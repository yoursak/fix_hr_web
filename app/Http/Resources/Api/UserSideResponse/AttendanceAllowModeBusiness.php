<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceAllowModeBusiness extends JsonResource
{
    public function toArray($request)
    {
        return [
            "attendance_active_methods" => $this->attendance_active_methods ?? [],
            "office_auto" => (int) !empty($this->office_auto) ?? 0,
            "office_manual" => (int)!empty($this->office_manual) ?? 0,
            "office_qr" => (int) !empty($this->office_qr) ?? 0,
            "office_face_id" => (int) !empty($this->office_face_id) ?? 0,
            "office_selfie" => (int)!empty($this->office_selfie) ?? 0,
            "outdoor_auto" => (int) !empty($this->outdoor_auto)  ?? 0,
            "outdoor_manual" => (int) !empty($this->outdoor_manual)  ?? 0,
            "outdoor_selfie" => (int)!empty($this->outdoor_selfie)  ?? 0,
            "wfh_auto" => (int) !empty($this->wfh_auto) ?? 0,
            "wfh_manual" => (int)!empty($this->wfh_manual)  ?? 0,
            "wfh_selfie" => (int) !empty($this->wfh_selfie) ?? 0,
        ];
    }
}
