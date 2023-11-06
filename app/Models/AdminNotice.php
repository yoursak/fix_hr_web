<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminNotice
 * 
 * @property int $id
 * @property string|null $title
 * @property Carbon|null $date
 * @property string|null $file
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $description
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class AdminNotice extends Model
{
	protected $table = 'admin_notices';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'title',
		'date',
		'file',
		'business_id',
		'branch_id',
		'description'
	];
}
