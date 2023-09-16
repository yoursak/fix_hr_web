<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MisspunchList
 * 
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property int $department_id
 * @property int $designation_id
 * @property string $emp_id
 * @property string $emp_name
 * @property string $emp_miss_date
 * @property string $emp_miss_time_type
 * @property string $emp_miss_in_time
 * @property string $emp_miss_out_time
 * @property string $emp_working_hour
 * @property string $message
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class MisspunchList extends Model
{
	protected $table = 'misspunch_list';

	protected $casts = [
		'department_id' => 'int',
		'designation_id' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'designation_id',
		'emp_id',
		'emp_name',
		'emp_miss_date',
		'emp_miss_time_type',
		'emp_miss_in_time',
		'emp_miss_out_time',
		'emp_working_hour',
		'message'
	];
}
