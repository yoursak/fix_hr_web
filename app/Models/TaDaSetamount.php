<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaSetamount
 * 
 * @property int $set_id
 * @property string|null $category_amount
 *
 * @package App\Models
 */
class TaDaSetamount extends Model
{
	protected $table = 'ta_da_setamount';
	protected $primaryKey = 'set_id';
	public $timestamps = false;

	protected $fillable = [
		'category_amount'
	];
}
