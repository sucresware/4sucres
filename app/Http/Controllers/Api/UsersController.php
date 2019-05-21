<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::notTrashed();

        if ($q = request()->input('query')) {
            $users = $users->where('name', 'like', $q . '%');
        }

        $users = $users->paginate(10);

        return response()->json($users);
    }

    public function all()
    {
        $users = Cache::rememberForever('api_plucked_users', function () {
            return User::notTrashed()->pluck('name');
        });

        return response()->json($users);
    }
}
