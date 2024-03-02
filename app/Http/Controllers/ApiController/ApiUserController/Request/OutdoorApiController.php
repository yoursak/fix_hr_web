<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RequestOutdoorList;
use App\Models\EmployeePersonalDetail;
use App\Http\Resources\Api\UserSideResponse\OutdoorResponse\OutdoorResources;
use App\Helpers\ReturnHelpers;


class OutdoorApiController extends Controller
{
    public function outdoorDetailFind(Request $request)
    {
        $data = RequestOutdoorList::where('business_id', $request->business_id)->where('emp_id', $request->emp_id)->where('id', $request->id)->first();
        if ($data) {
            return response()->json(['result' => (OutdoorResources::collection([$data])->all()), 'case' => 1, 'status' => true], 404);
        }
        return response()->json(['result' => [], 'case' => 2, 'status' => true], 404);
    }

    public function store(Request $request)
    {
        $empId = $request->emp_id;
        $businessId = $request->business_id;
        $branchId = $request->branch_id;
        $emp = EmployeePersonalDetail::join('policy_attendance_mode', 'policy_attendance_mode.business_id', '=', 'employee_personal_details.business_id')
            ->where('employee_personal_details.business_id', $businessId)
            ->where('employee_personal_details.branch_id', $branchId)
            ->where('employee_personal_details.emp_id', $empId)
            ->where('employee_personal_details.active_emp', 1)
            ->where('policy_attendance_mode.office_selfie', 1)
            ->select('employee_personal_details.*', 'policy_attendance_mode.office_selfie') // Add the columns you want to select
            ->first();
        if ($emp) {
            $data = new RequestOutdoorList();
            $data->business_id = $businessId;
            $data->branch_id = $request->branch_id;
            $data->branch_id = $branchId;
            $data->emp_id = $empId;
            $data->apply_date = $request->apply_date;
            $data->out_time = $request->out_time;
            $data->reason = $request->reason;
            $data->status = 1;
            $check = $data->save();
            if ($check) {
                return response()->json(['result' => true, 'case' => 1, 'message' => 'Outdoor Form has been submitted successfully', 'status' => true], 200);
            } else {
                return response()->json(['result' => [], 'case' => 2, 'message' => 'Outdoor Form has been not submitted', 'status' => true], 404);
            }
        }
        return response()->json(['result' => [], 'case' => 3, 'message' => 'Employee outdoor selfie mark not allowed', 'status' => true], 404);
    }

    public function showList(Request $request)
    {
        $requestDate = Carbon::createFromFormat('d-m-Y', $request->date);
        $data = RequestOutdoorList::where('business_id', $request->business_id)
            ->where('emp_id', $request->emp_id)
            ->whereYear('request_outdoor_list.apply_date', '=', $requestDate->year)
            ->whereMonth('request_outdoor_list.apply_date', '=', $requestDate->month)
            ->orderByDesc('id')
            ->get();
        if ($data) {
            return response()->json(['result' => (OutdoorResources::collection($data)->all()), 'case' => 1, 'status' => true], 200);
        }
        return response()->json(['result' => (OutdoorResources::collection($data)->all()), 'case' => 2, 'status' => true], 404);
    }

    public function delete()
    {
    }
}
