<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        // if($request->session()->get('business_id') && $request->session()->get('login_role') && $request->session()->get('login_email')){
        // }else{
        //     return back();
        // }
        return view('admin.dashboard.dashboard');
    }

    public function logout(Request $request){
        // dd($request->session()->forget('login_email'));
        $request->session()->forget('login_name');
        $request->session()->forget('login_email');
        $request->session()->forget('login_role');
        $request->session()->forget('business_id');
        return redirect('/thankyou');
    }
}
