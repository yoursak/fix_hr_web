<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->id,
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' => $this->department_id ?? '',
            'designation_id' => $this->department_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mobile_no' => $this->emp_mobile_no ?? '',
            'leave_type' => $this->leave_type ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'days' => (string)$this->days ?? '',
            'reason' => $this->reason ?? '',
            'status' => $this->status ?? '',
            'profile_photo' => $this->profile_photo ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
           
        ];
    }
}
?>