<?php

namespace App\Http\Controllers\ApiController\ApiAdminController\Attendance;

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

// use Carbon;

// API BY ATTENDANCE SECTION
class AttendanceController extends BaseController
{


    public function getTodayAttendanceList(Request $request)
    {
        $businessID = $request->business_id;
        $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        $preview = DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->where(function ($query) use ($date) {
                if (!empty($date)) {
                    $query->whereDate('attendance_list.punch_date', $date); // Use whereDate to compare the full date
                }
            })
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
            ->orderby('attendance_list.id', 'desc')
            ->get();

        $formattedData = AttendanceListResource::collection($preview);

        if ($formattedData) {

            return response()->json(['result' => $formattedData, 'status' => true],200);
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    // business_id call by -> admin/attendance_list/b_id //filters
    public function allAttendanceList(Request $request)
    {
        $businessID = $request->business_id;
        $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        $FindMonthYear = $request->find_year_month; //like 2023-11
        $EmpID = $request->emp_id;
        // calculate present, absent, halfday, holiday, weekoff;

        $preview = DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->where(function ($query) use ($date, $FindMonthYear, $EmpID) {

                if (!empty($date)) {
                    $query->whereDate('attendance_list.punch_date', $date); // Use whereDate to compare the full date
                }
                if ((!empty($FindMonthYear)) && (!empty($EmpID))) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                    $query->where('attendance_list.emp_id', $EmpID)->whereYear('attendance_list.punch_date', $year)->whereMonth('attendance_list.punch_date', $month);
                }
            })
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
            ->orderby('attendance_list.id', 'desc')
            ->get();

        $formattedData = AttendanceListResource::collection($preview);

        if ($formattedData) {

            return response()->json(['result' => $formattedData, 'status' => true],200);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }
    public function allEmployeePersonalData(Request $request)
    {
        $businessID = $request->business_id;
        $FindMonthYear = $request->find_year_month; //like 2023-11
        $EmpID = $request->emp_id;

        $preview = DB::table('attendance_list')
            ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->where(function ($query) use ($FindMonthYear, $EmpID) {
                if ((!empty($FindMonthYear)) && (!empty($EmpID))) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                    $query->where('attendance_list.emp_id', $EmpID)->whereYear('attendance_list.punch_date', $year)->whereMonth('attendance_list.punch_date', $month);
                }
            })
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
            ->orderby('attendance_list.id', 'desc')
            ->get();

        $formattedData = AttendanceListResource::collection($preview);


        if ($formattedData) {
            $collectionDashboardShow = ['Present' => 5, 'Absent' => 0, 'Half Days' => 0, 'Weekly Off' => 0, 'Leave' => 0, 'Overtime' => 0, 'Miss Punch' => 0, 'Late In' => 0];
            return response()->json(['dashboard' => $collectionDashboardShow, 'result' => $formattedData, 'status' => true], 200);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }
}
