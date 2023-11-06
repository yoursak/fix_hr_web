<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttenRuleBreak
 * 
 * @property int $id
 * @property bool|null $switch_is
 * @property bool|null $is_break_hr_deduct
 * @property int|null $break_extra_hr
 * @property int|null $break_extra_min
 * @property bool|null $occurance_is
 * @property int|null $occurance_hr
 * @property int|null $occurance_min
 * @property int|null $occurance_count
 * @property bool|null $absent_is
 * @property string|null $business_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyAttenRuleBreak extends Model
{
	protected $table = 'policy_atten_rule_break';

	protected $casts = [
		'switch_is' => 'bool',
		'is_break_hr_deduct' => 'bool',
		'break_extra_hr' => 'int',
		'break_extra_min' => 'int',
		'occurance_is' => 'bool',
		'occurance_hr' => 'int',
		'occurance_min' => 'int',
		'occurance_count' => 'int',
		'absent_is' => 'bool'
	];

	protected $fillable = [
		'switch_is',
		'is_break_hr_deduct',
		'break_extra_hr',
		'break_extra_min',
		'occurance_is',
		'occurance_hr',
		'occurance_min',
		'occurance_count',
		'absent_is',
		'business_id'
	];
}
