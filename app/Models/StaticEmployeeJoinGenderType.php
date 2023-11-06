<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinGenderType
 * 
 * @property int $id
 * @property string|null $gender_type
 *
 * @package App\Models
 */
class StaticEmployeeJoinGenderType extends Model
{
	protected $table = 'static_employee_join_gender_type';
	public $timestamps = false;

	// protected $fillable = [
	// 	'gender_type'
	// ];
}
