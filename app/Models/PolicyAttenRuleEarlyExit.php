<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttenRuleEarlyExit
 * 
 * @property int $id
 * @property bool $switch_is
 * @property int|null $grace_time_hr
 * @property int|null $grace_time_min
 * @property int|null $occurance_is
 * @property int|null $occurance_count
 * @property int|null $occurance_hr
 * @property int|null $occurance_min
 * @property int|null $absent_is
 * @property int|null $mark_half_day_hr
 * @property int|null $mark_half_day_min
 * @property string|null $business_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyAttenRuleEarlyExit extends Model
{
	protected $table = 'policy_atten_rule_early_exit';

	protected $casts = [
		'switch_is' => 'bool',
		'grace_time_hr' => 'int',
		'grace_time_min' => 'int',
		'occurance_is' => 'int',
		'occurance_count' => 'int',
		'occurance_hr' => 'int',
		'occurance_min' => 'int',
		'absent_is' => 'int',
		'mark_half_day_hr' => 'int',
		'mark_half_day_min' => 'int'
	];

	protected $fillable = [
		'switch_is',
		'grace_time_hr',
		'grace_time_min',
		'occurance_is',
		'occurance_count',
		'occurance_hr',
		'occurance_min',
		'absent_is',
		'mark_half_day_hr',
		'mark_half_day_min',
		'business_id'
	];
}
