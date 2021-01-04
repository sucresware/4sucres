<?php

namespace App\Notifications;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use NotificationChannels\WebPush\WebPushChannel;

class RepliesInthread extends DefaultNotification
{
    use Queueable;

    public $thread;

    public function __construct(thread $thread)
    {
        $this->thread = $thread;
    }

    public function via($notifiable)
    {
        $via = [
            'database',
        ];

        if (User::find($notifiable->id)->is_eligible_for_webpush) {
            $via[] = WebPushChannel::class;
        }

        return $via;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'thread_id' => $this->thread->id,
        ]);
    }

    protected function attributes()
    {
        return [
            'title' => 'Oui, allo ?',
            'target' => $this->thread->link,
            'html' => 'Plusieurs réponses ont été replyées sur le thread <b>' . e($this->thread->title) . '</b>',
            'text' => 'Plusieurs réponses ont été replyées sur le thread : ' . $this->thread->title,
        ];
    }
}
