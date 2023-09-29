<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clean otp on time ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('login_admin')->where('otp_created_at', '<', now())->update(['otp' => '']);

        $this->info('Expired OTPs have been deleted.');

        return Command::SUCCESS;
    }
}