<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicySalaryTdsStore
 * 
 * @property int $id
 * @property string|null $business_id
 * @property int|null $tdsffromsalary
 * @property int|null $tdstosalary
 * @property int|null $tdsamountstore
 * @property int|null $salset_id
 *
 * @package App\Models
 */
class PolicySalaryTdsStore extends Model
{
	protected $table = 'policy_salary_tds_store';
	public $timestamps = false;

	protected $casts = [
		'tdsffromsalary' => 'int',
		'tdstosalary' => 'int',
		'tdsamountstore' => 'int',
		'salset_id' => 'int'
	];

	protected $fillable = [
		'business_id',
		'tdsffromsalary',
		'tdstosalary',
		'tdsamountstore',
		'salset_id'
	];
}
