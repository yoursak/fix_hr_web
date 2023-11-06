<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestLeaveList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $emp_id
 * @property string|null $emp_mobile_no
 * @property bool|null $leave_type
 * @property bool $leave_category
 * @property bool $shift_type
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property int|null $days
 * @property string|null $reason
 * @property string|null $remark
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RequestLeaveList extends Model
{
	protected $table = 'request_leave_list';

	protected $casts = [
		'leave_type' => 'bool',
		'leave_category' => 'bool',
		'shift_type' => 'bool',
		'from_date' => 'datetime',
		'to_date' => 'datetime',
		'days' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'business_id',
		'emp_id',
		'emp_mobile_no',
		'leave_type',
		'leave_category',
		'shift_type',
		'from_date',
		'to_date',
		'days',
		'reason',
		'remark',
		'status'
	];
}
