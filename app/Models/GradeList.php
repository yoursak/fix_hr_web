<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GradeList
 *
 * @property int $id
 * @property string $business_id
 * @property string|null $branch_id
 * @property string $grade_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class GradeList extends Model
{
    protected $table = 'grade_list';
    protected $primary_key = 'id';
    protected $business_id = 'business_id';

    protected $fillable = [
        'business_id',
        'branch_id',
        'grade_name'
    ];
}
