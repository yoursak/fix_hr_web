<?php

namespace App\Http\Resources\Api\AdminSideResponse\Auth;
// app/Http/Resources/Api/AdminSideResponse/Auth
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

// admin
class LoginSuperAdminResources extends JsonResource
{
    public function toArray($request)
    {

        return   [
            'id' => $this->id,
            'business_id' => $this->business_id ?? '',
            'call_back_id' => $this->call_back_id ?? '',
            'login_type' => $this->login_type ?? '',
            'login_type_name' => $this->login_type_name ?? '',
            'business_type_name' => $this->business_type_name ?? '',
            'business_categories_name' => $this->business_categories_name ?? '',
            'business_email' => $this->business_email ?? '', //is_string($this->punch_out_time) ? Carbon::createFromFormat('H:i:s', $this->punch_out_time)->format('H:i:s') : '00:00:00',
            'business_logo' => $this->business_logo ?? '',
            'business_name' => $this->business_name ?? '',
            'mobile_no' => $this->mobile_no ?? '',
            'business_categories_name' => $this->business_categories_name ?? '',
            'gstnumber' => $this->gstnumber ?? '',
            'city' => $this->city ?? '',
            'state' => $this->state ?? '',
            'country' => $this->country ?? '',
            'pin_code' => $this->pin_code ?? '',
            'business_address' => $this->business_address ?? '',
            'is_verified' => $this->is_verified ?? '',
            'api_token' => $this->api_token ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
