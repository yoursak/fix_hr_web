<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(){
        return view('admin.attendance.attendance');
    }
    public function details(){
        $model=DB::table('attendance_list')->first();
        // $in_time =$model->punch_in;
        // $out_time =$model->punch_out;
        // $time=now()->format('h:i:s A');
        // dd($time);
        $load=compact('model');
        return view('admin.attendance.emp_attendace',$load);
    }
}
