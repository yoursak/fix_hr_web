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
            $start = Carbon::parse($request->in_time);
            $end = Carbon::parse($request->out_time);
            $hours = $end->diffInHours($start);
            $minutes = $end->diffInMinutes($start);
        // return gmdate('H:i', $duration);
        $data->message = $request->message;
        $data->profile_photo = $emp->profile_photo;
        $data->status = $request->status;
        

        // Parse the time inputs
        list($inHours, $inMinutes, $inPeriod) = sscanf($data->emp_miss_in_time, "%d:%d %s");
        list($outHours, $outMinutes, $outPeriod) = sscanf($data->emp_miss_out_time, "%d:%d %s");
        
        // Convert to 24-hour format if necessary
        if ($inPeriod === 'PM' && $inHours !== 12) {
            $inHours += 12;
        } elseif ($inPeriod === 'AM' && $inHours === 12) {
            $inHours = 0;
        }
        
        if ($outPeriod === 'PM' && $outHours !== 12) {
            $outHours += 12;
        } elseif ($outPeriod === 'AM' && $outHours === 12) {
            $outHours = 0;
        }
        
        // Calculate the time difference in minutes
        $differenceMinutes = ($outHours * 60 + $outMinutes) - ($inHours * 60 + $inMinutes);
        
        // Ensure the differenceMinutes is positive
        if ($differenceMinutes < 0) {
                $differenceMinutes += 720; // 12 hours in minutes
            }
            
            // Calculate the hours and minutes for the result
            $resultHours = floor($differenceMinutes / 60);
            $resultMinutes = $differenceMinutes % 60;

            // Format the result as "hh:MM AM/PM"
            $formattedResult = sprintf("%02d:%02d %s", $resultHours, $resultMinutes, $outPeriod);
            $data->emp_working_hour = $formattedResult ;
            
            // return response()->json(['result' => $formattedResult]);
            
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
