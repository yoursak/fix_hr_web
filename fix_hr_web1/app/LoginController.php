<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    public function index(){
        return view('auth.admin.login');
    }

    public function login_otp(){
        return view('auth.admin.otp');
    }

    public function signup_otp(){
        return view('auth.admin.signup');
    }

    public function submit(){
        return redirect('/');
    }
}
