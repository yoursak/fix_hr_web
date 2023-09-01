<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendenceResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->attendance_list->id,
            'business_id' => $this->business_id ?? '',
            'department_id' => $this->department_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'emp_id' => $this->emp_name ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_status' => $this->emp_status ?? '',
            'punch_in' => $this->punch_in ?? '',
            'punch_out' => $this->punch_out ?? '',
            'production_hour' => $this->production_hour ?? '',
            'location_ip' => $this->location_ip ?? '',
            'working_from' => $this->working_from ?? '',
           
        ];
    }
}
