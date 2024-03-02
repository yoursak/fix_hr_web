<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalarySetup
 *
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property int|null $salary_id
 * @property int|null $earning_type_id
 * @property string|null $others
 * @property string|null $custom_earning_compo
 * @property string|null $earning_amount_percent
 *
 * @property StaticSalaryEarningType|null $static_salary_earning_type
 * @property PolicySalaryStaticEarningComponent|null $policy_salary_static_earning_component
 *
 * @package App\Models
 */
class PolicySalarySetup extends Model
{
	protected $table = 'policy_salary_setup';
	public $timestamps = false;

	protected $casts = [
		'salary_id' => 'int',
		'earning_type_id' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'salary_id',
		'earning_type_id',
		'others',
		'custom_earning_compo',
		'earning_amount_percent'
	];

	public function static_salary_earning_type()
	{
		return $this->belongsTo(StaticSalaryEarningType::class, 'salary_id');
	}

	public function policy_salary_static_earning_component()
	{
		return $this->belongsTo(PolicySalaryStaticEarningComponent::class, 'earning_type_id');
	}
}
