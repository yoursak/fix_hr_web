<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExportEmployeeTemplate
 * 
 * @property int $id
 * @property int|null $emp_id
 * @property string|null $emp_fname
 * @property string|null $emp_mname
 * @property string|null $emp_lname
 * @property Carbon|null $emp_dob
 * @property Carbon|null $emp_join
 * @property string|null $emp_gender
 * @property string|null $emp_mobile
 * @property string|null $emp_gmail
 * @property string|null $emp_blood_group
 * @property string|null $emp_iemi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ExportEmployeeContractualTemplates extends Model
{
    protected $table = 'export_employee_contractual_templates';

    protected $casts = [
        'emp_id' => 'int',
        'emp_dob' => 'datetime',
        'emp_join' => 'datetime'
    ];

    protected $fillable = [
        'emp_id',
        'emp_fname',
        'emp_mname',
        'emp_lname',
        'emp_mobile',
        'emp_gmail',
        'emp_dob',
        'emp_gender',
        'emp_marital',
        'emp_join',
        'emp_nationality',
        'emp_religion',
        'emp_caste_category',
        'emp_blood_group',
        'emp_gov_id',
        'emp_gov_id_no',
        'emp_branch',
        'emp_department',
        'emp_designation',
        'emp_type',
        'emp_contractual_type',
        'emp_assign_attendance_method',
        'emp_country',
        'emp_state',
        'emp_cities',
        'emp_pincode',
        'emp_address',
        'emp_active'
    ];
}
