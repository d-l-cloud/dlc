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
        $schedule->command('getdata:dltocloud')->withoutOverlapping()->dailyAt('01:54');
        $schedule->command('dlcloud:sendFormEmail')->withoutOverlapping()->everyMinute();
        $schedule->command('scout:flush "App\Models\Shop\ProductList"')->everyFiveMinutes();
        /* $schedule->command('scout:import "App\Models\Shop\ProductList"')->withoutOverlapping()->everyFiveMinutes();
        $schedule->command('scout:flush "App\Models\Shop\ProductList" --domain=doorlock52.ru')->withoutOverlapping()->everyFiveMinutes();
        $schedule->command('scout:import "App\Models\Shop\ProductList" --domain=doorlock52.ru')->withoutOverlapping()->everyMinute();*/
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
