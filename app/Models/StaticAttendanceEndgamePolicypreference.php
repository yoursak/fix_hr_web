<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticAttendanceEndgamePolicypreference
 * 
 * @property int $id
 * @property string|null $policy_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StaticAttendanceEndgamePolicypreference extends Model
{
	protected $table = 'static_attendance_endgame_policypreference';

	protected $fillable = [
		'policy_name'
	];
}
