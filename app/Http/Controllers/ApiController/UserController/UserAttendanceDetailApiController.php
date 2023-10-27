<?php

namespace App\Http\Controllers\ApiController\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceIdToDataResources;
use App\Helpers\ReturnHelpers;
use Carbon\Carbon;

class UserAttendanceDetailApiController extends Controller
{
    // ByDefault Attendace show and select month
    public function attendanceDetail(Request $request)
    {
        $emp = $request->emp_id;
        $business = $request->business_id;
        // SELECT DATE
        $selectDate = $request->selectDate ? Carbon::parse($request->selectDate) : '';
        $selectYearToCheck = $selectDate ? $selectDate->format('Y') : '';
        $selectMonthToCheck = $selectDate ? $selectDate->format('m') : '';
        // CURRENT DATE
        $currentDate = Carbon::now();
        $currentYearToCheck = $currentDate->format('Y');
        $currentMonthToCheck = $currentDate->format('m');
        if ($selectDate == '' && $emp != null && $business != null) {
            $attendanceDataExists = DB::table('attendance_list')
                ->whereYear('punch_date', $currentYearToCheck)
                ->whereMonth('punch_date', $currentMonthToCheck)
                ->where('emp_id', $emp)
                ->where('business_id', $business)
                ->get();
            if ($attendanceDataExists && count($attendanceDataExists) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($attendanceDataExists)->all(), '1');
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 200);
            }
        } elseif (isset($selectDate) && $emp != null && $business != null) {
            $attendanceDataExists = DB::table('attendance_list')
                ->where('emp_id', $emp)
                ->where('business_id', $business)
                ->whereYear('punch_date', $selectYearToCheck)
                ->whereMonth('punch_date', $selectMonthToCheck)
                ->get();
            if ($attendanceDataExists && count($attendanceDataExists) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($attendanceDataExists)->all(), '2');
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 200);
            }
        } else {
            return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 404);
        }
    }

    // select particular record 
    public function filterAttenDetail(Request $request)
    {
        $id = $request->id;
        $emp = $request->emp_id;
        $business = $request->business_id;
        if ($id != null && $emp != null && $business != null && $id != '' && $emp != '' && $business != '') {
            $checkingData = DB::table('attendance_list')
                ->where('id', $id)
                ->where('business_id', $business)
                ->where('emp_id', $emp)
                ->get();
            if (isset($checkingData) && count($checkingData) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($checkingData)->all(), 1);
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 2, 'status' => true], 200);
            }
        }
        return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 2, 'status' => true], 404);
    }  
}
