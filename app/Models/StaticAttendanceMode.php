<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticAttendanceMode
 * 
 * @property int $id
 * @property string $mode_name
 *
 * @package App\Models
 */
class StaticAttendanceMode extends Model
{
	protected $table = 'static_attendance_mode';
	public $timestamps = false;

	protected $fillable = [
		'mode_name'
	];
}
