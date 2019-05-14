<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class QuotedInPost extends Notification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'text' => '<b>' . $this->post->user->display_name . '</b> t\'as répondu dans la discussion <b>' . $this->post->discussion->title . '</b>',
            'target' => $this->post->link,
            'post_id' => $this->post->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => '<i class="fas fa-asterisk text-orange"></i> Hey! T\'as été cité !',
            'text' => '<b>' . $this->post->user->display_name . '</b> t\'as répondu dans la discussion <b>' . $this->post->discussion->title . '</b>',
            'target' => $this->post->link,
            'url' => route('notifications.show', $this->id),
        ]);
    }
}
