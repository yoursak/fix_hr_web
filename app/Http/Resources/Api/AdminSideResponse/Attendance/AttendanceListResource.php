<?php

namespace App\Http\Resources\Api\AdminSideResponse\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// admin
class AttendanceListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mname' => $this->emp_mname ?? '',
            'emp_lname' => $this->emp_lname ?? '',
            'working_from_method' => $this->working_from_method ?? '',
            'punch_selfie_mode' => $this->punch_selfie_mode ?? '',
            'punch_qr_mode' => $this->punch_qr_mode ?? '',
            'punch_location_tab_mode' => $this->punch_location_tab_mode ?? '',
            'attendance_status' => $this->attendace_status ?? '',
            'punch_date' => $this->punch_date ?? '',
            'business_id' => $this->business_id ?? '',
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
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}