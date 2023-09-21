<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\AttendanceList;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AttendenceResources;
use App\Models\employee\EmployeePersonalDetail;
use Carbon\Carbon;

class AttendanceApiController extends Controller
{
    public function index()
    {
        $data = AttendanceList::all();
        if ($data) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function store(Request $request)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        if ($emp) {
            $data = new AttendanceList();
            if ($request->image) {
                $validatedData = $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
                ]);
                // Get the uploaded image file
                $image = $request->file('image');
                $path = public_path('upload_image/');
                $imageName = date('d-m-Y h:i:sa') . '_' . md5($image) . '.' . $request->image->extension();
                $request->image->move($path, $imageName);
                $data->punch_in_selfie = $imageName;

                // $image  = new Image();
                // $image->name = $imageName;
                // $image->save();

                // // Return a response with information about the uploaded image
                // return response()->json([
                //     'message' => 'Image uploaded successfully.',
                //     'image_path' => $imageName,
                // ]);
            }
            // else {
            //     return response()->json(['result' => [], 'status' => false], 404);
            // }

            $data->working_from_mode = $request->wfmode;
            $data->punch_mode = $request->pmode;
            $data->emp_id = $request->emp_id;
            $data->emp_type = $emp->employee_type;
            $data->business_id = $emp->business_id;
            $data->branch_id = $emp->branch_id;
            $data->attendace_status = $request->attendace_status;
            $data->emp_today_current_status = $request->emp_today_current_status;
            $data->emp_name = $emp->emp_name;
            $data->punch_in = $request->punch_in;
            // $data->punch_in_selfie = $request->punch_in_selfie;
            $data->punch_in_time = now('Asia/Kolkata');
            $data->punch_in_address = $request->punch_in_address;
            $data->punch_in_latitude = $request->punch_in_latitude;
            $data->punch_in_longitude = $request->punch_in_longitude;
            $data->punch_out = $request->punch_out;
            $data->punch_out_selfie = $request->punch_out_selfie;
            $data->punch_out_time = $request->punch_out_time;
            $data->punch_out_address = $request->punch_out_address;
            $data->punch_out_latitude = $request->punch_out_latitude;
            $data->punch_out_longitude = $request->punch_out_longitude;
            $data->total_working_hour = $request->total_working_hour;

            if ($data->save()) {
                return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($data->id)])->all());

                // return ReturnHelpers::jsonApiReturn(AttendenceResources::collection(AttendanceList::where('emp_id',$data->id )->get()));
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    public function storey(Request $request)
    {
        $attend = new AttendanceList();
        $attend->business_id = $request->business_id;
        $attend->branch_id = $request->branch_id;
        // $attend->department_id = $request->department_id;
        $attend->emp_id = $request->emp_id;
        $attend->emp_name = $request->emp_name;
        // $attend->emp_status = $request->emp_status;
        $attend->punch_in_time = $request->punch_in_time;
        $attend->punch_in_address = $request->punch_in_address;
        $attend->punch_in_latitude = $request->punch_in_latitude;
        $attend->punch_in_longitude = $request->punch_in_longitude;
        // $attend->punch_in_image = $request->punch_in_image;
        // $attend->punch_out = $request->punch_out;
        // $attend->punch_out_address = $request->punch_out_address;
        // $attend->punch_out_latitude = $request->punch_out_latitude;
        // $attend->punch_out_longitude = $request->punch_out_longitude;
        // $attend->punch_out_image = $request->punch_out_image;
        // $attend->working_hour = $request->working_hour;
        // $attend->location_ip = $request->location_ip;
        // $attend->working_from = $request->working_from;
        if ($attend->save()) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($attend->id)])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function show($id)
    {
        $attend = AttendanceList::where('emp_id', $attend_id)->first();
        if ($attend) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function update(Request $request, $emp_id)
    {
        $attend = AttendanceList::where('emp_id', $emp_id)->first();
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
        if ($attend->save()) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($attend->id)])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function destroy($emp_id)
    {
        $attend = AttendanceList::where('emp_id', $emp_id)->first();

        if ($attend) {
            $attend->delete();
            return response()->json(['result' => true, 'status' => true, 'msg' => 'Delete Successfully!']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
