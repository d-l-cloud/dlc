<?php

namespace App\Console;

use App\Http\Controllers\Admin\Shop\AProductCategory;
use Illuminate\Console\Scheduling\Schedule;
//use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Gecche\Multidomain\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //$schedule->command('dlcloud:sendFormEmail')->withoutOverlapping();
        $currentDomain = app()->domain();
        $schedule->command('scout:flush "App\Models\Shop\ProductList" --domain='.$currentDomain)->withoutOverlapping();
        $schedule->command('scout:import "App\Models\Shop\ProductList" --domain='.$currentDomain)->withoutOverlapping();
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
