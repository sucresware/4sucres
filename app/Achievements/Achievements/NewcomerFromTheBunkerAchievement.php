<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewcomerFromTheBunkerAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Bunkered';
    }

    public function getDescription(): string
    {
        return 'Revendique son appartenance au forum alternatif lebunker.net';
    }

    public function getImage(): string
    {
        return 'lebunker.png';
    }
    
    public function isRare(): bool
    {
        return false;
    }
}
