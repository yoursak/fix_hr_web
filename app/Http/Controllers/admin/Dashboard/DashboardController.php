<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Mail\AuthMailer;

class DashboardController extends Controller
{
    public function index()
    {

        return view('admin.dashboard.dashboard');
    }

    public function logout(Request $request)
    {
        // session()->flush();
      
        // dd($request->session()->forget('login_email'));
        $request->session()->forget('login_name');
        $request->session()->forget('login_email');
        $request->session()->forget('login_role');
        $request->session()->forget('business_id');
        return redirect('/thankyou');
    }
}