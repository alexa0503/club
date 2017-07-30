<?php

namespace App\Console;

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
        Commands\OwnerVerify::class,
        Commands\PointsUpdate::class,
        Commands\SendCoupons::class,
        Commands\CarsRefund::class,
        Commands\ObtainCoupons::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('owner:verify')
        //    ->everyMinute();
        $schedule->command('send:coupons')
            ->everyMinute();
        $schedule->command('obtain:coupons')
            ->everyMinute();
        $schedule->command('cars:refund')
            ->everyMinute();
        $schedule->command('points:update')
            ->everyFiveMinutes();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
