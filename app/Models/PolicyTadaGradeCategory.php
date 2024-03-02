<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyTadaGradeCategory
 * 
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property string $grade_category
 * @property string $grade_group
 * @property string $designation_group
 * @property string $designation_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class PolicyTadaGradeCategory extends Model
{
	protected $table = 'policy_tada_grade_category';

	protected $fillable = [
		'business_id',
		'branch_id',
		'grade_category',
		'grade_group',
		'designation_group',
		'designation_id'
	];
}
