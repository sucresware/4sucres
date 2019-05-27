<?php

namespace App\Notifications;

use App\Achievements\AbstractAchievement;
use Illuminate\Bus\Queueable;

class UnlockedAchievement extends DefaultNotification
{
    use Queueable;

    public $achievement;

    public function __construct(AbstractAchievement $achievement)
    {
        $this->achievement = $achievement;
    }

    public function toArray($notifiable)
    {
        return array_merge($this->attributes());
    }

    protected function attributes()
    {
        $attributes = [
            'title'  => 'Ah oui oui !',
            'target' => route('profile'),
            'html'   => 'Succès débloqué : <b>' . $this->achievement->getName() . '</b>',
            'text'   => 'Succès débloqué : ' . $this->achievement->getName(),
        ];

        return $attributes;
    }
}
