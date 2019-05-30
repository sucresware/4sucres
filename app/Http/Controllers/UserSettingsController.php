<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Achievement;
use App\Models\User;
use App\Notifications\UnlockedAchievement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;
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
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'        => 'warning',
                    'method'       => __METHOD__,
                    'request'      => request()->all(),
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        request()->validate([
            'display_name' => ['required', 'string', 'max:35', 'min:4'],
            'shown_role'   => ['string', 'max:255'],
            'avatar'       => ['image', 'max:2048'],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 10, 10);

        if (request()->hasFile('avatar')) {
            $avatar_name = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

            $imagine = (new Imagine())
                ->open(request()->avatar)
                ->thumbnail(new Box(300, 300), ImageInterface::THUMBNAIL_OUTBOUND);

            if (request()->avatar->getClientOriginalExtension() == 'gif' && user()->can('upload animated avatars')) {
                $imagine->save(storage_path('app/public/avatars/' . $avatar_name), [
                    'animated' => true,
                ]);
            } else {
                $imagine->save(storage_path('app/public/avatars/' . $avatar_name));
            }

            $user->avatar = $avatar_name;

            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'      => 'notice',
                    'method'     => __METHOD__,
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
                    'level'      => 'warning',
                    'method'     => __METHOD__,
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
                    'level'        => 'alert',
                    'method'       => __METHOD__,
                    'elevated'     => true,
                    'request'      => request()->all(),
                    'sync'         => $sync,
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
                    'level'      => 'critical',
                    'method'     => __METHOD__,
                    'elevated'   => true,
                    'request'    => request()->all(),
                    'sync'       => $sync,
                ])
                ->log('UserRolesUpdated');
            }
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
            'layout.theme'    => request()->input('theme', 'light'),
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

        SucresHelper::throttleOrFail(__METHOD__, 1, 10);

        $user->email = request()->email;
        $user->save();

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

        SucresHelper::throttleOrFail(__METHOD__, 1, 10);

        if (!Hash::check(request()->password, $user->password)) {
            $validator->errors()->add('password', 'Le mot de passe est incorrect');

            return redirect(route('user.settings.account.password'))->withErrors($validator)->withInput(request()->input());
        }

        $user->password = Hash::make(request()->new_password);
        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'level'  => 'warning',
                'method' => __METHOD__,
            ])
            ->log('PasswordChanged#Account');

        return redirect(route('user.settings.account.password'))->with('success', 'Modifications enregistrées !');
    }
}
