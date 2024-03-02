<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\employee;
use App\Mail\AuthMailer;
use App\Models\LoginEmployee;
use App\Models\EmployeePersonalDetail;
use Carbon\Carbon;
// use App\Models\employee\LoginEmployee;
use App\Http\Resources\Api\UserSideResponse\EmployeeLoginResource;
use App\Helpers\ReturnHelpers;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Resources\Api\UserSideResponse\MultipleLogin;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;

class EmployeeLoginApiController extends Controller
{
    public function login(Request $request)
    {
        $phoneno = $request->phone;
        $otp = mt_rand(100000, 999999);
        $encodedOTP = urlencode($otp);
        $app = 'https://fixhr.app';
        $message = "Your One-Time Password (OTP) is {$encodedOTP}. Please enter this code to proceed. Thanks {$app} NSL LIFE";

        $url = "https://mobicomm.dove-sms.com/submitsms.jsp?user=KesarE&key=8360975400XX&senderid=NSLSMS&mobile={$phoneno}&message=" . urlencode($message) . '&accusage=6';

        $response = Http::withoutVerifying()->get($url);

        // return  ReturnHelpers::jsonApiReturn(EmployeeLoginResource::collection([DB::table('login_employee')->where('emp_id', $admin->emp_id)->first()]), 200);
        $admin = LoginEmployee::where('phone', $phoneno)->first();
        if ($admin && $response->successful()) {
            if ($admin) {
                $updateset = LoginEmployee::where('phone', $admin->phone)->update([
                    'otp' => $otp,
                    'otp_created_at' => Carbon::now(),
                ]);
                return response()->json(
                    [
                        'result' => EmployeeLoginResource::collection([
                            DB::table('login_employee')
                                ->where('emp_id', $admin->emp_id)
                                ->first(),
                        ]),
                        'message' => 'OTP has been Sent Successfully',
                        'status' => true,
                        'case' => 1,
                    ],
                    200,
                );
            } else {
                return response()->json(['result' => [], 'message' => 'You are Unauthorized to Login', 'status' => true, 'case' => 2], 200);
            }
        } else {
            return response()->json(['result' => [], 'message' => 'Server Not Found ! Please try after some Time.', 'status' => false, 'case' => 3], 404);
        }
    }
    public function VerifiedOtp(Request $request)
    {
        $phoneno = $request->phone;
        $Otp = $request->otp;
        $fcmToken = $request->fcm_token;
        $verify = LoginEmployee::where('phone', $phoneno)->first();

        if (!empty($verify)) {
            $EmployeeInfomation = EmployeePersonalDetail::where('business_id', $verify->business_id)
                ->where('emp_id', $verify->emp_id)
                ->where('emp_mobile_number', $verify->phone)
                ->first();

            $otpCreationTime = Carbon::parse($verify->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(10);

            if (Carbon::now()->lt($expirationTime)) {
                if ($verify->otp === $Otp) {
                    // Retrieve existing notification_key array or initialize as empty array
                    $notificationKeys = $verify->notification_key ? json_decode($verify->notification_key, true) : [];

                    // Check if $fcmToken already exists in the array
                    if (!in_array($fcmToken, $notificationKeys)) {
                        // Add $fcmToken to the array
                        $notificationKeys[] = $fcmToken;

                        LoginEmployee::where('phone', $phoneno)->update([
                            'otp' => null,
                            'otp_created_at' => null,
                            'notification_key' => json_encode($notificationKeys),
                        ]);
                    }

                    return response()->json(
                        [
                            'result' => LoginEmployee::where('phone', $phoneno)->select('emp_id', 'business_id', 'email', 'phone')->first(),
                            'status' => true,
                            'case' => 1,
                            'active_employee' => $EmployeeInfomation->active_emp,
                        ],
                        200,
                    );
                } else {
                    return response()->json(['result' => 'Incorrect OTP', 'status' => false, 'case' => 2], 200);
                }
            } else {
                return response()->json(['result' => 'OTP has expired.', 'status' => false, 'case' => 3], 200);
            }
        } else {
            return response()->json(['result' => 'Invalid OTP', 'status' => false, 'case' => 4], 404);
        }
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

    public function getMultipleLogin(Request $request)
    {
        $userPhoneNo = $request->phone;
        $checked = EmployeePersonalDetail::where('emp_mobile_number', $userPhoneNo)->get();

        if (!empty($checked)) {
            return response()->json(
                [
                    'result' => MultipleLogin::collection($checked),
                    'case' => 1,
                    'status' => true,
                    'message' => 'found multiple account this number',
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'result' => [],
                    'case' => 2,
                    'status' => false,
                    'message' => 'Not Multiple Account ',
                ],
                200,
            );
        }
    }

    public function employeeLogout(Request $request)
    {
        $userEmpID = $request->emp_id;
        $userPhoneNo = $request->phone;
        $BID = $request->business_id;
        $fcmKey = $request->fcm_key;

        // Retrieve the current notification_key for the user
        $user = LoginEmployee::where('phone', $userPhoneNo)
            ->where('business_id', $BID)
            ->where('emp_id', $userEmpID)
            ->first();

        if ($user) {
            $notificationKeyArray = json_decode($user->notification_key);

            // Remove the specified fcmKey from the notification_key array
            $updatedNotificationKeyArray = array_diff($notificationKeyArray, [$fcmKey]);

            // Update the notification_key column with the modified array
            $user->update(['notification_key' => json_encode(array_values($updatedNotificationKeyArray))]);

            return response()->json(['result' => 'Logout Successfully', 'status' => true, 'case' => 1], 200);
        } else {
            return response()->json(['result' => 'User not found', 'status' => false, 'case' => 2], 404);
        }
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
