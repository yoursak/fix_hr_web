<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApprovalManagementCycle
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $department_id
 * @property string|null $desgination_id
 * @property bool|null $cycle_type
 * @property string|null $role_id
 * @property bool|null $checked_status
 * @property bool|null $initial_status
 * @property bool|null $current_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ApprovalManagementCycle extends Model
{
	protected $table = 'approval_management_cycle';

	// protected $casts = [
	// 	'cycle_type' => 'bool',
	// 	'checked_status' => 'bool',
	// 	'initial_status' => 'bool',
	// 	'current_status' => 'bool'
	// ];

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'desgination_id',
		'cycle_type',
		'role_id',
		'checked_status',
		'initial_status',
		'current_status'
	];
}
