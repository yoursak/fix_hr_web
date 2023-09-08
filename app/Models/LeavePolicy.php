<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeavePolicy
 * 
 * @property int $id
 * @property string $policy_name
 * @property string $leave_policy_cycle
 * @property string $leave_period_from
 * @property string $leave_period_to
 * @property string $category_name
 * @property string $days
 * @property string $unused_leave_rule
 * @property string $carry_forward_limit
 * @property string $applicable_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class LeavePolicy extends Model
{
	protected $table = 'leave_policy';

	protected $fillable = [
		'policy_name',
		'leave_policy_cycle',
		'leave_period_from',
		'leave_period_to',
		'category_name',
		'days',
		'unused_leave_rule',
		'carry_forward_limit',
		'applicable_to'
	];
}
