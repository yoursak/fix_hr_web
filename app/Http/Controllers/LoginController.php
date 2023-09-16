<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\AuthMailer;
use App\Helpers\Layout;
use DB;
use Session;
use App\Models\admin\LoginAdmin;
use App\Helpers\Central_unit;

class LoginController extends BaseController
{
    public function index()
    {
        // $businessID = "ef4ae3f5e5c70b8454cf90498eae61d9";
        // $email = "amansahu.er@gmail.com";
        // // Session::put('business_id', $businessID);

        // $checking = DB::table('login_admin')->where('email', $email)
        //     ->join('universal_roles_define', 'universal_roles_define.role_id', '=', 'login_admin.user')
        //     ->get();
        // // ->select('universal_roles_define.*')->get();
        // $businessIDtoName = DB::table('business_details_list')->where('business_email', $email)->first();
        // return view('auth.admin.logintype', compact('checking', 'businessIDtoName'));


        return view('auth.admin.login');
    }

    public function login_otp(Request $request)
    {
        $request->session()->put('email', $request->email);
        $User = LoginAdmin::where('email', $request->email)->first();
        $first_login = DB::table('pending_admins')->where('emp_email', $request->email)->first();
        $otp = rand(100000, 999999);
        if (isset($User)) {
            $details = [
                'name' => $User->name,
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];
            // $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

            if (true) {  // if (isset($sendMail)) {
                $User->update(['otp' => $otp]);
                return view('auth.admin.otp');
            }
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
                return view('auth.admin.otp');
            }
        }
        // return back();
    }

    //     $checking = DB::table('login_admin')->where('email', $email)
    //     ->join('universal_roles_define', 'universal_roles_define.role_id', '=', 'login_admin.user')
    //     ->get();
    // // ->select('universal_roles_define.*')->get();
    // $businessIDtoName = DB::table('business_details_list')->where('business_email', $email)->first();


    public function loginTypeCheck(Requset $request)
    {

        dd($request->all());
    }

    // public function loginType
    public function submit(Request $request)
    {

        $email = Session::get('email');
        $otp = $request->otp;
        // echo $email . $otp;
        if (isset($email) && isset($otp)) {

            $checking = DB::table('login_admin')
                ->join('business_details_list', 'business_details_list.business_email', '=', 'login_admin.email')
                ->join('universal_roles_define', 'universal_roles_define.role_id', '=', 'login_admin.user')
                ->where('email', $email)
                ->get();
            // ->select('universal_roles_define.*')->get();
            $businessIDtoName = DB::table('business_details_list')->where('business_email', $email)->first();

            $check_otp = DB::table('login_admin')->where('email', $email)->where('otp', $otp)->first();
            $check_otp_for_first = DB::table('pending_admins')->where('emp_email', $email)->where('otp', $otp)->first();
            $employee_check = DB::table('employee_personal_details')->where('emp_email', $email)->first();
            if (isset($check_otp)) {


                // Session::put('business_id', $check_otp->business_id);
                $request->session()->put('business_id', $check_otp->business_id);
                $request->session()->put('login_role', $check_otp->user);
                $request->session()->put('login_name', $check_otp->name);
                $request->session()->put('login_email', $check_otp->email);
                $request->session()->put('branch_id', $employee_check->branch_id);
                // if ($employee_check->emp_id) {
                //     $request->session()->put('login_emp_id', $employee_check->emp_id);
                // }


                return view('auth.admin.logintype', compact('checking'));

                // return redirect('/');
            }

            if (isset($check_otp_for_first)) {
                $request->session()->put('business_id', $check_otp->business_id);
                $request->session()->put('login_email', $check_otp_for_first->emp_email);
                $request->session()->put('login_emp_id', $employee_check->emp_id);
                $request->session()->put('branch_id', $employee_check->branch_id);

                // dd("aasd");
                $now_is_admin = DB::table('login_admin')->insert([
                    'user' => 1,
                    'business_id' => $check_otp_for_first->business_id,
                    'name' =>  $check_otp_for_first->emp_name,
                    'email' =>  $check_otp_for_first->emp_email,
                    'phone' => $check_otp_for_first->emp_phone,
                    'country_code' => +91,
                    'is_verified' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                if (isset($now_is_admin)) {

                    $approved = DB::table('pending_admins')->where('emp_email',  $check_otp_for_first->emp_email)->delete();

                    if (isset($approved)) {
                        Alert::success('Login Successfully', 'Now you are a Admin Position at FixingDots');
                    }
                }
                // dd($request->all());
                return redirect('/');

                // return redirect()->route('make.admin');
            }
            // else {
            //     return back();
            // }
        }
        
        // else {
        //     return redirect('/login');
        // }

        // if (isset($email) && isset($otp)) {

        //     $checking = DB::table('login_admin')
        //     ->join('business_details_list','business_details_list.business_email','=','login_admin.email')
        //     ->join('universal_roles_define', 'universal_roles_define.role_id', '=', 'login_admin.user')
        //     ->where('email', $email)
        //      ->get();
        //     // ->select('universal_roles_define.*')->get();
        //     $businessIDtoName = DB::table('business_details_list')->where('business_email', $email)->first();

        //     $check_otp = DB::table('login_admin')->where('email', $email)->where('otp', $otp)->first();
        //     $check_otp_for_first = DB::table('pending_admins')->where('emp_email', $email)->where('otp', $otp)->first();
        //     $employee_check = DB::table('employee_personal_details')->where('emp_email', $email)->first();
        //     if (isset($check_otp)) {


        //         // Session::put('business_id', $check_otp->business_id);
        //         $request->session()->put('business_id', $check_otp->business_id);
        //         $request->session()->put('login_role', $check_otp->user);
        //         $request->session()->put('login_name', $check_otp->name);
        //         $request->session()->put('login_email', $check_otp->email);
        //         $request->session()->put('branch_id', $employee_check->branch_id);
        //         if ($employee_check->emp_id) {
        //             $request->session()->put('login_emp_id', $employee_check->emp_id);
        //         }


        //         return view('auth.admin.logintype', compact('checking'));

        //         // return redirect('/');
        //     } 
        //      if (isset($check_otp_for_first)) {
        //         $request->session()->put('business_id', $check_otp_for_first->business_id);
        //         $request->session()->put('login_role', 'admin');
        //         $request->session()->put('login_name', $check_otp_for_first->emp_name);
        //         $request->session()->put('login_email', $check_otp_for_first->emp_email);
        //         $request->session()->put('login_phone', $check_otp_for_first->emp_phone);
        //         $request->session()->put('login_emp_id', $employee_check->emp_id);
        //         $request->session()->put('branch_id', $employee_check->branch_id);

        //         return redirect()->route('make.admin');
        //     } else {
        //         return back();
        //     }
        // } else {
        //     return redirect('/login');
        // }
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
