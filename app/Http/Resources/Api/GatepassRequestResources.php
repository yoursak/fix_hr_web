<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class GatepassRequestResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->id,
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' => (string)$this->department_id ?? '',
            'designation_id' => (string)$this->department_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_name' => $this->emp_name ?? '',
            'emp_type' => (string)$this->emp_type ?? '',
            'emp_mobile_no' => $this->emp_mobile_no ?? '',
            'date' => $this->date ?? '',
            'going_through' => $this->going_through ?? '',
            'out_time' => $this->out_time ?? '',
            'in_time' => $this->in_time ?? '',
            'reason' => $this->reason ?? '',
            'status' => $this->status ?? '',
            'profile_photo' => $this->profile_photo ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
           
        ];
    }
}
?>