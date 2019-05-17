<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->attempt([
            'email' => request()->email,
            'password' => request()->password,
        ], $remember)) {
            if (user()->deleted_at) {
                auth()->logout();
                return redirect()->route('home')->with('error', 'Désolé mec, c\'est terminé.');
            }

            return redirect()->route('home');
        } else {
            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            return redirect(route('login'))->withErrors($validator)->withInput($request->input());
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
