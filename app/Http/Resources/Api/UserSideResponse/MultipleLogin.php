<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class MultipleLogin extends JsonResource
{
    public function toArray($request)
    {
        return [
            'emp_id' => (string) $this->emp_id ?? '',
            'business_id' => (string) $this->business_id ?? '',
            'email' => (string) $this->emp_email ?? '',
            'phone' => (string) $this->emp_mobile_number ?? '',
        ];
    }
}
?>