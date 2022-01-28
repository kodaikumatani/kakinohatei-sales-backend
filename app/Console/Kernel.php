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
        $schedule->command('gmail:send')->hourlyAt(1)->between('10:00', '21:00');
        $schedule->command('gmail:send')->hourlyAt(15)->between('10:00', '21:00');
        $schedule->command('gmail:read')->hourlyAt(5)->between('10:00', '17:00');
        $schedule->command('gmail:read')->hourlyAt(20)->between('10:00', '17:00');
        $schedule->command('gmail:dailyclosing')->dailyAt('13:00');
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
