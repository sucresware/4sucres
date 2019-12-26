<?php

namespace App\Achievements\Achievements;

use App\Achievements\AbstractAchievement;

class OpenTheDoorAchievement extends AbstractAchievement
{
    const ENABLED = true;

    const UNLOCKABLE = false;

    public function getName(): string
    {
        return '*Barnabé, ouvre la porte*';
    }

    public function getDescription(): string
    {
        return 'Pour avoir trouvé une faille critique sur 4sucres.org';
    }

    public function getImage(): string
    {
        return 'openthedoor.png';
    }
    
    public function getRarity(): bool
    {
        return true;
    }
}
