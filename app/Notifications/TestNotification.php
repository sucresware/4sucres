<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

class TestNotification extends DefaultNotification
{
    use Queueable;

    public function via($notifiable)
    {
        return parent::via($notifiable);
    }

    protected function attributes()
    {
        $attributes = [
            'title'  => 'Oh putain j\'me suis dit oulaaah !',
            'target' => route('home'),
            'html'   => 'Ceci est un test de notification. <b>T\'as vu ?</b>',
            'text'   => 'Ceci est un test de notification. T\'as vu ?',
        ];

        return $attributes;
    }
}
