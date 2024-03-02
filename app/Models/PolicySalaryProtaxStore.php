<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryProtaxStore
 *
 * @property int $id
 * @property string|null $business_id
 * @property int|null $proffromsalary
 * @property int|null $protosalary
 * @property int|null $proamountstore
 * @property int|null $salset_id
 *
 * @package App\Models
 */
class PolicySalaryProtaxStore extends Model
{
	protected $table = 'policy_salary_protax_store';
	public $timestamps = false;

	protected $casts = [
		'proffromsalary' => 'int',
		'protosalary' => 'int',
		'proamountstore' => 'int',
		'salset_id' => 'int'
	];

	protected $fillable = [
		'business_id',
		'proffromsalary',
		'protosalary',
		'proamountstore',
		'salset_id'
	];
}
