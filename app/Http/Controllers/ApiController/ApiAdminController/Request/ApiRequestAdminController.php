<?php

namespace App\Http\Controllers\ApiController\ApiAdminController\Request;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use DateTime;
use App\Mail\AuthMailer;
use Illuminate\Support\Facades\Mail;
use App\Models\LoginAdmin;
use App\Models\admin\CameraPermissionModel;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AdminLoginResource;
use App\Http\Resources\Api\CameraPermission;
use App\Models\employee\EmployeePersonalDetail;
// use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\AdminSideResponse\Employee\EmployeeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\AdminSideResponse\Request\RequestResource;
use App\Http\Resources\Api\AdminSideResponse\Request\RequestMispunchResource;


// use Session;
class ApiRequestAdminController extends BaseController
{
    public function allRequestLeaveList(Request $request)
    {
        $businessID = $request->business_id;
        $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        $FindMonthYear = $request->find_year_month; //like 2023-11
        $EmpID = $request->emp_id;
        // calculate present, absent, halfday, holiday, weekoff;

        $preview = DB::table('request_leave_list')
            ->join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_leave_list.business_id', $businessID)
            ->where(function ($query) use ($date, $FindMonthYear, $EmpID) {

                if (!empty($date)) {
                    $query->whereDate('request_leave_list.from_date', $date); // Use whereDate to compare the full date
                }
                if ((!empty($FindMonthYear)) && (!empty($EmpID))) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                    $query->where('request_leave_list.emp_id', $EmpID)->whereYear('request_leave_list.from_date', $year)->whereMonth('request_leave_list.from_date', $month);
                }
            })
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'request_leave_list.*')
            ->orderby('request_leave_list.id', 'desc')
            ->get();

        // return $preview;
        $formattedData = RequestResource::collection($preview);
        if ($formattedData) {
            return response()->json(['result' => $formattedData, 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }
    public function allRequestMissPunchList(Request $request)
    {
        $businessID = $request->business_id;
        $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        $FindMonthYear = $request->find_year_month; //like 2023-11
        $EmpID = $request->emp_id;
        // calculate present, absent, halfday, holiday, weekoff;

        $preview = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_mispunch_list.business_id', $businessID)
            ->where(function ($query) use ($date, $FindMonthYear, $EmpID) {

                if (!empty($date)) {
                    $query->whereDate('request_mispunch_list.emp_miss_date', $date); // Use whereDate to compare the full date
                }
                if ((!empty($FindMonthYear)) && (!empty($EmpID))) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                    $query->where('request_mispunch_list.emp_id', $EmpID)->whereYear('request_mispunch_list.emp_miss_date', $year)->whereMonth('request_mispunch_list.emp_miss_date', $month);
                }
            })
            ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'request_mispunch_list.*')
            ->orderby('request_mispunch_list.id', 'desc')
            ->get();

        // return $preview;
        $formattedData = RequestMispunchResource::collection($preview);
        if ($formattedData) {
            return response()->json(['result' => $formattedData, 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    // public function employeeList(Request $request)
    // {
    //     $query = DB::table('employee_personal_details')
    //         ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
    //         ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
    //         ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id');

    //     // Check for filter criteria and add WHERE clauses
    //     if ($request->has('branch_id') && $request->branch_id !== null) {
    //         $query->where('employee_personal_details.branch_id', '=', $request->branch_id);
    //     }

    //     if ($request->has('department_id') && $request->department_id !== null) {
    //         $query->where('employee_personal_details.department_id', '=', $request->department_id);
    //     }

    //     if ($request->has('business_id') && $request->business_id !== null) {
    //         $query->where('employee_personal_details.business_id', '=', $request->business_id);
    //     }

    //     // Execute the query and get the results
    //     $employees = $query->get();

    //     // Check if there are any results
    //     if ($employees->isEmpty()) {
    //         return response()->json(['success' => false, 'msg' => 'No employees found'], 401);
    //     }

    //     // Return the filtered employees
    //     // return response()->json(['success' => true, 'data' => $employees], 200);
    //     // EmployeeResource::collection($emp)

    //     return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($employees));
    //     // return response()->json(['success' => true, 'data' => $request->all()], 200);
    // }


    // 

}
