<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    protected function submit()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255', 'min:4', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('register_action')],
        ]);

        $user = User::create([
            'name' => request()->name,
            'display_name' => request()->name,
            'shown_role' => 'Sucrette',
            'email' => request()->email,
            'password' => Hash::make(request()->password),
        ]);
        $user->assignRole('user');

        $verify_user = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40),
        ]);

        Mail::to($user)->send(new VerifyEmail($user));

        return redirect()->route('home')
            ->with('success', 'Ton compte a bien été créé le sucre ! Tu dois valider ton adresse e-mail pour finaliser ton inscription !');
    }

    public function verify($token)
    {
        $verify_user = VerifyUser::where('token', $token)->firstOrFail();
        $user = $verify_user->user;

        $user->email_verified_at = now();
        $user->save();

        auth()->login($user);

        return redirect()->route('home')
            ->with('success', 'Bienvenue à bord ' . $user->name . ' !');
    }
}
