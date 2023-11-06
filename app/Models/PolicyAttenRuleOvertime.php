<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttenRuleOvertime
 * 
 * @property int $id
 * @property bool $switch_is
 * @property int $early_ot_hr
 * @property int $early_ot_min
 * @property int $late_ot_hr
 * @property int $late_ot_min
 * @property int $min_ot_hr
 * @property int $min_ot_min
 * @property int $max_ot_hr
 * @property int $max_ot_min
 * @property string $business_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyAttenRuleOvertime extends Model
{
	protected $table = 'policy_atten_rule_overtime';

	protected $casts = [
		'switch_is' => 'bool',
		'early_ot_hr' => 'int',
		'early_ot_min' => 'int',
		'late_ot_hr' => 'int',
		'late_ot_min' => 'int',
		'min_ot_hr' => 'int',
		'min_ot_min' => 'int',
		'max_ot_hr' => 'int',
		'max_ot_min' => 'int'
	];

	protected $fillable = [
		'switch_is',
		'early_ot_hr',
		'early_ot_min',
		'late_ot_hr',
		'late_ot_min',
		'min_ot_hr',
		'min_ot_min',
		'max_ot_hr',
		'max_ot_min',
		'business_id'
	];
}
