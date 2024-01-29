<?php
namespace App\Http\Resources\Api\UserSideResponse;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveBalanceListReport extends JsonResource
{
    public function toArray($request)
    {
        return [
            // 'id' => $this->id ?? $this->id,
            // 'category_name' => $this->name ?? '',
            'current_month' => $this->current_month ?? 0,
            'leave_policy_id' => $this->leave_policy_id ?? 0,
            'business_id' => $this->business_id ?? '',
            'policy_type_id' => $this->category_name ?? 0, //category_id
            // 'policy_category_name' => $this->apply_category_name ?? '', //category_name 
            // 'policy_monthly_cycle' => $this->leave_cycle_monthly_yearly ?? 0,
            // 'policy_days' => $this->days,
            // 'policy_unused_leave_rule' => $this->unused_leave_rule,
            // 'policy_carry_forward_limit' => $this->carry_forward_limit,
            // 'policy_applicable_to_gender_id' => $this->applicable_to, //gender ID
            // 'policy_applicable_to_gender_name' => $this->applicable_name, //gender name
            // 'leave_opening' => $this->leave_opening,
            // 'leave_allotted' => $this->leave_allotted,
            // 'leave_taken' => $this->leave_taken,
            // 'leave_remaining' => $this->leave_remaining

        ];
    }
}
?>