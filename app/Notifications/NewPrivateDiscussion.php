<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewPrivateDiscussion extends Notification
{
    use Queueable;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'text' => '<b>' . $this->discussion->user->display_name . '</b> a commencé une discussion privée avec toi.',
            'target' => $this->discussion->link,
            'discussion_id' => $this->discussion->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => '<i class="fas fa-asterisk text-orange"></i> Faut pas que ça se sache !',
            'text' => '<b>' . $this->discussion->user->display_name . '</b> a commencé une discussion privée avec toi.',
            'target' => $this->discussion->link,
            'url' => route('notifications.show', $this->id),
        ]);
    }
}
