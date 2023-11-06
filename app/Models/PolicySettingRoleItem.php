<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySettingRoleItem
 * 
 * @property int $id
 * @property int|null $role_create_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $model_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicySettingRoleItem extends Model
{
	protected $table = 'policy_setting_role_items';

	protected $casts = [
		'role_create_id' => 'int'
	];

	protected $fillable = [
		'role_create_id',
		'business_id',
		'branch_id',
		'model_name'
	];
}
