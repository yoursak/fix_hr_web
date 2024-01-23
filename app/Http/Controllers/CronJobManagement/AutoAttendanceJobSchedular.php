<?php

namespace App\Http\Controllers\CronJobManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use App\Helpers\MasterRulesManagement\RulesManagement;


class AutoAttendanceJobSchedular extends Controller
{

    public static  $load;
    public function __construct()
    {
        $businessId = Session::get('business_id');
        $laod = DB::table('login_admin')->where('business_id', $businessId)->first();
        self::$load='sdf';
    }

    public static function root()
    {
        $kite=self::$load;
       
        // \Log::info("Auto Attendance Cron Activated execution!");
        print_r($kite);
    }
    public function AutoAttendanceCall()
    {  $getDay = RulesManagement::TodayStatus()[1];
        $loaded = DB::table('testing_mode')->insert(['count_value' => $getDay]);
    }
}
