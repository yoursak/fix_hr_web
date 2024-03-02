<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceDailyCount
 *
 * @property int $id
 * @property int $business_id
 * @property Carbon $date
 * @property int $total_emp
 * @property int $present
 * @property int $absent
 * @property int $late
 * @property int $early
 * @property int $mispunch
 * @property int $halfday
 * @property int $overtime
 * @property int $leave
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceDailyCount extends Model
{
	protected $table = 'attendance_daily_count';
	public $incrementing = false;

	// protected $casts = [
	// 	'id' => 'int',
	// 	'business_id' => 'int',
	// 	'date' => 'datetime',
	// 	'total_emp'=>'int',
	// 	'present' => 'int',
	// 	'absent' => 'int',
	// 	'late' => 'int',
	// 	'early' => 'int',
	// 	'mispunch' => 'int',
	// 	'halfday' => 'int',
	// 	'overtime' => 'int',
	// 	'leave' => 'int'
	// ];

	protected $fillable = [
		'id',
		'business_id',
		'branch_id',
		'date',
		'total_emp',
		'present',
		'absent',
		'late',
		'early',
		'mispunch',
		'halfday',
		'overtime',
		'leave'
	];
}
