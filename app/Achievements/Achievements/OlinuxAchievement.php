<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class OlinuxAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'QUOI ?!';
    }

    public function getDescription(): string
    {
        return 'A été (est toujours ?) un proche d\'Olinux';
    }

    public function getImage(): string
    {
        return 'olinux.png';
    }
    
    public function isRare(): bool
    {
        return true;
    }
}
