<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business_type extends Model
{
    use HasFactory;
	
    protected $table="business_type_list";
    protected $primary_key="id";

}
