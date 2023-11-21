<?php

namespace App\Http\Resources\Api\AdminSideResponse\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// admin
class RequestResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mname' => $this->emp_mname ?? '',
            'emp_lname' => $this->emp_lname ?? '',
            'business_id' => $this->business_id ?? '',
            'shift_type' => (String) $this->shift_type ?? '',
            'leave_type' => (String) $this->leave_type ?? '',
            'leave_category' => (String) $this->leave_category ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'days' => (String) $this->days ?? '',
            'reason' => $this->reason ?? '',
            'final_status' => $this->final_status ?? '',
            'forward_by_role_id' => (String) $this->forward_by_role_id ?? '',
            'forward_by_status' => (String) $this->forward_by_status ?? '',
            'final_level_role_id' => (String) $this->final_level_role_id ?? '',
            'process_complete' => (String) $this->process_complete ?? '',
            // 'punch_in_time' => is_string($this->punch_in_time) ? Carbon::createFromFormat('H:i:s', $this->punch_in_time)->format('H:i:s') : '00:00:00',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}