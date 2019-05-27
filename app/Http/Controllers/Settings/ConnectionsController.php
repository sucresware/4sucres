<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class ConnectionsController extends Controller
{
    public function index()
    {
        $user = user();

        return view('user.settings.connections.index', compact('user'));
    }

    public function regenToken()
    {
        $user = user();

        $user->api_token = str_random(60);

        $user->save();

        return redirect(route('user.settings.connections.index'))->with('success', 'Token régénéré !');
    }
}
