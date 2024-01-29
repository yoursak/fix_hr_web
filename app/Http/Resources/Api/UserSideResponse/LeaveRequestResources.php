<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? 0,
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'leave_day' => (string)$this->leave_day ?? '',
            'leave_category' => $this->leave_category ?? '',
            'shift_type' => (string) ($this->shift_type) == 1 ? $this->leave_shift_type : (($this->shift_type) == 2 ? $this->leave_shift_type : '') ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'days' => (floatval($this->days)) ?? '',
            'reason' => $this->reason ?? '',
            'forward_by_role_id' => (string)$this->forward_by_role_id ?? '',
            'forward_by_status' => (string)$this->forward_by_status ?? '',
            'final_level_role_id' => (string)$this->final_level_role_id ?? '',
            'final_status' => (string)$this->final_status ?? '',
            'process_complete' => (int)$this->process_complete ?? '',
            'leave_remaining' => floatval($this->leave_remaining),
            'leave_summary_debit_value' => floatval($this->leave_summary_debit_value),
            'leave_summary_unpaid_value' => floatval($this->leave_summary_unpaid_value),
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
    // "id": 51,
    //     "business_id": "e3d64177e51bdff82b499e116796fe74",
    //     "emp_id": "IT008",
    //     "leave_type": 1,
    //     "leave_category": "Casual leave (CL)",
    //     "shift_type": 0,
    //     "from_date": "2023-12-28",
    //     "to_date": "2023-12-28",
    //     "days": 1,
    //     "reason": "Testing",
    //     "forward_by_role_id": "-1",
    //     "forward_by_status": 1,
    //     "final_level_role_id": "6",
    //     "final_status": 1,
    //     "process_complete": "1",
    //     "created_at": "2023-12-28T05:58:07.000000Z",
    //     "updated_at": "2023-12-29T07:45:15.000000Z",
    //     "leave_day": "Full Day",
    //     "leave_shift_type": null
}
