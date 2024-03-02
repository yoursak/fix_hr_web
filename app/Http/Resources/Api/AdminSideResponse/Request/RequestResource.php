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
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mname' => $this->emp_mname ?? '',
            'emp_lname' => $this->emp_lname ?? '',
            'leave_type' => (string) $this->leave_type ?? '',
            'leave_day' => (string)$this->leave_day ?? '',
            'leave_category' => (string) $this->leave_category ?? '',
            'shift_type' => (string) $this->shift_type ?? '',
            'shift_name' => (string) ($this->shift_type) == 1 ? $this->leave_shift_type : (($this->shift_type) == 2 ? $this->leave_shift_type : '') ?? '',
            'from_date' => $this->from_date ?? '',
            'to_date' => $this->to_date ?? '',
            'apply_date' => $this->apply_date ?? '',
            'days' => (string) $this->days ?? '',
            'reason' => $this->reason ?? '',
            'final_status' => $this->final_status ?? '',
            'forward_by_role_id' => (string) $this->forward_by_role_id ?? '',
            'forward_by_status' => (string) $this->forward_by_status ?? '',
            'final_level_role_id' => (string) $this->final_level_role_id ?? '',
            'process_complete' => (string) $this->process_complete ?? '',
            'leave_remaining' => floatval($this->leave_remaining),
            'leave_summary_debit_value' => floatval($this->leave_summary_debit_value),
            'leave_summary_unpaid_value' => floatval($this->leave_summary_unpaid_value),
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
