<?php

namespace App\Http\Controllers\Next;

use App\Helpers\SucresHelper;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Notifications\UnlockedAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserSettingsController extends Controller
{
    public function profile()
    {
        $user = user()->only([
            'display_name',
            'bio',
        ]);

        return inertia('settings/profile', compact('user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([]);

        return redirect()->route('next.settings.profile')
            ->with('success', 'Profil mis à jour !');
    }

    public function account()
    {
        $user = user()->only([
            'email',
        ]);

        return inertia('settings/account', compact('user'));
    }

    public function submitAccount(Request $request)
    {
        $request->validate([]);
    }

    public function security()
    {
        return inertia('settings/security');
    }

    public function submitSecurity(Request $request)
    {
        $request->validate([]);
    }

    public function notifications()
    {
        return inertia('settings/notifications');
    }

    public function submitNotifications(Request $request)
    {
        $request->validate([]);
    }

    public function design()
    {
        return inertia('settings/design');
    }

    public function submitDesign(Request $request)
    {
        $request->validate([]);
    }

    public function LEGACYaccountEmail()
    {
        $user = user();

        return view('user.settings.account.email', compact('user'));
    }

    public function LEGACYaccountPassword()
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

        return view('user.settings.account.password', compact('user', 'google_2fa'));
    }

    public function LEGACYlayout()
    {
        $user = user();

        return view('user.settings.layout', compact('user'));
    }

    public function LEGACYnotifications()
    {
        $user = user();

        return view('user.settings.notifications', compact('user'));
    }

    public function LEGACYupdateProfile($name = null)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && ! user()->can('bypass users guard')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                    'request' => request()->all(),
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        request()->validate([
            'display_name' => ['required', 'string', 'alpha_dash', 'max:35', 'min:4'],
            'shown_role' => ['string', 'max:255'],
            'avatar' => ['image', 'max:2048'],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 10, 10);

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

            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties([
                    'level' => 'notice',
                    'method' => __METHOD__,
                    'attributes' => [
                        'avatar' => $avatar_name,
                    ],
                ])
                ->log('UserAvatarUpdated');
        }

        $user->display_name = request()->display_name;

        if (user()->can('update shown_role')) {
            $old_shown_role = $user->shown_role;
            $user->shown_role = request()->shown_role;

            if ($user->shown_role != $old_shown_role) {
                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level' => 'warning',
                        'method' => __METHOD__,
                        'attributes' => [
                            'shown_role' => request()->shown_role,
                        ],
                        'old' => [
                            'shown_role' => $old_shown_role,
                        ],
                    ])
                    ->log('UserShownRoleUpdated');
            }
        }

        if (user()->can('update achievements')) {
            $sync = $user->achievements()->sync(request()->achievements);

            if (count($sync['attached']) || count($sync['detached']) || count($sync['updated'])) {
                foreach ($sync['attached'] as $achievement_id) {
                    $achievement = Achievement::find($achievement_id);
                    $class = '\App\Achievements\Achievements\\' . $achievement->code;
                    $user->notify(new UnlockedAchievement(new $class()));
                }

                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level' => 'alert',
                        'method' => __METHOD__,
                        'elevated' => true,
                        'request' => request()->all(),
                        'sync' => $sync,
                    ])
                    ->log('UserAchievementsUpdated');
            }
        }

        if (user()->can('update roles')) {
            $sync = $user->roles()->sync(request()->role);

            if (count($sync['attached']) || count($sync['detached']) || count($sync['updated'])) {
                activity()
                    ->performedOn($user)
                    ->causedBy(user())
                    ->withProperties([
                        'level' => 'critical',
                        'method' => __METHOD__,
                        'elevated' => true,
                        'request' => request()->all(),
                        'sync' => $sync,
                    ])
                    ->log('UserRolesUpdated');
            }
        }

        $user->save();

        return redirect(route('user.settings.profile', $user->name))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYupdateLayout()
    {
        $user = user();

        request()->validate([
            'sidebar' => [Rule::in(['left', 'right'])],
            'stickers' => [Rule::in(['default', 'inline'])],
            'theme' => [Rule::in(['light-theme', 'dark-theme', 'onche-light-theme', 'avn-light-theme', 'synth-theme', 'sensory-theme'])],
        ]);

        $user->setMultipleSettings([
            'layout.sidebar' => request()->input('sidebar', 'left'),
            'layout.stickers' => request()->input('stickers', 'default'),
            'layout.theme' => request()->input('theme', 'light-theme'),
            'layout.compact' => (bool) request()->input('layout_compact', false),
        ]);

        return redirect(route('user.settings.layout'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYupdateNotifications()
    {
        $user = user();

        $user->setMultipleSettings([
            'notifications.subscribe_on_create' => (bool) request()->input('subscribe_on_create', false),
            'notifications.subscribe_on_reply' => (bool) request()->input('subscribe_on_reply', false),
            'notifications.on_subscribed_threads' => (bool) request()->input('notification_on_subscribed_threads', false),
            'notifications.on_new_private_message' => (bool) request()->input('notification_on_new_private_message', false),
            'notifications.when_mentionned_or_quoted' => (bool) request()->input('notification_when_mentionned_or_quoted', false),
            'webpush.enabled' => (bool) request()->input('optin_webpush', false),
            'webpush.idle_wait' => request()->input('idle_wait', 1),
        ]);

        return redirect(route('user.settings.notifications'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYupdateNotificationsPushbullet()
    {
        $user = user();

        $optin_pushbullet = (bool) request()->input('optin_pushbullet', false);
        $email = request()->input('email', '');

        if ($optin_pushbullet) {
            request()->validate(['email' => 'required']);
        }

        $user->setMultipleSettings([
            'services.pushbullet.enabled' => $optin_pushbullet,
            'services.pushbullet.email' => $email,
        ]);

        return redirect(route('user.settings.notifications'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYnotificationsPushbulletTest()
    {
        $user = user();

        $user->notify(new TestNotification());

        return redirect(route('user.settings.notifications'))->with('success', 'Notification envoyée !');
    }

    public function LEGACYupdateAccountEmail()
    {
        $user = user();

        request()->validate([
            'email' => ['required', 'string', 'email', 'not_throw_away', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 1, 10);

        $user->email = request()->email;
        $user->save();

        return redirect(route('user.settings.account.email'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYupdateAccountPassword()
    {
        $user = user();

        $validator = Validator::make(request()->input(), [
            'password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $validator->validate();

        SucresHelper::throttleOrFail(__METHOD__, 1, 10);

        if (! Hash::check(request()->password, $user->password)) {
            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            return redirect(route('user.settings.account.password'))->withErrors($validator)->withInput(request()->input());
        }

        $user->password = Hash::make(request()->new_password);
        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level' => 'warning',
                'method' => __METHOD__,
            ])
            ->log('PasswordChanged#Account');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYenableAccount2FA()
    {
        $user = user();

        $google2fa = app('pragmarx.google2fa');

        $user->setMultipleSettings([
            'google_2fa.enabled' => true,
            'google_2fa.secret' => encrypt($google2fa->generateSecretKey()),
        ]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level' => 'warning',
                'method' => __METHOD__,
            ])
            ->log('2FAEnabled');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYdisableAccount2FA()
    {
        $user = user();

        $user->setMultipleSettings([
            'google_2fa.enabled' => false,
            'google_2fa.secret' => null,
        ]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level' => 'warning',
                'method' => __METHOD__,
            ])
            ->log('2FADisabled');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }

    public function LEGACYupdateAccount2FA()
    {
        $user = user();

        // $validator = Validator::make(request()->input(), [
        //     'password'     => ['required'],
        //     'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        // ]);
        // $validator->validate();

        // SucresHelper::throttleOrFail(__METHOD__, 1, 10);

        // if (!Hash::check(request()->password, $user->password)) {
        //     $validator->errors()->add('password', 'Le mot de passe est incorrect');

        //     return redirect(route('user.settings.account.password'))->withErrors($validator)->withInput(request()->input());
        // }

        // $user->password = Hash::make(request()->new_password);
        // $user->save();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level' => 'warning',
                'method' => __METHOD__,
            ])
            ->log('2FAUpdated');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }
}
