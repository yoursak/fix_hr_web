<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class PolicyWeeklyHolidayList extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->holiday_id,
            'holiday_name' => $this->holiday_name,
            'day' => $this->day,
            'date' => $this->holiday_date
        ];
    }
}
