<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\BranchList;

/**
 * Class EmployeePersonalDetail
 *
 * @property int $id
 * @property string|null $business_id
 * @property string|null $branch_id
 * @property string|null $emp_id
 * @property int|null $master_endgame_id
 * @property string|null $emp_name
 * @property string|null $emp_mname
 * @property string|null $emp_lname
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property bool|null $is_admin
 * @property int $role_id
 * @property int|null $employee_type
 * @property int|null $employee_contractual_type
 * @property float|null $emp_mobile_number
 * @property string|null $emp_email
 * @property Carbon|null $emp_date_of_birth
 * @property Carbon|null $emp_date_of_joining
 * @property bool $emp_gender
 * @property bool $emp_marital_status
 * @property bool $emp_caste
 * @property bool $emp_blood_group
 * @property bool $emp_select_id
 * @property string $emp_select_id_number
 * @property string $emp_nationality
 * @property string|null $emp_address
 * @property string|null $emp_country
 * @property string|null $emp_state
 * @property string|null $emp_city
 * @property string|null $emp_pin_code
 * @property string|null $emp_shift_type
 * @property string|null $emp_reporting_manager
 * @property string|null $emp_imei_no
 * @property bool|null $emp_attendance_method
 * @property bool $emp_status
 * @property string|null $profile_photo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class EmployeePersonalDetail extends Model
{
    protected $table = 'employee_personal_details';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';
    public function branch()
    {
        return $this->belongsTo(BranchList::class, 'branch_id');
    }
    public function grade_list()
    {
        return $this->belongsTo(GradeList::class, 'grade');
    }

    protected $fillable = [
        'emp_id',
        'business_id',
        'branch_id',
        'emp_name',
        'emp_mname',
        'emp_lname',
        'emp_mobile_number',
        'emp_email',
        'emp_date_of_birth',
        'emp_gender',
        'emp_marital_status',
        'emp_date_of_joining',
        'emp_nationality',
        'emp_religion',
        'emp_category',
        'emp_blood_group',
        'emp_gov_select_id',
        'emp_gov_select_id_number',
        'department_id',
        'designation_id',
        'employee_type',
        'emp_country',
        'emp_state',
        'emp_city',
        'emp_pin_code',
        'emp_address',
        'master_endgame_id',
        'emp_attendance_method',
        'emp_shift_type',
        'assign_shift_type',
        'emp_reporting_manager',
        'emp_reporting_manager_names',
        'active_emp',
        'employee_contractual_type',
        'emp_rotational_shift_type_item',
        'assign_shift_start_time',
        'assign_shift_end_time',
        'static_role',
        'role_id',
        'grade',
        'budget_code',
        'account_code',
        'bank_ifsc_code',
        'bank_name',
        'bank_branch_name',
        'bank_account_no',
        'bank_branch_code',
        'bank_micr_code',
        'profile_photo',
        'bank_address_line1',
        'bank_address_line2',
        'pf_no',
        'pf_joining_no',
        'pf_eligible',
        'lwf_eligible',
        // 'lwf_no',
        'eps_eligible',
        'eps_joining_no',
        'eps_no',
        // 'eps_exit_data',
        // 'hps_eligible',
        'family_name',
        'relationship',
        'relative_date_of_birth',
        'updated_at_emp',
        'updated_at_reside',
        'updated_at_comp',
        'updated_at_bank',
        'updated_at_account',
        'updated_at_fanily',
        'relative_phone_no'
    ];
}
