<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

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
                $output .= '- unban <span class="text-muted">{<i>User:</i> $id|$name}</span>';
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
            default:
                $output .= 'Command "' . $args[0] . '" not found 🤔';

                break;
        }

        return [
            'output' => $output,
        ];
    }
}
