<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryStaticDeductionComponent
 * 
 * @property int $deduct_id
 * @property string $name_ded
 *
 * @package App\Models
 */
class PolicySalaryStaticDeductionComponent extends Model
{
	protected $table = 'policy_salary_static_deduction_component';
	protected $primaryKey = 'deduct_id';
	public $timestamps = false;

	protected $fillable = [
		'name_ded'
	];
}
