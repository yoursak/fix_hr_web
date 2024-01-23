<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalEmployeeDetails extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_mname' => $this->emp_mname ?? '', // If emp_mname is null??'', set a default value ('N/A' in this case)
            'emp_lname' => $this->emp_lname ?? '', // If emp_lname is null??'', set a default value ('N/A' in this case)
            'department_id' => $this->department_id ?? '',
            'designation_id' => $this->designation_id ?? '',
            'is_admin' => $this->is_admin ?? '',
            'role_id' => $this->role_id ?? '',
            'employee_type' => $this->employee_type ?? '',
            'emp_mobile_number' => $this->emp_mobile_number ?? '',
            'emp_email' => $this->emp_email ?? '',
            // 'date' => $this->date ? date('d-m-Y', strtotime($this->date)) : '',

            'emp_date_of_birth' => $this->emp_date_of_birth ? date('d-m-Y', strtotime($this->emp_date_of_birth)) : '' ?? '',
            'emp_date_of_joining' => $this->emp_date_of_joining ? date('d-m-Y', strtotime($this->emp_date_of_joining)) : ''  ?? '',
            'emp_gender' => $this->emp_gender ?? '',
            'emp_address' => $this->emp_address ?? '',
            'emp_country' => $this->emp_country ?? '',
            'emp_state' => $this->emp_state ?? '',
            'emp_city' => $this->emp_city ?? '',
            'emp_pin_code' => $this->emp_pin_code ?? '',
            'emp_shift_type' => $this->emp_shift_type ?? '',
            'emp_attendance_method' => $this->emp_attendance_method ?? '',
            'emp_status' => $this->emp_status ?? '',
            'profile_photo' => $this->profile_photo ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
            'gender' => $this->gender ?? '', // If gender is null??'', set a default value ('N/A' in this case)
            'policy_name' => $this->policy_name ?? '',
            'method_name' => $this->method_name ?? '',
            'method_switch' => $this->method_switch ?? '',
            'leave_policy_ids_list' => json_decode($this->leave_policy_ids_list, true),
            'holiday_policy_ids_list' => json_decode($this->holiday_policy_ids_list, true),
            'weekly_policy_ids_list' => json_decode($this->weekly_policy_ids_list, true),
            'shift_settings_ids_list' => json_decode($this->shift_settings_ids_list, true),
            'emp_type_name' => $this->emp_type_name ?? '',
            'attendance_method_name' => $this->attendance_method_name ?? '',
            'attendance_shift_name' => $this->attendance_shift_name ?? '',
            'branch_name' => $this->branch_name ?? '',
            'depart_name' => $this->depart_name ?? '',
            'desig_name' => $this->desig_name ?? '',
            'emp_shift_start' => $this->shift_start ?? '',
            'emp_shift_end' => $this->shift_end ?? '',
        ];



        // return [
        //     // 'id' => $this->id ?? $this->employee_personal_details->id??'',
        //     'emp_role_id' => (string) $this->role_id ?? '',
        //     'emp_id' => $this->emp_id ?? '',
        //     'business_id' => $this->business_id ?? '',
        //     'branch_id' => $this->branch_id ?? '',
        //     'branch_name' => $this->branch_name ?? '',
        //     'department_id' => (string) $this->department_id ?? '',
        //     'department_name' =>  $this->depart_name ?? '',
        //     'designation_id' => (string) $this->designation_id ?? '',
        //     'designation_name' =>  $this->desig_name ?? '',
        //     'employee_type' => (string) $this->employee_type ?? '',
        //     'emp_name' => $this->emp_name ?? '',
        //     'emp_middile_name' => $this->emp_mname ?? '',
        //     'emp_last_name' => $this->emp_lname ?? '',
        //     'emp_mobile_number' => $this->emp_mobile_number ?? '',
        //     'emp_email' => $this->emp_email ?? '',
        //     'emp_date_of_birth' => $this->emp_date_of_birth ?? '',
        //     'emp_date_of_joining' => $this->emp_date_of_joining ?? '',
        //     'emp_gender' => (string) $this->emp_gender ?? '',
        //     'emp_address' => $this->emp_address ?? '',
        //     'emp_country' => $this->emp_country ?? '',
        //     'emp_state' => $this->emp_state ?? '',
        //     'emp_city' => $this->emp_city ?? '',
        //     'emp_pin_code' => $this->emp_pin_code ?? '',
        //     'emp_shift_type' => $this->emp_shift_type ?? '',
        //     'emp_shift_name' => $this->shift_type_name ?? '',
        //     'emp_attendance_method_id' => $this->emp_attendance_method ?? '',
        //     'emp_attendance_method_name' => $this->attendance_method_name ?? '',
        //     'emp_status' => $this->emp_status ?? '',
        //     'emp_profile_photo' => $this->profile_photo ?? '',
        //     'created_at' => $this->created_at ?? '',
        //     'updated_at' => $this->updated_at ?? ''
        // ];
    }
}
