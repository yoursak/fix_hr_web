<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property string $business_id
 * @property string $packages
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscription';
	public $timestamps = false;

	protected $fillable = [
		'business_id',
		'packages'
	];
}
