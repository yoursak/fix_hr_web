<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyHolidayDetail
 * 
 * @property int $holiday_id
 * @property int|null $template_id
 * @property string|null $business_id
 * @property string|null $holiday_name
 * @property string|null $day
 * @property Carbon|null $holiday_date
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class PolicyHolidayDetail extends Model
{
	protected $table = 'policy_holiday_details';
	protected $primaryKey = 'holiday_id';

	// protected $casts = [
	// 	'template_id' => 'int',
	// 	'holiday_date' => 'datetime'
	// ];

	protected $fillable = [
		'template_id',
		'business_id',
		'holiday_name',
		'day',
		'holiday_date'
	];
}
