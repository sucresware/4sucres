<?php

use App\Models\DiscordEmoji;
use App\Models\DiscordGuild;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::get('/user', function () {
        return request()->user();
    });

    Route::post('/discord-guilds', function () {
        request()->validate([
            'id'   => ['required', 'integer'],
            'icon' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $guild = new DiscordGuild([
            'id'   => request()->id,
            'icon' => request()->icon,
            'name' => request()->name,
        ]);

        try {
            // Vérification de l'existance de la PP du serveur
            file_get_contents($guild->icon_link);
        } catch (\Exception $e) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'        => 'warning',
                    'method'       => __METHOD__,
                    'request'      => request()->all(),
                    'attributes'   => array_merge($guild->toArray(), ['link' => $guild->link]),
                ])
                ->log('DiscordGuildNotFound');

            abort(404);
        }

        $guild = DiscordGuild::updateOrCreate(['id'=> request()->id], [
            'icon' => request()->icon,
            'name' => request()->name,
        ]);

        $guild->users()->syncWithoutDetaching(request()->user());

        return [
            'success' => true,
        ];
    });

    Route::post('/discord-emojis', function () {
        request()->validate([
            'id'             => ['required', 'integer'],
            'guild_id'       => ['required', 'integer', 'exists:discord_guilds,id'],
            'name'           => ['required', 'string', 'max:255'],
            'animated'       => ['required', 'boolean'],
            'deleted'        => ['required', 'boolean'],
        ]);

        $emoji = new DiscordEmoji([
            'id'                => request()->id,
            'name'              => request()->name,
            'animated'          => request()->animated,
            'deleted'           => request()->deleted,
            'discord_guild_id'  => request()->guild_id,
        ]);

        try {
            // Vérification de l'existance de l'emoji
            file_get_contents($emoji->link);
        } catch (\Exception $e) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'        => 'warning',
                    'method'       => __METHOD__,
                    'request'      => request()->all(),
                    'attributes'   => array_merge($emoji->toArray(), ['link' => $emoji->link]),
                ])
                ->log('DiscordEmojiNotFound');

            abort(404);
        }

        $emoji = DiscordEmoji::updateOrCreate(['id'=> request()->id], [
            'name'              => request()->name,
            'animated'          => request()->animated,
            'deleted'           => request()->deleted,
            'discord_guild_id'  => request()->guild_id,
        ]);

        return [
            'success' => true,
        ];
    });
});
