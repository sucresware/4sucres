<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscordEmoji extends Model
{
    protected $increments = false;

    protected $guarded = [];

    protected $appends = ['link'];

    public function guild()
    {
        return $this->belongsTo(DiscordGuild::class, 'discord_guild_id');
    }

    public function getLinkAttribute()
    {
        $url = 'https://cdn.discordapp.com/emojis/' . $this->id;
        $url .= ($this->animated) ? '.gif' : '.png';

        return $url;
    }
}
