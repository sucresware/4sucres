<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Qirolab\Laravel\Reactions\Contracts\ReactsInterface;
use Qirolab\Laravel\Reactions\Traits\Reacts;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements ReactsInterface
{
    use Notifiable, HasRoles, Reacts;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verify_user()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function getLinkAttribute()
    {
        return route('user.show', [$this->id, $this->name]);
    }

    public function getAvatarLinkAttribute()
    {
        return $this->avatar ? url('storage/avatars/' . $this->avatar) : url('/img/guest.png');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')->withPivot('unlocked_at');
    }

    public function getRestrictedAttribute(){
        return (bool) ($this->email_verified_at == null);
    }

    public function getRestrictedPostsCreatedAttribute(){
        return \App\Models\Post::where('user_id', auth()->user()->id)
            ->whereHas('discussion', function($q){
                return $q->where('private', false);
            })
            ->count();
    }

    public function getRestrictedPostsRemainingAttribute(){
        return 3 - $this->restricted_posts_created;
    }
}
