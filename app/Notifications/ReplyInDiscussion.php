<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ReplyInDiscussion extends Notification
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
        return $this->save_to_database ? ['database', 'broadcast'] : ['broadcast'];
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'discussion_id' => $this->post->discussion->id,
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(array_merge($this->attributes(), [
            'title' => '<i class="fas fa-asterisk text-orange"></i> Oh putain ! Une nouvelle réponse !',
            'url' => route('notifications.show', $this->id),
        ]));
    }

    protected function attributes()
    {
        if (!$this->post->discussion->private) {
            $text = '<b>' . $this->post->user->display_name . '</b> a posté une réponse dans <b>' . $this->post->discussion->title . '</b>';
        } else {
            $text = '<b>' . $this->post->user->display_name . '</b> a répondu dans la discussion privée <b>' . $this->post->discussion->title . '</b>';
        }

        return [
            'text' => $text,
            'target' => $this->post->link,
        ];
    }
}
