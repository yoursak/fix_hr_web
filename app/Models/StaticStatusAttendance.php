<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticStatusAttendance
 * 
 * @property int $id
 * @property string|null $status_labels
 * @property string|null $badge_colors
 *
 * @package App\Models
 */
class StaticStatusAttendance extends Model
{
	protected $table = 'static_status_attendance';
	public $timestamps = false;
	protected $primary_key = 'id';

	protected $fillable = [
		'status_labels',
		'badge_colors',
		'label'
	];
}
