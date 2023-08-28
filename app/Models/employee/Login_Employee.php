<?php

namespace App\Models\employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login_Employee extends Model
{
    use HasFactory;
    protected $table = 'login_employee';
	protected $primaryKey = 'id';
	public $timestamps = false;
}
