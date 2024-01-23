<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyMasterEndgameMethod
 * 
 * @property int $id
 * @property string|null $business_id
 * @property bool|null $method_switch
 * @property string|null $method_name
 * @property int|null $policy_preference
 * @property bool|null $level_type
 * @property string|null $leave_policy_ids_list
 * @property string|null $holiday_policy_ids_list
 * @property string|null $weekly_policy_ids_list
 * @property string|null $shift_settings_ids_list
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicyMasterEndgameMethod extends Model
{

	protected $table = 'policy_master_endgame_method';
	protected $primary_key = 'id';
	// protected $casts = [
	// 	'method_switch' => 'bool',
	// 	'policy_preference' => 'int',
	// 	'level_type' => 'bool'
	// ];

	// protected $fillable = [
	// 	'business_id',
	// 	'method_switch',
	// 	'method_name',
	// 	'policy_preference',
	// 	'level_type',
	// 	'leave_policy_ids_list',
	// 	'holiday_policy_ids_list',
	// 	'weekly_policy_ids_list',
	// 	'shift_settings_ids_list'
	// ];
}
