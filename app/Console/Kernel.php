<?php

namespace App\Console;

use App\Console\Commands\DistributeAchievementsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DistributeAchievementsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command('queue:work --tries=3 --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule
            ->command('backup:clean')
            ->daily();

        $schedule
            ->command('backup:run')
            ->cron('0 */2 * * *');

        $schedule
            ->command('achievements:distribute')
            ->twiceDaily(11, 23)
            ->withoutOverlapping();

        // $schedule
        //     ->command('ban:delete-expired')
        //     ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
