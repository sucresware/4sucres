<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class DefaultNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function toArray($notifiable)
    {
        return $this->attributes();
    }

    public function via($notifiable)
    {
        $via = [
            'database',
            'broadcast'
        ];

        if (User::find($notifiable->id)->is_eligible_for_webpush) {
            $via[] = WebPushChannel::class;
        }

        return $via;
    }

    public function toBroadcast($notifiable)
    {
        $attributes = $this->attributes();

        return new BroadcastMessage(array_merge($attributes, [
            'title' => $attributes['title'],
            'url' => route('notifications.show', $this->id),
        ]));
    }

    public function toWebPush($notifiable, $notification)
    {
        $attributes = $this->attributes();

        return (new WebPushMessage)
            ->data([
                'url' => route('notifications.show', $this->id),
            ])
            ->title($attributes['title'])
            ->body($attributes['text'])
            ->icon(url('/img/webpush/icon.png'))
            ->badge(url('/img/webpush/badge.png'));
    }
}
