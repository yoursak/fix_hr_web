<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendenceResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->attendance_list->id,
            'emp_id' => $this->emp_id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' => $this->department_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_status' => $this->emp_status ?? '',
            'punch_in' => $this->punch_in ?? '',
            'punch_in_address' => $this->punch_in_address ?? '',
            'punch_in_latitude' => $this->punch_in_latitude ?? '',
            'punch_in_longitude' => $this->punch_in_longitude ?? '',
            'punch_in_image' => $this->punch_in_image ?? '',
            'punch_out' => $this->punch_out ?? '',
            'punch_out_address' => $this->punch_out_address ?? '',
            'punch_out_latitude' => $this->punch_out_latitude ?? '',
            'punch_out_longitude' => $this->punch_out_longitude ?? '',
            'punch_out_image' => $this->punch_out_image ?? '',
            'working_hour' => $this->working_hour ?? '',
            'working_from' => $this->working_from ?? '',
        
        ];
    }
}
