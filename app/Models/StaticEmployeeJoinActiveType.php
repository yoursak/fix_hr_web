<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StaticEmployeeJoinGovtDocType
 * 
 * @property int $id
 * @property string|null $govt_type
 * @property string|null $document_no_length
 *
 * @package App\Models
 */
class StaticEmployeeJoinActiveType extends Model
{
    protected $table = 'static_employee_join_active_type';
    public $timestamps = false;

    // protected $fillable = [
    // 	'govt_type',
    // 	'document_no_length'
    // ];
}
