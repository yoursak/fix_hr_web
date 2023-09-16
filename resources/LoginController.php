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
use App\Models\admin\LoginAdmin;
class LoginController extends BaseController
{
    public function index()
    {
        return view('auth.admin.login');
    }

    public function login_otp(Request $request)
    {
        $request->session()->put('email', $request->email);
        $User = LoginAdmin::where('email', $request->email)->first();
        $first_login = DB::table('pending_admins')->where('emp_email', $request->email)->first();
        $otp = rand(100000, 999999);
        if(isset($User)){
            $details = [
                'name' => $User->name,
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];
            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
    
            if (isset($sendMail)) {
                $User->update(['otp' => $otp]);
            }
            return view('auth.admin.otp');
        }
         if (isset($first_login)) {
            $details = [
                'name' => $first_login->emp_name,
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];
            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
    
            if (isset($sendMail)) {
                $first = DB::table('pending_admins')->where('emp_email', $request->email)->update(['otp' => $otp]);
                // dd($otp);
            }
            return view('auth.admin.otp');
        }
    }

    public function submit(Request $request)
    {
        $email = Session::get('email');
        $otp = $request->otp;
        // echo $email . $otp;

        if (isset($email) && isset($otp)) {

            $check_otp = DB::table('login_admin')->where('email', $email)->where('otp', $otp)->first();
            $check_otp_for_first = DB::table('pending_admins')->where('emp_email', $email)->where('otp', $otp)->first();
            $employee_check = DB::table('employee_personal_details')->where('emp_email', $email)->first();
            if (isset($check_otp)) {

                // Session::put('business_id', $check_otp->business_id);
                $request->session()->put('business_id', $check_otp->business_id);
                $request->session()->put('login_role', $check_otp->user);
                $request->session()->put('login_name', $check_otp->name);
                $request->session()->put('login_email', $check_otp->email);
                $request->session()->put('login_emp_id', $employee_check->emp_id);

                return redirect('/');
            }elseif (isset($check_otp_for_first)) {
                $request->session()->put('business_id', $check_otp_for_first->business_id);
                $request->session()->put('login_role', 'admin');
                $request->session()->put('login_name', $check_otp_for_first->emp_name);
                $request->session()->put('login_email', $check_otp_for_first->emp_email);
                $request->session()->put('login_phone', $check_otp_for_first->emp_phone);
                $request->session()->put('login_emp_id', $employee_check->emp_id);

                return redirect()->route('make.admin');
            }else{
                return back();
            }
        } else {
            return redirect('/login');
        }
    }

    public function error()
    {
        return 'Session Expired';
    }

    public function thankyou(Request $request)
    {
        Session()->flush();
        return view('auth.admin.thanks');
    }

    public function AdminLogin(Request $request)
    {

    }
}