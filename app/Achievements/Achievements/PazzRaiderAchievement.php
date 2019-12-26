<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class PazzRaiderAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Pazz Crusader';
    }

    public function getDescription(): string
    {
        return 'Était présent lors des raids de la pazz';
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
