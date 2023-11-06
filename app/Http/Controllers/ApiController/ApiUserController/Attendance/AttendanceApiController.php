<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceList;
use App\Models\PolicyAttendanceMode;
use App\Models\EmployeePersonalDetail;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\AttendenceResources;
use App\Http\Resources\Api\EmployeeLoginResource;
// use App\Models\employee\EmployeePersonalDetail;
use Carbon\Carbon;
use DB;
use App\Http\Resources\Api\UserSideResponse\TodayStatusAttendanceResource;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceResources;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceIdToDataResources;

class AttendanceApiController extends Controller
{
    // public function index()
    // {
    //     $data = AttendanceList::all();
    //     if ($data) {
    //         return ReturnHelpers::jsonApiReturn(AttendenceResources::collection($data)->all());
    //     }
    //     return response()->json(['result' => [], 'status' => false]);
    // }
    // ByDefault Attendace show and select month
    public function attendanceDetail(Request $request)
    {
        $emp = $request->emp_id;
        $business = $request->business_id;
        // SELECT DATE
        $selectDate = $request->selectDate ? Carbon::parse($request->selectDate) : '';
        $selectYearToCheck = $selectDate ? $selectDate->format('Y') : '';
        $selectMonthToCheck = $selectDate ? $selectDate->format('m') : '';
        // CURRENT DATE
        $currentDate = Carbon::now();
        $currentYearToCheck = $currentDate->format('Y');
        $currentMonthToCheck = $currentDate->format('m');
        if ($selectDate == '' && $emp != null && $business != null) {
            $attendanceDataExists = DB::table('attendance_list')
                ->whereYear('punch_date', $currentYearToCheck)
                ->whereMonth('punch_date', $currentMonthToCheck)
                ->where('emp_id', $emp)
                ->where('business_id', $business)
                ->get();
            if ($attendanceDataExists && count($attendanceDataExists) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($attendanceDataExists)->all(), '1');
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 200);
            }
        } elseif (isset($selectDate) && $emp != null && $business != null) {
            $attendanceDataExists = DB::table('attendance_list')
                ->where('emp_id', $emp)
                ->where('business_id', $business)
                ->whereYear('punch_date', $selectYearToCheck)
                ->whereMonth('punch_date', $selectMonthToCheck)
                ->get();
            if ($attendanceDataExists && count($attendanceDataExists) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($attendanceDataExists)->all(), '2');
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 200);
            }
        } else {
            return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 3, 'status' => true], 404);
        }
    }

    // select particular record 
    public function filterAttenDetail(Request $request)
    {
        $id = $request->id;
        $emp = $request->emp_id;
        $business = $request->business_id;
        if ($id != null && $emp != null && $business != null && $id != '' && $emp != '' && $business != '') {
            $checkingData = DB::table('attendance_list')
                ->where('id', $id)
                ->where('business_id', $business)
                ->where('emp_id', $emp)
                ->get();
            if (isset($checkingData) && count($checkingData) != 0) {
                return ReturnHelpers::jsonApiReturnSecond(UserAttendanceIdToDataResources::collection($checkingData)->all(), 1);
            } else {
                return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 2, 'status' => true], 200);
            }
        }
        return response()->json(['result' => ['value' => 'Data is not found'], 'case' => 2, 'status' => true], 404);
    }

    public function store(Request $request)
    {
        // return true;
        $emp = EmployeePersonalDetail::where('emp_id', $request->emp_id)->first();
        if ($emp) {
            $data = new AttendanceList();
            if ($request->image) {
                $validatedData = $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    // Adjust max size as needed
                ]);
                // Get the uploaded image file
                $image = $request->file('image');
                $path = public_path('upload_image/');
                $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
                // $imageName = date('d-m-Y h:i:sa') . '_' . md5($image) . '.' . $request->image->extension();
                $request->image->move($path, $imageName);
                $data->punch_in_selfie = $imageName;

                // $image  = new Image();
                // $image->name = $imageName;
                // $image->save();

                // // Return a response with information about the uploaded image
                // return response()->json([
                //     'message' => 'Image uploaded successfully.',
                //     'image_path' => $imageName,
                // ]);
            }
            // else {
            //     return response()->json(['result' => [], 'status' => false], 404);
            // }

            $data->working_from_method = $emp->emp_attendance_method;
            $data->emp_id = $request->emp_id;
            $data->business_id = $emp->business_id;
            $data->branch_id = $emp->branch_id;
            $data->attendance_status = 1; //$request->attendace_status;
            $data->emp_today_current_status = 0; /// $request->emp_today_current_status;
            $data->punch_in_time = $request->punch_in_time;
            $data->active_selfie_mode = $request->punch_mode;
            $data->punch_in_address = $request->punch_in_address;
            $data->punch_in_latitude = $request->punch_in_latitude;
            $data->punch_in_longitude = $request->punch_in_longitude;
            $data->punch_out_selfie = $request->punch_out_selfie;
            $data->punch_out_time = $request->punch_out_time;
            $data->punch_out_address = $request->punch_out_address;
            $data->punch_out_latitude = $request->punch_out_latitude;
            $data->punch_out_longitude = $request->punch_out_longitude;
            $data->total_working_hour = $request->total_working_hour;
            $data->punch_date = now('Asia/Kolkata');

            if ($data->save()) {
                // return $data;

                return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($data->id)])->all());

                // return ReturnHelpers::jsonApiReturn(AttendenceResources::collection(AttendanceList::where('emp_id',$data->id )->get()));
            }
            return response()->json(['result' => [], 'status' => false]);
        }
        return response()->json(['result' => [], 'status' => false], 404);
    }

    // Todays Status
    public function currentAttendanceStatus(Request $request)
    {
        $getDay = RulesManagement::TodayStatus()[0]; //current Day;
        $formattedDate = date('Y-m-d', strtotime($getDay));

        $emp = $request->emp_id;
        $business = $request->business_id;
        $Today = $formattedDate;

        $load = AttendanceList::where('business_id', $business)->where('emp_id', $emp)->where('punch_date', $Today)->first(); //use by static data

        if (isset($load)) {
            // return $load;
            return ReturnHelpers::jsonApiReturn(TodayStatusAttendanceResource::collection([AttendanceList::find($load->id)])->all());
        } else {

            return response()->json(['result' => [], 'status' => false], 404);
        }
    }


    //CREATED CODE BY JAYANT (Attendance Handling)
    public function storeAttendance(Request $request) //remaining on faceID and location-tabs
    {
        // initialize
        $currentMethodAuto = 0;
        $currentMethodManual = 0;

        // sensitive
        $emp = $request->emp_id;
        $business = $request->business_id;
        //methods
        $methodAccept = $request->method_layer; //1-Office 2-Outdoor 3-Remote
        // mode
        $qrCode = $request->active_qr_mode; //Active Starter Created Attendance  Layer like 1-Office{qrmode} and Second{selfie} 
        $selfie = $request->active_selfie_mode;
        //other crede. gate_working_loaded_MODE
        $markedInOutMode = $request->marked_mode; //static_attendance_mode_response use by table //Marked like : MarkedIn : MarkedOut -> 1 QrCode , 2 FaceID , 3 Selfie 

        // punchIn
        $punchInTime = $request->punch_in_time;
        $punchInLatitude = $request->punch_in_latitude;
        $punchInLongitude = $request->punch_in_longitude;
        $punchInAddress = $request->punch_in_address;

        // punchOut
        $punchOutTime = $request->punch_out_time;
        $punchOutLatitude = $request->punch_out_latitude;
        $punchOutLongitude = $request->punch_out_longitude;
        $punchOutAddress = $request->punch_out_address;

        //checking QR auto - manual  Automatic Set values BY AttendanceMode
        $checkingModes =PolicyAttendanceMode::where('business_id', $business)
            ->where(function ($query) {
                $query->where('office_auto', 1)->orWhere('office_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);
            })
            ->select('office_auto', 'office_manual')
            ->first();

        if (isset($checkingModes)) {
            $currentMethodAuto = $checkingModes->office_auto;
            $currentMethodManual = $checkingModes->office_manual;
        }
        // Rules
        $getDay = RulesManagement::TodayStatus()[0]; //current Day;
        $formattedDate = date('Y-m-d', strtotime($getDay));
        $punchDate = $formattedDate;

        $information = EmployeePersonalDetail::where('business_id', $business)->where('emp_id', $emp)->first(); //findOut Employee Details
        $policyGetShiftPerDay = DB::table('employee_personal_details')
            ->join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->where('employee_personal_details.emp_id', $emp) //check emp_id
            ->where('employee_personal_details.business_id', $business) //check business_id
            ->select('static_attendance_shift_type.id as emp_shift_type')
            ->first(); //get empolyee shift type assigned
        $ShiftTypeID = $policyGetShiftPerDay->emp_shift_type;
        // Rotational Shift Items
        $RotationalShift = $information->emp_rotational_shift_type_item;

        // ShiftAttendanceChecking Cell
        $DATA = EmployeePersonalDetail::join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->join('policy_attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))') //End-Games method array index values checking
            ->where('policy_master_endgame_method.method_switch', 1) //end game method on also
            ->where('policy_attendance_shift_type_items.is_active', 1) //scheduler task shift is active check
            ->where('employee_personal_details.emp_id', $emp) //check emp_id
            ->where('employee_personal_details.business_id', $business) //check business_id
            ->where(function ($query) use ($RotationalShift, $ShiftTypeID) {
                // only rotational case special
                if ($ShiftTypeID == 2 && $RotationalShift != 0) {
                    $query->where('policy_attendance_shift_type_items.id', $RotationalShift);
                }
            })
            ->select(
                'policy_master_endgame_method.id as method_id',
                'policy_master_endgame_method.method_name as method_name',
                'policy_attendance_shift_type_items.id as shift_item_id',
                'policy_attendance_shift_type_items.shift_name as shift_template_name',
                'static_attendance_shift_type.id  as shift_type_id',
                'static_attendance_shift_type.name as shift_type_name',
                'policy_attendance_shift_type_items.shift_start as shift_start_time',
                'policy_attendance_shift_type_items.shift_end as shift_end_time',
                'policy_attendance_shift_type_items.shift_hr as shift_hour',
                'policy_attendance_shift_type_items.shift_min as shift_min',
                'policy_attendance_shift_type_items.work_hr as working_hour',
                'policy_attendance_shift_type_items.work_min as working_min',
                'policy_attendance_shift_type_items.break_min as break_min',
                'policy_attendance_shift_type_items.is_paid as is_paid'
            )
            ->first();
        // dd($DATA);

        if (isset($DATA)) {
            $startTime = strtotime($DATA->shift_start_time);
            $endTime = strtotime($DATA->shift_end_time);
            $checkInTime = strtotime($punchInTime);
            $checkOutTime = strtotime($punchOutTime);
            $before15min = 10 * 60; // Convert 15 minutes to seconds

            // Define the extended start and end times by adding/subtracting 15 minutes
            $extendedStartTime = $startTime - $before15min;
            $extendedEndTime = $endTime + $before15min;

            //shiftCollections
            $ShiftItemID = $DATA->shift_item_id;

            if (
                ($checkInTime >= $extendedStartTime && $checkOutTime <= $extendedEndTime) //checkin overall shift active and which shift checking , get details or shift get id in shift item
            ) {
                $minutes = date('i', $checkInTime);

                // Print the minutes
                // echo "Minutes: " . $minutes;
                // print_r("\n Times are within the specified range or within 10 minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));
                // print_r("\n Times are within the specified range or within 10 minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkOutTime));

                // Office Method
                if (isset($information)) {

                    // QR-Mode by Method hold on method case of remote other working
                    if ($emp != null && $business != null && $qrCode == 1 && $markedInOutMode != null) {

                        $check = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 1)->first();
                        if (isset($check)) {
                            if ($methodAccept != null && $punchOutTime != null && $punchOutAddress != null && $punchOutLongitude != null && $punchOutLatitude != null) {

                                $punchInTimes = strtotime($check->punch_in_time);
                                $punchOutTimes = strtotime($punchOutTime);
                                $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                                $totalWorkingTimestamp = strtotime("midnight") + $totalWorkingSeconds;

                                $totalWorking = date("H:i:s", $totalWorkingTimestamp);

                                //punch-out-confirm
                                $updateDATA = [
                                    'emp_id' => $emp,
                                    'business_id' => $business,
                                    'branch_id' => $information->branch_id,
                                    'working_from_method' => $methodAccept,
                                    'method_auto' => $currentMethodAuto,
                                    'method_manual' => $currentMethodManual,
                                    'emp_today_current_status' => 2,
                                    'marked_out_mode' => $markedInOutMode,
                                    'punch_date' => $punchDate,
                                    'punch_out_time' => $punchOutTime,
                                    'punch_out_address' => $punchOutAddress,
                                    'punch_out_latitude' => $punchOutLatitude,
                                    'punch_out_longitude' => $punchOutLongitude,
                                    'total_working_hour' => $totalWorking
                                ];
                                $loaded = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 1)->update($updateDATA);

                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked PunchOut Successfully Attendance', 'case' => 2], 'status' => true], 200);
                            } else {
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                            }
                        } else {
                            if ($methodAccept != null && $punchInTime != null && $punchInTime != null && $punchInAddress != null && $punchInLatitude != null && $punchInLongitude != null) {

                                $insertChecking = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 2)->first();
                                if (!isset($insertChecking)) {
                                    $collection = new AttendanceList();
                                    $collection->emp_id = $emp;
                                    $collection->business_id = $business;
                                    $collection->branch_id = $information->branch_id;
                                    $collection->working_from_method = $methodAccept;
                                    $collection->method_auto = $currentMethodAuto; //current case on checking and value set
                                    $collection->method_manual = $currentMethodManual;
                                    $collection->attendance_status = 0; //QRCode-punchIn BY Manual ways
                                    $collection->emp_today_current_status = 1; //punch-in-confirm
                                    $collection->marked_in_mode = $markedInOutMode; //static_attendance_mode_response use by table
                                    $collection->active_qr_mode = 1; //subject mode setting
                                    $collection->attendance_shift = $ShiftItemID;
                                    $collection->punch_date = $punchDate; //anytime current upload DAY
                                    $collection->punch_in_time = $punchInTime;
                                    $collection->punch_in_latitude = $punchInLatitude;
                                    $collection->punch_in_longitude = $punchInLongitude;
                                    $collection->punch_in_address = $punchInAddress;
                                    $collection->save();
                                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked PunchIn Successfully Attendance', 'case' => 1], 'status' => true], 200);
                                }
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Today QR-Code Marked Completed', 'case' => 4], 'status' => true], 200);
                            } else {
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                            }
                        }
                    }
                    // Selfie Office Mode
                    if ($emp != null && $business != null && $selfie == 1 && $markedInOutMode != null) {


                        $validatedData = $request->validate([
                            'image' => 'required|image|mimes:jpeg,png,jpg',
                            // Adjust max size as needed
                        ]);
                        // Get the uploaded image file
                        $image = $request->file('image');
                        $path = public_path('upload_image/');
                        $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
                        $request->image->move($path, $imageName);
                        // $data->punch_in_selfie = $imageName;
                        $check = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 1)->first();

                        if (isset($check)) {
                            if ($methodAccept != null && $imageName != null && $punchOutTime != null && $punchOutAddress != null && $punchOutLongitude != null && $punchOutLatitude != null) {

                                $punchInTimes = strtotime($check->punch_in_time);
                                $punchOutTimes = strtotime($punchOutTime);
                                $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                                $totalWorkingTimestamp = strtotime("midnight") + $totalWorkingSeconds;

                                $totalWorking = date("H:i:s", $totalWorkingTimestamp);

                                //punch-out-confirm
                                //static_attendance_mode_response use by table
                                $updateDATA = [
                                    'emp_id' => $emp,
                                    'business_id' => $business,
                                    'branch_id' => $information->branch_id,
                                    'working_from_method' => $methodAccept,
                                    'method_auto' => $currentMethodAuto,
                                    'method_manual' => $currentMethodManual,
                                    'emp_today_current_status' => 2,
                                    'marked_out_mode' => $markedInOutMode,
                                    'punch_date' => $punchDate,
                                    'punch_out_selfie' => $imageName,
                                    'punch_out_time' => $punchOutTime,
                                    'punch_out_address' => $punchOutAddress,
                                    'punch_out_latitude' => $punchOutLatitude,
                                    'punch_out_longitude' => $punchOutLongitude,
                                    'total_working_hour' => $totalWorking,

                                ];
                                $loaded = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 1)->update($updateDATA);

                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked PunchOut Successfully Attendance', 'case' => 2], 'status' => true], 200);
                            }
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked Already PunchOut Successfully', 'case' => 3], 'status' => true], 200);
                        } else {
                            if ($methodAccept != null && $imageName != null && $punchInTime != null && $punchInAddress != null && $punchInLatitude != null && $punchInLongitude != null) {

                                $insertChecking = AttendanceList::where('punch_date', $formattedDate)->where('emp_id', $emp)->where('emp_today_current_status', 2)->first();
                                if (!isset($insertChecking)) {
                                    $collection = new AttendanceList();
                                    $collection->emp_id = $emp;
                                    $collection->business_id = $business;
                                    $collection->branch_id = $information->branch_id;
                                    $collection->working_from_method = $methodAccept;
                                    $collection->method_auto = $currentMethodAuto; //current case on checking and value set
                                    $collection->method_manual = $currentMethodManual;
                                    $collection->attendance_status = 0; //QRCode-punchIn BY Manual ways
                                    $collection->emp_today_current_status = 1; //punch-in-confirm
                                    $collection->marked_in_mode = $markedInOutMode; //static_attendance_mode_response use by table
                                    $collection->active_selfie_mode = 1;
                                    $collection->attendance_shift = $ShiftItemID;
                                    $collection->punch_date = $punchDate; //anytime current upload DAY
                                    $collection->punch_in_selfie = $imageName; //subject mode setting
                                    $collection->punch_in_time = $punchInTime;
                                    $collection->punch_in_latitude = $punchInLatitude;
                                    $collection->punch_in_longitude = $punchInLongitude;
                                    $collection->punch_in_address = $punchInAddress;
                                    $collection->save();
                                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked PunchIn Successfully Attendance', 'case' => 1], 'status' => true], 200);
                                }
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Today Selfie Marked Completed', 'case' => 4], 'status' => true], 200);
                            } else {

                                return response()->json(['result' => ['value' => 'Selfie Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                            }
                        }
                    } else {
                        return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'galat hy ayhhh.. golu achay karrr....', 'case' => 5], 'status' => true], 404);
                    }
                }
                // return response()->json(['result' => ['value' => 'Your Shift 10 min is PunchIn', 'case' => 8], 'status' => true], 200);
            } else {
                // print_r("\n Times are Not within the specified range or within 10 minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));
                // print_r("\n Times are Not within the specified range or within 10 minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkInTime));
                // print_r("\n Times are Not Shift validated");

                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Shift Not Started', 'case' => 9], 'status' => true], 200);
            }
            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Your Shift is Activated', 'case' => 7], 'status' => true], 200);
        } else {

            return response()->json(['result' => ['message' => 'Your Shift is Not Activated', 'case' => 6], 'status' => true], 404);
        }
    }

    public function storey(Request $request)
    {
        $attend = new AttendanceList();
        $attend->business_id = $request->business_id;
        $attend->branch_id = $request->branch_id;
        // $attend->department_id = $request->department_id;
        $attend->emp_id = $request->emp_id;
        $attend->emp_name = $request->emp_name;
        // $attend->emp_status = $request->emp_status;
        $attend->punch_in_time = $request->punch_in_time;
        $attend->punch_in_address = $request->punch_in_address;
        $attend->punch_in_latitude = $request->punch_in_latitude;
        $attend->punch_in_longitude = $request->punch_in_longitude;
        // $attend->punch_in_image = $request->punch_in_image;
        // $attend->punch_out = $request->punch_out;
        // $attend->punch_out_address = $request->punch_out_address;
        // $attend->punch_out_latitude = $request->punch_out_latitude;
        // $attend->punch_out_longitude = $request->punch_out_longitude;
        // $attend->punch_out_image = $request->punch_out_image;
        // $attend->working_hour = $request->working_hour;
        // $attend->location_ip = $request->location_ip;
        // $attend->working_from = $request->working_from;
        if ($attend->save()) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($attend->id)])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function show($id)
    {
        $empData = DB::table('employee_personal_details')->where('emp_id', $id)->first();
        if ($empData) {
            $attendData = AttendanceList::where('emp_id', $id)->orderBy('id', 'desc')
                ->get();
            return ReturnHelpers::jsonApiReturn(UserAttendanceResources::collection($attendData)->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    public function update(Request $request, $emp_id)
    {
        $attend = AttendanceList::where('emp_id', $emp_id)->first();
        // return $attend;
        // $attend->business_id = $request->business_id ?? $attend->business_id;
        $attend->branch_id = $request->branch_id ?? $attend->branch_id;
        $attend->department_id = $request->department_id ?? $attend->department_id;
        $attend->emp_id = $request->emp_id ?? $attend->emp_id;
        $attend->emp_name = $request->emp_name ?? $attend->emp_name;
        $attend->emp_status = $request->emp_status ?? $attend->emp_status;
        $attend->punch_in_time = $request->punch_in_time ?? $attend->punch_in_time;
        $attend->punch_in_address = $request->punch_in_address ?? $attend->punch_in_address;
        $attend->punch_in_latitude = $request->punch_in_latitude ?? $attend->punch_in_latitude;
        $attend->punch_in_longitude = $request->punch_in_longitude ?? $attend->punch_in_longitude;
        $attend->punch_in_image = $request->punch_in_image ?? $attend->punch_in_image;
        $attend->punch_out_time = $request->punch_out ?? $attend->punch_out_time;
        $attend->punch_out_address = $request->punch_out_address ?? $attend->punch_out_address;
        $attend->punch_out_latitude = $request->punch_out_latitude ?? $attend->punch_out_latitude;
        $attend->punch_out_longitude = $request->punch_out_longitude ?? $attend->punch_out_longitude;
        $attend->punch_out_image = $request->punch_out_image ?? $attend->punch_out_image;
        $attend->working_hour = $request->working_hour ?? $attend->working_hour;
        $attend->working_from = $request->working_from ?? $attend->working_from;
        if ($attend->save()) {
            return ReturnHelpers::jsonApiReturn(AttendenceResources::collection([AttendanceList::find($attend->id)])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function destroy($emp_id)
    {
        $attend = AttendanceList::where('emp_id', $emp_id)->first();

        if ($attend) {
            $attend->delete();
            return response()->json(['result' => true, 'status' => true, 'msg' => 'Delete Successfully!']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
