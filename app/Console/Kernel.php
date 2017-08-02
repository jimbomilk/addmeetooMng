<?php

namespace App\Console;

use App\Location;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendScreen::class,
        Commands\LocationSchedule::class,
        Commands\SendMessage::class
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

        //Limpiamos la tabla de jobs

        // Creamos una tarea para cada location
        if (Schema::hasTable('locations')) {
            $locations = Location::all();
            foreach ($locations as $location)
            {
                $schedule->command('location_schedule '.$location->id)
                    ->everyMinute();

                $schedule->command('screen '.$location->id)
                    ->everyMinute();

                $schedule->command('message '.$location->id)
                    ->everyMinute();
            }
        }

    }
}
