<?php


// namespace App\Models;

// use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Model;

namespace App\Models\employee;

use carbon\carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class EmployeePersonalDetail
 * 
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property int|null $employee_type
 * @property string|null $emp_name
 * @property string|null $emp_id
 * @property string|null $emp_mobile_number
 * @property string|null $emp_email
 * @property int|null $emp_branch
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property Carbon|null $emp_date_of_birth
 * @property Carbon|null $emp_date_of_joining
 * @property int|null $emp_gender
 * @property string|null $emp_address
 * @property string|null $emp_country
 * @property string|null $emp_state
 * @property string|null $emp_city
 * @property string|null $emp_pin_code
 * @property string|null $profile_photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DemoImportModel extends Model
{
    protected $table = 'export_employee_templates';

    protected $primary_key = 'id';


    // protected $fillable = [
    //     'emp_id',
    //     'emp_fname'
    // ];

    protected $fillable = [
        'emp_id',    // Add other fields that are fillable
        'emp_fname',
        'emp_gender', // Add 'FirstName' to make it fillable
    ];
}
