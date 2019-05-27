<?php

namespace App\Models;

use App\Helpers\SucresHelper;
use App\Helpers\SucresParser;
use App\Notifications\MentionnedInPost;
use App\Notifications\QuotedInPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model implements ReactableInterface
{
    use Reactable, LogsActivity;

    protected $guarded = [];

    protected $appends = [
        'link',
        'presented_body',
        'presented_date',
    ];

    protected $casts = [
        'deleted_at' => 'timestamp',
    ];

    protected static $logAttributes = ['body', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public static function boot()
    {
        parent::boot();

        self::created(function ($created_post) {
            $discussion = $created_post->discussion;
            ++$discussion->replies;
            $discussion->last_reply_at = now();
            $discussion->save();

            $created_post->discussion->has_read()->sync([]);
            $created_post->discussion->notify_subscibers($created_post);

            if (!$created_post->discussion->private) {
                $parser = new SucresParser($created_post);

                $mentioned_users = $parser->getMentions(SucresParser::MENTIONS_RETURN_USERS)
                    ->unique()
                    ->reject(function ($user) use ($created_post) {
                        return $user->id == $created_post->user->id;
                    });

                $quoted_users = $parser->getQuotedUsers()
                    ->unique()
                    ->reject(function ($user) use ($created_post) {
                        return $user->id == $created_post->user->id;
                    });

                Notification::send($mentioned_users, new MentionnedInPost($created_post));
                Notification::send($quoted_users, new QuotedInPost($created_post));
            }

            return true;
        });

        self::updated(function ($updated_post) {
            return true;
        });
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPresentedBodyAttribute()
    {
        return (new SucresParser($this))->render();
    }

    public function getPresentedLightBodyAttribute()
    {
        return (new SucresParser($this))->render(false);
    }

    public function getPresentedDateAttribute()
    {
        $markup = SucresHelper::niceDate($this->created_at);

        if ($this->deleted_at) {
            $markup .= ' (supprimé ' . SucresHelper::niceDate($this->deleted_at) . ')';
        } else {
            if ($this->created_at != $this->updated_at) {
                $markup .= ' (modifié ' . SucresHelper::niceDate($this->updated_at) . ')';
            }
        }

        return $markup;
    }

    public function getLinkAttribute()
    {
        return route('posts.show', $this);
    }

    public function scopeNotTrashed($query)
    {
        return $query->where('deleted_at', null);
    }
}
