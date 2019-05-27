<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use App\Models\User;

class BetaSucreAchievement extends AbstractAchievement
{
    /**
     * End of beta date.
     *
     * @todo - Define date when out of beta.
     */
    const BETA_END_TIME = null;

    const ENABLED = false;

    const UNLOCKABLE = true;

    public function canUnlock(User $user): bool
    {
        return parent::canUnlock($user)
            && $user->created_at <= self::BETA_END_TIME;
    }

    public function getName(): string
    {
        return 'Sucre Béta';
    }

    public function getDescription(): string
    {
        return 'A été présent avant que @PipBoy ne hack le forum';
    }

    public function getImage(): string
    {
        return 'sucre.png';
    }
}
