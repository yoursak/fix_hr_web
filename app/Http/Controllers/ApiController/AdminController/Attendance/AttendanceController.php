<?php

namespace App\Http\Controllers\ApiController\AdminController\Attendance;

use App\Http\Resources\Api\AdminSideResponse\Attendance\AttendanceListResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Models\admin\Business_categories_list;
use App\Models\admin\Business_type;
use App\Models\admin\AttendanceList;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;
use App\Models\Migration;
use DateTime;
use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// API BY ATTENDANCE SECTION
class AttendanceController extends BaseController
{
    // business_id call by -> admin/attendance_list/b_id
    public function allAttendanceList($businessID)
    {
        $formattedData = AttendanceListResource::collection(DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
            ->get());

        if ($formattedData) {

            return response()->json(['result' => $formattedData, 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false], 404);

    }

}