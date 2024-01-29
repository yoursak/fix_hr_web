<?php

namespace App\Http\Controllers\ApiController\ApiAdminController;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use DateTime;
use App\Mail\AuthMailer;
use Illuminate\Support\Facades\Mail;
use App\Models\LoginAdmin;
use App\Models\CameraPermission as CameraPermissionModel;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AdminLoginResource;
use App\Http\Resources\Api\AdminSideResponse\CameraPermission;
use App\Models\EmployeePersonalDetail;
use App\Models\BusinessDetailsList;
use App\Http\Resources\Api\AdminSideResponse\Auth\LoginAdminResources;
use App\Http\Resources\Api\AdminSideResponse\Auth\LoginSuperAdminResources;
use App\Http\Resources\Api\EmployeeResource;
use Illuminate\Support\Facades\Validator;

use App\Models\BranchList;

// use Session;
class ApiLoginController extends BaseController
{
    public function login(Request $request)
    {
        $admin = LoginAdmin::where('email', $request->email)->first();
        $otp = rand(100000, 999999); // Ensure OTP is generated as a six-digit number

        if ($admin) {
            $details = [
                'name' => $admin->name,
                'title' => 'Mail from fixingdots.com ',
                'body' => 'Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];

            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

            if ($sendMail) {
                $updateset = LoginAdmin::where('email', $request->email)->update([
                    'otp' => $otp,
                    'otp_created_at' => Carbon::now(),
                    // Store the OTP creation time
                ]);

                if ($updateset) {
                    $adminroot = LoginAdmin::where('email', $request->email)->first();

                    // Store admin information in the session
                    // session(['admin' => $adminroot]);
                    // return response()->json(['Admin_login' => [$adminroot]]);

                    return ReturnHelpers::jsonApiReturn(AdminLoginResource::collection([LoginAdmin::find($adminroot->id)])->all());
                }
            }
        }
        return response()->json(['result' => [], 'status' => false], 401);
    }

    public function VerifiedOtp(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;
        $imei = $request->imei_no;
        $ip = $request->ip_address;
        $Notification = $request->notification;
        $log_active = 1;

        $admin = LoginAdmin::where('email', $email)->first();
        // return true;
        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(10);

            // Notification tokenApi
            $tokenVerifiy = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->first();

            $tokenMatching = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->where('notification_token', $Notification)->first();
            if (isset($tokenVerifiy) || isset($tokenMatching)) {
                $loaded = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->update([
                    'business_id' => $admin->business_id,
                    'email' => $email,
                    'imei_no' => $imei,
                    'ip_address' => $ip,
                    'notification_token' => $Notification,
                    'log_active' => $log_active,
                    'log_deactive' => 0
                ]);
            } else {
                $load = DB::table('login_token_admin')->insert(
                    [
                        'business_id' => $admin->business_id,
                        'email' => $email,
                        'imei_no' => $imei,
                        'ip_address' => $ip,
                        'notification_token' => $Notification,
                        'log_active' => $log_active,
                        'log_deactive' => 0
                    ]
                );
            }

            $case = 0;
            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $otp) {

                    // $data = $admin->createToken("API TOKEN")->plainTextToken;
                    $token = $admin->createToken('API Token');

                    // Reset the OTP and its creation time to null
                    $updateAdmin = LoginAdmin::where('email', $email)->update([
                        'otp' => null,
                        'otp_created_at' => null,
                        'is_verified' => 1,
                        'api_token' => $token->plainTextToken
                    ]);
                    if (isset($updateAdmin)) {
                        // bID or static role 1 check in business_details // all access role-mode bID, role - 1
                        // bID or static role 2 check in employee_personal_details get in role_id only   bID : encrypted ,role : - 2 ,  assign role : is_role -1

                        // 1 step checking in which gmail type of list load no of checkin admin-login finding with gmail
                        // $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $email)->first();
                        $list_of_handling = LoginAdmin::where('login_admin.email', $email)
                            ->leftJoin('static_login_type_selected', 'login_admin.static_role', '=', 'static_login_type_selected.id')
                            ->leftJoin('business_details_list', 'login_admin.business_id', '=', 'business_details_list.business_id')
                            ->select('static_login_type_selected.login_type', 'static_login_type_selected.description', 'business_details_list.business_name', 'business_details_list.business_logo', 'login_admin.static_role', 'login_admin.business_id', 'login_admin.email', 'login_admin.is_verified', 'login_admin.api_token')->get();
                        $count_account_created = LoginAdmin::where('email', $email)->count();
                        $case = ($count_account_created > 1) ? 2 : 1;
                        $account = ($count_account_created > 1) ? 'multiple' : 'single';
                        return response()->json(['result' => $list_of_handling, 'account' => $account, 'case' => $case]); //single account
                    }

                    // return $admin;
                } else {
                    return response()->json(['result' => ['Admin_login => Incorrect OTP.'], 'status' => false], 401);
                    // ['Admin_login' => 'Incorrect OTP']
                }
            } else {
                return response()->json(['result' => ['Admin_login => OTP has expired.'], 'status' => false], 401);
            }
        } else {
            return response()->json(['result' => ['Admin_login => Invalid OTP.'], 'status' => false], 401);
        }
        return response()->json(['result' => [], 'status' => false], 401);
    }

    // protected $signature = 'field:update-null';

    // public function handle()
    // {
    //     $currentTime = now();

    //     // Calculate the time threshold (5 minutes)
    //     $threshold = now()->subMinutes(5);

    //     // Find records where 'sent_at' is not null and 'null_after' is null
    //     $records = Login_admin::whereNotNull('sent_at')
    //         ->whereNull('null_after')
    //         ->where('sent_at', '<=', $threshold)
    //         ->get();

    //     foreach ($records as $record) {
    //         $record->update([
    //             'otp' => null,
    //             'null_after' => $currentTime,
    //         ]);
    //     }

    //     $this->info('Fields updated to null successfully.');
    // }
    public function resendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $otpData = EmailVerification::where('email', $request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if ($currentTime >= $time && $time >= $currentTime - (90 + 5)) {
            //90 seconds
            return response()->json(['success' => false, 'msg' => 'Please try after some time']);
        } else {
            $this->sendOtp($user); //OTP SEND
            return response()->json(['success' => true, 'msg' => 'OTP has been sent']);
        }
    }

    public function index()
    {
        if ($admin = true) {
            return response()->json(['success' => false, 'msg' => 'Jayant']);
        }
        return response()->json(['success' => false, 'msg' => 'Error']);
    }

    public function cameraLogin(Request $request)
    {

        $branchEmail = $request->branch_email;
        $admin = DB::table('camera_permission')->where('branch_email', $branchEmail)->first();

        $otp = rand(100000, 999999); // Ensure OTP is generated as a six-digit number

        if ($admin) {
            $details = [
                'name' => $branchEmail,
                'title' => 'Mail from fixingdots.com ',
                'body' => 'Your FixHR Admin Login one time PIN is: ' . "$otp",
            ];

            // $sendMail = Mail::to($branchEmail)->send(new AuthMailer($details));

            if (true) {
                $updateset = DB::table('camera_permission')->where('branch_email', $branchEmail)->update([
                    'otp' => $otp,
                    'otp_created_at' => Carbon::now(),
                    // Store the OTP creation time
                ]);

                if ($updateset) {
                    $adminroot = DB::table('camera_permission')->where('branch_email', $branchEmail)->select('business_id', 'branch_id', 'otp', 'otp_created_at', 'is_verified')->first();

                    return response()->json(['result' => $adminroot, 'status' => true], 200);
                }
            }
        }
        return response()->json(['result' => [], 'status' => false], 401);
    }

    public function cameraVerifyPermission(Request $request)
    {
        $bID = $request->business_id;
        $branchEmail = $request->branch_email; //sensitive
        $otp = $request->branch_otp;
        $attendanceType = $request->attendance_type;
        $imeiNumber = $request->imei_no;
        $admin = DB::table('camera_permission')->where('branch_email', $branchEmail)->where('otp', $otp)->where('imei_number', $imeiNumber)->first();
        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(10);
            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $otp) {

                    // $data = $admin->createToken("API TOKEN")->plainTextToken;
                    // $token = $admin->createToken('API Token');

                    // Reset the OTP and its creation time to null
                    $updateAdmin = $admin = DB::table('camera_permission')->where('branch_email', $branchEmail)->update([
                        'otp' => null,
                        'otp_created_at' => null,
                        'is_verified' => 1,
                        // 'api_token' => $token->plainTextToken
                    ]);

                    if ($updateAdmin) {
                        $checked = DB::table('camera_permission')
                            ->leftJoin('business_details_list', 'camera_permission.business_id', '=', 'business_details_list.business_id')
                            ->leftJoin('branch_list', 'camera_permission.branch_id', '=', 'branch_list.branch_id')
                            ->where('camera_permission.business_id', $bID)->where('camera_permission.branch_email', $branchEmail)->where('camera_permission.imei_number', $imeiNumber)->where('camera_permission.type_check', $attendanceType)
                            ->select('camera_permission.*', 'business_details_list.business_name', 'branch_list.branch_email', 'branch_list.branch_name', 'branch_list.is_active', 'branch_list.address', 'branch_list.logitude', 'branch_list.latitude')
                            ->first();
                        // dd($checked);
                        return response()->json(['result' => CameraPermission::collection([$checked])->all(), 'message' => 'Allow Camera Access Permission', 'status' => true, 'case' => 1], 200);
                    } else {
                        return response()->json(['result' => [], 'message' => 'Not Allow Camera Access Permission !', 'status' => false, 'case' => 2], 401);
                    }
                } else {
                    return response()->json(['result' => [], 'message' => ' Incorrect OTP.', 'status' => false, 'case' => 3], 401);
                }
            } else {
                return response()->json(['result' => [], 'message' => 'OTP has expired.', 'status' => false, 'case' => 4], 401);
            }
        } else {
            return response()->json(['result' => [], 'message' => 'IMEI Number is not found.', 'status' => false, 'case' => 5], 401);
        }
        // $bID = $request->business_id;
        // $attendanceType = $request->attendance_type;
        // $imeiNumber = $request->imei_no;
        // $branchEmail = $request->branch_email;

        // $checked = DB::table('camera_permission')
        //     ->leftJoin('business_details_list', 'camera_permission.business_id', '=', 'business_details_list.business_id')
        //     ->leftJoin('branch_list', 'camera_permission.branch_id', '=', 'branch_list.branch_id')
        //     ->where('camera_permission.business_id', $bID)->where('camera_permission.branch_email', $branchEmail)->where('camera_permission.imei_number', $imeiNumber)->where('camera_permission.type_check', $attendanceType)
        //     ->select('camera_permission.*', 'business_details_list.business_name', 'branch_list.branch_email', 'branch_list.branch_name', 'branch_list.is_active', 'branch_list.address', 'branch_list.logitude', 'branch_list.latitude')
        //     ->first();
        // if (isset($checked)) {
        //     return response()->json(['result' => CameraPermission::collection([$checked])->all(), 'message' => 'Allow Camera Access Permission', 'status' => true, 'case' => 1], 200);
        // } else {

        //     return response()->json(['result' => [], 'message' => 'Not Allow Camera Access Permission !', 'status' => false], 401);
        // }
    }

    public function Logout(Request $request)
    {
        $Gmail = $request->gmail;
        $BusinessID = $request->business_id;
        $Imei = $request->imei_no;

        $admin = DB::table('login_token_admin')->where('business_id', $BusinessID)
            ->where('email', $Gmail)
            ->where('imei_no', $Imei)
            ->first();

        if (isset($admin)) {
            $load = DB::table('login_token_admin')->where('business_id', $BusinessID)
                ->where('email', $Gmail)
                ->where('imei_no', $Imei)
                ->update([
                    'log_deactive' => 1,
                    'log_active' => 0,
                ]);
            return response()->json(['result' => $admin, 'status' => true], 200);
        } else {
            return response()->json(['result' => 'Not found', 'status' => false], 401);
        }
    }



    public function store(Request $request)
    {
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

// public function VerifiedOtp(Request $request)
// {
//     $email = $request->email;
//     $otp = $request->otp;
//     $imei = $request->imei_no;
//     $ip = $request->ip_address;
//     $Notification = $request->notification;
//     $log_active = 1;

//     $admin = LoginAdmin::where('email', $email)->first();
//     // return true;
//     if ($admin) {
//         $otpCreationTime = Carbon::parse($admin->otp_created_at);
//         $expirationTime = $otpCreationTime->addMinutes(10);

//         // Notification tokenApi
//         $tokenVerifiy = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->first();

//         $tokenMatching = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->where('notification_token', $Notification)->first();
//         if (isset($tokenVerifiy) || isset($tokenMatching)) {
//             $loaded = DB::table('login_token_admin')->where('business_id', $admin->business_id)->where('email', $admin->email)->where('imei_no', $imei)->update([
//                 'business_id' => $admin->business_id,
//                 'email' => $email,
//                 'imei_no' => $imei,
//                 'ip_address' => $ip,
//                 'notification_token' => $Notification,
//                 'log_active' => $log_active,
//                 'log_deactive' => 0
//             ]);
//         } else {
//             $load = DB::table('login_token_admin')->insert(
//                 [
//                     'business_id' => $admin->business_id,
//                     'email' => $email,
//                     'imei_no' => $imei,
//                     'ip_address' => $ip,
//                     'notification_token' => $Notification,
//                     'log_active' => $log_active,
//                     'log_deactive' => 0
//                 ]
//             );
//         }


//         if (Carbon::now()->lt($expirationTime)) {
//             if ($admin->otp === $otp) {

//                 // $data = $admin->createToken("API TOKEN")->plainTextToken;
//                 $token = $admin->createToken('API Token');

//                 // Reset the OTP and its creation time to null
//                 $updateAdmin = LoginAdmin::where('email', $email)->update([
//                     'otp' => null,
//                     'otp_created_at' => null,
//                     'is_verified' => 1,
//                     'api_token' => $token->plainTextToken
//                 ]);
//                 if (isset($updateAdmin)) {

//                     $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $email)->first();
//                     $infoBusinessDetails = BusinessDetailsList::join('login_admin', 'business_details_list.business_id', '=', 'login_admin.business_id')->join('static_login_type_selected', 'business_details_list.login_type', '=', 'static_login_type_selected.id')->join('static_business_categories_list', 'business_details_list.business_categories', '=', 'static_business_categories_list.id')->join('static_business_type_list', 'business_details_list.business_type', '=', 'static_business_type_list.id')->where('business_details_list.business_id', $verifyOtp->business_id)->where('business_details_list.business_email', $email)->select('static_login_type_selected.login_type as login_type_name', 'static_business_categories_list.name  as business_categories_name', 'static_business_type_list.name as business_type_name', 'business_details_list.*', 'login_admin.api_token', 'login_admin.is_verified')->first();
//                     // $mergedData = json_encode([
//                     //     'owner' => $infoBusinessDetails,
//                     //     'admin' => $mainloodLoad2
//                     // ]);
//                     // if ($mainloodLoad2) {
//                     //     DB::table('login_admin')->where('business_id', $businessId1)->where('email', Session::get('email'))->update(['is_verified' => 1]);
//                     //     Session::put('user_type', 'admin');
//                     //     Session::put('business_id', $businessId1);
//                     //     Session::put('branch_id', $branchId1);
//                     //     Session::put('login_emp_id', $mainloodLoad2->emp_id);
//                     //     Session::put('login_role', $mainloodLoad2->role_id); //role table role id link model_has_role
//                     //     Session::put('login_name', $mainloodLoad2->emp_name);
//                     //     Session::put('login_email', $mainloodLoad2->emp_email);
//                     //     Session::put('login_business_image', $infoBusinessDetails->business_logo);

//                     // dd($mergedData);
//                     // return ReturnHelpers::jsonApiReturn($verifyOtp);
//                     //  return ReturnHelpers::jsonApiReturn([$verifyOtp,'token_type' =>'Bearer']);
//                     // if (isset($cameraMode)) {
//                     //         return ReturnHelpers::jsonApiReturn([$verifyOtp, CameraPermission::collection([CameraPermissionModel::find($cameraMode->id)])->all()]);
//                     // } else {

//                     // }
//                     // $formattedData = LoginSuperAdminResources::collection($infoBusinessDetails);

//                     // return response()->json([
//                     //     'login_type' => [
//                     //         'owner' => LoginSuperAdminResources::collection([$infoBusinessDetails])->all(),
//                     //         'admin' => LoginAdminResources::collection([$mainloodLoad2])->all()
//                     //     ]
//                     // ]);
//                     return ReturnHelpers::jsonApiReturn([
//                         'owner' => LoginSuperAdminResources::collection([$infoBusinessDetails])->all(),
//                     ]);
//                     // return response()->json(["result" => LoginSuperAdminResources::collection($infoBusinessDetails)]);
//                 }

//                 // return $admin;
//                 //  return AdminLoginResource::collection([LoginAdmin::where('business_id ',$admin->business_id)->first()]);
//             } else {
//                 return response()->json(['result' => ['Admin_login => Incorrect OTP.'], 'status' => false], 401);
//                 // ['Admin_login' => 'Incorrect OTP']
//             }
//         } else {
//             return response()->json(['result' => ['Admin_login => OTP has expired.'], 'status' => false], 401);
//         }
//     } else {
//         return response()->json(['result' => ['Admin_login => Invalid OTP.'], 'status' => false], 401);
//     }
//     return response()->json(['result' => [], 'status' => false], 401);
// }
