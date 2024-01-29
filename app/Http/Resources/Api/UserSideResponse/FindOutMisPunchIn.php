<?php

namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class FindOutMisPunchIn extends JsonResource
{
    public function toArray($request)
    {

        return [
            'punch_in_time' => (String) $this->punch_in_time ?? '00:00:00'
        ];
    }
}