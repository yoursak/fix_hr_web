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
            'leave_category' => ($this->leave_category) ==1 ? 'Full Day': (($this->leave_category) ==2 ? 'Half Day' : '' )?? '',
            'shift_type' => ($this->shift_type) == 1 ? '1st Half': (($this->shift_type) == 2 ?'2nd Half' : '') ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'days' => (string)$this->days ?? '',
            'reason' => $this->reason ?? '',
            'status' => $this->status ?? '',
            'profile_photo' => '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
           
        ];
    }
}
?>