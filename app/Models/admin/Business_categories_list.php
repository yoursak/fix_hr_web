<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business_categories_list extends Model
{
    use HasFactory;
    protected $table="business_categories_list";
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
