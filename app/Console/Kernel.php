<?php

namespace App\Console;

use App\Jobs\GenerateDemands;
use App\Jobs\InsertDemandJob;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('user:add')->everyMinute();
        // $schedule->command('terminal:print-message')->everyMinute();

        // $schedule->command('script:run')->everyMinute();

        // $schedule->command('demands:create')->monthlyOn(Carbon::now()->endOfMonth()->day, '00:00');
        // $schedule->job(new InsertDemandJob())->dailyAt('00:00');
        // $schedule->command('demands:create')->monthlyOn(1, '00:00');
        
        // $schedule->job(new GenerateDemands())->lastDayOfMonth()->at('12:56');
        // $schedule->job(new GenerateDemands())->daily('12:00');
        $schedule->job(new GenerateDemands())->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // require base_path('/public/text.php');

        
    }
}
