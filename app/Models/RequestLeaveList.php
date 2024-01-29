<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class 	
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
	protected $primary_key = 'id';
	protected $business_id = 'business_id';
	protected $fillable = [
		'business_id',
		'emp_id',
		'leave_type',
		'leave_category',
		'shift_type',
		'from_date',
		'to_date',
		'days',
		'reason',
		'forward_by_role_id',
		'forward_by_status',
		'final_level_role_id',
		'final_status',
		'process_complete',
		'leave_remaining',
		'leave_summary_debit_value',
		'leave_summary_unpaid_value	',
		'apply_date'
	];
	protected $casts = [
		'leave_remaining' => 'float',
		'leave_summary_debit_value' => 'float',
		'leave_summary_unpaid_value' => 'float'
	];
}
