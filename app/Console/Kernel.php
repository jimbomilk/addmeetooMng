<?php

namespace App\Console;

use App\location;
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
        Commands\LocationUpdate::class,
        Commands\LocationSchedule::class
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

        // Creamos una tarea para cada location
        $locations = Location::all();
        foreach ($locations as $location)
        {
            $schedule->command('location_schedule '.$location->id)
                     ->everyMinute();
                     //->withoutOverlapping();

            $schedule->command('location_update '.$location->id)
                ->dailyAt('16:12');
                //->dailyAt('06:00');
        }

    }
}
