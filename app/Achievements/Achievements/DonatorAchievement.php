<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class DonatorAchievement extends AbstractAchievement
{
    public function canUnlock(Authenticatable $user): bool
    {
        return parent::canUnlock($user) && $user->hasRole('supporter');
    }

    public function getName(): string
    {
        return 'Sucre généreux';
    }

    public function getDescription(): string
    {
        // Because the amount of the support money can buy a coffee?
        return 'A donné un café dans lequel mettre quatre sucres';
    }

    public function getImage(): string
    {
        return 'sucre.png';
    }
}
