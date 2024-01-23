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

use App\Models\LoginAdmin;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
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
// use Illuminate\Support\Facades\Crypt;
use App\Models\StaticCountryModel;
use App\Models\StaticStatesModel;
use App\Models\StaticCityModel;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinEmpType;

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
        // dd(session('model_id'));
        // dd(self::$BusinessID,self::$UserType,self::$BranchID,self::$LoginRole,self::$LoginModelID,self::$LoginEmail,self::$LoginName);
        // like storage AT BusinessLoad ID 5
    }

    public static function myHelperFunction($parameter)
    {
        return "Hello THIS IS Rule MANAGEMENT, $parameter!";
    }
    public static function removeSpaces($string)
    {
        return str_replace(' ', '', $string);
    }

    // Todays Status started
    public static function TodayStatus()
    {
        $load = Session::get('business_id');
        // $data = "aman ' .$load  . '";
        return [self::allValueGet()[0], $load];
    }

    // Checking Country-State-City
    public static function getCheckingBusinessCheck($branch, $department, $designation)
    {
        $SessionBusiness = Session::get('business_id');

        $Branch = BranchList::where('business_id', $SessionBusiness)->where('branch_name', '=', $branch)->first();
        $Department = DepartmentList::where('business_id', $SessionBusiness)->where('depart_name', '=', $department)->first();
        $Designation = DesignationList::where('business_id', $SessionBusiness)->where('desig_name', '=', $designation)->first();

        if ($Branch != null && $Department != null && $Designation != null) {
            return [$Branch->branch_name, $Department->depart_name, $Designation->desig_name];
        } else {
            return ['', '', ''];
        }
    }

    // Checking Country-State-City
    public static function getCheckingCountryStateCity($country, $state, $city)
    {
        //remove space
        $countries = self::removeSpaces($country);
        $states = self::removeSpaces($state);
        $cities = self::removeSpaces($city);
        $AllCountry = StaticCountryModel::where('name', '=', $countries)->first();
        $AllStates = null;
        $AllCities = null;

        if ($AllCountry != null) {
            $AllStates = StaticStatesModel::where('country_id',$AllCountry->id)
                ->where('name', '=', $states)
                ->first();
        }

        if ($AllStates != null) {
            $AllCities = StaticCityModel::where('state_id', $AllStates->id)
                ->where('name', '=', $cities)
                ->first();
        }

        if ($AllCountry != null && $AllStates != null && $AllCities != null) {
            return [$AllCountry->name, $AllStates->name, $AllCities->name];
        } else {
            return [ '', '', ''];
        }
    }
    public static function getCheckingEmployeeType($empID)
    {
        $empType = self::removeSpaces($empID);
        $load = StaticEmployeeJoinEmpType::where('emp_type', '=', $empType)->first();
        if ($load != null) {
            return [$load->type_id];
        } else {
            return [''];
        }
    }
    public static function getCheckingBloodGroup($bloodGroup)
    {
        $bloodgroup = self::removeSpaces($bloodGroup);
        $load = StaticEmployeeJoinBloodGroup::where('blood_group', '=', $bloodgroup)->first();
        if ($load != null) {
            return [$load->id];
        } else {
            return [''];
        }
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
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', self::allValueGet()[5])->get();
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
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', $BID)->get();
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
        $leaveCount = PolicySettingLeavePolicy::where('business_id', self::allValueGet()[5])->count();
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

    static function AssociatedUser($ID)
    {
        $AssociatedUser = DB::table('employee_personal_details')
            ->where('business_id', self::allValueGet()[5])
            ->where('master_endgame_id', $ID)
            ->count();
        if ($AssociatedUser != null) {
            return [$AssociatedUser, 0, 0, 0, 0, 0, 0, 0];
        } else {
            return [0, 0, 0, 0, 0, 0, 0, 0];
        }
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
    public static function RoleName($ID)
    {
        $check = DB::table('policy_setting_role_create')
            ->where('id', $ID)
            ->first();

        if ($check != null) {
            return [$check];
        } else {
            return [0];
        }
    }

    // Upcoming Approval-Management SettingUpdated
    // 0 index get All Details
    public static function ApprovalGetDetails($approvalTypeID)
    {
        // StaticApprovalName ApprovalManagementCycle
        $AttendanceApproval = DB::table('approval_management_cycle')
            ->where('business_id', self::allValueGet()[5])
            ->where('approval_type_id', $approvalTypeID)
            ->first();
        // Checking Approval Cycle Type like Sequential ,Parallel

        // else {
        //     $cycleType = 1;
        // }
        // || $CycleType->cycle_type != null

        if ($AttendanceApproval != null) {
            $CycleType = DB::table('approval_management_cycle')
                ->where('business_id', self::allValueGet()[5])
                ->where('cycle_type', $AttendanceApproval->cycle_type)
                ->select('cycle_type')
                ->first();
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
    public static function CheckLeaveApprovalStatus($primaryID, $bID, $findRoleID)
    {
        $findRole = DB::table('request_leave_list')
            ->where('id', $primaryID)
            ->where('business_id', $bID)
            ->select('approved_by_status', 'approved_by_emp_id', 'approved_by_role_id')
            ->first();

        if ($findRole != null) {
            return [$findRole];
        } else {
            return [0]; //off or false case
        }
    }

    public function MonthlyData($year, $month)
    {
        //api month attendance
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
    public static function FinalRequestStatusSubmitFilterValue($ID, $ApprovalType)
    {
        $statusCounts = DB::table('approval_status_list')
            ->where('business_id', self::allValueGet()[5])
            ->where('all_request_id', $ID)
            ->where('approval_type_id', $ApprovalType)
            ->where('status', 2)
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

    public static function RequestGatePassApprovalManage($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID)
    {
        $loginRoleBID = self::allValueGet()[5];
        // checking the current status approvalStatusList
        $checkingCover = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();

        $LatestRemark = $checkingCover != null ? $checkingCover->remarks : ''; // latest remark according to approval typeid = 4 and last entry with the primary id
        $LatestStatusName = $checkingCover != null ? $checkingCover->request_response : '';
        $LatestStatusValue = $checkingCover->status ?? 0;
        $LatestRequestColor = $checkingCover->request_color ?? 0;
        $LatestRequestBtnColor = $checkingCover->btn_color ?? 0;
        $LatestTooltipColor = $checkingCover->tooltip_color ?? 0;

        $LastDeclineStatusRemark = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->where('status', 2)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();

        if ($checkApprovalCycleType == 1) {
            // sequential type check
            if ($checkingCover != null) {
                $checkingCoversLoad = DB::table('approval_status_list')
                    ->where('business_id', $loginRoleBID)
                    ->where('role_id', $loginRoleID)
                    ->where('approval_type_id', $approvalTypeIdStatic)
                    ->where('all_request_id', $itemID)
                    ->orderBy('approval_status_list.created_at', 'desc')
                    ->first();

                if ($checkingCoversLoad) {
                    // approval status list action performed or not
                    $CheckCurrentStaticStatus = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.business_id', $loginRoleBID)
                        ->where('approval_status_list.role_id', $loginRoleID)
                        ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->orderBy('approval_status_list.created_at', 'desc')
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();
                    // dd($CheckCurrentStaticStatus);
                    if ($CheckCurrentStaticStatus != null) {
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0]; // check the next role id
                        $ForwardName = $CheckingRole->roles_name ?? 0;

                        if ($itemIteration->process_complete == 1) {
                            // if all final process completer
                            $SD = DB::table('request_gatepass_list')
                                ->join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')
                                ->where('request_gatepass_list.business_id', $loginRoleBID)
                                ->where('request_gatepass_list.id', $itemID)
                                ->select('request_gatepass_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name;
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                // dd("kya chal raha");
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';

                                // return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                                // dd($LatestStatusValue);
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                // dd($SD->final_status);
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                            }

                            // return '<small><span class="' . $statusColor . '">' . $statusIcon . ' ' . $statusResponse . '</span></small>';
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name;

                            if ($LatestStatusValue == 1) {
                                // dd($CheckingRole);
                                // dd($CheckCurrentStaticStatus->request_response);
                                // dd($ForwardName);
                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $CheckCurrentStaticStatus->request_response . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {
                                // dd($CheckCurrentStaticStatus);

                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> ' . nl2br($LatestStatusName) . '</small>';
                            }

                            $checkingLoad = DB::table('approval_management_cycle')
                                ->where('business_id', Session::get('business_id'))
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->whereJsonContains('role_id', (string) $loginRoleID)
                                ->select('role_id')
                                ->first();

                            $roleIds = json_decode($checkingLoad->role_id, true);
                            $currentIndex = array_search($loginRoleID, $roleIds);
                            $nextIndex = $currentIndex + 1;
                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1;

                            $ApprovedName = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_status_list.business_id', $loginRoleBID)
                                ->where('approval_status_list.role_id', $loginRoleID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->first();
                            $CheckingLoad = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                ->first();

                            $gotoPow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotoPow->roles_name ?? 0;
                            if ($ApprovedName2 != 0) {
                                // dd($CheckingLoad);
                                if (isset($CheckingLoad)) {
                                    if ($CheckingLoad->status == 1) {
                                        // return '<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                    }
                                    if ($CheckingLoad->status == 2) {
                                        // dd($ForwardStaticName);
                                        // return '<br><small>Decliend To ' . $ApprovedName2 . '</small>';
                                    }
                                } else {
                                }
                            }
                        }
                    }
                } else {
                    $requestGet = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->where('approval_status_list.next_role_id', $loginRoleID)
                        ->where('approval_status_list.applied_cycle_type', 1)
                        ->where('approval_status_list.approval_type_id', '=', $approvalTypeIdStatic)
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();
                    // dd($requestGet);
                    if ($requestGet ?? false) {
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            // dd($requestGet);
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<br>Declined By ' . $DeclinedName . '<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            // dd($requestGet);
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            // dd($requestGet);

                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                        // dd($CheckCurrentStaticStatusSecond);
                    } else {
                        $CheckCurrentStaticStatusSecond = DB::table('request_gatepass_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_gatepass_list.id')
                            ->join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('request_gatepass_list.id', $itemID)
                            ->where('request_gatepass_list.business_id', $loginRoleBID)
                            ->select('request_gatepass_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->first();
                        // dd($CheckCurrentStaticStatusSecond);
                        if ($CheckCurrentStaticStatusSecond) {
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            // dd($CheckCurrentStaticStatusSecond->status);
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                // dd($CheckCurrentStaticStatusSecond);
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                // dd($CheckCurrentStaticStatusSecond->final_status);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br>'.$DeclinedName .' Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                // dd('hi');
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $LatestStatusName . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    // dd("hii");
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    // dd($CheckCurrentStaticStatusSecond);

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>'. $DeclinedName .' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-placement="top" data-bs-content="' . $HoverStatus . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    // dd('hii');
                                    // dd($CheckCurrentStaticStatusSecond->request_response);
                                    // dd($ForwardNameGET);
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i>  Pending</small>';
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> Pending</small>';
                                }
                                // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';

                            // return '<span class="badge badge-warning-light"><i class="ion-wand"></i>Requested</span>';
                        }

                        // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                    }
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }

        if ($checkApprovalCycleType == 2) {
            $CheckCurrentStaticStatusSecond = DB::table('request_gatepass_list')
                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_gatepass_list.id')
                ->join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')
                ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                ->where('request_gatepass_list.id', $itemID)
                ->where('request_gatepass_list.business_id', $loginRoleBID)
                ->orderBy('approval_status_list.created_at', 'desc')
                ->first();
            // ->where('approval_status_list.applied_cycle_type', 2)
            // return $itemID;
            if (!empty($CheckCurrentStaticStatusSecond)) {
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                // dd($CheckCurrentStaticStatusSecond);
                $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                    // dd("datga");
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    // dd($CheckCurrentStaticStatusSecond);
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';

                    // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }
    }

    public static function RequestLeaveApprovalManage($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID)
    {
        $loginRoleBID = self::allValueGet()[5];

        $checkingCover = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        $LatestRemark = $checkingCover != null ? $checkingCover->remarks : ''; // lateset remark according to approvaltypeid = 4 and last entry with the primary id
        $LatestStatusName = $checkingCover != null ? $checkingCover->request_response : '';
        $LatestStatusValue = $checkingCover->status ?? 0;
        $LatestRequestColor = $checkingCover->request_color ?? 0;
        $LatestRequestBtnColor = $checkingCover->btn_color ?? 0;
        $LatestTooltipColor = $checkingCover->tooltip_color ?? 0;

        $LastDeclineStatusRemark = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->where('status', 2)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        if ($checkApprovalCycleType == 1) {
            // Check for Pending Status
            if ($checkingCover != null) {
                $checkingCoversLoad = DB::table('approval_status_list')
                    ->where('business_id', $loginRoleBID)
                    ->where('role_id', $loginRoleID)
                    ->where('approval_type_id', $approvalTypeIdStatic)
                    ->where('all_request_id', $itemID)
                    ->orderBy('approval_status_list.created_at', 'desc')
                    ->first();

                if ($checkingCoversLoad) {
                    $CheckCurrentStaticStatus = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.business_id', $loginRoleBID)
                        ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->orderBy('approval_status_list.created_at', 'desc')
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();

                    if ($CheckCurrentStaticStatus != null) {
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;

                        if ($itemIteration->process_complete == 1) {
                            // if all final process completer
                            $SD = DB::table('request_leave_list')
                                ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                ->where('request_leave_list.business_id', $loginRoleBID)
                                ->where('request_leave_list.id', $itemID)
                                ->select('request_leave_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name;
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i>' : '<i class="ion-close-circled"></i>';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                // dd("kya chal raha");
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                // dd($SD->final_status);
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                        } else {
                            // $forwared = true;
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name;

                            if ($LatestStatusValue == 1) {
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> ' . nl2br($LatestStatusName) . '</small>';
                            }

                            $checkingLoad = DB::table('approval_management_cycle')
                                ->where('business_id', Session::get('business_id'))
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->whereJsonContains('role_id', (string) $loginRoleID)
                                ->select('role_id')
                                ->first();

                            $roleIds = json_decode($checkingLoad->role_id, true);
                            $currentIndex = array_search($loginRoleID, $roleIds);
                            $nextIndex = $currentIndex + 1;
                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1;

                            $ApprovedName = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_status_list.business_id', $loginRoleBID)
                                ->where('approval_status_list.role_id', $loginRoleID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->first();
                            $CheckingLoad = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                ->first();

                            $gotopow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotopow->roles_name ?? 0;

                            if ($ApprovedName2 != 0) {
                                if (isset($CheckingLoad)) {
                                    if ($CheckingLoad->status == 1) {
                                        // return '<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                    }
                                    if ($CheckingLoad->status == 2) {
                                        // return '<br><small>Decliend To ' . $ApprovedName2 . '</small>';
                                    }
                                } else {
                                }
                            }
                        }
                    }
                } else {
                    $requestGet = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->where('approval_status_list.next_role_id', $loginRoleID)
                        ->where('approval_status_list.applied_cycle_type', 1)
                        ->where('approval_status_list.approval_type_id', '=', $approvalTypeIdStatic)
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();
                    // dd($requestGet);
                    if ($requestGet ?? false) {
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            // dd($requestGet);
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<br>Declined By ' . $DeclinedName . '<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            // dd($requestGet);
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            // dd($requestGet);

                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                    } else {
                        $CheckCurrentStaticStatusSecond = DB::table('request_leave_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
                            ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('request_leave_list.id', $itemID)
                            ->where('request_leave_list.business_id', $loginRoleBID)
                            ->select('request_leave_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->first();
                        // dd($CheckCurrentStaticStatusSecond);
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                        $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                        $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                        if ($CheckCurrentStaticStatusSecond) {
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            // dd($CheckCurrentStaticStatusSecond->status);
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                // dd($CheckCurrentStaticStatusSecond);
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                // dd($CheckCurrentStaticStatusSecond->final_status);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br>'.$DeclinedName .' Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                // dd('hi');
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $LatestStatusName . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    // dd("nii");
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    // dd($CheckCurrentStaticStatusSecond);

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>'. $DeclinedName .' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-placement="top" data-bs-content="' . $HoverStatus . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    // dd('hii');
                                    // dd($CheckCurrentStaticStatusSecond->request_response);
                                    // dd($ForwardNameGET);
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i>  Pending</small>';
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> Pending</small>';
                                }
                                // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';

                            // return '<span class="badge badge-warning-light"><i class="ion-wand"></i>Requested</span>';
                        }

                        // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Padding</span>';
                    }
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }

        if ($checkApprovalCycleType == 2) {
            $CheckCurrentStaticStatusSecond = DB::table('request_leave_list')
                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
                ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                ->where('request_leave_list.id', $itemID)
                ->where('request_leave_list.business_id', $loginRoleBID)
                ->orderBy('approval_status_list.created_at', 'desc')
                ->first();
            if (!empty($CheckCurrentStaticStatusSecond)) {
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                // dd($CheckCurrentStaticStatusSecond);
                $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                    // dd("datga");
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    // dd($CheckCurrentStaticStatusSecond);
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';

                    // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }
    }

    public static function RequestMispunchApprovalManage($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID)
    {
        $loginRoleBID = self::allValueGet()[5];
        $checkingCover = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        $LatestRemark = $checkingCover != null ? $checkingCover->remarks : ''; // lateset remark according to approvaltypeid = 4 and last entry with the primary id
        $LatestStatusName = $checkingCover != null ? $checkingCover->request_response : '';
        $LatestStatusValue = $checkingCover->status ?? 0;
        $LatestRequestColor = $checkingCover->request_color ?? 0;
        $LatestRequestBtnColor = $checkingCover->btn_color ?? 0;
        $LatestTooltipColor = $checkingCover->tooltip_color ?? 0;
        // dd($itemID);
        // dd($checkingCover);
        $LastDeclineStatusRemark = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->where('status', 2)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        $RoleRedCode = DB::table('request_mispunch_list')
            ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
            ->where('request_mispunch_list.business_id', $loginRoleBID)
            ->where('request_mispunch_list.id', $itemID)
            ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        if ($checkApprovalCycleType == 1) {
            // Check for Pending Status
            if ($checkingCover != null) {
                $checkingCoversLoad = DB::table('approval_status_list')
                    ->where('business_id', $loginRoleBID)
                    ->where('role_id', $loginRoleID)
                    ->where('approval_type_id', $approvalTypeIdStatic)
                    ->where('all_request_id', $itemID)
                    ->orderBy('approval_status_list.created_at', 'desc')
                    ->first();
                // dd($checkingCoversLoad);

                if ($checkingCoversLoad) {
                    $CheckCurrentStaticStatus = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.business_id', $loginRoleBID)
                        ->where('approval_status_list.role_id', $loginRoleID)
                        ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->orderBy('approval_status_list.created_at', 'desc')
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();

                    if ($CheckCurrentStaticStatus != null) {
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        // dd($item->process_complete);

                        if ($itemIteration->process_complete == 1) {
                            $SD = DB::table('request_mispunch_list')
                                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                ->where('request_mispunch_list.business_id', $loginRoleBID)
                                ->where('request_mispunch_list.id', $itemID)
                                ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();

                            // dd($checkingCover);
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name;
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';

                            // $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i>' : '<i class="ion-close-circled"></i>';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                // dd("kya chal raha");
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';

                                // return'<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                                // dd($LatestStatusValue);
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                // dd($SD->final_status);
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name;

                            if ($LatestStatusValue == 1) {
                                // dd($CheckingRole);
                                // dd($CheckCurrentStaticStatus->request_response);
                                // dd($ForwardName);
                                // return'<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $CheckCurrentStaticStatus->request_response . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {
                                // dd($CheckCurrentStaticStatus);

                                // return'<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                // return'<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> ' . nl2br($LatestStatusName) . '</small>';
                            }

                            $checkingLoad = DB::table('approval_management_cycle')
                                ->where('business_id', Session::get('business_id'))
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->whereJsonContains('role_id', (string) $loginRoleID)
                                ->select('role_id')
                                ->first();

                            $roleIds = json_decode($checkingLoad->role_id, true);
                            $currentIndex = array_search($loginRoleID, $roleIds);
                            $nextIndex = $currentIndex + 1;
                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1;

                            $ApprovedName = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_status_list.business_id', $loginRoleBID)
                                ->where('approval_status_list.role_id', $loginRoleID)
                                ->where('approval_type_id', 3)
                                ->first();
                            $CheckingLoad = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                ->first();
                            // ->where('role_id', $nextRoleId)

                            $gotopow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotopow->roles_name ?? 0;

                            if ($ApprovedName2 != 0) {
                                // dd($CheckingLoad);
                                if (isset($CheckingLoad)) {
                                    if ($CheckingLoad->status == 1) {
                                        // return'<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                    }
                                    if ($CheckingLoad->status == 2) {
                                        // return'<br><small>Decliend To ' . $ApprovedName2 . '</small>';
                                    }
                                } else {
                                }
                            }
                        }
                    }
                } else {
                    $requestGet = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->where('approval_status_list.next_role_id', $loginRoleID)
                        ->where('approval_status_list.applied_cycle_type', 1)
                        ->where('approval_status_list.approval_type_id', '=', $approvalTypeIdStatic)
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();
                    // dd($requestGet);
                    if ($requestGet ?? false) {
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            // dd($requestGet);
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>Declined By' . $DeclinedName . '</br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                    } else {
                        // dd($CheckCurrentStaticStatusSecond);} else {
                        $CheckCurrentStaticStatusSecond = DB::table('request_mispunch_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
                            ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('request_mispunch_list.id', $itemID)
                            ->where('request_mispunch_list.business_id', $loginRoleBID)
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->select('request_mispunch_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->first();

                        $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                        $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                        // dd($CheckCurrentStaticStatusSecond);
                        if ($CheckCurrentStaticStatusSecond) {
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            // dd($CheckCurrentStaticStatusSecond->status);
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                // dd("chc");
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                // dd($CheckCurrentStaticStatusSecond);
                                // return'<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                // dd($CheckCurrentStaticStatusSecond->final_status);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return'<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br>'.$DeclinedName .' Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return'<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                // dd('hi');
                                // return'<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $LatestStatusName . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return'<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    // dd($CheckCurrentStaticStatusSecond);

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                    // return'<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>'. $DeclinedName .' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return'<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-placement="top" data-bs-content="' . $HoverStatus . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> Pending</small>';
                                    // return'<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    // dd('hii');
                                    // dd($CheckCurrentStaticStatusSecond->request_response);
                                    // dd($ForwardNameGET);
                                    // return'<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i>  Pending</small>';
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return'<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> Pending</small>';
                                }
                                // return'<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';

                            // return'<span class="badge badge-warning-light"><i class="ion-wand"></i>Requested</span>';
                        }

                        // return'<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                    }
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }

        if ($checkApprovalCycleType == 2) {
            $CheckCurrentStaticStatusSecond = DB::table('request_mispunch_list')
                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                ->where('request_mispunch_list.id', $itemID)
                ->where('request_mispunch_list.business_id', $loginRoleBID)
                ->orderBy('approval_status_list.created_at', 'desc')
                ->first();

            if (!empty($CheckCurrentStaticStatusSecond)) {
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                // dd($CheckingRole);
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);

                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }
    }

    public static function AttendanceApprovalManage($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID)
    {
        $loginRoleBID = self::allValueGet()[5];

        // checkig the current status approvalStatusList
        $checkingCover = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        $LatestRemark = $checkingCover != null ? $checkingCover->remarks : ''; // lateset remark according to approvaltypeid = 4 and last entry with the primary id
        $LatestStatusName = $checkingCover != null ? $checkingCover->request_response : '';
        $LatestStatusValue = $checkingCover->status ?? 0;
        $LatestRequestColor = $checkingCover->request_color ?? 0;
        $LatestRequestBtnColor = $checkingCover->btn_color ?? 0;
        $LatestTooltipColor = $checkingCover->tooltip_color ?? 0;
        $LastDeclineStatusRemark = DB::table('approval_status_list')
            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
            ->where('business_id', $loginRoleBID)
            ->where('approval_type_id', $approvalTypeIdStatic)
            ->where('all_request_id', $itemID)
            ->where('status', 2)
            ->orderBy('approval_status_list.created_at', 'desc')
            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();
        $RoleRedCode = DB::table('attendance_list')
            ->join('static_status_request', 'attendance_list.final_status', '=', 'static_status_request.id')
            ->where('attendance_list.business_id', $loginRoleBID)
            ->where('attendance_list.id', $itemID)
            ->select('attendance_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
            ->first();

        if ($checkApprovalCycleType == 1) {
            // sequentinal type check

            if ($checkingCover != null) {
                $checkingCoversLoad = DB::table('approval_status_list')
                    ->where('business_id', $loginRoleBID)
                    ->where('role_id', $loginRoleID)
                    ->where('approval_type_id', $approvalTypeIdStatic)
                    ->where('all_request_id', $itemID)
                    ->orderBy('approval_status_list.created_at', 'desc')
                    ->first();
                if ($checkingCoversLoad) {
                    // approval status list action performed or not
                    $CheckCurrentStaticStatus = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.business_id', $loginRoleBID)
                        ->where('approval_status_list.role_id', $loginRoleID)
                        ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->orderBy('approval_status_list.created_at', 'desc')
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();

                    if ($CheckCurrentStaticStatus != null) {
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0]; // check the next role id

                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        // dd($item->process_complete);
                        if ($itemIteration->process_complete == 1) {
                            // if all final process completer
                            $SD = DB::table('attendance_list')
                                ->join('static_status_request', 'attendance_list.final_status', '=', 'static_status_request.id')
                                ->where('attendance_list.business_id', $loginRoleBID)
                                ->where('attendance_list.id', $itemID)
                                ->select('attendance_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name;
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                // dd("kya chal raha");
                                // dd($LastDeclineStatusRemark);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';

                                // return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                                // dd($LatestStatusValue);
                            } elseif ($SD->final_status == 1) {
                                // dd($item->final_status);

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                // dd($SD->final_status);
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                            }

                            // return '<small><span class="' . $statusColor . '">' . $statusIcon . ' ' . $statusResponse . '</span></small>';
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name;

                            if ($LatestStatusValue == 1) {
                                // dd($CheckingRole);
                                // dd($CheckCurrentStaticStatus->request_response);
                                // dd($ForwardName);
                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $CheckCurrentStaticStatus->request_response . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {
                                // dd($CheckCurrentStaticStatus);

                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                // return '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> ' . nl2br($LatestStatusName) . '</small>';
                            }

                            $checkingLoad = DB::table('approval_management_cycle')
                                ->where('business_id', Session::get('business_id'))
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->whereJsonContains('role_id', (string) $loginRoleID)
                                ->select('role_id')
                                ->first();

                            $roleIds = json_decode($checkingLoad->role_id, true);
                            $currentIndex = array_search($loginRoleID, $roleIds);
                            $nextIndex = $currentIndex + 1;
                            $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1;

                            $ApprovedName = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_status_list.business_id', $loginRoleBID)
                                ->where('approval_status_list.role_id', $loginRoleID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->first();
                            $CheckingLoad = DB::table('approval_status_list')
                                ->where('all_request_id', $itemID)
                                ->where('approval_type_id', $approvalTypeIdStatic)
                                ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                ->first();

                            $gotopow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotopow->roles_name ?? 0;
                            if ($ApprovedName2 != 0) {
                                // dd($CheckingLoad);
                                if (isset($CheckingLoad)) {
                                    if ($CheckingLoad->status == 1) {
                                        // return '<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                    }
                                    if ($CheckingLoad->status == 2) {
                                        // dd($ForwardStaticName);
                                        // return '<br><small>Decliend To ' . $ApprovedName2 . '</small>';
                                    }
                                } else {
                                }
                            }
                        }
                    }
                } else {
                    $requestGet = DB::table('approval_status_list')
                        ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                        ->where('approval_status_list.all_request_id', $itemID)
                        ->where('approval_status_list.next_role_id', $loginRoleID)
                        ->where('approval_status_list.applied_cycle_type', 1)
                        ->where('approval_status_list.approval_type_id', '=', $approvalTypeIdStatic)
                        ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                        ->first();

                    if ($requestGet ?? false) {
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? 0;
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            // dd($requestGet);
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>' . $DeclinedName . '  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            // dd($requestGet);
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            // dd($requestGet);

                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                        // dd($CheckCurrentStaticStatusSecond);
                    } else {
                        $CheckCurrentStaticStatusSecond = DB::table('attendance_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'attendance_list.id')
                            ->join('static_status_request', 'attendance_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('attendance_list.id', $itemID)
                            ->where('attendance_list.business_id', $loginRoleBID)
                            ->select('attendance_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->first();

                        if ($CheckCurrentStaticStatusSecond) {
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            // dd($CheckCurrentStaticStatusSecond->status);
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                // dd($CheckCurrentStaticStatusSecond);
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                // dd($CheckCurrentStaticStatusSecond->final_status);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id ?? 0)[0]->roles_name ?? 0;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br>'.$DeclinedName .' Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                // dd('hi');
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $LatestStatusName . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    // dd($CheckCurrentStaticStatusSecond);

                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>'. $DeclinedName .' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-placement="top" data-bs-content="' . $HoverStatus . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    // dd('hii');
                                    // dd($CheckCurrentStaticStatusSecond->request_response);
                                    // dd($ForwardNameGET);
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i>  Pending</small>';
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> Pending</small>';
                                }
                                // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';

                            // return '<span class="badge badge-warning-light"><i class="ion-wand"></i>Requested</span>';
                        }

                        // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                    }
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }

        if ($checkApprovalCycleType == 2) {
            $CheckCurrentStaticStatusSecond = DB::table('attendance_list')
                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'attendance_list.id')
                ->join('static_status_request', 'attendance_list.final_status', '=', 'static_status_request.id')
                ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                ->where('attendance_list.id', $itemID)
                ->where('attendance_list.business_id', $loginRoleBID)
                ->orderBy('approval_status_list.created_at', 'desc')
                // ->where('approval_status_list.applied_cycle_type', 2)
                ->first();
            if (!empty($CheckCurrentStaticStatusSecond)) {
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                // dd($CheckCurrentStaticStatusSecond);
                $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;

                    // dd("datga");
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    // dd($CheckCurrentStaticStatusSecond);
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';

                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';

                    // return '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }
    }

    // all details get session
    public static function PassBy()
    {
        return [self::allValueGet()[4], self::allValueGet()[5], self::allValueGet()[8], self::allValueGet()[7]];
        // dd(self::allValueGet()[5]);
    }

    // USING Gateways SET BY JAYANT
    protected static function ReloadSession2Data()
    {
        //..protected Layer
        Session::put('user_type', Session::get('user_type'));
        Session::put('business_id', Session::get('business_id'));
        Session::put('branch_id', Session::get('branch_id'));
        Session::put('login_name', Session::get('login_name'));
        Session::put('login_email', Session::get('login_email'));
        Session::put('login_role', Session::get('login_role'));
        Session::put('login_business_image', Session::get('login_business_image') != null ? Session::get('login_business_image') : 'assets/images/users/16.jpg');
        if (Session::get('user_type') == 'owner') {
            Session::put('model_id', Session::get('model_id'));
        }
        if (Session::get('user_type') == 'admin') {
            Session::put('login_emp_id', Session::get('login_emp_id'));
        }
    }
    // after complete payment store same datas
    protected static function ReloadSession1Data($LoadModel)
    {
        $decryptedArray = json_decode($LoadModel, true);

        if ($decryptedArray['user_type'] == 'owner') {
            Session::put('user_type', $decryptedArray['user_type']);
            Session::put('business_id', $decryptedArray['business_id']);
            Session::put('branch_id', $decryptedArray['branch_id']);
            Session::put('model_id', $decryptedArray['model_id']);
            Session::put('login_role', $decryptedArray['login_role']);
            Session::put('login_name', $decryptedArray['login_name']);
            Session::put('login_email', $decryptedArray['login_email']);
            Session::put('login_business_image', $decryptedArray['login_business_image']);
        }
        if ($decryptedArray['user_type'] == 'admin') {
            Session::put('user_type', $decryptedArray['user_type']);
            Session::put('business_id', $decryptedArray['business_id']);
            Session::put('branch_id', $decryptedArray['branch_id']);
            Session::put('login_emp_id', $decryptedArray['login_emp_id']);
            Session::put('login_role', $decryptedArray['login_role']); //role table role id link model_has_role
            Session::put('login_name', $decryptedArray['login_name']);
            Session::put('login_email', $decryptedArray['login_email']);
            Session::put('login_business_image', $decryptedArray['login_business_image']);
        }
        return $decryptedArray;
    }
    public static function callReloadStep2SessionData()
    {
        return self::ReloadSession2Data(); //store
    }
    public static function callReloadStep1SessionData($LoadModel)
    {
        return self::ReloadSession1Data($LoadModel); //put
    }
    // MAIN Responsible LOADED
    public static function PatternMatch($combinedString)
    {
        $mode1 = '';
        $mode2 = '';
        $pattern = '/^(.*?)@(.*?)$/';
        preg_match($pattern, $combinedString, $matches);

        if (count($matches) === 3) {
            $uniqueId = $matches[1]; // Contains the value before '@'
            $businessId = $matches[2]; // Contains the value after '@'
            $mode1 = $uniqueId;
            $mode2 = $businessId;
            return [$mode1, $mode2];
        } else {
            return [$mode1, $mode2];
            // Regex didn't match the pattern
            // Handle the case where the string format is unexpected
        }
    }

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
        // dd($LoginModelID);
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
