<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\MisspunchList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\MisspunchRequestResources;
use Carbon\Carbon;

class MisspuchApiController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        if ($emp) {
            $data = new MisspunchList();
            $data->business_id = $emp->business_id;
            $data->branch_id = $emp->branch_id;
            $data->department_id = $emp->department_id;
            $data->designation_id = $emp->designation_id;
            $data->emp_id = $request->emp_id;
            $data->emp_type = $emp->employee_type;
            $data->emp_name = $emp->emp_name;
            $data->emp_mobile_no = $emp->emp_mobile_number;
            $data->emp_miss_date = $request->miss_date;
            $data->emp_miss_time_type = $request->miss_time_type;
            $data->emp_miss_in_time = $request->in_time;
            $data->emp_miss_out_time = $request->out_time;
            $data->emp_working_hour = $request->working_hour;
            $data->message = $request->message;
            $data->status = $request->status;

            if ($data->save()) {
                return ReturnHelpers::jsonApiReturn(MisspunchRequestResources::collection([MisspunchList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function show($id)
    {
        $data = MisspunchList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(MisspunchRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = MisspunchList::find($id);
        if ($data) {
            $data->business_id = $request->business_id ?? $data->business_id;
            $data->branch_id = $request->branch_id ?? $data->branch_id;
            $data->department_id = $request->department_id ?? $data->department_id;
            $data->designation_id = $request->designation_id ?? $data->designation_id;
            $data->emp_id = $request->emp_id ?? $data->emp_id;
            $data->emp_name = $request->emp_name ?? $data->emp_name;
            $data->emp_mobile_no = $request->emp_mobile_no ?? $data->emp_mobile_no;
            $data->emp_miss_date = $request->emp_miss_date ?? $data->emp_miss_date;
            $data->emp_miss_time_type = $request->emp_miss_time_type ?? $data->emp_miss_time_type;
            $data->emp_miss_in_time = $request->to_date ?? $data->emp_miss_in_time;
            $data->emp_miss_out_time = $request->days ?? $data->emp_miss_out_time;
            $data->message = $request->message ?? $data->message;
            $data->status = $request->status ?? $data->status;
            if ($data->update()) {
                return ReturnHelpers::jsonApiReturn(MisspunchRequestResources::collection([MisspunchList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function destroy($id)
    {
        $data = MisspunchList::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false]);
        }
    }
}
