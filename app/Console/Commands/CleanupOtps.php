<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanupOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cleanupOtp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Otp Clean otp on time ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // DB::table('login_admin')->where('otp_created_at', '<', now())->update(['otp' => '']);
        // Calculate the timestamp for 2 minutes ago
        // Calculate the timestamp for 2 minutes ago
        $twoMinutesAgo = Carbon::now()->subMinutes(2);

        // Update records where OTP was sent 2 minutes ago or earlier
        DB::table('login_admin')
            ->where('otp_sent_at', '<=', $twoMinutesAgo)
            ->update(['otp' => null]);
        $this->info('Expired OTPs have been deleted.');

        return Command::SUCCESS;
    }
}
