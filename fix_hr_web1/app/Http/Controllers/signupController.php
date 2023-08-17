<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class signupController extends Controller
{
    public function index(){
        return view('auth.admin.signup');
    }

    public function signup_otp(){
        return view('auth.admin.otp2');
    }

    public function save(){
        
    }
}
