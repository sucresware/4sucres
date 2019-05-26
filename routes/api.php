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

        $guild = DiscordGuild::updateOrCreate(['id'=> request()->id], [
            'icon' => request()->icon,
            'name' => request()->name,
        ]);

        $guild->users()->attach(request()->user());

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
