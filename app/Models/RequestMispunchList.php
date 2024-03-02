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
 * @property string|null $emp_id
 * @property string|null $emp_mobile_no
 * @property string|null $emp_miss_date
 * @property int|null $emp_miss_time_type
 * @property Carbon|null $emp_miss_in_time
 * @property Carbon|null $emp_miss_out_time
 * @property Carbon|null $emp_working_hour
 * @property string|null $reason
 * @property string $forward_by_role_id
 * @property bool|null $forward_by_status
 * @property string $final_level_role_id
 * @property bool $final_status
 * @property string $process_complete
 * @property string|null $remark
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RequestMispunchList extends Model
{
	protected $table = 'request_mispunch_list';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';

	protected $fillable = [
		'business_id',
		'branch_id',
		'emp_id',
		'emp_mobile_no',
		'emp_miss_date',
		'emp_miss_time_type',
		'emp_miss_in_time',
		'emp_miss_out_time',
		'emp_working_hour',
		'reason',
		'forward_by_role_id',
		'forward_by_status',
		'final_level_role_id',
		'final_status',
		'process_complete',
		'remark'
	];
}
