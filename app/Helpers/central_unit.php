<?php

namespace App\Helpers;

use App\Models\LoginAdmin;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
use App\Models\ModelHasPermission;
use App\Models\PolicyHolidayDetail;
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
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicySettingLeaveCategory;
use App\Models\StaticBusinessTypeList;
use App\Models\StaticBusinessCategoriesList;

use Illuminate\Support\Facades\DB;

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
            $CheckRole = PolicySettingRoleAssignPermission::where('business_id', Session::get('business_id'))
                ->where('branch_id', Session::get('branch_id'))
                ->where('emp_id', Session::get('login_emp_id'))
                ->first();

            if ($CheckRole) {
                $roleItem = PolicySettingRoleItem::where('role_create_id', $CheckRole->role_id)
                    ->get();

                $permissions = array_merge($permissions, $roleItem->pluck('model_name')->toArray());
                // dd($permissions);
            }
        }
        // model_id
        if (Session::has('business_id') && Session::has('user_type') && Session::has('model_id')) {
            $CheckRole = ModelHasPermission::where('business_id', Session::get('business_id'))
                ->where('model_id', Session::get('model_id'))
                ->first();

            if ($CheckRole) {
                $roleItem = ModelHasPermission::where('business_id', Session::get('business_id'))
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
        $result = BusinessDetailsList::where('business_email', $email)
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
        $result = BusinessDetailsList::where('business_id', $businessID)
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
        // sftp://jayant_fd_hr@143.244.136.30/public_html/app/Models/PolicySettingRoleCreate.php
        $result = PolicySettingRoleCreate::where('id', self::$LoginRole)
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

        $result = PolicySettingRoleCreate::where('id', $roleId)
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
        //    return "Super Admin";4
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
        $load = DesignationList::where('desig_id', $ID)
            ->select('desig_name')
            ->first();
        if (isset($load)) {
            return $load->desig_name;
        }
        // return '';
    }

    public static function BranchList()
    {
        return BranchList::where('business_id', self::$BusinessID)
            ->select('*')
            ->get();
    }
    static function Departmentget($id)
    {
        return DepartmentList::where(['depart_id' => $id, 'b_id' => self::$BusinessID])
            ->select('depart_name')
            ->first();
    }
    static function Branchget($id)
    {
        return BranchList::where(['branch_id' => $id, 'business_id' => self::$BusinessID])
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

        $department = DepartmentList::where('b_id', self::$BusinessID)
            ->select('*')
            ->get();
        // dd($department);
        return $department;
    }
    static function LeavePolicyList($businessID, $branchID)
    {
        if (isset($businessID) && isset($branchID)) {
            $Rooted = PolicySettingLeavePolicy::where('setting_leave_policy.business_id', $businessID)
                ->where('setting_leave_policy.branch_id', $branchID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
        }
        if (isset($businessID)) {
            $Rooted = PolicySettingLeavePolicy::where('setting_leave_policy.business_id', $businessID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
            // ->where('setting_leave_policy.branch_id', $branchID)
        }
        if (isset($branchID)) {
            $Rooted = PolicySettingLeavePolicy::where('setting_leave_policy.branch_id', $branchID)
                ->select('setting_leave_policy.*') // Select all columns from all three tables
                ->get();
        }
        // ->join('policy_setting_leave_category', 'policy_setting_leave_category.business_id', '=', 'setting_leave_policy.business_id')
        // ->join('policy_setting_leave_category', )
        // ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
        // ->join('policy_setting_leave_category', 'policy_setting_leave_category.leave_policy_id', '=', 'setting_leave_policy.id')

        return $Rooted;
    }
    static function EmpPlaceHolder()
    {
        $ad = ModelHasPermission::where('business_id', self::$BusinessID)
            ->first();
        if ($ad != null) {
            return $ad;
        }
    }
    static function RoleIdToCountAssignUsers($roleId)
    {
        $node = PolicySettingRoleAssignPermission::where('business_id', self::$BusinessID)
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

        $designation = DesignationList::where('designation_list.business_id', self::$BusinessID) // Select all columns from all three tables
            ->select('designation_list.*')
            ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
            ->get();
        return $designation;
    }

    static function EmployeeDetails()
    {
        $employee = EmployeePersonalDetail::join('static_employee_join_gender_type', 'employee_personal_details.emp_gender', '=', 'static_employee_join_gender_type.id')
            ->where(['business_id' => self::$BusinessID])
            ->select('employee_personal_details.*', 'static_employee_join_gender_type.gender_type')
            ->get();
        return $employee;
    }

    static function Template()
    {
        $template = PolicyHolidayTemplate::where(['business_id' => self::$BusinessID])
            ->select('*')
            ->get();
        return $template;
    }
    static function Holiday()
    {
        $template = PolicyHolidayDetail::where(['business_id' => self::$BusinessID])
            ->select('*')
            ->get();
        return $template;
    }

    static function GetAttDetails()
    {
        $AttList = AttendanceList::where('business_id', self::$BusinessID)
            ->get();
        if ($AttList != null) {
            return $AttList;
        }
    }

    static function GetBusinessType()
    {
        $AttList = StaticBusinessTypeList::get();
        return $AttList;
    }

    static function GetBusinessCategory()
    {
        $AttList = StaticBusinessCategoriesList::get();
        return $AttList;
    }

    // static function GetBusinessCategoryName($id){
    //    $data =StaticBusinessCategoriesList::find($id);
    //    return $data
    // }

    public static function GetBusinessCategoryName($id)
    {
        $data = StaticBusinessCategoriesList::where('id', $id)
            ->first();
        return $data;
    }

    public static function GetBusinessTypeName($id)
    {
        $data = StaticBusinessTypeList::where('id', $id)
            ->first();
        return $data;
    }

    //  static_business_type_list

    static function Get()
    {
        $AttList = StaticBusinessTypeList::get();
        return $AttList;
    }

    // Code Composing
    // fixing structures
    // Setting Template METHOD JAY  With Null Safety
    static function CountersValue()
    {
        $branch = BranchList::where('business_id', Session::get('business_id'))
            ->count();

        $department = DepartmentList::where('b_id', Session::get('business_id'))
            ->count();
        $designation = DesignationList::where('business_id', Session::get('business_id'))
            ->count();
        $adminCount = PolicySettingRoleAssignPermission::where('business_id', Session::get('business_id'))
            ->count();
        $holidayCount = PolicyHolidayTemplate::where('business_id', Session::get('business_id'))
            ->count();
        $leaveCount = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))
            ->count();
        $weeklyholidayCount = DB::table('policy_weekly_holiday_list')
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

    // Attendace Blade Count
    static function AttendanceGetCount()
    {
        $TotalEmpCount = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            ->count();
        $PresentCount = AttendanceList::where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            ->count();
        // ->where('business_id', Session::get('business_id'))
        $now = date('Y-m-d');
        $LeaveRequests = RequestLeaveList::where(function ($query) use ($now) {
            $query
                ->where(function ($query) use ($now) {
                    $query->where('from_date', '<=', $now)->where('to_date', '>=', $now);
                })
                ->orWhere(function ($query) use ($now) {
                    $query->where('from_date', '=', $now)->whereNull('to_date');
                });
        })
            ->get();

        $lateEntry = PolicyAttenRuleLateEntry::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();

        $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', Session::get('business_id'))
            ->where('switch_is', 1)
            ->first();
        $earlyTime = $earlyExit->mark_half_day_hr * 60 + $earlyExit->mark_half_day_min;
        $hours1 = floor($earlyTime / 60);
        $minutes1 = $earlyTime % 60;
        $earlyExitTime = gmdate('H:i', $hours1 * 3600 + $minutes1 * 60);
        $lateTime = $lateEntry->mark_half_day_hr * 60 + $lateEntry->mark_half_day_min;
        // Calculate hours and minutes
        $hours = floor($lateTime / 60);
        $minutes = $lateTime % 60;

        // Format as hh:mm
        $formattedTime = gmdate('H:i', $hours * 3600 + $minutes * 60);
        $fullLate = $lateTime * 60;
        // dd($formattedTime);
        $halfDayThreshold = 240; // Threshold for a half-day in minutes (4 hours)
        $currentDate = Carbon::now();

        $halfDayCount = DB::table('attendance_list')
            ->join('policy_attendance_shift_type_items', 'attendance_list.attendance_shift', '=', 'policy_attendance_shift_type_items.id')
            ->join('policy_atten_rule_late_entry', 'attendance_list.business_id', '=', 'policy_atten_rule_late_entry.business_id')
            ->where('policy_atten_rule_late_entry.switch_is', '1')
            ->where(function ($query) use ($halfDayThreshold, $formattedTime, $earlyExitTime) {
                // Case 1: Late Entry
                $query->orWhere(function ($query) use ($halfDayThreshold, $formattedTime) {
                    $query->whereRaw('TIMEDIFF(punch_in_time, policy_attendance_shift_type_items.shift_start) > 0')->whereRaw("TIMEDIFF(punch_in_time, policy_attendance_shift_type_items.shift_start) >= '$formattedTime'");
                });
                // Case 2: Early Exit
                $query->orWhere(function ($query) use ($halfDayThreshold, $earlyExitTime) {
                    $query
                        ->whereRaw('TIMEDIFF(policy_attendance_shift_type_items.shift_end,  punch_out_time) > 0')
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
            // ->where('date', $currentDate->toDateString())
            ->count();

        // $halfDayCount will contain the count of half-days based on the conditions
        // dd($halfDayCount);

        $LeavesCount = count($LeaveRequests);
        $AbsentCount = $TotalEmpCount - $PresentCount;
        // $AbsentCount = $TotalEmpCount - $PresentCount - $LeavesCount;
        // dd($now);

        $LateDays = AttendanceList::where('attendance_list.business_id', Session::get('business_id'))
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->join('policy_master_endgame_method', 'policy_master_endgame_method.id', '=', 'employee_personal_details.master_endgame_id')
            ->join('policy_attendance_shift_type_items', 'policy_attendance_shift_type_items.attendance_shift_id', '=', 'employee_personal_details.emp_shift_type')
            ->whereRaw('TIME(attendance_list.punch_in_time) > TIME(policy_attendance_shift_type_items.shift_start)')
            ->where('attendance_list.punch_date', date('Y-m-d'))
            ->where('policy_attendance_shift_type_items.is_active', '1')
            ->select('attendance_list.id', 'attendance_list.punch_in_time', 'policy_attendance_shift_type_items.shift_start')
            ->get();
        $LateDaysCount = count($LateDays);
        // dd($LateDays)
        $LeaveCount = RequestLeaveList::where('business_id', Session::get('business_id'))
            ->count();

        $MissPunchCount = RequestMispunchList::where('business_id', Session::get('business_id'))
            ->count();

        if ($TotalEmpCount != null || $PresentCount != null || $AbsentCount != null || $LateDaysCount != null || $halfDayCount != null) {
            return [$TotalEmpCount, $PresentCount, $AbsentCount, $halfDayCount, $LateDaysCount, $LeavesCount];
        } else {
            return [0, 0, 0, 0, 0, 0];
        }
    }

    //  Leave
    static function LeaveSectionCount()
    {
        $LeaveCount = RequestLeaveList::where('business_id', Session::get('business_id'))
            ->where('from_date', date('Y-m-d'))
            ->count();
        $EmpCount = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
            ->count();
        $AttendanceCount = AttendanceList::where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            ->count();

        // $UnplanedLeave = DB::table('request_leave_list')
        // ->where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
        // ->count();
        $AbsentCount = $EmpCount - $AttendanceCount;
        $PendingLeave = DB::table('approval_status_list')->where('business_id', Session::get('business_id'))->where('approval_type_id', 2)
            ->where('status', 0)
            ->count();
        // dd($PendingLeave);

        if ($LeaveCount != null || $AttendanceCount != null || $PendingLeave != null || $EmpCount != null || $AbsentCount != null) {
            return [$EmpCount, $AttendanceCount, $PendingLeave, $LeaveCount, $AbsentCount];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    static function GenderCheck()
    {
        $load = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
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
        $load = PolicySettingLeaveCategory::where('business_id', Session::get('business_id'))
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
        $holiday_policy = PolicyHolidayDetail::where('template_id', $id)
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
            $Roles = PolicySettingRoleItem::where('business_id', self::$BusinessID)
                ->where('branch_id', self::$BranchID)
                ->select('*') // Select all columns from all three tables
                ->get();
            return $Roles;
        }
        if (isset(self::$BusinessID)) {
            $Roles = PolicySettingRoleItem::where('business_id', self::$BusinessID)
                ->select('*') // Select all columns from all three tables
                ->get();
            return $Roles;

            // ->where('setting_leave_policy.branch_id', $branchID)
        }
        if (isset(self::$BranchID)) {
            $Roles = PolicySettingRoleItem::where('branch_id', self::$BranchID)
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
        return StaticSidebarMenu::get();
    }

    static function EmpIdToRoleId()
    {
        $checkPermission = PolicySettingRoleAssignPermission::where('emp_id', self::$LoginEmpID)
            ->select('role_id')
            ->first();
        return $checkPermission;
    }

    static function ModuleIdToPermission()
    {
        $checkPermission = PolicySettingRoleAssignPermission::join('policy_setting_role_items', 'policy_setting_role_items.role_create_id', '=', 'policy_setting_role_assign_permission.role_id')
            ->where('emp_id', self::$LoginEmpID)
            ->get();
        return $checkPermission;
    }
    // static function RoleIdToModelId($roleId)
    // {
    //     return DB::table('model_has_roles')
    //         ->where('role_id', $roleId)
    //         ->select('model_id', 'model_type')
    //         ->first();
    // }
    static function RoleIdToModelName($roleId)
    {
        return PolicySettingRoleItem::where('role_create_id', $roleId)
            ->select('model_name')
            ->get();
    }

    static function RoleIdToModelName2($roleId)
    {
        return PolicySettingRoleItem::where('role_create_id', $roleId)
            ->select('model_name as roleName')
            ->first();
    }

    static function GetModelPermission()
    {
        $ModelPermission = ModelHasPermission::where('model_id', self::$LoginModelID)
            ->get();
        return $ModelPermission;
    }

    static function GetBranchName($branch_id)
    {
        $Branch = BranchList::where('branch_id', $branch_id)
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




    // ********************************************************** Start of Attendance Calculation By Aman ***************************************


    // get no of Sunday function 
    static function getNumberOfSundaysInMonth($year, $month)
    {
        $day = 0;
        $totalDayinMonth = date('t');
        $sundays = 0;

        while(++$day <= $totalDayinMonth){
            $NDay = date('N',strtotime($year.'-'.$month.'-'.$day));
            if($NDay == 7){
                $sundays++;
            }
        }
        return $sundays;
    }

    static function attendanceByEmpDetails($Emp, $y, $m)
    {
        $totalTwhMin = 0;
        $totalOTMin = 0;
        $totalLateTime = 0;
        $totalEarlyExitTime = 0;
        $totalHolidays = 0;
        $totalWeekOff = 0;
        $totalPaidLeave = 0;
        $totalDayinMonth = date('t');
        $check = 0;

        while(++$check <= $totalDayinMonth){
            $getOffDay = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-' . $check)]);
            $isOffDay = $getOffDay[0];
            if($isOffDay == 6){
                $totalHolidays++;
            }elseif ($isOffDay == 7) {
                $totalWeekOff++;
            }elseif ($isOffDay == 10){
                $totalPaidLeave++;
            }
        }

        // dd($totalHolidays);

        $day = 1;
        while ($day <= date('d')) {
            $resCode = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-' . $day)]);
            // dd($resCode[10]);
            $status = $resCode[0];
            $inTime = $resCode[1] != 0 ? date('h:i A', strtotime($resCode[1])) : 'Not Mark';
            $outTime = $resCode[2] != 0 ? date('h:i A', strtotime($resCode[2])) : 'Not Mark';
            $workingHour = $resCode[1] && $resCode[2] ? $resCode[3] : '00:00';
            $punchInLoc = $resCode[4];
            $punchOutLoc = $resCode[5];
            $shiftName = $resCode[6];
            $breakTime = $resCode[7];
            $overTime = $resCode[8];
            $shiftWH = $resCode[9];
            $twhMin = $resCode[10];
            $MaxOvertime = $resCode[11];
            $lateby = $resCode[12];
            $earlyExitBy = $resCode[13];
            $occurance = $resCode[14];
            $entryGrace = $resCode[15];
            $exitGrace = $resCode[16];
            $inSelfie = $resCode[17];
            $outSelfie = $resCode[18];
            $remLeave = $resCode[19];
            $totalTwhMin += $twhMin;
            $totalOTMin += $overTime;
            $totalEarlyExitTime += $earlyExitBy;
            $totalLateTime += $lateby;


            $day++;
        }

        $allStatusCount = self::attendanceCount($Emp, $y, $m);
        // dd($twhMin);
        $twd = $allStatusCount[1] + $allStatusCount[2] + $allStatusCount[3] + $allStatusCount[4] + $allStatusCount[9] + $allStatusCount[8] + $allStatusCount[10] + $allStatusCount[11];
        $present = $allStatusCount[1] + $allStatusCount[3] + $allStatusCount[9] + $allStatusCount[8] / 2;
        $absent = $allStatusCount[2];
        $late = $allStatusCount[3];
        $mispunch = $allStatusCount[4];
        $holiday = $allStatusCount[6];
        $weekoff = $allStatusCount[7];
        $halfday = $allStatusCount[8];
        $overtime = $allStatusCount[9];
        $remainingleave = $remLeave;
        $totalPaidOffDay = $totalHolidays + $totalWeekOff + $totalPaidLeave;
        $totalWDinMonth =  $totalDayinMonth-$totalPaidOffDay;


        $cwh = ($totalTwhMin / 60);
        $twh = ($totalWDinMonth) * ($shiftWH / 60);
        $twhpercentage = $totalTwhMin != 0 && $shiftWH != 0 ? (($totalTwhMin / 60) / ($totalWDinMonth * ($shiftWH / 60))) * 100 : 0;
        // dd($twhpercentage);

        $rwh = ($totalWDinMonth) * ($shiftWH / 60) - $totalTwhMin / 60;

        $trwh = ($totalWDinMonth) * ($shiftWH / 60);

        $trwhpercentege = ((($totalWDinMonth) * ($shiftWH / 60) - $totalTwhMin / 60) / (($totalWDinMonth) * ($shiftWH / 60))) * 100;

        $otwh = $totalOTMin / 60;

        $totwh = $MaxOvertime / 60;

        $totwhpercentage = $MaxOvertime !== 0 ? ((($totalOTMin / 60) / ($MaxOvertime / 60))) * 100 : 0;

        $response = [
            $twd, //0
            $present, //1
            $absent, //2
            $late, //3
            $mispunch, //4
            $holiday, //5
            $weekoff, //6
            $halfday, //7
            $overtime, //8
            $remainingleave, //9
            $cwh, //10
            $twh, //11
            $twhpercentage, //12
            $rwh, //13
            $trwh, //14
            $trwhpercentege, //15
            $otwh, //16
            $totwh, //17
            $totwhpercentage //18
        ];

        // dd($response);
        return $response;
    }

    // All type calculation of Attendance for Dashboard
    static function GetCount($Date)
    {

        
        $leaveCount = 0;
        $misPunchCount = 0;
        $Present = 0;
        $Late = 0;
        $Overtime = 0;
        $HalfDay = 0;
        $Absent = 0;


        $EmpCount = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();
        $AttendanceList = AttendanceList::where('business_id', Session::get('business_id'))->get();
        $TodayAttendanceList = $AttendanceList->where('punch_date', $Date);
        $misPunchList = $AttendanceList->where('punch_date', $Date);

        foreach ($TodayAttendanceList as $key => $value) {
            $response = self::getEmpAttSumm(['emp_id' => $value->emp_id, 'punch_date' => $value->punch_date]);
            $status = $response[0];

            if ($status == 1 || $status == 5) {
                $Present++;
            } elseif ($status == 3) {
                $Late++;
            } elseif ($status == 9) {
                $Overtime++;
            } elseif ($status == 8) {
                $HalfDay++;
            } elseif ($status == 10 || $status == 11) {
                $leaveCount++;
            } elseif ($status == 2) {
                $Absent++;
            } elseif ($status == 4) {
                $misPunchCount++;
            }
        }


        $Present = $Present + $Late;
        $AbsentCount = $EmpCount - ($Present + $HalfDay + $misPunchCount);

        // foreach ($misPunchList as $mispunch) {
        //     if ($mispunch->emp_today_current_status == 1) {
        //         $misPunchCount++;
        //     }
        // }


        return [$EmpCount ?? 0, $Present ?? 0, $AbsentCount ?? 0, $HalfDay ?? 0, $leaveCount ?? 0, $misPunchCount ?? 0, $Late ?? 0, $Overtime ?? 0];

    }

    // Attendance Summary of Indivisual Employee for a Month 
    // $Emp = employee id 
    // $y = year 
    // $m = month
    static function attendanceCount($Emp, $y, $m)
    {
        $totalTwhMin = 0;
        $totalOTMin = 0;
        $totalLateTime = 0;
        $totalEarlyExitTime = 0;
        $day = 0;
        // $m = 10;
        $statusCounts = [
            1 => 0,
            // Present
            2 => 0,
            // Absent
            3 => 0,
            // Late
            4 => 0,
            // Mispunch
            5 => 0,
            // working
            6 => 0,
            // Holiday
            7 => 0,
            // Week Off
            8 => 0,
            // Half Day
            9 => 0,
            // Overtime
            10 => 0,
            // paid leave
            11 => 0,
            // unpaid leave
        ];

        $totalDayInMonth = ($m == date('m') ? date('d') : date('t', strtotime($m)));
        while (++$day <= $totalDayInMonth) {
            $date = $y . '-' . $m . '-' . $day;
            $resCode = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-d', strtotime($date))]);
            // dd($resCode);
            $status = $resCode[0];
            $overTime = $resCode[8];
            $twhMin = $resCode[10];
            $lateby = $resCode[12];
            $earlyExitBy = $resCode[13];
            $occurance = $resCode[14];
            $totalTwhMin += $twhMin;
            $totalOTMin += $overTime;
            if ($status == 3) {
                $totalEarlyExitTime += $earlyExitBy;
                $totalLateTime += $lateby;
            }

            $earlyOccurrenceIs = $occurance[0] ?? 0;
            $earlyOccurrence = $occurance[1] ?? 0;
            $earlyOccurrencePenalty = $occurance[2] ?? 0;

            $lateOccurrenceIs = $occurance[3] ?? 0;
            $lateOccurrence = $occurance[4] ?? 0;
            $lateOccurrencePenalty = $occurance[5] ?? 0;


            if ($status == 3) {
                if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 1) {
                    if ($lateOccurrenceIs == 1) {
                        if ($statusCounts[3] >= $lateOccurrence) {
                            if ($lateOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                        }
                    } elseif ($lateOccurrenceIs == 2) {
                        if ($totalLateTime >= $lateOccurrence) {
                            if ($lateOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                        }
                    }

                    if ($earlyOccurrenceIs == 1) {
                        if ($statusCounts[3] >= $earlyOccurrence) {
                            if ($earlyOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                        } elseif ($earlyOccurrenceIs == 2) {
                            if ($totalEarlyExitTime >= $earlyOccurrence) {
                                if ($earlyOccurrencePenalty == 1) {
                                    $statusCounts[8]++;
                                } else {
                                    $statusCounts[2]++;
                                }
                            }
                        }
                    }
                } else {
                    $statusCounts[3]++;
                }
                // dd($status);
            } else {
                $statusCounts[$status]++;
            }
            // dd($statusCounts);

        }

        return $statusCounts;
    }

    // Attendance Calculation of Indivisual Employee for a single day

    static function getEmpAttSumm($Emp)
    {
        // calculate present, absent, halfday, holiday, weekoff;

        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $Emp['emp_id'])
            ->select('emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();

        $holiday_policy = json_decode($employee->holiday_policy_ids_list ?? 0, true);
        $weekly_policy = json_decode($employee->weekly_policy_ids_list ?? 0, true);
        $shift_policy = json_decode($employee->shift_settings_ids_list ?? 0, true);
        $leave_policy = json_decode($employee->leave_policy_ids_list ?? 0, true);

        // dd($holiday_policy);




        if ($employee !== null && $employee->method_switch == 1) {

            $attendanceList = DB::table('attendance_list')
                ->where('business_id', Session::get('business_id'))
                ->where($Emp)
                ->first();


            $shift_type_found = false;

            foreach ($shift_policy as $policy) {
                if ($policy == $employee->emp_shift_type) {
                    $shift_type_found = true;
                    break; // No need to continue checking if we found a match
                }
            }

            if ($shift_type_found) {

                $shiftType = PolicyAttendanceShiftSetting::where([
                    'business_id' => Session::get('business_id'),
                    'id' => $employee->emp_shift_type,
                ])
                    ->first();

                if ($shiftType->shift_type == 2) {
                    $shift = PolicyAttendanceShiftTypeItem::where([
                        'business_id' => Session::get('business_id'),
                        'id' => $attendanceList->attendance_shift ?? 0,
                    ])
                        ->first();
                } else {
                    $shift = PolicyAttendanceShiftTypeItem::where([
                        'business_id' => Session::get('business_id'),
                        'attendance_shift_id' => $employee->emp_shift_type,
                    ])->first();
                }
            } else {
                return [5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $leavesPolicyItems = DB::table('policy_setting_leave_category')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'leave_policy_id' => $leave_policy[0],
                ])
                ->get();

            // $leaveRequestList = DB::table('approval_status_list')->where([
            //     'business_id' => Session::get('business_id'),
            //     'emp_id' => 'IT008',
            //     'approval_type_id' => 2,
            //     'status'=>1,
            // ])->get();

            // dd($leaveRequestList);

            $leaveRequestList = DB::table('request_leave_list')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'emp_id' => $Emp['emp_id'],
                    // 'status' => 1,
                ])
                ->whereMonth('from_date', date('m'))
                ->get();

            // dd($leaveRequestList);


            $lateEntry = PolicyAttenRuleLateEntry::where('business_id', Session::get('business_id'))
                ->first();
            $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', Session::get('business_id'))
                ->first();
            $overtimeRule = PolicyAttenRuleOvertime::where('business_id', Session::get('business_id'))
                ->first();

            $misPunchRequest = RequestMispunchList::where([
                'business_id' => Session::get('business_id'),
                'emp_id' => $Emp['emp_id'],
                'emp_miss_date' => $Emp['punch_date'],
            ])->first();


            foreach ($holiday_policy as $Hpolicy) {
                $isTodayHoliday = PolicyHolidayDetail::where([
                    'business_id' => Session::get('business_id'),
                    'holiday_date' => $Emp['punch_date'],
                    'template_id' => $Hpolicy,
                ])
                    ->first();
            }



            // dd(isset($attendanceList));
            $attendanceStatus = $attendanceList->emp_today_current_status ?? 0;
            $dayName = date('N', strtotime($Emp['punch_date']));
            $inTime = Carbon::parse($attendanceList->punch_in_time ?? 0)->format('H:i:s') !== '00:00:00' ? $attendanceList->punch_in_time : 0;
            $outTime = Carbon::parse($attendanceList->punch_out_time ?? 0)->format('H:i:s') !== '00:00:00' ? $attendanceList->punch_out_time : 0;
            $shiftStart = $shift->shift_start ?? 0;
            $shiftEnd = $shift->shift_end ?? 0;
            $entryGracetime = ($lateEntry->grace_time_hr ?? 0) * 60 + ($lateEntry->grace_time_min ?? 0);
            $exitGracetime = ($earlyExit->grace_time_hr ?? 0) * 60 + ($lateEntry->grace_time_min ?? 0);
            $markAbsentIf = $lateEntry->mark_half_day_hr * 60 + $earlyExit->mark_half_day_min ?? 0;
            $punchInLoc = $attendanceList->punch_in_address ?? 'Not Mark';
            $punchOutLoc = $attendanceList->punch_out_address ?? 'Not Mark';
            $in_selfie = $attendanceList->punch_in_selfie ?? '';
            $out_selfie = $attendanceList->punch_out_selfie ?? '';
            $shiftName = $shift->shift_name ?? 'Genral Shift';
            $breakTime = $shift->break_min ?? '00';
            $maxOvertime = $overtimeRule->max_ot_hr * 60 + $overtimeRule->max_ot_min;
            $shiftStartObj = Carbon::parse($shiftStart);
            $shiftEndObj = Carbon::parse($shiftEnd);
            $inTimeObj = Carbon::parse($inTime);
            $outTimeObj = Carbon::parse($outTime);
            $leaveDetail = [];
            $remLeave = 0;


            // leave calculation 

            foreach ($leavesPolicyItems as $leave) {
                // some variables
                $tLeave = 0;                        //total leave of all type of leave
                $appliedLeave = 0;                  //applied leave by user of particular leave type
                $leaveLimit = $leave->days;          //max leave for leave type
                $leaveRequest = $leaveRequestList->where('leave_category', $leave->id);
                foreach ($leaveRequest as $list) {
                    $to = Carbon::parse($list->to_date);
                    $punch_date = Carbon::parse($Emp['punch_date']);
                    if ($to < $punch_date) {
                        $tLeave = $tLeave + $list->days;
                        $appliedLeave = $appliedLeave + $list->days;
                    }
                }
                $remaining = $leaveLimit - $appliedLeave;
                $leaveDetail[$leave->id] = [
                    'name' => $leave->category_name,
                    'limit' => $leaveLimit,
                    'remaining' => $remaining,
                    'total_applied' => $tLeave,
                ];
            }

            foreach ($leaveDetail as $key => $detail) {
                $remLeave = $remLeave + $detail['remaining'];
            }
            // dd($remLeave);



            // occurance in $earlyExit  and $lateEntry
            if ($earlyExit->switch_is != null && $earlyExit->switch_is == 1) {
                if ($earlyExit->occurance_is == 1) {
                    $earlyOccurance = $earlyExit->occurance_count;
                } else {
                    $earlyOccurance = $earlyExit->occurance_hr * 60 + $earlyExit->occurance_min;
                }
            }

            if ($lateEntry->switch_is != null && $lateEntry->switch_is == 1) {
                if ($lateEntry->occurance_is == 1) {
                    $lateOccurance = $lateEntry->occurance_count;
                } else {
                    $lateOccurance = $lateEntry->occurance_hr * 60 + $lateEntry->occurance_min;
                }
                $ruleCount = [
                    0 => $earlyExit->occurance_is,
                    1 => $earlyOccurance ?? 0,
                    2 => $earlyExit->absent_is,
                    3 => $lateEntry->occurance_is,
                    4 => $lateOccurance,
                    5 => $lateEntry->absent_is,
                ];
            } else {
                $ruleCount = [
                    0 => 0,
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                ];
            }

            // dd($ruleCount);

            // difference between in and out time
            $punchInterval = $outTimeObj->diff($inTimeObj);
            $twh = $punchInterval->h . ' hr ' . $punchInterval->i . ' min'; // Use 'i' for minutes
            $twhMin = $punchInterval->h * 60 + $punchInterval->i; // Use 'i' for minutes
            // dd($twhMin);

            //calculate overtime:- (punchOut-punchIn)-(shiftEnd-shiftStart) = Overtime
            $shiftInterval = $shiftEndObj->diff($shiftStartObj);

            // Calculate total minutes for punchInterval and shiftInterval for overtime
            $punchIntervalMinutes = $punchInterval->h * 60 + $punchInterval->i;
            $shiftIntervalMinutes = $shiftInterval->h * 60 + $shiftInterval->i;
            $overtime = $punchIntervalMinutes - $shiftIntervalMinutes;
            $overtimeValue = $overtime > 0 ? $overtime : 0;

            // calculate overtime if overtime rule is active
            if ($overtimeRule->switch_is == 1 && $overtimeValue > 0) {
                $inTimeObj = Carbon::parse($inTime);
                $outTimeObj = Carbon::parse($outTime);

                $shiftStartObj = Carbon::parse($shiftStart);
                $shiftEndObj = Carbon::parse($shiftEnd);

                $earlyOtTime = $overtimeRule->early_ot_hr * 60 + $overtimeRule->early_ot_min;
                $lateOtTime = $overtimeRule->late_ot_hr * 60 + $overtimeRule->late_ot_min;

                $earlyCommingTime = $shiftStartObj->subMinutes($earlyOtTime);
                $lateGoingTime = $shiftEndObj->addMinutes($lateOtTime);

                if ($inTimeObj < $earlyCommingTime) {
                    $earlyIn = $earlyCommingTime;
                    if ($outTimeObj > $lateGoingTime) {
                        $lateGoing = $lateGoingTime;
                        $totalWork = $lateGoing->diff($earlyIn);
                    } else {
                        $totalWork = $outTimeObj->diff($earlyIn);
                    }
                } elseif ($outTimeObj > $lateGoingTime) {
                    $lateGoing = $lateGoingTime;
                    $totalWork = $lateGoing->diff($inTimeObj);
                } else {
                    $totalWork = $outTimeObj->diff($inTimeObj);
                }

                $totalshiftInterval = $earlyCommingTime->diff($lateGoingTime);

                $twhIntervalMinutes = $totalshiftInterval->h * 60 + $totalshiftInterval->i - ($shiftInterval->h * 60 + $shiftInterval->i);
                $overtimeValue = ($totalWork->h * 60 + $totalWork->i) - ($shiftInterval->h * 60 + $shiftInterval->i);

                $overtimeValue = min($overtimeValue, $twhIntervalMinutes);
                $overtimeValue = $overtimeValue >= 0 ? $overtimeValue : 0;

                // dd($inTimeObj);
            }

            // add grace time to entry time
            $shiftStartObj = Carbon::parse($shiftStart);
            $addedTime = $shiftStartObj->addMinutes($entryGracetime);
            $entryGrace = date('H:i', strtotime($addedTime));

            // sub grace time to exit time
            $shiftEndObj = Carbon::parse($shiftEnd);
            $exitGraceTime = $shiftEndObj->subMinutes($exitGracetime);
            $exitGrace = date('H:i', strtotime($exitGraceTime));

            // Mark absent half day if late by
            $halfAbsentTimeObj = $shiftStartObj->addMinutes($markAbsentIf);
            $absentHalfTime = date('H:i', strtotime($halfAbsentTimeObj));

            // Mark absent half day if early exit by
            $earlyExitMin = $earlyExit->mark_half_day_hr * 60 + $earlyExit->mark_half_day_min;
            $shiftEndObj = Carbon::parse($shiftEnd);
            $earlyExitBefore = $shiftEndObj->subMinutes($earlyExitMin);
            $EarlyExitTime = date('H:i', strtotime($earlyExitBefore));

            // calculate late by and early exit by
            $shiftStartObj = Carbon::parse($shiftStart);
            $shiftEndObj = Carbon::parse($shiftEnd);
            $inTimeObj = Carbon::parse($inTime);
            $outTimeObj = Carbon::parse($outTime);
            $lateBy = 0;
            $earlyExitBy = 0;

            if ($lateEntry->switch_is != null && $lateEntry->switch_is == 1 && $inTime > $entryGrace) {
                $lateByObj = $shiftStartObj->diff($inTimeObj);
                $lateBy = $lateByObj->h * 60 + $lateByObj->i;
            }

            if ($earlyExit->switch_is != null && $earlyExit->switch_is == 1 && $outTime < $exitGrace && $inTime && $outTime) {
                // dd(Carbon::parse($outTime)->format('H:i:s') !== '00:00:00');
                if (Carbon::parse($outTime)->format('H:i:s') !== '00:00:00') {
                    $earlyExitByObj = $shiftEndObj->diff($outTimeObj);
                    $earlyExitBy = $earlyExitByObj->h * 60 + $earlyExitByObj->i;
                } else {
                    $earlyExitBy = 0;
                }
            }
            // dd();

            // Status Code :-
            // Method Switch Off = 0
            // Present = 1
            // Absent = 2
            // Late = 3
            // Mispunch = 4
            // Working = 5
            // Holiday = 6
            // Weekoff = 7
            // Half day  = 8
            // Overtime  = 9
            // paid leave = 10
            //unpaid leave = 11


            $status = 2; // Default status (e.g., Absent)

            if (isset($attendanceList)) {
                // dd('if');
                if ($attendanceStatus >= 1) {
                    if ($attendanceStatus >= 2) {
                        if ($twhMin > $shiftIntervalMinutes / 2) {
                            if ($lateEntry->switch_is != null && $lateEntry->switch_is == 1 && $inTime > $entryGrace) {
                                if ($markAbsentIf > 0 && $inTime > $absentHalfTime) {
                                    $status = 8; // Half Day (Late)
                                } else {
                                    $status = 3; // Late
                                }
                                // dd($Emp);
                            } elseif ($earlyExit->switch_is != null && $earlyExit->switch_is == 1 && $outTime < $exitGrace) {
                                // Half Day (Late)
                                if ($earlyExitMin > 0 && $outTime < $EarlyExitTime) {
                                    $status = 8;
                                } else {
                                    // dd($outTime);
                                    $status = 3;
                                }
                            } else {
                                if ($punchIntervalMinutes > $shiftIntervalMinutes) {
                                    $status = 9; // Overtime
                                } else {
                                    $status = 1; // Present
                                }
                            }
                        } else {
                            $status = 2; //Absent
                        }
                    } else {
                        // dd();
                        if (date('Y-m-d', strtotime($Emp['punch_date'])) === date('Y-m-d')) {
                            $status = 1; // working
                        } else {
                            $status = 4; // Mis-punch
                        }
                    }
                }
            } elseif ($isTodayHoliday) {
                $status = 6; // Holiday
            } elseif (count($leaveRequestList) > 0) {
                // checking employee has any leave request or not

                foreach ($leaveRequestList as $list) {
                    $leaveFrom = Carbon::parse($list->from_date);
                    $leaveTo = Carbon::parse($list->to_date);
                    $today = Carbon::parse($Emp['punch_date']);
                    // $today = Carbon::parse(date('Y-m-d'));

                    if ($today >= $leaveFrom && $today <= $leaveTo) {
                        $remainingLeaves = $leaveDetail[$list->leave_category]['remaining'];
                        $day = $leaveFrom->diffInDays($today) + 1;
                        while ($day-- > 0) {
                            if ($remainingLeaves != 0) {
                                $status = 10; //paid leave
                                $remainingLeaves--;
                            } else {
                                $status = 11; // unpaid leave
                            }
                        }
                    } else {
                        foreach ($weekly_policy as $key => $wPolicy) {
                            $weekOff = DB::table('policy_weekly_holiday_list')
                                ->where([
                                    'business_id' => Session::get('business_id'),
                                    'id' => $wPolicy,
                                ])
                                ->first();
                            foreach (json_decode($weekOff->days) as $day) {
                                if (date('N', strtotime($day)) == $dayName) {
                                    $status = 7; // Week Off
                                    break;
                                }
                            }
                        }
                    }
                }
            } else {
                foreach ($weekly_policy as $key => $wPolicy) {
                    $weekOff = DB::table('policy_weekly_holiday_list')
                        ->where([
                            'business_id' => Session::get('business_id'),
                            'id' => $wPolicy,
                        ])
                        ->first();
                    foreach (json_decode($weekOff->days) as $day) {
                        if (date('N', strtotime($day)) == $dayName) {
                            $status = 7; // Week Off
                            break;
                        }
                    }
                }
            }

            // dd($twhMin);

            return [
                $status,
                //day status present, absent etc.
                $inTime,
                // punch in time
                $outTime,
                // punch out time
                $twh,
                // total working hour
                $punchInLoc,
                //punch in location
                $punchOutLoc,
                // punch out location
                $shiftName,
                // shift name
                $breakTime,
                // break time
                $overtimeValue,
                // overtime
                $shiftIntervalMinutes,
                //shift working hour
                $twhMin,
                // total working hour minutes
                $maxOvertime,
                // maximum overtime for a single month
                $lateBy,
                //late by
                $earlyExitBy,
                // early exit by
                $ruleCount,
                // occurances for late and early rule
                $entryGrace,
                //shift start time with grace time
                $exitGrace,
                //shift endd time with grace time
                $in_selfie,
                // punch in selfie
                $out_selfie,
                //punch out selfie
                $remLeave,
                //remaining leave
                $leaveDetail // details of leave
            ];
        }
        return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }

    // ********************************************************** End of Attendance Calculation By Aman ***************************************
}
