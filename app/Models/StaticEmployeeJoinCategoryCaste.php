<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinCategoryCaste
 * 
 * @property int $id
 * @property string|null $caste_category
 * @property string|null $caste_full_name
 *
 * @package App\Models
 */
class StaticEmployeeJoinCategoryCaste extends Model
{
	protected $table = 'static_employee_join_category_caste';
	public $timestamps = false;

	// protected $fillable = [
	// 	'caste_category',
	// 	'caste_full_name'
	// ];
}
