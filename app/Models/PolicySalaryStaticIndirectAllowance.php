<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryStaticIndirectAllowance
 * 
 * @property int $id
 * @property string|null $indirect_allow_name
 *
 * @package App\Models
 */
class PolicySalaryStaticIndirectAllowance extends Model
{
	protected $table = 'policy_salary_static_indirect_allowances';
	public $timestamps = false;

	protected $fillable = [
		'indirect_allow_name'
	];
}
