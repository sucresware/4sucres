<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;

class NewPrivateDiscussion extends DefaultNotification
{
    use Queueable;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'discussion_id' => $this->discussion->id,
        ]);
    }

    public function via($notifiable)
    {
        if (User::find($notifiable->id)->getSetting('notifications.on_new_private_message', true)) {
            return parent::via($notifiable);
        } else {
            return [];
        }
    }

    protected function attributes()
    {
        $attributes = [
            'title'  => 'Oh putain j\'me suis dit oulaaah !',
            'target' => $this->discussion->link,
            'html'   => '<b>' . e($this->discussion->user->display_name) . '</b> a commencé une discussion privée avec toi.',
            'text'   => $this->discussion->user->display_name . ' a commencé une discussion privée avec toi.',
        ];

        return $attributes;
    }
}
