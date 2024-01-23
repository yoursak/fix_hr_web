<?php

namespace App\Http\Controllers\paymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CcAvenueController extends Controller
{
    public function index(){
        return view('admin.subscription.rooting');
    }
    public function loadCompute()
    {

    }
}
