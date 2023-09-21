<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mail\AuthMailer;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('admin.dashboard.dashboard');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/thankyou');
    }
}