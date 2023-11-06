<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticSidebar
 * 
 * @property int $bar_id
 * @property string|null $sidebar_title
 * @property string|null $side_icon
 * @property int|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StaticSidebar extends Model
{
	protected $table = 'static_sidebar';
	protected $primaryKey = 'bar_id';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'sidebar_title',
		'side_icon',
		'status'
	];
}
