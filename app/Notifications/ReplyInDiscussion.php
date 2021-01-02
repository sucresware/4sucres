<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ReplyInthread extends DefaultNotification
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
            if (User::find($notifiable->id)->is_eligible_for_webpush) {
                $via[] = WebPushChannel::class;
            }
        }

        return $via;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'thread_id' => $this->post->thread->id,
        ]);
    }

    protected function attributes()
    {
        $attributes = [
            'title' => 'Oh putain ! Une nouvelle réponse !',
            'target' => $this->post->link,
        ];

        if (! $this->post->thread->private) {
            $attributes['html'] = '<b>' . e($this->post->user->display_name) . '</b> a posté une réponse dans <b>' . e($this->post->thread->title) . '</b>';
            $attributes['text'] = $this->post->user->display_name . ' a posté une réponse dans : ' . $this->post->thread->title;
        } else {
            $attributes['html'] = '<b>' . e($this->post->user->display_name) . '</b> a répondu dans le thread privée <b>' . e($this->post->thread->title) . '</b>';
            $attributes['text'] = $this->post->user->display_name . ' a répondu dans le thread privée : ' . $this->post->thread->title;
        }

        return $attributes;
    }

    public function toBroadcast($notifiable)
    {
        $attributes = $this->attributes();

        return new BroadcastMessage(array_merge($attributes, [
            'title' => $attributes['title'],
            'url' => $this->save_to_database ? route('notifications.show', $this->id) : $attributes['target'],
        ]));
    }
}
