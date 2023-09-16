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
use App\Models\admin\CameraPermissionModel;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AdminLoginResource;
use App\Http\Resources\Api\CameraPermission;
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
        // return true;
        if ($admin) {
            $otpCreationTime = Carbon::parse($admin->otp_created_at);
            $expirationTime = $otpCreationTime->addMinutes(10);

            if (Carbon::now()->lt($expirationTime)) {
                if ($admin->otp === $request->otp) {

                    $data = $admin->createToken("API TOKEN")->plainTextToken;
                    // Reset the OTP and its creation time to null
                    $updateAdmin = LoginAdmin::where('email', $request->email)->update([
                        'otp' => null,
                        'otp_created_at' => null,
                        'is_verified' => 1,
                        'api_token' => $data,
                    ]);
                    if (isset($updateAdmin)) {

                        $verifyOtp = LoginAdmin::where('business_id', $admin->business_id)->where('email', $admin->email)->first();
                        $cameraMode = CameraPermissionModel::where('business_id', $admin->business_id)->first();

                        // return ReturnHelpers::jsonApiReturn($verifyOtp);
                        //  return ReturnHelpers::jsonApiReturn([$verifyOtp,'token_type' =>'Bearer']);
                        if (isset($cameraMode)) {
                            return ReturnHelpers::jsonApiReturn([$verifyOtp, CameraPermission::collection([CameraPermissionModel::find($cameraMode->id)])->all()]);
                        } else {
                            return ReturnHelpers::jsonApiReturn([$verifyOtp]);
                        }
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

    public function branchList($request)
    {
        return ApiResponse::allBranch($request);
    }
    public function departmentList($request)
    {
        return ApiResponse::branchtoallDepartment($request);
    }

    public function employeeList(Request $request)
    {
        $query = EmployeePersonalDetail::query();

        if (isset($request->branch_id)) {
            $query->where('branch_id', $request->branch_id);
        }

        if (isset($request->department_id)) {
            $query->where('department_id', $request->department_id);
        }

        if (isset($request->business_id)) {
            $query->where('business_id', $request->business_id);
        }

        $emp = $query->get();

        if ($emp->isEmpty()) {
            return response()->json(['success' => false, 'msg' => 'No employees found'], 401);
        }

        return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($emp));
    }
    public function attendence(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required',
            'business_id' => 'required',
            'branch_id' => 'required',
            'mode' => 'required', // Assuming mode is an integer
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Check if mode is 1 (in Office with QRScanner)
        if ($request->mode == 1) {
            // Get today's date once
            $today = now()->toDateString();

            // Find the latest attendance record for today by the same employee
            $latestRecord = DB::table('attendance_list')
                ->where('emp_id', $request->input('emp_id'))
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->first();
            
               $empInfo= DB::table('employee_personal_details')->where('emp_id',$request->input('emp_id'))->first();
            if (!$latestRecord) {
                // If no record exists for today, it's the first action of the day, so mark punch_in
                $attendanceData = [
                    'emp_id' => $request->input('emp_id'),
                    'emp_today_current_status' => 'punch_in',
                    'punch_in' => 1,
                    'emp_name'=>$empInfo->emp_name,
                    'business_id' => $request->business_id,
                    'branch_id' => $request->branch_id,
                    'punch_in_latitude' => $request->latitude,
                    'punch_in_longitude' => $request->longitude,
                    'punch_in_address' => $request->address,
                    'punch_in_time' => now(),
                    'working_from_mode' => 'Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('attendance_list')->insert($attendanceData);
                return response()->json(['message' => 'Punch-in marked successfully', 'punchIn' => '1'], 200);
            } else {
                if ($latestRecord->emp_today_current_status === 'punch_in') {
                    // If the latest action was punch_in, mark punch_out and calculate working hours
                    $punchInTime = Carbon::parse($latestRecord->punch_in_time);
                    $punchOutTime = now();

                    // Calculate the difference in minutes and then convert it to decimal hours
                    $minutesDifference = $punchInTime->diffInMinutes($punchOutTime);
                    $workingHours = round($minutesDifference / 60, 2); // Convert minutes to decimal hours with 2 decimal places

                    // Update the total working hours by adding the working hours for this punch-out action
                    $totalWorkingHours = $latestRecord->total_working_hour + $workingHours;

                    DB::table('attendance_list')
                        ->where('id', $latestRecord->id)
                        ->update([
                            'emp_today_current_status' => 'punch_out',
                            'punch_out' => 1,
                            'punch_out_latitude' => $request->latitude,
                            'punch_out_longitude' => $request->longitude,
                            'punch_out_address' => $request->address,
                            'working_from_mode' => 'Office',
                            'punch_out_time' => $punchOutTime,
                            'total_working_hour' => $totalWorkingHours,
                            'updated_at' => now(),
                        ]);
                    // Update the total working hours

                    return response()->json(['message' => 'Punch-out marked successfully', 'punchOut' => '1'], 200);
                } else {
                    // If the latest action was punch_out or the same action is repeated, return an error
                    $todays_punched_done = DB::table('attendance_list')->where('emp_id', $request->emp_id)->where('created_at', now())->first();

                    // if (isset($todays_punched_done)) {

                    // }
                    return response()->json(['message' => 'Todays Punching Complete', 'complete' => 1], 200);

                    // return response()->json(['message' => 'Invalid action sequence'], 400);
                }
            }
        } else {
            // If mode is not 1, return an error
            return response()->json(['message' => 'Invalid mode'], 400);
        }
    }
    // name of Business
    public function nameBusiness(Request $request)
    {
        $value = DB::table('business_details_list')->where('business_id', $request->business_id)->first();
        return response()->json(["result" => $value]);
    }
    public function nameBrand(Request $request)
    {
        $value = DB::table('brand_list')->where('brand_id', $request->brand_id)->first();
        return response()->json(["result" => $value]);
    }
    public function nameTotalBrand(Request $request)
    {
        $value = DB::table('brand_list')->where('business_id', $request->business_id)->get();
        return response()->json(["result" => $value]);
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
