<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Session;
use App\Models\AttendanceList;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\LoginEmployee;
use App\Models\EmployeePersonalDetail;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    protected $commands = [
        // \App\Console\Commands\AutoMonthlyLeaveBalance::class,
        \App\Console\Commands\NotificationAlert::class,
        \App\Console\Commands\AutoAttendanceCron::class,
        // \App\Console\Commands\CleanupOtps::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     // Calculate the timestamp for 5 minutes ago
        //     $twoMinutesAgo = Carbon::now()->subMinutes(5);

        //     // Update records where OTP was sent 5 minutes ago or earlier
        //     DB::table('login_admin')
        //         ->where('otp_sent_at', '<=', $twoMinutesAgo)
        //         ->update(['otp' => null]);
        // })->everyMinute();

        // $schedule->command('command:autoMonthlyLeaveBalanceCron')->daily();
        // ->monthlyOn(Carbon::now()->endOfMonth()->format('d'), '23:59');
        // $schedule->command('command:notificationAlert')->everyMinute();
        $schedule->command('command:autoAttendanceCron')->daily();
        $schedule->command('command:notificationAlert')->everyMinute();
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
