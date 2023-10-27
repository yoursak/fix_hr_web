<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\LeaveRequestList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\LeaveRequestResources;
use DB;
use App\Http\Resources\Api\UserSideResponse\UserLeaveIdToDataResources;

use Carbon\Carbon;


class LeaveRequestApiController extends Controller
{
    public function index()
    {
        $leave = LeaveRequestList::all();
        return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection($leave)->all());
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->where('business_id', $request->business_id)->first();
        // return $emp;
        if ($emp) {
            $leave = new LeaveRequestList();
            $leave->business_id = $emp->business_id;
            $leave->branch_id = $emp->branch_id;
            $leave->department_id = $emp->department_id;
            $leave->designation_id = $emp->designation_id;
            $leave->emp_id = $request->emp_id;
            $leave->emp_type = $emp->employee_type;
            $leave->emp_name = $emp->emp_name;
            $leave->emp_mobile_no = $emp->emp_mobile_number;
            $leave->leave_type = $request->leave_type;
            $leave->leave_category = $request->leave_category;
            $leave->shift_type = $request->shift_type;
            $leave->from_date = $request->from_date;
            $leave->to_date = $request->to_date;

            // $fromDate = Carbon::parse($request->from_date);
            // $toDate = Carbon::parse($request->to_date);
    
            // $loaded = $toDate->diffInDays($fromDate);
            // $datetime1 = new DateTime($leave->from_date);
            // $datetime2 = new DateTime($leave->to_date);
            // $interval = $datetime1->diff($datetime2);
            // $leave->days = $loaded+1;
            $leave->days =  $request->days;
            $leave->reason = $request->reason;
            $leave->status = 0;
         

            if ($leave->save()) {
                // return $leave;
                return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection([LeaveRequestList::find($leave->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function leaveIdToData($id)
    {
        $emp = DB::table('employee_personal_details')
            ->where('emp_id', $id)
            ->first();
        $leave = DB::table('leave_request_list')
            ->where('emp_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        if ($emp!=null  &&(count($leave) != 0)) {
            // return $leave;
            return ReturnHelpers::jsonApiReturn(UserLeaveIdToDataResources::collection($leave)->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
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
            $leave->leave_category = $request->leave_category ?? $leave->leave_category;;
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
