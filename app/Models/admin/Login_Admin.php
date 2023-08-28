<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login_Admin extends Model
{
    use HasFactory;
    protected $table = 'login_admin';
    protected $primary_key="admin_login_id";

    protected $casts = [
		'otp' => 'int'
	];

	protected $fillable = [
        'user',
        'business_id',
		'name',
		'email',
        'country_code',
		'phone',
		'otp',
		'created_at',
        'updated_at'
	];

}
