<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    use HasFactory;
    protected $table="login";
    protected $primary_key="id";

    protected $casts = [
		'otp' => 'int'
	];

	protected $fillable = [
        'user',
		'name',
		'email',
        'country_code',
		'phone',
		'otp',
		'created_at',
        'updated_at'
	];
}
