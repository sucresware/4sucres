<?php

namespace App\Notifications;

use App\Models\Post;
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
            'post_id' => $this->post->discussion->id,
        ]);
    }

    protected function attributes()
    {
        $attributes = [
            'title' => 'Hey! T\'as été cité !',
            'target' => $this->post->link,
            'html' => '<b>' . $this->post->user->display_name . '</b> t\'as répondu dans la discussion <b>' . $this->post->discussion->title . '</b>',
            'text' => $this->post->user->display_name . ' t\'as répondu dans la discussion : ' . $this->post->discussion->title,
        ];

        return $attributes;
    }
}
