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
use ZipArchive;

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

        switch (Str::lower($args[0])) {
            case 'help':
                $output .= '<b>4𝙨𝙪𝙘𝙧𝙚𝙨/𝙩𝙚𝙧𝙢𝙞𝙣𝙖𝙡 😎</b>' . '<br>';
                $output .= 'Welcome ' . user()->name . '<br>';
                $output .= '<br>';
                $output .= 'Available commands:' . '<br>';
                $output .= '- user:info <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';
                $output .= '- user:ban <span class="text-muted">{<i>User:</i> $id|$name} {$comment}</span>' . '<br>';
                $output .= '- user:massdelete <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';
                $output .= '- user:tempban <span class="text-muted">{<i>User:</i> $id|$name} {$days} {$comment}</span>' . '<br>';
                $output .= '- user:warn <span class="text-muted">{<i>User:</i> $id|$name} {$comment}</span>' . '<br>';
                $output .= '- user:banip <span class="text-muted">{$ip_address}</span>' . '<br>';
                $output .= '- user:unban <span class="text-muted">{<i>User:</i> $id|$name}</span><br>';
                $output .= '- user:unbanip <span class="text-muted">{$ip_address}</span><br>';
                $output .= '- user:export <span class="text-muted">{<i>User:</i> $id|$name}</span><br>';
                $output .= '- discussion:restore <span class="text-muted">{<i>Discussion:</i> $id}</span>';

                break;
            case 'user:info':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name) = $args;

                $user = User::find($user_id_or_name);

                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }

                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $ips = Activity::query()
                    ->select(DB::raw('count(*) as count'), 'properties->ip as ip')
                    ->causedBy($user)
                    ->groupBy('ip')
                    ->orderBy('count', 'DESC')
                    ->get();

                $uas = Activity::query()
                    ->select(DB::raw('count(*) as count'), 'properties->ua as ua')
                    ->causedBy($user)
                    ->groupBy('ua')
                    ->orderBy('count', 'DESC')
                    ->get();

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

                $output .= '<span class="text-muted">raw ip(s): </span><br>';
                $ips->each(function ($row) use (&$output) {
                    if ($row->ip) {
                        $output .= '&nbsp;&nbsp;' . $row->ip . ' <span class="text-muted">(' . $row->count . ')</span><br>';
                    }
                });

                $output .= '<span class="text-muted">raw ua(s): </span><br>';
                $uas->each(function ($row) use (&$output) {
                    if ($row->ua) {
                        $output .= '&nbsp;&nbsp;' . $row->ua . ' <span class="text-muted">(' . $row->count . ')</span><br>';
                    }
                });

                // Reverse ip search
                $other_accounts = Activity::query()
                    ->select('causer_id')
                    ->where('causer_type', User::class)
                    ->where('causer_id', '!=', $user->id)
                    ->whereIn('properties->ip', [$ips->pluck('ip')])
                    ->groupBy('causer_id')
                    ->get();

                if ($other_accounts->count()) {
                    $output .= '<span class="text-muted">shared accounts: </span><br>';
                    $other_accounts->each(function ($row) use (&$output) {
                        $causer = User::find($row->causer_id);
                        if ($causer) {
                            $output .= '&nbsp;&nbsp;' . $causer->display_name . ' - @' . $causer->name . ' <span class="text-muted">(' . $causer->id . ')</span><br>';
                        }
                    });
                }

                break;
            case 'user:ban':
                if (count($args) != 3) {
                    if (count($args) > 3) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 3) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name, $comment) = $args;
                $user = User::notTrashed()->find($user_id_or_name);
                if (!$user) {
                    $user = User::notTrashed()->where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                } elseif ($user->isBanned()) {
                    $output .= 'User "' . $user_id_or_name . '" is already banned 🙁';

                    break;
                }

                $user->ban([
                    'comment' => str_replace('_', ' ', $comment),
                ]);

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserBanned');

                $output .= 'User "' . $user_id_or_name . '" banned ✅';

                break;
            case 'user:tempban':
                if (count($args) != 4) {
                    if (count($args) > 4) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 4) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name, $days, $comment) = $args;
                $user = User::notTrashed()->find($user_id_or_name);
                if (!$user) {
                    $user = User::notTrashed()->where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                } elseif ($user->isBanned()) {
                    $output .= 'User "' . $user_id_or_name . '" is already banned 🙁';

                    break;
                }

                $user->ban([
                    'expired_at' => '+' . $days . ' days',
                    'comment'    => str_replace('_', ' ', $comment),
                ]);

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserTempBanned');

                $output .= 'User "' . $user_id_or_name . '" banned for ' . $days . ' day(s) ✅';

                break;
            case 'user:warn':
                if (count($args) != 3) {
                    if (count($args) > 3) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 3) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name, $comment) = $args;
                $user = User::notTrashed()->find($user_id_or_name);
                if (!$user) {
                    $user = User::notTrashed()->where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $user->ban([
                    'expired_at' => now(),
                    'deleted_at' => now(),
                    'comment'    => str_replace('_', ' ', $comment),
                ]);

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserWarned');

                $user = $user->fresh();
                $user->banned_at = null;
                $user->save();

                $output .= 'User "' . $user_id_or_name . '" warned ✅';

                break;
            case 'user:export':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
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
                $zip_path = storage_path('app/public/exports/' . $uuid . '.zip');
                $zip = new ZipArchive();

                if (!$zip->open($zip_path, ZipArchive::CREATE)) {
                    $output .= 'Cannot create zip archive 🙁';

                    break;
                }

                $a_user = $user->makeVisible([
                    'email', 'gender', 'dob', 'email_verified_at', 'avatar',
                ])->toArray();

                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($a_user));
                $csv->insertOne($a_user);
                $zip->addFromString('user.csv', $csv->getContent());

                $activity = Activity::causedBy($user)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($activity[0]));
                $csv->insertAll($activity);
                $zip->addFromString('activity_caused_by.csv', $csv->getContent());

                $activity = Activity::forSubject($user)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($activity[0]));
                $csv->insertAll($activity);
                $zip->addFromString('activity_for_subject.csv', $csv->getContent());

                $discussions = Discussion::where('user_id', $user->id)->get()->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($discussions[0]));
                $csv->insertAll($discussions);
                $zip->addFromString('discussions.csv', $csv->getContent());

                $posts = Post::where('user_id', $user->id)->get()->makeHidden(['presented_body', 'presented_date'])->toArray();
                $csv = Writer::createFromString('');
                $csv->insertOne(array_keys($posts[0]));
                $csv->insertAll($posts);
                $zip->addFromString('posts.csv', $csv->getContent());

                $zip->close();

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
            case 'user:unban':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $user->unban();

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'    => 'error',
                        'method'   => __METHOD__,
                        'elevated' => true,
                    ])
                    ->log('UserUnbanned');

                $output .= 'User "' . $user_id_or_name . '" unbanned ✅';

                break;
            case 'user:banip':
            case 'user:unbanip':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $ip_address) = $args;

                ($command == 'user:banip') ? Firewall::blacklist($ip_address, true) : Firewall::remove($ip_address);

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

                $output .= 'Address "' . $ip_address . '" ' . ($command == 'user:banip' ? 'blacklisted' : 'removed from the blacklist') . ' ✅';

                break;
            case 'discussion:restore':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $discussion_id) = $args;

                $discussion = Discussion::find($discussion_id);

                if (!$discussion) {
                    $output .= 'Discussion "' . $discussion_id . '" not found 🙁';

                    break;
                }

                $discussion->posts()
                    ->where('deleted_at', $discussion->deleted_at)
                    ->update(['deleted_at' => null]);

                $discussion->deleted_at = null;
                $discussion->save();

                activity()
                    ->performedOn($discussion)
                    ->causedBy(user())
                    ->withProperties([
                        'level'      => 'error',
                        'method'     => __METHOD__,
                        'elevated'   => true,
                    ])
                    ->log('DiscussionRestored');

                $output .= 'Discussion "' . $discussion_id . '" restored ✅';

                break;
            case 'user:massdelete':
                if (count($args) != 2) {
                    if (count($args) > 2) {
                        $output .= 'Too many arguments 🙁';
                    } elseif (count($args) < 2) {
                        $output .= 'Not enough arguments 🙁';
                    }

                    break;
                }
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁';

                    break;
                }

                $discussions = $user->discussions()->whereNull('deleted_at')->get();
                $output .= $discussions->count() . ' discussions found.<br>';

                foreach ($discussions as $discussion) {
                    $output .= "\t Deleting discussion #" . $discussion->id . '.<br>';

                    $discussion->disableLogging();

                    $discussion
                        ->posts()
                        ->whereNull('deleted_at')
                        ->update(['deleted_at' => now()]);

                    $discussion->deleted_at = now();
                    $discussion->save();
                }

                $posts = $user->posts()->whereNull('deleted_at');
                $output .= $posts->count() . ' posts found.<br>';

                $posts->update([
                    'deleted_at' => now(),
                ]);

                $output .= 'Discussions and posts deleted ✅';

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level'      => 'error',
                        'method'     => __METHOD__,
                        'elevated'   => true,
                        'attributes' => [
                            'user'        => $user->getNameAttribute(),
                            'posts'       => $posts->count(),
                            'discussions' => $discussions->count(),
                        ],
                    ])
                    ->log('MassDelete');

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
