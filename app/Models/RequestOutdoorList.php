<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestOutdoorList
 *
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property string $emp_id
 * @property Carbon $apply_date
 * @property Carbon|null $out_time
 * @property string $reason
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RequestOutdoorList extends Model
{
    protected $table = 'request_outdoor_list';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';
    // protected $casts = [
    // 	'apply_date' => 'datetime',
    // 	'out_time' => 'datetime',
    // 	'status' => 'bool'
    // ];

    protected $fillable = [
        'business_id',
        'branch_id',
        'emp_id',
        'apply_date',
        'out_time',
        'reason',
        'status'
    ];
}
