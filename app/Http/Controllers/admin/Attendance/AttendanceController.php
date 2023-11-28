<?php

namespace App\Http\Controllers\admin\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Helpers\Central_unit;
use App\Models\admin\setupsettings\MasterEndGameModel;

use Illuminate\Support\Facades\Route;
use App\Helpers\MasterRulesManagement\RulesManagement;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;

// models 
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyMasterEndgameMethod;
// use Alert;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $now = date('Y-m-d');
        // dd($now);

        $lateEntry = PolicyAttenRuleLateEntry::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();

        $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();
        $earlyTime = ($earlyExit->mark_half_day_hr??0) * 60 + ($earlyExit->mark_half_day_min??0);
        $hours1 = floor($earlyTime / 60);
        $minutes1 = $earlyTime % 60; 
        $earlyExitTime = gmdate('H:i', $hours1 * 3600 + $minutes1 * 60);
        $lateTime = ($lateEntry->mark_half_day_hr??0) * 60 + ($lateEntry->mark_half_day_min??0);
        // Calculate hours and minutes
        $hours = floor($lateTime / 60);
        $minutes = $lateTime % 60;

        // Format as hh:mm
        $formattedTime = gmdate('H:i', $hours * 3600 + $minutes * 60);
        $fullLate = $lateTime * 60;
        // dd($formattedTime);
        $halfDayThreshold = 240; // Threshold for a half-day in minutes (4 hours)
        $currentDate = Carbon::now();


        $halfDayCount = AttendanceList::join('policy_attendance_shift_type_items', 'attendance_list.attendance_shift', '=', 'policy_attendance_shift_type_items.id')
            ->join('policy_atten_rule_late_entry', 'attendance_list.business_id', '=', 'policy_atten_rule_late_entry.business_id')
            ->where('policy_atten_rule_late_entry.switch_is', '1')
            ->where(function ($query) use ($halfDayThreshold, $formattedTime, $earlyExitTime) {
                // Case 1: Late Entry
                $query->orWhere(function ($query) use ($halfDayThreshold, $formattedTime) {
                    $query->whereRaw('TIMEDIFF(punch_in_time, policy_attendance_shift_type_items.shift_start) > 0')
                        ->whereRaw("TIMEDIFF(punch_in_time, policy_attendance_shift_type_items.shift_start) >= '$formattedTime'");
                });

                // Case 2: Early Exit
                $query->orWhere(function ($query) use ($halfDayThreshold, $earlyExitTime) {
                    $query->whereRaw('TIMEDIFF(policy_attendance_shift_type_items.shift_end,  punch_out_time) > 0')
                        ->whereRaw("TIMEDIFF(policy_attendance_shift_type_items.shift_end, punch_out_time) >= '$earlyExitTime'")
                        ->where('attendance_list.emp_today_current_status', '2');
                });

                // // Case 3: Occurrence = 1
                // $query->orWhere(function($query) {
                //     $query->where('occurrence', 1)
                //         ->whereRaw("HOUR(real_punch_in_time) >= 4");
                // });
    
                // // Case 4: Occurrence = 2
                // $query->orWhere(function($query) use ($halfDayThreshold) {
                //     $query->where('occurrence', 2)
                //         ->where(function($query) use ($halfDayThreshold) {
                //             $query->whereRaw("TIMEDIFF(real_punch_in_time, shift_punch_time) > 0")
                //                 ->orWhereRaw("TIMEDIFF(real_punch_out_time, shift_punch_out_time) > 0");
                //         });
                // });
            })
            // ->where('attendance_list.punch_date', $currentDate->toDateString())
            ->where('attendance_list.punch_date', $now)

            ->select('attendance_list.*', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end')
            ->get();


        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // session()->forget('custom_success_message');
        $distinctPunchDates = AttendanceList::where('attendance_status', '0')
            ->select('punch_date', 'attendance_status')
            ->distinct()
            ->pluck('punch_date');
        // dd($distinctPunchDates);
        $approvalPendingCount = count($distinctPunchDates);

        $pendingApproval = AttendanceList::get();
        $DATA = AttendanceList::join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->join('policy_atten_rule_late_entry', 'attendance_list.business_id', '=', 'policy_atten_rule_late_entry.business_id')
            ->join('policy_atten_rule_break', 'attendance_list.business_id', '=', 'policy_atten_rule_break.business_id')
            ->join('policy_attendance_shift_type_items', 'attendance_list.attendance_shift', '=', 'policy_attendance_shift_type_items.id')
            ->join('static_attendance_mode', 'static_attendance_mode.id', '=', 'attendance_list.marked_in_mode', )
            // // ->whereRaw('JSON_CONTAINS(policy_master_endgame_method.shift_settings_ids_list, JSON_QUOTE(employee_personal_details.emp_shift_type))')   // master endgamm json data check
            ->where('policy_atten_rule_late_entry.switch_is', 1)
            ->where('attendance_list.punch_date', date('Y-m-d'))
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('attendance_list.*', 'static_attendance_mode.mode_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end', 'static_attendance_methods.method_name', 'policy_atten_rule_late_entry.grace_time_min', 'policy_atten_rule_late_entry.grace_time_hr', 'policy_atten_rule_break.break_extra_hr', 'policy_atten_rule_break.break_extra_min', 'policy_attendance_shift_type_items.break_min')
            ->orderBy('attendance_list.id', 'desc')
            ->get();
        // dd($DATA);
        $data = [
            'labels' => ['Work', 'Break', 'Meetings'],
            'data' => [40, 20, 10],
            // Example data in hours
        ];
        $root = compact('moduleName', 'permissions', 'DATA', 'data', 'approvalPendingCount');
        return view('admin.attendance.attendance', $root);
    }

    // ********************************** Start of Attendance Ajax Response By Aman ******************************


    public function AttendanceByAjaxFilter(Request $request){
        $month = $request->month;
        $year = $request->year;
        $empId = $request->emp_id;

        $byAttendanceCalculation = Central_unit::attendanceByEmpDetails($empId, $year, $month);
        $allStatusCount = Central_unit::attendanceCount($empId, $year, $month);
        $getLeave = Central_unit::getEmpAttSumm(['emp_id' => $empId, 'punch_date' => date($year.'-'.$month.'-'.'d')]);
        return response()->json([$byAttendanceCalculation,$allStatusCount,$getLeave]);
    }

    public function dashboardAttendanceCountFilter(Request $request)
    {
        $resDate = $request->date;
        $monthAbbreviations = [
            'Okt' => 'Oct',
            'Maj' => 'May',
            // Add more month abbreviations as needed
        ];
        $engDate = str_replace(array_keys($monthAbbreviations), array_values($monthAbbreviations), $resDate);

        $date = date('Y-m-d', strtotime($engDate));
        $responseData = Central_unit::GetCount($date);
        return response()->json($responseData);

    }
    public function allAttendanceCalculationAjax(Request $request)
    {
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();
        $month = $request->month;
        $year = $request->year;
        $data = [];
        foreach ($Emp as $key => $emp) {
            $resCode = Central_unit::attendanceCount($emp->emp_id, $year, $month);
            $data[$emp->emp_id] = $resCode;
        }
        return response()->json([$Emp, $data]);
    }

    public function monthlyAtendanceAjax(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->department_id;
        $designationId = $request->designation_id;
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');
        $Emp = EmployeePersonalDetail::when($branchId, function ($query) use ($branchId) {
            $query->where('employee_personal_details.branch_id', $branchId);
        })->when($departmentId, function ($query) use ($departmentId) {
            $query->where('employee_personal_details.department_id', $departmentId);
        })->when($designationId, function ($query) use ($designationId) {
            $query->where('employee_personal_details.designation_id', $designationId);
        })->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('employee_personal_details.business_id', Session()->get('business_id'))
            ->get();

        $status = [];

        foreach ($Emp as $key => $emp) {
            $day = 0;
            $EmpID = $emp->emp_id;
            // Create an array to store the status for this employee
            $status[$EmpID] = [];

            while ($day++ < date('t')) {
                $res = Central_unit::getEmpAttSumm(['emp_id' => $EmpID, 'punch_date' => date($year.'-'.$month.'-'.$day)]);

                // Store the status for this day in the employee's array
                $status[$EmpID][] = $res[0];
            }
        }



        return response()->json([$Emp, $status]);
    }

    // ********************************** End of Attendance Ajax Response By Aman ******************************

    public function attendanceSummary()
    {
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            ->get();
        return view('admin.attendance.summary', compact('Emp'));
    }

    public function attendanceMark(Request $request)
    {
        // dd($request->all());
        $load = RulesManagement::RoleDetailsGet();
        $call = RulesManagement::PassBy();
        $AdminRoleId = $load[0];
        // dd($AdminRoleId);
        $EmpId = $call[2];
        if ($request->has('approveAll') && ($AdminRoleId != null && $EmpId != null)) {

            foreach ($request->checkbox as $key => $value) {
                $roatationalShift = AttendanceList::where('business_id', Session::get('business_id'))
                    ->where('id', $request->checkbox[$key])
                    ->where('attendance_status', 0)
                    ->update([
                        'approved_by_role_id' => $AdminRoleId,
                        'approved_by_emp_id' => $EmpId,
                        'attendance_status' => 1
                    ]);
            }
            Alert::success('Items updated successfully');
        } else if ($request->has('pendingAll') && ($AdminRoleId != null && $EmpId != null)) {
            $rooted = AttendanceList::where('business_id', Session::get('business_id'))
                ->where('attendance_status', 0)
                ->update([
                    'approved_by_role_id' => $AdminRoleId,
                    'approved_by_emp_id' => $EmpId,
                    'attendance_status' => 1
                ]);
            Alert::success('Items updated successfully');
        } else {
            Alert::warning('Not updated successfully');
        }
        // dd($request->all());
        //     print_r($request->checkbox[$key]);
        //     // print_r($request->id[$key]);
        //     // ->where('emp_id', $request->emp_id[$key])

        // //     //     echo $request->id[$key] . ' ' . "<br>";
        // //     //     echo $request->emp_id[$key] . ' ' . "<br>";
        // //     //     echo $request->myAttendanceCheck[$key] . ' ' . "<br>";

        // }

        return back();
    }




    public function attendanceUpdate(Request $request)
    {
        // dd($request->editPunchInTime);

        $punchInTimes = strtotime($request->editPunchInTime);
        // dd($punchInTimes);
        $punchOutTimes = strtotime($request->editPunchOutTime);
        $totalWorkingSeconds = $punchOutTimes - $punchInTimes;
        $totalWorkingTimestamp = strtotime('midnight') + $totalWorkingSeconds;

        // dd($totalWorkingTimestamp);
        $totalWorking = date('H:i:s', $totalWorkingTimestamp);
        // dd($totalWorkingTimestamp);
        // dd($totalWorking);
        // $punchInTime = $request->editPunchInTime;
        // $punchOutTime = $request->editPunchOutTime;
        $atteUpdate = AttendanceList::where('id', $request->Updateid)
            ->where('business_id', Session::get('business_id'))
            ->update(['punch_in_time' => $request->editPunchInTime, 'punch_out_time' => $request->editPunchOutTime, 'total_working_hour' => $totalWorking, 'attendance_status' => 1]);
        if ($atteUpdate) {
            Alert::success('Attendacne Request has been Approve Successfully');
        } else {
            Alert::error('Attendacne Request has not been Approve Successfully');
        }
        return redirect()->to('admin/attendance');
    }

    public function attendanceListFilter(Request $request)
    {
        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $dateSelectValue = $request->input('date_select_value') ? $request->input('date_select_value') : date('Y-m-d');
        $currentDate = Carbon::now();
        $filteredData = AttendanceList::join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->join('policy_atten_rule_late_entry', 'attendance_list.business_id', '=', 'policy_atten_rule_late_entry.business_id')
            ->join('policy_atten_rule_break', 'attendance_list.business_id', '=', 'policy_atten_rule_break.business_id')
            ->join('policy_attendance_shift_type_items', 'attendance_list.attendance_shift', '=', 'policy_attendance_shift_type_items.id')
            ->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('policy_attendance_shift_type_items.is_active', 1)
            ->where('policy_atten_rule_late_entry.switch_is', 1)
            ->where('attendance_list.punch_date', isset($dateSelectValue) ? $dateSelectValue : date('Y-m-d'))
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->join('branch_list', 'attendance_list.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('attendance_list.branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->when($dateSelectValue, function ($query) use ($dateSelectValue) {
                $query->where('attendance_list.punch_date', $dateSelectValue);
            })
            ->select('attendance_list.*', 'employee_personal_details.emp_name', 'designation_list.desig_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end', 'static_attendance_methods.method_name', 'policy_atten_rule_late_entry.grace_time_min', 'policy_atten_rule_late_entry.grace_time_hr', 'policy_atten_rule_break.break_extra_hr', 'policy_atten_rule_break.break_extra_min', 'policy_attendance_shift_type_items.break_min')
            ->orderBy('attendance_list.id', 'desc')
            ->get();

        // $filteredData = DB::table('attendance_list')
        //     ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->join('branch_list', 'attendance_list.branch_id', '=', 'branch_list.branch_id')
        //     ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
        //     ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        //     ->where('attendance_list.business_id', Session::get('business_id'))
        //     ->when($branchId, function ($query) use ($branchId) {
        //         $query->where('attendance_list.branch_id', $branchId);
        //     })
        //     ->when($departmentId, function ($query) use ($departmentId) {
        //         $query->where('employee_personal_details.department_id', $departmentId);
        //     })
        //     ->when($designationId, function ($query) use ($designationId) {
        //         $query->where('employee_personal_details.designation_id', $designationId);
        //     })
        //     // ->select('attendance_list.*', 'branch_list.branch_name', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'employee_personal_details.profile_photo', 'department_list.depart_name', 'designation_list.desig_name', 'attendance_shift_type.name', 'policy_attendance_shift_type_items.shift_start')

        //     ->select('attendance_list.*', 'employee_personal_details.department_id', 'employee_personal_details.designation_id', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name')
        //     ->get();

        // Return the filtered data as JSON response
        return response()->json(['get' => $filteredData]);
    }

    public function empIdToData(Request $request)
    {
        $SHOW = AttendanceList::
            // join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            // // ->
            where('id', $request->id)
            ->first();
        return response()->json(['get' => $SHOW]);
    }

    public function byemployee(Request $request, $id)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            ->where('emp_id', $id)
            ->first();
        // dd($emp);
        // $Holiday = DB::table("holiday_details")->where('business_id',Session::get('business_id'))->get();
        // $Notice = DB::table("admin_notices")->where('business_id',Session::get('business_id'))->get();

        // $DATA = DB::table('attendance_list')
        //     ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
        //     ->join('attendance_shift_type', 'attendance_list.working_from_method', '=', 'attendance_shift_type.id')
        //     ->where('employee_personal_details.business_id', Session::get('business_id'))
        //     ->orderBy('attendance_list.id', 'DESC')
        //     ->select('attendance_list.*', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id', 'attendance_shift_type.name')
        //     ->get();
        // $root= compact('moduleName', 'permissions','Emp','Holiday','Notice', 'DATA');
        // return view('admin.dashboard.dashboard',$root);
        return view('admin.attendance.attendancevby_employee', compact('emp'));
    }

    public function details(Request $request)
    {
        // dd($request->emp_id);
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            ->get();
        $designation = DesignationList::where('business_id', Session::get('business_id'))
            ->first();

        return view('admin.attendance.emp_attendace', compact('Emp', 'designation'));
    }

    public function createShift()
    {
        $attendaceShift = DB::table('policy_attendance_shift_settings')->where('business_id', Session::get('business_id'))
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.createshift', compact('permissions', 'moduleName', 'attendaceShift'));
    }
    public function submitTrackInTrackOut(Request $request)
    {
        $updated = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))
            ->first();

        if (isset($updated)) {
            $load = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))
                ->update([
                    'business_id' => Session::get('business_id'),
                    'track_in_out' => isset($request->tranck_in_out) ? $request->tranck_in_out : 0,
                    'no_attendace_without_punch' => isset($request->no_attendace_with_punch) ? $request->no_attendace_with_punch : 0,
                ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto Updated')->persistent(true);
            } else {
                Alert::info('Mode of Attendance Not Set! Update')->persistent(true);
            }
        } else {
            $load = PolicyAttendanceTrackInOut::insert([
                'business_id' => Session::get('business_id'),
                'track_in_out' => isset($request->tranck_in_out) ? $request->tranck_in_out : 0,
                'no_attendace_without_punch' => isset($request->no_attendace_with_punch) ? $request->no_attendace_with_punch : 0,
            ]);
            if (isset($load)) {
                Alert::success('Mode of Attendence Set to Auto')->persistent(true);
            } else {
                Alert::info('Mode of Attendance Not Set!')->persistent(true);
            }
        }

        return redirect()->to('admin/settings/attendance');
        //    dd($request->all());
    }

    public function getAttendaceShiftList(Request $request)
    {
        $load = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $request->id)
            ->get();
        return response()->json(['get' => $load]);
    }

    public function addShift(Request $request)
    {
        // PASSLOAD

        // dd($request->all());

        if ($request->shiftType == 1) {
            // : (($request->rotationalName!=null)?$request->rotationalName: $request->openShiftName);

            // dd($request->all());

            $load_first = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->fixedshiftName,
            ]);
            if (isset($load_first)) {
                $firstload = DB::getPdo()->lastInsertId();

                $fixShift = PolicyAttendanceShiftTypeItem::insert([
                    'attendance_shift_id' => $firstload,
                    'shift_name' => $request->fixedshiftName,
                    'shift_start' => $request->fixShiftStart,
                    'shift_end' => $request->fixShiftEnd,
                    'break_min' => $request->fixShiftBreak,
                    'is_paid' => $request->fixpaid,
                    'work_hr' => $request->f_WorkHour,
                    'work_min' => $request->f_WorkMin,
                    'is_active' => 1,
                    'business_id' => $request->session()->get('business_id'),
                    'branch_id' => $request->session()->get('branch_id'),
                    'updated_at' => now(),
                ]);

                if ($fixShift) {
                    Alert::success('Fixed Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Fixed Shift is Not Created!')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 2) {
            $load_second = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->rotationalName,
                'shift_weekly_repeat' => $request->repeat_week,
            ]);
            if (isset($load_second)) {
                $secondload = DB::getPdo()->lastInsertId();

                foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
                    $roatationalShift = PolicyAttendanceShiftTypeItem::insert([
                        'attendance_shift_id' => $secondload,
                        'shift_name' => $request->rotationalShiftName[$key],
                        'shift_start' => $request->rotationalShiftStart[$key],
                        'shift_end' => $request->rotationalShiftEnd[$key],
                        'break_min' => $request->rotationalShiftBreak[$key],
                        'is_paid' => $request->rotationalpaid[$key],
                        'work_hr' => $request->r_WorkHour[$key],
                        'work_min' => $request->r_WorkMin[$key],
                        'is_active' => $key == 0 ? 1 : 0,
                        'branch_id' => $request->session()->get('branch_id'),
                        'business_id' => $request->session()->get('business_id'),
                        'updated_at' => now(),
                    ]);
                }

                if ($roatationalShift) {
                    Alert::success('Rotational Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Rotational Shift is Not Created')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 3) {
            $load_third = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->openShiftName,
            ]);

            if (isset($load_third)) {
                $thridload = DB::getPdo()->lastInsertId();

                $openShift = PolicyAttendanceShiftTypeItem::insert([
                    'attendance_shift_id' => $thridload,
                    'shift_name' => $request->openShiftName,
                    'shift_hr' => $request->openHour,
                    'shift_min' => $request->openMin,
                    'break_min' => $request->openBreak,
                    'is_paid' => $request->openPaid,
                    'is_active' => 1,
                    'branch_id' => $request->session()->get('branch_id'),
                    'business_id' => $request->session()->get('business_id'),
                    'updated_at' => now(),
                ]);

                if ($openShift) {
                    Alert::success('Open Shift Created Successfully', '')->persistent(true);
                } else {
                    Alert::error('Open Shift is Not Created!')->persistent(true);
                }
            }
        }
        return redirect()->to('/admin/settings/attendance/create_shift');

        // if($request->shiftType == 'fixed'){
        //     $fixShift = DB::table('shift_fixed')->insert([
        //         'shift_name'=> $request->fixedshiftName,
        //         'shift_start'=> $request->fixShiftStart,
        //         'shift_end'=> $request->fixShiftEnd,
        //         'break_min'=> $request->fixShiftBreak,
        //         'is_paid'=> $request->fixpaid,
        //         'work_hr'=> $request->f_WorkHour,
        //         'work_min'=> $request->f_WorkMin,
        //         'business_id'=> $request->session()->get('business_id'),
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'updated_at'=> now(),
        //     ]);

        //     if($fixShift ){
        //         Alert::success('Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');

        //     }

        // }

        // if($request->shiftType == 'rotational'){
        //     $shift = DB::table('shift_set')->insert([
        //         'set_name'=> $request->rotationalName,
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'business_id'=> $request->session()->get('business_id'),
        //     ]);

        //     $getShift = DB::table('shift_set')->where([
        //         'set_name'=> $request->rotationalName,
        //         'business_id'=> $request->session()->get('business_id'),
        //     ])->first('set_id');

        //     // dd($getShift->set_id);

        //     foreach ($request->rotationalShiftName as $key => $rotationalShiftName) {
        //         $roatationalShift = DB::table('shift_rotational')->insert([
        //             'set_id'=> $getShift->set_id,
        //             'shift_name'=> $request->rotationalShiftName[$key],
        //             'shift_start'=> $request->rotationalShiftStart[$key],
        //             'shift_end'=> $request->rotationalShiftEnd[$key],
        //             'break_min'=> $request->rotationalShiftBreak[$key],
        //             'is_paid'=> $request->rotationalpaid[$key],
        //             'work_hr'=> $request->r_WorkHour[$key],
        //             'work_min'=> $request->r_WorkMin[$key],
        //             'branch_id'=> $request->session()->get('branch_id'),
        //             'business_id'=> $request->session()->get('business_id'),
        //             'updated_at'=> now(),
        //         ]);
        //     }

        //     if($roatationalShift){
        //         Alert::success('Rotationa Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');

        //     }
        // }

        // if($request->shiftType == 'open'){
        //     $openShift = DB::table('shift_open')->insert([
        //         'shift_name'=> $request->openShiftName,
        //         'shift_hr'=> $request->openHour,
        //         'shift_min'=> $request->openMin,
        //         'break_min'=> $request->openBreak,
        //         'is_paid'=> $request->openPaid,
        //         'branch_id'=> $request->session()->get('branch_id'),
        //         'business_id'=> $request->session()->get('business_id'),
        //         'updated_at'=> now(),
        //     ]);

        //     if($openShift){
        //         Alert::success('Shift Created Successfully','');

        //     }else{
        //         Alert::error('Failed','');
        //     }
        // }
    }

    public function updateAttendaceShift(Request $request)
    {
        $updatedAttendanceShift = false;

        if ($request->ajax()) {
            if ($request->shift_type == 2) {
                $shiftData = []; // Create an array to store the cleaned data

                foreach ($request->updated_items as $key => $item) {
                    // Check if all required properties exist in the item
                    if (isset($item['shift_name']) && isset($item['start_time']) && isset($item['end_time']) && isset($item['break_min']) && isset($item['is_paid']) && isset($item['work_hr']) && isset($item['work_min'])) {
                        // Access individual properties of each item
                        $defaultID = (int) $request->id;
                        $shiftName = $item['shift_name'];
                        $startTime = $item['start_time'];
                        $endTime = $item['end_time'];
                        $breakMin = $item['break_min'];
                        $isPaid = $item['is_paid'];
                        $workHour = $item['work_hr'];
                        $workMin = $item['work_min'];
                        // $isActive=($key==0)?1:0;
                        // Add the data to the $shiftData array or perform other operations
                        $shiftData[] = [
                            'attendance_shift_id' => $defaultID,
                            'business_id' => Session::get('business_id'),
                            'branch_id' => Session::get('branch_id'),
                            'shift_name' => $shiftName,
                            'shift_start' => $startTime,
                            'shift_end' => $endTime,
                            'break_min' => $breakMin,
                            'is_paid' => $isPaid,
                            'work_hr' => $workHour,
                            'work_min' => $workMin,
                        ];
                    }
                }

                $load = PolicyAttendanceShiftSetting::where('id', (int) $request->id)
                    ->where('shift_type', $request->shift_type)
                    ->where('business_id', Session::get('business_id'))
                    ->first();
                if (isset($load)) {
                    PolicyAttendanceShiftSetting::where('id', $load->id)
                        ->update(['shift_type_name' => $request->shift_rotation_name, 'shift_weekly_repeat' => $request->update_week_repeat]);
                    $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                        ->where('business_id', Session::get('business_id'))
                        ->delete();
                    if (isset($loadItems)) {
                        $loadedChecked = PolicyAttendanceShiftTypeItem::insert($shiftData);
                        // if (isset($loadedChecke/d)) {

                        $updatedAttendanceShift = true;
                        // }
                    }
                } else {
                    $updatedAttendanceShift = false;
                }
                // dd($load);
                // PolicyAttendanceShiftTypeItem::where('business_id',Session::get('business_id'))->get();
                // Now $shiftData contains the cleaned data with all required properties
            }
            return response()->json(['root' => $updatedAttendanceShift]);
        }
        if ($request->EditShiftFixedShiftSubmit === 'FixedSubmit') {
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->fixedshiftId])
                ->update([
                    'business_id' => Session::get('business_id'),
                    'branch_id' => Session::get('branch_id'),
                    'shift_type' => $request->fixiedshifttype,
                    'shift_type_name' => $request->editfixedshiftname,
                ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->fixedshiftId])
                ->update([
                    'shift_name' => $request->editfixedshiftname,
                    'shift_start' => $request->UpdatedFixShiftStart,
                    'shift_end' => $request->UpdatedFixShiftEnd,
                    'break_min' => $request->UpdatedFixShiftBreak,
                    'is_paid' => $request->UpdatedFixpaid,
                    'work_hr' => $request->fu_WorkHour,
                    'work_min' => $request->fu_WorkMin,
                    'updated_at' => now(),
                ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('Fixed Shift is Updated Successfully')->persistent(true);
            } else {
                Alert::error('Fixed Shift is Not Updated')->persistent(true);
            }
            return redirect()->to('admin/settings/attendance/create_shift');
        }
        if ($request->EditShiftOpenShiftSubmit == 'OpenSubmit') {
            // dd($request->all());
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->openshiftId])
                ->update([
                    'business_id' => Session::get('business_id'),
                    'branch_id' => Session::get('branch_id'),
                    'shift_type' => $request->editshifttype,
                    'shift_type_name' => $request->editopenShiftName,
                ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->openshiftId])
                ->update([
                    'shift_name' => $request->editopenShiftName,
                    'shift_hr' => $request->editopenHour,
                    'shift_min' => $request->editopenMin,
                    'break_min' => $request->editopenBreak,
                    'is_paid' => $request->editopenPaid,
                    'updated_at' => now(),
                ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('Open Shift is Updated Successfully')->persistent(true);
            } else {
                Alert::error('Open Shift is Not Updated')->persistent(true);
            }
            return redirect()->to('admin/settings/attendance/create_shift');
        }

        // else {
        //     Alert::error('Failed', '');
        //     return redirect()->to('admin/settings/attendance/create_shift');

        // }
        // if ($request->has('fixedId')) {
        //     $fixUpdate = DB::table('shift_fixed')->where(['business_id' => $request->session()->get('business_id'), 'fixed_id' => $request->fixedId])->update([
        //         'shift_name' => $request->UpdatedFixedshiftName,
        //         'shift_start' => $request->UpdatedFixShiftStart,
        //         'shift_end' => $request->UpdatedFixShiftEnd,
        //         'break_min' => $request->UpdatedFixShiftBreak,
        //         'is_paid' => $request->UpdatedFixpaid,
        //         'work_hr' => $request->fu_WorkHour,
        //         'work_min' => $request->fu_WorkMin,
        //         'updated_at' => now(),
        //     ]);

        //     if ($fixUpdate) {
        //         Alert::success('Shift Updated Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('openId')) {
        //     $updateOpen = DB::table('shift_open')->where(['business_id' => $request->session()->get('business_id'), 'open_id' => $request->openId])->update([
        //         'shift_name' => $request->updatedOpenShiftName,
        //         'shift_hr' => $request->updatedOpenHour,
        //         'shift_min' => $request->updatedOpenMin,
        //         'break_min' => $request->updatedOpenBreak,
        //         'is_paid' => $request->updatedOpenPaid,
        //         'updated_at' => now(),
        //     ]);

        //     if ($updateOpen) {
        //         Alert::success('Shift Updated Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('setId')) {
        //     // dd($request->all());

        //     $shift = DB::table('shift_set')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $request->setId])->update([
        //         'set_name' => $request->updatedRotationalName,
        //         'updated_at' => now(),
        //     ]);

        //     $roatationalRemove = DB::table('shift_rotational')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $request->setId])->delete();

        //     foreach ($request->updatedRotationalShiftName as $key => $rotationalShiftName) {
        //         $roatationalShift = DB::table('shift_rotational')->insert([
        //             'set_id' => $request->setId,
        //             'shift_name' => $request->updatedRotationalShiftName[$key],
        //             'shift_start' => $request->updatedRotationalShiftStart[$key],
        //             'shift_end' => $request->updatedRotationalShiftEnd[$key],
        //             'break_min' => $request->updatedRotationalShiftBreak[$key],
        //             'is_paid' => $request->updatedRotationalpaid[$key],
        //             'work_hr' => $request->ru_WorkHour[$key],
        //             'work_min' => $request->ru_WorkMin[$key],
        //             'branch_id' => $request->session()->get('branch_id'),
        //             'business_id' => $request->session()->get('business_id'),
        //             'updated_at' => now(),
        //         ]);
        //     }

        //     if ($roatationalShift) {
        //         Alert::success('Rotational Shift Created Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // return redirect()->to('admin/settings/attendance/create_shift');
    }

    public function deleteShift(Request $request)
    {
        // dd($request->all());

        $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->shift_id])
            ->delete();
        $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->shift_id])
            ->delete();

        if (isset($fixUpdate) && isset($load_first)) {
            Alert::success('Deleted is Successfully')->persistent(true);
        } else {
            Alert::error('Not Delete')->persistent(true);
        }

        return back();

        // return redirect()->to('admin/settings/attendance/create_shift');

        // if ($request->has('fixed')) {
        //     $fixDelete = DB::table('shift_fixed')->where(['business_id' => $request->session()->get('business_id'), 'fixed_id' => $id])->delete();
        //     if ($fixDelete) {
        //         Alert::success('Fixed Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('open')) {
        //     $openDelete = DB::table('shift_open')->where(['business_id' => $request->session()->get('business_id'), 'open_id' => $id])->delete();
        //     if ($openDelete) {
        //         Alert::success('Open Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }

        // if ($request->has('set')) {
        //     $roatationalDelete = DB::table('shift_rotational')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $id])->delete();
        //     $setDelete = DB::table('shift_set')->where(['business_id' => $request->session()->get('business_id'), 'set_id' => $id])->delete();
        //     if ($setDelete) {
        //         Alert::success('Rotational Shift Delete Successfully', '');
        //     } else {
        //         Alert::error('Failed', '');
        //     }
        // }
        // return back();
    }
}
