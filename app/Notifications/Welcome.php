<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;

class Welcome extends DefaultNotification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    protected function attributes()
    {
        $attributes = [
            'title' => 'Bienvenue sur 4sucres.org !',
            'target' => route('user.settings.layout'),
            'html' => 'Bienvenue <b>' . $this->user->getDisplayNameAttribute() . '</b> , prends le temps de personnaliser ton interface dans les paramètres.',
            'text' => 'Bienvenue, prends le temps de personnaliser ton interface dans les paramètres.',
        ];

        return $attributes;
    }
}
