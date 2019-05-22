<?php

namespace App\Models;

use App\Helpers\SucresHelper;
use App\Helpers\SucresParser;
use App\Jobs\ForgetCacheJob;
use App\Notifications\MentionnedInPost;
use App\Notifications\QuotedInPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;

class Post extends Model implements ReactableInterface
{
    use Reactable;

    protected $guarded = [];

    protected $appends = [
        'link',
        'presented_body',
        'presented_date',
    ];

    protected $casts = [
        'deleted_at' => 'timestamp',
    ];

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
            Cache::tags('posts')->forget($updated_post->id . ':render');

            Post::where('body', 'like', '%#p:' . $updated_post->id . '%')->pluck('id')->each(function ($id) {
                dispatch(new ForgetCacheJob($id . ':render', 'posts'));
                dispatch(new ForgetCacheJob($id . ':renderWithoutQuotes', 'posts'));
            });

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
        return Cache::tags('posts')->remember($this->id . ':render', now()->addWeeks(2), function () {
            return (new SucresParser($this))->render();
        });
    }

    public function getPresentedLightBodyAttribute()
    {
        return Cache::tags('posts')->remember($this->id . ':renderWithoutQuotes', now()->addWeeks(2), function () {
            return (new SucresParser($this))->render(false);
        });
    }

    public function getPresentedDateAttribute()
    {
        $markup = SucresHelper::niceDate($this->created_at);

        if ($this->deleted_at) {
            $markup .= ' (supprimé ' . SucresHelper::niceDate($this->created_at) . ')';
        } else {
            if ($this->created_at != $this->updated_at) {
                $markup .= ' (modifié ' . SucresHelper::niceDate($this->created_at) . ')';
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
