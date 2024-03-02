<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestGatepassList
 *
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property Carbon|null $date
 * @property int|null $going_through
 * @property Carbon|null $in_time
 * @property Carbon|null $out_time
 * @property string|null $source
 * @property string|null $destination
 * @property string|null $reason
 * @property string|null $remark
 * @property string $forward_by_role_id
 * @property bool $forward_by_status
 * @property string $final_level_role_id
 * @property bool $final_status
 * @property string $process_complete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RequestGatepassList extends Model
{
	protected $table = 'request_gatepass_list';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';

	// protected $casts = [
	// 	'date' => 'datetime',
	// 	'going_through' => 'int',
	// 	'in_time' => 'datetime',
	// 	'out_time' => 'datetime',
	// 	'forward_by_status' => 'bool',
	// 	'final_status' => 'bool'
	// ];

	protected $fillable = [
		'business_id',
		'branch_id',
		'emp_id',
		'date',
		'going_through',
		'in_time',
		'out_time',
		'source',
		'destination',
		'reason',
		'remark',
		'forward_by_role_id',
		'forward_by_status',
		'final_level_role_id',
		'final_status',
		'process_complete'
	];
}
