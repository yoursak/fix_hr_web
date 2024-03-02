<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticSalaryEarningType
 *
 * @property int $id
 * @property string $name
 * @property int $type_id
 *
 * @package App\Models
 */
class StaticSalaryEarningType extends Model
{
    protected $table = 'static_salary_earning_type';
    public $timestamps = false;

    protected $casts = [
        'type_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'type_id'
    ];
}
