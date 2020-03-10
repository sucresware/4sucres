<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewcomerFromHelloChrismasAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Noëliste';
    }

    public function getDescription(): string
    {
        return 'Revendique son appartenance au forum alternatif avenoel.org';
    }

    public function getImage(): string
    {
        return 'ave.png';
    }

    public function isRare(): bool
    {
        return false;
    }
}
