<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApprovalStatusList
 * 
 * @property int $id
 * @property int $applied_cycle_type
 * @property string|null $business_id
 * @property int|null $approval_type_id
 * @property int|null $all_request_id
 * @property string|null $role_id
 * @property string|null $emp_id
 * @property string|null $remarks
 * @property bool|null $status
 * @property string $prev_role_id
 * @property string $current_role_id
 * @property string $next_role_id
 * @property bool $clicked
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ApprovalStatusList extends Model
{
	protected $table = 'approval_status_list';
	protected $primaykey = 'id';
	protected $business_id = 'business_id';

	protected $casts = [
		// 'applied_cycle_type' => 'int',
		// 'approval_type_id' => 'int',
		// 'all_request_id' => 'int',
		// 'status' => 'bool',
		// 'clicked' => 'bool'
	];

	protected $fillable = [
		'applied_cycle_type',
		'business_id',
		'approval_type_id',
		'all_request_id',
		'role_id',
		'emp_id',
		'remarks',
		'status',
		'prev_role_id',
		'current_role_id',
		'next_role_id',
		'clicked'
	];
}
