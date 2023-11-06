<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticGoingThroughResponse extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? $this->id,
            'going_through' => $this->going_through ?? ''
        ];
    }
}
?>