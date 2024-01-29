<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLeaveIdToDataResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'leave_type' => (string)$this->leave_type ?? '',
            'leave_category' => (string)$this->leave_category ?? '',
            'shift_type' => (string)$this->shift_type ?? '', 
            'from_date' => $this->from_date ?? '', 
            'to_date' => $this->to_date ?? '', 
            'days' => (string)$this->days ?? '', 
            'reason' => $this->reason ?? '', 
            'status' => (string)$this->status ?? '', 
            'from_date' => $this->from_date ?? '', 
            'created_at' => $this->created_at ?? '', 
            'updated_at' => $this->updated_at ?? '', 
         
        ];
    }
}