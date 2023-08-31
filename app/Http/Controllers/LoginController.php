<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\AuthMailer;
use App\Helpers\Layout;
use DB;
use Session;
use App\Models\admin\Login_Admin;
class LoginController extends BaseController
{
    public function index()
    {
        return view('auth.admin.login');
    }

    public function login_otp(Request $request)
    {
        $request->session()->put('email', $request->email);
        $User = Login_Admin::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        $details = [
            'name' => 'd',
            'title' => 'OTP Genrated',
            'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
        ];
        $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

        if (isset($sendMail)) {
            $User->update(['otp' => $otp]);
        }
        return view('auth.admin.otp');
    }

    public function submit(Request $request)
    {
        $email = Session::get('email');
        $otp = $request->otp;
        echo $email . $otp;

        if (isset($email) && isset($otp)) {
            // dd($email);
            // dd($request->all());

            $check_otp = DB::table('login_admin')->where('email', $email)->where('otp', $otp)->first();
            if (isset($check_otp)) {

                Session::put('business_id', $check_otp->business_id);
                $request->session()->put('business_id', $check_otp->business_id);
                $request->session()->put('login_role', $check_otp->user);
                $request->session()->put('login_name', $check_otp->name);
                $request->session()->put('login_email', $check_otp->email);

                // echo $request->session()->get('business_id');

                // echo $email . $otp;

                // dd($check_otp);
                return redirect('/');
            }else{
                return back();
            }
        } else {
            return redirect('/login');
        }
        // Session::put('business_id','sfsdfdsfs');

        // return redirect('/');
    }

    public function error()
    {
        return 'Session Expired';
    }

    public function thankyou(Request $request)
    {
        session()->flush();

        return view('auth.admin.thanks');
    }

    public function AdminLogin(Request $request)
    {

    }
}