<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticBusinessCategoriesList
 * 
 * @property int $id
 * @property string|null $name
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StaticBusinessCategoriesList extends Model
{
	protected $table = 'static_business_categories_list';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'status'
	];
}
