<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
class MispunchRequestResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? $this->id,
            'business_id' => $this->business_id ?? '',
            'emp_id' => $this->emp_id ?? '',
            'emp_mobile_no' => $this->emp_mobile_no ?? '',
            'emp_miss_date' => $this->emp_miss_date ?? '',
            'emp_miss_time_type' => $this->time_type ?? '',
            'emp_miss_in_time' => $this->emp_miss_in_time ?? '',
            'emp_miss_out_time' => $this->emp_miss_out_time ?? '',
            // 'emp_miss_in_time' => $this->emp_miss_in_time ? Carbon::parse($this->emp_miss_in_time)->format('h:i A') : '' ?? '',
            // 'emp_miss_out_time' => $this->emp_miss_out_time ? Carbon::parse($this->emp_miss_out_time)->format('h:i A') : '' ?? '',
            'emp_working_hour' => $this->emp_working_hour ?? '',
            'reason' => $this->reason ?? '',
            'remark' => $this->remark ?? '',
            'status' => $this->final_status ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
?>

