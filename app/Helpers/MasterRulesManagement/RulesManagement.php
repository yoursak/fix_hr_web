<?php

namespace App\Helpers\MasterRulesManagement;

use Carbon\Carbon;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

use App\Models\ModelHasPermission;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
use App\Models\BranchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicyPolicyHolidayDetail;
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\StaticApprovalName;

//  PACKAGES POWER => DEVELOPED BY JAYANT
class RulesManagement
{
    protected static $UserType, $LoginEmpID, $BusinessID, $BranchID, $LoginRole, $LoginModelID, $LoginName, $LoginEmail, $LoginBusinessImage, $Today, $currentDay, $currentMonth, $currentYear;
    // session deling
    public function __construct()
    {
        // self::$UserType = Session::get('user_type'); //Other checking loader
        // self::$BusinessID = Session::get('business_id');
        // self::$BranchID = Session::get('branch_id');
        // self::$LoginRole = Session::get('login_role'); //role table id : 8
        // self::$LoginEmpID = Session::get('login_emp_id');
        // // login_emp_id
        // // self::$LoginModelType = Session::get('model_type'); //type loginModel : admin
        // self::$LoginModelID = Session::get('model_id'); //user id like : FD001
        // self::$LoginName = Session::get('login_name');
        // self::$LoginEmail = Session::get('login_email');
        // self::$LoginBusinessImage = Session::get('login_business_image'); //bimg
        self::allValueGet(); //self::temp storage data
        // dd(self::$BusinessID,self::$UserType,self::$BranchID,self::$LoginRole,self::$LoginModelID,self::$LoginEmail,self::$LoginName);
        // like storage AT BusinessLoad ID 5
    }

    public static function myHelperFunction($parameter)
    {
        return "Hello THIS IS Rule MANAGEMENT, $parameter!";
    }

    // Todays Status started
    public static function TodayStatus()
    {
        return [self::allValueGet()[0], 0];
    }

    // access permission hard word STEP 1
    public static function AccessPermission()
    {
        $currentRouteName = Route::currentRouteName();
        $permissions = [];

        // Check if 'business_id', 'branch_id', and 'login_emp_id' are not null in the session ///onwer
        if (Session::has('business_id') && Session::has('branch_id') && Session::has('user_type') && Session::has('login_emp_id')) {
            $CheckRole = DB::table('setting_role_assign_permission')
                ->where('business_id', Session::get('business_id'))
                ->where('branch_id', Session::get('branch_id'))
                ->where('emp_id', Session::get('login_emp_id'))
                ->first();

            if ($CheckRole) {
                $roleItem = DB::table('setting_role_items')
                    ->where('role_create_id', $CheckRole->role_id)
                    ->get();

                $permissions = array_merge($permissions, $roleItem->pluck('model_name')->toArray());
                // dd($permissions);
            }
        }
        // model_id
        if (Session::has('business_id') && Session::has('user_type') && Session::has('model_id')) {
            $CheckRole = DB::table('model_has_permissions')
                ->where('business_id', Session::get('business_id'))
                ->where('model_id', Session::get('model_id'))
                ->first();

            if ($CheckRole) {
                $roleItem = DB::table('model_has_permissions')
                    ->where('business_id', Session::get('business_id'))
                    ->where('model_id', Session::get('model_id'))
                    ->get();

                $permissions = array_merge($permissions, $roleItem->pluck('permission_name')->toArray());
            }
        }
        $parts = explode('.', $currentRouteName);
        $moduleName = $parts[0];
        // protection activated
        return [$moduleName, $permissions];
    }

    // return ALL POLICY Templates particular businessID MAIN CENTER STEP 2
    static function ALLPolicyTemplates()
    {
        // dd(self::allValueGet()[5]);
        $businessLoad = DB::table('business_details_list')
            ->where('business_id', self::allValueGet()[5])
            ->first();
        $branchList = DB::table('branch_list')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', self::allValueGet()[5])
            ->get();
        $holidayPolicy = DB::table('policy_holiday_template')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        $weeklyPolicy = DB::table('policy_weekly_holiday_list')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        $attendanceMode = DB::table('policy_attendance_mode')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        $attendanceShiftSettings = DB::table('policy_attendance_shift_settings')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        $attendanceTrackPunchInOROut = DB::table('policy_attendance_track_in_out')
            ->where('business_id', self::allValueGet()[5])
            ->first(); //particular set illegal

        // $shiftSettingIdsArray = $attendanceShiftSettings->pluck('id')->toArray();

        $finalEndGameRule = DB::table('policy_master_endgame_method')
            ->join('static_attendance_endgame_policypreference', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_policypreference.id')
            ->join('static_attendance_endgame_level', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_level.policypreference_level_id')
            ->where('policy_master_endgame_method.business_id', self::allValueGet()[5])
            ->select('policy_master_endgame_method.*', 'static_attendance_endgame_policypreference.policy_name as policy_name', 'static_attendance_endgame_level.level_name as level_name')
            ->get();

        $employeeInfomation = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_attendance_shift_type', 'employee_personal_details.emp_shift_type', '=', 'static_attendance_shift_type.id')
            ->join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->join('static_employee_join_gender_type', 'employee_personal_details.emp_gender', '=', 'static_employee_join_gender_type.id')
            ->where('employee_personal_details.business_id', self::allValueGet()[5])
            ->get();

        $adminRoleList = DB::table('policy_setting_role_create')
            ->where('business_id', self::allValueGet()[5])
            ->get();
        // Rule List
        // $lateentry;
        // $finalEndGameRule = DB::table('policy_master_endgame_method')
        //     ->join('static_attendance_endgame_policypreference', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_policypreference.id')
        //     ->join('static_attendance_endgame_level', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_level.policypreference_level_id')
        //     ->join('policy_attendance_shift_settings', function ($join) use ($attendanceShiftSettings) {
        //         $join->on('policy_master_endgame_method.shift_settings_ids_list', 'LIKE', DB::raw("CONCAT('%', policy_attendance_shift_settings.id, '%')"))
        //             ->whereIn('policy_attendance_shift_settings.id', $attendanceShiftSettings);
        //     })
        //     ->where('policy_master_endgame_method.business_id', self::allValueGet()[5])->get();
        // dd($finalEndGameRule);
        // ->join('policy_attendance_shift_settings', 'policy_master_endgame_method.shift_settings_ids_list', '=', 'policy_attendance_shift_settings.id')
        if (($finalEndGameRule != null) != null || $businessLoad != null || $branchList != null || $leavePolicy != null || $holidayPolicy != null || $weeklyPolicy != null || $attendanceMode != null || $attendanceShiftSettings != null || $attendanceTrackPunchInOROut != null || $employeeInfomation != null || $adminRoleList != null) {
            return [$finalEndGameRule, $businessLoad, $branchList, $leavePolicy, $holidayPolicy, $weeklyPolicy, $attendanceMode, $attendanceShiftSettings, $attendanceTrackPunchInOROut, $employeeInfomation, $adminRoleList];
        } else {
            return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }
    }

    static function ALLPolicyTemplatesByIDCall($BID)
    {
        // dd(self::allValueGet()[5]);
        // $departmentList=DB::table('department_list')
        $businessLoad = DB::table('business_details_list')
            ->where('business_id', $BID)
            ->first();
        $branchList = DB::table('branch_list')
            ->where('business_id', $BID)
            ->get(); //call by ApiResponse ,
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', $BID)
            ->get();
        $holidayPolicy = DB::table('policy_holiday_template')
            ->where('business_id', $BID)
            ->get();
        $weeklyPolicy = DB::table('policy_weekly_holiday_list')
            ->where('business_id', $BID)
            ->get();
        $attendanceMode = DB::table('policy_attendance_mode')
            ->where('business_id', $BID)
            ->get();
        $attendanceShiftSettings = DB::table('policy_attendance_shift_settings')
            ->where('policy_attendance_shift_settings.business_id', $BID)
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->join('policy_attendance_shift_type_items', 'policy_attendance_shift_settings.id', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->get();
        $attendanceTrackPunchInOROut = DB::table('policy_attendance_track_in_out')
            ->where('business_id', $BID)
            ->first(); //particular set illegal

        // $shiftSettingIdsArray = $attendanceShiftSettings->pluck('id')->toArray();

        $finalEndGameRule = DB::table('policy_master_endgame_method')
            ->join('static_attendance_endgame_policypreference', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_policypreference.id')
            ->join('static_attendance_endgame_level', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_level.policypreference_level_id')
            ->where('policy_master_endgame_method.business_id', $BID)
            ->select('policy_master_endgame_method.*', 'static_attendance_endgame_policypreference.policy_name as policy_name', 'static_attendance_endgame_level.level_name as level_name')
            ->get();

        // ->join('static_attendance_endgame_policypreference', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_policypreference.id')
        //     ->join('static_attendance_endgame_level', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_level.policypreference_level_id')
        //     ->where('policy_master_endgame_method.business_id', $BID)
        //     ->get();

        $employeeInfomation = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_attendance_shift_type', 'employee_personal_details.emp_shift_type', '=', 'static_attendance_shift_type.id')
            ->join('static_attendance_methods', 'employee_personal_details.emp_attendance_method', '=', 'static_attendance_methods.id')
            ->join('static_employee_join_gender_type', 'employee_personal_details.emp_gender', '=', 'static_employee_join_gender_type.id')
            ->where('employee_personal_details.business_id', $BID)
            ->get();

        // Rule List
        // $lateentry;
        // $finalEndGameRule = DB::table('policy_master_endgame_method')
        //     ->join('static_attendance_endgame_policypreference', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_policypreference.id')
        //     ->join('static_attendance_endgame_level', 'policy_master_endgame_method.policy_preference', '=', 'static_attendance_endgame_level.policypreference_level_id')
        //     ->join('policy_attendance_shift_settings', function ($join) use ($attendanceShiftSettings) {
        //         $join->on('policy_master_endgame_method.shift_settings_ids_list', 'LIKE', DB::raw("CONCAT('%', policy_attendance_shift_settings.id, '%')"))
        //             ->whereIn('policy_attendance_shift_settings.id', $attendanceShiftSettings);
        //     })
        //     ->where('policy_master_endgame_method.business_id', self::allValueGet()[5])->get();
        // dd($finalEndGameRule);
        // ->join('policy_attendance_shift_settings', 'policy_master_endgame_method.shift_settings_ids_list', '=', 'policy_attendance_shift_settings.id')
        if (($finalEndGameRule != null) != null || $businessLoad != null || $branchList != null || $leavePolicy != null || $holidayPolicy != null || $weeklyPolicy != null || $attendanceMode != null || $attendanceShiftSettings != null || $attendanceTrackPunchInOROut != null || $employeeInfomation != null) {
            return [$finalEndGameRule, $businessLoad, $branchList, $leavePolicy, $holidayPolicy, $weeklyPolicy, $attendanceMode, $attendanceShiftSettings, $attendanceTrackPunchInOROut, $employeeInfomation];
            // return array($finalEndGameRule,  $attendanceMode);
        } else {
            return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }
    }
    // first list
    static function GetValues($id)
    {
        // $branch = DB::table('branch_list')
        //     ->where('business_id', self::allValueGet()[5])->count();
        // || ($department != null) || ($designation != null) || ($adminCount != null) || ($holidayCount != null) || ($leaveCount != null) || ($weeklyholidayCount != null)

        $leaveSettingsList = PolicySettingLeavePolicy::where('id', $id)
            ->where('business_id', self::allValueGet()[5])
            ->first();
        $holidayPolicyList = DB::table('policy_holiday_template')
            ->where('temp_id', $id)
            ->where('business_id', self::allValueGet()[5])
            ->first();
        $weeklyPolicyList = DB::table('policy_weekly_holiday_list')
            ->where('id', $id)
            ->where('business_id', self::allValueGet()[5])
            ->first();

        // attendance
        $AttendanceShiftPolicyList = DB::table('policy_attendance_shift_settings')
            ->where('policy_attendance_shift_settings.id', $id) // Prefix with table name
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->where('policy_attendance_shift_settings.business_id', self::allValueGet()[5])
            ->first();
        $attendanceModeList = DB::table('policy_attendance_mode')
            ->where('business_id', self::allValueGet()[5])
            ->first();

        if ($leaveSettingsList != null || $holidayPolicyList != null || $weeklyPolicyList != null || $AttendanceShiftPolicyList != null || $attendanceModeList != null) {
            return [$leaveSettingsList, $holidayPolicyList, $weeklyPolicyList, $AttendanceShiftPolicyList, $attendanceModeList];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    // Attendance Method Dynamic Mapping Counter and loaded-set
    static function AttendaceMethodTypeCounter()
    {
        $load = DB::table('static_attendance_methods')->get();
        $attendanceData = [];

        foreach ($load as $item //dynamic
        ) {
            $methodId = $item->id ?? null; // Use the method_id if it exists, otherwise null
            $methodName = $item->method_name ?? null;

            $count = DB::table('employee_personal_details')
                ->where('emp_attendance_method', $methodId)
                ->where('business_id', self::allValueGet()[5])
                ->count();

            $attendanceData[$methodName] = $count;
        }

        // used BY
        // $attendanceData = json_decode($AttendanceData, true); // Convert JSON to associative array

        // $formattedData = [];

        // foreach ($attendanceData as $method => $count) {
        //     $formattedData[] = "$method: $count";
        // }

        // $displayString = implode(' | ', $formattedData);

        return json_encode($attendanceData);
    }

    // futures makes
    static function CountersValue()
    {
        $branch = DB::table('branch_list')
            ->where('business_id', self::allValueGet()[5])
            ->count();

        $department = DB::table('department_list')
            ->where('b_id', self::allValueGet()[5])
            ->count();
        $designation = DB::table('designation_list')
            ->where('business_id', self::allValueGet()[5])
            ->count();
        $adminCount = DB::table('policy_setting_role_assign_permission')
            ->where('business_id', self::allValueGet()[5])
            ->count();
        $holidayCount = DB::table('policy_holiday_template')
            ->where('business_id', self::allValueGet()[5])
            ->count();
        $leaveCount = PolicySettingLeavePolicy::where('business_id', self::allValueGet()[5])
            ->count();
        $weeklyholidayCount = DB::table('policy_weekly_holiday_list')
            ->where('business_id', self::allValueGet()[5])
            ->count();

        $EmployeeAttendanceMethod = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->select('emp_attendance_method')
            ->count();
        if ($branch != null || $department != null || $designation != null || $adminCount != null || $holidayCount != null || $leaveCount != null || $weeklyholidayCount != null || $EmployeeAttendanceMethod != null) {
            return [$branch, $department, $designation, $adminCount, $holidayCount, $leaveCount, $weeklyholidayCount, $$EmployeeAttendanceMethod];
        } else {
            return [0, 0, 0, 0, 0, 0, 0, 0];
        }
        // $filteredData = Employee::query()
        // ->when($branchId, function ($query) use ($branchId) {
        //     $query->where('branch_id', $branchId);
        // })
        // ->when($departmentId, function ($query) use ($departmentId) {
        //     $query->where('department_id', $departmentId);
        // })
        // ->when($designationId, function ($query) use ($designationId) {
        //     $query->where('designation_id', $designationId);
        // })
        // ->get();
    }

    static function SectionEmployeeCounters()
    {
        $totalEmployee = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->count();
        $GenderMale = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->where('emp_gender', 1)
            ->count();
        $GenderFemale = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->where('emp_gender', 2)
            ->count();
        $GenderOther = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->where('emp_gender', 3)
            ->count();
        $CurrentMonthCounterEmployeeAdd = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->whereMonth('created_at', self::allValueGet()[2])
            ->count();
        if ($totalEmployee != null || $GenderMale != null || $GenderFemale != null || $GenderOther != null || $CurrentMonthCounterEmployeeAdd != null) {
            return [$totalEmployee, $GenderMale, $GenderFemale, $GenderOther, $CurrentMonthCounterEmployeeAdd];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    // GenderCheck on Loader
    static function GenderCheck()
    {
        $load = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->where('emp_id', Session::get('login_emp_id'))
            ->select('emp_gender')
            ->first();
        if ($load != null) {
            if ($load->emp_gender == 2) {
                return ''; //Miss.
            }
            if ($load->emp_gender == 1) {
                return ''; //Mr.
            }
        } else {
            return '';
        }
    }

    // Role & Permission use in Attendance Side
    static function RoleDetailsGet()
    {
        $getRoleAssignID = self::allValueGet()[7];
        if ($getRoleAssignID != null) {

            return [$getRoleAssignID, 0];
        } else {

            return [0, 0];
        }
    }
    static function LeavePolicyCategory($id)
    {
        $load = DB::table('setting_leave_category')
            ->where('business_id', self::allValueGet()[5])
            ->where('leave_policy_id', $id)
            ->get();
        if ($load != null) {
            return $load;
        } else {
            return '';
        }
    }

    static function GetPolicysCount($id)
    {
        $holiday_policy = DB::table('holiday_details')
            ->where('template_id', $id)
            ->where('business_id', self::allValueGet()[5])
            ->count();
        //  || ($department != null) || ($designation != null) || ($adminCount != null)
        if ($holiday_policy != null) {
            // department, $designation, $adminCount
            return [$holiday_policy];
        } else {
            return [0, 0, 0, 0];
        }
    }
    // Loading status in Roles JAY
    static function GetRoles()
    {
        // change role
        if (isset(self::$BusinessID) && isset(self::$BranchID)) {
            $Roles = DB::table('setting_role_items')
                ->where('business_id', self::$BusinessID)
                ->where('branch_id', self::$BranchID)
                ->select('*') // Select all columns from all three tables
                ->get();
            return $Roles;
        }
        if (isset(self::$BusinessID)) {
            $Roles = DB::table('setting_role_items')
                ->where('business_id', self::$BusinessID)
                ->select('*') // Select all columns from all three tables
                ->get();
            return $Roles;

            // ->where('setting_leave_policy.branch_id', $branchID)
        }
        if (isset(self::$BranchID)) {
            $Roles = DB::table('setting_role_items')
                ->where('branch_id', self::$BranchID)
                ->select('*') // Select all columns from all three tables
                ->get();
            return $Roles;
        }
        return '';

        // $Roles = DB::table('roles')->where(['business_id' =>  self::$BusinessID])->select('*')->get();
    }

    // Attendance USED PACKAGES Status Managements Rules Power By JAYANT
    public function AttendanceActiveModesCheck()
    {
        $load_Attendance_Mode = DB::table('policy_attendance_mode')
            ->where('business_id', self::$BusinessID)
            ->first();
        if ($load_Attendance_Mode != null) {
            return [$load_Attendance_Mode, 0, 0];
        } else {
            return [0, 0, 0]; //off or false case
        }
    }

    // attendance Counter
    public function AttendanceCounters()
    {
        $load_Attendance_ShiftCount = DB::table('policy_attendance_shift_settings')
            ->where('business_id', self::$BusinessID)
            ->count();
        if ($load_Attendance_ShiftCount != null) {
            return [$load_Attendance_ShiftCount, 0, 0];
        } else {
            return [0, 0, 0]; //off or false case
        }
    }

    // attendance Shift check by ID
    public function AttedanceShiftCheckItems($ID)
    {
        $checked = DB::table('policy_attendance_shift_settings')
            ->where('id', $ID)
            ->where('business_id', self::$BusinessID)
            ->first();
        if ($checked != null) {
            return $checked->shift_type;
        } else {
            return '';
        }
    }

    // Shift- FindOut Dateformate
    // public function AttendanceShiftDataGet($ID)
    // {

    // }

    // conversion 24 to 12 horus Time any-value
    public function Convert24To12($value)
    {
        $valueNOTNull = '';
        if ($value != null) {
            $valueNOTNull = date('h:i A', strtotime($value)); //twentyFourHourTime
            return $valueNOTNull;
        }
        return $valueNOTNull;
    }

    // Attendance TrackIn&Out
    public function TrackInOutStatus()
    {
        $load = DB::table('policy_attendance_track_in_out')
            ->where('business_id', self::$BusinessID)
            ->first();
        if ($load != null) {
            return $load;
        }
        // return 'OFF';
    }

    // Store or check Response on Attendance Both side used api
    // public function AttendanceResponsePass()
    // {

    // }
    static public function RoleName($ID)
    {

        $check = DB::table('policy_setting_role_create')->where('id', $ID)->first();

        if ($check != null) {
            return [$check];
        } else {
            return [0];
        }
    }

    // Upcoming Approval-Management SettingUpdated
    // 0 index get All Details
    static public function ApprovalGetDetails($approvalTypeID)
    {
        // StaticApprovalName ApprovalManagementCycle
        $AttendanceApproval = DB::table('approval_management_cycle')->where('business_id', self::allValueGet()[5])
            ->where('approval_type_id', $approvalTypeID)
            ->first();
        // Checking Approval Cycle Type like Sequential ,Parallel

        // else {
        //     $cycleType = 1;
        // }
        // || $CycleType->cycle_type != null

        if ($AttendanceApproval != null) {
            $CycleType = DB::table('approval_management_cycle')->where('business_id', self::allValueGet()[5])->where('cycle_type', $AttendanceApproval->cycle_type)->select('cycle_type')->first();
            $cycleType = 2;
            if ($CycleType->cycle_type != null) {
                $cycleType = $CycleType->cycle_type;
            }
            return [$AttendanceApproval, $cycleType, 0];
        } else {
            return [0, 0, 0]; //off or false case
        }
    }
    // Current Status Leave Approval Checking Set
    static public function CheckLeaveApprovalStatus($primaryID, $bID, $findRoleID)
    {
        $findRole = DB::table('request_leave_list')->where('id', $primaryID)->where('business_id', $bID)->select('approved_by_status', 'approved_by_emp_id', 'approved_by_role_id')->first();

        if ($findRole != null) {
            return [$findRole];
        } else {
            return [0]; //off or false case
        }
    }

    public function MonthlyData($year, $month) //api month attendance
    {
        // Create a Carbon object representing the first day of the specified month and year.
        // $startDate = Carbon::createFromDate($year, $month, 1);
        // $endDate = $startDate->endOfMonth();
        $month = Carbon::createFromDate($year, $month, 1);
        $nextMonth = $month->copy()->endOfMonth();

        return $month->diffInDaysFiltered(function ($date) {
            return $date->isSunday();
        }, $nextMonth);
    }

    // 
    static public function FinalRequestStatusSubmitFilterValue($ID, $ApprovalType)
    {
        $statusCounts = DB::table('approval_status_list')
            ->where('business_id', self::allValueGet()[5])
            ->where('all_request_id', $ID)
            ->where('status',2)
            ->where('approval_type_id', $ApprovalType)
            ->select('status')
            ->get();

        $maxStatusValue = 0;

        if ($statusCounts->isNotEmpty()) {
            // If there is at least one row, set $maxStatusValue to 2
            $maxStatusValue = 2;
        } else {
            // If there are no rows, set $maxStatusValue to 1
            $maxStatusValue = 1;
        }
        // $maxStatusValue = $statusCounts->firstWhere('count', 2) ? 2 : 1;

        //  dd($maxStatusValue, $count);  
        if ($maxStatusValue != null) {
            return [$maxStatusValue];
        } else {
            return [0];
        }
    }



    // all details get session
    public static function PassBy()
    {
        return [self::allValueGet()[4], self::allValueGet()[5], self::allValueGet()[8], self::allValueGet()[7]];
    }

    // $currentDate = date('Y-m-d');
    // echo "Standard Date Format: $currentDate";

    // $currentTime24 = date('H:i:s');
    // echo "Standard 24-Hour Time Format: $currentTime24";

    // $currentTime12 = date('h:i A');
    // echo "Standard 12-Hour Time Format: $currentTime12";

    // loaded as constructor used
    public static function allValueGet()
    {
        $now = Carbon::now(); //Package initialize
        // all need packages builders
        self::$UserType = Session::get('user_type'); //Other checking loader
        self::$BusinessID = Session::get('business_id');
        self::$BranchID = Session::get('branch_id');
        self::$LoginRole = Session::get('login_role'); //role table id : 8
        self::$LoginEmpID = Session::get('login_emp_id');
        // login_emp_id
        // self::$LoginModelType = Session::get('model_type'); //type loginModel : admin
        self::$LoginModelID = Session::get('model_id'); //user id like : FD001
        self::$LoginName = Session::get('login_name');
        self::$LoginEmail = Session::get('login_email');
        self::$LoginBusinessImage = Session::get('login_business_image'); //bimg

        self::$Today = $now->format('Y-m-d H:i:s');
        self::$currentDay = $now->day;
        self::$currentMonth = $now->month;
        self::$currentYear = $now->year;

        return [self::$Today, self::$currentDay, self::$currentMonth, self::$currentYear, self::$UserType, self::$BusinessID, self::$BranchID, self::$LoginRole, self::$LoginEmpID, self::$LoginModelID, self::$LoginName, self::$LoginEmail, self::$LoginBusinessImage];
    }

    function CalculateTimeDifference($inTime, $outTime)
    {
        // Parse the input timestamps as Carbon objects
        $inTimeObj = Carbon::parse($inTime);
        $outTimeObj = Carbon::parse($outTime);

        // Calculate the time difference
        $timeDifference = $outTimeObj->diff($inTimeObj);

        // return $timeDifference;
    }

    public function CalculateLateBy($OfficeShiftStart, $PunchinTimeObj, $graceTimeHr, $grachTimeMin)
    {
        // ActualGarceMin Hours + Minutes
        $actualGraceMin = $graceTimeHr * 60 + $grachTimeMin;
        // officestart time
        $OfficeShiftStart = Carbon::parse($OfficeShiftStart);
        $officeShiftStartTime = Carbon::parse($OfficeShiftStart);
        // officestarttime + Grace time
        $officeStartGraceTime = $OfficeShiftStart->addMinutes($actualGraceMin);
        // $graceTime = date('H:i', strtotime($officeStartGraceTime));
        $FinalGraceTime = Carbon::parse($officeStartGraceTime);
        $PunchinTimeObj = Carbon::parse($PunchinTimeObj);
        // dd($PunchinTimeObj);

        if ($PunchinTimeObj >= $FinalGraceTime) {
            $lateTime = $officeShiftStartTime->diff($PunchinTimeObj);
            return $lateTime->format('-%H:%I') . ' Min.'; // Format the late time
        }
    }
}
