<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeLeaveBalance
 * 
 * @property int $id
 * @property string $business_id
 * @property string|null $emp_id
 * @property string|null $month
 * @property Carbon|null $year
 * @property int|null $leave_type
 * @property int|null $leave_id
 * @property bool|null $leave_cycle
 * @property int $opening
 * @property int $accured
 * @property int $availed_last_month
 * @property int $availed_current_month
 * @property int $balance
 * @property int $un_approved_leave_applied
 * @property int $available_leave_balance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class EmployeeLeaveBalance extends Model
{
	protected $table = 'employee_leave_balance';

	protected $casts = [
		'year' => 'datetime',
		'leave_type' => 'int',
		'leave_id' => 'int',
		'leave_cycle' => 'bool',
		'opening' => 'int',
		'accured' => 'int',
		'availed_last_month' => 'int',
		'availed_current_month' => 'int',
		'balance' => 'int',
		'un_approved_leave_applied' => 'int',
		'available_leave_balance' => 'int'
	];

	protected $fillable = [
		'business_id',
		'emp_id',
		'month',
		'year',
		'leave_type',
		'leave_id',
		'leave_cycle',
		'opening',
		'accured',
		'availed_last_month',
		'availed_current_month',
		'balance',
		'un_approved_leave_applied',
		'available_leave_balance'
	];
}
