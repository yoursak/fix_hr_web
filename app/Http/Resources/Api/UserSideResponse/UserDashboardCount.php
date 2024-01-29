<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDashboardCount extends JsonResource
{
    public function toArray($request)
    {

        return [
            // 'id' => $this->id ?? 0,
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            "month" => (int) $this->month ?? 0,
            "year" => (int) $this->year ?? 0,
            "present" => (int) $this->present ?? 0,
            "absent" => (int) $this->absent ?? 0,
            "late" => (int) $this->late ?? 0,
            "eearly_exit" => (int) $this->early_exit ?? 0,
            "mispunch" => (int) $this->mispunch ?? 0,
            "holiday" => (int) $this->holiday ?? 0,
            "week_off" => (int) $this->week_off ?? 0,
            "half_day" => (int) $this->half_day ?? 0,
            "overtime" => (int)$this->overtime ?? 0,
            "leave" => (int) $this->leave ?? 0,
        ];
    }
}
