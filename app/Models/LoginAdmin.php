<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
/**
 * Class LoginAdmin
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $country_code
 * @property string|null $phone
 * @property string|null $otp
 * @property Carbon|null $otp_created_at
 * @property bool|null $is_verified
 * @property string|null $api_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class LoginAdmin extends Model
{
	use HasApiTokens;
	protected $table = 'login_admin';

	protected $casts = [
		'otp_created_at' => 'datetime',
		'is_verified' => 'bool'
	];

	// protected $hidden = [
	// 	'api_token'
	// ];

	protected $fillable = [
		'business_id',
		'name',
		'email',
		'country_code',
		'phone',
		'otp',
		'otp_created_at',
		'is_verified',
		'api_token'
	];
}
