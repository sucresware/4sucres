<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use NotificationChannels\WebPush\WebPushChannel;

class ReplyInDiscussion extends DefaultNotification
{
    use Queueable;

    public $post;
    public $save_to_database;

    public function __construct(Post $post, $save_to_database = true)
    {
        $this->post = $post;
        $this->save_to_database = $save_to_database;
    }

    public function via($notifiable)
    {
        $via = ['broadcast'];
        if ($this->save_to_database) {
            $via[] = 'database';
        }

        if (User::find($notifiable->id)->is_eligible_for_webpush) {
            $via[] = WebPushChannel::class;
        }

        return $via;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'discussion_id' => $this->post->discussion->id,
        ]);
    }

    protected function attributes()
    {
        $attributes = [
            'title' => 'Oh putain ! Une nouvelle réponse !',
            'target' => $this->post->link,
        ];

        if (!$this->post->discussion->private) {
            $attributes['html'] = '<b>' . $this->post->user->display_name . '</b> a posté une réponse dans <b>' . $this->post->discussion->title . '</b>';
            $attributes['text'] = $this->post->user->display_name . ' a posté une réponse dans : ' . $this->post->discussion->title;
        } else {
            $attributes['html'] = '<b>' . $this->post->user->display_name . '</b> a répondu dans la discussion privée <b>' . $this->post->discussion->title . '</b>';
            $attributes['text'] = $this->post->user->display_name . ' a répondu dans la discussion privée : ' . $this->post->discussion->title;
        }

        return $attributes;
    }
}
