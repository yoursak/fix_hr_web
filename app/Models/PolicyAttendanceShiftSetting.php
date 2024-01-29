<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttendanceShiftSetting
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $department_id
 * @property bool $shift_type
 * @property string|null $shift_type_name
 * @property int $shift_weekly_repeat
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicyAttendanceShiftSetting extends Model
{
	protected $table = 'policy_attendance_shift_settings';
	protected $primary_key = 'id';
	protected $business_id = 'business_id';

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'shift_type',
		'shift_type_name',
		'shift_weekly_repeat'
	];
}
