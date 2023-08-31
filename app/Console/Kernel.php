<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     // $schedule->command('inspire')->hourly();
    // }

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Calculate the timestamp for 2 minutes ago
            $twoMinutesAgo = Carbon::now()->subMinutes(1);
    
            // Update records older than 2 minutes to have a null OTP
            DB::table('login_admin')
                ->where('otp', '!=', null)
                ->where('created_at', '<=', $twoMinutesAgo)
                ->update(['otp' => null]);
        })->everyMinute();

        $schedule->command('field:update-null')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
