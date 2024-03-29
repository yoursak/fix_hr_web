<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGatepassIdToDataResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'department_id' => $this->department_id ?? '',
            'designation_id' => $this->designation_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'date' => $this->date ?? '',
            'going_through' => $this->going_through ?? '',
            'in_time' => $this->in_time ?? '',
            'out_time' => $this->out_time ?? '',
            'reason' => $this->reason ?? '',
            'remark' => $this->remark ?? '',
            'status' => $this->status ?? '',
            'forward_by_role_id' => (string)$this->forward_by_role_id ?? '',
            'forward_by_status' => (string)$this->forward_by_status ?? '',
            'final_level_role_id' => (string)$this->final_level_role_id ?? '',
            'final_status' => (string)$this->final_status ?? '',
            'process_complete' => (int)$this->process_complete ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
