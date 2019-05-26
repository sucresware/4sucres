<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;
use Illuminate\Contracts\Auth\Authenticatable;

class BetaSucreAchievement extends AbstractAchievement
{
    /**
     * End of beta date.
     *
     * @todo - Define date when out of beta.
     */
    const BETA_END_TIME = null;

    const ENABLED = false;

    public function canUnlock(Authenticatable $user): bool
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
