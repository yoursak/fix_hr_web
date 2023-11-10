<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveCategoryResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->id,
            'category_name' => $this->category_name ?? '',
        ];
    }
}
?>
