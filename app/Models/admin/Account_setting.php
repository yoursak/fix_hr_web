<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_setting extends Model
{
    use HasFactory;
	protected $table="account_setting";
    protected $primary_key="id";

    protected $casts = [
		'updated_at' => 'timestamp'
	];

	protected $fillable = [
        'user',
		'name',
        'country_code',
        'phone',
		'email_address',
		'business_id',
		'subscriptions',
        'updated_at'
	];
}
