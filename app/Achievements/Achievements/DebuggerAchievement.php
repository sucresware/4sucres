<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class DebuggerAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Debugger';
    }

    public function getDescription(): string
    {
        return 'Avoir découvert un bug sur 4sucres.org';
    }

    public function getImage(): string
    {
        return 'debugger.png';
    }
    
    public function isRare(): bool
    {
        return false;
    }
}
