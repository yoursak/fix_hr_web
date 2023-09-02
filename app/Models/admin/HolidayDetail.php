<?php

/**
 * Created by Reliese Model.
 */


 /**
 * Laravel Model
 *
 * 
 * @package		Laravel Controller
 * @subpackage  HolidayDetail Model
 * @category	Model
 * @author		Aman Sahu
 *
 * 
 **/

namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HolidayDetail
 * 
 * @property int $holiday_id
 * @property string|null $holiday_name
 * @property Carbon|null $holiday_date
 * @property string|null $business_id
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class HolidayDetail extends Model
{
	protected $table = 'holiday_details';
	protected $primaryKey = 'holiday_id';

	protected $casts = [
		'holiday_date' => 'datetime'
	];

	protected $fillable = [
		'holiday_name',
		'holiday_date',
		'business_id',
		'template_id'
	];
}
