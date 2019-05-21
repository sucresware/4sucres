<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class UserSettingsController extends Controller
{
    public function index()
    {
        return redirect()->route('user.settings.profile');
    }

    public function profile($name = null)
    {
        if ($name) {
            $user = User::where('name', $name)->firstOrFail();
        } else {
            $user = user();
        }

        if ($user->id != user()->id && !user()->can('bypass users guard')) {
            return abort(403);
        }

        $achievements = user()->can('update achievements') ? Achievement::pluck('name', 'id') : [];
        $roles = user()->can('update roles') ? Role::pluck('name', 'id') : [];

        return view('user.settings.profile', compact('user', 'achievements', 'roles'));
    }

    public function accountEmail()
    {
        $user = user();

        return view('user.settings.account.email', compact('user'));
    }

    public function accountPassword()
    {
        $user = user();

        return view('user.settings.account.password', compact('user'));
    }

    public function layout()
    {
        $user = user();

        return view('user.settings.layout', compact('user'));
    }

    public function notifications()
    {
        $user = user();

        return view('user.settings.notifications', compact('user'));
    }

    public function updateProfile($name = null)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && !user()->can('bypass users guard')) {
            return abort(403);
        }

        request()->validate([
            'display_name' => ['required', 'string', 'max:255', 'min:4'],
            'shown_role'   => ['string', 'max:255'],
            'avatar'       => ['image', 'max:2048'],
        ]);

        if (request()->hasFile('avatar')) {
            $avatar_name = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

            $img = Image::make(request()->avatar)
                ->fit(300)
                ->save(storage_path('app/public/avatars/' . $avatar_name));
            $user->avatar = $avatar_name;
        }

        $user->display_name = request()->display_name;

        if (user()->can('update shown_role')) {
            $user->shown_role = request()->shown_role;
        }

        if (user()->can('update achievements')) {
            $user->achievements()->sync(request()->achievements);
        }

        if (user()->can('update roles')) {
            $user->roles()->sync(request()->role);
        }

        $user->save();

        return redirect(route('user.settings.profile', $user->name))->with('success', 'Modifications enregistrées !');
    }

    public function updateLayout()
    {
        $user = user();

        $user->setMultipleSettings([
            'layout.sidebar'  => request()->input('sidebar', 'left'),
            'layout.stickers' => request()->input('stickers', 'default'),
        ]);

        return redirect(route('user.settings.layout'))->with('success', 'Modifications enregistrées !');
    }

    public function updateNotifications()
    {
        $user = user();

        $user->setMultipleSettings([
            'webpush.enabled'   => (bool) request()->input('optin_webpush', 0),
            'webpush.idle_wait' => request()->input('idle_wait', 1),
        ]);

        return redirect(route('user.settings.notifications'))->with('success', 'Modifications enregistrées !');
    }

    public function updateAccountEmail()
    {
        $user = user();

        request()->validate([
            'email' => ['required', 'string', 'email', 'not_throw_away', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->email = request()->email;
        $user->save();

        activity()
            ->performedOn($user)
            ->withProperties(['level' => 'info'])
            ->log('Email modifié (paramètres)');

        return redirect(route('user.settings.account.email'))->with('success', 'Modifications enregistrées !');
    }

    public function updateAccountPassword()
    {
        $user = user();

        $validator = Validator::make(request()->input(), [
            'password'     => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $validator->validate();

        if (!Hash::check(request()->password, $user->password)) {
            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            return redirect(route('user.settings.account.password'))->withErrors($validator)->withInput(request()->input());
        }

        $user->password = Hash::make(request()->new_password);
        $user->save();

        activity()
            ->performedOn($user)
            ->withProperties(['level' => 'info'])
            ->log('Mot de passe modifié (paramètres)');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }
}
