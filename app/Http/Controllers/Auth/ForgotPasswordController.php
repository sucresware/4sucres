<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use App\Models\VerifyUser;
use App\Rules\Throttle;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail()
    {
        request()->validate([
            'email'                => ['required', 'email', new Throttle(__METHOD__, 3, 1)],
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);

        $user = User::where('email', request()->email)->first();

        if ($user != null) {
            $verify_user = VerifyUser::create([
                'user_id' => $user->id,
                'token'   => str_random(40),
                'scope'   => VerifyUser::SCOPE_RESET_PASSWORD,
            ]);

            Mail::to($user)->send(new ResetPassword($user, $verify_user->token));

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties([
                    'level'  => 'info',
                    'method' => __METHOD__,
                ])
                ->log('PasswordRequest');
        }

        return redirect()->route('password.request')
            ->with('swal-success', 'Des instructions viennent de t\'être envoyées par email. Si t\'as rien reçu dans 10 minutes, vérifies dans tes spams');
    }
}
