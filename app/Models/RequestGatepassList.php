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
 * @property string|null $emp_id
 * @property Carbon|null $date
 * @property string|null $going_through
 * @property Carbon|null $in_time
 * @property Carbon|null $out_time
 * @property string|null $source
 * @property string|null $destination
 * @property string|null $reason
 * @property string|null $status
 * @property string|null $remark
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RequestGatepassList extends Model
{
	protected $table = 'request_gatepass_list';

	protected $casts = [
		// 'date' => 'datetime',
		// 'in_time' => 'datetime',
		// 'out_time' => 'datetime'
	];

	protected $fillable = [
		'business_id',
		'emp_id',
		'date',
		'going_through',
		'in_time',
		'out_time',
		'source',
		'destination',
		'reason',
		'status',
		'remark'
	];
}
