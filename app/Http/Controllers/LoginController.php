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
use Illuminate\Support\Facades\Artisan;

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
        // dd($request->all());
        $first_login = DB::table('pending_admins')->where('emp_email', $request->email)->first();
        $otp = rand(100000, 999999);
        if (isset($User) != false) {
            $details = [
                'name' => $User->name,
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];
            // $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

            // isset($sendMail)
            if (true) {
                // define('STDIN', fopen("php://stdin", "r"));
                
                // echo "calling Schedular";
                // try {
                // Call the Artisan command
                // Artisan::call('otp:cleanup');

                // // // Optionally, get the output of the command
                // $output = Artisan::output();

                $User->update(['otp' => $otp]);
                Alert::success('Otp has been Send Successfully to Your Register Email');

                return view('auth.admin.otp');
            } else {
                Alert::warning('Email not Found, Kindly Register Your Business First');
                return view('auth.admin.otp');

                // return redirect('/login');
            }
        } else {

            if (isset($first_login) != false) {
                $details = [
                    'name' => $first_login->emp_name,
                    'title' => 'OTP Genrated',
                    'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
                ];
                $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

                // isset()
                if (isset($sendMail)) {
                   
                    $first = DB::table('pending_admins')->where('emp_email', $request->email)->update(['otp' => $otp]);
                    // dd($otp);
                    return view('auth.admin.otp');
                }
            } else {
                Alert::warning('', 'Email not Found, Kindly Register Your Business First');
                return redirect('/login');
            }
        }
        // return back();
    }


    public function loginTypeCheck(Requset $request)
    {

        dd($request->all());
    }
    public function handleCardClick(Request $request)
    {

        if (isset($request->card_type1)) {

            $cardType = $request->input('card_type1');
            $actualCardType = $cardType[0];
            $businessId = $cardType[1];
            $mainloodLoad1 = DB::table('business_details_list')->where('business_id', $businessId)->first();
            // model_has_permission 
            $load = DB::table('model_has_permissions')->where('business_id', $businessId)->first();

            if ($actualCardType === 'owner') {
                // Set session data for the owner card
                if ($mainloodLoad1) {
                    Session::put('user_type', 'owner');
                    Session::put('business_id', $businessId);
                    Session::put('branch_id', '');
                    Session::put('model_id', $load->model_id);
                    Session::put('login_role', 0);
                    Session::put('login_name', $mainloodLoad1->client_name);
                    Session::put('login_email', $mainloodLoad1->business_email);
                    Session::put('login_business_image', $mainloodLoad1->business_logo);
                } else {
                    Session::put('login_business_image', 'assets/images/users/16.jpg');
                }
                return response()->json(['root' => $actualCardType]);
            }
        }
        if (isset($request->card_type2)) {

            // return response()->json(['root' => $request->all()]);

            $cardType1 = $request->input('card_type2');
            $actualCardType1 = $cardType1[0];
            $businessId1 = $cardType1[1];
            $branchId1 = $cardType1[2];

            if ($actualCardType1 === 'admin') {
                $mainloodLoad2 = DB::table('employee_personal_details')->where('business_id', $businessId1)->where('emp_email', Session::get('email'))->first();
                $infoBusinessDetails = DB::table('business_details_list')->where('business_id', $businessId1)->first();
                if ($mainloodLoad2) {
                    DB::table('login_admin')->where('business_id', $businessId1)->where('email', Session::get('email'))->update(['is_verified' => 1]);
                    Session::put('user_type', 'admin');
                    Session::put('business_id', $businessId1);
                    Session::put('branch_id', $branchId1);
                    Session::put('login_emp_id', $mainloodLoad2->emp_id);
                    Session::put('login_role', $mainloodLoad2->role_id); //role table role id link model_has_role
                    Session::put('login_name', $mainloodLoad2->emp_name);
                    Session::put('login_email', $mainloodLoad2->emp_email);
                    Session::put('login_business_image', $infoBusinessDetails->business_logo);
                } else {
                    Session::put('login_business_image', 'assets/images/users/16.jpg');
                }

                return response()->json(['root' => $actualCardType1]);
            }
            // return response()->json(['root' => $request->all()]);
        }

        // if ($actualCardType === 'superadmin') {
        //     $mainloodLoad2 = DB::table('employee_personal_details')->where('business_id', $businessId)->where('emp_email', $request->session()->get('email'))->first();
        //     $infoBusinessDetails = DB::table('business_details_list')->where('business_id', $businessId)->first();
        //     if ($mainloodLoad2) {
        //         Session::put('user_type', 'superadmin');
        //         Session::put('business_id', $businessId);
        //         Session::put('branch_id', $mainloodLoad2->branch_id);
        //         Session::put('login_role', $mainloodLoad2->role_id);
        //         Session::put('login_name', $mainloodLoad2->emp_name);
        //         Session::put('login_email', $mainloodLoad2->emp_email);
        //         Session::put('login_business_image', $infoBusinessDetails->business_logo);
        //     } else {
        //         Session::put('login_business_image', 'assets/images/users/16.jpg');
        //     }

        //     return response()->json(['root' => $actualCardType]);
        // }
        // if($actualCardType==='employee')//employee case hold
    }

    // public function loginType
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
                if ($check_otp != null) {

                    Alert::success('Otp Authentication', 'Your Otp Verified Successfully');
                }
                return view('auth.admin.logintype');
            } else if (isset($check_otp_for_first)) {
                $now_is_admin = DB::table('login_admin')->insert([
                    'business_id' => $check_otp_for_first->business_id,
                    'name' => $check_otp_for_first->emp_name,
                    'email' => $check_otp_for_first->emp_email,
                    'phone' => $check_otp_for_first->emp_phone,
                    'country_code' => '+91',
                    'is_verified' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                if (isset($now_is_admin)) {

                    $approved = DB::table('pending_admins')->where('business_id', $check_otp_for_first->business_id)->where('emp_email', $check_otp_for_first->emp_email)->delete();
                    if (isset($approved)) {
                        Alert::success('Login Successfully', 'Now you are a Admin Position at FixingDots');
                        return view('auth.admin.logintype');
                    } else {
                        Alert::warning('Otp Aauthentication', 'Your Otp Aauthentication is Incorrect !');
                        return view('auth.admin.otp');
                    }
                }
            } else {
                Alert::warning('Otp Aauthentication', 'Your Otp Aauthentication is Incorrect !');
                return view('auth.admin.otp');
            }
        }
    }

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


    public function error()
    {
        return 'Session Expired';
    }

    public function thankyou(Request $request)
    {
        Session()->flush();
        return view('auth.admin.thanks');
    }
}