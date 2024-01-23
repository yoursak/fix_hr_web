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

            // $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

            if (true) {
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

                        $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $email)->first();
                        $infoBusinessDetails = BusinessDetailsList::join('login_admin', 'business_details_list.business_id', '=', 'login_admin.business_id')->join('static_login_type_selected', 'business_details_list.login_type', '=', 'static_login_type_selected.id')->join('static_business_categories_list', 'business_details_list.business_categories', '=', 'static_business_categories_list.id')->join('static_business_type_list', 'business_details_list.business_type', '=', 'static_business_type_list.id')->where('business_details_list.business_id', $verifyOtp->business_id)->where('business_details_list.business_email', $email)->select('static_login_type_selected.login_type as login_type_name', 'static_business_categories_list.name  as business_categories_name', 'static_business_type_list.name as business_type_name', 'business_details_list.*', 'login_admin.api_token', 'login_admin.is_verified')->first();
                        // $mergedData = json_encode([
                        //     'owner' => $infoBusinessDetails,
                        //     'admin' => $mainloodLoad2
                        // ]);
                        // if ($mainloodLoad2) {
                        //     DB::table('login_admin')->where('business_id', $businessId1)->where('email', Session::get('email'))->update(['is_verified' => 1]);
                        //     Session::put('user_type', 'admin');
                        //     Session::put('business_id', $businessId1);
                        //     Session::put('branch_id', $branchId1);
                        //     Session::put('login_emp_id', $mainloodLoad2->emp_id);
                        //     Session::put('login_role', $mainloodLoad2->role_id); //role table role id link model_has_role
                        //     Session::put('login_name', $mainloodLoad2->emp_name);
                        //     Session::put('login_email', $mainloodLoad2->emp_email);
                        //     Session::put('login_business_image', $infoBusinessDetails->business_logo);

                        // dd($mergedData);
                        // return ReturnHelpers::jsonApiReturn($verifyOtp);
                        //  return ReturnHelpers::jsonApiReturn([$verifyOtp,'token_type' =>'Bearer']);
                        // if (isset($cameraMode)) {
                        //         return ReturnHelpers::jsonApiReturn([$verifyOtp, CameraPermission::collection([CameraPermissionModel::find($cameraMode->id)])->all()]);
                        // } else {

                        // }
                        // $formattedData = LoginSuperAdminResources::collection($infoBusinessDetails);

                        // return response()->json([
                        //     'login_type' => [
                        //         'owner' => LoginSuperAdminResources::collection([$infoBusinessDetails])->all(),
                        //         'admin' => LoginAdminResources::collection([$mainloodLoad2])->all()
                        //     ]
                        // ]);
                        return ReturnHelpers::jsonApiReturn([
                            'owner' => LoginSuperAdminResources::collection([$infoBusinessDetails])->all(),
                        ]);
                        // return response()->json(["result" => LoginSuperAdminResources::collection($infoBusinessDetails)]);
                    }

                    // return $admin;
                    //  return AdminLoginResource::collection([LoginAdmin::where('business_id ',$admin->business_id)->first()]);
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
    public function VerifiedOtpAdmin(Request $request)
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

                        $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $email)->first();
                        // $infoBusinessDetails = BusinessDetailsList::join('login_admin', 'business_details_list.business_id', '=', 'login_admin.business_id')->join('static_login_type_selected', 'business_details_list.login_type', '=', 'static_login_type_selected.id')->join('static_business_categories_list', 'business_details_list.business_categories', '=', 'static_business_categories_list.id')->join('static_business_type_list', 'business_details_list.business_type', '=', 'static_business_type_list.id')->where('business_details_list.business_id', $verifyOtp->business_id)->where('business_details_list.business_email', $email)->select('static_login_type_selected.login_type as login_type_name', 'static_business_categories_list.name  as business_categories_name', 'static_business_type_list.name as business_type_name', 'business_details_list.*', 'login_admin.api_token', 'login_admin.is_verified')->first();
                        $mainloodLoad2 = EmployeePersonalDetail::join('policy_setting_role_create', 'employee_personal_details.role_id', '=', 'policy_setting_role_create.id')
                            ->join('login_admin', 'employee_personal_details.business_id', '=', 'login_admin.business_id')
                            ->join('static_employee_join_gender_type as employeegender', 'employee_personal_details.emp_gender', '=', 'employeegender.id')
                            ->join('static_employee_join_emp_type as employeetype', 'employee_personal_details.employee_type', '=', 'employeetype.type_id')
                            ->join('policy_master_endgame_method as mem', 'employee_personal_details.master_endgame_id', '=', 'mem.id')
                            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
                            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
                            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
                            ->join('static_login_type_selected', 'employee_personal_details.is_admin', '=', 'static_login_type_selected.id')
                            ->where('employee_personal_details.business_id', $verifyOtp->business_id)->where('employee_personal_details.emp_email', $email)
                            ->select('static_login_type_selected.login_type as login_type_name', 'policy_setting_role_create.roles_name as role_name', 'employee_personal_details.*', 'employeegender.gender_type as gender', 'employeetype.emp_type as emp_type_name', 'branch_list.branch_name as branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'login_admin.api_token', 'login_admin.is_verified')->first();




                        // $mergedData = json_encode([
                        //     'owner' => $infoBusinessDetails,
                        //     'admin' => $mainloodLoad2
                        // ]);
                        // if ($mainloodLoad2) {
                        //     DB::table('login_admin')->where('business_id', $businessId1)->where('email', Session::get('email'))->update(['is_verified' => 1]);
                        //     Session::put('user_type', 'admin');
                        //     Session::put('business_id', $businessId1);
                        //     Session::put('branch_id', $branchId1);
                        //     Session::put('login_emp_id', $mainloodLoad2->emp_id);
                        //     Session::put('login_role', $mainloodLoad2->role_id); //role table role id link model_has_role
                        //     Session::put('login_name', $mainloodLoad2->emp_name);
                        //     Session::put('login_email', $mainloodLoad2->emp_email);
                        //     Session::put('login_business_image', $infoBusinessDetails->business_logo);

                        // dd($mergedData);
                        // return ReturnHelpers::jsonApiReturn($verifyOtp);
                        //  return ReturnHelpers::jsonApiReturn([$verifyOtp,'token_type' =>'Bearer']);
                        // if (isset($cameraMode)) {
                        //         return ReturnHelpers::jsonApiReturn([$verifyOtp, CameraPermission::collection([CameraPermissionModel::find($cameraMode->id)])->all()]);
                        // } else {

                        // }
                        // $formattedData = LoginSuperAdminResources::collection($infoBusinessDetails);

                        // return response()->json([
                        //     'login_type' => [
                        //         'owner' => LoginSuperAdminResources::collection([$infoBusinessDetails])->all(),
                        //         'admin' => LoginAdminResources::collection([$mainloodLoad2])->all()
                        //     ]
                        // ]);
                        return ReturnHelpers::jsonApiReturn(['admin' => LoginAdminResources::collection([$mainloodLoad2])->all()]);
                        // return response()->json(["result" => LoginSuperAdminResources::collection($infoBusinessDetails)]);
                    }

                    // return $admin;
                    //  return AdminLoginResource::collection([LoginAdmin::where('business_id ',$admin->business_id)->first()]);
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


    public function cameraPermission(Request $request)
    {
        $bID = $request->business_id;
        $ImeiNumber = $request->imei_no;

        $checked = DB::table('camera_permission')->where('business_id', $bID)->where('imei_number', $ImeiNumber)->first();
        if (isset($checked)) {
            return response()->json(CameraPermission::collection(['result' => CameraPermissionModel::find($checked->id)])->all(), 200);
            // return response()->json(['result' => $checked, 'status' => true], 200);
        } else {

            return response()->json(['result' => [], 'status' => false], 401);
        }
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
