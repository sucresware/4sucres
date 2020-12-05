<?php

namespace App\Http\Controllers\Next\Auth;

use App\Http\Controllers\Controller;
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
            'email' => ['required', 'email'],
            'password' => 'required',
            'g-recaptcha-response' => [...(config('app.env') == 'production') ? ['required', 'captcha'] : []],
        ]);

        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->once($request->only(['email', 'password']), $remember) && ! user()->deleted_at) {
            if (user()->isBanned()) {
                $error = 'Ton compte est banni';
                $latest_ban = user()->bans->first();

                if ($latest_ban) {
                    ($latest_ban->isPermanent()) ? $error .= ' définitivement' : 'jusqu\'au ' . $latest_ban->expired_at->format('d/m/Y à H:i');
                    ($latest_ban->comment) ? $error .= ' (' . $latest_ban->comment . ').' : '.';
                    $validator->errors()->add('password', $error);
                }

                auth()->logout();

                return response(['errors' => $validator->errors()], 422);
            }

            if (user()->getSetting('google_2fa.enabled', false)) {
                $validator = validator()->make($request->input(), ['totp' => 'required']);
                $validator->validate();

                $google2fa = app('pragmarx.google2fa');

                if (! $google2fa->verifyKey(decrypt(user()->getSetting('google_2fa.secret')), $request->totp)) {
                    $validator->errors()->add('totp', 'Le code OTP est incorrect.');

                    // LOG: Login 2FA failed

                    return response(['errors' => $validator->errors()], 422);
                }
            }

            auth()->loginUsingId(user()->id);

            // LOG: Login successful

            return response()->json(['intended_url' => session()->pull('url.intended', route('home'))]);
        } else {
            auth()->logout();

            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            // LOG: Login failed

            return response(['errors' => $validator->errors()], 422);
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('next.home');
    }
}
