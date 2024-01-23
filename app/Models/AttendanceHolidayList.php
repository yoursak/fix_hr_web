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
class AttendanceHolidayList extends Model
{
    protected $table = 'attendance_holiday_list';
    protected $primaryKey = 'id';

    // protected $casts = [
    // 	'template_id' => 'int',
    // 	'holiday_date' => 'datetime'
    // ];

    protected $fillable = [
        'business_id',
        'name',
        'day',
        'holiday_date',
        'from_start',
        'to_end'
    ];

}
