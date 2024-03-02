<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaTolltaxExpenseList
 * 
 * @property int $toll_id
 * @property int $grade_id
 * @property string|null $branch_id
 * @property string $business_id
 * @property string|null $travel_type
 * @property int|null $travel_m_id_
 * @property string|null $toll_charge
 * @property string|null $toll_add_charge
 * @property string|null $parking_charge
 * 
 * @property GradeList $grade_list
 * @property TaDaTravelMode|null $ta_da_travel_mode
 *
 * @package App\Models
 */
class TaDaTolltaxExpenseList extends Model
{
	protected $table = 'ta_da_tolltax_expense_list';
	protected $primaryKey = 'toll_id';
	public $timestamps = false;

	protected $casts = [
		'grade_id' => 'int',
		'travel_m_id_' => 'int'
	];

	protected $fillable = [
		'grade_id',
		'branch_id',
		'business_id',
		'travel_type',
		'travel_m_id_',
		'toll_charge',
		'toll_add_charge',
		'parking_charge'
	];

	public function grade_list()
	{
		return $this->belongsTo(GradeList::class, 'grade_id');
	}

	public function ta_da_travel_mode()
	{
		return $this->belongsTo(TaDaTravelMode::class, 'travel_m_id_');
	}
}
