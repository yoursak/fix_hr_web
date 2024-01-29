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
 * @property bool|null $today_status
 * @property string|null $emp_id
 * @property Carbon|null $punch_date
 * @property string|null $overtime
 * @property string|null $late_by
 * @property string|null $early_exit
 * @property string|null $total_working_hour
 * @property string|null $shift_interval
 * @property string|null $setup_method_id
 * @property string|null $setup_method_name
 * @property bool $working_from_method
 * @property bool $method_auto
 * @property bool $method_manual
 * @property bool $marked_in_mode
 * @property bool $active_qr_mode
 * @property bool $marked_out_mode
 * @property bool $active_selfie_mode
 * @property bool $active_face_mode
 * @property bool $active_location_tab_mode
 * @property string|null $attendance_shift
 * @property string|null $applied_shift_template_name
 * @property string|null $applied_shift_type_name
 * @property string|null $applied_shift_comp_start_time
 * @property string|null $applied_shift_comp_end_time
 * @property int|null $brack_time
 * @property bool|null $brack_paid_check
 * @property string|null $punch_in_shift_name
 * @property string|null $punch_out_shift_name
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
 * @property int $approved_by_role_id
 * @property string|null $approved_by_emp_id
 * @property string $forward_by_role_id
 * @property bool $forward_by_status
 * @property string $final_level_role_id
 * @property bool $final_status
 * @property string $process_complete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttendanceList extends Model
{
	protected $table = 'attendance_list';
	protected $primary_key = 'id';
	protected $business_id = 'business_id';
	protected $fillable = [
		'emp_id',
		'business_id',
		'punch_date',
		'today_status',
		'overtime',
		'shift_interval',
		'early_exit',
		'late_by',
		'total_working_hour',
		'setup_method_id',
		'setup_method_name',
		'working_from_method',
		'method_auto',
		'method_manual',
		'marked_in_mode',
		'active_qr_mode',
		'marked_out_mode',
		'active_selfie_mode',
		'active_face_mode',
		'active_biometric_mode',
		'active_location_tab_mode',
		'attendance_shift',
		'applied_shift_template_name',
		'applied_shift_type_name',
		'applied_shift_comp_start_time',
		'applied_shift_comp_end_time',
		'brack_time',
		'brack_paid_check',
		'punch_in_shift_name',
		'punch_out_shift_name',
		'business_id',
		'branch_id',
		'emp_today_current_status',
		'punch_in_selfie',
		'punch_in_time',
		'punch_in_location_tag',
		'punch_in_qr_code',
		'punch_in_address',
		'punch_in_latitude',
		'punch_in_longitude',
		'punch_out_selfie',
		'punch_out_time',
		'punch_out_address',
		'punch_out_latitude',
		'punch_out_longitude',
		'punch_out_location_tag',
		'punch_out_qr_code',
		'approved_by_role_id',
		'approved_by_emp_id',
		'forward_by_role_id',
		'forward_by_status',
		'final_level_role_id',
		'final_status',
		'process_complete',
		'leave_type_category',
		'comp_off_active',
		'comp_off_value_get'
	];
}
