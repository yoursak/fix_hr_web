<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySettingRoleAssignPermission
 *
 * @property int $id
 * @property string|null $business_id
 * @property string|null $emp_id
 * @property int|null $role_id
 * @property string|null $branch_id
 * @property string|null $department_id
 * @property string|null $designation_id
 * @property bool $permission_type
 * @property string $permission_branch_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingRoleAssignPermission extends Model
{
	protected $table = 'policy_setting_role_assign_permission';

	// protected $casts = [
	// 	'role_id' => 'int',
	// 	'permission_type' => 'bool'
	// ];

	protected $fillable = [
		'business_id',
		'emp_id',
		'role_id',
		'branch_id',
		'department_id',
		'designation_id',
		'permission_type',
		'permission_branch_id'
	];
}
