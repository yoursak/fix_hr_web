<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BranchList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $branch_name
 * @property bool|null $is_active
 * @property string|null $address
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class AttendanceTimeLog extends Model
{
    protected $table = 'attendance_time_log';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';
    protected $fillable = [
        'emp_id',
        'business_id',
        'change_date',
        'punch_date',
        'prev_in_time',
        'changed_in_time',
        'prev_out_time',
        'changed_out_time',
        'prev_total_work',
        'changed_total_work',
        'reason',
        'changed_by',
        'changer_role',
        'changer_emp_id',
        'changer_name',
    ];
}
