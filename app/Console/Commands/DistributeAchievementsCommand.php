<?php

namespace App\Console\Commands;

use App\Achievements\AchievementManager;
use App\Models\User;
use Illuminate\Console\Command;

class DistributeAchievementsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'achievements:distribute';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        $achievementManager = new AchievementManager();

        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $achievementManager->probe($user);
            $bar->advance();
        }

        $bar->finish();
    }
}
