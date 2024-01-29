<?php

namespace App\Http\Resources\Api\AdminSideResponse\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PendingApprovalCountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'attendance_pending_count' => $this->resource[0],
            'mispunch_pending_count' => $this->resource[1],
            'leave_pending_count' => $this->resource[2],
        ];
    }
}
