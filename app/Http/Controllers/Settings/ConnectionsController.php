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

    public function redirectToDiscord()
    {
        return Socialite::with('discord')->redirect();
    }

    public function handleDiscordCallback()
    {
        try {
            $discord_user = Socialite::driver('discord')->user();
        } catch (\Exception $e) {
            return redirect(route('user.settings.connections.index'))->with('error', 'Oupsi ! Impossible de connecter ton compte Discord pour le moment.');
        }

        $discord = new DiscordClient(['token' => config('services.discord.client_id')]); // Token is required

        var_dump($discord->guild->guilds(['guild.id' => 81384788765712384]));

        dd($discord_user);
    }
}
