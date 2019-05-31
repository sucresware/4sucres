<?php

namespace App\Models;

use App\Notifications\RepliesInDiscussion;
use App\Notifications\ReplyInDiscussion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Discussion extends Model
{
    use LogsActivity;

    protected $guarded = [];
    protected $dates = ['last_reply_at'];

    protected $appends = [
        'link',
    ];

    protected static $logAttributes = ['title', 'sticky', 'locked', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($discussion) {
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

    public function scopeSticky($query)
    {
        return $query
            ->public()
            ->where('sticky', true)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function scopeOrdered($query)
    {
        return $query
            ->public()
            ->where('sticky', false)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function scopePublic($query)
    {
        return $query
            ->notTrashed()
            ->where('private', false);
    }

    public function scopePrivate($query, User $user)
    {
        return $query
            ->notTrashed()
            ->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('private', true)
            ->orderBy('last_reply_at', 'DESC');
    }

    public function scopeRead($query, User $user)
    {
        return $query
            ->whereHas('has_read', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
    }

    public function scopeNotTrashed($query)
    {
        return $query->where('deleted_at', null);
    }

    public function getPresentedLastReplyAtAttribute()
    {
        return str_replace('il y a', '', $this->last_reply_at->diffForHumans());
    }

    public function getPresentedRepliesAttribute()
    {
        return $this->replies - 1;
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'users_discussions');
    }

    public function has_read()
    {
        return $this->belongsToMany(User::class, 'has_read_discussions_users');
    }

    public function subscribed()
    {
        return $this->belongsToMany(User::class, 'subscribed_discussions_users');
    }

    public function notify_subscibers(Post $post)
    {
        foreach ($this->subscribed as $user) {
            if ($user->id != $post->user->id && $user->getIsNotifMPAttribute()) {
                // Check if the user has not already received an unread ReplyInDiscussion about this discussion :
                $notifications = $user->notifications()
                    ->where('data->discussion_id', $post->discussion->id)
                    ->where('read_at', null)
                    ->whereIn('type', [ReplyInDiscussion::class, RepliesInDiscussion::class]);

                if ($notifications->count()) {
                    $notifications->update(['read_at' => now()]);
                    if (!$post->discussion->private) {
                        $user->notify(new RepliesInDiscussion($post->discussion));
                        $user->notify(new ReplyInDiscussion($post, false));
                    } else {
                        $user->notify(new ReplyInDiscussion($post));
                    }
                } else {
                    $user->notify(new ReplyInDiscussion($post));
                }
            }
        }
    }

    public function getLinkAttribute()
    {
        return route('discussions.show', [$this->id, $this->slug]);
    }

    public static function link_to_post(Post $post)
    {
        $pagniator = 10;
        $post_position = array_search($post->id, $post->discussion->posts->pluck('id')->toArray()) + 1;
        $guessed_page = ceil($post_position / $pagniator);

        return $post->discussion->link . '?page=' . $guessed_page . '#p' . $post->id;
    }
}
