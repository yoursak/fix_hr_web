<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Setting;

use App\Helpers\Central_unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestLeaveList;
use App\Models\StaticLeaveShiftType;
use App\Models\StaticRequestLeaveType;
use App\Models\PolicySettingLeavePolicy;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\UserSideResponse\LeaveRequestResources;
use DB;
use App\Http\Resources\Api\UserSideResponse\StaticLeaveShiftTypeResources;
use App\Http\Resources\Api\UserSideResponse\LeaveCategoryResources;
use App\Http\Resources\Api\UserSideResponse\StaticRequestLeaveTypeResources;
use App\Http\Resources\Api\UserSideResponse\UserLeaveIdToDataResources;
use App\Http\Resources\Api\UserSideResponse\CurrentLeaveRequestStatus;
use App\Http\Resources\Api\UserSideResponse\PolicyHolidayListResource;
use Carbon\Carbon;
use App\models\PolicyMasterEndgameMethod;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicyHolidayDetail;

class SettingUserApiController extends Controller
{


    public function policyHolidayDataList(Request $request)
    {
        $EmpID = $request->emp_id;
        $business_id = $request->business_id;
        $FindMonthYear = $request->date;

        if ($EmpID != null && $business_id != null && $FindMonthYear != null) {
            // $requestDate = Carbon::createFromFormat('d-m-Y', $date);
            $emp = DB::table('employee_personal_details')
                ->join('policy_master_endgame_method', 'policy_master_endgame_method.id', '=', 'employee_personal_details.master_endgame_id')
                ->where('employee_personal_details.emp_id', $EmpID)
                ->where('policy_master_endgame_method.business_id', $business_id)
                ->where('policy_master_endgame_method.business_id', $business_id)
                ->where('policy_master_endgame_method.method_switch', 1)
                ->select('policy_master_endgame_method.business_id as bid', 'policy_master_endgame_method.holiday_policy_ids_list as holiday_id')
                ->first();

            if ($emp) {
                $holidayListQuery = PolicyHolidayDetail::where('business_id', $emp->bid)
                    ->where('template_id', $emp->holiday_id);
                if (!empty($FindMonthYear) && !empty($EmpID) && strlen($FindMonthYear) === 4) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $holidayListQuery->whereYear('holiday_date', $year);
                }
                $holidayList = $holidayListQuery->select('holiday_id', 'holiday_name', 'day', 'holiday_date')->get();

                if (count($holidayList) != 0) {
                    return response()->json(['result' => PolicyHolidayListResource::collection($holidayList)->all(), 'case' => 1, 'status' => true], 200);
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the employee leave request record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }
    }
}
