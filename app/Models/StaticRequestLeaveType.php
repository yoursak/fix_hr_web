<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticRequestLeaveType
 * 
 * @property int $id
 * @property string|null $leave_day
 *
 * @package App\Models
 */
class StaticRequestLeaveType extends Model
{
	protected $table = 'static_request_leave_type';
	public $incrementing = false;
	public $timestamps = false;

	// protected $casts = [
	// 	'id' => 'int'
	// ];

	// protected $fillable = [
	// 	'id',
	// 	'leave_day'
	// ];
}
