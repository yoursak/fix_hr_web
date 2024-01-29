<?php namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserHolidayListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'process_check' => (int) $this->process_check,
            'holiday_type_id' => (int) $this->holiday_type_id,
            'holiday_package_id' => (int) $this->holiday_package_id,
            'business_id' => (string) $this->business_id,
            'holiday_name' => (string) $this->holiday_name,
            'holiday_days' => (String) $this->holiday_days,
            'holiday_date' => (string) $this->holiday_date,
            'from_start' => (string) $this->from_start,
            'to_end' => (string) $this->to_end,
        ];
    }
}
