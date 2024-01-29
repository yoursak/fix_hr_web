<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttendanceShiftTypeItem
 * 
 * @property int $id
 * @property int|null $attendance_shift_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $depart_id
 * @property string|null $shift_name
 * @property Carbon|null $shift_start
 * @property int|null $shift_hr
 * @property Carbon|null $shift_end
 * @property int|null $shift_min
 * @property int|null $work_hr
 * @property int|null $work_min
 * @property int|null $break_min
 * @property bool $is_active
 * @property bool $is_paid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicyAttendanceShiftTypeItem extends Model
{
	protected $table = 'policy_attendance_shift_type_items';
	protected $primary_key = 'id';
	protected $fillable = [
		'attendance_shift_id',
		'business_id',
		'branch_id',
		'depart_id',
		'shift_name',
		'shift_start',
		'shift_hr',
		'shift_end',
		'shift_min',
		'work_hr',
		'work_min',
		'break_min',
		'is_active',
		'is_paid'
	];
}
