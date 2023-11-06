<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class GatepassRequestResources extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->id,
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'date' => $this->date ? date('d-m-Y', strtotime($this->date)) : '',
            'source' => $this->source ?? '',
            'destination' => $this->destination ?? '',
            'going_through' => $this->going_through ?? '',
            'in_time' => $this->in_time ?? '',
            'out_time' => $this->out_time ?? '',
            'reason' => $this->reason ?? '',
            'status' => $this->status ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? ''
           
        ];
    }
}
?>