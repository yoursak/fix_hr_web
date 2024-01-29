<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySettingLeavePolicy
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $policy_name
 * @property bool|null $leave_policy_cycle_monthly
 * @property bool|null $leave_policy_cycle_yearly
 * @property Carbon|null $leave_period_from
 * @property Carbon|null $leave_period_to
 * @property Carbon|null $sandwich_leaves_count
 * @property Carbon|null $sandwich_leaves_ignore
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingLeavePolicy extends Model
{
	protected $table = 'policy_setting_leave_policy';
	protected $primary_key = 'id';
	protected $business_id = 'business_id';


	protected $fillable = [
		'business_id',
		'policy_name',
		'leave_period_from',
		'leave_period_to',
		'sandwich_leaves_count',
		'sandwich_leaves_ignore'
	];
}
