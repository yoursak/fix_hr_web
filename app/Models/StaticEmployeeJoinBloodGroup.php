<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinBloodGroup
 * 
 * @property int $id
 * @property string|null $blood_group
 *
 * @package App\Models
 */
class StaticEmployeeJoinBloodGroup extends Model
{
	protected $table = 'static_employee_join_blood_group';
	public $timestamps = false;

	// protected $fillable = [
	// 	'blood_group'
	// ];
}
