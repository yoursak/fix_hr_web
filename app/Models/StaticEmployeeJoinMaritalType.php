<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinMaritalType
 * 
 * @property int $id
 * @property string|null $marital_type
 *
 * @package App\Models
 */
class StaticEmployeeJoinMaritalType extends Model
{
	protected $table = 'static_employee_join_marital_type';
	public $timestamps = false;

	// protected $fillable = [
	// 	'marital_type'
	// ];
}
