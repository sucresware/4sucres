<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['last_reply_at'];

    public static function boot()
    {
        parent::boot();

        self::creating(function($discussion){
            $discussion->slug = Str::slug($discussion->title);

            return $discussion;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'ASC');
    }

    public function scopeSticky($query){
        return $query
            ->where('sticky', true)
            ->where('private', false)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function scopeOrdered($query){
        return $query
            ->where('sticky', false)
            ->where('private', false)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function scopePrivate($query, User $user){
        return $query
            ->whereHas('members', function($query) use ($user){
                $query->where('user_id', $user->id);
            })
            ->where('private', true)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function getPresentedLastReplyAtAttribute(){
        return str_replace('il y a', '', $this->last_reply_at->diffForHumans());
    }

    public function getPresentedRepliesAttribute() {
        return $this->replies-1;
    }

    public function members(){
        return $this->belongsToMany(User::class, 'users_discussions');
    }

    public function has_read(){
        return $this->belongsToMany(User::class, 'has_read_discussions_users');
    }

    public function subscribed(){
        return $this->belongsToMany(User::class, 'subscribed_discussions_users');
    }

    public function notify_subscibers(Post $post){
        foreach ($this->subscribed as $user) {
            if ($user->id != $post->user->id) {
                Notification::create([
                    'class' => 'info',
                    'text' => $post->user->name . 'a posté un nouveau message sur la discussion ' . $post->discussion->title,
                    'href' => route('discussions.show', [$this->id, $this->slug]),
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
