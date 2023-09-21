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
                $User->update(['otp' => $otp]);
                Alert::success('', 'Otp has been Send Successfully to Your Register Email');

                return view('auth.admin.otp');
            } else {
                Alert::warning('', 'Email not Found, Kindly Register Your Business First');
                return view('auth.admin.otp');

                return redirect('/login');
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

        $cardType = $request->input('card_type');
        $actualCardType = $cardType[0];
        $businessId = $cardType[1];


        // For example, you can check the card type and business ID:

        if ($actualCardType === 'owner') {
            // Set session data for the owner card
            $mainloodLoad1 = DB::table('business_details_list')->where('business_id', $businessId)->first();
            if ($mainloodLoad1) {
                Session::put('user_type', 'owner');
                Session::put('business_id', $businessId);
                Session::put('branch_id', '');
                Session::put('login_role', 0);
                Session::put('login_name', $mainloodLoad1->client_name);
                Session::put('login_email', $mainloodLoad1->business_email);
                Session::put('login_business_image', $mainloodLoad1->business_logo);
            } else {
                Session::put('login_business_image', 'assets/images/users/16.jpg');
            }
            return response()->json(['root' => $actualCardType]);
        }
        if ($actualCardType === 'admin') {
            $mainloodLoad2 = DB::table('employee_personal_details')->where('business_id', $businessId)->where('emp_email', $request->session()->get('email'))->first();
            $infoBusinessDetails = DB::table('business_details_list')->where('business_id', $businessId)->first();
            if ($mainloodLoad2) {
                Session::put('user_type', 'admin');
                Session::put('business_id', $businessId);
                Session::put('branch_id', $mainloodLoad2->branch_id);
                Session::put('login_role', $mainloodLoad2->role_id);
                Session::put('login_name', $mainloodLoad2->emp_name);
                Session::put('login_email', $mainloodLoad2->emp_email);
                Session::put('login_business_image', $infoBusinessDetails->business_logo);
            } else {
                Session::put('login_business_image', 'assets/images/users/16.jpg');
            }

            return response()->json(['root' => $actualCardType]);
        }
        if ($actualCardType === 'superadmin') {
            $mainloodLoad2 = DB::table('employee_personal_details')->where('business_id', $businessId)->where('emp_email', $request->session()->get('email'))->first();
            $infoBusinessDetails = DB::table('business_details_list')->where('business_id', $businessId)->first();
            if ($mainloodLoad2) {
                Session::put('user_type', 'superadmin');
                Session::put('business_id', $businessId);
                Session::put('branch_id', $mainloodLoad2->branch_id);
                Session::put('login_role', $mainloodLoad2->role_id);
                Session::put('login_name', $mainloodLoad2->emp_name);
                Session::put('login_email', $mainloodLoad2->emp_email);
                Session::put('login_business_image', $infoBusinessDetails->business_logo);
            } else {
                Session::put('login_business_image', 'assets/images/users/16.jpg');
            }

            return response()->json(['root' => $actualCardType]);
        }
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
            //         Alert::success('Login Otp', 'Otp is verified successfully');

            if (isset($check_otp)) {
                // dd($email);

                $checking = DB::table('login_admin')
                    ->join('business_details_list', function ($join) {
                        $join->on('business_details_list.business_id', '=', 'login_admin.business_id');
                        // $join->on('business_details_list.business_email', '=', 'login_admin.email');

                    })
                    ->join('roles', function ($join) {
                        // $join->on('roles.business_id', '=', 'login_admin.business_id');
                        $join->on('roles.id', '=', 'login_admin.role_id');
                        // $join->on('roles.id', '=', 'login_admin.role_id');

                    })
                    ->where('email', $check_otp->email)
                    ->select('*', 'roles.name as rolename')
                    ->get();
                // dd($checking);

                if (isset($check_otp)) {
                    Alert::success('Otp Aauthentication', 'Your Otp Verified Successfully');
                    if (isset($checking)) {
                        Alert::success('Welocme', 'To FixHr Admin Dashboard');
                    }
                    return view('auth.admin.logintype', compact('checking'));
                    // return view('auth.admin.otp');
                } else {
                    // return redirect('/');

                    // return redirect('/');
                    Alert::warning('Otp Aauthentication', 'Your Otp Aauthentication is Incorrect !');
                    return view('auth.admin.otp');
                }
            }

            if (isset($check_otp_for_first)) {
                // $BusinessID = $check_otp_for_first->business_id;
                // $BrandID = $check_otp_for_first->branch_id;
                // $Role = $check_otp_for_first->user;
                // $LoginName = $check_otp_for_first->emp_name;
                // $LoginEmail = $check_otp_for_first->emp_email;
                // Session::put('business_id', $BusinessID);
                // Session::put('branch_id', $BrandID);
                // Session::put('user_type', 1);
                // $checkingRole = DB::table('employee_personal_details')
                //     ->join('roles', 'employee_personal_details.role_id', '=', 'roles.id')
                //     ->where('employee_personal_details.emp_email', $check_otp_for_first->emp_email)
                //     ->where('employee_personal_details.business_id', $check_otp_for_first->business_id)
                //     ->where('employee_personal_details.branch_id', $check_otp_for_first->branch_id)
                //     ->select('employee_personal_details.*')
                //     ->first();
                $cast=DB::table('roles')->where('business_id',$check_otp_for_first->business_id)->where('branch_id',$check_otp_for_first->branch_id)->first();
                // dd($cast);
                // Session::put('login_name', $LoginName);
                // Session::put('login_email', $LoginEmail);
                $now_is_admin = DB::table('login_admin')->insert([
                    'user' => 1,
                    'business_id' => $check_otp_for_first->business_id,
                    'name' => $check_otp_for_first->emp_name,
                    'email' => $check_otp_for_first->emp_email,
                    'phone' => $check_otp_for_first->emp_phone,
                    'role_id' => $cast->id,//role_id
                    'country_code' => '+91',
                    'is_verified' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                if (isset($now_is_admin)) {

                    $approved = DB::table('pending_admins')->where('business_id', $check_otp_for_first->business_id)->where('emp_email', $check_otp_for_first->emp_email)->delete();
                    if (isset($approved)) {
                        Alert::success('Login Successfully', 'Now you are a Admin Position at FixingDots');

                        if ($approved) {
                            Alert::success('Otp Aauthentication', 'Your Otp Verified Successfully');
                            // if ($checking) {
                            //     Alert::success('Welocme', 'To FixHr Admin Dashboard');
                            // }
                            // return view('auth.admin.logintype', compact('checking'));
                            // return view('auth.admin.otp');
                            return redirect('/');
                        } else {

                            // return redirect('/');
                            Alert::warning('Otp Aauthentication', 'Your Otp Aauthentication is Incorrect !');
                            return view('auth.admin.otp');
                        }
                    }
                } else {
                    return back();
                }
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
