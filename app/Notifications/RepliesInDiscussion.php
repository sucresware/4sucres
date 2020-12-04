<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use NotificationChannels\WebPush\WebPushChannel;

class RepliesInDiscussion extends DefaultNotification
{
    use Queueable;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
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
            'discussion_id' => $this->discussion->id,
        ]);
    }

    protected function attributes()
    {
        return [
            'title' => 'Oui, allo ?',
            'target' => $this->discussion->link,
            'html' => 'Plusieurs réponses ont été postées sur la discussion <b>' . e($this->discussion->title) . '</b>',
            'text' => 'Plusieurs réponses ont été postées sur la discussion : ' . $this->discussion->title,
        ];
    }
}
