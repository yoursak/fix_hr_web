<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_details extends Model
{
    use HasFactory;
	
    protected $table="business_details";
    protected $primary_key="b_id";

	protected $fillable = [
        'b_name',
		'b_category',
		'b_country',
        'b_state',
		'b_city',
		'b_pin',
		'b_gst',
        'b_address'
	];
}
