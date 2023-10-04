<?php

namespace App\Helpers\MasterRulesManagement;

use App\Models\admin\SidebarMenu;
use App\Models\admin\BranchList;
use App\Models\Permissions\Role;
use App\Models\Permissions\ModelHasPermission;
use App\Models\admin\Department_list;
use App\Models\admin\Designation_list;

use App\Models\admin\DepartmentList;
use App\Models\employee\Employee_Details;
use Illuminate\Support\Facades\DB;
use App\Models\admin\HolidayTemplate;
use App\Models\admin\HolidayDetail;
// use App\Models\admin\HolidayDetail;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;

//  PACKAGES DEVELOPED BY JAYANT
class RulesManagement
{

    protected static $UserType, $LoginEmpID, $BusinessID, $BranchID, $LoginRole, $LoginModelID, $LoginName, $LoginEmail, $LoginBusinessImage;
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
        // dd(self::$BusinessID,self::$UserType,self::$BranchID,self::$LoginRole,self::$LoginModelID,self::$LoginEmail,self::$LoginName);
        self::allValueGet(); //self::temp storage data
    }

    public static function myHelperFunction($parameter)
    {
        return "Hello THIS IS Rule MANAGEMENT, $parameter!";
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
        // dd(self::allValueGet()[1]);
        $businessLoad = DB::table('business_details_list')->where('business_id', self::allValueGet()[1])->first();
        $branchList = DB::table('branch_list')->where('business_id', self::allValueGet()[1])->get();
        $leavePolicy = DB::table('setting_leave_policy')->where('business_id', self::allValueGet()[1])->get();
        $holidayPolicy = DB::table('holiday_template')->where('business_id', self::allValueGet()[1])->get();
        $weeklyPolicy = DB::table('weekly_holiday_list')->where('business_id', self::allValueGet()[1])->get();
        $attendanceMode = DB::table('attendance_mode')->where('business_id', self::allValueGet()[1])->get();
        $attendanceShiftSettings = DB::table('attendance_shift_settings')->where('business_id', self::allValueGet()[1])->get();
        $attendanceTrackPunchInOROut = DB::table('attendance_track_in_out')->where('business_id', self::allValueGet()[1])->first(); //particular set illegal

        // Rule List
        // $lateentry;
        $finalEndGameRule = DB::table('master_endgame_method')
            ->join('attendance_endgame_policypreference', 'master_endgame_method.policy_preference', '=', 'attendance_endgame_policypreference.id')
            ->join('attendance_endgame_level', 'master_endgame_method.policy_preference', '=', 'attendance_endgame_level.policypreference_level_id')
            ->join('attendance_shift_settings', 'master_endgame_method.business_id', '=', 'attendance_shift_settings.business_id')
            ->where('master_endgame_method.business_id', self::allValueGet()[1])->get();
        // dd($finalEndGameRule);
        if (($finalEndGameRule != null) != null || ($businessLoad != null) || ($branchList != null) || ($leavePolicy != null) || ($holidayPolicy != null) || ($weeklyPolicy != null) || ($attendanceMode != null) || ($attendanceShiftSettings != null) || ($attendanceTrackPunchInOROut != null)) {
            return array($finalEndGameRule, $businessLoad, $branchList, $leavePolicy, $holidayPolicy, $weeklyPolicy, $attendanceMode, $attendanceShiftSettings, $attendanceTrackPunchInOROut);
        } else {
            return array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
    }
    // first list
    static function GetValues($id)
    {
        // $branch = DB::table('branch_list')
        //     ->where('business_id', self::allValueGet()[1])->count();
        // || ($department != null) || ($designation != null) || ($adminCount != null) || ($holidayCount != null) || ($leaveCount != null) || ($weeklyholidayCount != null)

        $leavesettingsList = DB::table('setting_leave_policy')->where('id', $id)->where('business_id', self::allValueGet()[1])->first();
        $holidaypolicyList = DB::table('holiday_template')->where('temp_id', $id)->where('business_id', self::allValueGet()[1])->first();
        $weeklyPolicyList = DB::table('weekly_holiday_list')->where('id', $id)->where('business_id', self::allValueGet()[1])->first();

        // attendance
        $AttendaceShiftPolicyList = DB::table('attendance_shift_settings')->where('id', $id)->where('business_id', self::allValueGet()[1])->first();
        $attendanceModeList = DB::table('attendance_mode')->where('business_id', self::allValueGet()[1])->first();



        if (($leavesettingsList != null) || ($holidaypolicyList != null) || ($weeklyPolicyList != null) || ($AttendaceShiftPolicyList != null) || ($attendanceModeList != null)) {
            return [$leavesettingsList, $holidaypolicyList, $weeklyPolicyList, $AttendaceShiftPolicyList, $attendanceModeList];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }


    // futures makes
    static function CountersValue()
    {
        $branch = DB::table('branch_list')
            ->where('business_id', self::allValueGet()[1])->count();

        $department = DB::table('department_list')
            ->where('b_id', self::allValueGet()[1])->count();
        $designation = DB::table('designation_list')
            ->where('business_id', self::allValueGet()[1])->count();
        $adminCount = DB::table('setting_role_assign_permission')->where('business_id', self::allValueGet()[1])->count();
        $holidayCount = DB::table('holiday_template')->where('business_id', self::allValueGet()[1])->count();
        $leaveCount = DB::table('setting_leave_policy')->where('business_id', self::allValueGet()[1])->count();
        $weeklyholidayCount = DB::table('weekly_holiday_list')->where('business_id', self::allValueGet()[1])->count();
        if (($branch != null) || ($department != null) || ($designation != null) || ($adminCount != null) || ($holidayCount != null) || ($leaveCount != null) || ($weeklyholidayCount != null)) {
            return [$branch, $department, $designation, $adminCount, $holidayCount, $leaveCount, $weeklyholidayCount];
        } else {
            return [0, 0, 0, 0, 0, 0, 0];
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
    // GenderCheck on Loader
    static function GenderCheck()
    {
        $load = DB::table('employee_personal_details')->where('business_id', self::allValueGet()[1])->where('emp_id', Session::get('login_emp_id'))->select('emp_gender')->first();
        if ($load != null) {
            if ($load->emp_gender == 2) {

                return 'Miss.';
            }
            if ($load->emp_gender == 1) {

                return 'Mr.';
            }
        } else {
            return '';
        }
    }
    static function LeavePolicyCategory($id)
    {
        $load = DB::table('setting_leave_category')->where('business_id', self::allValueGet()[1])->where('leave_policy_id', $id)->get();
        if ($load != null) {
            return $load;
        } else {
            return '';
        }
    }

    static function GetPolicysCount($id)
    {

        $holiday_policy = DB::table('holiday_details')->where('template_id', $id)->where('business_id', self::allValueGet()[1])->count();
        //  || ($department != null) || ($designation != null) || ($adminCount != null)
        if (($holiday_policy != null)) {
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

        $load_Attendance_Mode = DB::table('attendance_mode')->where('business_id', self::$BusinessID)->first();
        if (($load_Attendance_Mode != null)) {
            return array($load_Attendance_Mode, 0, 0);
        } else {
            return array(0, 0, 0); //off or false case
        }
    }

    // attendance Counter
    public function AttendanceCounters()
    {
        $load_Attendance_ShiftCount = DB::table('attendance_shift_settings')->where('business_id', self::$BusinessID)->count();
        if (($load_Attendance_ShiftCount != null)) {
            return array($load_Attendance_ShiftCount, 0, 0);
        } else {
            return array(0, 0, 0); //off or false case
        }
    }


    // attendance Shift check by ID
    public function AttedanceShiftCheckItems($ID)
    {
        $checked = DB::table('attendance_shift_settings')->where('id', $ID)->where('business_id', self::$BusinessID)->first();
        if ($checked != null) {
            return $checked->shift_type;
        } else {
            return '';
        }
    }

    // conversion 24 to 12 horus Time any-value
    public function Convert24To12($value)
    {
        $valueNOTNull = "";
        if ($value != null) {
            $valueNOTNull = date("h:i A", strtotime($value)); //twentyFourHourTime
            return $valueNOTNull;
        }
        return $valueNOTNull;
    }


    // Attendance TrackIn&Out
    public function TrackInOutStatus()
    {
        $load = DB::table('attendance_track_in_out')->where('business_id', self::$BusinessID)->first();
        if ($load != null) {
            return $load;
        }
        // return 'OFF';
    }


    //     $currentDate = date('Y-m-d');
    // echo "Standard Date Format: $currentDate";

    // $currentTime24 = date('H:i:s');
    // echo "Standard 24-Hour Time Format: $currentTime24";

    // $currentTime12 = date('h:i A');
    // echo "Standard 12-Hour Time Format: $currentTime12";


    // loaded as constructor used
    protected static function allValueGet()
    {
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

        // $BusinessID = self::$BusinessID;
        return array(self::$UserType, self::$BusinessID, self::$BranchID, self::$LoginRole, self::$LoginEmpID, self::$LoginModelID, self::$LoginName, self::$LoginEmail, self::$LoginBusinessImage);
    }
}
