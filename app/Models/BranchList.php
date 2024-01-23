<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeePersonalDetail;

/**
 * Class BranchList
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $branch_name
 * @property bool|null $is_active
 * @property string|null $address
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class BranchList extends Model
{
	protected $table = 'branch_list';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'business_id',
		'branch_id',
		'branch_name',
		'is_active',
		'address'
	];
	// Define the inverse relationship to employee_personal_details
	public function employeePersonalDetails()
	{
		return $this->hasMany(EmployeePersonalDetail::class, 'branch_id');
	}
	
}
