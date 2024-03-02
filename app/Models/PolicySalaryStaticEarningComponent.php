<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryStaticEarningComponent
 * 
 * @property int $id
 * @property string $name
 * @property int|null $earning_types
 * 
 * @property Collection|PolicySalarySetup[] $policy_salary_setups
 *
 * @package App\Models
 */
class PolicySalaryStaticEarningComponent extends Model
{
	protected $table = 'policy_salary_static_earning_component';
	public $timestamps = false;

	protected $casts = [
		'earning_types' => 'int'
	];

	protected $fillable = [
		'name',
		'earning_types'
	];

	public function policy_salary_setups()
	{
		return $this->hasMany(PolicySalarySetup::class, 'earning_type_id');
	}
}
