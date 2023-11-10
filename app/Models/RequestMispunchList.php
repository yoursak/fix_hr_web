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
 * @property string|null $emp_id
 * @property string|null $emp_mobile_no
 * @property string|null $emp_miss_date
 * @property int|null $emp_miss_time_type
 * @property Carbon|null $emp_miss_in_time
 * @property Carbon|null $emp_miss_out_time
 * @property Carbon|null $emp_working_hour
 * @property string|null $reason
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

	// protected $casts = [
	// 	'emp_miss_time_type' => 'int',
	// 	'emp_miss_in_time' => 'datetime',
	// 	'emp_miss_out_time' => 'datetime',
	// 	'emp_working_hour' => 'datetime',
	// 	'status' => 'int'
	// ];

	protected $fillable = [
		'business_id',
		'emp_id',
		'emp_mobile_no',
		'emp_miss_date',
		'emp_miss_time_type',
		'emp_miss_in_time',
		'emp_miss_out_time',
		'emp_working_hour',
		'reason',
		'remark',
		'status'
	];
}
