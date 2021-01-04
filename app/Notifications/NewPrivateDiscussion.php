<?php

namespace App\Notifications;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;

class NewPrivatethread extends DefaultNotification
{
    use Queueable;

    public $thread;

    public function __construct(thread $thread)
    {
        $this->thread = $thread;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'thread_id' => $this->thread->id,
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
            'title' => 'Oh putain j\'me suis dit oulaaah !',
            'target' => $this->thread->link,
            'html' => '<b>' . e($this->thread->user->display_name) . '</b> a commencé une thread privée avec toi.',
            'text' => $this->thread->user->display_name . ' a commencé une thread privée avec toi.',
        ];

        return $attributes;
    }
}
