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
        Commands\SendLevels::class,
        Commands\RegisterMembers::class,
        Commands\MembersExport::class,
        Commands\PointsCancel::class,
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
            ->dailyAt('01:00');
        $schedule->command('points:update')
            ->dailyAt('03:00');
        $schedule->command('points:update')
            ->dailyAt('02:00');
        $schedule->command('points:cancel')
            ->dailyAt('04:00');
        /*
        $count = \App\Verify::count();
        $n = ceil($count/10000);
        for ($i=0; $i < $n ; $i++) {
            $schedule->command('points:update '.$i)
                ->dailyAt('03:'.(10+$i));
        }
        */

        $schedule->command('send:levels')
            ->dailyAt('00:00');

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
