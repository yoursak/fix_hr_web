<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyTadaVariation
 * 
 * @property int $id
 * @property string|null $variation_type
 *
 * @package App\Models
 */
class PolicyTadaVariation extends Model
{
	protected $table = 'policy_tada_variation';
	public $timestamps = false;

	protected $fillable = [
		'variation_type'
	];
}
