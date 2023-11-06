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
use App\Models\employee\EmployeePersonalDetail;
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
        $admin = LoginAdmin::where('email', $request->email)->first();
        // return true;
        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(10);

            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $request->otp) {

                    // $data = $admin->createToken("API TOKEN")->plainTextToken;
                    $token = $admin->createToken('API Token');

                    // Reset the OTP and its creation time to null
                    $updateAdmin = LoginAdmin::where('email', $request->email)->update([
                        'otp' => null,
                        'otp_created_at' => null,
                        'is_verified' => 1,
                        'api_token' => $token->plainTextToken,
                    ]);
                    if (isset($updateAdmin)) {

                        $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $admin->email)->first();

                        // return ReturnHelpers::jsonApiReturn($verifyOtp);
                        //  return ReturnHelpers::jsonApiReturn([$verifyOtp,'token_type' =>'Bearer']);
                        // if (isset($cameraMode)) {
                        //         return ReturnHelpers::jsonApiReturn([$verifyOtp, CameraPermission::collection([CameraPermissionModel::find($cameraMode->id)])->all()]);
                        // } else {
                        return ReturnHelpers::jsonApiReturn([$verifyOtp]);
                        // }
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
            return response()->json(CameraPermission::collection(['result' => CameraPermissionModel::find($checked->id)])->all(),200);
            // return response()->json(['result' => $checked, 'status' => true], 200);
        } else {

            return response()->json(['result' => [], 'status' => false], 401);
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
