<?php

namespace App\Http\Controllers\ApiController\ApiUserController\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceList;
use App\Models\AttendanceDailyCount;
use App\Helpers\Central_unit;
use App\Models\PolicyAttendanceMode;
use App\Models\EmployeePersonalDetail;
use App\Models\AttendanceTabLocation;
use App\Helpers\ReturnHelpers;
use App\Models\PolicyAttenRuleOvertime;
use App\Http\Resources\Api\AttendenceResources;
use App\Http\Resources\Api\EmployeeLoginResource;
use App\Models\ApprovalManagementCycle;
use App\Models\AttendanceHolidayList;
// use App\Models\employee\EmployeePersonalDetail;
use Carbon\Carbon;
use App\Models\RequestLeaveList;
use DB;
use App\Http\Resources\Api\UserSideResponse\TodayStatusAttendanceResource;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceResources;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Resources\Api\UserSideResponse\AttendanceAllowModeBusiness;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceIdToDataResources;
use App\Http\Resources\Api\UserSideResponse\UserHolidayListResource;
use App\Http\Resources\Api\UserSideResponse\CurrentAttendanceRequestStatus;
use App\Http\Resources\Api\UserSideResponse\UserAttendanceLocationTabList;

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

        $load = AttendanceList::where('business_id', $business)
            ->where('emp_id', $emp)
            ->where('punch_date', $Today)
            ->first(); //use by static data

        if (isset($load)) {
            // return $load;
            return ReturnHelpers::jsonApiReturn(TodayStatusAttendanceResource::collection([AttendanceList::find($load->id)])->all());
        } else {
            return response()->json(['result' => [], 'status' => false], 404);
        }
    }

    //CREATED CODE BY JAYANT (Attendance Handling theory)
    public function storeAttendance(Request $request)
    {
        //remaining on faceID and location-tabs
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
        $locationTab = $request->active_location_tab_mode;
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

        // QR Code
        $punchInQRCode = $request->punch_in_qr_code;
        $punchOutQRCode = $request->punch_out_qr_code;

        // Tab Location values
        $LocationTabLongitude = (float) $request->location_tab_longitude ?? 0;
        $LocationTabLatitude = (float) $request->location_tab_latitude ?? 0;
        $LocationTabAddress = (string) $request->location_tab_address ?? '';

        // check approval
        $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $business)
            ->where('approval_type_id', 1)
            ->first();
        if ($approvalManagementCycle != null) {
            $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

            // Get the first index value of role_id
            $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

            // Get the last index value of role_id
            $lastRoleId = end($roleIds); // Get the last value of the array

            // $load = $approvalManagementCycle->cycle_type;
            // dd($firstRoleId, $lastRoleId);
        }
        //checking QR auto - manual  Automatic Set values BY AttendanceMode
        $checkingModes = PolicyAttendanceMode::where('business_id', $business)
            ->where(function ($query)  use ($methodAccept) {

                if ($methodAccept == 1) { //office

                    $query->where('office_auto', 1)->orWhere('office_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);
                }
                if ($methodAccept == 2) { //outdoor
                    $query->where('outdoor_auto', 1)->orWhere('outdoor_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);

                }
                if ($methodAccept == 3) //wfh
                {
                    $query->where('wfh_auto', 1)->orWhere('wfh_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);

                }
            })
            ->select('office_auto', 'office_manual', 'outdoor_auto', 'outdoor_manual', 'wfh_auto', 'wfh_manual')
            ->first();

        // PolicyAttendanceMode::where('business_id', $request->business_id)->get()
        if (isset($checkingModes)) {
            if ($methodAccept == 1) {
                $currentMethodAuto = $checkingModes->office_auto;
                $currentMethodManual = $checkingModes->office_manual;
            }
            if ($methodAccept == 2) {
                $currentMethodAuto = $checkingModes->outdoor_auto;
                $currentMethodManual = $checkingModes->outdoor_manual;
            }
            if ($methodAccept == 3) {
                $currentMethodAuto = $checkingModes->wfh_auto;
                $currentMethodManual = $checkingModes->wfh_manual;
            }
        }
        // dd($checkingModes);
        // Rules
        $getDay = RulesManagement::TodayStatus()[0]; //current Day;
        $formattedDate = date('Y-m-d', strtotime($getDay));
        $punchDate = $formattedDate;
        $count = 0;

        $information = EmployeePersonalDetail::where('business_id', $business)
            ->where('emp_id', $emp)
            ->first(); //findOut Employee Details

        // Find SetupActive By EmpID backdown invalied data stop PunchIn or PunchOut
        $setupActivateEmpID = $information->master_endgame_id;
        $setupActivateNameByAssignEmpID = DB::table('policy_master_endgame_method')
            ->where('business_id', $business)
            ->where('id', $setupActivateEmpID)
            ->where('method_switch', 1)
            ->first();

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

        // ShiftAttendanceChecking Cell Shift credentials show list
        $DATA = EmployeePersonalDetail::leftJoin('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
            ->leftJoin('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->leftJoin('policy_attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->leftJoin('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))') //End-Games method array index values checking
            ->where('policy_master_endgame_method.method_switch', 1) //end game method on also
            ->where('employee_personal_details.active_emp', 1)
            ->where('employee_personal_details.emp_id', $emp) //check emp_id
            ->where('employee_personal_details.business_id', $business) //check business_id
            ->Where(function ($query) use ($RotationalShift, $ShiftTypeID) {
                // only rotational case special
                if ($ShiftTypeID == 2 && $RotationalShift != 0) {
                    $query->where('policy_attendance_shift_type_items.id', $RotationalShift);
                }
                // $query->where('policy_attendance_shift_type_items.id', $RotationalShift)
                //     ->orWhere(function ($query) use ($ShiftTypeID, $RotationalShift) {
                //         if ($ShiftTypeID == 2 &&  $RotationalShift != 0) {
                //             $query->orwhere('policy_attendance_shift_type_items.id', $RotationalShift);
                //         }
                //     });
            })
            ->select('policy_master_endgame_method.id as method_id', 'policy_master_endgame_method.method_name as method_name', 'policy_attendance_shift_type_items.id as shift_item_id', 'policy_attendance_shift_type_items.shift_name as shift_template_name', 'static_attendance_shift_type.id  as shift_type_id', 'static_attendance_shift_type.name as shift_type_name', 'policy_attendance_shift_type_items.shift_start as shift_start_time', 'policy_attendance_shift_type_items.shift_end as shift_end_time', 'policy_attendance_shift_type_items.shift_hr as shift_hour', 'policy_attendance_shift_type_items.shift_min as shift_min', 'policy_attendance_shift_type_items.work_hr as working_hour', 'policy_attendance_shift_type_items.work_min as working_min', 'policy_attendance_shift_type_items.break_min as break_min', 'policy_attendance_shift_type_items.is_paid as is_paid')
            ->first();
        // Checking CompOff
        $AttendanceCompOff = RulesManagement::AttendaceCompOffSet($emp, $business, $punchDate);

        // ->where('policy_attendance_shift_type_items.is_active', 1) //scheduler task shift is active check automatic  disabled
        // dd($DATA);
        if (isset($DATA)) {
            // Get Pass Credentials model
            // $startTime = strtotime($DATA->shift_start_time);
            // $endTime = strtotime($DATA->shift_end_time);
            // $checkInTime = strtotime($punchInTime);
            // $checkOutTime = strtotime($punchOutTime);
            // $before15min = 10 * 60; // Convert 15 minutes to seconds
            // Define the extended start and end times by adding/subtracting 15 minutes
            // $extendedStartTime = $startTime - $before15min;
            // $extendedEndTime = $endTime + $before15min;
            // dd($punchInTime, $GetAutomaticRuleApplyByAutomation);
            // //&&
            // if (
            //     $checkInTime >= $extendedStartTime ||
            //     $checkOutTime <= $extendedEndTime //checkin overall shift active and which shift checking , get details or shift get id in shift item
            // ) {
            //     $minutes = date('i', $checkInTime);

            $startTime = strtotime($DATA->shift_start_time);
            $endTime = strtotime($DATA->shift_end_time);
            $checkInTime = strtotime($punchInTime);
            $checkOutTime = strtotime($punchOutTime);

            $checkingFinalShiftTimeMin = 0;
            // Attendance Shift Overtime checking PolicyAttenRuleOvertime
            $GetAutomaticRuleApplyByAutomation = PolicyAttenRuleOvertime::where('business_id', $business)
                ->where('switch_is', 1)
                ->first();

            if (isset($GetAutomaticRuleApplyByAutomation)) {
                $calculationModelHour = (int) $GetAutomaticRuleApplyByAutomation->early_ot_hr * 60;
                $calculationModelMin = (int) $GetAutomaticRuleApplyByAutomation->early_ot_min;
                $checkingFinalShiftTimeMin = $calculationModelHour + $calculationModelMin ?? 0; //sum minutes
            }
            $RestricGateAttenadancePunchIn = $checkingFinalShiftTimeMin != 0 ? $checkingFinalShiftTimeMin : 15;
            $beforemin = $RestricGateAttenadancePunchIn * 60; //15 * 60; // Convert 15 minutes to seconds

            // Define the extended start and end times by adding/subtracting 15 minutes
            $extendedStartTime = $startTime - $beforemin;
            $extendedEndTime = $startTime + $beforemin;

            //shiftCollections
            $ShiftItemID = $DATA->shift_item_id;

            //  && $checkInTime <= $extendedEndTime
            // Punch-in time is within the allowed range
            // echo "\n Punch-in time is within " . date('H:m:i a', $beforemin) . " minutes of shift start time.";
            // print_r("\n minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkOutTime));
            // print_r("\n minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));

            // Parallel process Segement needed addedd
            //new data shiftType of name
            $appliedShift_type_name = $DATA->shift_type_name;
            $appliedShift_template_name = $DATA->shift_template_name;
            $appliedShift_comp_start_time = $DATA->shift_start_time;
            $appliedShift_comp_end_time = $DATA->shift_end_time;
            $appliedShift_break_time = $DATA->break_min;
            $punchIn_shift_name = $DATA->shift_type_name;
            $punchOut_shift_name = $DATA->shift_type_name;

            // PUNCH-IN STORE Externals
            // $getAutomationLateEntry = DB::table('policy_atten_rule_late_entry')->where('business_id', $business)->where('switch_is', 1)->first();
            // $getAutomationOverTime = DB::table('policy_atten_rule_overtime')->where('business_id', $business)->where('switch_is', 1)->first();
            // // PUNCH-OUT STORE Externals
            // $getAutomationEarlyExit = DB::table('policy_atten_rule_early_exit')->where('business_id', $business)->where('switch_is', 1)->first();

            // $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $emp, 'punch_date' => $punchDate, 'business_id' => $business]);
            // $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
            // $Overtime=$TodayStatus[8];
            // $ShiftInterval=$TodayStatus[9];
            // $EarlyExit=$TodayStatus[13];
            // $LateBy=$TodayStatus[12];
            // dd($TodayStatus);
            // Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business);

            // Print the minutes
            // echo "Minutes: " . $minutes;
            // print_r("\n Times are within the specified range or within 10 minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));
            // print_r("\n Times are within the specified range or within 10 minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkOutTime));

            // Office Method
            if (isset($information)) {
                // QR-Mode by Method hold on method case of remote other working
                if ($emp != null && $business != null && $qrCode == 1 && $markedInOutMode == 1) {
                    $check = AttendanceList::where('punch_date', $formattedDate)
                        ->where('emp_id', $emp)
                        ->where('emp_today_current_status', 1)
                        ->first();
                    if (isset($check)) {
                        if ($methodAccept != null && $punchOutTime != null  && $punchOutQRCode != null  && $punchOutAddress != null && $punchOutLongitude != null && $punchOutLatitude != null) {
                            $punchInTimes = strtotime($check->punch_in_time);
                            $punchOutTimes = strtotime($punchOutTime);
                            $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                            $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;

                            $totalWorking = date('H:i:s', $totalWorkingTimestamp);

                            $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $emp, 'punch_date' => $punchDate, 'business_id' => $business]);
                            $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                            $Overtime = $TodayStatus[8];
                            $ShiftInterval = $TodayStatus[9];
                            $EarlyExit = $TodayStatus[13];
                            $LateBy = $TodayStatus[12];


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
                                'total_working_hour' => $totalWorking,
                                'punch_out_shift_name' => $punchOut_shift_name,
                                'punch_out_qr_code' => $punchOutQRCode,
                                'punch_out_location_tag' => ($methodAccept == 2) ? 2 : 0,
                                'final_status' => ($currentMethodAuto != 0) ? 1 : 0,
                                'process_complete' => ($currentMethodAuto != 0) ? 1 : 0,
                                'today_status' => $OverAllTodayStatus,
                                'overtime' => $Overtime,
                                'shift_interval' => $ShiftInterval,
                                'early_exit' => $EarlyExit,
                                'late_by' => $LateBy,
                            ];

                            $punchOutDateTodaysQR = AttendanceList::where('punch_date', $formattedDate)
                                ->where('emp_id', $emp)
                                ->where('emp_today_current_status', 1)
                                ->update($updateDATA);
                            Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business);
                            Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business); //error line
                            // if (isset($loaded)) {
                            //     //BUG LOop
                            //     // $updateTodaysStatus = [];
                            //     // dd($TodayStatus);
                            //     // AttendanceList::where('punch_date', $formattedDate)
                            //     //     ->where('emp_id', $emp)
                            //     //     ->update($updateTodaysStatus);

                            // }
                            if (isset($punchOutDateTodaysQR)) { //BUG Loop

                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked PunchOut Successfully Attendance', 'case' => 2], 'status' => true], 200);
                            }
                        } else {
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                        }
                    } else {
                        if ($methodAccept != null && $punchInTime != null && $punchInTime != null && $punchInQRCode != null && $punchInAddress != null && $punchInLatitude != null && $punchInLongitude != null) {
                            $insertChecking = AttendanceList::where('punch_date', $formattedDate)
                                ->where('emp_id', $emp)
                                ->where('emp_today_current_status', 2)
                                ->first();
                            if (!isset($insertChecking)) {
                                if ($checkInTime >= $extendedStartTime) {
                                    // Checking shift Time start time also PunchOnly
                                    $collection = new AttendanceList();
                                    $collection->today_status = 4;
                                    $collection->setup_method_id = $setupActivateEmpID;
                                    $collection->setup_method_name = $setupActivateNameByAssignEmpID->method_name; //endgame active method on time insert
                                    $collection->emp_id = $emp;
                                    $collection->business_id = $business;
                                    $collection->branch_id = $information->branch_id;
                                    $collection->working_from_method = $methodAccept;
                                    $collection->method_auto = $currentMethodAuto; //current case on checking and value set
                                    $collection->method_manual = $currentMethodManual;
                                    $collection->final_status = 0; //QRCode-punchIn BY Manual ways
                                    $collection->active_biometric_mode = 0;
                                    $collection->emp_today_current_status = 1; //punch-in-confirm
                                    $collection->marked_in_mode = $markedInOutMode; //static_attendance_mode_response use by table
                                    $collection->active_qr_mode = 1; //subject mode setting
                                    $collection->attendance_shift = $ShiftItemID;
                                    $collection->punch_date = $punchDate; //anytime current upload DAY
                                    $collection->punch_in_qr_code = $punchInQRCode;
                                    $collection->punch_in_time = $punchInTime;
                                    $collection->punch_in_latitude = $punchInLatitude;
                                    $collection->punch_in_longitude = $punchInLongitude;
                                    $collection->punch_in_address = $punchInAddress;
                                    $collection->punch_in_location_tag = ($methodAccept == 2) ? 1 : 0;
                                    $collection->active_location_tab_mode = ($methodAccept == 2) ? 1 : 0;
                                    $collection->applied_shift_template_name = $appliedShift_template_name; //new data shifttype of name
                                    $collection->applied_shift_type_name = $appliedShift_type_name;
                                    $collection->applied_shift_comp_start_time = $appliedShift_comp_start_time;
                                    $collection->applied_shift_comp_end_time = $appliedShift_comp_end_time;
                                    $collection->brack_time = $appliedShift_break_time;
                                    $collection->punch_in_shift_name = $punchIn_shift_name; //punchIn shift Name
                                    $collection->forward_by_role_id = $firstRoleId ?? 0;
                                    $collection->forward_by_status = 0;
                                    $collection->final_level_role_id = $lastRoleId ?? 0;
                                    $collection->final_status = 0;
                                    $collection->process_complete = 0;
                                    $collection->leave_type_category = $AttendanceCompOff[0];
                                    $collection->comp_off_active = $AttendanceCompOff[1];
                                    $collection->save();
                                    // Comp-Off Checking Upload Today checking new method
                                    RulesManagement::AttendaceCompOffSet($emp, $business, $punchDate);

                                    Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business);
                                    Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business);
                                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked PunchIn Successfully Attendance', 'case' => 1], 'status' => true], 200);
                                } else {
                                    // print_r("\n Times are Not within the specified range or within 10 minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));
                                    // print_r("\n Times are Not within the specified range or within 10 minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkInTime));
                                    // print_r("\n Times are Not Shift validated");
                                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'You Shift has Not Started', 'case' => 9], 'status' => true], 200);
                                }
                            }
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Today QR-Code Marked Completed', 'case' => 4], 'status' => true], 200);
                        } else {
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'QR-Code Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                        }
                    }
                }
                // Selfie Office Mode
                if ($emp != null && $business != null && $selfie == 1 && $markedInOutMode == 3) {
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
                    $check = AttendanceList::where('punch_date', $formattedDate)
                        ->where('emp_id', $emp)
                        ->where('emp_today_current_status', 1)
                        ->first();

                    if (isset($check)) {
                        if ($methodAccept != null && $imageName != null && $punchOutTime != null && $punchOutAddress != null && $punchOutLongitude != null && $punchOutLatitude != null) {
                            $punchInTimes = strtotime($check->punch_in_time);
                            $punchOutTimes = strtotime($punchOutTime);
                            $totalWorkingSeconds = $punchOutTimes - $punchInTimes;

                            $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;

                            $totalWorking = date('H:i:s', $totalWorkingTimestamp);


                            $TodayStatus = Central_unit::getEmpAttSummaryApi(['emp_id' => $emp, 'punch_date' => $punchDate, 'business_id' => $business]);
                            $OverAllTodayStatus = $TodayStatus[0]; //only running PunchOut time By Aman Attendance
                            $Overtime = $TodayStatus[8];
                            $ShiftInterval = $TodayStatus[9];
                            $EarlyExit = $TodayStatus[13];
                            $LateBy = $TodayStatus[12];

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
                                'punch_out_shift_name' => $punchOut_shift_name,
                                'final_status' => ($currentMethodAuto != 0) ? 1 : 0,
                                'process_complete' => ($currentMethodAuto != 0) ? 1 : 0,
                                'punch_out_location_tag' => ($methodAccept == 2) ? 2 : 0,
                                'today_status' => $OverAllTodayStatus,
                                'overtime' => $Overtime,
                                'shift_interval' => $ShiftInterval,
                                'early_exit' => $EarlyExit,
                                'late_by' => $LateBy
                            ];
                            $punchOutDateTodays =  AttendanceList::where('punch_date', $formattedDate)
                                ->where('emp_id', $emp)
                                ->where('emp_today_current_status', 1)
                                ->update($updateDATA);
                            Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business);
                            Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business);
                            if (isset($punchOutDateTodays)) { //BUG Loop

                                // $updateTodaysStatus = [];
                                // AttendanceList::where('punch_date', $formattedDate)
                                //     ->where('emp_id', $emp)
                                //     ->update($updateTodaysStatus);
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked PunchOut Successfully Attendance', 'case' => 2], 'status' => true], 200);
                            } else {

                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked Already PunchOut Successfully', 'case' => 3], 'status' => true], 200);
                            }
                        }
                    } else {
                        if ($methodAccept != null && $imageName != null && $punchInTime != null && $punchInAddress != null && $punchInLatitude != null && $punchInLongitude != null) {
                            $insertChecking = AttendanceList::where('punch_date', $formattedDate)
                                ->where('emp_id', $emp)
                                ->where('emp_today_current_status', 2)
                                ->first();
                            // dd($checkInTime,$extendedStartTime);
                            if (!isset($insertChecking)) {
                                if ($checkInTime >= $extendedStartTime) {
                                    // Checking shift Time start time also PunchOnly
                                    $collection = new AttendanceList();
                                    $collection->today_status = 4;
                                    $collection->setup_method_id = $setupActivateEmpID;
                                    $collection->setup_method_name = $setupActivateNameByAssignEmpID->method_name; //endgame active method on time insert
                                    $collection->emp_id = $emp;
                                    $collection->business_id = $business;
                                    $collection->branch_id = $information->branch_id;
                                    $collection->working_from_method = $methodAccept;
                                    $collection->method_auto = $currentMethodAuto; //current case on checking and value set
                                    $collection->method_manual = $currentMethodManual;
                                    $collection->final_status = 0; //QRCode-punchIn BY Manual ways
                                    $collection->emp_today_current_status = 1; //punch-in-confirm
                                    $collection->marked_in_mode = $markedInOutMode; //static_attendance_mode_response use by table
                                    $collection->active_selfie_mode = 1;
                                    $collection->active_biometric_mode = 0;
                                    $collection->attendance_shift = $ShiftItemID;
                                    $collection->punch_date = $punchDate; //anytime current upload DAY
                                    $collection->punch_in_selfie = $imageName; //subject mode setting
                                    $collection->punch_in_time = $punchInTime;
                                    $collection->punch_in_latitude = $punchInLatitude;
                                    $collection->punch_in_longitude = $punchInLongitude;
                                    $collection->punch_in_address = $punchInAddress;
                                    $collection->punch_in_location_tag = ($methodAccept == 2) ? 1 : 0;
                                    $collection->active_location_tab_mode = ($methodAccept == 2) ? 1 : 0;
                                    $collection->applied_shift_template_name = $appliedShift_template_name; //new data shifttype of name
                                    $collection->applied_shift_type_name = $appliedShift_type_name;
                                    $collection->applied_shift_comp_start_time = $appliedShift_comp_start_time;
                                    $collection->applied_shift_comp_end_time = $appliedShift_comp_end_time;
                                    $collection->brack_time = $appliedShift_break_time;
                                    $collection->punch_in_shift_name = $punchIn_shift_name;
                                    $collection->forward_by_role_id = $firstRoleId ?? 0;
                                    $collection->forward_by_status = 0;
                                    $collection->final_level_role_id = $lastRoleId ?? 0;
                                    $collection->final_status = 0;
                                    $collection->process_complete = 0;
                                    $collection->leave_type_category = $AttendanceCompOff[0];
                                    $collection->comp_off_active = $AttendanceCompOff[1];
                                    $collection->save();
                                    // Comp-Off Checking Upload Today checking new method
                                    Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business);
                                    Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business);
                                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked PunchIn Successfully Attendance', 'case' => 1], 'status' => true], 200);
                                }
                            } else {
                                // print_r("\n Times are Not within the specified range or within 10 minutes before or after. Default In: " . date('h:i a', $startTime) . "Out: " .  date('h:i a', $endTime));
                                // print_r("\n Times are Not within the specified range or within 10 minutes before or after. PUNCH In: " . date('h:i a', $checkInTime) . "Out: " . date('h:i a', $checkInTime));
                                // print_r("\n Times are Not Shift validated");
                                return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'You Shift has Not Started', 'case' => 9], 'status' => true], 200);
                            }
                            // return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Today Selfie Marked Completed', 'case' => 4], 'status' => true], 200);
                        } else {
                            // return response()->json(['result' => ['value' => 'Selfie Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Selfie Marked Already PunchIn Successfully', 'case' => 3], 'status' => true], 200);
                        }
                    }
                }
                // Location Tab only Apply for Outdoor active at after punchDate
                if ($emp != null && $business != null && $locationTab == 1 && $markedInOutMode == 4 && $methodAccept == 2 && $LocationTabAddress != '') {
                    $check = AttendanceList::where('punch_date', $formattedDate)
                        ->where('emp_id', $emp)
                        ->where('emp_today_current_status', 1)
                        ->first();
                    if (isset($check)) {

                        $storeMultipleListMode = [
                            'attendance_id' => $check->id,
                            'business_id' => $check->business_id,
                            'punch_time' => date('H:i'),
                            'latitude' => $LocationTabLatitude,
                            'logitude' => $LocationTabLongitude,
                            'address' => $LocationTabAddress
                        ];

                        $Checked = AttendanceTabLocation::insert($storeMultipleListMode);
                        if (isset($Checked)) {

                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Your Current Location add Location Tab', 'case' => 10], 'status' => true], 200);
                        } else {
                            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Not  add Location Tab', 'case' => 11], 'status' => true], 200);
                        }
                    }
                } else {
                    return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Incorrect PunchIn', 'case' => 5], 'status' => true], 404);
                }
            }
            // return response()->json(['result' => ['value' => 'Your Shift 10 min is PunchIn', 'case' => 8], 'status' => true], 200);

            return response()->json(['result' => ['Dafault InTime' => date('h:i a', $startTime), 'Dafault OutTime' => date('h:i a', $endTime), 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Your Shift is Activated', 'case' => 7], 'status' => true], 200);
        } else {
            return response()->json(['result' => ['Dafault InTime' => '', 'Dafault OutTime' => '', 'PunchInTime' => date('h:i a', strtotime($punchInTime)), 'PunchOutTime' => date('h:i a', strtotime($punchOutTime)), 'message' => 'Your Shift is Not Activated', 'case' => 6], 'status' => true], 404);

            // return response()->json(['result' => ['message' => 'Your Shift is Not Activated', 'case' => 6], 'status' => true], 404);
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

    public function attendanceDataList(Request $request)
    {
        $emp_id = $request->emp_id;
        $business_id = $request->business_id;
        $date = $request->date;
        if ($emp_id != null && $business_id != null && $date != null) {
            $requestDate = Carbon::createFromFormat('d-m-Y', $date);
            $emp = DB::table('employee_personal_details')
                ->where('emp_id', $emp_id)
                ->where('business_id', $business_id)
                ->first();
            if ($emp) {
                $attendance = AttendanceList::join('policy_attendance_shift_type_items', 'attendance_list.attendance_shift', '=', 'policy_attendance_shift_type_items.id')
                    ->where('attendance_list.emp_id', $emp_id)
                    ->where('attendance_list.business_id', $business_id)
                    ->whereYear('attendance_list.punch_date', '=', $requestDate->year)
                    ->whereMonth('attendance_list.punch_date', '=', $requestDate->month)
                    ->select('attendance_list.*', 'policy_attendance_shift_type_items.shift_name', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end')
                    ->orderBy('attendance_list.id', 'desc')
                    ->get();
                $load_only_attendance = UserAttendanceResources::collection($attendance)->all();

                // today check is Holidays
                $holiday_list = AttendanceHolidayList::where('business_id', $business_id)
                    ->whereDate('holiday_date', '<=', now()->format('Y-m-d'))
                    ->whereMonth('holiday_date', '=', $requestDate->month)
                    ->whereYear('holiday_date', '=', $requestDate->year)
                    ->where('master_end_method_id', $emp->master_endgame_id)
                    ->select('process_check', 'holiday_type_id', 'holiday_package_id', 'business_id', 'name as holiday_name', 'day as holiday_days', 'holiday_date', 'from_start', 'to_end')
                    ->get();
                $prow = UserHolidayListResource::collection($holiday_list)->all();
                // Fetch leave data
                // $leave_list = RequestLeaveList::where('business_id', $business_id)
                //     ->where('emp_id', $emp_id)
                //     ->leftJoin('static_request_leave_type', 'request_leave_list.leave_type', '=', 'static_request_leave_type.id')
                //     ->leftJoin('static_leave_shift_type', 'request_leave_list.shift_type', '=', 'static_leave_shift_type.id')
                //     ->leftJoin('static_leave_category', 'request_leave_list.leave_category', '=', 'static_leave_category.id')
                //     ->whereDate('request_leave_list.apply_date', '<=', now()->format('Y-m-d'))
                //     ->whereMonth('request_leave_list.apply_date', '=', $requestDate->month)
                //     ->whereYear('request_leave_list.apply_date', '=', $requestDate->year)
                //     ->select(
                //         'request_leave_list.leave_type',
                //         'static_request_leave_type.leave_day as leave_type_name',
                //         'request_leave_list.leave_category',
                //         'request_leave_list.days',
                //         \DB::raw('CAST(COALESCE(static_leave_shift_type.leave_shift_type, "") AS CHAR) as leave_shift_type'), // Handle null case and cast to string
                //         'static_leave_category.name as leave_category_name',
                //         'request_leave_list.shift_type',
                //         'request_leave_list.from_date',
                //         'request_leave_list.to_date',
                //         \DB::raw('CAST(request_leave_list.days AS DECIMAL(10, 2)) as total_days'), // Cast to float
                //         'request_leave_list.reason',
                //         'request_leave_list.final_status as status',
                //         \DB::raw('CAST(leave_remaining AS DECIMAL(10, 2)) as leave_remaining'), // Cast to float
                //         \DB::raw('CAST(leave_summary_debit_value AS DECIMAL(10, 2)) as leave_summary_debit_value'), // Cast to float
                //         \DB::raw('CAST(leave_summary_unpaid_value AS DECIMAL(10, 2)) as leave_summary_unpaid_value'), // Cast to float
                //         \DB::raw('DATE_FORMAT(request_leave_list.apply_date, "%Y-%m-%d") as formatted_apply_date'), // Format apply_date
                //         'request_leave_list.documents'
                //     )
                //     ->get();

                // Fetch absent data
                // $attendanceRecords =  $attendance->pluck('punch_date')->toArray();

                // $daysInMonth = Carbon::create($requestDate->year, $requestDate->month)->daysInMonth;
                // $fullMonthAttendance = collect();
                // $currentDate = Carbon::now();

                // for ($day = 1; $day <= $daysInMonth; $day++) {
                //     $date = Carbon::create($requestDate->year, $requestDate->month, $day)->format('Y-m-d');

                //     // Check if the date is neither a holiday nor in the attendance records
                //     if (!$leave_list->contains('formatted_apply_date', $date) && !$holiday_list->contains('holiday_date', $date) && !in_array($date, $attendanceRecords)) {
                //         // Mark as absent only if the date is on or before the current date
                //         $status = $currentDate->gte(Carbon::parse($date)) ? 'absent' : '';
                //         $fullMonthAttendance->push([
                //             'absent_type' => 2,
                //             'absent_date' => $date,
                //             'status' => $status,
                //         ]);
                //     }
                // }

                // // Filter out the days that are not absent
                // $absentDays = $fullMonthAttendance->filter(function ($day) {
                //     return $day['status'] === 'absent';->concat($leave_list)
                // })->values();)->concat($absentDays)
                // Merge the lists
                $combinedList = collect($load_only_attendance)->concat($prow);

                $sortedList = $combinedList
                    ->sortBy(
                        function ($item) {
                            // ?? $item['absent_date']
                            return $item['punch_date'] ?? $item['holiday_date'];
                        },
                        SORT_REGULAR,
                        true,
                    )
                    ->values()
                    ->all();

                if (count($sortedList) != 0) {
                    return response()->json(['result' => $sortedList, 'case' => 1, 'status' => true], 200);

                    // return ReturnHelpers::jsonApiReturnSecond(UserAttendanceResources::collection($attendance)->all(), 1); // case 1 when the attendance date find
                } else {
                    return response()->json(['result' => [], 'case' => 2, 'status' => true], 200); // case 2 when the employee attendance record not found
                }
            } else {
                return response()->json(['result' => [], 'case' => 3, 'status' => false], 404); // case 3 when the employee not found
            }
        } else {
            return response()->json(['result' => [], 'case' => 4, 'status' => false], 404); // case 4 when the rquired field is null
        }
    }
    public function checkLocationTabList(Request $request)
    {
        $pID = $request->primary_id;
        $emp_id = $request->emp_id;
        $business_id = $request->business_id;
        $active = $request->active_location_tab_mode; //accept one case

        $get = AttendanceList::where('emp_id', $emp_id)->where('business_id', $business_id)->where('id', $pID)->where('active_location_tab_mode', $active)->first();
        if (isset($get) && $active == 1) {
            $attendanceLocationTab = AttendanceTabLocation::where('attendance_id', $get->id)->get();

            return response()->json(['result' => UserAttendanceLocationTabList::collection($attendanceLocationTab)->all(), 'case' => 1, 'status' => true], 200);
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404); // case 3 when the employee not found
        }
    }
    public function currentStatusAttendanceRequest(Request $request)
    {
        $goto = DB::table('attendance_list')
            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'attendance_list.id')
            ->join('policy_setting_role_create', 'approval_status_list.role_id', '=', 'policy_setting_role_create.id')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->leftJoin('employee_personal_details', 'approval_status_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('attendance_list.id', $request->id) //primary id
            ->where('approval_status_list.approval_type_id', $request->approval_type) //leave type 2
            ->where('approval_status_list.business_id', $request->business_id)
            ->where('policy_setting_role_create.business_id', $request->business_id)
            ->select('approval_status_list.*', 'policy_setting_role_create.roles_name', 'static_status_request.request_response', 'employee_personal_details.emp_name as first_name', 'employee_personal_details.emp_mname as middle_name', 'employee_personal_details.emp_lname as last_name')
            ->get();
        if (isset($goto)) {
            // return $goto;

            return response()->json(['result' => CurrentAttendanceRequestStatus::collection($goto)->all(), 'case' => 1, 'status' => true], 200); // case 3 when the employee not found
            // return ReturnHelpers::jsonApiReturnSecond([CurrentAttendanceRequestStatus::collection($goto)->all(), 1],200); // case 1 when the leave date find
        } else {
            return response()->json(['result' => [], 'case' => 2, 'status' => false], 404); // case 3 when the employee not found
        }
    }
    public function show($id)
    {
        $empData = DB::table('employee_personal_details')
            ->where('emp_id', $id)
            ->first();
        if ($empData) {
            $attendData = AttendanceList::where('emp_id', $id)
                ->orderBy('id', 'desc')
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
    public function attendanceAcceptOnBusiness(Request $request)
    {
        $policy = PolicyAttendanceMode::where('business_id', $request->business_id)->get();
        if (!empty($policy)) {
            return response()->json(['result' =>  AttendanceAllowModeBusiness::collection($policy), 'case' => 1, 'status' => true], 200);
        } else {
            return response()->json(['result' =>  [], 'case' => 2, 'status' => false], 404);
        }
    }
}
