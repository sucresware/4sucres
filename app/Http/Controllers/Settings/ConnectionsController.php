<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use RestCord\DiscordClient;

class ConnectionsController extends Controller
{
    public function index()
    {
        $user = user();

        return view('user.settings.connections.index', compact('user'));
    }
}
