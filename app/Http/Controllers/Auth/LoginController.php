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
        ]);
        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->attempt([
            'email' => request()->email,
            'password' => request()->password,
        ], $remember)) {
            // if (auth()->user()->email_verified_at == null) {
            //     auth()->logout();
            //     return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant de te connecter !');
            // }

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
