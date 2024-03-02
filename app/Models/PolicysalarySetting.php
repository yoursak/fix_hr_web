<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicysalarySetting
 *
 * @property int $id
 * @property string $business_id
 * @property int $da_hra
 * @property int $pfset
 * @property int $esi_set
 * @property int $eps_set
 * @property int $lwf_set
 * @property int $Protax_set
 * @property int $TDS_set
 * @property float|null $da_value
 * @property float|null $hra_value
 * @property float|null $pf_employee_value
 * @property float|null $pf_organization_value
 * @property float|null $esi_employee_value
 * @property float|null $esi_organization_value
 * @property float|null $eps_value
 * @property float|null $lwf_employee_value
 * @property float|null $lwf_organization_value
 *
 * @package App\Models
 */
class PolicysalarySetting extends Model
{
	protected $table = 'policy_salary_settings';
	public $timestamps = false;

	protected $casts = [
		'da_hra' => 'int',
		'pfset' => 'int',
		'esi_set' => 'int',
		'eps_set' => 'int',
		'lwf_set' => 'int',
		'Protax_set' => 'int',
		'TDS_set' => 'int',
		'da_value' => 'float',
		'hra_value' => 'float',
		'pf_employee_value' => 'float',
		'pf_organization_value' => 'float',
		'esi_employee_value' => 'float',
		'esi_organization_value' => 'float',
		'eps_value' => 'float',
		'lwf_employee_value' => 'float',
		'lwf_organization_value' => 'float'
	];

	protected $fillable = [
		'business_id',
		'da_hra',
		'pfset',
		'esi_set',
		'eps_set',
		'lwf_set',
		'Protax_set',
		'TDS_set',
		'da_value',
		'hra_value',
		'pf_employee_value',
		'pf_organization_value',
		'esi_employee_value',
		'esi_organization_value',
		'eps_value',
		'lwf_employee_value',
		'lwf_organization_value'
	];
}
