<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\Achievement;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    protected function submit()
    {
        $min_date = now()->subYears(13);
        $max_date = now()->setYear(1900);

        request()->validate([
            'name'                 => ['required', 'string', 'alpha_dash', 'max:255', 'min:4', 'unique:users'],
            'email'                => ['required', 'string', 'email', 'not_throw_away', 'max:255', 'unique:users'],
            'password'             => ['required', 'string', 'min:6'],
            'dob'                  => ['required', 'date', 'before:' . $min_date, 'after:' . $max_date],
            'gender'               => ['required', 'in:M,F'],
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'gender.in'            => 'Désolé, pas de sucres non genrés ici. Tu peux trouver ta place sur <a href="http://www.madmoizelle.com/">mademoiZelle.com</a>',
            'dob.before'           => 'Tu dois avoir plus de 13 ans pour t\'inscrire ici.',
            'dob.after'            => 'WTF l\'ancien !? T\'es né avant 1900?',
            'email.not_throw_away' => 'Un problème avec l\'adresse e-mail?',
        ]);

        $user = User::create([
            'name'         => request()->name,
            'display_name' => request()->name,
            'shown_role'   => (request()->gender == 'M') ? 'Sucros' : 'Sucrette',
            'email'        => request()->email,
            'password'     => Hash::make(request()->password),
            'gender'       => request()->gender,
            'dob'          => request()->dob,
        ]);
        $user->assignRole('user');

        switch (request()->referrer) {
            case 'none.none':
                $user->achievements()->attach(Achievement::where('name', 'Esprit libre')->first());

                break;
            case 'avenoel.org':
                $user->achievements()->attach(Achievement::where('name', 'Noëliste')->first());

                break;
            case 'jeuxvideo.com':
                $user->achievements()->attach(Achievement::where('name', 'ISSOU !')->first());

                break;
            case '2sucres.org':
                $user->achievements()->attach(Achievement::where('name', 'Ça fait 6 sucres')->first());

                break;
            case 'lebunker.net':
                $user->achievements()->attach(Achievement::where('name', 'Bunkered')->first());

                break;
            case 'onche.party':
                $user->achievements()->attach(Achievement::where('name', 'Tu veux du ponche ?')->first());

                break;
        }

        activity()
            ->performedOn($user)
            ->withProperties(['level' => 'info'])
            ->log('Nouvelle inscription');

        $verify_user = VerifyUser::create([
            'user_id' => $user->id,
            'token'   => str_random(40),
            'scope'   => VerifyUser::SCOPE_VERIFY_EMAIL,
        ]);

        Mail::to($user)->send(new VerifyEmail($user, $verify_user->token));
        Auth::login($user);
        Cache::forget('api_plucked_users');

        return redirect()->route('home')
            ->with('swal-success', 'Ton compte a bien été créé ! Bienvenue sur 4sucres.org');
    }

    public function verify($token)
    {
        $verify_user = VerifyUser::where('token', $token)->firstOrFail();
        $user = $verify_user->user;

        $user->email_verified_at = now();
        $user->save();

        auth()->login($user);

        $verify_user->delete();

        return redirect()->route('home')
            ->with('swal-success', 'Bienvenue à bord ' . $user->name . ' !');
    }
}
