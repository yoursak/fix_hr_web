<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticAttendanceShiftType
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class StaticAttendanceShiftType extends Model
{
	protected $table = 'static_attendance_shift_type';
	protected $primary_id = 'id';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
}
