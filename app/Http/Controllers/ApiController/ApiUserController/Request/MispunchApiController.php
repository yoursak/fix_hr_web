<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\MispunchList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\MispunchRequestResources;
use Carbon\Carbon;
use App\Http\Resources\Api\UserSideResponse\UserMispunchIdToDataResources;
use DB;

class MispunchApiController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        if ($emp) {
            $data = new MispunchList();
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
            $data->status = 0;

            if ($data->save()) {
                return ReturnHelpers::jsonApiReturn(MispunchRequestResources::collection([MispunchList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

        // // if($Mispunch!=null){
        // //     return "kya andha hai";
        // // }
        // // if (isset($Mispunch) &&  !empty($Mispunch)) {
        //     if (empty($yourArray)) {
        //     return 'The array is not null and not empty.';
        // } else {
        //     return 'The array is null or empty.';
        // }

    public function mispunchDataList(Request $request)
    {
        $businessID = $request->business_id;
        $EmpID = $request->emp_id;
        $date = $request->date;

        $date = Carbon::createFromFormat('d-m-Y', $date);
        
        // $date = $request->date; // Assuming $request->date is a valid date in 'Y-m-d' format
        $FindMonthYear = $request->find_year_month; //like 2023-11
        // return $date;
        // // calculate present, absent, halfday, holiday, weekoff;

        $preview = DB::table('request_mispunch_list')
            ->join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_mispunch_listn.business_id', $businessID)
            ->where(function ($query) use ($date, $FindMonthYear, $EmpID) {

                if (!empty($date)) {
                    $query->whereDate('request_mispunch_list.emp_miss_date', $date); // Use whereDate to compare the full date
                }
                if ((!empty($FindMonthYear)) && (!empty($EmpID))) {
                    $year = substr($FindMonthYear, 0, 4); // Extract the year (e.g., '2023')
                    $month = substr($FindMonthYear, 5, 2); // Extract the month (e.g., '11')
                    $query->where('request_mispunch_list.emp_id', $EmpID)->whereYear('request_mispunch_list.emp_miss_date', $year)->whereMonth('emp_miss_date.emp_miss_date', $month);
                }
            })
            // ->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.emp_shift_type', 'employee_personal_details.emp_attendance_method', 'employee_personal_details.profile_photo', 'attendance_list.*')
            // ->orderby('attendance_list.id', 'desc')
            ->get();

        // $formattedData = AttendanceListResource::collection($preview);

        // if ($formattedData) {

        //     return response()->json(['result' => $formattedData, 'status' => true]);
        // }
        // return response()->json(['result' => [], 'status' => false], 404);
        $emp = DB::table('employee_personal_details')
            ->where('emp_id', $id)
            ->first();
        $Mispunch = DB::table('Mispunch_list')
            ->where('emp_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        if ($emp!=null  &&(count($Mispunch) != 0)) {
            // return $Mispunch;
            return ReturnHelpers::jsonApiReturn(UserMispunchIdToDataResources::collection($Mispunch)->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }




    }

    public function show($id)
    {
        $data = MispunchList::find($id);
        if ($data) {
            return ReturnHelpers::jsonApiReturn(MispunchRequestResources::collection([$data])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = MispunchList::find($id);
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
                return ReturnHelpers::jsonApiReturn(MispunchRequestResources::collection([MispunchList::find($data->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function destroy($id)
    {
        $data = MispunchList::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['result' => true, 'status' => true]);
        } else {
            return response()->json(['result' => [], 'status' => false]);
        }
    }
}
