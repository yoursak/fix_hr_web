<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = "subscription";
    protected $primary_key = "id";
    protected $business_id = "business_id";

    protected $fillable = [
        'order_id',
        'payment_id',
        'name',
        'amount',
        'email',
        'phone_no',
        'order_status',
        'role_id',
        'business_id',
        'user_type',
        'plan_id',
        'base_plan',
        'per_employee_value',
        'additional_count',
        'additional_employee',
        'payment_date',
        'cycle_starting',
        'cycle_expairy',
        'cycle_remaining',
        'payment_code',
        'payment_state',
        'payment_response_code',
        'active_status'

    ];
}
