<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendenceResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            // 'id' => $this->id ?? $this->attendance_list->id,
            // 'emp_id' => $this->emp_id ?? '',
            // 'business_id' => $this->business_id ?? '',
            // 'branch_id' => $this->branch_id ?? '',
            // 'department_id' => $this->department_id ?? '',
            // 'emp_name' => $this->emp_name ?? '',
            // 'emp_status' => $this->emp_status ?? '',
            // 'punch_in' => $this->punch_in ?? '',
            // 'punch_in_address' => $this->punch_in_address ?? '',
            // 'punch_in_latitude' => $this->punch_in_latitude ?? '',
            // 'punch_in_longitude' => $this->punch_in_longitude ?? '',
            // 'punch_in_image' => $this->punch_in_image ?? '',
            // 'punch_out' => $this->punch_out ?? '',
            // 'punch_out_address' => $this->punch_out_address ?? '',
            // 'punch_out_latitude' => $this->punch_out_latitude ?? '',
            // 'punch_out_longitude' => $this->punch_out_longitude ?? '',
            // 'punch_out_image' => $this->punch_out_image ?? '',
            // 'working_hour' => $this->working_hour ?? '',
            // 'working_from' => $this->working_from ?? '',


            
            'id' => $this->id ?? $this->attendance_list->id,
            'working_from_mode' => $this->working_from_mode ?? '',
            'punch_mode' => $this->punch_mode ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_type' => (string)$this->emp_type ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'attendace_status' => $this->attendace_status ?? '',
            'emp_today_current_status' => $this->emp_today_current_status ?? '',
            'emp_name' => $this->emp_name ?? '',
            'punch_in' => $this->punch_in ?? '',
            'punch_in_selfie' => $this->punch_in_selfie ?? '',
            'punch_in_time' => $this->punch_in_time ?? '',
            'punch_in_address' => $this->punch_in_address ?? '',
            'punch_in_latitude' => $this->punch_in_latitude ?? '',
            'punch_in_longitude' => $this->punch_in_longitude ?? '',
            'punch_out' => $this->punch_out ?? '',
            'punch_out_selfie' => $this->punch_out_selfie ?? '',
            'punch_out_time' => $this->punch_out_time ?? '',
            'punch_out_address' => $this->punch_out_address ?? '',
            'punch_out_latitude' => $this->punch_out_latitude ?? '',
            'punch_out_longitude' => $this->punch_out_longitude ?? '',
            'total_working_hour' => $this->total_working_hour ?? '',
            'created_at'=>$this->created_at??'',
            'updated_at'=>$this->updated_at??''
        

            // $data->working_from_mode = $request->wfmode,
            // $data->punch_mode = $request->pmode,
            // $data->emp_id = $request->emp_id,
            // $data->business_id = $emp->business_id,
            // $data->branch_id = $emp->branch_id,
            // $data->attendace_status = $request->attendace_status,
            // $data->emp_today_current_status = $request->emp_today_current_status,
            // $data->emp_name = $emp->emp_name,
            // $data->punch_in = $request->punch_in,
            // $data->punch_in_selfie = $request->punch_in_selfie,
            // $data->punch_in_time = $request->punch_in_time,
            // $data->punch_in_address = $request->punch_in_address,
            // $data->punch_in_latitude = $request->punch_in_latitude,
            // $data->punch_in_longitude = $request->punch_in_longitude,
            // $data->punch_out = $request->punch_out,
            // $data->punch_out_selfie = $request->punch_out_selfie,
            // $data->punch_out_time = $request->punch_out_time,
            // $data->punch_out_address = $request->punch_out_address,
            // $data->punch_out_latitude = $request->punch_out_latitude,
            // $data->punch_out_longitude = $request->punch_out_longitude,
            // $data->total_working_hour = $request->total_working_hour,
        
        ];
    }
}
