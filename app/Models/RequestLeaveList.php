<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestLeaveList
 *
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property bool|null $leave_type
 * @property int $leave_category
 * @property bool $shift_type
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property float|null $days
 * @property string|null $reason
 * @property string $forward_by_role_id
 * @property bool $forward_by_status
 * @property string $final_level_role_id
 * @property bool $final_status
 * @property string $process_complete
 * @property float $leave_remaining
 * @property float $leave_summary_debit_value
 * @property float $leave_summary_unpaid_value
 * @property Carbon|null $apply_date
 * @property string|null $documents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RequestLeaveList extends Model
{
    protected $table = 'request_leave_list';
    protected $primary_key = 'id';
    // protected $business_id = 'business_id';
    // protected $casts = [
    //     // 'leave_type' => 'bool',
    //     // 'leave_category' => 'int',
    //     // 'shift_type' => 'bool',
    //     // 'from_date' => 'datetime',
    //     // 'to_date' => 'datetime',
    //     'days' => 'float',
    //     // 'forward_by_status' => 'bool',
    //     'final_status' => 'bool',
    //     'leave_allotted' => 'float',
    //     'leave_remaining' => 'float',
    //     'leave_summary_debit_value' => 'float',
    //     'leave_summary_unpaid_value' => 'float',
    //     'apply_date' => 'datetime'
    // ];

    protected $fillable = [
        'business_id',
        'branch_id',
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
        'leave_allotted',
        'leave_remaining',
        'leave_summary_debit_value',
        'leave_summary_unpaid_value',
        'apply_date',
        'documents'
    ];
}
