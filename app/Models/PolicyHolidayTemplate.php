<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyHolidayTemplate
 * 
 * @property int $temp_id
 * @property string|null $temp_name
 * @property Carbon|null $temp_from
 * @property Carbon|null $temp_to
 * @property string|null $business_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PolicyHolidayTemplate extends Model
{
	protected $table = 'policy_holiday_template';
	protected $primaryKey = 'temp_id';

	protected $casts = [
		// 'temp_from' => 'datetime',
		// 'temp_to' => 'datetime'
	];

	protected $fillable = [
		// 'temp_name',
		// 'temp_from',
		// 'temp_to',
		// 'business_id'
	];
}
