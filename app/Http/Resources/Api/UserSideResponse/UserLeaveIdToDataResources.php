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
            'emp_id' => $this->emp_id ?? '',
            'leave_type' => (string)$this->leave_type ?? '',
            'leave_category' => (string)$this->leave_category ?? '',
            'shift_type' => (string)$this->shift_type ?? '', 
            'from_date' => $this->from_date ?? '', 
            'to_date' => $this->to_date ?? '', 
            'days' => (string)$this->days ?? '', 
            'reason' => $this->reason ?? '', 
            'status' => (string)$this->status ?? '', 
            'from_date' => $this->from_date ?? '', 
            'created_at' => $this->created_at ?? '', 
            'updated_at' => $this->updated_at ?? '', 
            // 'branch_id' => $this->branch_id ?? '',
            // 'department_id' => (string)$this->department_id ?? '',
            // 'designation_id' => (string)$this->designation_id ?? '',
            // 'emp_type' => (string)$this->emp_type ?? '',
            // 'emp_name' => $this->emp_name ?? '',
            // 'emp_mname' => $this->emp_mame ?? '',
            // 'emp_lname' => $this->emp_lame ?? '',
            // 'emp_mobile_no' => $this->emp_mobile_no ?? '',
        ];
    }
}