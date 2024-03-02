<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Session;
use DB;
use App\Models\PolicyAttendanceMode;
use App\Models\EmployeePersonalDetail;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicyAttenRuleOvertime;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Helpers\Central_unit;
use Alert;

class BioMetricImport implements ToCollection
{
    /**
     * @param Collection $collection
     *
     */
    protected $month, $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
    public function collection(Collection $collection)
    {
        $EmpId = Null;
        $EmpData = [];
        $EmpCount = 0;
        foreach ($collection as $key => $row) {
            if (($key) % 5 == 1) {
                $EmpId = $row[2];
                $day = 0;
                foreach ($row as $key1 => $value) {
                    if ($key1 >= 4) {
                        // echo 'emp: ' . $EmpId . '<pre>';
                        // echo 'status: ' . $collection[($EmpCount * 5) + 1][$day + 4] . '<pre>';
                        // echo 'in: ' . $collection[($EmpCount * 5) + 2][$day + 4] . '<pre>';
                        // echo 'out: ' . $collection[($EmpCount * 5) + 3][$day + 4] . '<pre>';
                        // echo 'WH: ' . $collection[($EmpCount * 5) + 4][$day + 4] . '<pre>';
                        // echo 'OT: ' . $collection[($EmpCount * 5) + 5][$day + 4] . '<pre>';
                        // echo 'day: ' . ++$day . '<pre>';
                        // echo '------------------------------------------------------' . '<pre>';

                        $inTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collection[($EmpCount * 5) + 2][$day + 4])->format('H:i:s');
                        $outTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collection[($EmpCount * 5) + 3][$day + 4])->format('H:i:s');
                        $workingHour = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collection[($EmpCount * 5) + 4][$day + 4])->format('H:i:s');


                        $EmpData[$day] = [
                            'emp' => $EmpId,
                            'status' => $collection[($EmpCount * 5) + 1][$day + 4],
                            'in' => $inTime,
                            'out' => $outTime,
                            'WH' => $workingHour,
                            'OT' => $collection[($EmpCount * 5) + 5][$day + 4],
                            'day' => ++$day
                        ];
                    }
                }
                // dd($EmpData);
                self::createDataInDB($EmpData);
                $EmpCount++;
            }
        }


        // foreach ($EmpData as $key => $Emp) {
        //     foreach ($Emp as $key => $empData) {

        //         $settedStatus = $empData['status'];
        //         $Status = 2;
        //         $punchDate = date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $empData['day']));


        //         if ($settedStatus == 'P' || $settedStatus == 'p') {
        //             $Status = 1;
        //         } else if ($settedStatus == 'OT' || $settedStatus == 'ot' || $settedStatus == 'Ot') {
        //             $Status = 9;
        //         } else if ($settedStatus == 'HD' || $settedStatus == 'hd' || $settedStatus == 'Hd') {
        //             $Status = 8;
        //         } else if ($settedStatus == 'L' || $settedStatus == 'l') {
        //             $Status = 10;
        //         } else if ($settedStatus == 'HO' || $settedStatus == 'ho' || $settedStatus == 'Ho') {
        //             $Status = 6;
        //         } else if ($settedStatus == 'WO' || $settedStatus == 'wo' || $settedStatus == 'Wo') {
        //             $Status = 7;
        //         } else if ($settedStatus == 'MSP' || $settedStatus == 'msp' || $settedStatus == 'Msp') {
        //             $Status = 4;
        //         } else {
        //             $Status = 2;
        //         }


        //         $emp = $empData['emp'];
        //         $business = Session::get('business_id');

        //         // dd($empData);
        //         //remaining on faceID and location-tabs
        //         // initialize
        //         $currentMethodAuto = 0;
        //         $currentMethodManual = 0;


        //         //methods
        //         $methodAccept = 4; //1-Office 2-Outdoor 3-Remote 4-biometric
        //         // mode
        //         $qrCode = 0; //Active Starter Created Attendance  Layer like 1-Office{qrmode} and Second{selfie}
        //         $selfie = 0;
        //         //other crede. gate_working_loaded_MODE
        //         $markedInOutMode = 4; //static_attendance_mode_response use by table //Marked like : MarkedIn : MarkedOut -> 1 QrCode , 2 FaceID , 3 Selfie, 4 Biometric

        //         // punchIn

        //         $punchInLatitude = Null;
        //         $punchInLongitude = Null;
        //         $punchInAddress = Null;

        //         // punchOut
        //         $punchOutLatitude = Null;
        //         $punchOutLongitude = Null;
        //         $punchOutAddress = Null;

        //         $punchInTime = $empData['in'];
        //         $punchOutTime = $empData['out'];
        //         $totalWorkingHour = $empData['WH'];
        //         $overTime = $empData['OT'];

        //         // dd($punchInTime,$punchOutTime,$totalWorkingHour );

        //         // check approval
        //         $approvalManagementCycle = ApprovalManagementCycle::where('business_id', $business)
        //             ->where('approval_type_id', 1)
        //             ->first();
        //         if ($approvalManagementCycle != null) {
        //             $roleIds = json_decode($approvalManagementCycle->role_id, true); // Decode JSON string to PHP array

        //             // Get the first index value of role_id
        //             $firstRoleId = $roleIds[0] ?? null; // This will get the first value or null if it doesn't exist

        //             // Get the last index value of role_id
        //             $lastRoleId = end($roleIds); // Get the last value of the array
        //         }
        //         //checking QR auto - manual  Automatic Set values BY AttendanceMode
        //         $checkingModes = PolicyAttendanceMode::where('business_id', $business)
        //             ->where(function ($query) {
        //                 $query->where('office_auto', 1)->orWhere('office_manual', 1); //->orWhere('office_face_id', 1)->orWhere('office_qr', 1)->orWhere('office_selfie', 1);
        //             })
        //             ->select('office_auto', 'office_manual')
        //             ->first();

        //         if (isset($checkingModes)) {
        //             $currentMethodAuto = $checkingModes->office_auto;
        //             $currentMethodManual = $checkingModes->office_manual;
        //         }
        //         // Rules
        //         $getDay = RulesManagement::TodayStatus()[0]; //current Day;
        //         // $formattedDate = date('Y-m-d', strtotime($getDay));
        //         // $punchDate = $punchDate;



        //         $information = EmployeePersonalDetail::where('business_id', $business)
        //             ->where('emp_id', $emp)
        //             ->first(); //findOut Employee Details

        //         // Find SetupActive By EmpID backdown invalied data stop PunchIn or PunchOut
        //         $setupActivateEmpID = $information->master_endgame_id;
        //         $setupActivateNameByAssignEmpID = DB::table('policy_master_endgame_method')->where('business_id', $business)->where('id', $setupActivateEmpID)->where('method_switch', 1)->first();

        //         $policyGetShiftPerDay = DB::table('employee_personal_details')
        //             ->join('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
        //             ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
        //             ->where('employee_personal_details.emp_id', $emp) //check emp_id
        //             ->where('employee_personal_details.business_id', $business) //check business_id
        //             ->select('static_attendance_shift_type.id as emp_shift_type')
        //             ->first(); //get empolyee shift type assigned
        //         $ShiftTypeID = $policyGetShiftPerDay->emp_shift_type;
        //         // Rotational Shift Items
        //         $RotationalShift = $information->emp_rotational_shift_type_item;

        //         // ShiftAttendanceChecking Cell Shift credentials show list
        //         $DATA = EmployeePersonalDetail::leftJoin('policy_attendance_shift_settings', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_settings.id')
        //             ->leftJoin('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
        //             ->leftJoin('policy_attendance_shift_type_items', 'employee_personal_details.emp_shift_type', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
        //             ->leftJoin('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
        //             ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))') //End-Games method array index values checking
        //             ->where('policy_master_endgame_method.method_switch', 1) //end game method on also
        //             ->where('employee_personal_details.active_emp', 1)
        //             ->where('employee_personal_details.emp_id', $emp) //check emp_id
        //             ->where('employee_personal_details.business_id', $business) //check business_id
        //             ->Where(function ($query) use ($RotationalShift, $ShiftTypeID) {
        //                 // only rotational case special
        //                 if ($ShiftTypeID == 2 && $RotationalShift != 0) {
        //                     $query->where('policy_attendance_shift_type_items.id', $RotationalShift);
        //                 }
        //             })
        //             ->select('policy_master_endgame_method.id as method_id', 'policy_master_endgame_method.method_name as method_name', 'policy_attendance_shift_type_items.id as shift_item_id', 'policy_attendance_shift_type_items.shift_name as shift_template_name', 'static_attendance_shift_type.id  as shift_type_id', 'static_attendance_shift_type.name as shift_type_name', 'policy_attendance_shift_type_items.shift_start as shift_start_time', 'policy_attendance_shift_type_items.shift_end as shift_end_time', 'policy_attendance_shift_type_items.shift_hr as shift_hour', 'policy_attendance_shift_type_items.shift_min as shift_min', 'policy_attendance_shift_type_items.work_hr as working_hour', 'policy_attendance_shift_type_items.work_min as working_min', 'policy_attendance_shift_type_items.break_min as break_min', 'policy_attendance_shift_type_items.is_paid as is_paid')
        //             ->first();

        //         // dd($DATA);

        //         if (isset($DATA)) {


        //             $startTime = strtotime($DATA->shift_start_time);
        //             $endTime = strtotime($DATA->shift_end_time);
        //             $checkInTime = strtotime($punchInTime);
        //             $checkOutTime = strtotime($punchOutTime);


        //             $checkingFinalShiftTimeMin = 0;
        //             // Attendance Shift Overtime checking PolicyAttenRuleOvertime
        //             $GetAutomaticRuleApplyByAutomation = PolicyAttenRuleOvertime::where('business_id', $business)->where('switch_is', 1)->first();

        //             if (isset($GetAutomaticRuleApplyByAutomation)) {
        //                 $calculationModelHour = (int) ($GetAutomaticRuleApplyByAutomation->early_ot_hr) * 60;
        //                 $calculationModelMin = (int) $GetAutomaticRuleApplyByAutomation->early_ot_min;
        //                 $checkingFinalShiftTimeMin = ($calculationModelHour + $calculationModelMin) ?? 0; //sum minutes
        //             }
        //             $RestricGateAttenadancePunchIn = ($checkingFinalShiftTimeMin != 0) ? $checkingFinalShiftTimeMin : 15;
        //             $beforemin = $RestricGateAttenadancePunchIn * 60; //15 * 60; // Convert 15 minutes to seconds

        //             // Define the extended start and end times by adding/subtracting 15 minutes
        //             $extendedStartTime = $startTime - $beforemin;
        //             $extendedEndTime = $startTime + $beforemin;


        //             //shiftCollections
        //             $ShiftItemID = $DATA->shift_item_id;


        //             $appliedShift_type_name = $DATA->shift_type_name;
        //             $appliedShift_template_name = $DATA->shift_template_name;
        //             $appliedShift_comp_start_time = $DATA->shift_start_time;
        //             $appliedShift_comp_end_time = $DATA->shift_end_time;
        //             $appliedShift_break_time = $DATA->break_min;
        //             $punchIn_shift_name = $DATA->shift_type_name;
        //             $punchOut_shift_name = $DATA->shift_type_name;


        //             // Office Method
        //             if (isset($information)) {

        //                 // dd($information);
        //                 // BioMetric Attendance Mode
        //                 $CreateEmpAttendance = DB::table('attendance_list')->insert([
        //                     'today_status' => $Status,
        //                     'emp_id' => $emp,
        //                     'punch_date' => $punchDate,
        //                     'overtime' => 0,
        //                     'late_by' => 0,
        //                     'early_exit' => 0,
        //                     'total_working_hour' => $totalWorkingHour,
        //                     'shift_interval' => 0,
        //                     'setup_method_id' => $setupActivateEmpID,
        //                     'setup_method_name' => $setupActivateNameByAssignEmpID->method_name,
        //                     'working_from_method' => $methodAccept,
        //                     'method_auto' => $currentMethodAuto,
        //                     'method_manual' => $currentMethodManual,
        //                     'marked_in_mode' => $markedInOutMode,
        //                     'active_qr_mode' => 0,
        //                     'marked_out_mode' => $markedInOutMode,
        //                     'active_selfie_mode' => 0,
        //                     'active_face_mode' => 0,
        //                     'active_location_tab_mode' => 0,
        //                     'active_biometric_mode' => 1,
        //                     'attendance_shift' => $ShiftItemID,
        //                     'applied_shift_template_name' => $appliedShift_template_name,
        //                     'applied_shift_type_name' => $appliedShift_type_name,
        //                     'applied_shift_comp_start_time' => $appliedShift_comp_start_time,
        //                     'applied_shift_comp_end_time' => $appliedShift_comp_end_time,
        //                     'brack_time' => $appliedShift_break_time,
        //                     'brack_paid_check' => 0,
        //                     'punch_in_shift_name' => $punchIn_shift_name,
        //                     'punch_out_shift_name' => $punchOut_shift_name,
        //                     'business_id' => $business,
        //                     'branch_id' => $information->branch_id,
        //                     'emp_today_current_status' => 2,
        //                     'punch_in_selfie' => null,
        //                     'punch_in_time' => $punchInTime,
        //                     'punch_in_location_tag' => null,
        //                     'punch_in_address' => null,
        //                     'punch_in_latitude' => null,
        //                     'punch_in_longitude' => null,
        //                     'punch_out_selfie' => null,
        //                     'punch_out_time' => $punchOutTime,
        //                     'punch_out_address' => null,
        //                     'punch_out_latitude' => null,
        //                     'punch_out_longitude' => null,
        //                     'punch_out_location_tag' => null,
        //                     'approved_by_role_id' => 0,
        //                     'approved_by_emp_id' => null,
        //                     'forward_by_role_id' => $firstRoleId ?? 0,
        //                     'forward_by_status' => 1,
        //                     'final_level_role_id' => $lastRoleId ?? 0,
        //                     'final_status' => 1,
        //                     'process_complete' => 1,
        //                 ]);
        //                 $TodayStatus = Central_unit::getEmpAttSummaryApi2(['emp_id' => $emp, 'punch_date' => $punchDate, 'business_id' => $business, 'branch_id' => $information->branch_id]);
        //                 Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business, $information->branch_id);
        //                 Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business, $information->branch_id, Session::get('login_role'), Session::get('login_emp_id'));
        //                 // dd($punchDate);

        //                 // $update = DB::table('attendance_list')->Where(['emp_id'=>$emp,'punch_date'=> date('Y-m-d', strtotime($punchDate)),'business_id'=>$business])->update([
        //                 //     'today_status' => $TodayStatus['Status'],
        //                 //     'overtime' => $TodayStatus['Overtime'],
        //                 //     'shift_interval' => $TodayStatus['ShiftInterval'],
        //                 //     'early_exit' => $TodayStatus['EarlyExitBy'],
        //                 //     'late_by' => $TodayStatus['LateBy'],
        //                 // ]);

        //                 // dd($CreateEmpAttendance,$TodayStatus);
        //             }
        //         } else {
        //             Alert::warning("Employee Shift is not found");
        //             return back();
        //         }
        //     }
        // }

        Alert::success('','Inserted Successfully');
        return back();
    }

    public function createDataInDB($Data){
        foreach ($Data as $key => $empData) {
            // dd($empData);
            $settedStatus = $empData['status'];
            $Status = 2;
            $punchDate = date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $empData['day']));


            if ($settedStatus == 'P' || $settedStatus == 'p') {
                $Status = 1;
            } else if ($settedStatus == 'OT' || $settedStatus == 'ot' || $settedStatus == 'Ot') {
                $Status = 9;
            } else if ($settedStatus == 'HD' || $settedStatus == 'hd' || $settedStatus == 'Hd') {
                $Status = 8;
            } else if ($settedStatus == 'L' || $settedStatus == 'l') {
                $Status = 10;
            } else if ($settedStatus == 'HO' || $settedStatus == 'ho' || $settedStatus == 'Ho') {
                $Status = 6;
            } else if ($settedStatus == 'WO' || $settedStatus == 'wo' || $settedStatus == 'Wo') {
                $Status = 7;
            } else if ($settedStatus == 'MSP' || $settedStatus == 'msp' || $settedStatus == 'Msp') {
                $Status = 4;
            } else {
                $Status = 2;
            }


            $emp = $empData['emp'];
            $business = Session::get('business_id');

            // dd($empData);
            //remaining on faceID and location-tabs
            // initialize
            $currentMethodAuto = 0;
            $currentMethodManual = 0;


            //methods
            $methodAccept = 4; //1-Office 2-Outdoor 3-Remote 4-biometric
            // mode
            $qrCode = 0; //Active Starter Created Attendance  Layer like 1-Office{qrmode} and Second{selfie}
            $selfie = 0;
            //other crede. gate_working_loaded_MODE
            $markedInOutMode = 4; //static_attendance_mode_response use by table //Marked like : MarkedIn : MarkedOut -> 1 QrCode , 2 FaceID , 3 Selfie, 4 Biometric

            // punchIn

            $punchInLatitude = Null;
            $punchInLongitude = Null;
            $punchInAddress = Null;

            // punchOut
            $punchOutLatitude = Null;
            $punchOutLongitude = Null;
            $punchOutAddress = Null;

            $punchInTime = $empData['in'];
            $punchOutTime = $empData['out'];
            $totalWorkingHour = $empData['WH'];
            $overTime = $empData['OT'];

            // dd($punchInTime,$punchOutTime,$totalWorkingHour );

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
            }
            //checking QR auto - manual  Automatic Set values BY AttendanceMode
            $checkingModes = PolicyAttendanceMode::where('business_id', $business)
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
            // $formattedDate = date('Y-m-d', strtotime($getDay));
            // $punchDate = $punchDate;



            $information = EmployeePersonalDetail::where('business_id', $business)
                ->where('emp_id', $emp)
                ->first(); //findOut Employee Details

            // Find SetupActive By EmpID backdown invalied data stop PunchIn or PunchOut
            $setupActivateEmpID = $information->master_endgame_id;
            $setupActivateNameByAssignEmpID = DB::table('policy_master_endgame_method')->where('business_id', $business)->where('id', $setupActivateEmpID)->where('method_switch', 1)->first();

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
                })
                ->select('policy_master_endgame_method.id as method_id', 'policy_master_endgame_method.method_name as method_name', 'policy_attendance_shift_type_items.id as shift_item_id', 'policy_attendance_shift_type_items.shift_name as shift_template_name', 'static_attendance_shift_type.id  as shift_type_id', 'static_attendance_shift_type.name as shift_type_name', 'policy_attendance_shift_type_items.shift_start as shift_start_time', 'policy_attendance_shift_type_items.shift_end as shift_end_time', 'policy_attendance_shift_type_items.shift_hr as shift_hour', 'policy_attendance_shift_type_items.shift_min as shift_min', 'policy_attendance_shift_type_items.work_hr as working_hour', 'policy_attendance_shift_type_items.work_min as working_min', 'policy_attendance_shift_type_items.break_min as break_min', 'policy_attendance_shift_type_items.is_paid as is_paid')
                ->first();

            // dd($DATA);

            if (isset($DATA)) {


                $startTime = strtotime($DATA->shift_start_time);
                $endTime = strtotime($DATA->shift_end_time);
                $checkInTime = strtotime($punchInTime);
                $checkOutTime = strtotime($punchOutTime);


                $checkingFinalShiftTimeMin = 0;
                // Attendance Shift Overtime checking PolicyAttenRuleOvertime
                $GetAutomaticRuleApplyByAutomation = PolicyAttenRuleOvertime::where('business_id', $business)->where('switch_is', 1)->first();

                if (isset($GetAutomaticRuleApplyByAutomation)) {
                    $calculationModelHour = (int) ($GetAutomaticRuleApplyByAutomation->early_ot_hr) * 60;
                    $calculationModelMin = (int) $GetAutomaticRuleApplyByAutomation->early_ot_min;
                    $checkingFinalShiftTimeMin = ($calculationModelHour + $calculationModelMin) ?? 0; //sum minutes
                }
                $RestricGateAttenadancePunchIn = ($checkingFinalShiftTimeMin != 0) ? $checkingFinalShiftTimeMin : 15;
                $beforemin = $RestricGateAttenadancePunchIn * 60; //15 * 60; // Convert 15 minutes to seconds

                // Define the extended start and end times by adding/subtracting 15 minutes
                $extendedStartTime = $startTime - $beforemin;
                $extendedEndTime = $startTime + $beforemin;


                //shiftCollections
                $ShiftItemID = $DATA->shift_item_id;


                $appliedShift_type_name = $DATA->shift_type_name;
                $appliedShift_template_name = $DATA->shift_template_name;
                $appliedShift_comp_start_time = $DATA->shift_start_time;
                $appliedShift_comp_end_time = $DATA->shift_end_time;
                $appliedShift_break_time = $DATA->break_min;
                $punchIn_shift_name = $DATA->shift_type_name;
                $punchOut_shift_name = $DATA->shift_type_name;


                // Office Method
                if (isset($information)) {

                    // dd($information);
                    // BioMetric Attendance Mode
                    $CreateEmpAttendance = DB::table('attendance_list')->insert([
                        'today_status' => $Status,
                        'emp_id' => $emp,
                        'punch_date' => $punchDate,
                        'overtime' => 0,
                        'late_by' => 0,
                        'early_exit' => 0,
                        'total_working_hour' => $totalWorkingHour,
                        'shift_interval' => 0,
                        'setup_method_id' => $setupActivateEmpID,
                        'setup_method_name' => $setupActivateNameByAssignEmpID->method_name,
                        'working_from_method' => $methodAccept,
                        'method_auto' => $currentMethodAuto,
                        'method_manual' => $currentMethodManual,
                        'marked_in_mode' => $markedInOutMode,
                        'active_qr_mode' => 0,
                        'marked_out_mode' => $markedInOutMode,
                        'active_selfie_mode' => 0,
                        'active_face_mode' => 0,
                        'active_location_tab_mode' => 0,
                        'active_biometric_mode' => 1,
                        'attendance_shift' => $ShiftItemID,
                        'applied_shift_template_name' => $appliedShift_template_name,
                        'applied_shift_type_name' => $appliedShift_type_name,
                        'applied_shift_comp_start_time' => $appliedShift_comp_start_time,
                        'applied_shift_comp_end_time' => $appliedShift_comp_end_time,
                        'brack_time' => $appliedShift_break_time,
                        'brack_paid_check' => 0,
                        'punch_in_shift_name' => $punchIn_shift_name,
                        'punch_out_shift_name' => $punchOut_shift_name,
                        'business_id' => $business,
                        'branch_id' => $information->branch_id,
                        'emp_today_current_status' => 2,
                        'punch_in_selfie' => null,
                        'punch_in_time' => $punchInTime,
                        'punch_in_location_tag' => null,
                        'punch_in_address' => null,
                        'punch_in_latitude' => null,
                        'punch_in_longitude' => null,
                        'punch_out_selfie' => null,
                        'punch_out_time' => $punchOutTime,
                        'punch_out_address' => null,
                        'punch_out_latitude' => null,
                        'punch_out_longitude' => null,
                        'punch_out_location_tag' => null,
                        'approved_by_role_id' => 0,
                        'approved_by_emp_id' => null,
                        'forward_by_role_id' => $firstRoleId ?? 0,
                        'forward_by_status' => 1,
                        'final_level_role_id' => $lastRoleId ?? 0,
                        'final_status' => 1,
                        'process_complete' => 1,
                    ]);
                    $TodayStatus = Central_unit::getEmpAttSummaryApi2(['emp_id' => $emp, 'punch_date' => $punchDate, 'business_id' => $business, 'branch_id' => $information->branch_id]);
                    Central_unit::MyCountForMonth($emp, date('Y-m-d', strtotime($punchDate)), $business, $information->branch_id);
                    Central_unit::MyCountForDaily(date('Y-m-d', strtotime($punchDate)), $business, $information->branch_id, Session::get('login_role'), Session::get('login_emp_id'));
                    // dd($punchDate);

                    // $update = DB::table('attendance_list')->Where(['emp_id'=>$emp,'punch_date'=> date('Y-m-d', strtotime($punchDate)),'business_id'=>$business])->update([
                    //     'today_status' => $TodayStatus['Status'],
                    //     'overtime' => $TodayStatus['Overtime'],
                    //     'shift_interval' => $TodayStatus['ShiftInterval'],
                    //     'early_exit' => $TodayStatus['EarlyExitBy'],
                    //     'late_by' => $TodayStatus['LateBy'],
                    // ]);

                    // dd($CreateEmpAttendance,$TodayStatus);
                }
            } else {
                Alert::warning("Employee Shift is not found");
                return back();
            }
        }
    }
}
