<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticRequestLeaveTypeResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->id,
            'leave_day' => $this->leave_day ?? '',
        ];
    }
}
?>
