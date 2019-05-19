<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::enabled();

        if ($q = request()->input('query')) {
            $users = $users->where('name', 'like', $q . '%');
        }

        $users = $users->paginate(10);

        return response()->json($users);
    }

    public function all()
    {
        $users = User::enabled();

        return response()->json($users->pluck('name'));
    }
}
