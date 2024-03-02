<?php

namespace App\Http\Resources\Api\AdminSideResponse\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginAdminVerify extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // "login_type": "Owner",
        // "description": "To record attendance details of my employee",
        // "business_name": "Infinite Solutions",
        // "business_logo": "10-01-2024_800a303ff14312e5b991a791a31e13f6.jpg",
        // "static_role": 1,
        // "business_id": "e3d64177e51bdff82b499e116796fe74",
        // "email": "jbhasin@fixingdots.com",
        // "is_verified": true,
        // "api_token": "510|C9vyO1OKZ4dhK6te266AxlYsgP2VFgwTgxnkkQg4f77bc152"

        return [
            'login_type' => (string) $this->login_type,
            'description' => (string)$this->business_id ?? '',
            'business_name' => (string) $this->business_name,
            'business_logo' => (string) $this->business_logo,
            'static_role' => (int) $this->static_role,
            'business_id' => (string) $this->business_id,
            'email' => (string)$this->email,
            'is_verified' => (bool) $this->is_verified,
            'api_token' => (string) $this->api_token
        ];
    }
}
