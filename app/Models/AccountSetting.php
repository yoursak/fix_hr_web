<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountSetting
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $phone_no
 * @property string|null $email_address
 * @property int|null $business_id
 * @property string|null $subscriptions
 * @property int|null $kyb_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AccountSetting extends Model
{
	protected $table = 'account_setting';

	protected $casts = [
		'business_id' => 'int',
		'kyb_id' => 'int'
	];

	protected $fillable = [
		'name',
		'phone_no',
		'email_address',
		'business_id',
		'subscriptions',
		'kyb_id'
	];
}
