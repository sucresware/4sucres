<?php

namespace App\Models;

use App\Notifications\RepliesInthread;
use App\Notifications\ReplyInthread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Thread extends Model
{
    use LogsActivity;

    protected $guarded = [];
    protected $dates = ['last_reply_at'];

    protected $appends = [
        'link',
    ];

    protected $casts = [
        'sticky' => 'bool',
        'locked' => 'bool',
        'private' => 'bool',
    ];

    protected static $logAttributes = ['title', 'sticky', 'locked', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($thread) {
            $thread->slug = Str::slug($thread->title);
            if (! $thread->slug) {
                $thread->slug = 'singe';
            }

            return $thread;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function replies()
    {
        return $this
            ->hasMany(Reply::class)
            ->orderBy('created_at', 'ASC');
    }

    public function latest_reply()
    {
        return $this
            ->hasOne(Reply::class)
            ->latest();
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
        return $this->belongsToMany(User::class, 'users_threads');
    }

    public function has_read()
    {
        return $this->belongsToMany(User::class, 'has_read_threads_users');
    }

    public function subscribed()
    {
        return $this->belongsToMany(User::class, 'subscribed_threads_users');
    }

    public function notify_subscibers(Reply $reply)
    {
        foreach ($this->subscribed as $user) {
            if ($user->id != $reply->user->id) {
                if ((! $reply->thread->private && $user->getSetting('notifications.on_subscribed_threads', true)) || ($reply->thread->private && $user->getSetting('notifications.on_new_private_message', true))) {
                    // Check if the user has not already received an unread ReplyInthread about this thread :
                    $notifications = $user->notifications()
                        ->where('data->thread_id', $reply->thread->id)
                        ->where('read_at', null)
                        ->whereIn('type', [ReplyInThread::class, RepliesInThread::class]);

                    if ($notifications->count()) {
                        $notifications->each(function ($notification) {
                            $notification->read_at = now();
                            $notification->save();
                        });

                        if (! $reply->thread->private) {
                            $user->notify(new RepliesInthread($reply->thread));
                            $user->notify(new ReplyInthread($reply, false));
                        } else {
                            $user->notify(new ReplyInthread($reply));
                        }
                    } else {
                        $user->notify(new ReplyInthread($reply));
                    }
                }
            }
        }
    }

    public function getLinkAttribute()
    {
        return route('threads.show', [$this->id, $this->slug]);
    }

    public static function link_to_reply(Reply $reply)
    {
        $paginator = 10;
        $reply_position = array_search($reply->id, $reply->thread->replies->pluck('id')->toArray()) + 1;
        $guessed_page = ceil($reply_position / $paginator);

        return $reply->thread->link . '?page=' . $guessed_page . '#p' . $reply->id;
    }
}
