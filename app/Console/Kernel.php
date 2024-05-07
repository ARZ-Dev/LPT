<?php

namespace App\Console;

use App\Http\Controllers\CronJobController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $beforeLastMonthDay = now()->endOfMonth()->subDay()->day;

        $schedule->call(function () {
            (new CronJobController())->closeMonthReminder();
        })->monthlyOn($beforeLastMonthDay);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
