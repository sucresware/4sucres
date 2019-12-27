<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class GoodIdeaAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'C\'est une bonne idée';
    }

    public function getDescription(): string
    {
        return 'Avoir proposé une idée d\'amélioration, acceptée et déployée sur 4sucres.org';
    }

    public function getImage(): string
    {
        return 'idea.png';
    }
}
