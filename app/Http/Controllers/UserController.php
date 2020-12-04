<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function profile()
    {
        $user = user();

        return redirect($user->link);
    }

    public function show($nameOrId)
    {
        $user = User::where('name', $nameOrId)->first();

        if (! $user) {
            $user = User::findOrFail($nameOrId);
        }

        if ($user->deleted_at) {
            return abort(410);
        }

        return view('user.show', compact('user'));
    }

    public function edit($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if ($user->id != user()->id && ! user()->can('bypass users guard')) {
            return abort(403);
        }

        $achievements = user()->can('update achievements') ? Achievement::pluck('name', 'id') : [];
        $roles = user()->can('update roles') ? Role::pluck('name', 'id') : [];

        return view('user.edit', compact('user', 'achievements', 'roles'));
    }

    public function delete($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if (user()->cannot('delete users')) {
            activity()
                ->performedOn($user)
                ->withProperties(['level' => 'warning'])
                ->log('Tentative de suppression d\'utilisateur refusée (GET)');

            return abort(403);
        }

        return view('user.delete', compact('user'));
    }

    public function destroy($name)
    {
        $user = User::where('name', $name)->firstOrFail();

        if (user()->cannot('delete users')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        $user->deleted_at = now();
        $user->save();

        activity()
            ->performedOn($user)
            ->causedBy(user())
            ->withProperties([
                'level' => 'error',
                'method' => __METHOD__,
                'elevated' => true,
            ])
            ->log('UserSoftDeleted');

        return redirect()->route('home');
    }
}
