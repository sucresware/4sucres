<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewYear2021Achievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Bonne année 2021 !';
    }

    public function getDescription(): string
    {
        return 'Avoir fêté la nouvelle année avec les doubles sucros';
    }

    public function getImage(): string
    {
        return 'year2020.png';
    }

    public function isRare(): bool
    {
        return true;
    }
}
