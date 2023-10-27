<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMisspunchIdToDataResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' => $this->department_id ?? '',
            'designation_id' => $this->designation_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_type' => $this->emp_type ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mobile_no' => $this->emp_mobile_no ?? '',
            'emp_miss_date' => $this->emp_miss_date ?? '',
            'emp_miss_time_type' => $this->emp_miss_time_type ?? '',
            'emp_miss_in_time' => $this->emp_miss_in_time ?? '',
            'emp_miss_out_time' => $this->emp_miss_out_time ?? '',
            'emp_working_hour' => $this->emp_working_hour ?? '',
            'message' => $this->message ?? '',
            'remark' => $this->remark ?? '',
            'status' => $this->status ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '', 
          
        ];
    }
}