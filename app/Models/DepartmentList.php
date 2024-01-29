<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DepartmentList
 * 
 * @property int $depart_id
 * @property string|null $b_id
 * @property string|null $branch_id
 * @property string|null $depart_name
 * @property int $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class DepartmentList extends Model
{
	protected $table = 'department_list';
	// protected $primaryKey = 'depart_id';

	// protected $casts = [
	// 	'status' => 'int'
	// ];

	// protected $fillable = [
	// 	'depart_id',
	// 	'b_id',
	// 	'branch_id',
	// 	'depart_name',
	// 	'status'
	// ];
}
