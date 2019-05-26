<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class AlphaSucreAchievement extends AbstractAchievement
{
    const ALPHA_END_TIME = '2019-05-13 23:59:59';

    const ENABLED = true;

    public function canUnlock(Authenticatable $user): bool
    {
        return parent::canUnlock($user)
            && $user->created_at <= self::ALPHA_END_TIME;
    }

    public function getName(): string
    {
        return 'Sucre Alpha';
    }

    public function getDescription(): string
    {
        return 'A été présent quand 4sucres n’était qu’un sujet de troll';
    }

    public function getImage(): string
    {
        return 'alpha.png';
    }
}
