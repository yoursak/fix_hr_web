<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industrial_sector extends Model
{
    use HasFactory;
    protected $table="industrial_sector_list";
    protected $primary_key="id";

	protected $fillable = [
        'name',
        'created_at',
        'updated_at'
	];

    protected $cast =[
        'updated_at'
    ];
}
