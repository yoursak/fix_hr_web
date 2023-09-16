<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\AttendanceList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AttendenceResources;


class AttendanceApiController extends Controller
{
    
    public function index()
    {
        $data = AttendanceList::all();
        if($data){
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function store(Request $request)
    {
        $attend = new AttendanceList();
        $attend->business_id = $request->business_id;
        $attend->branch_id = $request->branch_id;
        $attend->department_id = $request->department_id;
        $attend->emp_id = $request->emp_id;
        $attend->emp_name = $request->emp_name;
        $attend->emp_status = $request->emp_status;
        $attend->punch_in_time = $request->punch_in_time;
        $attend->punch_in_address = $request->punch_in_address;
        $attend->punch_in_latitude = $request->punch_in_latitude;
        $attend->punch_in_longitude = $request->punch_in_longitude;
        $attend->punch_in_image = $request->punch_in_image;
        // $attend->punch_out = $request->punch_out;
        // $attend->punch_out_address = $request->punch_out_address;
        // $attend->punch_out_latitude = $request->punch_out_latitude;
        // $attend->punch_out_longitude = $request->punch_out_longitude;
        // $attend->punch_out_image = $request->punch_out_image;
        // $attend->working_hour = $request->working_hour;
        // $attend->location_ip = $request->location_ip;
        $attend->working_from = $request->working_from;
        if($attend->save()){
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection(AttendanceList::where('emp_id', $request->emp_id)->get()));
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function show($id)
    {
        $attend = AttendanceList::where('emp_id', $attend_id)->first();
        if($attend){
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function update(Request $request, $emp_id)
    {
        $attend = AttendanceList::where('emp_id',$emp_id)->first();
        // return $attend;
        // $attend->business_id = $request->business_id ?? $attend->business_id;
        $attend->branch_id = $request->branch_id ?? $attend->branch_id;
        $attend->department_id = $request->department_id ?? $attend->department_id;
        $attend->emp_id = $request->emp_id ?? $attend->emp_id;
        $attend->emp_name = $request->emp_name ?? $attend->emp_name;
        $attend->emp_status = $request->emp_status ?? $attend->emp_status;
        $attend->punch_in_time = $request->punch_in_time ?? $attend->punch_in_time;
        $attend->punch_in_address = $request->punch_in_address ?? $attend->punch_in_address;
        $attend->punch_in_latitude = $request->punch_in_latitude ?? $attend->punch_in_latitude;
        $attend->punch_in_longitude = $request->punch_in_longitude ?? $attend->punch_in_longitude;
        $attend->punch_in_image = $request->punch_in_image ?? $attend->punch_in_image;
        $attend->punch_out_time = $request->punch_out ?? $attend->punch_out_time;
        $attend->punch_out_address = $request->punch_out_address ?? $attend->punch_out_address;
        $attend->punch_out_latitude = $request->punch_out_latitude ?? $attend->punch_out_latitude;
        $attend->punch_out_longitude = $request->punch_out_longitude ?? $attend->punch_out_longitude;
        $attend->punch_out_image = $request->punch_out_image ?? $attend->punch_out_image;
        $attend->working_hour = $request->working_hour ?? $attend->working_hour;
        $attend->working_from = $request->working_from ?? $attend->working_from;
        if($attend->save()){
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection(AttendanceList::where('emp_id', $request->emp_id)->get()));
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function destroy($emp_id)
    {
        $attend = AttendanceList::where('emp_id',$emp_id)->first();
        
        if($attend){
            $attend->delete();
            return response()->json(['result' => true, 'status' => true, 'msg'=> 'Delete Successfully!']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
