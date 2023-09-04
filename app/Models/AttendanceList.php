<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceList
 * 
 * @property int $id
 * @property string|null $emp_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_name
 * @property string|null $emp_status
 * @property Carbon|null $punch_in_time
 * @property string|null $punch_in_address
 * @property string|null $punch_in_latitude
 * @property string|null $punch_in_longitude
 * @property string|null $punch_in_image
 * @property Carbon|null $punch_out_time
 * @property string|null $punch_out_address
 * @property string|null $punch_out_latitude
 * @property string|null $punch_out_longitude
 * @property string|null $punch_out_image
 * @property string|null $working_hour
 * @property string|null $working_from
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceList extends Model
{
	protected $table = 'attendance_list';

	protected $casts = [
		'punch_in_time' => 'datetime',
		'punch_out_time' => 'datetime'
	];

	protected $fillable = [
		'emp_id',
		'business_id',
		'branch_id',
		'emp_name',
		'emp_status',
		'punch_in_time',
		'punch_in_address',
		'punch_in_latitude',
		'punch_in_longitude',
		'punch_in_image',
		'punch_out_time',
		'punch_out_address',
		'punch_out_latitude',
		'punch_out_longitude',
		'punch_out_image',
		'working_hour',
		'working_from'
	];
}
