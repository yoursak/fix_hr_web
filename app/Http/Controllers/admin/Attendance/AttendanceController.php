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
    public function details(Request $request){
        // dd($request->emp_id);
        $model=DB::table('attendance_list')->where('emp_id',$request->emp_id)->first();
        $load=compact('model');
        return view('admin.attendance.emp_attendace',$load);
    }
}
