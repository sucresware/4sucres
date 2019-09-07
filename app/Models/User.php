<?php

namespace App\Models;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ReactsInterface, BannableContract
{
    use Notifiable;
    use HasRoles;
    use Reacts;
    use HasPushSubscriptions;
    use LogsActivity;
    use CausesActivity;
    use Bannable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'link',
        'avatar_link',
        'is_birthday',
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
        'dob'               => 'datetime',
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
        if (config('app.env') === 'local') {
            return url('/img/guest.png');
        } else {
            return $this->avatar ? url('storage/avatars/' . $this->avatar) : url('/img/guest.png');
        }
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')->withPivot('unlocked_at');
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getRestrictedAttribute()
    {
        return (bool) ($this->email_verified_at == null);
    }

    public function getRestrictedPostsCreatedAttribute()
    {
        return $this->posts()
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
        return $query->where('last_activity', '>', Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s'));
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

    public function getIsEligibleForPushbulletAttribute()
    {
        return $this->getSetting('services.pushbullet.enabled', false) && $this->getSetting('services.pushbullet.email', '');
    }

    public function getDisplayNameAttribute()
    {
        return $this->deleted_at ? 'Inconnu' : $this->attributes['display_name'];
    }

    public function getNameAttribute()
    {
        return $this->deleted_at ? 'Inconnu' : $this->attributes['name'];
    }

    public function getIsBirthdayAttribute()
    {
        return $this->dob ? (new Carbon($this->dob))->isCurrentDay() : false;
    }

    public function discord_guilds()
    {
        return $this->belongsToMany(DiscordGuild::class);
    }

    public function getEmojisAttribute()
    {
        if ($this->can('sync discord emojis')) {
            $cache = ['emojis', 'user:' . $this->id];
        } else {
            $cache = ['emojis', 'global'];
        }

        return Cache::tags($cache[0])->rememberForever($cache[1], function () {
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
                return $q->where('user_id', $this->id);
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
        });
    }

    public function getRepliesCountAttribute()
    {
        $posts_count = $this
            ->posts()
            ->notTrashed()
            ->whereHas('discussion', function ($q) {
                $q->public();
            })
            ->count();

        return $posts_count - $this->discussions_count;
    }

    public function getDiscussionsCountAttribute()
    {
        return $this
            ->discussions()
            ->public()
            ->count();
    }

    public function getApiTokenAttribute()
    {
        if (!isset($this->attributes['api_token'])) {
            $this->attributes['api_token'] = $this->createToken('personal')->accessToken;
            $this->save();
        }

        return $this->attributes['api_token'];
    }

    public function getPrivateUnreadCountAttribute()
    {
        // Original request (150-200ms):
        // return \App\Models\Discussion::private($this)->count() - \App\Models\Discussion::private($this)->read($this)->count();

        // Optimized request (20ms+5ms):
        $private_ids = Discussion::query()
            ->select('id')
            ->private($this)
            ->pluck('id')
            ->toArray();

        $user_has_read = DB::table('has_read_discussions_users')
            ->select('discussion_id')
            ->distinct('discussion_id')
            ->where('user_id', $this->id)
            ->whereIn('discussion_id', $private_ids)
            ->pluck('discussion_id')
            ->toArray();

        return count(array_diff($private_ids, $user_has_read));
    }

    public function routeNotificationForPushbullet()
    {
        return new \NotificationChannels\Pushbullet\Targets\Email($this->getSetting('services.pushbullet.email', ''));
    }
}
