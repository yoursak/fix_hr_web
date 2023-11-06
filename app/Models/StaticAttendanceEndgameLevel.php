<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticAttendanceEndgameLevel
 * 
 * @property int $id
 * @property int|null $policypreference_level_id
 * @property string|null $level_name
 *
 * @package App\Models
 */
class StaticAttendanceEndgameLevel extends Model
{
	protected $table = 'static_attendance_endgame_level';
	public $timestamps = false;

	protected $casts = [
		'policypreference_level_id' => 'int'
	];

	protected $fillable = [
		'policypreference_level_id',
		'level_name'
	];
}
