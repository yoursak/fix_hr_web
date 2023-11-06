<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEndgameMethodSwitch
 * 
 * @property int $id
 * @property string $method_check
 *
 * @package App\Models
 */
class StaticEndgameMethodSwitch extends Model
{
	protected $table = 'static_endgame_method_switch';
	public $timestamps = false;

	protected $fillable = [
		'method_check'
	];
}
