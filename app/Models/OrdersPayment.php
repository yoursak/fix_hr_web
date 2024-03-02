<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersPayment extends Model
{
    use HasFactory;
    protected $table = 'orderspayment';

    protected $fillable = [
        'user_business_id',
        'amount',
        'discount',
        'gst',
        'total',
        'plan_id',
        'mode',
        'payment_id',
        'status',
        'rzp_ordered_id'
    ];
}
