<?php


// namespace App\Models;

// use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Model;

namespace App\Models\employee;

use carbon\carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class EmployeePersonalDetail
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property int|null $employee_type
 * @property string|null $emp_name
 * @property string|null $emp_id
 * @property string|null $emp_mobile_number
 * @property string|null $emp_email
 * @property int|null $emp_branch
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property Carbon|null $emp_date_of_birth
 * @property Carbon|null $emp_date_of_joining
 * @property int|null $emp_gender
 * @property string|null $emp_address
 * @property string|null $emp_country
 * @property string|null $emp_state
 * @property string|null $emp_city
 * @property string|null $emp_pin_code
 * @property string|null $profile_photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeePersonalDetail extends Model
{
	protected $table = 'employee_personal_details';

	protected $casts = [
		'employee_type' => 'int',
		'emp_branch' => 'int',
		'department_id' => 'int',
		'designation_id' => 'int',
		'emp_date_of_birth' => 'datetime',
		'emp_date_of_joining' => 'datetime',
		'emp_gender' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'employee_type',
		'emp_name',
		'emp_id',
		'emp_mobile_number',
		'emp_email',
		'emp_branch',
		'department_id',
		'designation_id',
		'emp_date_of_birth',
		'emp_date_of_joining',
		'emp_gender',
		'emp_address',
		'emp_country',
		'emp_state',
		'emp_city',
		'emp_pin_code',
		'profile_photo'
	];
}
