<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string|null $guard_name
 * @property string|null $name
 * @property string|null $description
 * @property int|null $module_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property StaticSidebarMenu|null $static_sidebar_menu
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permissions';

	protected $casts = [
		'module_id' => 'int'
	];

	protected $fillable = [
		'guard_name',
		'name',
		'description',
		'module_id',
		'business_id',
		'branch_id'
	];

	public function static_sidebar_menu()
	{
		return $this->belongsTo(StaticSidebarMenu::class, 'module_id');
	}
}
