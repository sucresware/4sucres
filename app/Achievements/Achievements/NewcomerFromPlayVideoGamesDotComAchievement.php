<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewcomerFromPlayVideoGamesDotComAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'ISSOU !';
    }

    public function getDescription(): string
    {
        return 'Revendique son appartenance au forum jeuxvideo.com';
    }

    public function getImage(): string
    {
        return 'jvc.png';
    }
    
    public function getRarity(): bool
    {
        return false;
    }
}
