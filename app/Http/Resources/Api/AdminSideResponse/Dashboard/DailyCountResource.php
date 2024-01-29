<?php

namespace App\Http\Resources\Api\AdminSideResponse\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyCountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'totalEmp' => $this->totalEmp,
            'present' => $this->present,
            'absent' => $this->absent,
            'late' => $this->late,
            'early' => $this->early,
            'mispunch' => $this->mispunch,
            'halfday' => $this->halfday,
            'overtime' => $this->overtime,
            'leave' => $this->leave,
        ];
    }
}
