<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLeaveIdToDataResources extends JsonResource
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
            'leave_type' => $this->leave_type ?? '',
            'leave_category' => $this->leave_category ?? '',
            'shift_type' => $this->shift_type ?? '', 
            'from_date' => $this->from_date ?? '', 
            'to_date' => $this->to_date ?? '', 
            'days' => $this->days ?? '', 
            'reason' => $this->reason ?? '', 
            'status' => $this->status ?? '', 
            'from_date' => $this->from_date ?? '', 
            'created_at' => $this->created_at ?? '', 
            'updated_at' => $this->updated_at ?? '', 
        ];
    }
}