<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        $verify_user = VerifyUser::where('token', $token)->firstOrFail();

        return view('auth.passwords.reset', compact('token'));
    }

    public function reset($token)
    {
        $verify_user = VerifyUser::where('token', $token)->firstOrFail();
        $user = $verify_user->user;

        request()->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->password = Hash::make(request()->password);
        $user->save();

        Auth::login($user);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level' => 'warning',
                'method' => __METHOD__,
            ])
            ->log('PasswordChanged#Email');

        return redirect()->route('home')
            ->with('swal-success', 'Mot de passe modifié, bon retour !');
    }
}
