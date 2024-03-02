<?php

namespace App\Http\Controllers\admin\Onlinepay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnlinepayController extends Controller
{
    public function index()
    {
        return view('admin.onlinepay.onlinepay');
    }
    public function deductions()
    {
        return view('admin.onlinepay.payment.deductions');
    }
    public function onlinePay()
    {
        return view('admin.onlinepay.payment.online_pay');
    }
    public function paymentEntry()
    {
        return view('admin.onlinepay.payment.payment_entry');
    }
}
