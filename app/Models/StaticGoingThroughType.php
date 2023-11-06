<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticGoingThroughType
 * 
 * @property int $id
 * @property string $going_through
 *
 * @package App\Models
 */
class StaticGoingThroughType extends Model
{
	protected $table = 'static_going_through_type';
	public $timestamps = false;

	protected $fillable = [
		'going_through'
	];
}
