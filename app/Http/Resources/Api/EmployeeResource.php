<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->employee_personal_details->id,
            // 'user_company_id' => $this->comp_id ?? $this->company_detail->comp_id,
            'employee_type' => $this->employee_type ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_mobile_number' => $this->emp_mobile_number ?? '',
            'emp_email' => $this->emp_email ?? '',
            'emp_branch' => $this->emp_branch ?? '',
            'emp_department' => $this->emp_department ?? '',
            'emp_designation' => $this->emp_designation ?? '',
            'emp_date_of_birth' => $this->emp_date_of_birth ?? '',
            'emp_date_of_joining' => $this->emp_date_of_joining ?? '',
            'emp_gender' => $this->emp_gender ?? '',
            'emp_address' => $this->emp_address ?? '',
            'emp_country' => $this->emp_country ?? '',
            'emp_state' => $this->emp_state ?? '',
            'emp_city' => $this->emp_city ?? '',
            'emp_pin_code' => $this->emp_pin_code ?? '',
            'profile_photo' => $this->profile_photo ?? '',
        ];
    }
}
