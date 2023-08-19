<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department_list extends Model
{
    use HasFactory;
    protected $primary_key="id";

	protected $fillable = [
        'name',
        'branch_id'
	];
}
