<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('user.show', compact('user'));
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }
}
