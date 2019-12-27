<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class ContributorAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'Contributeur';
    }

    public function getDescription(): string
    {
        return 'Pour avoir contribué au code source de 4sucres.org';
    }

    public function getImage(): string
    {
        return 'contributor.png';
    }
}
