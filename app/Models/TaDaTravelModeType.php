<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaTravelModeType
 * 
 * @property int $travel_m_id
 * @property string|null $travel_class
 * 
 * @property Collection|TaDaTravelMode[] $ta_da_travel_modes
 *
 * @package App\Models
 */
class TaDaTravelModeType extends Model
{
	protected $table = 'ta_da_travel_mode_type';
	protected $primaryKey = 'travel_m_id';
	public $timestamps = false;

	protected $fillable = [
		'travel_class'
	];

	public function ta_da_travel_modes()
	{
		return $this->hasMany(TaDaTravelMode::class, 'travel_m_id');
	}
}
