<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class ModeratorAchievement extends AbstractAchievement
{
    const ENABLED = true;

    public function canUnlock(Authenticatable $user): bool
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
        return 'sucre.png';
    }
}
