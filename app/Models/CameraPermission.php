<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CameraPermission
 * 
 * @property int $id
 * @property string|null $mode_check
 * @property bool|null $business_check
 * @property bool|null $branch_check
 * @property string|null $business_id
 * @property string|null $mobile_ip
 * @property string|null $imei_number
 * @property bool|null $check_camera
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CameraPermission extends Model
{
	protected $table = 'camera_permission';

	// protected $casts = [
	// 	'business_check' => 'bool',
	// 	'branch_check' => 'bool',
	// 	'check_camera' => 'bool'
	// ];

	protected $fillable = [
		'mode_check',
		'business_check',
		'branch_check',
		'business_id',
		'mobile_ip',
		'imei_number',
		'check_camera'
	];
}
