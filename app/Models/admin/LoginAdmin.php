<?php

/**
 * Created by Reliese Model.
 */
namespace App\Models\admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


/**
 * Class LoginAdmin
 * 
 * @property int $id
 * @property string|null $user
 * @property string|null $business_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $country_code
 * @property string|null $phone
 * @property string|null $otp
 * @property Carbon|null $otp_created_at
 * @property bool|null $is_verified
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class LoginAdmin extends Authenticatable
{
	use HasApiTokens;
	use HasRoles;
	protected $table = 'login_admin';

	protected $casts = [
		'otp_created_at' => 'datetime',
		'is_verified' => 'bool'
	];

	protected $fillable = [
		'user',
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
