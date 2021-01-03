<?php

namespace App\Notifications;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Bus\Queueable;

class QuotedInReply extends DefaultNotification
{
    use Queueable;

    public $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'reply_id' => $this->reply->id,
            'thread_id' => $this->reply->thread->id,
        ]);
    }

    public function via($notifiable)
    {
        if (User::find($notifiable->id)->getSetting('notifications.when_mentionned_or_quoted', true)) {
            return parent::via($notifiable);
        } else {
            return [];
        }
    }

    protected function attributes()
    {
        $attributes = [
            'title' => 'Hey! T\'as été cité !',
            'target' => $this->reply->link,
            'html' => '<b>' . e($this->reply->user->display_name) . '</b> t\'as répondu dans le thread <b>' . e($this->reply->thread->title) . '</b>',
            'text' => $this->reply->user->display_name . ' t\'as répondu dans le thread : ' . $this->reply->thread->title,
        ];

        return $attributes;
    }
}
