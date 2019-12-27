<?php

use App\Achievements\AchievementManager;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $manager = new AchievementManager();
        foreach (AchievementManager::AVAILABLE_ACHIEVEMENTS as $achievement) {
            $achievement = $manager->getAchievement($achievement);
            Achievement::updateOrCreate(
            [
                'code'        => $achievement->getClassName(),
            ], [
                'name'        => $achievement->getName(),
                'image'       => $achievement->getImage(),
                'description' => $achievement->getDescription(),
            ]);
        }
    }
}
