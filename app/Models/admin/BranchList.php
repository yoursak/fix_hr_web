<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BranchList
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $business_id
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
    protected $primaryKey = 'branch_id';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'is_active' => 'bool',
    ];

    protected $fillable = ['id', 'business_id', 'branch_name', 'is_active', 'address'];
}
