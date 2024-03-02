<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaLodging
 *
 * @property int $lo_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property int|null $grade_id
 * @property int|null $travel_id
 * @property int|null $Travel_category_id
 * @property string|null $lodging_type
 * @property string|null $lodge_amount
 * @property int|null $status
 * @property int|null $set_amount
 *
 * @property TaDaSetamount|null $ta_da_setamount
 *
 * @package App\Models
 */
class TaDaLodging extends Model
{
	protected $table = 'ta_da_lodging';
	protected $primaryKey = 'lo_id';
	public $timestamps = false;

	protected $casts = [
		'grade_id' => 'int',
		'travel_id' => 'int',
		'Travel_category_id' => 'int',
		'status' => 'int',
		'set_amount' => 'int'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'grade_id',
		'travel_id',
		'Travel_category_id',
		'lodging_type',
		'lodge_amount',
		'status',
		'set_amount'
	];

    public function grade_list()
    {
        return $this->belongsTo(GradeList::class, 'grade_id');
    }

	public function ta_da_setamount()
	{
		return $this->belongsTo(TaDaSetamount::class, 'set_amount');
	}
	public function travel_type()
	{
		return $this->belongsTo(TaDaTravelModeType::class, 'travel_id');
	}
    public function travel_category()
    {
        return $this->belongsTo(TaDaTravelMode::class, 'Travel_category_id');
    }
    public function set_amount_one()
    {
        return $this->belongsTo(TaDaSetamount::class, 'set_amount');
    }
}
