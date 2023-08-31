<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        
        
            // user found

        return [
            // "Gellow"
            // 'company_id' =>$this->comp_id ?? '',
            // 'company_name' =>$this->comp_name ?? '',
            // 'company_billing_name' =>$this->comp_billing_name ?? '',
            // 'company_unique_id' =>$this->comp_unique_id ?? '',
            // 'company_logo'=>$this->comp_logo!=null?json_decode($this->comp_logo):[null],
            // 'company_phone' =>$this-> comp_phn ?? '',
            // 'company_email' =>$this-> comp_email ?? '',
            // 'company_gst' =>$this-> comp_gst ?? '',
            // 'company_panno' =>$this-> comp_pan ?? '',
            // 'company_address1' =>$this-> comp_address1 ?? '',
            // 'company_address2' =>$this-> comp_address2 ?? '',
            // 'company_ex_work' =>$this-> comp_ex_work ?? '',
            // 'company_pin' =>$this-> comp_pin ?? '',
            // 'company_city' =>CityResource::collection([$this->city])->all(),
            // 'company_state' =>StateResource::collection([$this->state])->all(),
            // 'company_country' =>CountryResource::collection([$this->country])->all(),
            // 'company_status' =>$this->comp_status ?? '',
            // 'business_id' => $this->session()->get('business_id'),
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
            // 'created_at' => now(),
            // 'updated_at' => now()   
        ];
    }


}
