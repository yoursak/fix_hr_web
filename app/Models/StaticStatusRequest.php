<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticStatusRequest
 * 
 * @property int $id
 * @property string|null $request_response
 * @property string|null $request_color
 *
 * @package App\Models
 */
class StaticStatusRequest extends Model
{
	protected $table = 'static_status_request';
	public $timestamps = false;

	protected $fillable = [
		'request_response',
		'request_color'
	];
}
