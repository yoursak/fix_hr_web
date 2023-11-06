<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLoginResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            // 'id' => $this->id ?? $this->login_employee->id,
            'emp_id' => $this->emp_id ?? '',
            'business_id' => $this->business_id ?? '',
            // 'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'country_code' => $this->country_code ?? '',
            'phone' => $this->phone ?? '',
            // 'otp' => $this->otp ?? '',
            // 'otp_created_at' => $this->otp_created_at ?? '',
        ];
    }
}
 