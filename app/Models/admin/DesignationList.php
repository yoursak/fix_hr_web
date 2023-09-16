<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationList extends Model
{
    use HasFactory;
    protected $table="designation_list";
    protected $primary_key="desig_id";

	protected $fillable = [
        'business_id',
        'branch_id',
        'department_id',
        'desig_name'
	];
}
