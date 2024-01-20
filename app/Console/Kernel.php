<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('hello:world')
        // ->everyMinute()
        // ->timezone('Asia/Baghdad');
        // php artisan orders:delete-returned
        //php artisan reviews:delete-old
        $schedule->command('orders:delete-returned')->daily()->timezone('Asia/Baghdad');
        $schedule->command('reviews:delete-old')->daily()->timezone('Asia/Baghdad');

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
