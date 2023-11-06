<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyAttendanceTrackInOut
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $department_id
 * @property bool $track_in_out
 * @property bool $no_attendace_without_punch
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyAttendanceTrackInOut extends Model
{
	protected $table = 'policy_attendance_track_in_out';

	protected $casts = [
		'track_in_out' => 'bool',
		'no_attendace_without_punch' => 'bool'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'track_in_out',
		'no_attendace_without_punch'
	];
}
