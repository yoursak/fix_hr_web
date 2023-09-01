<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginEmployee
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $country_code
 * @property string|null $phone
 * @property string|null $otp
 * @property Carbon|null $otp_created_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class LoginEmployee extends Model
{
	protected $table = 'login_employee';

	protected $casts = [
		'otp_created_at' => 'datetime'
	];

	protected $fillable = [
		'business_id',
		'name',
		'email',
		'country_code',
		'phone',
		'otp',
		'otp_created_at'
	];
}
