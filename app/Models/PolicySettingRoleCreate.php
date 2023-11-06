<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySettingRoleCreate
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $roles_name
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingRoleCreate extends Model
{
	protected $table = 'policy_setting_role_create';

	protected $fillable = [
		'business_id',
		'branch_id',
		'roles_name',
		'description'
	];
}
