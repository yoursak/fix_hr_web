<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\employee;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GatepassRequestList
 * 
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property int $department_id
 * @property int $designation_id
 * @property string $emp_id
 * @property string $emp_name
 * @property string $emp_mobile_no
 * @property Carbon $date
 * @property string $going_through
 * @property Carbon $in_time
 * @property Carbon $out_time
 * @property string $reason
 * @property int|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class GatepassRequestList extends Model
{
	protected $table = 'gatepass_request_list';

	protected $casts = [
		// 'department_id' => 'int',
		// 'designation_id' => 'int',
		// 'date' => 'datetime',
		// 'in_time' => 'datetime',
		// 'out_time' => 'datetime',
		// 'status' => 'int'
	];

	protected $fillable = [
		// 'business_id',
		// 'branch_id',
		// 'department_id',
		// 'designation_id',
		// 'emp_id',
		// 'emp_name',
		// 'emp_mobile_no',
		// 'date',
		// 'going_through',
		// 'in_time',
		// 'out_time',
		// 'reason',
		// 'status'
	];
}
