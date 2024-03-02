<?php

namespace App\Http\Resources\Api\UserSideResponse\OutdoorResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class OutdoorResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'business_id' => $this->business_id ?? '',
            'branch_id' => $this->branch_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'out_time' => $this->out_time    ?? '',
            'apply_date' => $this->apply_date ?? '',
            'reason' => $this->reason ?? '',
            'status' => $this->status ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
        ];
    }
}
