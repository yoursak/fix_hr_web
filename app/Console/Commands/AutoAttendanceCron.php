<?php

namespace App\Console\Commands;

use App\Helpers\MasterRulesManagement\RulesManagement;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Http\Controllers\CronJobManagement\AutoAttendanceJobSchedular;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AttendanceList;
use App\Models\PolicyHolidayDetail;
use App\Models\AttendanceHolidayList;
// use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Session;
use DB;



class AutoAttendanceCron extends Command
{

    protected $signature = 'command:autoAttendanceCron';
    protected $description = 'Auto Attendance Cron Activated Executed successfully';

    public function handle()
    {


        \Log::info("Auto Attendance Cron Activated execution!");
        // Create By JAY  ON PROJECT BACKGROUND Working 
        //Monthly Stack upload data's at attendance list any typeof holidays details
        $currentDate = Carbon::now()->format('Y-m-d');
        $targetDate = $currentDate; // YYYY-MM-DD
        // '2023-12-25'; //daily Checking Day's
        $loaded = PolicyHolidayDetail::where('holiday_date', date('Y-m-d', strtotime($targetDate)))->get();
        if ($loaded->isNotEmpty()) {
            foreach ($loaded as $item) {
                // Assuming PolicyHolidayDetail model has a relationship named 'template'
                $load = $item->template;

                if ($load) {
                    AttendanceHolidayList::create([
                        'business_id' => $item->business_id,
                        'name' => $item->holiday_name,
                        'day' => $item->day,
                        'holiday_date' => $item->holiday_date,
                        'from_start' => $load->temp_from,
                        'to_end' => $load->temp_to
                    ]);
                }
            }
        }
        print_r($loaded);

        $this->info("Current Monthly Data insert");



        // $loaded = DB::table('policy_holiday_details')->whereYear('holiday_date', $currentYear)->get();
        // print_r($loaded);
        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;
        // Replace '2023-12-25' with your specific date in the desired format
        // $currentDate = Carbon::now()->format('Y-m-d');
        // $nextDate = Carbon::now()->addDay()->format('Y-m-d');
        // $targetDate = '2023-11-28'; // YYYY-MM-DD

        // if ($currentDate === $targetDate || $nextDate === $targetDate) {
        //     $loads = '2023-12-25';
        //     $holidayUploadData = DB::table('policy_holiday_details')
        //         ->where('holiday_date', date('Y-m-d', strtotime($loads)))
        //         ->get();

        //     foreach ($holidayUploadData as $item) {
        //         print_r($item);
        //         $this->info("Holiday found on: ");
        //         // Process other information from $item if needed
        //         // $this->info("Current date or next date matches the target date! '.$item.'");

        //     }
        // } else {
        //     $this->info("Condition not met.");
        // }

        $this->info('command:autoAttendanceCron Auto Attendance Cron is working fine!');
        return Command::SUCCESS;
    }
}
