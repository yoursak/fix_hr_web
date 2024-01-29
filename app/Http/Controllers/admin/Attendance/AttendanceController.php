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
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

// models
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\AttendanceTimeLog;
use App\Models\EmployeePersonalDetail;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;

use App\Models\LoginEmployee;
use App\Models\PolicyMasterEndgameMethod;
// use Alert;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        //loginRoleid check
        $FindRoleID = RulesManagement::PassBy()[3];
        $nonPunchedEmployee = [];
        $now = date('Y-m-d');
        $lateEntry = PolicyAttenRuleLateEntry::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();
        $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();
        $earlyTime = ($earlyExit->mark_half_day_hr ?? 0) * 60 + ($earlyExit->mark_half_day_min ?? 0);
        $hours1 = floor($earlyTime / 60);
        $minutes1 = $earlyTime % 60;
        $earlyExitTime = gmdate('H:i', $hours1 * 3600 + $minutes1 * 60);
        $lateTime = ($lateEntry->mark_half_day_hr ?? 0) * 60 + ($lateEntry->mark_half_day_min ?? 0);
        // Calculate hours and minutes
        $hours = floor($lateTime / 60);
        $minutes = $lateTime % 60;
        // Format as hh:mm
        $formattedTime = gmdate('H:i', $hours * 3600 + $minutes * 60);
        $fullLate = $lateTime * 60;
        // dd($formattedTime);
        $halfDayThreshold = 240; // Threshold for a half-day in minutes (4 hours)

        $currentDate = Carbon::now();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        // pendingApprovalCount
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::now()->day;

        $distinctPunchDates = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.final_status', '0')
            ->where('attendance_list.business_id', Session::get('business_id'))
            ->whereYear('attendance_list.punch_date', $currentYear)
            ->whereMonth('attendance_list.punch_date', $currentMonth)
            ->whereDate('attendance_list.punch_date', '<>', Carbon::today()) // Exclude today's data
            ->select('attendance_list.punch_date', 'final_status')
            ->distinct()
            ->get();
        // dd($distinctPunchDates);
        $approvalPendingCount = count($distinctPunchDates);
        $checkApprovalPermission = DB::table('approval_management_cycle')
            ->where('business_id', Session::get('business_id'))
            ->where('approval_type_id', 1)
            ->whereJsonContains('role_id', (string) $loginRoleID)
            ->first();
        $checkApprovalforwardId = AttendanceList::where('business_id', Session::get('business_id'))->where('forward_by_role_id', $loginRoleID)->where('final_status', '0')->first();

        // dd($checkApprovalforwardId);
        $EmployeeDetails = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();
        $DATA = AttendanceList::join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.punch_date', date('Y-m-d'))
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select(
                'attendance_list.*',
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"),
                'employee_personal_details.emp_name',
                'employee_personal_details.emp_mname',
                'static_attendance_methods.method_name',
                'employee_personal_details.profile_photo',
                'employee_personal_details.designation_id',
                'employee_personal_details.emp_lname',
                'employee_personal_details.department_id'
            )
            ->orderBy('attendance_list.id', 'desc')
            ->get();

        $filteredEmpIds = $DATA->pluck('emp_id')->toArray();
        // dd($filteredEmpIds);

        // Retrieve data from EmployeePersonalDetail excluding the records with emp_ids from $filteredData
        $employeeData = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            // ->leftJoin('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->whereNotIn('emp_id', $filteredEmpIds)
            // ->select('employee_personal_details.*', 'static_attendance_methods.method_name', 'designation_list.desig_name')
            ->get();


        $combinedData = $DATA->merge($employeeData);
        // dd($combinedData);
        // $DATA = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
        //     ->join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
        //     ->select('employee_personal_details.*', 'static_attendance_methods.method_name')
        //     ->get();
        $data = [
            'labels' => ['Work', 'Break', 'Meetings'],
            'data' => [40, 20, 10],
            // Example data in hours
        ];
        // ForApproval setup
        $owner_call_back_id = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        // dd($owner_call_back_id);
        $roleIdToCheck = Session::get('login_role');
        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', Session::get('business_id'))
            ->where('approval_type_id', 1)
            ->where('cycle_type', 2)
            ->where(function ($query) use ($roleIdToCheck) {
                $query->whereJsonContains('role_id', (string) $roleIdToCheck)
                    ->orWhereJsonContains('role_id', (string) $roleIdToCheck);
            })
            ->first();
        // dd($parallerCaseApprovalListRoleIdCheck);
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(1)[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $root = compact('parallerCaseApprovalListRoleIdCheck', 'moduleName', 'loginRoleBID', 'owner_call_back_id', 'checkApprovalCycleType', 'loginRoleID', 'permissions', 'DATA', 'data', 'approvalPendingCount', 'checkApprovalPermission', 'checkApprovalforwardId');
        return view('admin.attendance.attendance', $root);
    }



    // ********************************** Start of Attendance Ajax Response By Aman ******************************

    public function getHolidayForEmployee(Request $request)
    {
        $Date = $request->date;
        $EmpID = $request->emp_id;

        $holiday = Central_unit::getHolidayFromDB($EmpID, $Date);
        $leave = DB::table('request_leave_list')->where('emp_id', $EmpID)
            ->leftJoin('static_leave_category', 'request_leave_list.leave_category', '=', 'static_leave_category.id')
            ->whereDate('request_leave_list.from_date', '<=', $Date)
            ->whereDate('request_leave_list.to_date', '>=', $Date)
            ->first();

        $attendanceList = DB::table('attendance_list')->where('business_id', Session::get('business_id'))->where(['punch_date' => $Date, 'emp_id' => $EmpID])->first();
        $taps = DB::table('attendance_tab_location_list')->where('attendance_id', $attendanceList->id ?? 0)->get();
        return response()->json([$holiday, $leave, $taps]);
    }
    public function AttendanceByAjaxFilter(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $empId = $request->emp_id;

        $employeeAttendanceData = Central_unit::employeeAttendanceFiterForMonth(['month' => $month, 'year' => $year, 'emp_id' => $empId]);
        $byAttendanceCalculation = Central_unit::attendanceByEmpDetails($empId, $year, $month);
        $monthlyCount = Central_unit::getMonthlyCountFromDB($empId, $year, $month, Session::get('business_id'));


        $timeLog = AttendanceTimeLog::where('business_id', Session::get('business_id'))
            ->where('emp_id', $empId)
            ->whereMonth('punch_date', $month)
            ->whereYear('punch_date', $year)
            ->get();


        return response()->json([$byAttendanceCalculation, $employeeAttendanceData, $timeLog, $monthlyCount]);
    }

    public function dashboardAttendanceCountFilter(Request $request)
    {
        $resDate = $request->date;
        $monthAbbreviations = [
            'Okt' => 'Oct',
            'Maj' => 'May',
        ];
        $engDate = str_replace(array_keys($monthAbbreviations), array_values($monthAbbreviations), $resDate);

        $date = date('Y-m-d', strtotime($engDate));
        $responseData = Central_unit::getDailyCountForDashboardAndDailyList(Session::get('business_id'), $date);

        return response()->json($responseData);
    }
    public function allAttendanceCalculationAjax(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $branchId = $request->branch_id;
        $departmentId = $request->department_id;
        $designationId = $request->designation_id;
        $data = [];

        $Emp = EmployeePersonalDetail::when($branchId, function ($query) use ($branchId) {
            $query->where('employee_personal_details.branch_id', $branchId);
        })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->whereDate('employee_personal_details.emp_date_of_joining', '<=', date('Y-m-d', strtotime($year . '-' . $month . '-01')))
            ->where('employee_personal_details.active_emp', 1)
            ->where('employee_personal_details.business_id', Session()->get('business_id'))
            ->get();

        foreach ($Emp as $key => $emp) {
            // $resCode = Central_unit::attendanceCount($emp->emp_id, $year, $month);
            $resCode = Central_unit::getMonthlyCountFromDB($emp->emp_id, $year, $month, Session::get('business_id'));
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
        })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('employee_personal_details.department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('employee_personal_details.designation_id', $designationId);
            })
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->whereDate('employee_personal_details.emp_date_of_joining', '<=', date('Y-m-d', strtotime($year . '-' . $month . '-01')))
            ->where('employee_personal_details.business_id', Session()->get('business_id'))
            ->where('employee_personal_details.active_emp', 1)
            ->get();
        $status = [];

        foreach ($Emp as $key => $emp) {
            $day = 0;
            $EmpID = $emp->emp_id;
            // Create an array to store the status for this employee
            $status[$EmpID] = [];

            while ($day++ < date('t')) {
                $res = Central_unit::getEmpAttSumm(['emp_id' => $EmpID, 'punch_date' => date($year . '-' . $month . '-' . $day)]);
                // Store the status for this day in the employee's array
                $status[$EmpID][] = $res[0];
            }
        }

        return response()->json([$Emp, $status]);
    }

    // ********************************** End of Attendance Ajax Response By Aman ******************************

    public function attendanceSummary()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($permissions);
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->where('active_emp', 1)->get();
        return view('admin.attendance.summary', compact('Emp', 'permissions', 'moduleName'));
    }

    public function attendanceListFilter(Request $request)
    {

        // $dateSelectValue = $request->input('date_select_value') ? $request->input('date_select_value') : date('Y-m-d');

        // $Employees = EmployeePersonalDetail::leftJoin('attendance_list', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
        //     ->leftJoin('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
        //     ->leftJoin('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
        //     ->where('employee_personal_details.business_id', Session::get('business_id'))
        //     ->when($dateSelectValue, function ($query) use ($dateSelectValue) {
        //         $query->where('attendance_list.punch_date', $dateSelectValue);
        //     })
        //     ->get();

        // return $Employees;

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $branchId = $request->branch_id;
        $departmentId = $request->input('department_id');
        $designationId = $request->input('designation_id');
        $dateSelectValue = $request->input('date_select_value') ? $request->input('date_select_value') : date('Y-m-d');
        $empResData = [];
        $allStatusCount = [];
        $currentDate = Carbon::now();
        $loginRoleID = Session::get('login_role');
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $approval_type_id_static = 1;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(1)[1];
        $dailyCount = Central_unit::MyCountForDaily($dateSelectValue, Session::get('business_id'));


        $filteredData = AttendanceList::join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('policy_attendance_shift_settings as attendanceShift', 'employee_personal_details.emp_shift_type', '=', 'attendanceShift.id')
            ->join('static_attendance_shift_type', 'attendanceShift.shift_type', '=', 'static_attendance_shift_type.id')
            ->join('policy_attendance_shift_type_items', 'attendanceShift.id', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.punch_date', isset($dateSelectValue) ? $dateSelectValue : date('Y-m-d'))
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
            ->select(
                'attendance_list.*',
                DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_start, '%h:%i %p'), NULL) AS shift_start"),
                DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_end, '%h:%i %p'), NULL) AS shift_end"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"),
                'employee_personal_details.emp_name',
                'employee_personal_details.emp_mname',
                'designation_list.desig_name',
                'static_attendance_methods.method_name',
                'employee_personal_details.profile_photo',
                'employee_personal_details.designation_id',
                'employee_personal_details.emp_lname',
                'employee_personal_details.department_id'
            )
            ->orderBy('attendance_list.id', 'desc')
            ->get();

        $filteredEmpIds = $filteredData->pluck('emp_id')->toArray();

        // Retrieve data from EmployeePersonalDetail excluding the records with emp_ids from $filteredData
        $employeeData = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            // ->leftJoin('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->when($designationId, function ($query) use ($designationId) {
                $query->where('designation_id', $designationId);
            })
            ->whereNotIn('emp_id', $filteredEmpIds)
            // ->select('employee_personal_details.*', 'static_attendance_methods.method_name', 'designation_list.desig_name')
            ->get();


        $combinedData = $filteredData->merge($employeeData);

        foreach ($combinedData as $key => $data) {
            $resCode = Central_unit::getEmpAttSumm(['emp_id' => $data->emp_id, 'punch_date' => $dateSelectValue]);
            $empResData[$data->emp_id] = $resCode;
        }

        $allStatusCount = Central_unit::getDailyCountForDashboardAndDailyList(Session::get('business_id'), $dateSelectValue);
        if (count($filteredData) != 0) {
            if ($checkApprovalCycleType == 1) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::AttendanceApprovalManage($checkApprovalCycleType, $data, $data->id, 1, $loginRoleID);
                    // $EmpStatus = RulesManagement::AttendanceApprovalManage($checkApprovalCycleType, $data, $data->id, 2, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;

                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 1)
                        ->where('emp_id', $loginEmpID)
                        ->where('role_id', $loginRoleID)
                        ->where('all_request_id', $data->id)
                        ->select('approval_status_list.id')
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }

            if ($checkApprovalCycleType == 2) {
                foreach ($filteredData as $key => $data) {
                    $EmpStatus = RulesManagement::AttendanceApprovalManage($checkApprovalCycleType, $data, $data->id, 1, $loginRoleID);
                    $empStatus[$data->id] = $EmpStatus;
                    $current_status_particular_tb = DB::table('approval_status_list')
                        ->where('approval_type_id', $approval_type_id_static)
                        ->where('applied_cycle_type', 2)
                        ->where('all_request_id', $data->id)
                        ->first();
                    $currentStatusParrticularDb[$data->id] = $current_status_particular_tb;
                }
            }
        } else {
            $combinedData = [];
            $currentStatusParrticularDb = [];
            $empStatus = [];
        }

        $TimeLog = DB::table('attendance_time_log')->where('business_id', Session::get('business_id'))->where('punch_date', $dateSelectValue)
            ->select(
                'attendance_time_log.emp_id',
                'attendance_time_log.change_date',
                'attendance_time_log.punch_date',
                DB::raw('TIME_FORMAT(attendance_time_log.changed_in_time, "%h:%i %p") AS changed_in_time'),
                DB::raw('TIME_FORMAT(attendance_time_log.changed_out_time, "%h:%i %p") AS changed_out_time'),
                'attendance_time_log.prev_total_work',
                'attendance_time_log.changed_total_work',
                'attendance_time_log.reason',
                'attendance_time_log.changed_by',
                'attendance_time_log.changer_role',
                'attendance_time_log.changer_emp_id',
                'attendance_time_log.changer_name',
                DB::raw('COALESCE(TIME_FORMAT(attendance_time_log.prev_in_time, "%h:%i %p"), "---") AS prev_in_time'),
                DB::raw('COALESCE(TIME_FORMAT(attendance_time_log.prev_out_time, "%h:%i %p"), "---") AS prev_out_time'),

            )
            ->get();

        return response()->json(['get' => $filteredData, 'resData' => $empResData, 'allStatusCount' => $allStatusCount, 'currentstatupartdb' => $currentStatusParrticularDb, 'status' => $empStatus, 'checkapprovaltype' => $checkApprovalCycleType, 'loginroleid' => $loginRoleID, 'timeLog' => [$TimeLog], 'dailyCount' => $dailyCount]);
    }

    public function attendanceMark(Request $request)
    {

        $Days = '';
        $status = 1;
        $PID = $request->Updateid;
        $BID = RulesManagement::PassBy()[1];
        $FindRoleID = RulesManagement::PassBy()[3];
        $EmpID = RulesManagement::PassBy()[2];
        $load = RulesManagement::RoleDetailsGet();
        $call = RulesManagement::PassBy();
        $AdminRoleId = $load[0];

        // dd($AdminRoleId);
        $EmpId = $call[2];
        $ApprovalTypeID = 1; //Gatepass processType
        if ($request->has('status')) {
            // notification calling node model by jayant

            // modal approval btn
            $attendance = DB::table('attendance_list')
                ->where('id', $PID)
                ->where('business_id', Session::get('business_id'))
                ->where('emp_today_current_status', 2)
                ->first();

            $array = [
                'redirect_id' => 1,
                'primary_id' => $PID,
                'punch_date' => $attendance->punch_date,
            ];
            $SD = LoginEmployee::where('emp_id', $attendance->emp_id)->first();
            $sdd = ($request->status != 2) ? 'Approved' : 'Declined';
            if ($SD->notification_key != null) {

                $reult = RulesManagement::NotificationSendMode($SD->notification_key, 'Fix HR Employee', 'Attendance ' . $sdd . ' By : ' . Session::get('user_type') . ' ', $array);
            }

            if ($attendance) {
                $ApprovalManagement = DB::table('approval_management_cycle')
                    ->where('business_id', $BID)
                    ->where('approval_type_id', $ApprovalTypeID)
                    ->first();
                if ($ApprovalManagement->cycle_type == 1) {
                    //sequential
                    // next forward
                    $status = $request->status;
                    $sd = DB::table('approval_management_cycle')
                        ->where('business_id', $BID)
                        ->where('approval_type_id', $ApprovalTypeID)
                        ->whereJsonContains('role_id', (string) $FindRoleID)
                        ->select('role_id')
                        ->first();
                    // dd($sd);
                    $value = DB::table('attendance_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->first();
                    if ($sd) {
                        $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                        $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id
                        if ($currentIndex !== false) {
                            $nextIndex = $currentIndex + 1;
                            $prevIndex = $currentIndex - 1;
                            // Check if the next index is within the bounds of the array
                            // if (isset($roleIds[$nextIndex])) {
                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                            $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0
                            // dd($request->all(),$FindRoleID,$nextRoleId);
                            // Update the database for the current index
                            DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->update([
                                    'forward_by_role_id' => $nextRoleId,
                                    'forward_by_status' => $status,
                                ]);
                            // Update the approval status for the current index
                            //Sequential
                            DB::table('approval_status_list')
                                ->where('approval_type_id', $ApprovalTypeID)
                                ->where('role_id', $FindRoleID)
                                ->where('business_id', $BID)
                                ->where('all_request_id', $PID)
                                ->insert([
                                    'applied_cycle_type' => 1,
                                    'business_id' => $BID,
                                    'approval_type_id' => $ApprovalTypeID,
                                    'all_request_id' => $PID,
                                    'role_id' => $FindRoleID,
                                    'emp_id' => $EmpID,
                                    // 'remarks' => $Remark != null ? $Remark : '',
                                    'clicked' => 1,
                                    'status' => $status,
                                    'prev_role_id' => $prevRoleId,
                                    'current_role_id' => $FindRoleID,
                                    'next_role_id' => $nextRoleId,
                                ]);
                            Alert::success('', 'Status is Updated');
                        }
                    }
                    if ($value->forward_by_role_id == $value->final_level_role_id) {
                        DB::table('attendance_list')
                            ->where('business_id', $BID)
                            ->where('id', $PID)
                            ->update([
                                'process_complete' => 1,
                                'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                            ]);
                    }
                }
                // dd($request->all());

                // default case
                if ($ApprovalManagement->cycle_type == 2) {
                    // paraller
                    $status = $request->status;

                    $parallerModalApprovalBtn = DB::table('attendance_list')
                        ->where('business_id', $BID)
                        ->where('id', $PID)
                        ->where('emp_today_current_status', 2)
                        ->update([
                            'process_complete' => 1,
                            'final_status' => $status,
                        ]);
                    if ($parallerModalApprovalBtn) {
                        $loadCheck = DB::table('approval_status_list')
                            ->where('approval_type_id', $ApprovalTypeID)
                            ->where('business_id', $BID)
                            ->where('all_request_id', $PID)
                            ->first();

                        if ($loadCheck) {
                            // DB::table('approval_status_list')
                            //     ->where('business_id', $BID)
                            //     ->where('approval_type_id', $ApprovalTypeID)
                            //     ->where('all_request_id', $PID)
                            //     ->update([
                            //         'business_id' => $BID,
                            // 'applied_cycle_type' => 2,
                            //         'approval_type_id' => $ApprovalTypeID,
                            //         'all_request_id' => $PID,
                            //         'role_id' => $FindRoleID,
                            //         'emp_id' => $EmpID,
                            //         'remarks' => $Remark,
                            //         'status' => $status,
                            //     ]);
                        } else {
                            //Parallel
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
                                    // 'remarks' => $Remark,
                                    'status' => $status,
                                ]);
                        }
                        Alert::success('', 'Attendance is Approve');
                    } else {
                        Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                    }
                }
            } else {
                Alert::info('', 'Attendance is not approved,"\n" punch-out is required for approval.');
            }
            // }elseif ($request->has('approveAll') && ($AdminRoleId != null && $EmpId != null)) {  // modal apprvoa all btn
        } elseif ($request->has('approveAll')) {
            // modal apprvoa all btn
            if ($request->checkbox != '') {
                foreach ($request->checkbox as $key => $value) {
                    $PID = $request->checkbox[$key];
                    $checkPunchInPunchOut = DB::table('attendance_list')
                        ->where('business_id', Session::get('business_id'))
                        ->where('id', $PID)
                        ->where('emp_today_current_status', 2)
                        ->first();
                    // dd($checkPunchInPunchOut);
                    $EmpID = RulesManagement::PassBy()[2];
                    if (isset($checkPunchInPunchOut)) {
                        $roatationalShift = AttendanceList::where('business_id', Session::get('business_id'))
                            ->where('id', $PID)
                            ->where('final_status', 0)
                            ->where('emp_today_current_status', 2)
                            ->update([
                                'approved_by_role_id' => $AdminRoleId,
                                'approved_by_emp_id' => $EmpId,
                                // 'final_status' => 1,
                                // 'process_complete' => 1,
                                // 'final_status' => 1,
                            ]);
                        // dd($roatationalShift);
                        $ApprovalManagement = DB::table('approval_management_cycle')
                            ->where('business_id', $BID)
                            ->where('approval_type_id', $ApprovalTypeID)
                            ->first();
                        // dd($ApprovalManagement);
                        if ($ApprovalManagement->cycle_type == 1) {
                            //sequential
                            // next forward
                            $status = $request->status;
                            $sd = DB::table('approval_management_cycle')
                                ->where('business_id', $BID)
                                ->where('approval_type_id', $ApprovalTypeID)
                                ->whereJsonContains('role_id', (string) $FindRoleID)
                                ->select('role_id')
                                ->first();
                            $value = DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->first();
                            if ($sd) {
                                $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                                $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                                if ($currentIndex !== false) {
                                    $nextIndex = $currentIndex + 1;
                                    $prevIndex = $currentIndex - 1;

                                    // Check if the next index is within the bounds of the array
                                    // if (isset($roleIds[$nextIndex])) {
                                    $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                                    $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                                    // dd($request->all(),$FindRoleID,$nextRoleId);
                                    // Update the database for the current index
                                    DB::table('attendance_list')
                                        ->where('business_id', $BID)
                                        ->where('id', $PID)
                                        ->update([
                                            'forward_by_role_id' => $nextRoleId,
                                            'forward_by_status' => 1,
                                        ]);
                                    // dd($sd);

                                    // Update the approval status for the current index
                                    //Sequential
                                    DB::table('approval_status_list')
                                        ->where('approval_type_id', $ApprovalTypeID)
                                        ->where('role_id', $FindRoleID)
                                        ->where('business_id', $BID)
                                        ->where('all_request_id', $PID)
                                        ->insert([
                                            'applied_cycle_type' => 1,
                                            'business_id' => $BID,
                                            'approval_type_id' => $ApprovalTypeID,
                                            'all_request_id' => $PID,
                                            'role_id' => $FindRoleID,
                                            'emp_id' => $EmpID,
                                            // 'remarks' => $Remark != null ? $Remark : '',
                                            'clicked' => 1,
                                            'status' => 1,
                                            'prev_role_id' => $prevRoleId,
                                            'current_role_id' => $FindRoleID,
                                            'next_role_id' => $nextRoleId,
                                        ]);
                                    Alert::success('', 'Status is Updated');
                                }
                            }
                            if ($value->forward_by_role_id == $value->final_level_role_id) {
                                DB::table('attendance_list')
                                    ->where('business_id', $BID)
                                    ->where('id', $PID)
                                    ->update([
                                        'process_complete' => 1,
                                        'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                                    ]);
                            }
                        }

                        if ($ApprovalManagement->cycle_type == 2) {
                            $parallerModalApprovalBtn = DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->where('emp_today_current_status', 2)
                                ->update([
                                    'process_complete' => 1,
                                    'final_status' => $status,
                                ]);

                            if ($parallerModalApprovalBtn) {
                                $loadCheck = DB::table('approval_status_list')
                                    ->where('approval_type_id', $ApprovalTypeID)
                                    ->where('business_id', $BID)
                                    ->where('all_request_id', $PID)
                                    ->first();

                                if ($loadCheck) {
                                    // DB::table('approval_status_list')
                                    //     ->where('business_id', $BID)
                                    //     ->where('approval_type_id', $ApprovalTypeID)
                                    //     ->where('all_request_id', $PID)
                                    //     ->update([
                                    //         'business_id' => $BID,
                                    // 'applied_cycle_type' => 2,
                                    //         'approval_type_id' => $ApprovalTypeID,
                                    //         'all_request_id' => $PID,
                                    //         'role_id' => $FindRoleID,
                                    //         'emp_id' => $EmpID,
                                    //         'remarks' => $Remark,
                                    //         'status' => $status,
                                    //     ]);
                                } else {
                                    //Parallel
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
                                            // 'remarks' => $Remark,
                                            'status' => $status,
                                        ]);
                                }
                                Alert::success('', 'Attendance is Approve');
                            } else {
                                Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                            }
                        }
                    }
                }
                Alert::success('', 'Items updated successfully');
            }
        } elseif ($request->has('pendingAll')) {
            $leavePendingRequestCheck = DB::table('request_leave_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')->where('request_leave_list.business_id', Session::get('business_id'))->where('request_leave_list.final_status', 0)->first();
            $mispunchPendingRequestCheck = DB::table('request_mispunch_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'request_mispunch_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')->where('request_mispunch_list.business_id', Session::get('business_id'))->where('request_mispunch_list.final_status', 0)->first();
            $attendanceOutTimeMis = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', 'attendance_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('attendance_list.emp_today_current_status', '!=', '2')
                ->whereDate('attendance_list.punch_date', '!=', now()->toDateString())
                ->first();
            if ($leavePendingRequestCheck != null && $mispunchPendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear your attendance, leave and mispunch first');
                return redirect('/admin/attendance');
            } else if ($leavePendingRequestCheck != null && $mispunchPendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear your all your leave and mispunch first');
                return redirect('/admin/attendance');
            } else if ($leavePendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your attendance and leave first');
                return redirect('/admin/attendance');
            } else if ($mispunchPendingRequestCheck != null && $attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your attendance and mispunch first');
                return redirect('/admin/attendance');
            } else if ($leavePendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your leave first');
                return redirect('/admin/attendance');
            } else if ($mispunchPendingRequestCheck != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly clear all your mispunch first');
                return redirect('/admin/attendance');
            } else if ($attendanceOutTimeMis != null) {
                Alert::info('', 'Attendance approval not allowed, Kindly mark your punch out time first');
                return redirect('/admin/attendance');
            }

            // dd($attendanceOutTimeMis);
            $PendingApproval = DB::table('attendance_list')
                ->where('final_status', 0)
                ->where('process_complete', 0)
                ->where('business_id', Session::get('business_id'))
                ->where('emp_today_current_status', 2)
                ->get();
            if ($PendingApproval->count() == 0) {
                // Alert::warning('', '');
                return back();
            }
            // dd($PendingApproval->count());

            foreach ($PendingApproval as $key => $value) {
                $PID = $value->id;
                // $checkPunchInPunchOut = DB::table('attendance_list')
                //     ->where('business_id', Session::get('business_id'))
                //     ->where('id', $PID)
                //     ->where('emp_today_current_status', 2)
                //     ->first();

                if (isset($PendingApproval)) {
                    $EmpID = RulesManagement::PassBy()[2];
                    // dd($EmpId);
                    // $roatationalShift = AttendanceList::where('business_id', Session::get('business_id'))
                    //     ->where('id', $PID)
                    //     ->where('final_status', 0)
                    //     ->where('emp_today_current_status', 2)
                    //     ->update([
                    //         'approved_by_role_id' => $AdminRoleId,
                    //         'approved_by_emp_id' => $EmpId,
                    //         // 'final_status' => 1,
                    //         // 'process_complete' => 1,
                    //         // 'final_status' => 1,
                    //     ]);

                    $ApprovalManagement = DB::table('approval_management_cycle')
                        ->where('business_id', $BID)
                        ->where('approval_type_id', $ApprovalTypeID)
                        ->first();
                    if ($ApprovalManagement->cycle_type == 1) {
                        $status = $request->status;
                        $sd = DB::table('approval_management_cycle')
                            ->where('business_id', $BID)
                            ->where('approval_type_id', $ApprovalTypeID)
                            ->whereJsonContains('role_id', (string) $FindRoleID)
                            ->select('role_id')
                            ->first();
                        // dd($sd);
                        $value = DB::table('attendance_list')
                            ->where('business_id', $BID)
                            ->where('id', $PID)
                            ->first();
                        // dd($sd);
                        if ($sd) {
                            $roleIds = json_decode($sd->role_id, true); // Decode the JSON array
                            $currentIndex = array_search($FindRoleID, $roleIds); // Find the current index of forward_by_role_id

                            if ($currentIndex !== false) {
                                $nextIndex = $currentIndex + 1;
                                $prevIndex = $currentIndex - 1;

                                // Check if the next index is within the bounds of the array
                                // if (isset($roleIds[$nextIndex])) {
                                $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1; //sensitive case if last next end then recall 0
                                $prevRoleId = isset($roleIds[$prevIndex]) ? $roleIds[$prevIndex] : 0; //prev 1st start recall 0

                                // dd($request->all(),$FindRoleID,$nextRoleId);
                                // Update the database for the current index
                                $attendanccelist = DB::table('attendance_list')
                                    ->where('business_id', $BID)
                                    ->where('id', $PID)
                                    ->update([
                                        'forward_by_role_id' => $nextRoleId,
                                        'forward_by_status' => 1,
                                    ]);
                                // dd($sd);

                                // Update the approval status for the current index
                                //Sequential
                                // dd($PID);
                                $approvalstatuslist = DB::table('approval_status_list')
                                    ->where('approval_type_id', $ApprovalTypeID)
                                    ->where('role_id', $FindRoleID)
                                    ->where('business_id', $BID)
                                    ->where('all_request_id', $PID)
                                    ->insert([
                                        'applied_cycle_type' => 1,
                                        'business_id' => $BID,
                                        'approval_type_id' => $ApprovalTypeID,
                                        'all_request_id' => $PID,
                                        'role_id' => $FindRoleID,
                                        'emp_id' => $EmpID,
                                        // 'remarks' => $Remark != null ? $Remark : '',
                                        'clicked' => 1,
                                        'status' => 1,
                                        'prev_role_id' => $prevRoleId,
                                        'current_role_id' => $FindRoleID,
                                        'next_role_id' => $nextRoleId,
                                    ]);
                                // dd($dd);
                                // if($attendanccelist && $approvalstatuslist ){

                                //     Alert::success('', 'Status is Updated');
                                // }else {
                                //     Alert::info('', 'Status is not Updated');
                                // }
                            }
                        }
                        // dd($value->forward_by_role_id);
                        if ($value->forward_by_role_id == $value->final_level_role_id) {
                            DB::table('attendance_list')
                                ->where('business_id', $BID)
                                ->where('id', $PID)
                                ->update([
                                    'process_complete' => 1,
                                    'final_status' => RulesManagement::FinalRequestStatusSubmitFilterValue($PID, 1)[0], //final status submit
                                ]);
                        }
                    }
                    // dd($request->all());

                    if ($ApprovalManagement->cycle_type == 2) {
                        $parallerModalApprovalBtn = DB::table('attendance_list')
                            ->where('business_id', $BID)
                            ->where('id', $PID)
                            ->where('emp_today_current_status', 2)
                            ->update([
                                'process_complete' => 1,
                                'final_status' => $status,
                            ]);
                        if ($parallerModalApprovalBtn) {
                            $loadCheck = DB::table('approval_status_list')
                                ->where('approval_type_id', $ApprovalTypeID)
                                ->where('business_id', $BID)
                                ->where('all_request_id', $PID)
                                ->first();

                            if ($loadCheck) {
                                // DB::table('approval_status_list')
                                //     ->where('business_id', $BID)
                                //     ->where('approval_type_id', $ApprovalTypeID)
                                //     ->where('all_request_id', $PID)
                                //     ->update([
                                //         'business_id' => $BID,
                                // 'applied_cycle_type' => 2,
                                //         'approval_type_id' => $ApprovalTypeID,
                                //         'all_request_id' => $PID,
                                //         'role_id' => $FindRoleID,
                                //         'emp_id' => $EmpID,
                                //         'remarks' => $Remark,
                                //         'status' => $status,
                                //     ]);
                            } else {
                                //Parallel
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
                                        // 'remarks' => $Remark,
                                        'status' => $status,
                                    ]);
                            }
                            Alert::success('', 'Attendance is Approve');
                        } else {
                            Alert::info('', 'Attendance is not approved, punch-out is required for approval.');
                        }
                    }
                }
            }
            Alert::success('', 'Items updated successfully');
            // dd($PendingApproval[]->id);
            $rooted = AttendanceList::where('business_id', Session::get('business_id'))
                ->where('final_status', 0)
                ->update([
                    // 'approved_by_role_id' => $AdminRoleId,
                    // 'approved_by_emp_id' => $EmpId,
                    // 'final_status' => 1,
                ]);
            Alert::success('', 'Items updated successfully');
        } else {
            Alert::warning('', 'Not updated successfully');
        }
        // dd($rooted);

        return back();

        ///////////////////////////////////////////////////////////////

        // $load = RulesManagement::RoleDetailsGet();
        // $call = RulesManagement::PassBy();
        // $AdminRoleId = $load[0];
        // // dd($AdminRoleId);
        // $EmpId = $call[2];
        // if($request->has('approveAll') && ($AdminRoleId != null && $EmpId != null)) {

        //     foreach($request->checkbox as $key => $value) {
        //         $roatationalShift = AttendanceList::where('business_id', Session::get('business_id'))
        //             ->where('id', $request->checkbox[$key])
        //             ->where('final_status', 0)
        //             ->update([
        //                 'approved_by_role_id' => $AdminRoleId,
        //                 'approved_by_emp_id' => $EmpId,
        //                 'final_status' => 1
        //             ]);
        //     }
        //     Alert::success('Items updated successfully');
        // } else if($request->has('pendingAll') && ($AdminRoleId != null && $EmpId != null)) {
        //     $rooted = AttendanceList::where('business_id', Session::get('business_id'))
        //         ->where('final_status', 0)
        //         ->update([
        //             'approved_by_role_id' => $AdminRoleId,
        //             'approved_by_emp_id' => $EmpId,
        //             'final_status' => 1
        //         ]);
        //     Alert::success('Items updated successfully');
        // } else {
        //     Alert::warning('Not updated successfully');
        // }
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
            ->update(['punch_in_time' => $request->editPunchInTime, 'punch_out_time' => $request->editPunchOutTime, 'total_working_hour' => $totalWorking, 'final_status' => 1]);
        if ($atteUpdate) {
            Alert::success('Your aAttendacne request has been approve successfully');
        } else {
            Alert::error('Your attendacne request has not been approve successfully');
        }
        return redirect()->to('admin/attendance');
    }

    public function empIdToData(Request $request)
    {
        $SHOW = AttendanceList::where('id', $request->id)->first();
            // join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            // // ->
        return response()->json(['get' => $SHOW]);
    }

    public function byemployee(Request $request, $id)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($permissions);
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
        return view('admin.attendance.attendancevby_employee', compact('emp', 'permissions'));
    }

    public function details(Request $request)
    {
        // dd($request->emp_id);
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($accessPermission);
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->where('active_emp', 1)->get();
        $designation = DesignationList::where('business_id', Session::get('business_id'))->first();

        return view('admin.attendance.emp_attendace', compact('Emp', 'designation', 'permissions'));
    }

    public function createShift()
    {
        $attendaceShift = DB::table('policy_attendance_shift_settings')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.createshift', compact('permissions', 'moduleName', 'attendaceShift'));
    }
    public function submitTrackInTrackOut(Request $request)
    {
        $updated = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->first();

        if (isset($updated)) {
            $load = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->update([
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
        $load = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $request->id)->get();
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
                    Alert::success('', 'Your fixed shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your fixed shift has not been created')->persistent(true);
                }
            }
        } elseif ($request->shiftType == 2) {
            $load_second = PolicyAttendanceShiftSetting::insert([
                'business_id' => Session::get('business_id'),
                'shift_type' => $request->shiftType,
                'shift_type_name' => $request->rotationalName,
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
                    Alert::success('', 'Your rotational shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your rotational shift has not been created')->persistent(true);
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
                    Alert::success('', 'Your open shift has been created successfully', '')->persistent(true);
                } else {
                    Alert::error('', 'Your open shift has not been created')->persistent(true);
                }
            }
        }
        return redirect()->back();

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
        // dd($request->all());
        $defaultID = $request->setId;

        if (isset($request->setId)) {
            if (isset($request->shiftType) == 2) {
                if (($request->rotationName) && ($request->updateItmeIdName) && ($request->editshiftname) && ($request->editstartshift) && ($request->editshiftTimeend) && isset($request->ru_WorkHour) && isset($request->ru_WorkMin) && isset($request->isPaid))
                    $shiftData = []; // Create an array to store the cleaned data
                $load = PolicyAttendanceShiftSetting::where('id', (int) $request->setId)
                    ->where('shift_type', $request->shiftType)
                    ->where('business_id', Session::get('business_id'))
                    ->first();

                if ((isset($load))) {
                    PolicyAttendanceShiftSetting::where('id', $load->id)->update(['shift_type_name' => $request->rotationName]);
                    $editshiftname = $request->editshiftname;
                    $editstartshift = $request->editstartshift;
                    $editshiftTimeend = $request->editshiftTimeend;
                    $updatedRotationalShiftBreak = $request->updatedRotationalShiftBreak;
                    $ru_WorkHour = $request->ru_WorkHour;
                    $ru_WorkMin = $request->ru_WorkMin;
                    $isPaid = $request->isPaid;
                    $loadItemsCheck = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('id')
                        ->toArray();
                    $updateItems = $request->updateItmeIdName;
                    $nonExistentIds = array_diff($loadItemsCheck, $updateItems);
                    if (isset($nonExistentIds)) {

                        $delete = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                            ->where('business_id', Session::get('business_id'))->whereIn('id', $nonExistentIds)->delete();
                    }

                    foreach ($request->updateItmeIdName as $key => $item) {
                        // Check if all required properties exist in the item
                        $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
                            ->where('id', (int) $item)
                            ->where('business_id', Session::get('business_id'))
                            ->first();


                        if (isset($loadItems)) {
                            $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)->where('id', (int) $item)
                                ->where('business_id', Session::get('business_id'))
                                ->update([
                                    'shift_name' => $editshiftname[$item],
                                    'shift_start' => $editstartshift[$item],
                                    'shift_end' => $editshiftTimeend[$item],
                                    'work_hr' => $ru_WorkHour[$item],
                                    'work_min' => $ru_WorkMin[$item],
                                    'break_min' => $updatedRotationalShiftBreak[$item],
                                    'is_paid' => $isPaid[$item]
                                ]);
                        } else {
                            PolicyAttendanceShiftTypeItem::insert([
                                'attendance_shift_id' => $defaultID,
                                'business_id' => Session::get('business_id'),
                                'branch_id' => Session::get('branch_id'),
                                'shift_name' => $editshiftname[$item],
                                'shift_start' => $editstartshift[$item],
                                'shift_end' => $editshiftTimeend[$item],
                                'break_min' => $updatedRotationalShiftBreak[$item],
                                'is_paid' => $isPaid[$item],
                                'work_hr' => $ru_WorkHour[$item],
                                'work_min' => $ru_WorkHour[$item],
                            ]);
                        }
                    }
                }
                $updatedAttendanceShift = true;
                Alert::success('', 'Your rotational shift has been updated successfully')->persistent(true);
            }
        }
        // if ($request->ajax()) {
        //     if ($request->shift_type == 2) {
        //         $shiftData = []; // Create an array to store the cleaned data

        //         foreach ($request->updated_items as $key => $item) {
        //             // Check if all required properties exist in the item
        //             if (isset($item['shift_name']) && isset($item['start_time']) && isset($item['end_time']) && isset($item['break_min']) && isset($item['is_paid']) && isset($item['work_hr']) && isset($item['work_min'])) {
        //                 // Access individual properties of each item
        //                 $defaultID = (int) $request->id;
        //                 $shiftName = $item['shift_name'];
        //                 $startTime = $item['start_time'];
        //                 $endTime = $item['end_time'];
        //                 $breakMin = $item['break_min'];
        //                 $isPaid = $item['is_paid'];
        //                 $workHour = $item['work_hr'];
        //                 $workMin = $item['work_min'];
        //                 // $isActive=($key==0)?1:0;
        //                 // Add the data to the $shiftData array or perform other operations
        //                 $shiftData[] = [
        //                     'attendance_shift_id' => $defaultID,
        //                     'business_id' => Session::get('business_id'),
        //                     'branch_id' => Session::get('branch_id'),
        //                     'shift_name' => $shiftName,
        //                     'shift_start' => $startTime,
        //                     'shift_end' => $endTime,
        //                     'break_min' => $breakMin,
        //                     'is_paid' => $isPaid,
        //                     'work_hr' => $workHour,
        //                     'work_min' => $workMin,
        //                 ];
        //             }
        //         }

        //         $load = PolicyAttendanceShiftSetting::where('id', (int) $request->id)
        //             ->where('shift_type', $request->shift_type)
        //             ->where('business_id', Session::get('business_id'))
        //             ->first();
        //         if (isset($load)) {
        //             PolicyAttendanceShiftSetting::where('id', $load->id)->update(['shift_type_name' => $request->shift_rotation_name]);
        //             $loadItems = PolicyAttendanceShiftTypeItem::where('attendance_shift_id', $load->id)
        //                 ->where('business_id', Session::get('business_id'))
        //                 ->delete();
        //             if (isset($loadItems)) {
        //                 $loadedChecked = PolicyAttendanceShiftTypeItem::insert($shiftData);
        //                 // if (isset($loadedChecked)) {

        //                 $updatedAttendanceShift = true;
        //                 // }
        //             }
        //         } else {
        //             $updatedAttendanceShift = false;
        //         }
        //         // dd($load);
        //         // PolicyAttendanceShiftTypeItem::where('business_id',Session::get('business_id'))->get();
        //         // Now $shiftData contains the cleaned data with all required properties
        //     }
        //     return response()->json(['root' => $z]);
        // }
        if ($request->EditShiftFixedShiftSubmit === 'FixedSubmit') {
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->fixedshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->fixiedshifttype,
                'shift_type_name' => $request->editfixedshiftname,
            ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->fixedshiftId])->update([
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
                Alert::success('', 'Your fixed shift has been updated successfully')->persistent(true);
            } else {
                Alert::error('', 'Your fixed shift has not been updated')->persistent(true);
            }
            return redirect()->back();
        }
        if ($request->EditShiftOpenShiftSubmit == 'OpenSubmit') {
            // dd($request->all());
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->openshiftId])->update([
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'shift_type' => $request->editshifttype,
                'shift_type_name' => $request->editopenShiftName,
            ]);

            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->openshiftId])->update([
                'shift_name' => $request->editopenShiftName,
                'shift_hr' => $request->editopenHour,
                'shift_min' => $request->editopenMin,
                'break_min' => $request->editopenBreak,
                'is_paid' => $request->editopenPaid,
                'updated_at' => now(),
            ]);

            if (isset($fixUpdate) && isset($load_first)) {
                Alert::success('', 'Your open shift has been updated successfully')->persistent(true);
            } else {
                Alert::error('', 'Your open shift has not been updated')->persistent(true);
            }
            return redirect()->back();
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
        return redirect()->back();
    }

    public function restoreAllAttendanceCount()
    {
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
        Central_unit::setCountAtOnceForDailyAndMonthly();
        dd('Reset Successfully');
    }

    public function deleteShift(Request $request)
    {
        $checkmat = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))
            ->whereJsonContains('shift_settings_ids_list', $request->shift_id)
            ->count();

        if ($checkmat == 0) {
            $load_first = PolicyAttendanceShiftSetting::where(['business_id' => Session::get('business_id'), 'id' => $request->shift_id])->delete();
            $fixUpdate = PolicyAttendanceShiftTypeItem::where(['business_id' => Session::get('business_id'), 'attendance_shift_id' => $request->shift_id])->delete();
        }
        if (isset($fixUpdate) && isset($load_first)) {
            Alert::success('', 'Your shift has been deleted successfully')->persistent(true);
        } else {
            Alert::error('', 'You cannot delete the shift if you have an employee associated with it.')->persistent(true);
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
