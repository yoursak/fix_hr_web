<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->id,
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_mobile_no' => $this->emp_mobile_no ?? '',
            'leave_category' => $this->category_name ?? '',
            'leave_type' => $this->leave_day ?? '',
            // 'shift_type' => $this->shift_type ?? '',
            'shift_type' => ($this->shift_type) == 1 ? 'First Half': (($this->shift_type) == 2 ?'Second Half' : '') ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'days' => (string)$this->days ?? '',
            'reason' => $this->reason ?? '',
            'initial_level_role_id' => (string)$this->initial_level_role_id ?? '',
            'previous_by_role_id' => (string)$this->previous_by_role_id ?? '',
            'forward_by_role_id' => (string)$this->forward_by_role_id ?? '',
            'forward_by_status' => (string)$this->forward_by_status ?? '',
            'final_level_role_id' => (string)$this->final_level_role_id ?? '',
            'process_complete' => (string)$this->process_complete ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''

            // 'leave_category' => ($this->leave_category) ==1 ? 'Full Day': (($this->leave_category) ==2 ? 'Half Day' : '' )?? '',
            
            // 'emp_mobile_no' => $this->emp_mobile_no ?? '',
           
        ];
    }
}
?>