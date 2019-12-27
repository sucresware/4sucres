<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use App\Models\User;

class ModeratorAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
    {
        return parent::canUnlock($user)
            && ($user->hasRole('moderator')
                || $user->hasRole('admin'));
    }

    public function getName(): string
    {
        return 'Distributeur de 410';
    }

    public function getDescription(): string
    {
        return 'A prouvé être digne de la puissance du 410';
    }

    public function getImage(): string
    {
        return '410.png';
    }
}
