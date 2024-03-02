<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyTadaCurrency
 * 
 * @property int $id
 * @property string|null $currency
 *
 * @package App\Models
 */
class PolicyTadaCurrency extends Model
{
	protected $table = 'policy_tada_currency';
	public $timestamps = false;

	protected $fillable = [
		'currency'
	];
}
