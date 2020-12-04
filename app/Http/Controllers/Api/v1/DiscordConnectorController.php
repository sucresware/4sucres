<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\DiscordEmoji;
use App\Models\DiscordGuild;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class DiscordConnectorController extends Controller
{
    public function guilds()
    {
        if (! user('api')->can('sync discord emojis')) {
            abort(403);
        }

        request()->validate([
            'id' => ['required', 'integer'],
            'icon' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $guild = new DiscordGuild([
            'id' => request()->id,
            'icon' => request()->icon,
            'name' => request()->name,
        ]);

        try {
            file_get_contents($guild->icon_link);
        } catch (\Exception $e) {
            activity()
                ->causedBy(auth()->user('api'))
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                    'request' => request()->all(),
                    'attributes' => array_merge($guild->toArray(), ['link' => $guild->link]),
                ])
                ->log('DiscordGuildNotFound');

            abort(404);
        }

        $guild = DiscordGuild::updateOrCreate([
            'id' => request()->id,
        ], [
            'icon' => request()->icon,
            'name' => request()->name,
        ]);

        DiscordGuild::findOrFail(request()->id)->users()->syncWithoutDetaching(user('api')); // <= Necessary beacuse `$guild->id` is set to 0 on creation (?!).

        Cache::tags('emojis')->forget('user:' . user('api')->id);

        return ['success' => true];
    }

    public function emojis()
    {
        if (! user('api')->can('sync discord emojis')) {
            abort(403);
        }

        request()->validate([
            'guild_id' => ['required', 'integer', 'exists:discord_guilds,id'],
            'emojis' => ['required', 'array'],
            'emojis.*.id' => ['required', 'integer'],
            'emojis.*.name' => ['required', 'string', 'max:255'],
            'emojis.*.animated' => ['boolean'],
            'emojis.*.deleted' => ['boolean'],
            'emojis.*.require_colons' => ['boolean'],
        ]);

        foreach (request()->emojis as $incomingEmoji) {
            $emoji = DiscordEmoji::updateOrCreate([
                'id' => $incomingEmoji['id'],
            ], [
                'name' => $incomingEmoji['name'],
                'animated' => $incomingEmoji['animated'] ?? false,
                'deleted' => $incomingEmoji['deleted'] ?? false,
                'require_colons' => $incomingEmoji['require_colons'] ?? true,
                'discord_guild_id' => request()->guild_id,
            ]);

            try {
                file_get_contents($emoji->link);
            } catch (\Exception $e) {
                activity()
                    ->causedBy(auth()->user('api'))
                    ->withProperties([
                        'level' => 'warning',
                        'method' => __METHOD__,
                        'request' => request()->all(),
                        'attributes' => array_merge($emoji->toArray(), ['link' => $emoji->link]),
                    ])
                    ->log('DiscordEmojiNotFound');

                $emoji->delete();
            }
        }

        Cache::tags('emojis')->forget('user:' . user('api')->id);

        return [
            'success' => true,
        ];
    }
}
