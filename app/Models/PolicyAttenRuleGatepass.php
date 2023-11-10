<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttenRuleGatepass
 * 
 * @property int $id
 * @property int|null $switch_is
 * @property int|null $occurance_is
 * @property int|null $occurance_count
 * @property int|null $occurance_hr
 * @property int|null $occurance_min
 * @property int|null $absent_is
 * @property string $business_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyAttenRuleGatepass extends Model
{
	protected $table = 'policy_atten_rule_gatepass';

	// protected $casts = [
	// 	'switch_is' => 'int',
	// 	'occurance_is' => 'int',
	// 	'occurance_count' => 'int',
	// 	'occurance_hr' => 'int',
	// 	'occurance_min' => 'int',
	// 	'absent_is' => 'int'
	// ];

	protected $fillable = [
		'switch_is',
		'occurance_is',
		'occurance_count',
		'occurance_hr',
		'occurance_min',
		'absent_is',
		'business_id'
	];
}
