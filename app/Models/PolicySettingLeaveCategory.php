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
 * @property int|null $leave_policy_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $category_name
 * @property int|null $days
 * @property string|null $unused_leave_rule
 * @property int|null $carry_forward_limit
 * @property string|null $applicable_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingLeaveCategory extends Model
{
	protected $table = 'policy_setting_leave_category';

	protected $casts = [
		'leave_policy_id' => 'int',
		'days' => 'int',
		'carry_forward_limit' => 'int'
	];

	protected $fillable = [
		'leave_policy_id',
		'business_id',
		'branch_id',
		'category_name',
		'days',
		'unused_leave_rule',
		'carry_forward_limit',
		'applicable_to'
	];
}
