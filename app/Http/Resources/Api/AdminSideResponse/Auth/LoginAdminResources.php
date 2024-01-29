<?php

namespace App\Http\Resources\Api\AdminSideResponse\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// admin
class LoginAdminResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? 0,
            'business_id' => $this->business_id ?? '',
            'email' => (String) $this->email ?? '',
            'is_verified' => $this->is_verified ?? '',
            'api_token' => $this->api_token ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
        // 'is_admin' => $this->is_admin ?? '', //is_string($this->punch_out_time) ? Carbon::createFromFormat('H:i:s', $this->punch_out_time)->format('H:i:s') : '00:00:00',
        //     'role_id' => $this->role_id ?? '',
        //     'emp_id' => $this->emp_id ?? '',
        //     'business_id' => $this->business_id ?? '',
        //     'department_id' => $this->department_id ?? '',
        //     'branch_id' => $this->branch_id ?? '',
        //     'branch_name' => $this->branch_name ?? '',
        //     'depart_name' => $this->depart_name ?? '',
        //     'designation_id' => $this->designation_id ?? '',
        //     'desig_name' => $this->desig_name ?? '',
        //     'login_type_name' => $this->login_type_name ?? '',
        //     'master_endgame_id' => $this->master_endgame_id ?? '', // is_string($this->punch_in_time) ? Carbon::createFromFormat('H:i:s', $this->punch_in_time)->format('H:i:s') : '00:00:00',
        //     'role_name' => $this->role_name ?? '',
        //     'emp_name' => $this->emp_name ?? '',
        //     'emp_mname' => $this->emp_mname ?? '',
        //     'emp_lname' => $this->emp_lname ?? '',
        //     'emp_email' => $this->emp_email ?? '',
        //     'emp_mobile_number' => $this->emp_mobile_number ?? '',
        //     'employee_type' => $this->emp_type_name ?? '',
        //     'emp_date_of_birth' => $this->emp_date_of_birth ?? '',
        //     'emp_date_of_joining' => $this->emp_date_of_joining ?? '',
        //     'gender' => $this->gender ?? '',
    }
}
