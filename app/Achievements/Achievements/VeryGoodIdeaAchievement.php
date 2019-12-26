<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class VeryGoodIdeaAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return 'C\'est une très bonne idée';
    }

    public function getDescription(): string
    {
        return 'Avoir proposé une idée d\'amélioration unique et inédite, acceptée et déployée sur 4sucres.org';
    }

    public function getImage(): string
    {
        return 'niceidea.png';
    }
    
    public function getRarity(): bool
    {
        return true;
    }
}
