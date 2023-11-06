<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestMispunchList
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
 * @property string|null $emp_miss_date
 * @property string|null $emp_miss_time_type
 * @property Carbon|null $emp_miss_in_time
 * @property Carbon|null $emp_miss_out_time
 * @property Carbon|null $emp_working_hour
 * @property string|null $message
 * @property string|null $remark
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RequestMispunchList extends Model
{
	protected $table = 'request_mispunch_list';

	protected $casts = [
		'department_id' => 'int',
		'designation_id' => 'int',
		'emp_type' => 'int',
		'emp_miss_in_time' => 'datetime',
		'emp_miss_out_time' => 'datetime',
		'emp_working_hour' => 'datetime',
		'status' => 'int'
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
		'emp_miss_date',
		'emp_miss_time_type',
		'emp_miss_in_time',
		'emp_miss_out_time',
		'emp_working_hour',
		'message',
		'remark',
		'status'
	];
}
