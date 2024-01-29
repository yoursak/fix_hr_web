<?php

namespace App\Console\Commands;

use App\Helpers\MasterRulesManagement\RulesManagement;
use Illuminate\Console\Command;

use Carbon\Carbon;

class AutoMonthlyLeaveBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:autoMonthlyLeaveBalanceCron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Monthly Leave Balance Cron Activate Executed successfully';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Auto  Monthly Leave Balance Cron Activated execution!");
        // $today = Carbon::parse('2023-12-12'); //Carbon::now();
        // $lastDayOfMonth = Carbon::parse('2023-12-12'); // ->endOfMonth();
        // if ($today->isSameDay($lastDayOfMonth)) {
        //     print_r("Today is the last day of the month");
        //     RulesManagement::UploadReport($today);
        //     $this->info("Current  Monthly Leave Balance Data insert Ok");
        // } else {
        //     print_r("Today is not the last day of the month");
        //     $this->info("Current  Monthly Leave Balance Not Data insert !");

        //     // dd('Today is not the last day of the month');
        // }


        return Command::SUCCESS;
    }
}
