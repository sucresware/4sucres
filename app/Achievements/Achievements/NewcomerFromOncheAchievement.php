<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class NewcomerFromOncheAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Tu veux du ponche ?';
    }

    public function getDescription(): string
    {
        return 'Revendique son appartenance au forum alternatif onche.party';
    }

    public function getImage(): string
    {
        return 'onche.png';
    }
}
