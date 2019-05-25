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
        return Socialite::with('discord')
            ->setScopes([
                'guilds',
            ])
            ->redirect();
    }

    public function handleDiscordCallback()
    {
        try {
            $discord_user = Socialite::driver('discord')->user();
        } catch (\Exception $e) {
            return redirect(route('user.settings.connections.index'))->with('error', 'Oupsi ! Impossible de connecter ton compte Discord pour le moment.');
        }

        $discord = new DiscordClient([
            'tokenType' => 'OAuth',
            'token'     => $discord_user->token,
        ]);

        dump($discord_user);

        $user = $discord->user->getCurrentUser();
        $guilds = $discord->user->getCurrentUserGuilds();

        dump($user);
        dump($guilds);

        $user_emojis = [];
        foreach ($guilds as $guild) {
            $emojis = $discord->emoji->listGuildEmojis(['guild.id' => $guild->id]);
            dump($emojis);
            $user_emojis[] = $emojis;
        }
    }
}
