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
            'attendance_id' => (string) $this->id ?? '',
            'today_status' => (int) $this->today_status ?? 2,
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
            'forward_by_role_id' => (string) $this->forward_by_role_id ?? '',
            'forward_by_status' => (string) $this->forward_by_status ?? '',
            'final_level_role_id' => (string) $this->final_level_role_id ?? '',
            'final_status' => (string) $this->final_status ?? '',
            'process_complete' => (string) $this->process_complete ?? '',
            'attendance_shift' => (string) $this->attendance_shift ?? '',
            'applied_shift_template_name' => (string) $this->applied_shift_template_name ?? '',
            'applied_shift_type_name' => (string) $this->applied_shift_type_name ?? '',
            'applied_shift_comp_start_time' => is_string($this->applied_shift_comp_start_time) ? Carbon::createFromFormat('H:i:s', $this->applied_shift_comp_start_time)->format('H:i:s') : '00:00:00',
            'applied_shift_comp_end_time' => is_string($this->applied_shift_comp_end_time) ? Carbon::createFromFormat('H:i:s', $this->applied_shift_comp_end_time)->format('H:i:s') : '00:00:00',
            'punch_in_shift_name' => (string) $this->punch_in_shift_name ?? '',
            'punch_out_shift_name' => (string) $this->punch_out_shift_name ?? '',
            'punch_date' => $this->punch_date ?? '',
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
            'approved_by_role_id' => (string) $this->approved_by_role_id ?? '',
            'approved_by_emp_id' => $this->approved_by_emp_id ?? '',
            'shift_name' => $this->shift_name ?? '',
            'shift_start' => is_string($this->shift_start) ? Carbon::createFromFormat('H:i:s', $this->shift_start)->format('H:i:s') : '00:00:00',
            'shift_end' => is_string($this->shift_end) ? Carbon::createFromFormat('H:i:s', $this->shift_end)->format('H:i:s') : '00:00:00',
            'overtime' => ($this->overtime > 0) ? (intval($this->overtime / 60) ? intval($this->overtime / 60) . 'Hr ' : '') . (intval($this->overtime % 60) ? intval($this->overtime % 60) . 'Min' : '') : '', //Carbon::createFromTimestamp()->format('h:i A') ?? '',
            'lateby_time' => ($this->late_by  > 0) ? (intval($this->late_by  / 60) ? intval($this->late_by  / 60) . 'Hr ' : '') . (intval($this->late_by  % 60) ? intval($this->late_by  % 60) . 'Min' : '') : '', //Carbon::createFromTimestamp()->format('h:i A') ?? '',
            'earlyby_time' => ($this->early_exit  > 0) ? (intval($this->early_exit  / 60) ? intval($this->early_exit  / 60) . 'Hr ' : '') . (intval($this->early_exit  % 60) ? intval($this->early_exit  % 60) . 'Min' : '') : '',
            // $this->early_exit ?? ''
            // 'created_at' => $this->created_at ?? '',
            // 'updated_at' => $this->updated_at ?? '',
        ];
    }
}
