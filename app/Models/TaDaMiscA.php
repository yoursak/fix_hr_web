<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaDaMiscA
 *
 * @property int $misc_id
 * @property int|null $grade_id
 * @property string|null $branch_id
 * @property string|null $business_id
 * @property string|null $misc_amount
 * @property string|null $set_amount
 * @property int $status
 *
 * @property GradeList|null $grade_list
 *
 * @package App\Models
 */
class TaDaMiscA extends Model
{
	protected $table = 'ta_da_misc_a';
	protected $primaryKey = 'misc_id';
	public $timestamps = false;

	protected $casts = [
		'grade_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'grade_id',
		'branch_id',
		'business_id',
		'misc_amount',
		'set_amount',
		'status'
	];

	public function grade_list()
    {
        return $this->belongsTo(GradeList::class, 'grade_id');
    }

}
