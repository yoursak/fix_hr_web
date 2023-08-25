<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Layout;
use DB;

class LoginController extends Controller
{
    public function index(){
        return view('auth.admin.login');
    }

    public function login_otp(Request $request){
        // dd($request);
        return view('auth.admin.otp');
    }

    public function submit(Request $request){
        return redirect('/admin');
    }

    public function error(){
        return Redirect::back();
    }
}
