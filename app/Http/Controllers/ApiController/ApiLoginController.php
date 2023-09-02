<?php

namespace App\Http\Controllers\ApiController;
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
use App\Models\admin\LoginAdmin;
use App\Helpers\ReturnHelpers;  
use App\Http\Resources\Api\AdminLoginResource;
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
                    'otp_created_at' => Carbon::now(), // Store the OTP creation time
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
        return true;
        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(5);
            
            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $request->otp) {
                    // Reset the OTP and its creation time to null
                 $updateAdmin=   LoginAdmin::where('email', $request->email)->update([
                        'otp' => null,
                        'otp_created_at' => null,
                        'is_verified' => 1
                    ]);
                    if(isset($updateAdmin)){

                        $verifyOtp=[LoginAdmin::where('business_id',$admin->business_id)->first()];
                        $admin->token = $admin->createToken("API TOKEN")->plainTextToken;
                        return ReturnHelpers::jsonApiReturn($verifyOtp);
                    }
                    
                    // return $admin;
                     return AdminLoginResource::collection([LoginAdmin::where('business_id ',$admin->business_id)->first()]);
                } else {
                    return response()->json(['Admin_login' => 'Incorrect OTP']);
                }
            } else {
                return response()->json(['Admin_login' => 'OTP has expired.']);
            }
        } else {
            return response()->json(['Admin_login' => 'Invalid OTP']);
        }
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

    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
