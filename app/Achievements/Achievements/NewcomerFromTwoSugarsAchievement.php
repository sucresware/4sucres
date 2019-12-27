<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewcomerFromTwoSugarsAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Ça fait 6 sucres';
    }

    public function getDescription(): string
    {
        return 'Revendique son appartenance au forum alternatif 2sucres.org';
    }

    public function getImage(): string
    {
        return '2sucres.png';
    }
}
