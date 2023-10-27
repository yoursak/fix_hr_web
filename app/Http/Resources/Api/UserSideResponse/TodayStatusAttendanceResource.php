<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class TodayStatusAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'emp_id' => $this->emp_id ?? '',
            'working_from_method' => (int) $this->working_from_method ?? 0,
            "method_auto" => (int) $this->method_auto ?? 0,
            "method_manual" => (int) $this->method_manual ?? 0,
            "marked_in_mode" => (int) $this->marked_in_mode ?? 0,
            "marked_out_mode" => (int) $this->marked_out_mode ?? 0,
            "active_selfie_mode" => (int) $this->active_selfie_mode ?? 0,
            "active_qr_mode" => (int) $this->active_qr_mode ?? 0,
            "active_face_mode" => (int) $this->active_face_mode ?? 0,
            "active_location_tab_mode" => $this->active_location_tab_mode ?? '',
            "attendance_status" => (int) $this->attendance_status ?? 0,
            'punch_date' => $this->punch_date ?? '',
            'punch_in_selfie' => $this->punch_in_selfie ?? '',
            'punch_in_time' => $this->punch_in_time ?? '',
            'punch_in_latitude' => $this->punch_in_latitude ?? '',
            'punch_in_longitude' => $this->punch_in_longitude ?? '',
            'punch_in_address' => $this->punch_in_address ?? '',
            'punch_out_selfie' => $this->punch_out_selfie ?? '',
            'punch_out_time' => $this->punch_out_time ?? '',
            'punch_out_latitude' => $this->punch_out_latitude ?? '',
            'punch_out_longitude' => $this->punch_out_longitude ?? '',
            'punch_out_address' => $this->punch_out_address ?? '',
            'total_working_hour' => $this->total_working_hour ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : '',
        ];
        // return parent::toArray($request);
    }
}
