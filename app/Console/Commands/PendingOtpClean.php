<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class PendingOtpClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendingotp:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('pending_admins')->where('created_at', '<', now())->delete();//update(['otp' => '']);

        $this->info('Expired Pending OTPs have been deleted.');

        return Command::SUCCESS;
    }
}
