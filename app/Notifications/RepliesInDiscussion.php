<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class RepliesInDiscussion extends Notification
{
    use Queueable;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'text' => 'Plusieurs réponses ont été postées sur la discussion <b>' . $this->discussion->title . '</b>',
            'target' => $this->discussion->link,
            'discussion_id' => $this->discussion->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => '<i class="fas fa-asterisk text-orange"></i> Oh putain ! Des nouvelles réponses !',
            'text' => 'Plusieurs réponses ont été postées sur la discussion <b>' . $this->discussion->title . '</b>',
            'target' => $this->discussion->link,
            'url' => route('notifications.show', $this->id),
        ]);
    }
}
