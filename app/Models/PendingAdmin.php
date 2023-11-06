<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PendingAdmin
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property string|null $emp_name
 * @property string|null $emp_email
 * @property string|null $emp_phone
 * @property string|null $otp
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PendingAdmin extends Model
{
	protected $table = 'pending_admins';

	protected $fillable = [
		'business_id',
		'branch_id',
		'emp_id',
		'emp_name',
		'emp_email',
		'emp_phone',
		'otp'
	];
}
