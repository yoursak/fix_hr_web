<?php


namespace App\Models\employee;

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
 * @property string|null $emp_name
 * @property string|null $emp_mobile_no
 * @property string|null $leave_type
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property int|null $days
 * @property string|null $reason
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
 class LeaveRequestList extends Model
{
	protected $table = 'leave_request_list';

	protected $casts = [
		// 'department_id' => 'int',
		// 'designation_id' => 'int',
		// 'from_date' => 'datetime',
		// 'to_date' => 'datetime',
		// 'days' => 'int',
		// 'status' => 'bool'
	];

	protected $fillable = [
		// 'business_id',
		// 'branch_id',
		// 'department_id',
		// 'designation_id',
		// 'emp_id',
		// 'emp_name',
		// 'emp_mobile_no',
		// 'leave_type',
		// 'from_date',
		// 'to_date',
		// 'days',
		// 'reason',
		// 'status'
	];
}
