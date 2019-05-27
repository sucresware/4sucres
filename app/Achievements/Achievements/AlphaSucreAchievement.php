<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use App\Models\User;

class AlphaSucreAchievement extends AbstractAchievement
{
    const ALPHA_END_TIME = '2019-05-13 23:59:59';

    const ENABLED = true;

    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
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
        return 'A été présent quand 4sucres n’était qu’une idée';
    }

    public function getImage(): string
    {
        return 'beta.png';
    }
}
