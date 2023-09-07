<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->employee_personal_details->id,
            'emp_role_id' => $this->role_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' =>(string) $this->department_id ?? '',
            'designation_id' =>(string)  $this->designation_id ?? '',
            'employee_type' =>(string)  $this->employee_type ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mobile_number' => $this->emp_mobile_number ?? '',
            'emp_email' => $this->emp_email ?? '',
            'emp_date_of_birth' => $this->emp_date_of_birth ?? '',
            'emp_date_of_joining' => $this->emp_date_of_joining ?? '',
            'emp_gender' => (string) $this->emp_gender ?? '',
            'emp_address' => $this->emp_address ?? '',
            'emp_country' => $this->emp_country ?? '',
            'emp_state' => $this->emp_state ?? '',
            'emp_city' => $this->emp_city ?? '',
            'emp_pin_code' => $this->emp_pin_code ?? '',
            'emp_profile_photo' => $this->profile_photo ?? '',
            'created_at'=>$this->created_at??'',
            'updated_at'=>$this->updated_at??''
        ];
    }
}
