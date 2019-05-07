<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $guarded = [];

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
        $bbcode = new \ChrisKonnertz\BBCode\BBCode();

        $bbcode->addTag('glitch', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                return '<span class="baffle">';
            } else {
                return '</span>';
            }
        });

        return $bbcode->render($this->body);
    }
}
