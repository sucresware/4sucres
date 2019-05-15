<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function profile()
    {
        $user = user();

        return redirect($user->link);
    }

    public function settings()
    {
        $user = user();

        return view('user.settings', compact('user'));
    }

    public function saveSettings()
    {
        $user = user();

        $user->setMultipleSettings([
            'layout.sidebar.right' => request()->input('layout_sidebar_right', false),
            'layout.stickers.inline' => request()->input('layout_stickers_inline', false),
        ]);

        return redirect(route('user.settings'))->with('success', 'C\'est enregistré !');
    }

    public function show($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        return view('user.show', compact('user'));
    }

    public function edit($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && !user()->can('bypass users guard')) {
            return abort(403);
        }

        $achievements = user()->can('update achievements') ? Achievement::pluck('name', 'id') : [];
        $roles = user()->can('update roles') ? Role::pluck('name', 'id') : [];

        return view('user.edit', compact('user', 'achievements', 'roles'));
    }

    public function update($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && !user()->can('bypass users guard')) {
            return abort(403);
        }

        request()->validate([
            'display_name' => ['required', 'string', 'max:255', 'min:4'],
            'shown_role' => ['string', 'max:255'],
            'avatar' => ['image', 'max:2048'],
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

        return redirect($user->link);
    }
}
