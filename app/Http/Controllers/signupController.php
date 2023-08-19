<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business_details;
use App\Models\Login;

class signupController extends Controller
{
    public function index(){
        return view('auth.admin.signup');
    }

    public function signup_otp(){
        return view('auth.admin.otp2');
    }

    public function business(){
        return view('auth.admin.business');
    }

    public function saveEmail(Request $request){
        // dd($request);
        return redirect('signup/otp');
    }

    public function saveOTP(Request $request){
        // dd($request);
        return redirect('signup/business');
    }

    public function saveBusiness(Request $request){
        // dd($request);
        return redirect('/admin');
    }

    
}
