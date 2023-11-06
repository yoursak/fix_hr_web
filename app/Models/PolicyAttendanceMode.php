<?php

/**
 * Created by Reliese Model.
 */

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
class PolicyAttendanceMode extends Model
{
	protected $table = 'policy_attendance_mode';

	// protected $casts = [
	// 	'office_auto' => 'bool',
	// 	'office_manual' => 'bool',
	// 	'office_qr' => 'bool',
	// 	'office_face_id' => 'bool',
	// 	'office_selfie' => 'bool',
	// 	'outdoor_auto' => 'bool',
	// 	'outdoor_manual' => 'bool',
	// 	'outdoor_selfie' => 'bool',
	// 	'wfh_auto' => 'bool',
	// 	'wfh_manual' => 'bool',
	// 	'wfh_selfie' => 'bool'
	// ];

	protected $fillable = [
		'business_id',
		'attendance_active_methods',
		'office_auto',
		'office_manual',
		'office_qr',
		'office_face_id',
		'office_selfie',
		'outdoor_auto',
		'outdoor_manual',
		'outdoor_selfie',
		'wfh_auto',
		'wfh_manual',
		'wfh_selfie'
	];
}
