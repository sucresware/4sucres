<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class CrazyPosterAchievement extends AbstractAchievement
{
    const POST_COUNT_TO_UNLOCK = 50;

    public function canUnlock(Authenticatable $user): bool
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
        return 'A posté plus de 50 messages.';
    }

    public function getImage(): string
    {
        return '2sucres.png';
    }
}
