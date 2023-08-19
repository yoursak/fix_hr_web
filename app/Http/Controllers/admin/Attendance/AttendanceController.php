<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(){
        return view('admin.attendance.attendance');
    }
    public function details(){
        return view('admin.attendance.emp_attendace');
    }
}
