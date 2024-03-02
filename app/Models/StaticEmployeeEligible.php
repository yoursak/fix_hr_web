<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployEligible
 *
 * @property int $eligible_id
 * @property string|null $eligible
 *
 * @package App\Models
 */
class StaticEmployeeEligible extends Model
{
	protected $table = 'static_employee_eligible';
	protected $primaryKey = 'eligible_id';
	public $timestamps = false;

	protected $fillable = [
		'eligible'
	];
}
