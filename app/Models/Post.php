<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;
use Qirolab\Laravel\Reactions\Traits\Reactable;

class Post extends Model implements ReactableInterface
{
    use SoftDeletes, Reactable;
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

            foreach ($mentioned_users as $user) {
                Notification::create([
                    'class' => 'info',
                    'text' => '<b>' . $post->user->name . '</b> vous a mentionné sur la discussion <b>' . $post->discussion->title . '</b>',
                    'href' => route('discussions.show', [$post->discussion->id, $post->discussion->slug]),
                    'user_id' => $user->id,
                ]);
            }

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

            foreach ($quoted_users as $user) {
                Notification::create([
                    'class' => 'info',
                    'text' => '<b>' . $post->user->name . '</b> vous a cité sur la discussion <b>' . $post->discussion->title . '</b>',
                    'href' => route('discussions.show', [$post->discussion->id, $post->discussion->slug]),
                    'user_id' => $user->id,
                ]);
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
        $body = $this->presented_light_body;

        // Rendu des citations :
        $preg_result = [];
        preg_match_all('/(?:#p:)(?:\d+)(?:<br\/>|<br>|[\s]|$|\z)/', $body, $preg_result);

        foreach ($preg_result[0] as $tag) {
            $tag = trim($tag);
            $clear_tag = trim(str_replace(['#p:'], '', $tag));

            $post = Post::find($clear_tag);
            if (!$post || $post->discussion->private) {
                continue;
            }

            $body = str_replace(
                $tag,
                view('discussion.post._show_as_quote', compact('post'))->render(),
                $body
            );
        }

        return $body;
    }

    public function getPresentedLightBodyAttribute()
    {
        $body = $this->body;

        // Rendu de [mock][/mock]
        $preg_result = [];
        preg_match_all('/(?:\[mock\])(.*)(?:\[\/mock\])/', $body, $preg_result);

        foreach ($preg_result[0] as $k => $tag) {
            $str = str_split(strtolower($preg_result[1][$k]));
            foreach ($str as &$char) {
                if (rand(0, 1)) {
                    $char = strtoupper($char);
                }
            }

            $body = str_replace(
                $tag,
                implode('', $str),
                $body
            );
        }

        // Rendu du BBCode :
        $bbcode = new \ChrisKonnertz\BBCode\BBCode();

        $bbcode->addTag('glitch', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                return '<span class="baffle">';
            } else {
                return '</span>';
            }
        });

        // Fix urls
        $bbcode->addTag('sucresBB_url', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                if ($tag->property) {
                    $code = '<a target="_blank" href="'.$tag->property.'">';
                } else {
                    $code = '<a target="_blank" href="';
                }
            } else {
                if ($openingTag->property) {
                    $code = '</a>';
                } else {
                    $partial = mb_substr($html, $openingTag->position + 9);
                    $html = mb_substr($html, 0, $openingTag->position + 9)
                        .strip_tags($partial).'">'.$partial.'</a>';
                }
            }

            return $code;
        });

        // Prepare YouTube tag content
        $re = '/\[youtube](.*)\[\/youtube]/m';
        $match = [];
        preg_match($re, $body, $match);
        if ($match[0] ?? null) {
            $new_tag = '[youtube]';
            $base_youtube_url = $match[1];
            $base_youtube_url = str_replace('https://www.youtube.com/watch?v=', '', $base_youtube_url);
            $base_youtube_url = str_replace('https://youtube.com/watch?v=', '', $base_youtube_url);
            $base_youtube_url = str_replace('https://youtu.be/', '', $base_youtube_url);
            $base_youtube_url = str_replace('https://www.youtube.com/embed/', '', $base_youtube_url);
            $base_youtube_url = str_replace('http://www.youtube.com/watch?v=', '', $base_youtube_url);
            $base_youtube_url = str_replace('http://youtube.com/watch?v=', '', $base_youtube_url);
            $base_youtube_url = str_replace('http://youtu.be/', '', $base_youtube_url);
            $base_youtube_url = str_replace('http://www.youtube.com/embed/', '', $base_youtube_url);
            $new_tag .= $base_youtube_url;
            $new_tag .= '[/youtube]';
            $body = str_replace($match[0], $new_tag, $body);
        }

        $bbcode->setYouTubeWidth(560);
        $bbcode->setYouTubeHeight(315);
        $body = $bbcode->render($body);

        // Rendu des mentions :
        $preg_result = [];
        preg_match_all('/(?:@|#u:)(?:\w+)(?:<br\/>|<br>|[\s]|$|\z)/', $body, $preg_result);

        foreach ($preg_result[0] as $tag) {
            $tag = trim($tag);
            $clear_tag = trim(str_replace(['@', '#u:'], '', $tag));

            $user = User::where('name', $clear_tag)->first();
            if (!$user) {
                continue;
            }

            $body = str_replace(
                $tag,
                '<a href="' . $user->link . '" class="badge badge-primary">@' . $clear_tag . '</a>' . ' ',
                $body
            );
        }

        return $body;
    }
}
