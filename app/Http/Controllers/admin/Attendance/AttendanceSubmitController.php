<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Illuminate\Http\Request;
use DB;
use Session;
use Alert;
use carbon\Carbon;

class AttendanceSubmitController extends Controller
{
    public function index($date)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $EmployeeDate = [];
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $NofDay = date('t', strtotime($date));


        $MonthName = date('F', strtotime($date));

        $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $NofDay));
        $Employee = DB::table('employee_personal_details')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_date_of_joining', '<=', $date)
            ->where('employee_personal_details.active_emp', 1)
            ->join('designation_list', 'employee_personal_details.designation_id', 'designation_list.desig_id')
            ->get();

        foreach ($Employee as $key => $value) {
            for ($i = 1; $i <= $NofDay; $i++) {
                $empStatus[$i] = Central_unit::getEmpAttSumm(['emp_id' => $value->emp_id, 'punch_date' => date('Y-m-d', strtotime($year . '-' . $month . '-' . $i))])[0];
            }
            $EmpAttendanceCount = Central_unit::getMonthlyCountFromDB($value->emp_id, $year, $month, Session::get('business_id'));


            $EmployeeDate[$key] = [
                'name' => $value->emp_name . ' ' . $value->emp_mname . ' ' . $value->emp_lname,
                'empId' => $value->emp_id,
                'designation' => $value->desig_name,
                'imgURL' => $value->profile_photo,
                'month' => $month,
                'year' => $year,
                'status' => $empStatus,
                'count' => $EmpAttendanceCount,
            ];
        }
        return view('admin.attendance.submit', compact('NofDay', 'EmployeeDate', 'permissions','MonthName','year'));
    }

    public function DefreezeAttendance($id)
    {
        $submittedData = DB::table('attendance_submit')->where('id', $id)->first();

        $currentDate = Carbon::now();
        $givenDate = Carbon::create($submittedData->year, $submittedData->month, 1);
        $monthDifference = $currentDate->diffInMonths($givenDate);
        // dd($monthDifference);

        if ($monthDifference <= 1) {
            $dfreeze = DB::table('attendance_submit')->where('id', $id)->update(['submited' => 0]);
            if ($dfreeze) {
                Alert::success('Succesfully Defreezed');
            } else {
                Alert::error('Failed');
            }
        } else {
            Alert::error('Failed', 'You can not defreeze attendance becouse monthly interval has been lapsed');
        }

        return back();
    }

    public function updateAttendancePage()
    {
        return view('admin.attendance.forcely_update');
    }

    public function forcefulyCorrectionMethod(Request $request)
    {

        // dd($request->all());

        $selectedDate = date('Y-m-d', strtotime($request->date_select));
        $submittedData = DB::table('attendance_submit')
            ->where([
                ['month', '=', date('m', strtotime($selectedDate))],
                ['year', '=', date('Y', strtotime($selectedDate))]
            ])
            ->first();
        if ($submittedData == null) {
            // dd($submittedData);
            Alert::error('Failed', 'Only Submitted Data Can Force Update, You can use normal edit way.');
            return back();
        } else {
            if($submittedData->submited){
                Alert::warning('Failed', 'Kindly De-Freeze the Submitted Data');
                return back();
            }
        }


        $employeeOtherDetails = Central_unit::getIndivisualEmployeeDetails($request->emp_id);
        $EmpName = $employeeOtherDetails->emp_name ?? '';
        $EmpMName = $employeeOtherDetails->emp_mname ?? '';
        $EmpLName = $employeeOtherDetails->emp_lname ?? '';
        $EmpID = $employeeOtherDetails->emp_id ?? '';
        $EmpShiftName = $employeeOtherDetails->attendance_shift_name ?? '';
        $EmpShiftStart = $employeeOtherDetails->shift_start ?? '';
        $EmpShiftEnd = $employeeOtherDetails->shift_end ?? '';
        $InTime = RulesManagement::Convert12To24($request->in_time);
        $OutTime = RulesManagement::Convert12To24($request->out_time);
        $TotalWorkHour = date('h:i:s', strtotime($request->total_working));

        $empDetails = DB::table('employee_personal_details')->where(['business_id' => Session::get('business_id'), 'emp_id' => $request->emp_id])->first();
        $shift = $empDetails->assign_shift_type == 2 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();
        $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : 'N/A';
        $shiftInterval = $interval->h ?? 0 + $interval->i ?? 0;

        $Remark = $request->reason;
        $PunchDate = date('Y-m-d', strtotime($request->date_select));

        $status = 1;
        $ApprovalTypeID = 1;
        $BID = Session::get('business_id');
        $FindRoleID = Session::get('login_role');


        $attndanceDetails = DB::table('attendance_list')->where(['business_id' => Session::get('business_id'), 'punch_date' => $PunchDate, 'emp_id' => $EmpID])->first();
        $approvalCycle = DB::table('approval_management_cycle')->where(['business_id' => Session::get('business_id'), 'cycle_type' => 1])->first();


        if (isset($attndanceDetails)) {


            $updateAttendance = DB::table('attendance_list')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'punch_date' => $PunchDate,
                    'emp_id' => $EmpID
                ])
                ->update([
                    'emp_today_current_status' => 2,
                    'punch_in_time' => date('h:m:s',strtotime($InTime)),
                    'punch_out_time' => date('h:m:s',strtotime($OutTime)),
                    'total_working_hour' => $TotalWorkHour
                ]);

            $createLog = DB::table('attendance_time_log')->insert([
                'business_id' => Session::get('business_id'),
                'emp_id' => $EmpID,
                'change_date' => date('Y-m-d'),
                'punch_date' => date('Y-m-d', strtotime($PunchDate)),
                'prev_in_time' => $attndanceDetails ? $attndanceDetails->punch_in_time : '00:00:00',
                'changed_in_time' => date('h:m:s',strtotime($InTime)),
                'prev_out_time' => $attndanceDetails ? $attndanceDetails->punch_out_time : '00:00:00',
                'changed_out_time' => date('h:m:s',strtotime($OutTime)),
                'prev_total_work' => $attndanceDetails ? $attndanceDetails->total_working_hour : '00:00:00',
                'changed_total_work' => $TotalWorkHour != null ? $TotalWorkHour : '00:00:00',
                'reason' => $request->reason,
                'changed_by' => $FindRoleID,
                'changer_emp_id' => Session::get('model_id') ?? Null,
                'changer_role' => Session::get('user_type') ?? null,
                'changer_name' => Session::get('login_name') ?? null,
            ]);

        } else {

            $newAttendanceData = DB::table('attendance_list')->insert([
                'today_status' => $attndanceDetails ? $attndanceDetails->today_status : 1,
                'emp_id' => $attndanceDetails ? $attndanceDetails->emp_id : $request->emp_id,
                'punch_date' => $attndanceDetails ? $attndanceDetails->punch_date : date('Y-m-d', strtotime($PunchDate)),
                'overtime' => $attndanceDetails ? $attndanceDetails->overtime : 0,
                'late_by' => $attndanceDetails ? $attndanceDetails->late_by : 0,
                'early_exit' => $attndanceDetails ? $attndanceDetails->early_exit : 0,
                'total_working_hour' => $TotalWorkHour != null ? $TotalWorkHour : '00:00:00',
                'shift_interval' => $attndanceDetails ? $attndanceDetails->shift_interval : $shiftInterval,
                'setup_method_id' => $attndanceDetails ? $attndanceDetails->setup_method_id : ($empDetails != null ? $empDetails->master_endgame_id : null),
                'setup_method_name' => $attndanceDetails ? $attndanceDetails->setup_method_name : null,
                'working_from_method' => $attndanceDetails ? $attndanceDetails->working_from_method : ($empDetails != null ? $empDetails->emp_attendance_method : null),
                'method_auto' => $attndanceDetails ? $attndanceDetails->method_auto : 0,
                'method_manual' => $attndanceDetails ? $attndanceDetails->method_manual : 1,
                'marked_in_mode' => $attndanceDetails ? $attndanceDetails->marked_in_mode : 0,
                'active_qr_mode' => $attndanceDetails ? $attndanceDetails->active_qr_mode : 0,
                'marked_out_mode' => $attndanceDetails ? $attndanceDetails->marked_out_mode : 0,
                'active_selfie_mode' => $attndanceDetails ? $attndanceDetails->active_selfie_mode : 1,
                'active_face_mode' => $attndanceDetails ? $attndanceDetails->active_face_mode : 0,
                'active_location_tab_mode' => $attndanceDetails ? $attndanceDetails->active_location_tab_mode : 0,
                'attendance_shift' => $attndanceDetails ? $attndanceDetails->attendance_shift : ($empDetails != null ? $empDetails->emp_attendance_method : null),
                'applied_shift_template_name' => $attndanceDetails ? $attndanceDetails->applied_shift_template_name : null,
                'applied_shift_type_name' => $attndanceDetails ? $attndanceDetails->applied_shift_type_name : null,
                'applied_shift_comp_start_time' => $attndanceDetails ? $attndanceDetails->applied_shift_comp_start_time : ($shift != null ? $shift->shift_start : null),
                'applied_shift_comp_end_time' => $attndanceDetails ? $attndanceDetails->applied_shift_comp_end_time : ($shift != null ? $shift->shift_end : null),
                'brack_time' => $attndanceDetails ? $attndanceDetails->brack_time : ($shift != null ? $shift->break_min : null),
                'brack_paid_check' => $attndanceDetails ? $attndanceDetails->brack_paid_check : ($shift != null ? $shift->is_paid : null),
                'punch_in_shift_name' => $attndanceDetails ? $attndanceDetails->punch_in_shift_name : null,
                'punch_out_shift_name' => $attndanceDetails ? $attndanceDetails->punch_out_shift_name : null,
                'business_id' => $attndanceDetails ? $attndanceDetails->business_id : Session::get('business_id'),
                'branch_id' => $attndanceDetails ? $attndanceDetails->branch_id : Session::get('branch_id'),
                'emp_today_current_status' => isset($InTime) && isset($OutTime) ? 2 : $attndanceDetails->emp_today_current_status,
                'punch_in_selfie' => $attndanceDetails ? $attndanceDetails->punch_in_selfie : ($empDetails != null ? $empDetails->profile_photo : null),
                'punch_in_time' => date('h:m:s',strtotime($InTime)),
                'punch_in_location_tag' => $attndanceDetails ? $attndanceDetails->punch_in_location_tag : null,
                'punch_in_address' => $attndanceDetails ? $attndanceDetails->punch_in_address : null,
                'punch_in_latitude' => $attndanceDetails ? $attndanceDetails->punch_in_latitude : null,
                'punch_in_longitude' => $attndanceDetails ? $attndanceDetails->punch_in_longitude : null,
                'punch_out_selfie' => $attndanceDetails ? $attndanceDetails->punch_out_selfie : ($empDetails != null ? $empDetails->profile_photo : null),
                'punch_out_time' => date('h:m:s',strtotime($OutTime)),
                'punch_out_address' => $attndanceDetails ? $attndanceDetails->punch_out_address : null,
                'punch_out_latitude' => $attndanceDetails ? $attndanceDetails->punch_out_latitude : null,
                'punch_out_longitude' => $attndanceDetails ? $attndanceDetails->punch_out_longitude : null,
                'punch_out_location_tag' => $attndanceDetails ? $attndanceDetails->punch_out_location_tag : null,
                'approved_by_role_id' => $attndanceDetails ? $attndanceDetails->approved_by_role_id : 0,
                'approved_by_emp_id' => null,
                'forward_by_role_id' => $approvalCycle != null ? json_decode($approvalCycle->role_id)[count(json_decode($approvalCycle->role_id)) - 1] : 0,
                'forward_by_status' => $attndanceDetails ? $attndanceDetails->today_status : 0,
                'final_level_role_id' => $approvalCycle != null ? json_decode($approvalCycle->role_id)[0] : 0,
                'final_status' => $attndanceDetails ? $attndanceDetails->final_status : 0,
                'process_complete' => $attndanceDetails ? $attndanceDetails->process_complete : 0,
            ]);

            $createLog = DB::table('attendance_time_log')->insert([
                'business_id' => Session::get('business_id'),
                'emp_id' => $EmpID,
                'change_date' => date('Y-m-d'),
                'punch_date' => date('Y-m-d', strtotime($PunchDate)),
                'prev_in_time' => isset($attndanceDetails) ? $attndanceDetails->punch_in_time : 'N/A',
                'changed_in_time' => date('h:m:s',strtotime($InTime)),
                'prev_out_time' => isset($attndanceDetails) ? $attndanceDetails->punch_out_time : 'N/A',
                'changed_out_time' =>date('h:m:s',strtotime($OutTime)),
                'prev_total_work' => isset($attndanceDetails) ? $attndanceDetails->total_working_hour : 'N/A',
                'changed_total_work' => $TotalWorkHour != null ? $TotalWorkHour : 'N/A',
                'reason' => $request->reason,
                'changed_by' => $FindRoleID,
                'changer_emp_id' => Session::get('model_id') ?? Null,
                'changer_role' => Session::get('user_type') ?? null,
                'changer_name' => Session::get('login_name') ?? null,
            ]);

        }


        $attndanceDetails = DB::table('attendance_list')->where(['business_id' => Session::get('business_id'), 'punch_date' => $PunchDate, 'emp_id' => $EmpID])->first();
        $calculation = Central_unit::getEmpAttSummaryApi(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d', strtotime($PunchDate)), 'emp_id' => $request->emp_id]);
        $PID = $attndanceDetails->id;

        $parallerModalApprovalBtn = DB::table('attendance_list')
            ->where('business_id', $BID)
            ->where('id', $PID)
            ->where('emp_today_current_status', 2)
            ->update([
                'today_status' => $calculation[0],
                'process_complete' => 1,
                'final_status' => $status,
            ]);
        if ($parallerModalApprovalBtn) {

            DB::table('approval_status_list')
                ->where('business_id', $BID)
                ->where('approval_type_id', $ApprovalTypeID)
                ->where('all_request_id', $PID)
                ->insert([
                    'applied_cycle_type' => 2,
                    'business_id' => $BID,
                    'approval_type_id' => $ApprovalTypeID,
                    'all_request_id' => $PID,
                    'role_id' => $FindRoleID,
                    'emp_id' => $EmpID,
                    'clicked' => 1,
                    'remarks' => $Remark,
                    'status' => $status,
                ]);

            Alert::success('', 'Attendance is Approve');
        } else {
            Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
        }

        $monthCount = Central_unit::MyCountForMonth($request->emp_id, date('Y-m-d', strtotime($PunchDate)), Session::get('business_id'));
        $dailyCount = Central_unit::MyCountForDaily(date('Y-m-d', strtotime($PunchDate)), Session::get('business_id'));

        if(isset($monthCount) || isset($dailyCount)){
            Alert::success('', 'Counts Updated SuccessFully');
        }else{
            Alert::info('','Counts Not Update');
        }
        return back();

    }
    public function getEmpShiftAjax(Request $request)
    {
        $data = [];
        $employeeOtherDetails = Central_unit::getIndivisualEmployeeDetails($request->emp_id);
        $empAttendance = DB::table('attendance_list')->where('business_id', Session::get('business_id'))->where(['emp_id' => $request->emp_id, 'punch_date' => date('Y-m-d', strtotime($request->date))])->first();

        $EmpName = $employeeOtherDetails->emp_name ?? '';
        $EmpMName = $employeeOtherDetails->emp_mname ?? '';
        $EmpLName = $employeeOtherDetails->emp_lname ?? '';
        $EmpID = $employeeOtherDetails->emp_id ?? '';
        $EmpShiftName = $employeeOtherDetails->attendance_shift_name ?? '';
        $EmpShiftStart = RulesManagement::Convert24To12($employeeOtherDetails->shift_start ?? '');
        $EmpShiftEnd = RulesManagement::Convert24To12($employeeOtherDetails->shift_end ?? '');
        $PunchDate = date('d-m-Y', strtotime($request->date));
        $InTime = RulesManagement::Convert24To12($empAttendance->punch_in_time ?? '');
        $OutTime = RulesManagement::Convert24To12($empAttendance->punch_out_time ?? '');

        $data = [
            'emp_id' => $EmpID,
            'name' => $EmpName,
            'mName' => $EmpMName,
            'lName' => $EmpLName,
            'shiftName' => $EmpShiftName,
            'shiftStart' => $EmpShiftStart,
            'shiftEnd' => $EmpShiftEnd,
            'punch_date' => $PunchDate,
            'inTime' => $InTime,
            'outTime' => $OutTime,
        ];


        return response()->json($data);
    }
    public function attendanceSubmitPage()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $submittedData = DB::table('attendance_submit')
            ->where('business_id', Session::get('business_id'))
            ->get();
        return view('admin.attendance.submit_attendance', compact('submittedData', 'permissions'));
    }

    public function createAttendanceSubmit(Request $request)
    {
        $submittedData = DB::table('attendance_submit')
            ->where('business_id', Session::get('business_id'))
            ->where(['month' => $request->month, 'year' => $request->year])
            ->first();


        if (isset($submittedData)) {
            Alert::warning('Data Already Created');
            return back();
        } elseif ($request->month == date('m') && $request->year == date('Y')) {
            Alert::warning('Sorry, Your attendance month cycle has not completed');
            return back();
        }elseif ($request->month > date('m') || $request->year > date('Y')) {
            Alert::warning('Sorry, Your attendance month cycle has not Started');
            return back();
        } else {
            $submittedData = DB::table('attendance_submit')->insert([
                'business_id' => Session::get('business_id'),
                'month' => $request->month,
                'year' => $request->year,
                'created' => date('Y-m-d'),
                'submited' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if (isset($submittedData)) {
                Alert::success('Data Successfully Created');
                return back();
            } else {
                Alert::error('Sorry, You data not created');
                return back();
            }
        }
    }

    public function getAttendanceSubmitData(Request $request)
    {
        $EmployeeDate = [];
        $year = $request->year;
        $month = $request->month;
        $NofDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $NofDay));
        $Employee = DB::table('employee_personal_details')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_date_of_joining', '<=', $date)
            ->where('active_emp', 1)
            ->join('designation_list', 'employee_personal_details.designation_id', 'designation_list.desig_id')
            ->get();

        foreach ($Employee as $key => $value) {
            for ($i = 1; $i <= $NofDay; $i++) {
                $empStatus[$i] = Central_unit::getEmpAttSumm(['emp_id' => $value->emp_id, 'punch_date' => date('Y-m-d', strtotime($year . '-' . $month . '-' . $i))])[0];
            }
            $EmpAttendanceCount = Central_unit::getMonthlyCountFromDB($value->emp_id, $year, $month, Session::get('business_id'));

            $EmployeeDate[$key] = [
                'name' => $value->emp_name . ' ' . $value->emp_mname . ' ' . $value->emp_lname,
                'empId' => $value->emp_id,
                'designation' => $value->desig_name,
                'imgURL' => $value->profile_photo,
                'month' => $month,
                'year' => $year,
                'status' => $empStatus,
                'count' => $EmpAttendanceCount,
            ];
        }
        return response()->json([$NofDay, $EmployeeDate, date('M', mktime(0, 0, 0, $month, 1))]);
    }

    // public function onStatusChangeFunction(Request $request)
    // {
    //     $emp_id = $request->emp;
    //     $day = $request->day;
    //     $month = $request->month;
    //     $year = $request->year;
    //     $value = $request->value;
    //     $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
    //     $punch_date = $date;
    //     $business_id = Session::get('business_id');

    //     $empData = compact('month', 'year', 'emp_id', 'business_id');
    //     $empData1 = compact('date', 'business_id');
    //     $empData2 = compact('punch_date', 'emp_id', 'business_id');
    //     $empData3 = compact('emp_id', 'business_id');

    //     $monthlyCount = DB::table('attendance_monthly_count')->where($empData)->first();
    //     $dailyCount = DB::table('attendance_daily_count')->where($empData1)->first();
    //     $empAttendance = DB::table('attendance_list')->where($empData2)->first();
    //     $empDetails = DB::table('employee_personal_details')->where($empData3)->first();
    //     $shift = $empDetails->assign_shift_type == 2 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();

    //     if ($value == 1) {
    //         $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : '';
    //         if (isset($empAttendance)) {
    //             DB::table('attendance_list')->where($empData2)->update([
    //                 'today_status' => 1,
    //                 'punch_in_time' => $shift->shift_start,
    //                 'punch_out_time' => $shift->shift_end,
    //                 'brack_time' => 0,
    //                 'late_by' => 0,
    //                 'early_exit' => 0,
    //                 'overtime' => 0,
    //                 'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
    //             ]);
    //         } else {
    //             DB::table('attendance_list')->where($empData2)->insert([
    //                 'emp_id' => $emp_id,
    //                 'punch_date' => $date,
    //                 'today_status' => 1,
    //                 'punch_in_time' => ($shift->shift_start ?? 0),
    //                 'punch_out_time' => ($shift->shift_end ?? 0),
    //                 'applied_shift_comp_start_time' => ($shift->shift_start ?? 0),
    //                 'applied_shift_comp_end_time' => ($shift->shift_end ?? 0),
    //                 'brack_time' => $shift->break_min ?? 0,
    //                 'applied_shift_template_name' => $shift->shift_name ?? 'Shift Not Found',
    //                 'late_by' => 0,
    //                 'early_exit' => 0,
    //                 'overtime' => 0,
    //                 'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
    //                 'shift_interval' => ($interval->h ?? 0) * 60 + ($interval->i ?? 0),
    //                 'emp_today_current_status' => 2,
    //                 'business_id' => $business_id,
    //                 'setup_method_id' => $empDetails->master_endgame_id,
    //             ]);
    //         }
    //     } else if ($value == 8) {
    //         $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : '';
    //         $halfIntervalMin = ($interval->h ?? 0) * 60 + ($interval->i ?? 0) / 2;
    //         $outtime = Carbon::parse($shift->shift_end)->subMinutes($halfIntervalMin);

    //         if (isset($empAttendance)) {
    //             DB::table('attendance_list')->where($empData2)->update([
    //                 'today_status' => 8,
    //                 'punch_in_time' => $shift->shift_start,
    //                 'punch_out_time' => $outtime,
    //                 'brack_time' => 0,
    //                 'late_by' => 0,
    //                 'early_exit' => 0,
    //                 'overtime' => 0,
    //                 'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
    //             ]);
    //         } else {
    //             DB::table('attendance_list')->where($empData2)->insert([
    //                 'emp_id' => $emp_id,
    //                 'punch_date' => $date,
    //                 'today_status' => 1,
    //                 'punch_in_time' => ($shift->shift_start ?? 0),
    //                 'punch_out_time' => ($outtime ?? 0),
    //                 'applied_shift_comp_start_time' => ($shift->shift_start ?? 0),
    //                 'applied_shift_comp_end_time' => ($shift->shift_end ?? 0),
    //                 'brack_time' => $shift->break_min ?? 0,
    //                 'applied_shift_template_name' => $shift->shift_name ?? 'Shift Not Found',
    //                 'late_by' => 0,
    //                 'early_exit' => 0,
    //                 'overtime' => 0,
    //                 'total_working_hour' => ($interval->h ?? '00') / 2 . ':' . ($interval->i ?? '00') / 2 . ':00',
    //                 'shift_interval' => ($interval->h ?? 0) * 60 + ($interval->i ?? 0),
    //                 'emp_today_current_status' => 2,
    //                 'business_id' => $business_id,
    //                 'setup_method_id' => $empDetails->master_endgame_id,
    //             ]);
    //         }
    //     }

    //     $updateMonthCount = DB::table('attendance_monthly_count')->where($empData);
    //     if (isset($empAttendance)) {
    //         $prevStatus = $empAttendance->today_status;
    //         if (isset($monthlyCount)) {
    //             if ($prevStatus == 4) {
    //                 $updateMonthCount->update([
    //                     'mispunch' => $monthlyCount->mispunch <= 0 ? 0 : $monthlyCount->mispunch - 1,
    //                     'present' => $value == 1 ? $monthlyCount->present + 1 : $monthlyCount->present,
    //                     'half_day' => $value == 8 ? $monthlyCount->half_day + 1 : $monthlyCount->half_day,
    //                     'absent' => $value == 2 ? $monthlyCount->absent + 1 : $monthlyCount->absent,
    //                 ]);
    //             } else if ($prevStatus == 8) {
    //                 $updateMonthCount->update([
    //                     'present' => $value == 1 ? $monthlyCount->present + 1 : $monthlyCount->present,
    //                     'half_day' => $monthlyCount->half_day <= 0 ? 0 : $monthlyCount->half_day - 1,
    //                     'absent' => $value == 2 ? $monthlyCount->absent + 1 : $monthlyCount->absent,
    //                 ]);
    //             } else if ($prevStatus == 1) {
    //                 $updateMonthCount->update([
    //                     'present' => $monthlyCount->present <= 0 ? 0 : $monthlyCount->present - 1,
    //                     'half_day' => $value == 8 ? $monthlyCount->half_day + 1 : $monthlyCount->half_day,
    //                     'absent' => $value == 2 ? $monthlyCount->absent + 1 : $monthlyCount->absent,
    //                 ]);
    //             } else {
    //                 $updateMonthCount->update([
    //                     'present' => $value == 1 ? $monthlyCount->present + 1 : $monthlyCount->present,
    //                     'half_day' => $value == 8 ? $monthlyCount->half_day + 1 : $monthlyCount->half_day,
    //                     'absent' => $monthlyCount->absent <= 0 ? 0 : $monthlyCount->absent - 1,
    //                 ]);
    //             }
    //         } else {
    //             DB::table('attendance_monthly_count')->where($empData)->insert([
    //                 'present' => $value == 1 ? 1 : 0,
    //                 'half_day' => $value == 8 ? 1 : 0,
    //                 'absent' => $value == 2 ? 1 : 0,
    //                 'business_id' => $business_id,
    //                 'emp_id' => $emp_id,
    //                 'month' => $month,
    //                 'year' => $year,
    //             ]);
    //         }
    //     } else {
    //         if (isset($monthlyCount)) {
    //             $updateMonthCount->update([
    //                 'present' => $value == 1 ? $monthlyCount->present + 1 : $monthlyCount->present,
    //                 'half_day' => $value == 8 ? $monthlyCount->half_day + 1 : $monthlyCount->half_day,
    //                 'absent' => $value == 2 ? $monthlyCount->absent + 1 : ($monthlyCount->absent <= 0 ? 0 : $monthlyCount->absent - 1),
    //             ]);
    //         } else {
    //             DB::table('attendance_monthly_count')->where($empData)->insert([
    //                 'present' => $value == 1 ? 1 : 0,
    //                 'half_day' => $value == 8 ? 1 : 0,
    //                 'absent' => $value == 2 ? 1 : 0,
    //                 'business_id' => $business_id,
    //                 'emp_id' => $emp_id,
    //                 'month' => $month,
    //                 'year' => $year,
    //             ]);
    //         }
    //     }

    //     return response()->json(DB::table('attendance_monthly_count')->where($empData)->first());
    // }

    public function finalAttendanceSubmit(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $pendingAttendance = DB::table('attendance_list')->where('business_id',Session::get('business_id'))->whereMonth('punch_date',$month)->whereYear('punch_date',$year)->where('today_status',4)->get();
        $pendingLeave = DB::table('request_leave_list')->where('business_id',Session::get('business_id'))->whereMonth('from_date',$month)->whereYear('from_date',$year)->where('final_status',0)->get();

        if(isset($pendingAttendance) || isset($pendingLeave)){
            Alert::error('','Kindly Clear Your Attendance Mispunch and Leave Status.');
            return back();
        }
        $holidayList = DB::table('attendance_holiday_list')->where('business_id',Session::get('business_id'))->whereMonth('holiday_date',$month)->whereYear('holiday_date', $year)->update(['process_check'=>1]);
        // dd($holidayList);


        $givenDate = Carbon::create($year, $month, 1);
        $previousMonth = $givenDate->subMonth();

        $previousMonthData = DB::table('attendance_submit')
            ->where('business_id', Session::get('business_id'))
            ->where(['month' => $previousMonth->month, 'year' => $previousMonth->year])
            ->first();
        if ($previousMonthData->submited == 0) {
            Alert::error('Failed', 'Previous month data is not submitted yet.');
            return back();
        }

        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
        $business_id = Session::get('business_id');

        $Employee = DB::table('employee_personal_details')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_date_of_joining', '<=', $date)
            ->join('designation_list', 'employee_personal_details.designation_id', 'designation_list.desig_id')
            ->get();

        foreach ($Employee as $key => $value) {
            $emp_id = $value->emp_id;
            $empData = compact('month', 'year', 'emp_id', 'business_id');
            $empData1 = compact('date', 'business_id');

            // dd($request->get($emp_id));

            $monthlyCount = DB::table('attendance_monthly_count')
                ->where($empData)
                ->first();
            $dailyCount = DB::table('attendance_daily_count')
                ->where($empData1)
                ->first();
            $shift =
                $value->assign_shift_type == 2
                ? DB::table('policy_attendance_shift_type_items')
                    ->where('id', $value->emp_rotational_shift_type_item)
                    ->first()
                : DB::table('policy_attendance_shift_type_items')
                    ->where('attendance_shift_id', $value->emp_shift_type)
                    ->first();

            for ($i = 1; $i <= $day; $i++) {
                // dd($month);
                $status = $request->get($emp_id . $i);
                $punch_date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
                $empData2 = compact('punch_date', 'emp_id', 'business_id');
                $empAttendance = DB::table('attendance_list')
                    ->where($empData2)
                    ->first();

                if ($status == 1) {
                    $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : '';
                    if (isset($empAttendance)) {
                        DB::table('attendance_list')
                            ->where($empData2)
                            ->update([
                                'today_status' => 1,
                                'punch_in_time' => $shift->shift_start,
                                'punch_out_time' => $shift->shift_end,
                                'brack_time' => 0,
                                'late_by' => 0,
                                'early_exit' => 0,
                                'overtime' => 0,
                                'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
                            ]);
                    } else {
                        DB::table('attendance_list')
                            ->where($empData2)
                            ->insert([
                                'emp_id' => $emp_id,
                                'punch_date' => $punch_date,
                                'today_status' => 1,
                                'punch_in_time' => $shift->shift_start ?? 0,
                                'punch_out_time' => $shift->shift_end ?? 0,
                                'applied_shift_comp_start_time' => $shift->shift_start ?? 0,
                                'applied_shift_comp_end_time' => $shift->shift_end ?? 0,
                                'brack_time' => $shift->break_min ?? 0,
                                'applied_shift_template_name' => $shift->shift_name ?? 'Shift Not Found',
                                'late_by' => 0,
                                'early_exit' => 0,
                                'overtime' => 0,
                                'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
                                'shift_interval' => ($interval->h ?? 0) * 60 + ($interval->i ?? 0),
                                'emp_today_current_status' => 2,
                                'business_id' => $business_id,
                                'setup_method_id' => $value->master_endgame_id,
                            ]);
                    }
                } elseif ($status == 8) {
                    $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : '';
                    $halfIntervalMin = ($interval->h ?? 0) * 60 + ($interval->i ?? 0) / 2;
                    $outtime = Carbon::parse($shift->shift_end)->subMinutes($halfIntervalMin);

                    if (isset($empAttendance)) {
                        DB::table('attendance_list')
                            ->where($empData2)
                            ->update([
                                'today_status' => 8,
                                'punch_in_time' => $shift->shift_start,
                                'punch_out_time' => $outtime,
                                'brack_time' => 0,
                                'late_by' => 0,
                                'early_exit' => 0,
                                'overtime' => 0,
                                'total_working_hour' => ($interval->h ?? '00') . ':' . ($interval->i ?? '00') . ':00',
                            ]);
                    } else {
                        DB::table('attendance_list')
                            ->where($empData2)
                            ->insert([
                                'emp_id' => $emp_id,
                                'punch_date' => $punch_date,
                                'today_status' => 1,
                                'punch_in_time' => $shift->shift_start ?? 0,
                                'punch_out_time' => $outtime ?? 0,
                                'applied_shift_comp_start_time' => $shift->shift_start ?? 0,
                                'applied_shift_comp_end_time' => $shift->shift_end ?? 0,
                                'brack_time' => $shift->break_min ?? 0,
                                'applied_shift_template_name' => $shift->shift_name ?? 'Shift Not Found',
                                'late_by' => 0,
                                'early_exit' => 0,
                                'overtime' => 0,
                                'total_working_hour' => ($interval->h ?? '00') / 2 . ':' . ($interval->i ?? '00') / 2 . ':00',
                                'shift_interval' => ($interval->h ?? 0) * 60 + ($interval->i ?? 0),
                                'emp_today_current_status' => 2,
                                'business_id' => $business_id,
                                'setup_method_id' => $value->master_endgame_id,
                            ]);
                    }
                }
            }

            $updateMonthCount = DB::table('attendance_monthly_count')->where($empData);

            if (isset($monthlyCount)) {
                // dd($monthlyCount);
                $updateMonthCount->update([
                    'present' => $request->get($emp_id)['present'] ?? 0,
                    'absent' => $request->get($emp_id)['absent'] ?? 0,
                    'late' => 0,
                    'early_exit' => 0,
                    'mispunch' => $request->get($emp_id)['mispunch'] ?? 0,
                    'holiday' => $request->get($emp_id)['holiday'] ?? 0,
                    'week_off' => $request->get($emp_id)['weekoff'] ?? 0,
                    'half_day' => $request->get($emp_id)['halfday'] ?? 0,
                    'overtime' => $request->get($emp_id)['overtime'] ?? 0,
                    'leave' => $request->get($emp_id)['leave'] ?? 0,
                ]);
            } else {
                DB::table('attendance_monthly_count')->insert([
                    'business_id' => Session::get('business_id'),
                    'emp_id' => $value->emp_id,
                    'month' => $month,
                    'year' => $year,
                    'present' => $request->get($emp_id)['present'],
                    'absent' => $request->get($emp_id)['absent'],
                    'late' => 0,
                    'early_exit' => 0,
                    'mispunch' => $request->get($emp_id)['mispunch'],
                    'holiday' => $request->get($emp_id)['holiday'],
                    'week_off' => $request->get($emp_id)['weekoff'],
                    'half_day' => $request->get($emp_id)['halfday'],
                    'overtime' => $request->get($emp_id)['overtime'],
                    'leave' => $request->get($emp_id)['leave'],
                ]);
            }
        }

        // $EmpID = Session::get('login_emp_id');
        // $FindRoleID = Session::get('login_role');
        // $BID = Session::get('business_id');
        // $approval_status_list = DB::table('approval_status_list')->insert(['applied_cycle_type' => 2, 'business_id' => $BID, 'approval_type_id' => 1, 'all_request_id' => $PID, 'role_id' => $FindRoleID, 'emp_id' => $EmpID, 'status' => $status]);

        $submittedData = DB::table('attendance_submit')
            ->where('business_id', Session::get('business_id'))
            ->where(['month' => $request->month, 'year' => $request->year])
            ->update(['submited' => 1]);
        if (isset($submittedData)) {
            Alert::success('Submitted Successfully');
        } else {
            Alert::error('Failed');
        }
        return redirect('admin/attendance/submit-attendance');
    }

    public function correctAttendanceTiming(Request $request)
    {
        // $calculation = Central_unit::getEmpAttSummaryApi(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d', strtotime($request->punch_date)), 'emp_id' => $request->emp_id]);


        $month = date('m', strtotime($request->punch_date));
        $year = date('Y', strtotime($request->punch_date));
        $is_submitted = DB::table('attendance_submit')->where(['business_id' => Session::get('business_id'), 'month' => $month, 'year' => $year, 'submited' => 1])->first();

        if (isset($is_submitted)) {
            Alert::error('', 'Can not change attendance,Selected month attendance already submitted');
            return back();
        }

        $in_time = RulesManagement::Convert12To24($request->in_time);
        $out_time = RulesManagement::Convert12To24($request->out_time);

        $roleId = Session::get('login_role');
        $email = Session::get('email');
        $roleName = Session::get('user_type');
        $changerName = Session::get('login_name');
        $changerEmpId = Session::get('login_emp_id') ?? 'N/A';

        $attndanceDetails = DB::table('attendance_list')->where(['business_id' => Session::get('business_id'), 'emp_id' => $request->emp_id, 'punch_date' => date('Y-m-d', strtotime($request->punch_date))])->first();
        $approvalCycle = DB::table('approval_management_cycle')->where(['business_id' => Session::get('business_id'), 'cycle_type' => 1])->first();
        $total_work = Carbon::parse($in_time)->diff(Carbon::parse($out_time));
        $monthlyCount = DB::table('attendance_monthly_count')->where('emp_id', $request->emp_id)->where(['month' => date('m', strtotime($request->punch_date)), 'year' => date('Y', strtotime($request->punch_date)), 'business_id' => Session::get('business_id')])->first();
        $dailyCount = DB::table('attendance_daily_count')->where(['business_id' => Session::get('business_id'), 'date' => date('Y-m-d', strtotime($request->punch_date))])->first();


        // dd($request->emp_id);
        $empDetails = DB::table('employee_personal_details')->where(['business_id' => Session::get('business_id'), 'emp_id' => $request->emp_id])->first();
        $shift = $empDetails->assign_shift_type == 2 && $empDetails->assign_shift_type != 0 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();
        $interval = ($shift->shift_start ?? 0) != 0 && ($shift->shift_end ?? 0) != 0 ? Carbon::parse($shift->shift_start)->diff(Carbon::parse($shift->shift_end)) : 'N/A';
        $shiftInterval = ($interval->h ?? 0)*60 + $interval->i ?? 0;
        // dd($interval);
        if ($attndanceDetails != null) {
            $prev_status = $attndanceDetails->today_status;

            if (isset($monthlyCount)) {
                DB::table('attendance_monthly_count')
                    ->where('emp_id', $request->emp_id)
                    ->where(['month' => date('m', strtotime($request->punch_date)), 'year' => date('Y', strtotime($request->punch_date)), 'business_id' => Session::get('business_id')])
                    ->update([
                        'present' => $prev_status == 1 ? $monthlyCount->present - 1 : $monthlyCount->present,
                        'absent' => $prev_status == 2 ? $monthlyCount->absent - 1 : $monthlyCount->absent,
                        'late' => $prev_status == 3 ? $monthlyCount->late - 1 : $monthlyCount->late,
                        'early_exit' => $prev_status == 12 ? $monthlyCount->early_exit - 1 : $monthlyCount->early_exit,
                        'mispunch' => $prev_status == 4 ? $monthlyCount->mispunch - 1 : $monthlyCount->mispunch,
                        'holiday' => $prev_status == 6 ? $monthlyCount->holiday - 1 : $monthlyCount->holiday,
                        'week_off' => $prev_status == 7 ? $monthlyCount->week_off - 1 : $monthlyCount->week_off,
                        'half_day' => $prev_status == 8 ? $monthlyCount->half_day - 1 : $monthlyCount->half_day,
                        'overtime' => $prev_status == 9 ? $monthlyCount->overtime - 1 : $monthlyCount->overtime,
                        'leave' => $prev_status == 10 || $prev_status == 11 ? $monthlyCount->leave - 1 : $monthlyCount->leave,
                    ]);
            }

            if (isset($dailyCount)) {
                DB::table('attendance_daily_count')->where(['business_id' => Session::get('business_id'), 'date' => date('Y-m-d', strtotime($request->punch_date))])->update([
                    'present' => $prev_status == 1 ? $dailyCount->present - 1 : $dailyCount->present,
                    'absent' => $prev_status == 2 ? $dailyCount->absent - 1 : $dailyCount->absent,
                    'late' => $prev_status == 3 ? $dailyCount->late - 1 : $dailyCount->late,
                    'early' => $prev_status == 12 ? $dailyCount->early - 1 : $dailyCount->early,
                    'mispunch' => $prev_status == 4 ? $dailyCount->mispunch - 1 : $dailyCount->mispunch,
                    'halfday' => $prev_status == 8 ? $dailyCount->halfday - 1 : $dailyCount->halfday,
                    'overtime' => $prev_status == 9 ? $dailyCount->overtime - 1 : $dailyCount->overtime,
                    'leave' => $prev_status == 10 || $prev_status == 11 ? $dailyCount->leave - 1 : $dailyCount->leave,
                ]);
            }
        } else {
            if (isset($monthlyCount)) {
                DB::table('attendance_monthly_count')
                    ->where('emp_id', $request->emp_id)
                    ->where(['month' => date('m', strtotime($request->punch_date)), 'year' => date('Y', strtotime($request->punch_date)), 'business_id' => Session::get('business_id')])
                    ->update([
                        'present' => $monthlyCount->present,
                        'absent' => $monthlyCount->absent <= 0 ? $monthlyCount->absent - 1 : 0,
                        'late' => $monthlyCount->late,
                        'early_exit' => $monthlyCount->early_exit,
                        'mispunch' => $monthlyCount->mispunch,
                        'holiday' => $monthlyCount->holiday,
                        'week_off' => $monthlyCount->week_off,
                        'half_day' => $monthlyCount->half_day,
                        'overtime' => $monthlyCount->overtime,
                        'leave' => $monthlyCount->leave,
                    ]);
            }

            if (isset($dailyCount)) {
                DB::table('attendance_daily_count')->where(['business_id' => Session::get('business_id'), 'date' => date('Y-m-d', strtotime($request->punch_date))])->update([
                    'present' => $dailyCount->present,
                    'absent' => $dailyCount->absent - 1,
                    'late' => $dailyCount->late,
                    'early' => $dailyCount->early,
                    'mispunch' => $dailyCount->mispunch,
                    'halfday' => $dailyCount->halfday,
                    'overtime' => $dailyCount->overtime,
                    'leave' => $dailyCount->leave,
                ]);
            }
        }

        $createLog = DB::table('attendance_time_log')->insert([
            'business_id' => Session::get('business_id'),
            'emp_id' => $request->emp_id,
            'change_date' => date('Y-m-d'),
            'punch_date' => date('Y-m-d', strtotime($request->punch_date)),
            'prev_in_time' => $attndanceDetails ? date('h:i:s',strtotime($attndanceDetails->punch_in_time)) : '00:00:00',
            'changed_in_time' => $in_time,
            'prev_out_time' => $attndanceDetails ? date('h:i:s',strtotime($attndanceDetails->punch_out_time)) : '00:00:00',
            'changed_out_time' => $out_time,
            'prev_total_work' => $attndanceDetails ? date('h:i:s',strtotime($attndanceDetails->total_working_hour)) : '00:00:00',
            'changed_total_work' => $total_work != null ? date('h:i:s',strtotime($total_work->h . ':' . $total_work->i)) : '00:00:00',
            'reason' => $request->reason,
            'changed_by' => $roleId,
            'changer_emp_id' => $changerEmpId,
            'changer_role' => $roleName,
            'changer_name' => $changerName,
        ]);

        $newAttendanceData = DB::table('attendance_list')->insert([
            'today_status' => $attndanceDetails ? $attndanceDetails->today_status : 1,
            'emp_id' => $attndanceDetails ? $attndanceDetails->emp_id : $request->emp_id,
            'punch_date' => $attndanceDetails ? $attndanceDetails->punch_date : date('Y-m-d', strtotime($request->punch_date)),
            'overtime' => $attndanceDetails ? $attndanceDetails->overtime : 0,
            'late_by' => $attndanceDetails ? $attndanceDetails->late_by : 0,
            'early_exit' => $attndanceDetails ? $attndanceDetails->early_exit : 0,
            'total_working_hour' => $total_work != null ? date('h:i:s',strtotime($total_work->h . ':' . $total_work->i)) : '00:00:00',
            'shift_interval' => $attndanceDetails ? $attndanceDetails->shift_interval : $shiftInterval,
            'setup_method_id' => $attndanceDetails ? $attndanceDetails->setup_method_id : ($empDetails != null ? $empDetails->master_endgame_id : null),
            'setup_method_name' => $attndanceDetails ? $attndanceDetails->setup_method_name : null,
            'working_from_method' => $attndanceDetails ? $attndanceDetails->working_from_method : ($empDetails != null ? $empDetails->emp_attendance_method : null),
            'method_auto' => $attndanceDetails ? $attndanceDetails->method_auto : 0,
            'method_manual' => $attndanceDetails ? $attndanceDetails->method_manual : 1,
            'marked_in_mode' => $attndanceDetails ? $attndanceDetails->marked_in_mode : 0,
            'active_qr_mode' => $attndanceDetails ? $attndanceDetails->active_qr_mode : 0,
            'marked_out_mode' => $attndanceDetails ? $attndanceDetails->marked_out_mode : 0,
            'active_selfie_mode' => $attndanceDetails ? $attndanceDetails->active_selfie_mode : 1,
            'active_face_mode' => $attndanceDetails ? $attndanceDetails->active_face_mode : 0,
            'active_location_tab_mode' => $attndanceDetails ? $attndanceDetails->active_location_tab_mode : 0,
            'attendance_shift' => $attndanceDetails ? $attndanceDetails->attendance_shift : ($empDetails != null ? $empDetails->emp_attendance_method : null),
            'applied_shift_template_name' => $attndanceDetails ? $attndanceDetails->applied_shift_template_name : null,
            'applied_shift_type_name' => $attndanceDetails ? $attndanceDetails->applied_shift_type_name : null,
            'applied_shift_comp_start_time' => $attndanceDetails ? $attndanceDetails->applied_shift_comp_start_time : ($shift != null ? $shift->shift_start : null),
            'applied_shift_comp_end_time' => $attndanceDetails ? $attndanceDetails->applied_shift_comp_end_time : ($shift != null ? $shift->shift_end : null),
            'brack_time' => $attndanceDetails ? $attndanceDetails->brack_time : ($shift != null ? $shift->break_min : null),
            'brack_paid_check' => $attndanceDetails ? $attndanceDetails->brack_paid_check : ($shift != null ? $shift->is_paid : null),
            'punch_in_shift_name' => $attndanceDetails ? $attndanceDetails->punch_in_shift_name : null,
            'punch_out_shift_name' => $attndanceDetails ? $attndanceDetails->punch_out_shift_name : null,
            'business_id' => $attndanceDetails ? $attndanceDetails->business_id : Session::get('business_id'),
            'branch_id' => $attndanceDetails ? $attndanceDetails->branch_id : Session::get('branch_id'),
            'emp_today_current_status' => isset($in_time) && isset($out_time) ? 2 : $attndanceDetails->emp_today_current_status,
            'punch_in_selfie' => $attndanceDetails ? $attndanceDetails->punch_in_selfie : ($empDetails != null ? $empDetails->profile_photo : null),
            'punch_in_time' => $in_time,
            'punch_in_location_tag' => $attndanceDetails ? $attndanceDetails->punch_in_location_tag : null,
            'punch_in_address' => $attndanceDetails ? $attndanceDetails->punch_in_address : null,
            'punch_in_latitude' => $attndanceDetails ? $attndanceDetails->punch_in_latitude : null,
            'punch_in_longitude' => $attndanceDetails ? $attndanceDetails->punch_in_longitude : null,
            'punch_out_selfie' => $attndanceDetails ? $attndanceDetails->punch_out_selfie : ($empDetails != null ? $empDetails->profile_photo : null),
            'punch_out_time' => $out_time,
            'punch_out_address' => $attndanceDetails ? $attndanceDetails->punch_out_address : null,
            'punch_out_latitude' => $attndanceDetails ? $attndanceDetails->punch_out_latitude : null,
            'punch_out_longitude' => $attndanceDetails ? $attndanceDetails->punch_out_longitude : null,
            'punch_out_location_tag' => $attndanceDetails ? $attndanceDetails->punch_out_location_tag : null,
            'approved_by_role_id' => $attndanceDetails ? $attndanceDetails->approved_by_role_id : 0,
            'approved_by_emp_id' => null,
            'forward_by_role_id' => $approvalCycle != null ? json_decode($approvalCycle->role_id)[count(json_decode($approvalCycle->role_id)) - 1] : 0,
            'forward_by_status' => $attndanceDetails ? $attndanceDetails->today_status : 0,
            'final_level_role_id' => $approvalCycle != null ? json_decode($approvalCycle->role_id)[0] : 0,
            'final_status' => 0,
            'process_complete' =>  0,
        ]);

        $delete_prev_attendance = isset($attndanceDetails) ? DB::table('attendance_list')->where('id', $attndanceDetails->id)->delete() : true;
        $calculation = Central_unit::getEmpAttSummaryApi(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d', strtotime($request->punch_date)), 'emp_id' => $request->emp_id]);
        // dd($calculation);
        $updatedAttendanceData = DB::table('attendance_list')
            ->where(['business_id' => Session::get('business_id'), 'emp_id' => $request->emp_id, 'punch_date' => date('Y-m-d', strtotime($request->punch_date))])
            ->update([
                'today_status' => $calculation ? $calculation[0] : 0,
                'overtime' => $calculation ? $calculation[8] : 0,
                'late_by' => $calculation ? $calculation[12] : 0,
                'early_exit' => $calculation ? $calculation[13] : 0,
            ]);


        if (isset($monthlyCount)) {
            DB::table('attendance_monthly_count')
                ->where('emp_id', $request->emp_id)
                ->where(['month' => date('m', strtotime($request->punch_date)), 'year' => date('Y', strtotime($request->punch_date)), 'business_id' => Session::get('business_id')])
                ->update([
                    'present' => $calculation[0] == 1 ? $monthlyCount->present + 1 : $monthlyCount->present,
                    'absent' => $calculation[0] == 2 ? $monthlyCount->absent + 1 : $monthlyCount->absent,
                    'late' => $calculation[0] == 3 ? $monthlyCount->late + 1 : $monthlyCount->late,
                    'early_exit' => $calculation[0] == 12 ? $monthlyCount->early_exit + 1 : $monthlyCount->early_exit,
                    'mispunch' => $calculation[0] == 4 ? $monthlyCount->mispunch + 1 : $monthlyCount->mispunch,
                    'holiday' => $calculation[0] == 6 ? $monthlyCount->holiday + 1 : $monthlyCount->holiday,
                    'week_off' => $calculation[0] == 7 ? $monthlyCount->week_off + 1 : $monthlyCount->week_off,
                    'half_day' => $calculation[0] == 8 ? $monthlyCount->half_day + 1 : $monthlyCount->half_day,
                    'overtime' => $calculation[0] == 9 ? $monthlyCount->overtime + 1 : $monthlyCount->overtime,
                    'leave' => $calculation[0] == 10 || $calculation[0] == 11 ? $monthlyCount->leave + 1 : $monthlyCount->leave,
                ]);
        } else {
            DB::table('attendance_monthly_count')->insert([
                'business_id' => Session::get('business_id'),
                'emp_id' => $request->emp_id,
                'month' => $month,
                'year' => $year,
                'present' => $calculation[0] == 1 ? 1 : 0,
                'absent' => $calculation[0] == 2 ? 1 : 0,
                'late' => $calculation[0] == 3 ? 1 : 0,
                'early_exit' => $calculation[0] == 12 ? 1 : 0,
                'mispunch' => $calculation[0] == 4 ? 1 : 0,
                'holiday' => $calculation[0] == 6 ? 1 : 0,
                'week_off' => $calculation[0] == 7 ? 1 : 0,
                'half_day' => $calculation[0] == 8 ? 1 : 0,
                'overtime' => $calculation[0] == 9 ? 1 : 0,
                'leave' => $calculation[0] == 10 || $calculation[0] == 11 ? 1 : 0,
            ]);
        }


        if (isset($dailyCount)) {
            DB::table('attendance_daily_count')->where(['business_id' => Session::get('business_id'), 'date' => date('Y-m-d', strtotime($request->punch_date))])->update([
                'present' => $calculation[0] == 1 ? $dailyCount->present + 1 : $dailyCount->present,
                'absent' => $calculation[0] == 2 ? $dailyCount->absent + 1 : $dailyCount->absent,
                'late' => $calculation[0] == 3 ? $dailyCount->late + 1 : $dailyCount->late,
                'early' => $calculation[0] == 12 ? $dailyCount->early + 1 : $dailyCount->early,
                'mispunch' => $calculation[0] == 4 ? $dailyCount->mispunch + 1 : $dailyCount->mispunch,
                'halfday' => $calculation[0] == 8 ? $dailyCount->halfday + 1 : $dailyCount->halfday,
                'overtime' => $calculation[0] == 9 ? $dailyCount->overtime + 1 : $dailyCount->overtime,
                'leave' => $calculation[0] == 10 || $calculation[0] == 11 ? $dailyCount->leave + 1 : $dailyCount->leave,
            ]);
        } else {
            DB::table('attendance_daily_count')->insert([
                'business_id' => Session::get('business_id'),
                'date' => date('Y-m-d', strtotime($request->punch_date)),
                'present' => $calculation[0] == 1 ? 1 : 0,
                'absent' => $calculation[0] == 2 ? 1 : 0,
                'late' => $calculation[0] == 3 ? 1 : 0,
                'early' => $calculation[0] == 12 ? 1 : 0,
                'mispunch' => $calculation[0] == 4 ? 1 : 0,
                'halfday' => $calculation[0] == 8 ? 1 : 0,
                'overtime' => $calculation[0] == 9 ? 1 : 0,
                'leave' => $calculation[0] == 10 || $calculation[0] == 11 ? 1 : 0,
            ]);
        }

        Central_unit::MyCountForMonth($request->emp_id, date('Y-m-d', strtotime($request->punch_date)), Session::get('business_id'));
        Central_unit::MyCountForDaily(date('Y-m-d', strtotime($request->punch_date)), Session::get('business_id'));

        if (isset($createLog) && isset($newAttendanceData) && isset($delete_prev_attendance) && $calculation && isset($updatedAttendanceData)) {
            Alert::success('','Attendance Data has been Successfully Changed');
        } else {
            Alert::error('','Failed to change');
        }

        return back();
    }
}
