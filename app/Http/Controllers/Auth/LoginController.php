<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Throttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'email'                => ['required', 'email', new Throttle(__METHOD__, 3, 1)],
            'password'             => 'required',
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);
        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->attempt([
            'email' => request()->email,
            'password' => request()->password,
        ], $remember) && !user()->deleted_at) {
            if (user()->isBanned()) {
                $error = 'Le compte est banni ';
                $latest_ban = user()->bans->first();

                if ($latest_ban) {
                    ($latest_ban->isPermanent()) ? $error .= 'définitivement' : 'jusqu\'au ' . $latest_ban->expired_at->format('d/m/Y à H:i');
                    ($latest_ban->comment) ? $error .= ' (' . $latest_ban->comment . ').' : '.';
                    $validator->errors()->add('password', $error);
                }

                auth()->logout();

                return redirect(route('login'))->withErrors($validator)->withInput($request->input());
            }

            activity()
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'info',
                    'method' => __METHOD__,
                ])
                ->log('LoginSuccessful');

            return redirect()->intended();
        } else {
            auth()->logout();

            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            activity()
                ->withProperties([
                    'level'    => 'warning',
                    'method'   => __METHOD__,
                    'email'    => request()->email,
                ])
                ->log('LoginFailed');

            return redirect(route('login'))->withErrors($validator)->withInput($request->input());
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
