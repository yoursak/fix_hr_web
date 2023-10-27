<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAttendanceIdToDataResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->attendance_list->id,
            'working_from_method' => (string)$this->working_from_method ?? '',
            'method_auto' => (string)$this->method_auto ?? '',
            'method_manual' => (string)$this->method_manual ?? '',
            'marked_in_mode' => (string)$this->marked_in_mode ?? '',
            'marked_out_mode' => (string)$this->marked_out_mode ?? '',
            'active_qr_mode' => (string)$this->active_qr_mode ?? '',
            'active_selfie_mode' => (string)$this->active_selfie_mode ?? '',
            'active_face_mode' => (string)$this->active_face_mode ?? '',
            'active_location_tab_mode' => (string)$this->active_location_tab_mode ?? '',
            'attendance_status' => (string)$this->attendance_status ?? '',
            'attendance_shift' => (string)$this->attendance_shift ?? '',
            'punch_date' => (string)$this->punch_date ?? '',
            'emp_id' => (string)$this->emp_id ?? '',
            'business_id' => (string)$this->business_id ?? '',
            'branch_id' => (string)$this->branch_id ?? '',
            'emp_today_current_status' => (string)$this->emp_today_current_status ?? '',
            'punch_in_selfie' => (string)$this->punch_in_selfie ?? '',
            'punch_in_time' => (string)$this->punch_in_time ?? '',
            'punch_in_location_tag' => (string)$this->punch_in_location_tag ?? '',
            'punch_in_address' => (string)$this->punch_in_address ?? '',
            'punch_in_latitude' => (string)$this->punch_in_latitude ?? '',
            'punch_in_longitude' => (string)$this->punch_in_longitude ?? '',
            'punch_out_selfie' => (string)$this->punch_out_selfie ?? '',
            'punch_out_time' => (string)$this->punch_out_time ?? '',
            'punch_out_address' => (string)$this->punch_out_address ?? '',
            'punch_out_location_tag' => (string)$this->punch_out_location_tag ?? '',
            'total_working_hour' => (string)$this->total_working_hour ?? '',
            'created_at'=>$this->created_at??'',
            'updated_at'=>$this->updated_at??'',
        ];
    }
}