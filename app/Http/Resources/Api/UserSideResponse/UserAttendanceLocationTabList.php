<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserAttendanceLocationTabList extends JsonResource
{
    public function toArray($request)
    {

        return [
            'punch_time' => (string) $this->punch_time ?? '',
            'latitude' => (string) $this->latitude ?? '',
            'logitude' => (string) $this->logitude ?? '',
            'address' => (string) $this->address ?? '',
        ];
    }
}
