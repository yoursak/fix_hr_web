<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeaveRequestList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property string|null $emp_id
 * @property int|null $emp_type
 * @property string|null $emp_name
 * @property string|null $emp_mobile_no
 * @property string|null $leave_type
 * @property int|null $leave_category
 * @property int|null $shift_type
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property int|null $days
 * @property string|null $reason
 * @property bool|null $status
 * @property string|null $profile_photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LeaveRequestList extends Model
{
	protected $table = 'leave_request_list';

	protected $casts = [
		'department_id' => 'int',
		'designation_id' => 'int',
		'emp_type' => 'int',
		'leave_category' => 'int',
		'shift_type' => 'int',
		'from_date' => 'datetime',
		'to_date' => 'datetime',
		'days' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'designation_id',
		'emp_id',
		'emp_type',
		'emp_name',
		'emp_mobile_no',
		'leave_type',
		'leave_category',
		'shift_type',
		'from_date',
		'to_date',
		'days',
		'reason',
		'status',
		'profile_photo'
	];
}
