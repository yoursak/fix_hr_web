<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttendanceMode
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string $attendance_active_methods
 * @property bool|null $office_auto
 * @property bool|null $office_manual
 * @property bool|null $office_qr
 * @property bool|null $office_face_id
 * @property bool|null $office_selfie
 * @property bool|null $outdoor_auto
 * @property bool|null $outdoor_manual
 * @property bool|null $outdoor_selfie
 * @property bool|null $wfh_auto
 * @property bool|null $wfh_manual
 * @property bool|null $wfh_selfie
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyCompOffLwopLeave extends Model
{
    protected $table = 'policy_comp_off_lwop_leave';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';

    protected $fillable = [
        'switch',
        'business_id',
        'holiday_weekly_checked',
        'overtime_checked',
        'overtime_hr',
        'lwop_leave_checked',

    ];
}
