<?php


namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveBalanceListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'current_month' => $this->resource['current_month'],
            'current_running_monthly_yearly_balance' => (float) $this->resource['checking_monthly_yearly'],
            'leave_policy_id' => $this->resource['leave_policy_id'],
            'business_id' => $this->resource['business_id'],
            'policy_type_id' => $this->resource['policy_type_id'],
            'policy_category_name' => $this->resource['policy_category_name'],
            'policy_monthly_cycle' => $this->resource['policy_monthly_cycle'],
            'policy_days' => $this->resource['policy_days'],
            'policy_unused_leave_rule' => $this->resource['policy_unused_leave_rule'],
            'policy_carry_forward_limit' => $this->resource['policy_carry_forward_limit'],
            'policy_applicable_to_gender_id' => $this->resource['policy_applicable_to_gender_id'],
            'policy_applicable_to_gender_name' => $this->resource['policy_applicable_to_gender_name'],
            'leave_opening' => (float) $this->resource['leave_opening'],
            'leave_allotted' => (float) $this->resource['leave_allotted'],
            'leave_taken' => (float) $this->resource['leave_taken'],
            'leave_remaining' => (float) $this->resource['leave_remaining']
        ];
    }
}
