<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySettingLeaveCategory
 * 
 * @property int $id
 * @property string|null $leave_type
 * @property int|null $leave_policy_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $category_name
 * @property int|null $leave_cycle_monthly_yearly
 * @property int|null $days
 * @property string|null $unused_leave_rule
 * @property int|null $carry_forward_limit
 * @property string|null $applicable_to
 * @property int|null $martial_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingLeaveCategory extends Model
{
	protected $table = 'policy_setting_leave_category';
	protected $primary_id = 'id';
	protected $business_id = 'business_id';

	protected $fillable = [
		'leave_policy_id',
		'business_id',
		'category_name',
		'leave_cycle_monthly_yearly',
		'days',
		'unused_leave_rule',
		'carry_forward_limit',
		'applicable_to'
	];
}
