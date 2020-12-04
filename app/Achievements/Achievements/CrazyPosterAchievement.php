<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use App\Models\User;

class CrazyPosterAchievement extends AbstractAchievement
{
    const POST_COUNT_TO_UNLOCK = 1500;

    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
    {
        return parent::canUnlock($user)
            && $user->replies_count >= self::POST_COUNT_TO_UNLOCK;
    }

    public function getName(): string
    {
        return 'Posteur fou';
    }

    public function getDescription(): string
    {
        return 'Pour avoir posté + de 1500 messages sur le forum.';
    }

    public function getImage(): string
    {
        return 'crazyposter.png';
    }

    public function isRare(): bool
    {
        return false;
    }
}
