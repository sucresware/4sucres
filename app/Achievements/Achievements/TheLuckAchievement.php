<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class TheLuckAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'La CHANCE';
    }

    public function getDescription(): string
    {
        return 'Avoir été le seul a atteindre les 100.00 cm sans tricher sur LeBunker';
    }

    public function getImage(): string
    {
        return '100cm.png';
    }

    public function isRare(): bool
    {
        return true;
    }
}
