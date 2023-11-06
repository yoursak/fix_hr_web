<?php

namespace App\Http\Controllers\ApiController\ApiAdminController\Employee;

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

// use Session;
class EmployeeController extends BaseController
{
    public function branchList($request)
    {
        return ApiResponse::allBranch($request);

        // return response()->json(['result' => $request->all()]);
    }
    public function departmentList($request)
    {
        return ApiResponse::branchtoallDepartment($request);
    }

    public function employeeList(Request $request)
    {
        $query = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id');

        // Check for filter criteria and add WHERE clauses
        if ($request->has('branch_id') && $request->branch_id !== null) {
            $query->where('employee_personal_details.branch_id', '=', $request->branch_id);
        }
        
        if ($request->has('department_id') && $request->department_id !== null) {
            $query->where('employee_personal_details.department_id', '=', $request->department_id);
        }
        
        if ($request->has('business_id') && $request->business_id !== null) {
            $query->where('employee_personal_details.business_id', '=', $request->business_id);
        }

        // Execute the query and get the results
        $employees = $query->get();

        // Check if there are any results
        if ($employees->isEmpty()) {
            return response()->json(['success' => false, 'msg' => 'No employees found'], 401);
        }

        // Return the filtered employees
        // return response()->json(['success' => true, 'data' => $employees], 200);
        // EmployeeResource::collection($emp)

        return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($employees));
        // return response()->json(['success' => true, 'data' => $request->all()], 200);
    }
    public function attendence(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required',
            'business_id' => 'required',
            'branch_id' => 'required',
            'mode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required'
        ]);
        // Assuming mode is an integer

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Check if mode is 1 (in Office with QRScanner)
        if ($request->mode == 1) {
            // Get today's date once
            $today = now()->toDateString();

            // Find the latest attendance record for today by the same employee
            $latestRecord = DB::table('attendance_list')
                ->where('emp_id', $request->input('emp_id'))
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->first();

            $empInfo = DB::table('employee_personal_details')->where('emp_id', $request->input('emp_id'))->first();
            if (!$latestRecord) {
                // If no record exists for today, it's the first action of the day, so mark punch_in
                $attendanceData = [
                    'emp_id' => $request->input('emp_id'),
                    'emp_today_current_status' => 'punch_in',
                    'punch_in' => 1,
                    'emp_name' => $empInfo->emp_name,
                    'business_id' => $request->business_id,
                    'branch_id' => $request->branch_id,
                    'punch_in_latitude' => $request->latitude,
                    'punch_in_longitude' => $request->longitude,
                    'punch_in_address' => $request->address,
                    'punch_in_time' => now(),
                    'working_from_mode' => 'Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('attendance_list')->insert($attendanceData);
                return response()->json(['message' => 'Punch-in marked successfully', 'punchIn' => '1'], 200);
            } else {
                if ($latestRecord->emp_today_current_status === 'punch_in') {
                    // If the latest action was punch_in, mark punch_out and calculate working hours
                    $punchInTime = Carbon::parse($latestRecord->punch_in_time);
                    $punchOutTime = now();

                    // Calculate the difference in minutes and then convert it to decimal hours
                    $minutesDifference = $punchInTime->diffInMinutes($punchOutTime);
                    $workingHours = round($minutesDifference / 60, 2); // Convert minutes to decimal hours with 2 decimal places

                    // Update the total working hours by adding the working hours for this punch-out action
                    $totalWorkingHours = $latestRecord->total_working_hour + $workingHours;

                    DB::table('attendance_list')
                        ->where('id', $latestRecord->id)
                        ->update([
                            'emp_today_current_status' => 'punch_out',
                            'punch_out' => 1,
                            'punch_out_latitude' => $request->latitude,
                            'punch_out_longitude' => $request->longitude,
                            'punch_out_address' => $request->address,
                            'working_from_mode' => 'Office',
                            'punch_out_time' => $punchOutTime,
                            'total_working_hour' => $totalWorkingHours,
                            'updated_at' => now(),
                        ]);
                    // Update the total working hours

                    return response()->json(['message' => 'Punch-out marked successfully', 'punchOut' => '1'], 200);
                } else {
                    // If the latest action was punch_out or the same action is repeated, return an error
                    $todays_punched_done = DB::table('attendance_list')->where('emp_id', $request->emp_id)->where('created_at', now())->first();

                    // if (isset($todays_punched_done)) {

                    // }
                    return response()->json(['message' => 'Todays Punching Complete', 'complete' => 1], 200);

                    // return response()->json(['message' => 'Invalid action sequence'], 400);
                }
            }
        } else {
            // If mode is not 1, return an error
            return response()->json(['message' => 'Invalid mode'], 400);
        }
    }
    public function nameBrand(Request $request)
    {
        $value = DB::table('brand_list')->where('brand_id', $request->brand_id)->first();
        return response()->json(["result" => $value]);
    }
    public function nameTotalBrand(Request $request)
    {
        $value = DB::table('brand_list')->where('business_id', $request->business_id)->get();
        return response()->json(["result" => $value]);
    }

}