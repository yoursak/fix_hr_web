<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinEmpType
 * 
 * @property int $type_id
 * @property string $emp_type
 *
 * @package App\Models
 */
class StaticEmployeeJoinEmpType extends Model
{
	protected $table = 'static_employee_join_emp_type';
	protected $primaryKey = 'type_id';
	public $timestamps = false;

	protected $fillable = [
		'emp_type'
	];
}
