<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class RaiderAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Raideur engagé';
    }

    public function getDescription(): string
    {
        return 'A brillé lors d\'un raid organisé par Artamas';
    }

    public function getImage(): string
    {
        return 'raid.png';
    }
    
    public function isRare(): bool
    {
        return false;
    }
}
