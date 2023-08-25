<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch_list extends Model
{
    use HasFactory;
    protected $table="branch_list";
    protected $primary_key="id";

	protected $fillable = [
        'name',
	];
}
