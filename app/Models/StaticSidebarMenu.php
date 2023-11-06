<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticSidebarMenu
 * 
 * @property int $menu_id
 * @property string|null $menu_name
 * @property string|null $menu_link
 * @property string|null $sub_list
 * @property int|null $sidebar_id
 * @property int|null $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * 
 * @property Collection|Permission[] $permissions
 *
 * @package App\Models
 */
class StaticSidebarMenu extends Model
{
	protected $table = 'static_sidebar_menu';
	protected $primaryKey = 'menu_id';

	protected $casts = [
		'sidebar_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'menu_name',
		'menu_link',
		'sub_list',
		'sidebar_id',
		'status'
	];

	public function permissions()
	{
		return $this->hasMany(Permission::class, 'module_id');
	}
}
