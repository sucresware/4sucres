<?php

namespace App\Http\Controllers\Next\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Throttle;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return inertia('auth/login');
    }

    public function submit(Request $request)
    {
        $validator = validator()->make($request->input(), [
            'email' => ['required', 'email', new Throttle(__METHOD__, 3, 1)],
            'password' => 'required',
            'g-recaptcha-response' => [...(config('app.env') == 'production') ? ['required', 'captcha'] : []],
        ]);

        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->attempt($request->only(['email', 'password']), $remember) && ! user()->deleted_at) {
            if (user()->isBanned()) {
                $error = 'Ton compte est banni';
                $latest_ban = user()->bans->first();

                if ($latest_ban) {
                    ($latest_ban->isPermanent()) ? $error .= ' définitivement' : 'jusqu\'au ' . $latest_ban->expired_at->format('d/m/Y à H:i');
                    ($latest_ban->comment) ? $error .= ' (' . $latest_ban->comment . ').' : '.';
                    $validator->errors()->add('password', $error);
                }

                auth()->logout();

                return redirect(route('next.login'))->withErrors($validator)->withInput($request->input());
            }

            // LOG: Login successful

            if (
                $request->cookie('guest_theme') != user()->getSetting('layout.theme', 'light-theme') &&
                in_array($request->cookie('guest_theme'), ['light-theme', 'dark-theme']) &&
                in_array(user()->getSetting('layout.theme', 'light-theme'), ['light-theme', 'dark-theme'])
            ) {
                $theme = $request->cookie('guest_theme', user()->getSetting('layout.theme', 'light-theme'));
                user()->setSetting('layout.theme', $theme);
            }

            return redirect()->intended();
        } else {
            auth()->logout();

            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            // LOG: Login failed

            return redirect(route('next.login'))->withErrors($validator)->withInput($request->input());
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('next.home');
    }
}
