<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\GatepassRequestList;
use App\Models\admin\BranchList;
use App\Models\admin\DepartmentList;
use App\Models\admin\DesignationList;
use App\Http\Resources\Api\GatepassRequestResources;
use App\Helpers\ReturnHelpers;

class GatePassApiController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        if ($emp) {
            $data = new GatepassRequestList();
            $data->business_id = $emp->business_id;
            $data->branch_id = $emp->branch_id;
            $data->department_id = $emp->department_id;
            $data->designation_id = $emp->designation_id;
            $data->emp_id = $request->emp_id;
            $data->emp_name = $emp->emp_name;
            $data->emp_type = $emp->employee_type;
            $data->emp_mobile_no = $emp->emp_mobile_number;
            $data->date = $request->date;
            $data->going_through = $request->going_through;
            $data->in_time = $request->in_time;
            $data->out_time = $request->out_time;
            $data->reason = $request->reason;
            $data->status = $request->status;
            if ($data->save()) {
                return ReturnHelpers::jsonApiReturn(GatepassRequestResources::collection([GatepassRequestList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function show($id)
    {
        $data = GatepassRequestList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(GatepassRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = GatepassRequestList::find($id);
        if ($data) {
            $data->business_id = $request->business_id ?? $data->business_id;
            $data->branch_id = $request->branch_id ?? $data->branch_id;
            $data->department_id = $request->department_id ?? $data->department_id;
            $data->designation_id = $request->designation_id ?? $data->designation_id;
            $data->emp_id = $request->emp_id ?? $data->emp_id;
            $data->emp_name = $request->emp_name ?? $data->emp_name;
            $data->emp_mobile_no = $emp->emp_mobile_number ?? $data->emp_mobile_no;
            $data->date = $request->date ?? $data->date;
            $data->going_through = $request->going_through ?? $data->going_through;
            $data->in_time = $request->in_time ?? $data->in_time;
            $data->out_time = $request->out_time ?? $data->out_time;
            $data->reason = $request->reason ?? $data->reason;
            $data->status = $request->status ?? $data->status;
            if ($data->update()) {
                return ReturnHelpers::jsonApiReturn(GatepassRequestResources::collection([GatepassRequestList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function destroy($id)
    {
        // return true;
        $data = GatepassRequestList::find($id);
        // return $data;
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }
}
