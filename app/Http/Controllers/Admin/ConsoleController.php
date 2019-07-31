<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Csv\Writer;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;
use Spatie\Activitylog\Models\Activity;

class ConsoleController extends Controller
{
    public function index()
    {
        return view('admin.console.index');
    }

    public function run($command)
    {
        $args = explode(' ', e(trim($command)));
        $output = '';

        switch ($args[0]) {
            case 'help':
                $output .= '<b>4𝙨𝙪𝙘𝙧𝙚𝙨/𝙩𝙚𝙧𝙢𝙞𝙣𝙖𝙡 😎</b>' . '<br>';
                $output .= 'Welcome ' . user()->name . '<br>';
                $output .= '<br>';
                $output .= 'Available commands:' . '<br>';
                $output .= '- userinfo <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';
                $output .= '- ban <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';
                $output .= '- banip <span class="text-muted">{$ip_address}</span>' . '<br>';
                $output .= '- unban <span class="text-muted">{<i>User:</i> $id|$name}</span><br>';
                $output .= '- unbanip <span class="text-muted">{$ip_address}</span><br>';
                $output .= '- export <span class="text-muted">{<i>User:</i> $id|$name}</span>';

                break;
            case 'userinfo':
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $output .= '<span class="text-muted">id: </span> ' . $user->id . '<br>';
                $output .= '<span class="text-muted">name: </span> ' . $user->name . '<br>';
                $output .= '<span class="text-muted">display_name: </span> ' . $user->display_name . '<br>';
                $output .= '<span class="text-muted">shown_role: </span> ' . $user->shown_role . '<br>';
                $output .= '<span class="text-muted">email: </span> ' . $user->email . '<br>';
                $output .= '<span class="text-muted">gender: </span> ' . $user->gender . '<br>';
                $output .= '<span class="text-muted">dob: </span> ' . $user->dob . '<br>';
                $output .= '<span class="text-muted">email_verified_at: </span> ' . $user->email_verified_at . '<br>';
                $output .= '<span class="text-muted">last_activity: </span> ' . $user->last_activity . '<br>';
                $output .= '<span class="text-muted">created_at: </span> ' . $user->created_at . '<br>';
                $output .= '<span class="text-muted">updated_at: </span> ' . $user->updated_at . '<br>';
                $output .= '<span class="text-muted">deleted_at: </span> ' . $user->deleted_at . '<br>';
                $output .= '<span class="text-muted">ip(s): </span><br>';
                Activity::query()
                    ->select(DB::raw('count(*) as count'), 'properties->ip as ip')
                    ->causedBy($user)
                    ->groupBy('ip')
                    ->orderBy('count', 'DESC')
                    ->each(function ($row) use (&$output) {
                        if ($row->ip) {
                            $output .= '&nbsp;&nbsp;' . $row->ip . ' <span class="text-muted">(' . $row->count . ')</span><br>';
                        }
                    });
                $output .= '<span class="text-muted">ua(s): </span><br>';

                Activity::query()
                    ->select(DB::raw('count(*) as count'), 'properties->ua as ua')
                    ->causedBy($user)
                    ->groupBy('ua')
                    ->orderBy('count', 'DESC')
                    ->each(function ($row) use (&$output) {
                        if ($row->ua) {
                            $output .= '&nbsp;&nbsp;' . $row->ua . ' <span class="text-muted">(' . $row->count . ')</span><br>';
                        }
                    });

                break;
            case 'ban':
                list($command, $user_id_or_name) = $args;
                $user = User::notTrashed()->find($user_id_or_name);
                if (!$user) {
                    $user = User::notTrashed()->where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $user->deleted_at = now();
                $user->save();

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserSoftDeleted');

                $output .= 'User "' . $user_id_or_name . '" banned ✅';

                break;
            case 'export':
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $uuid = Str::uuid();
                $path = storage_path('app/temp/' . $uuid);
                File::makeDirectory($path, 0755, true, true);

                $a_user = $user->makeVisible([
                    'email', 'gender', 'dob', 'email_verified_at', 'avatar',
                ])->toArray();

                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($a_user));
                $csv->insertOne($a_user);
                File::put($path . '/user.csv', $csv->getContent());

                $activity = Activity::causedBy($user)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($activity[0]));
                $csv->insertAll($activity);
                File::put($path . '/activity_caused_by.csv', $csv->getContent());

                $activity = Activity::forSubject($user)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($activity[0]));
                $csv->insertAll($activity);
                File::put($path . '/activity_for_subject.csv', $csv->getContent());

                $discussions = Discussion::where('user_id', $user->id)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($discussions[0]));
                $csv->insertAll($discussions);
                File::put($path . '/discussions.csv', $csv->getContent());

                $posts = Post::where('user_id', $user->id)->get()->makeHidden(['presented_body', 'presented_date'])->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($posts[0]));
                $csv->insertAll($posts);
                File::put($path . '/posts.csv', $csv->getContent());

                $zip_path = storage_path('app/public/exports/' . $uuid . '.zip');
                (new \Chumper\Zipper\Zipper())->make($zip_path)->add($path)->close();
                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserExported');

                $url = url('storage/exports/' . $uuid . '.zip');
                $output .= '<a href="' . $url . '" target="_blank">' . $url . '</a><br>';
                $output .= 'User "' . $user_id_or_name . '" exported ✅';

                break;
            case 'unban':
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $user->deleted_at = null;
                $user->save();

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UnsoftDelted');

                $output .= 'User "' . $user_id_or_name . '" unbanned ✅';

                break;
                case 'banip':
            case 'unbanip':
            list($command, $ip_address) = $args;

            ($command == 'banip') ? Firewall::blacklist($ip_address, true) : Firewall::remove($ip_address);

            activity()
                ->causedBy(user())
                ->withProperties([
                    'level'      => 'error',
                    'method'     => __METHOD__,
                    'elevated'   => true,
                    'attributes' => [
                        'ip' => $ip_address,
                    ],
                ])
                ->log($command);

            $output .= 'Address "' . $ip_address . '" ' . ($command == 'banip' ? 'blacklisted' : 'removed from the blacklist') . ' ✅';

            break;
                default:
                $output .= 'Command "' . $args[0] . '" not found 🤔';

                break;
        }

        return [
            'output' => $output,
        ];
    }
}
