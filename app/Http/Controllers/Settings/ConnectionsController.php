<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ConnectionsController extends Controller
{
    public function index()
    {
        $user = user();

        return view('user.settings.connections.index', compact('user'));
    }

    public function redirectToDiscord()
    {
        return Socialite::with('discord')->redirect();
    }

    public function handleDiscordCallback()
    {
        $discord_user = Socialite::driver('discord')->user();

        dd($discord_user);
    }
}
