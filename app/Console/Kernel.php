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
        $currentDomain = app()->domain();
        //$schedule->command('getdata:dltocloud --domain=doorlock52.ru')->withoutOverlapping();
        if ($currentDomain==''){
            $schedule->command('getdata:dltocloud')->dailyAt('22:05')->withoutOverlapping();
        } elseif ($currentDomain=='doorlock52.ru'){
            $schedule->command('getdata:dltocloud')->dailyAt('22:13')->withoutOverlapping();
        }elseif ($currentDomain=='doorlock66.ru'){
            $schedule->command('getdata:dltocloud')->dailyAt('22:15')->withoutOverlapping();
        }elseif ($currentDomain=='doorlock42.ru'){
            $schedule->command('getdata:dltocloud')->dailyAt('22:17')->withoutOverlapping();
        }else {}
        $schedule->command('dlcloud:sendFormEmail')->withoutOverlapping();
        $schedule->command('scout:flush "App\Models\Shop\ProductList"')->withoutOverlapping();
        $schedule->command('scout:import "App\Models\Shop\ProductList"')->withoutOverlapping();
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
