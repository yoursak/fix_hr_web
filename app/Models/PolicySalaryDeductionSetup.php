<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryDeductionSetup
 * 
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property string|null $deduct_name
 * @property int $deduct_fix_percentId
 * @property int $deduction_type_id
 * @property string|null $others
 * @property string|null $custom_deduction_componentt
 * @property string|null $Deduct_amount_percentage
 * 
 * @property PolicySalaryStaticDeductionComponent $policy_salary_static_deduction_component
 * @property StaticSalaryEarningType $static_salary_earning_type
 *
 * @package App\Models
 */
class PolicySalaryDeductionSetup extends Model
{
	protected $table = 'policy_salary_deduction_setup';
	public $timestamps = false;

	protected $casts = [
		'deduct_fix_percentId' => 'int',
		'deduction_type_id' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'deduct_name',
		'deduct_fix_percentId',
		'deduction_type_id',
		'others',
		'custom_deduction_componentt',
		'Deduct_amount_percentage'
	];

	public function policy_salary_static_deduction_component()
	{
		return $this->belongsTo(PolicySalaryStaticDeductionComponent::class, 'deduction_type_id');
	}

	public function static_salary_earning_type()
	{
		return $this->belongsTo(StaticSalaryEarningType::class, 'deduct_fix_percentId');
	}
}
