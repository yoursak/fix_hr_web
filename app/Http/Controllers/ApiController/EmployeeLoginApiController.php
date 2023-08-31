<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMailer;
use Carbon\Carbon;

class EmployeeLoginApiController extends Controller
{
    public function login(Request $request)
    {
        $admin = DB::table('login_employee')
            ->where('email', $request->email)
            ->first();

        $otp = rand(100000, 999999); // Ensure OTP is generated as a six-digit number

        if ($admin) {
            $details = [
                'title' => 'Mail from fixingdots.com ',
                'body' => 'This is for testing Auth otp checking ' . "$otp",
            ];

            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));

            if ($sendMail) {
                $updateset = DB::table('login_employee')
                    ->where('email', $request->email)
                    ->update([
                        'otp' => $otp,
                        'otp_created_at' => Carbon::now(), // Store the OTP creation time
                    ]);

                if ($updateset) {
                    $adminroot = DB::table('login_employee')
                        ->where('email', $request->email)
                        ->first();
                    return response()->json(['Employee_login' => [$adminroot]]);
                }
            }
        }
    }

    public function VerifiedOtp(Request $request)
    {
        $admin = DB::table('login_employee')
            ->where('email', $request->email)
            ->first();

        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addSeconds(60);

            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $request->otp) {
                    // Reset the OTP and its creation time to null
                    DB::table('login_employee')
                        ->where('email', $request->email)
                        ->update([
                            'otp' => null,
                            'otp_created_at' => null,
                        ]);

                    return response()->json(['Employee_login' => $admin]);
                } else {
                    return response()->json(['Employee_login' => 'Incorrect OTP']);
                }
            } else {
                return response()->json(['Employee_login' => 'OTP has expired.']);
            }
        } else {
            return response()->json(['Employee_login' => 'Invalid OTP']);
        }
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
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