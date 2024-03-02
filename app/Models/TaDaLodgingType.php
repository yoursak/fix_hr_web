<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaLodgingType
 * 
 * @property int $lodging_type_id
 * @property string $occupancy
 *
 * @package App\Models
 */
class TaDaLodgingType extends Model
{
	protected $table = 'ta_da_lodging_type';
	protected $primaryKey = 'lodging_type_id';
	public $timestamps = false;

	protected $fillable = [
		'occupancy'
	];
}
