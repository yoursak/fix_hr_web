<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\LeaveRequestList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\LeaveRequestResources;
use DB;

class LeaveRequestApiController extends Controller
{
    public function index()
    {
        $leave = LeaveRequestList::all();
        return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection($leave)->all());
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        $leave = new LeaveRequestList();
        $leave->business_id = $emp->business_id;
        $leave->branch_id = $emp->branch_id;
        $leave->department_id = $emp->department_id;
        $leave->designation_id = $emp->designation_id;
        $leave->emp_id = $request->emp_id;
        $leave->emp_name = $emp->emp_name;
        $leave->emp_mobile_no = $emp->emp_mobile_number;
        $leave->leave_type = $request->leave_type;
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->days = $request->days;
        $leave->reason = $request->reason;
        $leave->status = $request->status;
        $leave->created_at = now();
        $leave->updated_at = now();

        if ($leave->save()) {
            return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection([LeaveRequestList::find($leave->id)])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function show($id)
    {
        $data = LeaveRequestList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(LeaveRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false]);
        }
    }

    public function update(Request $request, $id)
    {
        $leave = LeaveRequestList::find($id);
        $leave->business_id = $request->business_id ?? $leave->business_id;
        $leave->branch_id = $request->branch_id ?? $leave->branch_id;
        $leave->department_id = $request->department_id ?? $leave->department_id;
        $leave->designation_id = $request->designation_id ?? $leave->designation_id;
        $leave->emp_id = $request->emp_id ?? $leave->emp_id;
        $leave->emp_name = $request->emp_name ?? $leave->emp_name;
        $leave->emp_mobile_no = $request->emp_mobile_no ?? $leave->emp_mobile_no;
        $leave->leave_type = $request->leave_type ?? $leave->leave_type;
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

    public function destroy($id)
    {
        // return true;
        $leave = LeaveRequestList::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false]);
        }
    }
}
