<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticAttendanceMethod
 * 
 * @property int $id
 * @property string|null $method_name
 *
 * @package App\Models
 */
class StaticAttendanceMethod extends Model
{
	protected $table = 'static_attendance_methods';
	public $timestamps = false;

	protected $fillable = [
		'method_name'
	];
}
