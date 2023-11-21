<?php

namespace App\Http\Resources\Api\AdminSideResponse\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// admin
class RequestMispunchResource extends JsonResource
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
            'shift_type' => (string) $this->emp_shift_type ?? '',
            'emp_miss_date' => (string) $this->emp_miss_date ?? '',
            'emp_miss_time_type' => (string) $this->emp_miss_time_type ?? '',
            'emp_miss_in_time' => $this->emp_miss_in_time ?? '',
            'emp_miss_out_time' => $this->emp_miss_out_time ?? '',
            'emp_working_hour' => (string) $this->emp_working_hour ?? '',
            'reason' => $this->reason ?? '',
            'remark' => $this->remark ?? '',
            'final_status' => $this->final_status ?? '',
            'forward_by_role_id' => (string) $this->forward_by_role_id ?? '',
            'forward_by_status' => (string) $this->forward_by_status ?? '',
            'final_level_role_id' => (string) $this->final_level_role_id ?? '',
            'process_complete' => (string) $this->process_complete ?? '',
            // 'punch_in_time' => is_string($this->punch_in_time) ? Carbon::createFromFormat('H:i:s', $this->punch_in_time)->format('H:i:s') : '00:00:00',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
