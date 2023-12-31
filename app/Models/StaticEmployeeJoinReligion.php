<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinReligion
 * 
 * @property int $id
 * @property string $religion_name
 *
 * @package App\Models
 */
class StaticEmployeeJoinReligion extends Model
{
	protected $table = 'static_employee_join_religion';
	public $timestamps = false;

	protected $fillable = [
		'religion_name'
	];
}
