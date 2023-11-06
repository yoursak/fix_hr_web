<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticBusinessTypeList
 * 
 * @property int $id
 * @property string|null $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StaticBusinessTypeList extends Model
{
	protected $table = 'static_business_type_list';

	protected $fillable = [
		'name'
	];
}
