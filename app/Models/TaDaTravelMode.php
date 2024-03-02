<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaTravelMode
 *
 * @property int $travel_id
 * @property string|null $travel_type
 * @property int|null $travel_m_id
 * @property int|null $status
 *
 * @property TaDaTravelModeType|null $ta_da_travel_mode_type
 *
 * @package App\Models
 */
class TaDaTravelMode extends Model
{
	protected $table = 'ta_da_travel_mode';
	protected $primaryKey = 'travel_id';
	public $timestamps = false;

	protected $casts = [
		'travel_m_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'travel_type',
		'travel_m_id',
		'business_id',
		'branch_id',
		'status'
	];

	public function ta_da_travel_mode_type()
	{
		return $this->belongsTo(TaDaTravelModeType::class, 'travel_m_id');
	}
}
