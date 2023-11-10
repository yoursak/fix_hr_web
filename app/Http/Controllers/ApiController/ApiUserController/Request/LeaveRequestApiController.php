<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeePersonalDetail;
use App\Models\RequestLeaveList;
use App\Models\StaticLeaveShiftType;
use App\Models\StaticRequestLeaveType;
use App\Models\PolicySettingLeavePolicy;
use App\Helpers\ReturnHelpers;
// /public_html/app/Http/Resources/Api/UserSideResponse
use App\Http\Resources\Api\UserSideResponse\LeaveRequestResources;
use DB;
use App\Http\Resources\Api\UserSideResponse\StaticLeaveShiftTypeResources;
use App\Http\Resources\Api\UserSideResponse\LeaveCategoryResources;
use App\Http\Resources\Api\UserSideResponse\StaticRequestLeaveTypeResources;
use App\Http\Resources\Api\UserSideResponse\UserLeaveIdToDataResources;

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

        if ($emp) {
            // why type = 2 leave for  using approval system checking actived
            $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $emp->business_id)
                ->where('approval_type_id', 2)
                ->first();
            if ($approvalManagementCycle != null) {
                $load = $approvalManagementCycle->cycle_type;
            } else {
                $load = 2; //default
            }
            $leave = new RequestLeaveList();
            $leave->business_id = $emp->business_id;
            $leave->emp_id = $request->emp_id;
            $leave->emp_mobile_no = $emp->emp_mobile_number;
            $leave->leave_type = $request->leave_type;
            $leave->leave_category = $request->leave_category ? $request->leave_category : '0';
            $leave->shift_type = $request->shift_type ? $request->shift_type : '0';
            $leave->from_date = $request->from_date;
            $leave->to_date = $request->to_date;
            $leave->runtime_cycle_update = $load; //$approvalManagementCycle->cycle_type;
            $leave->status = 0;

            if ($leave->save()) {
                //     return $leave;
                return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection([RequestLeaveList::find($leave->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function leaveDataList(Request $request)
    {
        $emp_id = $request->emp_id;
        $business_id = $request->business_id;
        $date = $request->date;
        if ($emp_id != null && $business_id != null && $date != null) {
            $requestDate = Carbon::createFromFormat('d-m-Y', $date);
            $emp = DB::table('employee_personal_details')
                ->where('emp_id', $emp_id)
                ->where('business_id', $business_id)
                ->first();
            if ($emp) {
                $leave = RequestLeaveList
                    ::join('policy_setting_leave_category', 'policy_setting_leave_category.id', '=', 'request_leave_list.leave_category')
                    ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
                    ->where('request_leave_list.emp_id', $emp_id)
                    ->where(function ($query) use ($requestDate) {
                        $query
                            ->where(function ($query) use ($requestDate) {
                        //         // $query->where('from_date', '<=', $requestDate)->where('to_date', '>=', $requestDate);
                                $query->whereYear('request_leave_list.from_date', '<=', $requestDate->year)
                                ->whereYear('request_leave_list.to_date', '>=', $requestDate->year)
                                ->whereMonth('request_leave_list.from_date', '<=', $requestDate->month)
                                ->whereMonth('request_leave_list.to_date', '>=', $requestDate->month);
                            })
                        ->orWhere(function ($query) use ($requestDate) {
                            $query->whereYear('request_leave_list.from_date', '=', $requestDate->year)
                            ->whereMonth('request_leave_list.from_date', '=', $requestDate->month)
                            ->whereNull('request_leave_list.to_date');
                        });
                    })
                    ->where('request_leave_list.business_id', $business_id)
                    ->select('request_leave_list.*', 'policy_setting_leave_category.category_name', 'static_request_leave_type.leave_day')
                    ->get();
                // return $leave;
                // return $leave;
                if (count($leave) != 0) {
                    // return $leave;
                    return ReturnHelpers::jsonApiReturnSecond(LeaveRequestResources::collection($leave)->all(), 1); // case 1 when the gatepass date find
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true]); // case 2 when the employee gatepass record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }

        // return $request->all();
        // $leaveTest = DB::table('leave_request_list')
        // ->join('employee_personal_details', 'employee_personal_details.emp_id', '=' , 'leave_request_list.emp_id')
        // ->where('leave_request_list.emp_id', $id)
        // ->select('leave_request_list.*')
        // ->get();
        // return $leaveTest;
        // $emp = DB::table('employee_personal_details')
        //     ->where('emp_id', $id)
        //     ->first();
        // $leave = DB::table('leave_request_list')
        //     ->where('emp_id', $id)
        //     ->orderBy('id', 'desc')
        //     ->get();
        // if ($emp != null && (count($leave) != 0)) {
        //     return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection($leave)->all());
        // } else {
        //     return response()->json(['result' => [], 'status' => false], 404);
        // }
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

    public function update(Request $request, $id)
    {
        $leave = LeaveRequestList::find($id);
        if ($leave) {
            $leave->business_id = $request->business_id ?? $leave->business_id;
            $leave->branch_id = $request->branch_id ?? $leave->branch_id;
            $leave->department_id = $request->department_id ?? $leave->department_id;
            $leave->designation_id = $request->designation_id ?? $leave->designation_id;
            $leave->emp_id = $request->emp_id ?? $leave->emp_id;
            $leave->emp_name = $request->emp_name ?? $leave->emp_name;
            $leave->emp_mobile_no = $request->emp_mobile_no ?? $leave->emp_mobile_no;
            $leave->leave_type = $request->leave_type ?? $leave->leave_type;
            $leave->leave_category = $request->leave_category ?? $leave->leave_category;
            $leave->shift_type = $request->shift_type ?? $leave->shift_type;
            $leave->from_date = $request->from_date ?? $leave->from_date;
            $leave->to_date = $request->to_date ?? $leave->to_date;
            $leave->days = $request->days ?? $leave->days;
            $leave->reason = $request->reason ?? $leave->reason;
            $leave->status = $request->status ?? $leave->status;

            if ($leave->update()) {
                return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection([LeaveRequestList::find($leave->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function destroy($id)
    {
        // return true;
        $leave = LeaveRequestList::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }
}
