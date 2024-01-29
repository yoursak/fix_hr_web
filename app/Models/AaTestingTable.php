<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AaTestingTable
 * 
 * @property int $id
 * @property string $business_id
 * @property string $branch_id
 * @property string $roles_name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AaTestingTable extends Model
{
	protected $table = 'aa_testing_table';

	protected $fillable = [
		// 'business_id',
		// 'branch_id',
		// 'roles_name',
		// 'description'
	];
}
