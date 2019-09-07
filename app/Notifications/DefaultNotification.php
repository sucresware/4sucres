<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushbullet\PushbulletChannel;
use NotificationChannels\Pushbullet\PushbulletMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

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
            'broadcast',
        ];

        if (User::find($notifiable->id)->is_eligible_for_webpush) {
            $via[] = WebPushChannel::class;
        }

        if (User::find($notifiable->id)->is_eligible_for_pushbullet) {
            $via[] = PushbulletChannel::class;
        }

        return $via;
    }

    public function toBroadcast($notifiable)
    {
        $attributes = $this->attributes();

        return new BroadcastMessage(array_merge($attributes, [
            'title' => $attributes['title'],
            'url'   => route('notifications.show', $this->id),
        ]));
    }

    public function toWebPush($notifiable, $notification)
    {
        $attributes = $this->attributes();

        return (new WebPushMessage())
            ->data([
                'url' => route('notifications.show', $this->id),
            ])
            ->title($attributes['title'])
            ->body($attributes['text'])
            ->icon(url('/img/webpush/icon.png'))
            ->badge(url('/img/webpush/badge.png'));
    }

    public function toPushbullet($notifiable)
    {
        $attributes = $this->attributes();

        return PushbulletMessage::create($attributes['text'])
            ->link()
            ->title($attributes['title'])
            ->url(route('notifications.show', $this->id));
    }
}
