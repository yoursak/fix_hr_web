<?php

namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $department_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property string|null $emp_name
 * @property string|null $emp_status
 * @property string|null $punch_in
 * @property string|null $punch_out
 * @property string|null $production_hour
 * @property string|null $location_ip
 * @property string|null $working_from
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceList extends Model
{
	protected $table = 'attendance_list';

	protected $fillable = [
		'business_id',
		'department_id',
		'branch_id',
		'emp_id',
		'emp_name',
		'emp_status',
		'punch_in',
		'punch_out',
		'production_from',
		'location_ip',
		'working_hour'
	];
}
