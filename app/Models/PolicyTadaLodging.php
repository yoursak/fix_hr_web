<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyTadaLodging
 *
 * @property int $id
 * @property int|null $gradeCategory
 * @property int|null $travel
 * @property int|null $travel_category
 * @property string|null $lodging_limit
 * @property string|null $select_occupancy
 * @property string|null $double_occupancy
 * @property int|null $currency
 *
 * @package App\Models
 */
class PolicyTadaLodging extends Model
{
	protected $table = 'policy_tada_lodging';
	public $timestamps = false;

	protected $casts = [
		'gradeCategory' => 'int',
		'travel' => 'int',
		'travel_category' => 'int',
		'currency' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'gradeCategory',
		'travel',
		'travel_category',
		'lodging_limit',
		'select_occupancy',
		'double_occupancy',
		'currency'
	];
}
