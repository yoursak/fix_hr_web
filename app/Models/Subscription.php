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
        'user_type',
        'model_id',
        'name',
        'email',
        'phone_no',
        'plan_id',
        'base_plan',
        'additional_count',
        'additional_employee',
        'payment_code',
        'payment_merchant_id',
        'payment_merchant_transaction',
        'payment_transaction_id',
        'payment_amount',
        'payment_state',
        'payment_instrument_type',
        'payment_response_code',
        'payment_date',
        'active_status'
    ];
}
