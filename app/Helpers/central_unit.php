<?php

namespace App\Helpers;

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
use Carbon\Carbon;

use App\Helpers\MasterRulesManagement\RulesManagement;

class Central_unit
{
    // public ;
    protected static $UserType, $LoginEmpID, $BusinessID, $BranchID, $LoginRole, $LoginModelID, $LoginName, $LoginEmail, $LoginBusinessImage;

    // LOADING DATA SET IN JAY TEST CASE
    public function __construct()
    {
        self::$BusinessID = Session::get('business_id');
        self::$UserType = Session::get('user_type'); //Other checking loader
        self::$BranchID = Session::get('branch_id');
        self::$LoginRole = Session::get('login_role'); //role table id : 8
        self::$LoginEmpID = Session::get('login_emp_id');
        // login_emp_id
        // self::$LoginModelType = Session::get('model_type'); //type loginModel : admin
        self::$LoginModelID = Session::get('model_id'); //user id like : FD001
        self::$LoginName = Session::get('login_name');
        self::$LoginEmail = Session::get('login_email');
        self::$LoginBusinessImage = Session::get('login_business_image'); //bimg
        // dd(self::$BusinessID,self::$UserType,self::$BranchID,self::$LoginRole,self::$LoginModelID,self::$LoginEmail,self::$LoginName);
    }
    // LOAD ANY LOGIN CHECK ACCESS-PERMISSION JAY
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

    // static function BusinessName()
    // {
    //    $result = DB::table('business_details_list')
    //       ->where('business_email', $email)
    //       ->where('business_id', $businessID)->first();
    //    // ->first(); // Get the first row as an object

    //    // Check if a result was found
    //    if ($result) {
    //       return $result->business_name; // Access the 'business_name' property
    //    } else {
    //       // Handle the case where no result was found
    //       return "No matching business found";
    //    }
    // }

    static function BusinessIdToName($email, $businessID)
    {
        $result = DB::table('business_details_list')
            ->where('business_email', $email)
            ->where('business_id', $businessID)
            ->first();
        // ->first(); // Get the first row as an object

        // Check if a result was found
        if ($result) {
            return $result->business_name; // Access the 'business_name' property
        } else {
            // Handle the case where no result was found
            return 'No matching business found';
        }
    }

    static function BusinessIdToName2($businessID)
    {
        $result = DB::table('business_details_list')
            ->where('business_id', $businessID)
            ->first();
        // ->first(); // Get the first row as an object

        // Check if a result was found
        if ($result) {
            return $result->business_name; // Access the 'business_name' property
        } else {
            // Handle the case where no result was found
            return 'No matching business found';
        }
    }

    // standard helpers
    public static function RoleIdToName()
    {
        // $result = DB::table('universal_roles_define')->where('role_id', $roleId)->select('role_name')->first();

        $result = DB::table('setting_role_create')
            ->where('id', self::$LoginRole)
            ->select('roles_name')
            ->first();

        // $result = DB::table('roles')->where('id', self::$LoginRole)->select('name')->first();
        // // dd($result);
        // // Check if a result was found
        if ($result) {
            return $result->roles_name; // Return the role_name property
        } elseif (self::$LoginRole == 0) {
            return 'Owner';
        }
        //  else if (self::$LoginRole == 1) {
        //    return "Admin";
        // } else if (self::$LoginRole == 2) {
        //    return "Super Admin";
        // } else if (self::$LoginRole == 3) {
        //    return "Employee";
        // }
        else {
            return 'Unknown Role'; // You can change this default value as needed
        }
    }

    public static function RoleIdToName2($roleId)
    {
        // $result = DB::table('universal_roles_define')->where('role_id', $roleId)->select('role_name')->first();

        $result = DB::table('setting_role_create')
            ->where('id', $roleId)
            ->select('roles_name')
            ->first();

        // $result = DB::table('roles')->where('id', self::$LoginRole)->select('name')->first();
        // // dd($result);
        // // Check if a result was found
        if ($result) {
            return $result->roles_name; // Return the role_name property
        } elseif ($roleId == 0) {
            return 'Owner';
        }
        //  else if (self::$LoginRole == 1) {
        //    return "Admin";
        // } else if (self::$LoginRole == 2) {
        //    return "Super Admin";
        // } else if (self::$LoginRole == 3) {
        //    return "Employee";
        // }
        else {
            return 'Unknown Role'; // You can change this default value as needed
        }
    }
    // static function findBusinessName($businessID,$branchID){
    //    $result = DB::table('branch_list')->where('business_id',$businessID)->where('branch_id',$branchID)->first();

    //    if ($result) {
    //       return $result->business_name; // Access the 'business_name' property
    //    } else {
    //       // Handle the case where no result was found
    //       return "No matching business found";
    //    }
    // }
    public static function DesingationIdToName($ID)
    {
        $load = DB::table('designation_list')
            ->where('desig_id', $ID)
            ->select('desig_name')
            ->first();
        if (isset($load)) {
            return $load->desig_name;
        }
        // return '';
    }

    public static function BranchList()
    {
        return DB::table('branch_list')
            ->where('business_id', self::$BusinessID)
            ->select('*')
            ->get();
    }
    static function Departmentget($id)
    {
        return DB::table('department_list')
            ->where(['depart_id' => $id, 'b_id' => self::$BusinessID])
            ->select('depart_name')
            ->first();
    }
    static function Branchget($id)
    {
        return DB::table('branch_list')
            ->where(['branch_id' => $id, 'business_id' => self::$BusinessID])
            ->select('branch_name')
            ->first();
    }
    static function DepartmentList()
    {
        // $department = DB::table('department_list')
        //     ->where(['business_id' => self::$BusinessID])
        //     ->join('branch_list', 'department_list.branch_id', '=', 'branch_list.branch_id')
        //     ->select('*')
        //     ->get();//old

        $department = DB::table('department_list')
            ->where('b_id', self::$BusinessID)
            ->select('*')
            ->get();
        // dd($department);
        return $department;
    }
    static function LeavePolicyList($businessID, $branchID)
    {
        if (isset($businessID) && isset($branchID)) {
            $Rooted = DB::table('setting_leave_policy')
                ->where('setting_leave_policy.business_id', $businessID)
                ->where('setting_leave_policy.branch_id', $branchID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
        }
        if (isset($businessID)) {
            $Rooted = DB::table('setting_leave_policy')
                ->where('setting_leave_policy.business_id', $businessID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
            // ->where('setting_leave_policy.branch_id', $branchID)
        }
        if (isset($branchID)) {
            $Rooted = DB::table('setting_leave_policy')
                ->where('setting_leave_policy.branch_id', $branchID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
        }
        // ->join('setting_leave_category', 'setting_leave_category.business_id', '=', 'setting_leave_policy.business_id')
        // ->join('setting_leave_category', )
        // ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
        // ->join('setting_leave_category', 'setting_leave_category.leave_policy_id', '=', 'setting_leave_policy.id')

        return $Rooted;
    }
    static function EmpPlaceHolder()
    {
        $ad = DB::table('model_has_permissions')
            ->where('business_id', self::$BusinessID)
            ->first();
        if ($ad != null) {
            return $ad;
        }
    }
    static function RoleIdToCountAssignUsers($roleId)
    {
        $node = DB::table('setting_role_assign_permission')
            ->where('business_id', self::$BusinessID)
            ->where('role_id', $roleId)
            ->count();

        if ($node != null) {
            return $node;
        }
    }
    static function DesignationList()
    {
        // $designation = DB::table('designation_list')
        //     ->join('branch_list', 'branch_list.branch_id', '=', 'designation_list.branch_id')
        //     ->join('department_list', 'designation_list.department_id', '=', 'department_list.depart_id')
        //     ->where('designation_list.business_id', self::$BusinessID) // Select all columns from all three tables
        //     ->select('designation_list.*', 'branch_list.*', 'department_list.*')
        //     ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
        //     ->get();old

        $designation = DB::table('designation_list')
            ->where('designation_list.business_id', self::$BusinessID) // Select all columns from all three tables
            ->select('designation_list.*')
            ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
            ->get();
        return $designation;
    }

    static function EmployeeDetails()
    {
        $employee = DB::table('employee_personal_details')
            ->join('employee_gender', 'employee_personal_details.emp_gender', '=', 'employee_gender.id')
            ->where(['business_id' => self::$BusinessID])
            ->select('employee_personal_details.*', 'employee_gender.gender_type')
            ->get();
        return $employee;
    }

    static function Template()
    {
        $template = DB::table('holiday_template')
            ->where(['business_id' => self::$BusinessID])
            ->select('*')
            ->get();
        return $template;
    }
    static function Holiday()
    {
        $template = DB::table('holiday_details')
            ->where(['business_id' => self::$BusinessID])
            ->select('*')
            ->get();
        return $template;
    }

    static function GetAttDetails()
    {
        $AttList = DB::table('attendance_list')
            ->where('business_id', self::$BusinessID)
            ->get();
        if ($AttList != null) {
            return $AttList;
        }
    }

    static function GetBusinessType()
    {
        $AttList = DB::table('business_type_list')->get();
        return $AttList;
    }

    static function GetBusinessCategory()
    {
        $AttList = DB::table('business_categories_list')->get();
        return $AttList;
    }

    // static function GetBusinessCategoryName($id){
    //    $data = DB::table('business_categories_list')->find($id);
    //    return $data
    // }

    public static function GetBusinessCategoryName($id)
    {
        $data = DB::table('business_categories_list')
            ->where('id', $id)
            ->first();
        return $data;
    }

    public static function GetBusinessTypeName($id)
    {
        $data = DB::table('business_type_list')
            ->where('id', $id)
            ->first();
        return $data;
    }

    //  business_type_list

    static function Get()
    {
        $AttList = DB::table('business_type_list')->get();
        return $AttList;
    }

    // Code Composing
    // fixing structures
    // Setting Template METHOD JAY  With Null Safety
    static function CountersValue()
    {
        $branch = DB::table('branch_list')
            ->where('business_id', Session::get('business_id'))
            ->count();

        $department = DB::table('department_list')
            ->where('b_id', Session::get('business_id'))
            ->count();
        $designation = DB::table('designation_list')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $adminCount = DB::table('setting_role_assign_permission')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $holidayCount = DB::table('holiday_template')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $leaveCount = DB::table('setting_leave_policy')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $weeklyholidayCount = DB::table('weekly_holiday_list')
            ->where('business_id', Session::get('business_id'))
            ->count();

        // attendance side

        if ($branch != null || $department != null || $designation != null || $adminCount != null || $holidayCount != null || $leaveCount != null || $weeklyholidayCount != null) {
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

    static function GetCount()
    {
        $LeaveCount = DB::table('leave_request_list')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $EmpCount = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $AttendanceCount = DB::table('attendance_list')
            ->where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            ->count();
        $AbsentCount = $EmpCount - $AttendanceCount;
        $MissPunchCount = DB::table('misspunch_list')
            ->where('business_id', Session::get('business_id'))
            ->count();

        if ($LeaveCount != null || $AttendanceCount != null || $MissPunchCount != null || $EmpCount != null || $AbsentCount != null) {
            return [$EmpCount, $AttendanceCount, $MissPunchCount, $LeaveCount, $AbsentCount];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    //  Leave
    static function LeaveSectionCount()
    {
        $LeaveCount = DB::table('leave_request_list')
            ->where('business_id', Session::get('business_id'))
            ->where('from_date', date('Y-m-d'))
            ->count();
        $EmpCount = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->count();
        $AttendanceCount = DB::table('attendance_list')
            ->where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            ->count();

            // $UnplanedLeave = DB::table('leave_request_list')
            // ->where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            // ->count();
        $AbsentCount = $EmpCount - $AttendanceCount;
        $PendingLeave = DB::table('leave_request_list')
            ->where('business_id', Session::get('business_id'))
            ->where('status', 0)
            ->count();

        if ($LeaveCount != null || $AttendanceCount != null || $PendingLeave != null || $EmpCount != null || $AbsentCount != null) {
            return [$EmpCount, $AttendanceCount, $PendingLeave, $LeaveCount, $AbsentCount];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    static function GenderCheck()
    {
        $load = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('emp_id', Session::get('login_emp_id'))
            ->select('emp_gender')
            ->first();
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
        $load = DB::table('setting_leave_category')
            ->where('business_id', Session::get('business_id'))
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
            ->where('business_id', Session::get('business_id'))
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

    // permission sets jay
    // skipping  pattern Dashboard.View -> get In Dashboard
    static function patternViewDots($string)
    {
        // Define a regular expression pattern to capture the first part (Dashboard)
        $pattern = '/^(.+)\.View$/i';

        // Use preg_match to match the pattern
        if (preg_match($pattern, $string, $matches)) {
            // $matches[1] contains the captured value
            $result = $matches[1];
            return $result;
        } else {
            return $string;
        }
    }
    static function sidebarMenu($menu_name)
    {
        return DB::table('sidebar_menu')
            ->where('menu_name', '=', $menu_name)
            ->first();
    }

    // skipping  pattern Dashboard.View -> get In Dashboard
    static function patternSkipDots($string)
    {
        // Define a regular expression pattern to capture the first part (Dashboard)
        $pattern = '/^([^\.]+)\./';

        // Use preg_match to match the pattern
        if (preg_match($pattern, $string, $matches)) {
            // $matches[1] contains the captured value (Dashboard)
            $dashboard = $matches[1];

            // Use $dashboard as needed
            return $dashboard;
        } else {
            // Pattern not found
            return '';
        }
    }
    static function sideBarLists()
    {
        return DB::table('sidebar_menu')->get();
    }

    static function EmpIdToRoleId()
    {
        $checkPermission = DB::table('setting_role_assign_permission')
            ->where('emp_id', self::$LoginEmpID)
            ->select('role_id')
            ->first();
        return $checkPermission;
    }

    static function ModuleIdToPermission()
    {
        $checkPermission = DB::table('setting_role_assign_permission')
            ->join('setting_role_items', 'setting_role_items.role_create_id', '=', 'setting_role_assign_permission.role_id')
            ->where('emp_id', self::$LoginEmpID)
            ->get();
        return $checkPermission;
    }
    static function RoleIdToModelId($roleId)
    {
        return DB::table('model_has_roles')
            ->where('role_id', $roleId)
            ->select('model_id', 'model_type')
            ->first();
    }
    static function RoleIdToModelName($roleId)
    {
        return DB::table('setting_role_items')
            ->where('role_create_id', $roleId)
            ->select('model_name')
            ->get();
    }

    static function RoleIdToModelName2($roleId)
    {
        return DB::table('setting_role_items')
            ->where('role_create_id', $roleId)
            ->select('model_name as roleName')
            ->first();
    }

    static function GetModelPermission()
    {
        $ModelPermission = DB::table('model_has_permissions')
            ->where('model_id', self::$LoginModelID)
            ->get();
        return $ModelPermission;
    }

    static function GetBranchName($branch_id)
    {
        $Branch = DB::table('branch_list')
            ::where('branch_id', $branch_id)
            ->first();
    }

    // get count for different fields

    function CalculateTimeDifference($inTime, $outTime)
    {
        // Parse the input timestamps as Carbon objects
        $inTimeObj = Carbon::parse($inTime);
        $outTimeObj = Carbon::parse($outTime);

        // Calculate the time difference
        $timeDifference = $outTimeObj->diff($inTimeObj);

        return $timeDifference;
    }
}
