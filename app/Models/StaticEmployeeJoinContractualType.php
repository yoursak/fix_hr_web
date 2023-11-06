<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinContractualType
 * 
 * @property int $id
 * @property string $contractual_type
 *
 * @package App\Models
 */
class StaticEmployeeJoinContractualType extends Model
{
	protected $table = 'static_employee_join_contractual_type';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'contractual_type'
	];
}
