<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ReactsInterface
{
    use Notifiable, HasRoles, Reacts, HasPushSubscriptions, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'link',
        'avatar_link',
    ];

    protected $hidden = [
        'password', 'remember_token',
        'email', 'gender', 'dob',
        'email_verified_at', 'settings',
        'avatar', 'api_token',
    ];

    protected static $logAttributes = ['name', 'display_name', 'shown_role', 'email', 'avatar', 'settings'];
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['updated'];
    protected static $submitEmptyLogs = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity'     => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'settings'          => 'array',
    ];

    public function verify_user()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function getLinkAttribute()
    {
        return route('user.show', $this->name);
    }

    public function getAvatarLinkAttribute()
    {
        return $this->avatar ? url('storage/avatars/' . $this->avatar) : url('/img/guest.png');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')->withPivot('unlocked_at');
    }

    public function getRestrictedAttribute()
    {
        return (bool) ($this->email_verified_at == null);
    }

    public function getRestrictedPostsCreatedAttribute()
    {
        return \App\Models\Post::where('user_id', user()->id)
            ->whereHas('discussion', function ($q) {
                return $q->where('private', false);
            })
            ->count();
    }

    public function getRestrictedPostsRemainingAttribute()
    {
        return 3 - $this->restricted_posts_created;
    }

    public function scopeActive($query)
    {
        return $query->where('last_activity', '>', Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'));
    }

    public function scopeOnline($query)
    {
        // FIXME
        return $query->where('last_activity', '>', Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'));
    }

    public function scopeNotTrashed($query)
    {
        return $query->where('deleted_at', null);
    }

    public function getOnlineAttribute()
    {
        // FIXME
        return $this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
    }

    public function getOnlineCircleColorAttribute()
    {
        if ($this->last_activity) {
            if ($this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) {
                return 'text-success';
            } elseif ($this->last_activity > Carbon::now()->subMinutes(60)->format('Y-m-d H:i:s')) {
                return 'text-muted';
            } else {
                return 'text-danger';
            }
        }
    }

    public function getPresentedLastActivityAttribute()
    {
        if ($this->last_activity) {
            if ($this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) {
                return 'En ligne';
            } elseif ($this->last_activity > Carbon::now()->subMinutes(60)->format('Y-m-d H:i:s')) {
                return 'Inactif ' . str_replace('il y a', 'depuis', $this->last_activity->diffForHumans());
            } else {
                return 'Hors ligne';
            }
        }
    }

    public function getSetting($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    public function setSetting($key, $value)
    {
        $currentSettings = $this->settings;
        data_set($currentSettings, $key, $value);
        $this->settings = $currentSettings;
        $this->save();

        return $this;
    }

    public function setMultipleSettings(array $settings)
    {
        $currentSettings = $this->settings;
        foreach ($settings as $key => $value) {
            data_set($currentSettings, $key, $value);
        }

        $this->settings = $currentSettings;
        $this->save();

        return $this;
    }

    public function getIsEligibleForWebpushAttribute()
    {
        return $this->getSetting('webpush.enabled', false) &&
            now() > $this->last_activity
            ->addMinutes($this->getSetting('webpush.idle_wait', 1));
    }

    public function getDisplayNameAttribute()
    {
        return $this->deleted_at ? 'Inconnu' : $this->attributes['display_name'];
    }

    public function getNameAttribute()
    {
        return $this->deleted_at ? 'Inconnu' : $this->attributes['name'];
    }

    public function discord_guilds()
    {
        return $this->belongsToMany(DiscordGuild::class);
    }

    public function getEmojisAttribute()
    {
        $jvc_smileys = Cache::get('jvc_smileys')->transform(function ($smiley) {
            $smiley->type = 'smiley';
            $smiley->link = url('/img/smileys/' . $smiley->image);

            return $smiley;
        });

        $emojis = Cache::get('emojis')->transform(function ($smiley) {
            $smiley->type = 'emoji';

            return $smiley;
        });

        $discord_emojis = DiscordEmoji::whereHas('guild.users', function ($q) {
            return $q->where('user_id', user()->id);
        })->get()
        ->transform(function ($emoji) {
            if ($emoji->require_colons) {
                $emoji->shortname = ':' . $emoji->name . ':';
            } else {
                $emoji->shortname = $emoji->name;
            }

            $emoji->type = 'discord';

            return $emoji;
        });

        $duplicates = [];

        $all = collect(array_merge(
            $jvc_smileys->toArray(),
            $emojis->toArray(),
            $discord_emojis->toArray()
        ))->transform(function ($emoji) use (&$duplicates) {
            if (is_array($emoji)) {
                $e = [
                    'type'      => $emoji['type'],
                    'shortname' => $emoji['shortname'],
                    'link'      => $emoji['link'] ?? '',
                    'html'      => $emoji['html'] ?? '',
                ];
            } else {
                $e = [
                    'type'      => $emoji->type,
                    'shortname' => $emoji->shortname,
                    'link'      => $emoji->link ?? '',
                    'html'      => $emoji->html ?? '',
                ];
            }

            if (in_array($e['shortname'], $duplicates)) {
                $name = $e['shortname'];
                $counts = array_count_values($duplicates);
                if (substr($name, -1, 1) == ':') {
                    $e['shortname'] = substr($name, 0, -1) . '~' . $counts[$name] . ':';
                } else {
                    $e['shortname'] = $name . '~' . $counts[$name];
                }

                $duplicates[] = $name;
            } else {
                $duplicates[] = $e['shortname'];
            }

            return $e;
        });

        return $all;
    }
}
