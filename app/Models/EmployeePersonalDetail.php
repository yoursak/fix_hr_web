<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeePersonalDetail
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property int|null $master_endgame_id
 * @property string|null $emp_name
 * @property string|null $emp_mname
 * @property string|null $emp_lname
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property bool|null $is_admin
 * @property int $role_id
 * @property int|null $employee_type
 * @property int|null $employee_contractual_type
 * @property float|null $emp_mobile_number
 * @property string|null $emp_email
 * @property Carbon|null $emp_date_of_birth
 * @property Carbon|null $emp_date_of_joining
 * @property bool $emp_gender
 * @property bool $emp_marital_status
 * @property bool $emp_caste
 * @property bool $emp_blood_group
 * @property bool $emp_select_id
 * @property string $emp_select_id_number
 * @property string $emp_nationality
 * @property string|null $emp_address
 * @property string|null $emp_country
 * @property string|null $emp_state
 * @property string|null $emp_city
 * @property string|null $emp_pin_code
 * @property string|null $emp_shift_type
 * @property string|null $emp_reporting_manager
 * @property string|null $emp_imei_no
 * @property bool|null $emp_attendance_method
 * @property bool $emp_status
 * @property string|null $profile_photo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class EmployeePersonalDetail extends Model
{
	protected $table = 'employee_personal_details';

	// protected $casts = [
	// 	'master_endgame_id' => 'int',
	// 	'department_id' => 'int',
	// 	'designation_id' => 'int',
	// 	'is_admin' => 'bool',
	// 	'role_id' => 'int',
	// 	'employee_type' => 'int',
	// 	'employee_contractual_type' => 'int',
	// 	'emp_mobile_number' => 'float',
	// 	'emp_date_of_birth' => 'datetime',
	// 	'emp_date_of_joining' => 'datetime',
	// 	'emp_gender' => 'bool',
	// 	'emp_marital_status' => 'bool',
	// 	'emp_caste' => 'bool',
	// 	'emp_blood_group' => 'bool',
	// 	'emp_select_id' => 'bool',
	// 	'emp_attendance_method' => 'bool',
	// 	'emp_status' => 'bool'
	// ];

	// protected $fillable = [
	// 	'business_id',
	// 	'branch_id',
	// 	'emp_id',
	// 	'master_endgame_id',
	// 	'emp_name',
	// 	'emp_mname',
	// 	'emp_lname',
	// 	'department_id',
	// 	'designation_id',
	// 	'is_admin',
	// 	'role_id',
	// 	'employee_type',
	// 	'employee_contractual_type',
	// 	'emp_mobile_number',
	// 	'emp_email',
	// 	'emp_date_of_birth',
	// 	'emp_date_of_joining',
	// 	'emp_gender',
	// 	'emp_marital_status',
	// 	'emp_caste',
	// 	'emp_blood_group',
	// 	'emp_select_id',
	// 	'emp_select_id_number',
	// 	'emp_nationality',
	// 	'emp_address',
	// 	'emp_country',
	// 	'emp_state',
	// 	'emp_city',
	// 	'emp_pin_code',
	// 	'emp_shift_type',
	// 	'emp_reporting_manager',
	// 	'emp_imei_no',
	// 	'emp_attendance_method',
	// 	'emp_status',
	// 	'profile_photo'
	// ];
}
