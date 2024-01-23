<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

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

use Carbon\Carbon;

use App\Models\ApprovalManagementCycle;

class LeaveRequestApiController extends Controller
{
    public function index()
    {
        $leave = LeaveRequestList::all();
        return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection($leave)->all());
    }

    // static table shift type
    public function staticLeaveShiftType()
    {
        $data = StaticLeaveShiftType::get();
        return ReturnHelpers::jsonApiReturn(StaticLeaveShiftTypeResources::collection($data)->all());
    }

    // static table requestLeaveType
    public function staticRequestLeaveType()
    {
        $data = StaticRequestLeaveType::get();
        return ReturnHelpers::jsonApiReturn(StaticRequestLeaveTypeResources::collection($data)->all());
    }

    // dynamic custome leave category
    public function policySettingLeaveCategory(Request $request)
    {
        $business = $request->business_id;
        $data = DB::table('policy_setting_leave_policy')
            ->join('policy_setting_leave_category', 'policy_setting_leave_category.leave_policy_id', '=', 'policy_setting_leave_policy.id')
            ->where('policy_setting_leave_category.business_id', '=', $business)
            ->where('policy_setting_leave_policy.business_id', '=', $business)
            ->select('policy_setting_leave_category.*')
            ->get();
        if ($data) {
            return ReturnHelpers::jsonApiReturn(LeaveCategoryResources::collection($data)->all()); // case 1 when the gatepass date find
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        $load = 0;

        if (isset($emp)) {
            // why type = 2 leave for  using approval system checking actived
            $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $emp->business_id)
                ->where('approval_type_id', 2)
                ->first();
            if ($approvalManagementCycle != null) {
                $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

                // Get the first index value of role_id
                $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

                // Get the last index value of role_id
                $lastRoleId = end($roleIds); // Get the last value of the array

                // $load = $approvalManagementCycle->cycle_type;
                // dd($firstRoleId, $lastRoleId);
            }

            $empData = [
                'empID' => $emp->emp_id,
                'businessID' => $emp->business_id,
                'fullOrHafDay' => $request->leave_type,
                'leaveID' => $request->leave_category,
                'shift' => $request->shift_type,
                'from' => $request->from_date,
                'to' => $request->to_date,
                'day' => $request->days,
            ];

            $leaveCalculation = Central_unit::calculateLeaveCountApi($empData);

            // dd($leaveCalculation);
            // else {
            //     $load = 2; //default
            // }
            $leave = new RequestLeaveList();
            $leave->business_id = $emp->business_id;
            $leave->emp_id = $emp->emp_id;
            $leave->emp_mobile_no = $emp->emp_mobile_number;
            $leave->leave_type = $request->leave_type;
            $leave->leave_category = $request->leave_category != null ? $request->leave_category : '0';
            $leave->shift_type = $request->shift_type != null ? $request->shift_type : '0';
            $leave->from_date = $request->from_date;
            $leave->to_date = $request->to_date;
            $leave->days = $request->days;
            $leave->reason = $request->reason;
            $leave->forward_by_role_id = $firstRoleId ?? 0;
            $leave->forward_by_status = 0;
            $leave->final_level_role_id = $lastRoleId ?? 0;
            $leave->final_status = 0;
            $leave->process_complete = 0;
            $leave->final_status = 0;
            // $leave->runtime_cycle_update = $load; //$approvalManagementCycle->cycle_type;

            if ($leave->save()) {
                // $empData = [
                //     'empID' => $emp->emp_id,
                //     'businessID' => $emp->business_id,
                //     'fullOrHafDay' => $request->leave_type,
                //     'leaveID' => $request->leave_category,
                //     'shift' => $request->shift_type,
                //     'from' => $request->from_date,
                //     'to' => $request->to_date,
                //     'day' => $request->days,
                // ];

                // $leaveCalculation = Central_unit::calculateLeaveCountApi($empData);
                //     return $leave;
                return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection([RequestLeaveList::find($leave->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false], 404);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function leaveDataList(Request $request)
    {
        $EmpID = $request->emp_id;
        $business_id = $request->business_id;
        $FindMonthYear = $request->date;

        if ($EmpID != null && $business_id != null && $FindMonthYear != null) {
            // $requestDate = Carbon::createFromFormat('d-m-Y', $date);
            $emp = DB::table('employee_personal_details')
                ->where('emp_id', $EmpID)
                ->where('business_id', $business_id)
                ->first();
            if ($emp) {
                // return $emp;
                $leave = RequestLeaveList::join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
                    ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
                    ->where('request_leave_list.emp_id', $EmpID)
                    ->where(function ($query) use ($FindMonthYear, $EmpID) {
                        if (!empty($FindMonthYear) && !empty($EmpID)) {
                            $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                            $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                            // $query->where('request_leave_list.emp_id', $EmpID)->whereYear('request_leave_list.from_date', $year)->whereMonth('request_leave_list.from_date', $month);
                            $query
                                ->where('request_leave_list.emp_id', $EmpID)
                                ->whereYear('request_leave_list.created_at', $year)
                                ->whereMonth('request_leave_list.created_at', $month);
                        }

                        // $query
                        //     ->where(function ($query) use ($requestDate) {
                        // //         // $query->where('from_date', '<=', $requestDate)->where('to_date', '>=', $requestDate);
                        //         $query->whereYear('request_leave_list.from_date', '<=', $requestDate->year)
                        //         ->whereYear('request_leave_list.to_date', '>=', $requestDate->year)
                        //         ->whereMonth('request_leave_list.from_date', '<=', $requestDate->month)
                        //         ->whereMonth('request_leave_list.to_date', '>=', $requestDate->month);
                        //     })
                        // ->orWhere(function ($query) use ($requestDate) {
                        //     $query->whereYear('request_leave_list.from_date', '=', $requestDate->year)
                        //     ->whereMonth('request_leave_list.from_date', '=', $requestDate->month)
                        //     ->whereNull('request_leave_list.to_date');
                        // });
                    })
                    ->where('request_leave_list.business_id', $business_id)
                    ->select('request_leave_list.*', 'policy_setting_leave_category.category_name', 'static_request_leave_type.leave_day')
                    ->get();
                // return $leave;
                // return $leave;
                if (count($leave) != 0) {
                    // return  response()->json(['result'=>$leave]);
                    return ReturnHelpers::jsonApiReturnSecond(LeaveRequestResources::collection($leave)->all(), 1); // case 1 when the leave date find
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
    public function currentStatusLeaveRequest(Request $request)
    {
        $goto = DB::table('request_leave_list')
            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
            ->join('policy_setting_role_create', 'approval_status_list.role_id', '=', 'policy_setting_role_create.id')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('request_leave_list.id', $request->id) //primary id
            ->where('approval_status_list.approval_type_id', $request->approval_type) //leave type 2
            ->where('approval_status_list.business_id', $request->business_id)
            ->where('policy_setting_role_create.business_id', $request->business_id)
            ->select('approval_status_list.*', 'policy_setting_role_create.roles_name', 'static_status_request.request_response')
            ->get();
        if (isset($goto)) {
            // return $goto;
            return ReturnHelpers::jsonApiReturnSecond(CurrentLeaveRequestStatus::collection($goto)->all(), 1); // case 1 when the leave date find
        } else {
            return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
        }
    }

    public function show($id)
    {
        $data = LeaveRequestList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function leaveUpdate(Request $request)
    {
        $id = $request->id;
        $businessId = $request->business_id;
        $EmpID = $request->emp_id;
        $leave = RequestLeaveList::join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->where('request_leave_list.id', $id)
            ->where('request_leave_list.business_id', $businessId)
            ->where('request_leave_list.emp_id', $EmpID)
            ->select('request_leave_list.*', 'policy_setting_leave_category.category_name', 'static_request_leave_type.leave_day')
            ->first();
        if ($leave) {
            if ($leave->forward_by_status == 0 && $leave->final_status == 0 && $leave->process_complete == 0) {
                $leave->id = $request->id ?? $leave->id;
                $leave->business_id = $request->business_id ?? $leave->business_id;
                $leave->emp_id = $request->emp_id ?? $leave->emp_id;
                $leave->leave_type = $request->leave_type ?? $leave->leave_type;
                $leave->leave_category = $request->leave_category ?? $leave->leave_category;
                $leave->shift_type = $request->shift_type ?? $leave->shift_type;
                $leave->from_date = $request->from_date ?? $leave->from_date;
                $leave->to_date = $request->to_date ?? $leave->to_date;
                $leave->reason = $request->reason ?? $leave->reason;
                $leave->days = $request->days ?? $leave->days;
                $leave->forward_by_role_id = $request->forward_by_role_id ?? $leave->forward_by_role_id;
                $leave->forward_by_status = $request->forward_by_status ?? $leave->forward_by_status;
                $leave->final_level_role_id = $request->final_level_role_id ?? $leave->final_level_role_id;
                $leave->final_status = $request->final_status ?? $leave->final_status;
                $leave->process_complete = $request->process_complete ?? $leave->process_complete;
                $submit = $leave->update();
                if ($submit) {
                    return response()->json(['result' => [], 'status' => true, 'case' => 1]); // case 1 update
                }
                return response()->json(['result' => [], 'status' => false, 'case' => 2]); // case 2 not update
            }
            return response()->json(['result' => [], 'status' => false, 'case' => 3]); // case 3 when the action perform
        }
        return response()->json(['result' => [], 'status' => false, 'case' => 4], 404); // case 4 when the data not found
    }

    public function destroy(Request $request)
    {
        $leave = RequestLeaveList::where('business_id', $request->business_id)->where('emp_id', $request->emp_id)->where('id', $request->id)->first();
        if ($leave) {
            if ($leave->forward_by_status == 0 && $leave->final_status == 0 && $leave->process_complete == 0) {
                $leave->delete();
                return response()->json(['result' => true, 'status' => true, 'case' => 1]);
            }else{
                return response()->json(['result' => 'You cannot delete your request, your request is a process you can not delete it.', 'status' => false, 'case'=>2]);
            }
        } else {
            return response()->json(['result' => [], 'status' => false , 'case' =>3], 404);
        }
    }
}
