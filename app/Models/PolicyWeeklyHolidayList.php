<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyWeeklyHolidayList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $name
 * @property string $days
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicyWeeklyHolidayList extends Model
{
	protected $table = 'policy_weekly_holiday_list';

	protected $fillable = [
		'business_id',
		'name',
		'days'
	];
}
