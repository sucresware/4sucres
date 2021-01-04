<?php

namespace App\Http\Controllers\Next;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserSettingsController extends Controller
{
    public function profile()
    {
        $user = user()->only([
            'display_name',
            'bio',
            'avatar_link',
        ]);

        return inertia('settings/profile', compact('user'));
    }

    public function submitProfile()
    {
        $user = user();

        request()->validate([
            'display_name' => ['required', 'string', 'alpha_dash', 'max:35', 'min:4'],
            'avatar' => ['image', 'max:2048'],
        ]);

        if (request()->hasFile('avatar')) {
            $avatar_name = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

            Image::make(request()->avatar)
                ->fit(300)
                ->save(storage_path('app/public/avatars/' . $avatar_name));

            // TODO: Réparer le resize des avatars animés !
            // if (request()->avatar->getClientOriginalExtension() == 'gif' && user()->can('upload animated avatars')) {
            //     $img->save(storage_path('app/public/avatars/' . $avatar_name), [
            //         'animated' => true,
            //     ]);
            // } else {
            //     $img->save(storage_path('app/public/avatars/' . $avatar_name));
            // }

            $user->avatar = $avatar_name;
        }

        $user->display_name = request()->display_name;
        $user->save();

        return redirect()->route('next.settings.profile')
            ->with('success', 'Modifications enregistrées !');
    }

    public function account()
    {
        $user = user()->only([
            'email',
        ]);

        return inertia('settings/account', compact('user'));
    }

    public function submitAccount()
    {
        $user = user();

        request()->validate([
            'email' => ['required', 'string', 'email', 'not_throw_away', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->email = request()->email;
        $user->save();

        return redirect()->route('next.settings.account')
            ->with('success', 'Modifications enregistrées !');
    }

    public function security()
    {
        $user = user();

        if ($user->getSetting('google_2fa.enabled', false)) {
            $google2fa = app('pragmarx.google2fa');

            $qr_image = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $google_2fa_secret = decrypt($user->getSetting('google_2fa.secret'))
            );

            $google_2fa = [
                'enabled' => $user->getSetting('google_2fa.enabled', false),
                'qr_image' => $qr_image,
                'secret' => $google_2fa_secret,
            ];
        } else {
            $google_2fa = [
                'enabled' => false,
            ];
        }

        return inertia('settings/security', compact('google_2fa'));
    }

    public function submitSecurity()
    {
        request()->validate([]);

        $validator = validator()->make(request()->input(), [
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $validator->validate();
        $user = user();

        if (! Hash::check(request()->current_password, $user->password)) {
            $validator->errors()->add('current_password', 'Le mot de passe est incorrect');

            return redirect(route('next.settings.security'))
                ->withErrors($validator)
                ->withInput(request()->input());
        }

        $user->password = Hash::make(request()->password);
        $user->save();

        return redirect()->route('next.settings.security')
            ->with('success', 'Modifications enregistrées !');
    }

    public function enable2FA()
    {
        $user = user();
        $google2fa = app('pragmarx.google2fa');

        $user->setMultipleSettings([
            'google_2fa.enabled' => true,
            'google_2fa.secret' => encrypt($google2fa->generateSecretKey()),
        ]);

        return redirect()->route('next.settings.security')
            ->with('success', 'Authentification à deux facteurs activée.');
    }

    public function disable2FA()
    {
        $user = user();

        $user->setMultipleSettings([
            'google_2fa.enabled' => false,
            'google_2fa.secret' => null,
        ]);

        return redirect()->route('next.settings.security')
            ->with('warning', 'Authentification à deux facteurs désactivée.');
    }

    public function notifications()
    {
        return inertia('settings/notifications');
    }

    public function submitNotifications()
    {
        request()->validate([]);

        return redirect()->route('next.settings.notifications')
            ->with('success', 'Modifications enregistrées !');
    }

    public function design()
    {
        return inertia('settings/design');
    }
}
