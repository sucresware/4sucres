<?php

namespace App\Models;

use App\Helpers\SucresParser;
use App\Notifications\MentionnedInPost;
use App\Notifications\QuotedInPost;
use Illuminate\Database\Eloquent\Model;
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
        'presented_created_at',
        'presented_updated_at',
    ];

    protected $hidden = [
        '',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($post) {
            $discussion = $post->discussion;
            ++$discussion->replies;
            $discussion->last_reply_at = now();
            $discussion->save();

            $post->discussion->has_read()->sync([]);
            $post->discussion->notify_subscibers($post);

            if (!$post->discussion->private) {
                $preg_result = [];
                preg_match_all('/(?:@|#u:)(?:\w+)(?:<br\/>|<br>|[\s]|$|\z)/', $post->body, $preg_result);
                $mentioned_users = [];

                foreach ($preg_result[0] as $tag) {
                    $tag = trim($tag);
                    $clear_tag = trim(str_replace(['@', '#u:'], '', $tag));

                    if ($clear_tag == $post->user->name) {
                        continue;
                    }
                    $user = User::where('name', $clear_tag)->first();
                    if (!$user) {
                        continue;
                    }

                    $mentioned_users[$user->id] = $user;
                }

                Notification::send($mentioned_users, new MentionnedInPost($post));

                $preg_result = [];
                preg_match_all('/(?:#p:)(?:\d+)(?:<br\/>|<br>|[\s]|$|\z)/', $post->body, $preg_result);
                $quoted_users = [];

                foreach ($preg_result[0] as $tag) {
                    $tag = trim($tag);
                    $clear_tag = trim(str_replace(['#p:'], '', $tag));

                    $p = Post::find($clear_tag);
                    if (!$p || $p->discussion->private) {
                        continue;
                    }
                    if ($post->user->id == $p->user->id) {
                        continue;
                    }

                    $quoted_users[$p->user->id] = $p->user;
                }

                Notification::send($quoted_users, new QuotedInPost($post));
            }

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
        return (new SucresParser($this, true))->render();
    }

    public function getPresentedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y à H:i:s');
    }

    public function getPresentedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d/m/Y à H:i:s');
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
