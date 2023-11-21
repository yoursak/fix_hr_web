<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserAttendanceResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            // 'emp_id' => $this->emp_id ?? '',
            'id' => $this->id,
            'emp_id' => $this->emp_id ?? $this->emp_id,
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'method_auto' => $this->method_auto ?? '',
            'method_manual' => $this->method_manual ?? '',
            'marked_in_mode' => $this->marked_in_mode ?? '',
            'marked_out_mode' => $this->marked_out_mode ?? '',
            'active_qr_mode' => $this->active_qr_mode ?? '',
            'active_selfie_mode' => $this->active_selfie_mode ?? '',
            'active_face_mode' => $this->active_face_mode ?? '',
            'active_location_tab_mode' => $this->active_location_tab_mode ?? '',
            'attendance_status' => $this->attendance_status ?? '',
            'attendance_shift' => $this->attendance_shift ?? '',
            'punch_date' => $this->punch_date ?? '',
            'attendance_shift' => $this->attendance_shift ?? '',
            'emp_today_current_status' => $this->emp_today_current_status ?? '',
            'punch_in_selfie' => $this->punch_in_selfie ?? '',
            'punch_in_time' => is_string($this->punch_in_time) ? Carbon::createFromFormat('H:i:s', $this->punch_in_time)->format('H:i:s') : '00:00:00',
            'punch_in_location_tag' => $this->punch_out_location_tag ?? '',
            'punch_in_address' => $this->punch_in_address ?? '',
            'punch_in_latitude' => $this->punch_in_latitude ?? '',
            'punch_in_longitude' => $this->punch_in_longitude ?? '',
            'punch_out_selfie' => $this->punch_out_selfie ?? '',
            'punch_out_time' => is_string($this->punch_out_time) ? Carbon::createFromFormat('H:i:s', $this->punch_out_time)->format('H:i:s') : '00:00:00',
            'punch_out_address' => $this->punch_out_address ?? '',
            'punch_out_latitude' => $this->punch_out_latitude ?? '',
            'punch_out_longitude' => $this->punch_out_longitude ?? '',
            'punch_out_location_tag' => $this->punch_out_location_tag ?? '',
            'total_working_hour' => $this->total_working_hour ?? '',
            'approved_by_role_id' => $this->approved_by_role_id ?? '',
            'approved_by_emp_id' => $this->approved_by_emp_id ?? '',
            'shift_name' => $this->shift_name ?? '',
            'shift_start' => is_string($this->shift_start) ? Carbon::createFromFormat('H:i:s', $this->shift_start)->format('H:i:s') : '00:00:00',
            'shift_end' => is_string($this->shift_end) ? Carbon::createFromFormat('H:i:s', $this->shift_end)->format('H:i:s') : '00:00:00',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}