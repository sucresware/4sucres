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

            if (
                $request->cookie('guest_theme') != user()->getSetting('layout.theme', 'light-theme') &&
                in_array($request->cookie('guest_theme'), ['light-theme', 'dark-theme']) &&
                in_array(user()->getSetting('layout.theme', 'light-theme'), ['light-theme', 'dark-theme'])
            ) {
                $theme = $request->cookie('guest_theme', user()->getSetting('layout.theme', 'light-theme'));
                user()->setSetting('layout.theme', $theme);
            }

            // Refresh the api_token if it is expired
            try {
                $client = new \GuzzleHttp\Client(['verify' => false]);
                $res = $client->request('GET', env('APP_URL') . '/api/v1/@me', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . user()->api_token,
                    ]
                ]);

                $json_response = json_decode((string) $res->getBody());
                $user_id = $json_response->id;
            } catch (\Throwable $e) {
                user()->api_token = user()->createToken('personal')->accessToken;
                user()->save();
            }

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
        if (in_array(user()->getSetting('layout.theme', 'light-theme'), ['light-theme', 'dark-theme'])) {
            $theme = user()->getSetting('layout.theme');
        }

        auth()->logout();

        if (isset($theme)) {
            return redirect()->route('home')->cookie('guest_theme', $theme, 43800, null, null, false, false);
        }

        return redirect()->route('home');
    }
}
