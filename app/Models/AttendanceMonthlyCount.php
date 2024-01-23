<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceMonthlyCount
 * 
 * @property int $id
 * @property string $business_id
 * @property string $emp_id
 * @property string $month
 * @property string $year
 * @property string $present
 * @property string $absent
 * @property string $late
 * @property string $early_exit
 * @property string $mispunch
 * @property string $holiday
 * @property string $week_off
 * @property string $half_day
 * @property string $overtime
 * @property string $leave
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceMonthlyCount extends Model
{
	protected $table = 'attendance_monthly_count';

	protected $fillable = [
		'business_id',
		'emp_id',
		'month',
		'year',
		'present',
		'absent',
		'late',
		'early_exit',
		'mispunch',
		'holiday',
		'week_off',
		'half_day',
		'overtime',
		'leave'
	];

	
}
