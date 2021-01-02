<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;

class QuotedInPost extends DefaultNotification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes(), [
            'post_id' => $this->post->id,
            'thread_id' => $this->post->thread->id,
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
            'target' => $this->post->link,
            'html' => '<b>' . e($this->post->user->display_name) . '</b> t\'as répondu dans le thread <b>' . e($this->post->thread->title) . '</b>',
            'text' => $this->post->user->display_name . ' t\'as répondu dans le thread : ' . $this->post->thread->title,
        ];

        return $attributes;
    }
}
