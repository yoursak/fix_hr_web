<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SettingLeavePolicy
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $policy_name
 * @property bool|null $leave_policy_cycle_monthly
 * @property bool|null $leave_policy_cycle_yearly
 * @property Carbon|null $leave_period_from
 * @property Carbon|null $leave_period_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class SettingLeavePolicy extends Model
{
	protected $table = 'setting_leave_policy';

	// protected $casts = [
	// 	'leave_policy_cycle_monthly' => 'bool',
	// 	'leave_policy_cycle_yearly' => 'bool',
	// 	'leave_period_from' => 'datetime',
	// 	'leave_period_to' => 'datetime'
	// ];

	// protected $fillable = [
	// 	'business_id',
	// 	'branch_id',
	// 	'policy_name',
	// 	'leave_policy_cycle_monthly',
	// 	'leave_policy_cycle_yearly',
	// 	'leave_period_from',
	// 	'leave_period_to'
	// ];
}
