<?php

namespace App\Http\Resources\Api\AdminSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class CameraPermission extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id ??'',
            'mode_check' => $this->mode_check?? '',
            'business_check' => $this->business_check ?? '',
            'brand_check' => $this->brand_check ?? '',
            'business_id' => $this->business_id ?? '',
            'brand_id' => $this->brand_id ?? '',
            'mobile_ip' =>(string)  $this->mobile_ip ?? '',
            'imei_number' =>(string)  $this->imei_number ?? '',
            'check_camera' => $this->check_camera ?? '',
            'created_at'=>$this->created_at??'',
            'updated_at'=>$this->updated_at??''
        ];
    }
}
