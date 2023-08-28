<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation_list extends Model
{
    use HasFactory;
    protected $table="designation_list";
    protected $primary_key="desig_id";

	protected $fillable = [
        'name',
        'branch_id',
        'department_id'
	];
}
