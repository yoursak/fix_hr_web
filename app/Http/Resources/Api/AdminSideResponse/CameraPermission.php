<?php

namespace App\Http\Resources\Api\AdminSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class CameraPermission extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'business_check' => $this->business_check ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => (string) $this->branch_id ?? '',
            'branch_check' => (int) $this->branch_check ?? 0,
            'branch_email' => (string) $this->branch_email ?? '',
            'business_name' => (string) $this->business_name ?? '',
            'branch_name' => (string) $this->branch_name ?? '',
            'mode_check' => $this->mode_check ?? '', //office wfh remote
            'attendance_mode_type' => (int) $this->type_check ?? 0,
            'is_active' => (int) $this->is_active ?? 0,
            'check_camera' => $this->check_camera ?? '',
            'imei_number' => (string) $this->imei_number ?? '',
            'address' => (string) $this->address ?? '',
            'logitude' => (string) $this->logitude ?? '',
            'latitude' => (string) $this->latitude ?? '',
        ];
    }
}
