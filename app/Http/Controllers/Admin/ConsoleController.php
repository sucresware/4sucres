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
                $output .= '› ban <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';
                $output .= '› unban <span class="text-muted">{<i>User:</i> $id|$name}</span>' . '<br>';

                break;
            case 'ban':
                list($command, $user_id_or_name) = $args;
                $user = User::notTrashed()->find($user_id_or_name);
                if (!$user) {
                    $user = User::notTrashed()->where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁.';

                    break;
                }

                $user->deleted_at = now();
                $user->save();

                $output .= 'User "' . $user_id_or_name . '" banned ✅.';

                break;
            case 'unban':
                list($command, $user_id_or_name) = $args;
                $user = User::find($user_id_or_name);
                if (!$user) {
                    $user = User::where('name', $user_id_or_name)->first();
                }
                if (!$user) {
                    $output .= 'User "' . $user_id_or_name . '" not found 🙁.';

                    break;
                }

                $user->deleted_at = null;
                $user->save();

                $output .= 'User "' . $user_id_or_name . '" unbanned ✅.';

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
