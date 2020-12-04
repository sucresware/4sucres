<?php

namespace App\Achievements\Achievements;

use App\Models\User;
use App\Achievements\AbstractAchievement;

class DonatorAchievement extends AbstractAchievement
{
    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
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
        return 'donator.png';
    }

    public function isRare(): bool
    {
        return true;
    }
}
