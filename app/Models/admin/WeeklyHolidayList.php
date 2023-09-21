<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WeeklyHolidayList
 * 
 * @property int $id
 * @property string $business_id
 * @property string $name
 * @property string $days
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class WeeklyHolidayList extends Model
{
	protected $table = 'weekly_holiday_list';

	protected $fillable = [
		// 'business_id',
		// 'name',
		// 'days'
	];
}
