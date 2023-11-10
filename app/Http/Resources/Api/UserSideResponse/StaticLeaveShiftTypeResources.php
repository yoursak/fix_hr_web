<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticLeaveShiftTypeResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->id,
            'leave_shift_type' => $this->leave_shift_type ?? '',
        ];
    }
}
?>
