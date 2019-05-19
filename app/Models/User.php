<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;

class User extends Authenticatable implements ReactsInterface
{
    use Notifiable, HasRoles, Reacts, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'link',
        'avatar_link'
    ];

    protected $hidden = [
        'password', 'remember_token',
        'email', 'gender', 'dob',
        'email_verified_at', 'settings',
        'avatar',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'settings' => 'array',
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
        return (bool)($this->email_verified_at == null);
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

    public function scopeOnline($query)
    {
        return $query->where('last_activity', '>', Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'));
    }

    public function scopeEnabled($query)
    {
        return $query->where('deleted_at', null);
    }

    public function getOnlineAttribute()
    {
        return ($this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'));
    }

    public function getPresentedLastActivityAttribute()
    {
        if ($this->last_activity) {
            if ($this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) {
                return 'En ligne';
            } else {
                return 'Actif ' . $this->last_activity->diffForHumans();
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
        return ($this->getSetting('webpush.enabled', false) &&
            now() > $this->last_activity
            ->addMinutes($this->getSetting('webpush.idle_wait', 1)));
    }

    public function getDisplayNameAttribute()
    {
        return $this->deleted_at ? 'Utilisateur supprimé' : $this->attributes['display_name'];
    }

    public function getNameAttribute()
    {
        return $this->deleted_at ? 'UtilisateurSupprimé' : $this->attributes['name'];
    }
}
