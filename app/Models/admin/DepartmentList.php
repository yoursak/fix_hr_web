<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * Class DepartmentList
 * 
 * @property int $depart_id
 * @property string|null $depart_name
 * @property string|null $branch_id
 * @property int $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class DepartmentList extends Model
{
	protected $table = 'department_list';
	protected $primaryKey = 'depart_id';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'depart_name',
		'branch_id',
		'status'
	];
}
