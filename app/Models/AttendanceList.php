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
 * @property bool $working_from_method
 * @property bool $method_auto
 * @property bool $method_manual
 * @property bool $marked_in_mode
 * @property bool $marked_out_mode
 * @property bool $active_qr_mode
 * @property bool $active_selfie_mode
 * @property bool $active_face_mode
 * @property bool $active_location_tab_mode
 * @property bool $attendance_status
 * @property string|null $attendance_shift
 * @property Carbon|null $punch_date
 * @property string|null $emp_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_today_current_status
 * @property string|null $punch_in_selfie
 * @property Carbon|null $punch_in_time
 * @property string|null $punch_in_location_tag
 * @property string|null $punch_in_address
 * @property string|null $punch_in_latitude
 * @property string|null $punch_in_longitude
 * @property string|null $punch_out_selfie
 * @property Carbon|null $punch_out_time
 * @property string|null $punch_out_address
 * @property string|null $punch_out_latitude
 * @property string|null $punch_out_longitude
 * @property string|null $punch_out_location_tag
 * @property string|null $total_working_hour
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceList extends Model
{
	protected $table = 'attendance_list';

	// protected $casts = [
	// 	'working_from_method' => 'bool',
	// 	'method_auto' => 'bool',
	// 	'method_manual' => 'bool',
	// 	'marked_in_mode' => 'bool',
	// 	'marked_out_mode' => 'bool',
	// 	'active_qr_mode' => 'bool',
	// 	'active_selfie_mode' => 'bool',
	// 	'active_face_mode' => 'bool',
	// 	'active_location_tab_mode' => 'bool',
	// 	'attendance_status' => 'bool',
	// 	'punch_date' => 'datetime',
	// 	'punch_in_time' => 'datetime',
	// 	'punch_out_time' => 'datetime'
	// ];

	protected $fillable = [
		'working_from_method',
		'method_auto',
		'method_manual',
		'marked_in_mode',
		'marked_out_mode',
		'active_qr_mode',
		'active_selfie_mode',
		'active_face_mode',
		'active_location_tab_mode',
		'attendance_status',
		'attendance_shift',
		'punch_date',
		'emp_id',
		'business_id',
		'branch_id',
		'emp_today_current_status',
		'punch_in_selfie',
		'punch_in_time',
		'punch_in_location_tag',
		'punch_in_address',
		'punch_in_latitude',
		'punch_in_longitude',
		'punch_out_selfie',
		'punch_out_time',
		'punch_out_address',
		'punch_out_latitude',
		'punch_out_longitude',
		'punch_out_location_tag',
		'total_working_hour'
	];
}
