<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\employee;
use App\Mail\AuthMailer;
use Carbon\Carbon;
use App\Models\employee\LoginEmployee;
use App\Http\Resources\Api\EmployeeLoginResource;
use App\Helpers\ReturnHelpers;
use App\Helpers\MasterRulesManagement\RulesManagement;


class EmployeeLoginApiController extends Controller
{
    public function login(Request $request)
    {
        $admin = DB::table('login_employee')->where('phone', $request->phone)->first();
        // return $admin;
        // dd($chckRules);
        if ($admin) {
            $rulesMangement = new RulesManagement();
            $checkRules = $rulesMangement->ALLPolicyTemplatesByIDCall($admin->business_id);
            
            // $request = DB::table('login_employee')->where('id',$admin->id)->all();
            // return $request;
            // return response()->json(['result'=>["EmployeeDetail" =>[$admin],"MasterRule" => $checkRules[0], "AttendanceMode" => $checkRules[6]], 'status' => true]);
            // , [$checkRules[0], $checkRules[6]
            return ReturnHelpers::jsonApiReturn(EmployeeLoginResource::collection([DB::table('login_employee')->where('emp_id', $admin->emp_id)->first()]));
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }


    public function MasterRule(Request $request)
    {
        $rulesMangement = new RulesManagement();
        $checkRules = $rulesMangement->ALLPolicyTemplatesByIDCall($request->business_id);
        if ($checkRules) {

            return response()->json(['result' => $checkRules[0], 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function AttendanceMode(Request $request)
    {
        $rulesMangement = new RulesManagement();
        $checkRules = $rulesMangement->ALLPolicyTemplatesByIDCall($request->business_id);
        if ($checkRules) {
            return response()->json(['result' => $checkRules[6], 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function ShiftTypeList(Request $request)
    {
        $rulesMangement = new RulesManagement();
        $checkRules = $rulesMangement->ALLPolicyTemplatesByIDCall($request->business_id);
        if ($checkRules) {
            return response()->json(['result' => $checkRules[7], 'status' => true]);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
//****************************************************************************************************************
//****************************************Email Login Check with otp*********************************************
//****************************************************************************************************************

 // public function login1(Request $request)
    // {
    //     $admin = LoginEmployee::where('email', $request->email)->first();
    //     $otp = rand(100000, 999999); // Ensure OTP is generated as a six-digit number
    //     if ($admin) {
    //         $details = [
    //             'name' => $admin->name,
    //             'title' => 'Mail from fixingdots.com ',
    //             'body' => 'Your FixHR Admin Login one time PIN is: ' . "$otp",
    //         ];
    //         $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
    //         if ($sendMail) {
    //             $updateset = LoginEmployee::where('email', $request->email)->update([
    //                 'otp' => $otp,
    //                 'otp_created_at' => Carbon::now(), // Store the OTP creation time
    //             ]);

    //             if ($updateset) {
    //                 $adminroot = LoginEmployee::where('email', $request->email)->first();
    //                 // return $adminroot;   

    //                 // Store admin information in the session
    //                 session(['admin' => $adminroot]);
    //                 // return true;
    //             return ReturnHelpers::jsonApiReturn(EmployeeLoginResource::collection([LoginEmployee::find($adminroot->id)])->all());


    //             }
    //         }
    //     }
    // }


    // public function VerifiedOtp(Request $request)
    // {
    //     $admin = LoginEmployee::where('email', $request->email)->first();

    //     if ($admin) {
    //         $otpCreationTime = Carbon::parse($admin->otp_created_at);
    //         $expirationTime = $otpCreationTime->addMinutes(5);

    //         if (Carbon::now()->lt($expirationTime)) {
    //             if ($admin->otp === $request->otp) {
    //                 // Reset the OTP and its creation time to null
    //                 LoginEmployee::where('email', $request->email)->update([
    //                     'otp' => null,
    //                     'otp_created_at' => null,
    //                     'is_verified' => null,
    //                 ]);
    //                 return ReturnHelpers::jsonApiReturn(EmployeeLoginResource::collection(['Employee_login' =>LoginEmployee::find($admin->id)])->all());

    //                 // return response()->json(['Admin_login' => $admin]);
    //             } else {
    //                 return response()->json(['Admin_login' => 'Incorrect OTP']);
    //             }
    //         } else {
    //             return response()->json(['Admin_login' => 'OTP has expired.']);
    //         }
    //     } else {
    //         return response()->json(['Admin_login' => 'Invalid OTP']);
    //     }
    //*********************************************************************************************************************************

    // public function index()
    // {
    //     //
    // }

    // public function store(Request $request)
    // {
    //     //
    // }

    // public function show($id)
    // {
    //     //
    // }

    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // public function destroy($id)
    // {
    //     //
    // }
