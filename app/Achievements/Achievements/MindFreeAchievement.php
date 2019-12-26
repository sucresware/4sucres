<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class MindFreeAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Esprit libre';
    }

    public function getDescription(): string
    {
        return 'Avoir fait le choix de l\'indépendance lors de son inscription';
    }

    public function getImage(): string
    {
        return 'beta.png';
    }
    
    public function getRarity(): bool
    {
        return false;
    }
}
