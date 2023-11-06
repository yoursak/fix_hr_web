<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelHasPermission
 * 
 * @property int $id
 * @property int|null $role_id
 * @property int|null $permission_id
 * @property string|null $model_id
 * @property int|null $module_id
 * @property string|null $model_type
 * @property string|null $permission_name
 * @property string|null $business_id
 * @property string|null $branch_id
 *
 * @package App\Models
 */
class ModelHasPermission extends Model
{
	protected $table = 'model_has_permissions';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'permission_id' => 'int',
		'module_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'permission_id',
		'model_id',
		'module_id',
		'model_type',
		'permission_name',
		'business_id',
		'branch_id'
	];
}
