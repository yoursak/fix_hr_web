<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DesignationList
 * 
 * @property int $desig_id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $department_id
 * @property string|null $desig_name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class DesignationList extends Model
{
	protected $table = 'designation_list';
	protected $primaryKey = 'desig_id';

	protected $fillable = [
		'business_id',
		'branch_id',
		'department_id',
		'desig_name'
	];
}
