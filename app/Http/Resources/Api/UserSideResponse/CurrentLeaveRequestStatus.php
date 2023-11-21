<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrentLeaveRequestStatus extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'applied_cycle_type' => $this->applied_cycle_type ?? '',
            'business_id' => (string)$this->business_id ?? '',
            'all_request_id' =>(string) $this->all_request_id ?? '',
            'role_id' => (string)$this->role_id ?? '',
            'roles_name'=>(string)$this->roles_name ??'',
            'emp_id' =>(string) $this->emp_id ?? '',
            'remarks' => $this->remarks ?? '',
            'status' => (string) $this->status ?? '',
            'prev_role_id' => $this->prev_role_id ?? '',
            'current_role_id' => (string) $this->current_role_id ?? '',
            'next_role_id' => $this->next_role_id ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
        ];
    }
}
?>