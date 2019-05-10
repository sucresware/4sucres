<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('user.show', compact('user'));
    }

    public function show(User $user, $name)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user, $name)
    {
        if (auth()->user()->can('update achievements')) {
            $achievements = Achievement::pluck('name', 'id');
        } else {
            $achievements = [];
        }

        if (auth()->user()->can('update roles')) {
            $roles = Role::pluck('name', 'id');
        } else {
            $roles = [];
        }

        return view('user.edit', compact('user', 'achievements', 'roles'));
    }

    public function update(User $user, $name)
    {
        request()->validate([
            'display_name' => ['required', 'string', 'max:255', 'min:4'],
            'shown_role' => ['string', 'max:255'],
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (request()->hasFile('avatar')) {
            $avatar_name = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

            $img = Image::make(request()->avatar)
                ->fit(300)
                ->save(storage_path('app/public/avatars/' . $avatar_name));
            $user->avatar = $avatar_name;
        }

        $user->display_name = request()->display_name;

        if (auth()->user()->can('update shown_role')) {
            $user->shown_role = request()->shown_role;
        }

        if (auth()->user()->can('update achievements')) {
            $user->achievements()->sync(request()->achievements);
        }

        if (auth()->user()->can('update roles')) {
            $user->roles()->sync(request()->role);
        }

        $user->save();

        return redirect()->route('user.show', [$user->id, $user->name]);
    }
}
