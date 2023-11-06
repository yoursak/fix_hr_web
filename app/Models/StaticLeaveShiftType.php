<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticLeaveShiftType
 * 
 * @property int $id
 * @property string $leave_shift_type
 *
 * @package App\Models
 */
class StaticLeaveShiftType extends Model
{
	protected $table = 'static_leave_shift_type';
	public $timestamps = false;

	protected $fillable = [
		'leave_shift_type'
	];
}
