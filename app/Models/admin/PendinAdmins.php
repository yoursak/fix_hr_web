<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pending_admins extends Model
{
    use HasFactory;
    protected $table = "pending_admins";
    protected $fillable = [
        "business_id","branch_id","emp_id","emp_name","emp_email","emp_phone"
    ] ;

    protected $casts = [
        'otp'
    ] ;
}
