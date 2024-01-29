<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use App\Models\LoginAdmin;
use App\Models\AttendanceDailyCount;
use App\Models\AttendanceMonthlyCount;
use App\Models\EmployeeLeaveBalance;
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
use App\Http\Controllers\ApiController\CalendarController;
use Illuminate\Support\Facades\DB;

// use App\Models\admin\
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRofles;
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
        // print_R(self::$LoginRole);
        // $result = DB::table('universal_roles_define')->where('role_id', $roleId)->select('role_name')->first();
        // sftp://jayant_fd_hr@143.244.136.30/public_html/app/Models/PolicySettingRoleCreate.php

        $load = DB::table('business_details_list')->where('login_type', self::$LoginRole)->where('business_id', self::$BusinessID)->first();
        if (isset($load)) {
            return 'Owner';
        } else {

            $result = PolicySettingRoleCreate::where('business_id', Session::get('business_id'))->where('id', self::$LoginRole)
                ->select('roles_name')
                ->first();

            // $result = DB::table('roles')->where('id', self::$LoginRole)->select('name')->first();
            // // dd($result);
            // // Check if a result was found
            if ($result) {
                return $result->roles_name; // Return the role_name property
            } else if (!$result) {
            } elseif (self::$LoginRole == 0) {
                return 'Unknown Role';
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
        $BusinessID = Session('business_id');
        $loginEmpId = Session::get('login_emp_id');
        $checkpermission = PolicySettingRoleAssignPermission::where('business_id', $BusinessID)
            ->where('emp_id', $loginEmpId)
            ->select('permission_branch_id')
            ->pluck('permission_branch_id')
            ->first();
        // Decode the JSON string into an array
        $checkArray = json_decode($checkpermission, true);
        if ($checkArray !== null && !empty($checkArray) && (Session::get('login_role')) != 1) {
            return BranchList::where('business_id', $BusinessID)->where('branch_id', $checkArray)->select('*')->get();
        } else {
            return BranchList::where('business_id', $BusinessID)->select('*')->get();
        }
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

    static function AttendanceMode()
    {
        return DB::table('static_attendance_mode')->get();
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
            ->where('active_emp', 1)
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
            ->select(
                '*',
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_start_time, '%h:%i %p'), NULL) AS applied_shift_comp_start_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_end_time, '%h:%i %p'), NULL) AS applied_shift_comp_end_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"),
            )
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
        $adminCount = PolicySettingRoleAssignPermission::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'policy_setting_role_assign_permission.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('policy_setting_role_assign_permission.business_id', Session::get('business_id'))
            ->select('policy_setting_role_assign_permission.*')
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
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        // Get the current month and year
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $checkArray = json_decode(
            PolicySettingRoleAssignPermission::where('business_id', $businessId)
                ->where('emp_id', Session::get('login_emp_id'))
                ->select('permission_branch_id')
                ->pluck('permission_branch_id')
                ->first(),
            true
        );

        if ($checkArray !== null && !empty($checkArray) && $roleIdToCheck != 1) {
            $totalEmp = DB::table('employee_personal_details')->where('business_id', $businessId)->where('branch_id', $checkArray)->where('active_emp', '1')->count();
            $present = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('employee_personal_details.branch_id', $checkArray)->where('attendance_list.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->where('attendance_list.punch_date', date('Y-m-d'))->whereIn('attendance_list.today_status', [1, 4, 9, 3])->count();
            $PaidLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.leave_category', '!=', '9')
                ->where('employee_personal_details.branch_id', $checkArray)
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
            $UnpaidLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.leave_category', '9')
                ->where('employee_personal_details.branch_id', $checkArray)
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
            $PendingLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.final_status', 0)
                ->where('employee_personal_details.branch_id', $checkArray)
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
        } else {
            $totalEmp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('active_emp', '1')->count();
            $present = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('attendance_list.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->where('attendance_list.punch_date', date('Y-m-d'))->whereIn('attendance_list.today_status', [1, 4, 9, 3])->count();
            $PaidLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.leave_category', '!=', '9')
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
            $UnpaidLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.leave_category', '9')
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
            $PendingLeave = DB::table('request_leave_list')
                ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('request_leave_list.business_id', Session::get('business_id'))
                ->where('request_leave_list.final_status', 0)
                ->whereYear('request_leave_list.created_at', $currentYear)
                ->whereMonth('request_leave_list.created_at', $currentMonth)
                ->count();
        }
        if ($totalEmp != null || $present != null || $PaidLeave != null || $UnpaidLeave != null || $PendingLeave != null) {
            return [$totalEmp, $present, $PaidLeave, $UnpaidLeave, $PendingLeave];
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
        $load = PolicySettingLeaveCategory::join('static_leave_category', 'static_leave_category.id', '=', 'policy_setting_leave_category.category_name')->join('static_leave_category_applicable_to', 'static_leave_category_applicable_to.id', '=', 'policy_setting_leave_category.applicable_to')
            ->where('business_id', Session::get('business_id'))
            ->where('leave_policy_id', $id)
            ->select('policy_setting_leave_category.*', 'static_leave_category.name as static_category_name', 'static_leave_category_applicable_to.name as static_leave_category_applicable_name')
            ->get();
        //     $Leaves = PolicySettingLeaveCategory::
        //     join('static_leave_category', 'static_leave_category.id', '=' , 'policy_setting_leave_category.category_name')
        // ->where('business_id', $request->session()->get('business_id'))
        // ->select('policy_setting_leave_category.*', 'static_leave_category.name as static_category_name')
        // ->get();
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

    static function CalculateTimeDifference($inTime, $outTime)
    {
        // Parse the input timestamps as Carbon objects
        $inTimeObj = Carbon::parse($inTime);
        $outTimeObj = Carbon::parse($outTime);

        // Calculate the time difference
        $timeDifference = $outTimeObj->diff($inTimeObj);

        return $timeDifference;
    }
    // ********************************************************** Common Functions Created By Aman ***************************************

    static function getIndivisualEmployeeDetails($EmpId)
    {
        $item1 = 0;
        $business_id = Session::get('business_id');
        $emp_id = $EmpId;
        $now = DB::table('employee_personal_details')
            ->join('policy_attendance_shift_settings', 'policy_attendance_shift_settings.id', '=', 'employee_personal_details.emp_shift_type')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->select('policy_attendance_shift_settings.shift_type as shift_type')
            ->first(); // Use first() to retrieve a single row

        $now1 = (int) $now->shift_type;

        if ($now1 == 2) {
            $item = DB::table('employee_personal_details')
                ->where('employee_personal_details.emp_id', $emp_id)
                ->where('employee_personal_details.business_id', $business_id)
                ->where('employee_personal_details.active_emp', 1)
                ->select('emp_rotational_shift_type_item')
                ->first();
            $item1 = (int) $item->emp_rotational_shift_type_item;
        }


        $emp = DB::table('employee_personal_details')
            ->join('static_employee_join_gender_type as employeegender', 'employee_personal_details.emp_gender', '=', 'employeegender.id')
            ->join('static_employee_join_emp_type as employeetype', 'employee_personal_details.employee_type', '=', 'employeetype.type_id')
            ->join('policy_master_endgame_method as mem', 'employee_personal_details.master_endgame_id', '=', 'mem.id')
            ->join('static_attendance_endgame_policypreference as policypreference', 'mem.policy_preference', '=', 'policypreference.id')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->join('designation_list', 'employee_personal_details.designation_id', '=', 'designation_list.desig_id')
            ->join('static_attendance_methods as am1', 'employee_personal_details.emp_attendance_method', '=', 'am1.id')
            ->join('policy_attendance_shift_settings as attendanceShift', 'employee_personal_details.emp_shift_type', '=', 'attendanceShift.id')
            ->join('static_attendance_shift_type', 'attendanceShift.shift_type', '=', 'static_attendance_shift_type.id')
            ->join('policy_attendance_shift_type_items', 'attendanceShift.id', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.active_emp', 1)
            ->where('employee_personal_details.business_id', $business_id)
            ->where(function ($query) use ($now1, $item1) {
                if ($now1 == 2) {
                    //rotation
                    $query->where('attendanceShift.shift_type', $now1)->where('policy_attendance_shift_type_items.id', $item1);
                } else {
                    //open
                    $query->where('attendanceShift.shift_type', $now1);
                }
            })
            ->select('employee_personal_details.*', 'employeegender.gender_type as gender', 'policypreference.policy_name', 'mem.method_name', 'mem.method_switch', 'mem.method_name', 'mem.leave_policy_ids_list', 'mem.holiday_policy_ids_list', 'mem.weekly_policy_ids_list', 'mem.shift_settings_ids_list', 'employeetype.emp_type as emp_type_name', 'am1.method_name as attendance_method_name', 'static_attendance_shift_type.name as attendance_shift_name', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end')
            ->first();



        // dd($emp);
        return $emp;
    }

    static function rotateShiftWeekly()
    {
        $Shift = DB::table('policy_attendance_shift_settings')
            ->where('business_id', Session::get('business_id'))
            ->where('shift_type', 2)
            ->get();
        foreach ($Shift as $key => $shift) {
            $ShiftItem = DB::table('policy_attendance_shift_type_items')
                ->where('business_id', Session::get('business_id'))
                ->where('attendance_shift_id', $shift->id)
                ->get();

            $prevId = -1;
            $prevColone = $prevId;
            foreach ($ShiftItem as $key => $item) {
                $currId = $item->id;

                $EmpList = DB::table('employee_personal_details')
                    ->where('business_id', Session::get('business_id'))
                    ->where('emp_rotational_shift_type_item', $currId)
                    ->update(['emp_rotational_shift_type_item' => $prevId]);

                $prevId = $currId;
            }

            // Update the first employee with the last shift ID
            DB::table('employee_personal_details')
                ->where('business_id', Session::get('business_id'))
                ->where('emp_rotational_shift_type_item', $prevColone)
                ->update(['emp_rotational_shift_type_item' => $prevId]);
        }
    }
    static function getTimeLog($empId, $date)
    {
        $data = DB::table('attendance_time_log')->where(['business_id' => Session::get('business_id'), 'emp_id' => $empId, 'punch_date' => $date])
            ->select(
                'attendance_time_log.*',
                DB::raw("IFNULL(DATE_FORMAT(attendance_time_log.changed_in_time, '%h:%i %p'), NULL) AS changed_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_time_log.changed_out_time, '%h:%i %p'), NULL) AS changed_out_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_time_log.prev_in_time, '%h:%i %p'), NULL) AS prev_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_time_log.prev_out_time, '%h:%i %p'), NULL) AS prev_out_time"),

            )->get();
        return $data;
    }



    ////////////////////// Start Exact Count //////////////////////
    static function MyCountForDaily($date, $businessID)
    {
        $punchDate = date('Y-m-d', strtotime($date));

        $createDailyCount = 0;
        $updateDailyCount = 0;

        $attendance = DB::table('attendance_list')->where(['business_id' => $businessID, 'punch_date' => $punchDate])->get();

        $leave = DB::table('request_leave_list')
            ->where([
                'business_id' => Session::get('business_id'),
            ])
            ->where('final_status', 1)
            ->whereDate('from_date', '<=', date('Y-m-d', strtotime($date)))
            ->whereDate('to_date', '>=', date('Y-m-d', strtotime($date)))
            ->count();


        $overtime = $attendance->where('today_status', 9)->count();
        $absent = $attendance->where('today_status', 2)->count();
        $late = $attendance->where('today_status', 3)->count();
        $early = $attendance->where('today_status', 12)->count();
        $halfday = $attendance->where('today_status', 8)->count();
        $leave1 = $attendance->where('today_status', 10)->count();
        $leave2 = $attendance->where('today_status', 11)->count();
        $mispunch = $attendance->where('today_status', 4)->count();
        $present = $attendance->where('today_status', 1)->count() + $overtime + $late + $early;


        $getTodayCount = DB::table('attendance_daily_count')->where(['business_id' => $businessID, 'date' => $punchDate])->first();
        $totalEmp = $getTodayCount->total_emp ?? 0;
        if (isset($getTodayCount)) {

            $updateDailyCount = AttendanceDailyCount::where([
                'business_id' => $businessID,
                'date' => date('Y-m-d', strtotime($punchDate)),
            ])->update([
                'present' => $present ?? 0,
                'absent' => ($totalEmp ?? 0) - ($present ?? 0) - ($mispunch ?? 0) - ($halfday ?? 0) + ($absent ?? 0),
                'late' => $late ?? 0,
                'early' => $early ?? 0,
                'mispunch' => $mispunch ?? 0,
                'halfday' => $halfday ?? 0,
                'overtime' => $overtime,
                'leave' => $leave ?? 0,
            ]);
        } else {
            $totalEmp = DB::table('employee_personal_details')->where('active_emp', '1')->where('business_id', $businessID)->count();

            $createDailyCount = AttendanceDailyCount::create([
                'business_id' => $businessID,
                'date' => date('Y-m-d', strtotime($punchDate)),
                'total_emp' => $totalEmp ?? 0,
                'present' => $present ?? 0,
                'absent' => ($totalEmp ?? 0) - ($present ?? 0) - ($mispunch ?? 0) - ($halfday ?? 0) + ($absent ?? 0),
                'late' => $late ?? 0,
                'early' => $early ?? 0,
                'mispunch' => $mispunch ?? 0,
                'halfday' => $halfday ?? 0,
                'overtime' => $overtime,
                'leave' => $leave ?? 0,
            ]);
        }

        return [$createDailyCount, $updateDailyCount];
    }


    static function setCountAtOnceForDailyAndMonthly()
    {
        $Attendance = AttendanceList::where('business_id', Session::get('business_id'))->get();

        foreach ($Attendance as $key => $atten) {
            self::MyCountForMonth($atten->emp_id, date('Y-m-d', strtotime($atten->punch_date)), Session::get('business_id'));
            self::MyCountForDaily(date('Y-m-d', strtotime($atten->punch_date)), Session::get('business_id'));
        }
    }


    static function MyCountForMonth($empID, $date, $businessID)
    {
        // dd('d');
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $totalDay = $month == date('m') ? date('d', strtotime($date)) : date('t', strtotime($date));

        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', $businessID)
            ->where('employee_personal_details.emp_id', $empID)
            ->where('employee_personal_details.active_emp', 1)
            ->select('emp_date_of_joining', 'master_endgame_id', 'emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();


        $monthlyCount = DB::table('attendance_monthly_count')->where(['business_id' => $businessID, 'emp_id' => $empID])->where('month', $month)->where('year', $year)->first();

        $attendanceData = DB::table('attendance_list')->where(['business_id' => $businessID, 'emp_id' => $empID])->whereMonth('punch_date', $month)->whereYear('punch_date', $year)->get();
        $overtime = $attendanceData->where('today_status', 9)->count();
        $absent = $attendanceData->where('today_status', 2)->count();
        $late = $attendanceData->where('today_status', 3)->count();
        $early = $attendanceData->where('today_status', 12)->count();
        $halfday = $attendanceData->where('today_status', 8)->count();
        // $leave1 = $attendanceData->where('today_status', 10)->count();
        // $leave2 = $attendanceData->where('today_status', 11)->count();
        $mispunch = $attendanceData->where('today_status', 4)->count();
        $present = $attendanceData->where('today_status', 1)->count() + $overtime + $late + $early;

        $holidays = DB::table('attendance_holiday_list')
            ->where([
                'business_id' => $businessID,
                'master_end_method_id' => $employee->master_endgame_id ?? 0,
            ])
            ->whereMonth('holiday_date', date('m', strtotime($date)))
            ->whereYear('holiday_date', date('Y', strtotime($date)))
            ->whereDate('holiday_date', '<', date('Y-m-d', strtotime($date)))
            ->get();


        $holidayWeekCount = DB::table('attendance_holiday_list')
            ->whereYear('holiday_date', date('Y', strtotime($date)))
            ->whereMonth('holiday_date', date('m', strtotime($date)))
            ->where(['business_id' => Session::get('business_id'), 'master_end_method_id' => $employee->master_endgame_id ?? 0])
            ->whereDate('holiday_date', '<', date('Y-m-d', strtotime($date)))
            ->groupBy('holiday_date')
            ->get();

        $machingDays = 0;
        foreach ($holidayWeekCount as $key => $holiday) {
            $attendanceForCheck = DB::table('attendance_list')->where('emp_id', $empID)->where('punch_date', $holiday->holiday_date)->first();
            $leave = DB::table('request_leave_list')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'emp_id' => $empID
                ])
                ->where('final_status', 1)
                ->whereDate('from_date', '<=', $holiday->holiday_date)
                ->whereDate('to_date', '>=', $holiday->holiday_date)
                ->first();

            if (isset($leave) || isset($attendanceForCheck) || isset($leave1)) {
                // dd($empID,$leave,$attendanceForCheck);
                $machingDays++;
            }
        }
        $attendanceFor = DB::table('attendance_list')->where('emp_id', $empID)->whereMonth('punch_date', date('m', strtotime($date)))->get();
        foreach ($attendanceFor as $key => $att) {
            $leave1 = DB::table('request_leave_list')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'emp_id' => $empID
                ])
                ->where('final_status', 1)
                ->whereDate('from_date', '<=', $att->punch_date)
                ->whereDate('to_date', '>=', $att->punch_date)
                ->first();

            if (isset($leave1)) {
                // dd($empID,$leave,$attendanceForCheck);
                $machingDays++;
            }
        }

        // dd($machingDays);

        $weekOff = $holidays->where('holiday_type_id', 2)->count();
        $holiday = $holidays->where('holiday_type_id', 1)->count();
        $bothCountWithGroup = $holidayWeekCount->count() - $machingDays;

        $leave = DB::table('request_leave_list')
            ->where('emp_id', $empID)
            ->where('final_status', 1)
            ->where(function ($query) use ($date) {
                $query->whereMonth('from_date', date('m', strtotime($date)))
                    ->orWhereMonth('to_date', date('m', strtotime($date)));
            })
            ->whereDate('from_date', '<=', date('Y-m-d', strtotime($date)))
            ->get();

        $LeaveCount = 0;

        foreach ($leave as $key => $Leave) {
            if (date('m', strtotime($Leave->from_date)) == date('m', strtotime($Leave->to_date . '-1 month'))) {
                $from = date('Y', strtotime($Leave->to_date)) . '-' . date('m', strtotime($Leave->to_date)) . '-01';
                $fromDate = Carbon::parse($from);
                $toDate = Carbon::parse($Leave->to_date);
                $dayDifference = $fromDate->diffInDays($toDate);
                $LeaveCount = $LeaveCount + $dayDifference + 1;
            } elseif (date('m', strtotime($Leave->to_date)) == date('m', strtotime($Leave->from_date . '+1 month'))) {
                $fromDate = Carbon::parse($Leave->from_date);
                $to = date('Y', strtotime($Leave->from_date)) . '-' . date('m', strtotime($Leave->from_date)) . '-' . date('t', strtotime($Leave->from_date));
                $toDate = Carbon::parse($to);
                $dayDifference = $fromDate->diffInDays($toDate);
                $LeaveCount = $LeaveCount + $dayDifference + 1;
            } else {
                $LeaveCount = $LeaveCount + $Leave->days;
            }
        }

        $leaveC = $LeaveCount;
        if (is_float($leaveC)) {
            $leaveC = intval($leaveC + 0.5);
        }

        $calculatedAbsent = (($totalDay) - ($present + $halfday + $bothCountWithGroup + $leaveC + $mispunch));
        $calculatedAbsent = (($totalDay) - ($present + $halfday + $mispunch));


        if (isset($monthlyCount)) {
            $up = DB::table('attendance_monthly_count')
                ->where([
                    'business_id' => $businessID,
                    'emp_id' => $empID,
                    'year' => $year,
                    'month' => $month,
                ])
                ->update([
                    'present' => $present ?? 0,
                    'absent' => ($calculatedAbsent < 0) ? 0 : $calculatedAbsent,
                    'late' => $late ?? 0,
                    'early_exit' => $early ?? 0,
                    'mispunch' => $mispunch ?? 0,
                    'holiday' => $holiday ?? 0,
                    'week_off' => $weekOff ?? 0,
                    'half_day' => $halfday ?? 0,
                    'overtime' => $overtime,
                    'leave' => $LeaveCount,
                ]);

            // dd($up);
        } else {
            DB::table('attendance_monthly_count')->insert([

                'business_id' => $businessID,
                'emp_id' => $empID,
                'year' => $year,
                'month' => $month,
                'present' => $present ?? 0,
                'absent' => ($calculatedAbsent < 0) ? 0 : $calculatedAbsent,
                'late' => $late ?? 0,
                'early_exit' => $early ?? 0,
                'mispunch' => $mispunch ?? 0,
                'holiday' => $holiday ?? 0,
                'week_off' => $weekOff ?? 0,
                'half_day' => $halfday ?? 0,
                'overtime' => $overtime,
                'leave' => $LeaveCount,
            ]);
        }

        self::setLateForPunchIN($empID, $date, $businessID);

        return 0;
    }

    ////////////////////// End Exact Count //////////////////////

    public static function setLateForPunchIN($empID, $date, $businessID)
    {

        $attendance = DB::table('attendance_list')->where('emp_id', $empID)->where('punch_date', date('Y-m-d', strtotime($date)))->first();
        if ($attendance) {
            $lateEntry = PolicyAttenRuleLateEntry::where('business_id', $businessID)->first();
            $lateBy = 0;
            $switch = $lateEntry->switch_is;
            $gracetimeMin = $lateEntry->grace_time_hr * 60 + $lateEntry->grace_time_min;
            $inTime = Carbon::parse($attendance->punch_in_time);
            $shiftStart = Carbon::parse($attendance->applied_shift_comp_start_time);
            $gracetime = $shiftStart->addMinutes($gracetimeMin);

            if (($switch ?? 0) == 1) {
                if ($inTime > $gracetime) {
                    $shiftStart1 = Carbon::parse($attendance->applied_shift_comp_start_time);
                    $lateBy = $shiftStart1->diffInMinutes($inTime);
                }
            }

            $update = DB::table('attendance_list')
                ->where('emp_id', $empID)
                ->where('punch_date', date('Y-m-d', strtotime($date)))
                ->update(['late_by' => $lateBy]);
            // addded
        }
        return 0;
    }

    public static function getEmpLeaveDetails($empID, $Date)
    {

        // $empID = 'IT009';
        // $Date = date('2024-01-21');

        $leave = DB::table('request_leave_list')
            ->join('static_leave_category', 'request_leave_list.leave_category', '=', 'static_leave_category.id')
            ->where('request_leave_list.emp_id', $empID)->where('request_leave_list.from_date', '<=', $Date)
            ->whereDate('request_leave_list.to_date', '>=', $Date)
            ->where('request_leave_list.business_id', Session::get('business_id'))
            ->first();
        return $leave;
    }

    public static function getCountry()
    {
        return DB::table('static_countries')->orderBy('Name')->get();
    }
    public static function getState()
    {
        return DB::table('static_states')->orderBy('Name')->get();
    }

    public static function getHolidayFromDB($Emp, $Date)
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('active_emp', 1)->first();
        $Holiday = DB::table('attendance_holiday_list')->where(['business_id' => Session::get('business_id'), 'master_end_method_id' => $Emp->master_endgame_id, 'holiday_date' => date('Y-m-d', strtotime($Date))])->first();
        return $Holiday;
    }

    public static function getCity()
    {
        return
            DB::table('static_cities')->orderBy('Name')->get();
    }


    static function attendanceByEmpDetails($Emp, $y, $m)
    {

        // $machingDays = 0;
        $empDetails = DB::table('employee_personal_details')->where(['business_id' => Session::get('business_id'), 'emp_id' => $Emp, 'active_emp' => 1])->first();
        $shift = $empDetails->assign_shift_type == 2 && $empDetails->assign_shift_type != 0 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();
        $present = DB::table('attendance_list')
            ->select(DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(total_working_hour))) as total_working_hours'))
            ->where(['business_id' => Session::get('business_id'), 'emp_id' => $Emp])
            ->whereIn('today_status', [1, 3, 9, 12, 8])
            ->whereMonth('punch_date', $m)
            ->whereYear('punch_date', $y)
            ->first();
        $holidayWeekOff = DB::table('attendance_holiday_list')->whereYear('holiday_date', $y)->whereMonth('holiday_date', $m)->where(['business_id' => Session::get('business_id'), 'master_end_method_id' => $empDetails->master_endgame_id])->groupBy('holiday_date')->get();
        $weekOffHoliDayCount = $holidayWeekOff->count();
        $offDayCount = $weekOffHoliDayCount;

        //maximum overtime
        $otRule = DB::table('policy_atten_rule_overtime')->where(['business_id' => Session::get('business_id')])->first();

        if ($otRule->switch_is == 1) {
            //calculate occured overtime
            $overtimeHour = round(DB::table('attendance_list')->where(['business_id' => Session::get('business_id'), 'emp_id' => $Emp])->whereMonth('punch_date', $m)->sum('overtime') / 60, 2);
            $maxOT = round(($otRule->max_ot_hr * 60 + $otRule->max_ot_min) / 60, 2);
            //overtime %
            $otPercentage = round(($overtimeHour / $maxOT) * 100, 2);
        }

        // calculate total working hour
        $timeArray = explode(":", $present->total_working_hours ?? '00:00:00');
        $totalWorkingHour = round((($timeArray[0] * 60) + $timeArray[1]) / 60, 2);

        //calculate gross hour
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);

        if ($empDetails->assign_shift_type == 3) {
            $totalShiftWork = ($shift->shift_hr * 60 + $shift->shift_min) / 60;
        } else {
            $totalShiftWork = ($shift->work_hr * 60 + $shift->work_min) / 60;
        }
        $grossMonthlyHour = ($daysInMonth - $offDayCount) * $totalShiftWork;

        // working hour %
        $totalWorkingHourPercentage = $totalWorkingHour <= 0 ? 0 : round(($totalWorkingHour / $grossMonthlyHour) * 100, 2);

        //remaining work hour
        $remaining = $grossMonthlyHour - $totalWorkingHour;

        // dd($grossMonthlyHour);

        //remaining %
        $remainingPercentage = $remaining <= 0 ? 0 : round(($remaining / $grossMonthlyHour) * 100, 2);




        $response = [
            $grossMonthlyHour,
            $totalWorkingHour,
            $totalWorkingHourPercentage,
            $maxOT ?? 0,
            $overtimeHour ?? 0,
            $otPercentage ?? 0,
            $remaining,
            $remainingPercentage
        ];

        return $response;
    }

    static function attendanceCount($Emp, $y, $m)
    {

        // $getCount = DB::table('attendance_monthly_count')->where(['business_id',Session::get('business_id')])->where([
        //     'emp_id'=> $Emp,
        //     'month'=>$m,
        //     'year'=> $y,
        // ])->first();



        $totalTwhMin = 0;
        $totalOTMin = 0;
        $totalLateTime = 0;
        $totalEarlyExitTime = 0;
        $day = 0;
        $statusCounts = [
            0 => 0,
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
            12 => 0,
            // EarlyExit
        ];

        $totalDayInMonth = ($m == date('m') ? date('d') : date('t', strtotime('01-' . $m . '-' . $y)));
        while (++$day <= $totalDayInMonth) {
            $date = $y . '-' . $m . '-' . $day;
            $resCode = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-d', strtotime($date))]);

            $status = $resCode[0];
            $overTime = $resCode[8];
            $twhMin = $resCode[10];
            $lateby = $resCode[12];
            $earlyExitBy = $resCode[13];
            $occurance = $resCode[14];
            $totalTwhMin += $twhMin;
            $totalOTMin += $overTime;
            if ($status == (3 || 12)) {
                $totalEarlyExitTime += $earlyExitBy;
                $totalLateTime += $lateby;
            }

            $earlyOccurrenceIs = $occurance[0] ?? 0;
            $earlyOccurrence = $occurance[1] ?? 0;
            $earlyOccurrencePenalty = $occurance[2] ?? 0;

            $lateOccurrenceIs = $occurance[3] ?? 0;
            $lateOccurrence = $occurance[4] ?? 0;
            $lateOccurrencePenalty = $occurance[5] ?? 0;

            $statusPrinted = false;


            if ($status == 3 || $status == 12) {
                if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 0) {
                    if ($lateOccurrenceIs == 1) {
                        if ($statusCounts[3] >= $lateOccurrence) {

                            if ($lateOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                            $statusPrinted = true;
                        }
                    } elseif ($lateOccurrenceIs == 2) {

                        if ($totalLateTime >= $lateOccurrence) {
                            if ($lateOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                            $statusPrinted = true;
                        }
                    }

                    if ($earlyOccurrenceIs == 1 && !$statusPrinted) {
                        if ($statusCounts[3] >= $earlyOccurrence) {

                            if ($earlyOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                            $statusPrinted = true;
                        }
                    } elseif ($earlyOccurrenceIs == 2 && !$statusPrinted) {
                        if ($totalEarlyExitTime >= $earlyOccurrence) {
                            if ($earlyOccurrencePenalty == 1) {
                                $statusCounts[8]++;
                            } else {
                                $statusCounts[2]++;
                            }
                            $statusPrinted = true;
                        }
                    }
                } elseif ($status == 12) {
                    $statusCounts[12]++;
                } else {
                    $statusCounts[3]++;
                }
            }
            if (!$statusPrinted) {
                $statusCounts[$status]++; //issue on new account
            }
        }
        return $statusCounts;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //get attendance detail from db only for a single employee for a specific day . (ther is no any calculation)
    static function getEmpAttendanceDetails($empID, $Date)
    {
        return DB::table('attendance_list')->where('emp_id', $empID)->where('punch_date', $Date)
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->select(
                'attendance_list.*',
                'static_attendance_methods.method_name',
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_start_time, '%h:%i %p'), NULL) AS applied_shift_comp_start_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_end_time, '%h:%i %p'), NULL) AS applied_shift_comp_end_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"),
                DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"),
            )
            ->first();
    }

    // All type calculation of Attendance for Dashboard and daily attendance
    static function getDailyCountForDashboardAndDailyList($businessID, $Date)
    {
        $getPreviousDayCount = DB::table('attendance_daily_count')->where('date', date('Y-m-d', strtotime($Date . ' -1 day')))->where('business_id', $businessID)->first();
        $getDailyCount = DB::table('attendance_daily_count')->where('date', $Date)->where('business_id', $businessID)->first();
        $dailyCount = [
            'totalEmp' => $getDailyCount->total_emp ?? ($getPreviousDayCount->total_emp ?? 0),
            'present' => date('d-m-Y') == date('d-m-Y', strtotime($Date)) ? ($getDailyCount->present ?? 0) + ($getDailyCount->mispunch ?? 0) : ($getDailyCount->present ?? 0),
            'absent' => ($getDailyCount->total_emp ?? 0) - (($getDailyCount->present ?? 0) + ($getDailyCount->mispunch ?? 0) + ($getDailyCount->halfday ?? 0) + ($getDailyCount->leave ?? 0)),
            'late' => $getDailyCount->late ?? 0,
            'early' => $getDailyCount->early ?? 0,
            'mispunch' => date('d-m-Y') == date('d-m-Y', strtotime($Date)) ? 0 : ($getDailyCount->mispunch ?? 0),
            'halfday' => ($getDailyCount->halfday ?? 0),
            'overtime' => ($getDailyCount->overtime ?? 0),
            'leave' => ($getDailyCount->leave ?? 0),
        ];
        return $dailyCount;
    }

    // getdashboardcount
    public static function getDashboardCount($businessID, $Date)
    {
        $businessID = Session::get('business_id');
        $today = date('Y-m-d');
        $yesterday = Carbon::yesterday()->toDateString();

        $statuses = [
            'present' => [1, 4, 9, 3],
            'absent' => [2],
            'halfDay' => [8],
            'late' => [3],
            'overtime' => [9],
            'mispunch' => [4],
        ];

        $totalEmp = EmployeePersonalDetail::where('business_id', $businessID)
            ->where('active_emp', '1')
            ->where('active_emp', 1)
            ->pluck('emp_id')
            ->all();

        $late = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('attendance_list.business_id', Session::get('business_id'))->where('attendance_list.punch_date', date('Y-m-d'))->where('attendance_list.today_status', 3)->count();
        $overtime = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('attendance_list.business_id', Session::get('business_id'))->where('attendance_list.punch_date', date('Y-m-d'))->where('attendance_list.today_status', 9)->count();
        $weekoffHolidayData = EmployeePersonalDetail::join('attendance_holiday_list', 'attendance_holiday_list.master_end_method_id', '=', 'employee_personal_details.master_endgame_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('employee_personal_details.business_id', $businessID)
            ->where('attendance_holiday_list.holiday_date', $today)
            ->pluck('employee_personal_details.emp_id')
            ->all();

        $leaveData = RequestLeaveList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id', $businessID)
            ->where('request_leave_list.final_status', '1')
            ->whereDate('request_leave_list.from_date', '<=', now())
            ->whereDate('request_leave_list.to_date', '>=', now())
            ->distinct()
            ->pluck('request_leave_list.emp_id')
            ->all();

        $presentData = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.punch_date', $today)
            ->whereIn('attendance_list.today_status', [1, 4, 9, 3])
            ->pluck('attendance_list.emp_id')
            ->all();

        $halfDay = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.business_id', $businessID)
            ->where('attendance_list.punch_date', $today)
            ->where('attendance_list.today_status', 8)
            ->pluck('attendance_list.emp_id')
            ->all();

        $absentcheck = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.business_id', $businessID)
            ->where('attendance_list.punch_date', $today)
            ->whereIn('attendance_list.today_status', $statuses['absent'])
            ->pluck('attendance_list.emp_id')
            ->all();



        // Merge and get unique emp_ids
        $allEmpIds = array_unique(array_merge($weekoffHolidayData, $leaveData, $presentData, $halfDay, $absentcheck));

        // Find employees in $totalEmp who are not in $allEmpIds
        $employeesNotInData = array_diff($totalEmp, $allEmpIds);
        $dailyCount['halfday'] = $dailyCount['halfDay'] ?? 0;

        $dailyCount = [
            'totalEmp' => count($totalEmp),
            'present' => count($presentData),
            'absent' => count($employeesNotInData),
            'halfday' => count($halfDay),
            'late' => $late,
            'overtime' => $overtime,
            'mispunch' => 0,
            'leave' => count($leaveData),
        ];

        return $dailyCount;
    }

    // thinks to do count
    public static function getThinksToDoCount($businessID)
    {
        $BID = (!empty($businessID)) ? $businessID : Session::get('business_id');

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::now()->day;

        $manageAttendance = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.business_id',  $BID)
            ->whereMonth('attendance_list.punch_date', '=', $currentMonth)
            ->whereYear('attendance_list.punch_date', '=', $currentYear)
            ->whereDate('attendance_list.punch_date', '<>', Carbon::today())
            ->where('attendance_list.final_status', 0)
            ->select('attendance_list.punch_date')
            ->distinct('attendance_list.punch_date')
            ->count();
        $manageMispunch = RequestMispunchList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_mispunch_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_mispunch_list.business_id',  $BID)
            ->where('request_mispunch_list.final_status', 0)
            ->whereMonth('request_mispunch_list.created_at', '=', $currentMonth)
            ->whereYear('request_mispunch_list.created_at', '=', $currentYear)
            ->select('request_mispunch_list.emp_miss_date')
            ->distinct('request_mispunch_list.emp_miss_date')
            ->get(); // Add get() to execute the query

        $attendanceMispunch = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.business_id',  $BID)
            ->where('today_status', 4)
            ->whereMonth('attendance_list.punch_date', '=', $currentMonth)
            ->whereYear('attendance_list.punch_date', '=', $currentYear)
            ->whereDate('attendance_list.punch_date', '<>', Carbon::today())
            ->select('attendance_list.punch_date')
            ->distinct('attendance_list.punch_date')
            ->get(); // Add get() to execute the query

        $mergedDistinctDates = $manageMispunch->union($attendanceMispunch)->pluck('emp_miss_date')->count();

        $manageLeaves = RequestLeaveList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id',  $BID)
            ->where('request_leave_list.final_status', 0)
            ->whereMonth('request_leave_list.apply_date', '=', $currentMonth)
            ->whereYear('request_leave_list.apply_date', '=', $currentYear)
            ->select('request_leave_list.apply_date')
            ->distinct('request_leave_list.apply_date')
            ->count();
        // dd($manageLeaves);
        if ($manageAttendance != null || $mergedDistinctDates != null || $manageLeaves != null) {
            return [$manageAttendance, $mergedDistinctDates, $manageLeaves];
        } else {
            return [0, 0, 0];
        }
    }

    // get Monthly count from Database
    static function getMonthlyCountFromDB($empID, $year, $month, $BusinessID)
    {
        $getCount = AttendanceMonthlyCount::where(['emp_id' => $empID, 'year' => $year, 'month' => $month, 'business_id' => $BusinessID])->first();


        $setCount = [
            'present' => ($getCount->present ?? 0),
            'absent' => ($getCount->absent ?? 0) < 0 ? 0 : ($getCount->absent ?? 0),
            'mispunch' => $getCount->mispunch ?? 0,
            'late' => $getCount->late ?? 0,
            'early' => $getCount->early_exit ?? 0,
            'halfday' => $getCount->half_day ?? 0,
            'overtime' => $getCount->overtime ?? 0,
            'leave' => $getCount->leave ?? 0,
            'weekoff' => $getCount->week_off ?? 0,
            'holiday' => $getCount->holiday ?? 0,
            'total' => ($getCount->present ?? 0) + (($getCount->half_day ?? 0) != 0 ? $getCount->half_day / 2 : 0)
        ];

        // dd($setCount);

        return $setCount ?? [];
    }
    // Attendance Calculation of Indivisual Employee for a single day
    static function getEmpAttSumm($Emp)
    {

        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $Emp['emp_id'])
            ->select('emp_date_of_joining', 'master_endgame_id', 'emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();

        $shift_policy = $employee->shift_settings_ids_list;
        $leave_policy = $employee->leave_policy_ids_list;


        $attendanceList = DB::table('attendance_list')->where('business_id', Session::get('business_id'))->where($Emp)->first();
        $Status = $attendanceList->today_status ?? 2;


        $shiftStart = $attendanceList->applied_shift_comp_start_time ?? false;
        $shiftEnd = $attendanceList->applied_shift_comp_end_time ?? false;

        if (!isset($attendanceList) && $employee->method_switch == 1) {
            $leaveList = DB::table('request_leave_list')->where('business_id', Session::get('business_id'))->where('emp_id', $Emp['emp_id'])->whereDate('from_date', '<=', $Emp['punch_date'])
                ->whereDate('to_date', '>=', $Emp['punch_date'])->where('final_status', 1)->first();
            if (isset($leaveList)) {
                $Status = 10;
            } else {

                // $isTodayHoliday = PolicyHolidayDetail::where(['business_id' => Session::get('business_id'), 'holiday_date' => $Emp['punch_date'], 'template_id' => $holiday_policy,])->first();
                $holidays = DB::table('attendance_holiday_list')->where('business_id', Session::get('business_id'))->where('master_end_method_id', $employee->master_endgame_id)->where('holiday_date', $Emp['punch_date'])->first();


                if ($holidays != null) {
                    $holiday_type = $holidays->holiday_type_id;
                    $holiday_name = $holidays->name;
                    $holiday_day = $holidays->day;
                    $holiday_date = $holidays->holiday_date;

                    // dd($holiday_type, $holiday_name, $holiday_day, $holiday_date);

                    if ($holiday_type == 1) {
                        $Status = 6;
                    } else if ($holiday_type == 2) {
                        $Status = 7;
                    } else {
                        $Status = 2;
                    }
                } else {
                    $Status = 2;
                }
            }
        }
        $timeDuration = $attendanceList->total_working_hour ?? 0;
        $punchInObj = Carbon::parse($attendanceList->punch_in_time ?? 0);
        $punchOutObj = Carbon::parse($attendanceList->punch_out_time ?? 0);
        $totalWorkingMinutes = $punchOutObj->diff($punchInObj);
        $twhMin = $totalWorkingMinutes->h * 60 + $totalWorkingMinutes->i;


        if ($employee->emp_date_of_joining > $Emp['punch_date']) {
            $Status = 5;
        }
        return [
            ($Status ?? 2) == 4 ? (date('d-m-Y') == date('d-m-Y', strtotime($Emp['punch_date'])) ? 1 : 4) : ($Status ?? 2),
            //day status present, absent etc.
            $attendanceList->punch_in_time ?? 0,
            // punch in time
            $attendanceList->punch_out_time ?? 0,
            // punch out time
            $attendanceList->total_working_hour ?? 0,
            // total working hour
            $attendanceList->punch_in_address ?? '',
            //punch in location
            $attendanceList->punch_out_address ?? '',
            // punch out location
            $attendanceList->applied_shift_template_name ?? '',
            // shift name
            $attendanceList->brack_time ?? 0,
            // break time
            $attendanceList->overtime ?? 0,
            // overtime
            $attendanceList->shift_interval ?? 0,
            //shift working hour
            $twhMin ?? 0,
            // total working hour minutes
            480,
            // maximum overtime for a single month
            $attendanceList->late_by ?? 0,
            //late by
            $attendanceList->early_exit ?? 0,
            // early exit by
            [0, 0, 0, 0, 0, 0],
            // occurances for late and early rule
            10,
            //shift start time with grace time
            10,
            //shift endd time with grace time
            $attendanceList->punch_in_selfie ?? '',
            // punch in selfie
            $attendanceList->punch_out_selfie ?? '',
            //punch out selfie
            2,
            //remaining leave
            [0, 0, 0, 0, 0, 0],
            $shiftStart,
            $shiftEnd
        ];
    }
    // Active attendance calculation for api
    static function getEmpAttSummaryApi($Emp)
    {


        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', $Emp['business_id'])
            ->where('employee_personal_details.emp_id', $Emp['emp_id'])
            ->select('emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom', 'master_endgame_id')
            ->first();

        // dd($employee->shift_settings_ids_list);
        $holiday_policy = $employee->holiday_policy_ids_list;
        $weekly_policy = $employee->weekly_policy_ids_list;
        $shift_policy = json_decode($employee->shift_settings_ids_list ?? 0, true);
        $leave_policy = $employee->leave_policy_ids_list;



        if ($employee !== null && ($employee->method_switch ?? 0) == 1) {

            $attendanceList = DB::table('attendance_list')->where($Emp)->first();
            // dd($attendanceList);

            $shift_type_found = false;
            foreach ($shift_policy as $policy) {
                if ($policy == $employee->emp_shift_type) {
                    $shift_type_found = true;
                    break; // No need to continue checking if we found a match
                }
            }

            if ($shift_type_found) {

                $shiftType = PolicyAttendanceShiftSetting::where([
                    'business_id' => $Emp['business_id'],
                    'id' => $employee->emp_shift_type,
                ])->first();

                // if ($shiftType != null && ($shiftType->shift_type ?? false) && $shiftType->shift_type == 2) {
                //     $shift = PolicyAttendanceShiftTypeItem::where(['business_id' => $Emp['business_id'], 'id' => $attendanceList->attendance_shift ?? 0,])->first();
                // }else{
                //     $shift = PolicyAttendanceShiftTypeItem::where(['business_id' => $Emp['business_id'], 'attendance_shift_id' => $employee->emp_shift_type])->first();
                // }

                $empDetails = DB::table('employee_personal_details')->where(['business_id' => $Emp['business_id'], 'emp_id' => $Emp['emp_id']])->first();
                $shift = $empDetails->assign_shift_type == 2 && $empDetails->assign_shift_type != 0 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();
                // dd($shift);
            } else {
                return [5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $leavesPolicyItems = DB::table('policy_setting_leave_category')->where(['business_id' => $Emp['business_id'], 'leave_policy_id' => $leave_policy])->get();
            $leaveRequestList = DB::table('request_leave_list')->where(['business_id' => $Emp['business_id'], 'emp_id' => $Emp['emp_id'], 'final_status' => 1,])->whereMonth('from_date', date('m'))->get();


            $lateEntry = PolicyAttenRuleLateEntry::where('business_id', $Emp['business_id'])->first();
            $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', $Emp['business_id'])->first();
            $overtimeRule = PolicyAttenRuleOvertime::where('business_id', $Emp['business_id'])->first();
            $isTodayHoliday = PolicyHolidayDetail::where(['business_id' => $Emp['business_id'], 'holiday_date' => $Emp['punch_date'], 'template_id' => $holiday_policy,])->first();




            $attendanceStatus = $attendanceList->emp_today_current_status ?? 0;
            $dayName = date('N', strtotime($Emp['punch_date']));
            $inTime = Carbon::parse($attendanceList->punch_in_time ?? 0)->format('H:i:s') !== '00:00:00' ? $attendanceList->punch_in_time : 0;
            $outTime = Carbon::parse($attendanceList->punch_out_time ?? 0)->format('H:i:s') !== '00:00:00' ? $attendanceList->punch_out_time : 0;
            $shiftStart = $shift->shift_start ?? 0;
            $shiftEnd = $shift->shift_end ?? 0;
            $entryGracetime = ($lateEntry->grace_time_hr ?? 0) * 60 + ($lateEntry->grace_time_min ?? 0);
            $exitGracetime = ($earlyExit->grace_time_hr ?? 0) * 60 + ($lateEntry->grace_time_min ?? 0);
            $markAbsentIf = ($lateEntry->mark_half_day_hr ?? 0) * 60 + ($earlyExit->mark_half_day_min ?? 0);
            $maxOvertime = ($overtimeRule->max_ot_hr ?? 0) * 60 + ($overtimeRule->max_ot_min ?? 0);
            $punchInLoc = $attendanceList->punch_in_address ?? 'Not Mark';
            $punchOutLoc = $attendanceList->punch_out_address ?? 'Not Mark';
            $in_selfie = $attendanceList->punch_in_selfie ?? '';
            $out_selfie = $attendanceList->punch_out_selfie ?? '';
            $shiftName = $shift->shift_name ?? 'Genral Shift';
            $breakTime = $shift->break_min ?? '00';

            $shiftStartObj = Carbon::parse($shiftStart);
            $shiftEndObj = Carbon::parse($shiftEnd);
            $inTimeObj = Carbon::parse($inTime);
            $outTimeObj = Carbon::parse($outTime);
            $leaveDetail = [];
            $remLeave = 0;

            // dd($inTime,$outTime,$shiftStart,$shiftEnd);

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
            if (($earlyExit->switch_is ?? 0) != null && ($earlyExit->switch_is ?? 0) == 1) {
                if ($earlyExit->occurance_is == 1) {
                    $earlyOccurance = $earlyExit->occurance_count;
                } else {
                    $earlyOccurance = $earlyExit->occurance_hr * 60 + $earlyExit->occurance_min;
                }
            } else {
                $earlyOccurance = 0;
            }

            if (($lateEntry->switch_is ?? 0) != null && ($lateEntry->switch_is ?? 0) == 1) {
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

            // dd($shiftInterval);
            // Calculate total minutes for punchInterval and shiftInterval for overtime
            $punchIntervalMinutes = $punchInterval->h * 60 + $punchInterval->i;
            $shiftIntervalMinutes = $shiftInterval->h * 60 + $shiftInterval->i;
            $overtime = ($shiftIntervalMinutes != 0) ? $punchIntervalMinutes - $shiftIntervalMinutes : 0;
            // dd($punchIntervalMinutes,$shiftIntervalMinutes,$overtime);
            $overtimeValue = $overtime > 0 ? $overtime : 0;

            // calculate overtime if overtime rule is active
            // Calculate Overtime based on Overtime Rule
            if (($overtimeRule->switch_is ?? 0) == 1 && $overtimeValue > 0) {
                $earlyCommingTime = $shiftStartObj->subMinutes($overtimeRule->early_ot_hr * 60 + $overtimeRule->early_ot_min);
                $lateGoingTime = $shiftEndObj->addMinutes($overtimeRule->late_ot_hr * 60 + $overtimeRule->late_ot_min);

                $earlyIn = $earlyCommingTime->isAfter($inTimeObj) ? $earlyCommingTime : $inTimeObj;
                $lateGoing = $outTimeObj->isAfter($lateGoingTime) ? $lateGoingTime : $outTimeObj;

                $totalWork = $lateGoing->diff($earlyIn);

                $totalShiftInterval = $earlyCommingTime->diff($lateGoingTime);
                $twhIntervalMinutes = $totalShiftInterval->h * 60 + $totalShiftInterval->i - $shiftIntervalMinutes;
                $overtimeValue = min($overtimeValue, max($twhIntervalMinutes, 0));
            }
            // dd($overtimeValue);
            // dd($earlyCommingTime,$lateGoingTime,$earlyIn,$lateGoing);

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
            $earlyExitMin = ($earlyExit->mark_half_day_hr ?? 0) * 60 + ($earlyExit->mark_half_day_min ?? 0);
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



            if (($lateEntry->switch_is ?? 0) != null && ($lateEntry->switch_is ?? 0) == 1 && $inTime > $entryGrace) {
                $lateByObj = $shiftStartObj->diff($inTimeObj);
                $lateBy = $lateByObj->h * 60 + $lateByObj->i;
            }

            if (($earlyExit->switch_is ?? 0) != null && ($earlyExit->switch_is ?? 0) == 1 && $outTime < $exitGrace && $inTime && $outTime) {
                if (Carbon::parse($outTime)->format('H:i:s') !== '00:00:00') {
                    $earlyExitByObj = $shiftEndObj->diff($outTimeObj);
                    $earlyExitBy = $earlyExitByObj->h * 60 + $earlyExitByObj->i;
                } else {
                    $earlyExitBy = 0;
                }
            }

            // dd($lateBy,$earlyExitBy);

            $status = 2;

            if (isset($attendanceList)) {
                if ($attendanceStatus >= 1) {
                    if ($attendanceStatus >= 2) {
                        if ($twhMin >= $shiftIntervalMinutes / 2) {
                            if (($lateEntry->switch_is ?? 0) != null && ($lateEntry->switch_is ?? 0) == 1 && $inTime > $entryGrace) {
                                if ($markAbsentIf > 0 && $inTime > $absentHalfTime) {
                                    $status = 8;
                                } else {
                                    $status = 3;
                                }
                            } elseif (($earlyExit->switch_is ?? 0) != null && ($earlyExit->switch_is ?? 0) == 1 && $outTime < $exitGrace) {
                                if ($earlyExitMin > 0 && $outTime < $EarlyExitTime) {
                                    $status = 8;
                                } else {
                                    $status = 12;
                                }
                            } else {
                                if ($punchIntervalMinutes > $shiftIntervalMinutes) {
                                    $status = 9;
                                } else {
                                    $status = 1;
                                }
                            }
                        } else {
                            $status = 2;
                        }
                    } else {
                        if (date('Y-m-d', strtotime($Emp['punch_date'])) === date('Y-m-d')) {
                            $status = 1;
                        } else {
                            $status = 4;
                        }
                    }
                }
            } else {

                $leaveList = DB::table('request_leave_list')->where('business_id', Session::get('business_id'))->where('emp_id', $Emp['emp_id'])->whereDate('from_date', '<=', $Emp['punch_date'])
                    ->whereDate('to_date', '>=', $Emp['punch_date'])->where('final_status', 1)->first();
                if (isset($leaveList)) {
                    $Status = 10;
                } else {
                    $holidays = DB::table('attendance_holiday_list')->where('business_id', Session::get('business_id'))->where('master_end_method_id', $employee->master_endgame_id)->where('holiday_date', $Emp['punch_date'])->first();


                    if ($holidays != null) {
                        $holiday_type = $holidays->holiday_type_id;
                        $holiday_name = $holidays->name;
                        $holiday_day = $holidays->day;
                        $holiday_date = $holidays->holiday_date;

                        if ($holiday_type == 1) {
                            $Status = 6;
                        } else if ($holiday_type == 2) {
                            $Status = 7;
                        } else {
                            $Status = 2;
                        }
                    } else {
                        $Status = 2;
                    }
                }
            }


            $countData = AttendanceMonthlyCount::where([
                'business_id' => $Emp['business_id'],
                'emp_id' => $Emp['emp_id'],
                'year' => date('Y', strtotime($Emp['punch_date'])),
                'month' => date('m', strtotime($Emp['punch_date']))
            ])->first();

            if (!$countData) {
                Central_unit::MyCountForMonth($Emp['emp_id'], date('Y-m-d', strtotime($Emp['punch_date'])), $Emp['business_id']);
            }

            if ($countData) {
                $attendanceData = AttendanceList::where('emp_id', $Emp['emp_id'])
                    ->where('business_id', $Emp['business_id'])
                    ->whereMonth('punch_date', date('m'))
                    ->get();

                $lateCount = $countData->late;
                $earlyCount = $countData->early_exit;

                $lateSum = $attendanceData->sum('late_by');
                $earlySum = $attendanceData->sum('early_exit');

                $earlyOccurrenceIs = $ruleCount[0] ?? 0;
                $earlyOccurrence = $ruleCount[1] ?? 0;
                $earlyOccurrencePenalty = $ruleCount[2] ?? 0;

                $lateOccurrenceIs = $ruleCount[3] ?? 0;
                $lateOccurrence = $ruleCount[4] ?? 0;
                $lateOccurrencePenalty = $ruleCount[5] ?? 0;

                $statusPrinted = false;

                if (in_array($status, [3, 12])) {
                    if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 0) {
                        if (($lateOccurrenceIs == 1 && $lateCount >= $lateOccurrence) || ($lateOccurrenceIs == 2 && $lateSum >= $lateOccurrence)) {
                            $status = ($lateOccurrencePenalty == 1) ? 8 : 2;
                            $statusPrinted = true;
                        }

                        if ($earlyOccurrenceIs == 1 && !$statusPrinted && $earlyCount >= $earlyOccurrence || ($earlyOccurrenceIs == 2 && !$statusPrinted && $earlySum >= $earlyOccurrence)) {
                            $status = ($earlyOccurrencePenalty == 1) ? 8 : 2;
                            $statusPrinted = true;
                        }
                    } elseif ($status == 12) {
                        $status = 12;
                    } else {
                        $status = 3;
                    }
                }
            }



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

    // mark absent/halfday if mispunch date is over from rule
    static function misPunchRuleFunction($BusinessID, $Date)
    {
        $mispunchRole = DB::table('policy_atten_rule_misspunch')->where('business_id', $BusinessID)->first();
        $mispunchSwitch = ($mispunchRole->switch_is ?? 0);
        $maxDayForRequest = ($mispunchRole->request_day ?? 0);
        $ifNotRequestedThen = ($mispunchRole->request_day_absent_is ?? 0);
        $currentDate = Carbon::parse($Date);
        $ruleDaysAgo = $currentDate->subDays($maxDayForRequest);

        $attendanceList = DB::table('attendance_list')->where('today_status', 4)->where('punch_date', '<=', $ruleDaysAgo)->where('business_id', $BusinessID)->get();
        foreach ($attendanceList as $attendance) {
            $Emp = DB::table('employee_personal_details')->where(['emp_id' => $attendance->emp_id])->first();
            // if (($Emp->active_emp ?? 0) != 1) {
            //     continue;
            // }
            $misPunchRequests = DB::table('request_mispunch_list')->where('emp_id', $attendance->emp_id)->where('emp_miss_date', date('Y-m-d', strtotime($attendance->punch_date)))->where('business_id', $BusinessID)->first();
            $empMonthCount = DB::table('attendance_monthly_count')->where('emp_id', $attendance->emp_id)->where('year', date('Y', strtotime($attendance->punch_date)))->where('month', date('m', strtotime($attendance->punch_date)))->where('business_id', $BusinessID)->first();

            if (!isset($empMonthCount)) {
                $countData = AttendanceMonthlyCount::create([
                    'business_id' => $BusinessID,
                    'emp_id' => $attendance->emp_id,
                    'month' => date('m', strtotime($attendance->punch_date)),
                    'year' => date('Y', strtotime($attendance->punch_date)),
                    'present' => 0,
                    'absent' => 0,
                    'late' => 0,
                    'early_exit' => 0,
                    'mispunch' => 0,
                    'holiday' => 0,
                    'week_off' => 0,
                    'half_day' => 0,
                    'overtime' => 0,
                    'leave' => 0,
                ]);

                $countData->save();
            }
            $employeeOtherDetails = self::getIndivisualEmployeeDetails($attendance->emp_id);
            $EmpShiftStart = Carbon::parse($employeeOtherDetails->shift_start ?? '');
            $EmpShiftEnd = Carbon::parse($employeeOtherDetails->shift_end ?? '');
            $shoftWorkingHour = $EmpShiftStart->diff($EmpShiftEnd);
            $halfShiftMin = ($shoftWorkingHour->h * 60 + $shoftWorkingHour->i) / 2;
            $punchInTime = Carbon::parse($attendance->punch_in_time);
            $punchOutTime = $punchInTime->copy()->addMinutes($halfShiftMin);
            $workingHourObj = $punchInTime->diff($punchOutTime);
            $workingHour = sprintf('%02d:%02d:%02d', $workingHourObj->h, $workingHourObj->i, $workingHourObj->s);
            // dd($workingHour);

            if (!isset($misPunchRequests)) {

                if ($ifNotRequestedThen == 1) {

                    DB::table('attendance_list')->where('id', $attendance->id)->update([
                        'today_status' => 8,
                        'punch_out_time' => $punchOutTime,
                        'total_working_hour' => $workingHour,
                        'emp_today_current_status' => 2,
                    ]);

                    DB::table('attendance_monthly_count')->where('id', $empMonthCount->id)->update([
                        'half_day' => $empMonthCount->half_day + 1,
                        'mispunch' => $empMonthCount->mispunch >= 0 ? $empMonthCount->mispunch - 1 : 0,
                    ]);
                }

                if ($ifNotRequestedThen == 2) {

                    DB::table('attendance_list')->where('id', $attendance->id)->update(['today_status' => 2]);

                    DB::table('attendance_monthly_count')->where('id', $empMonthCount->id)->update([
                        'absent' => $empMonthCount->half_day + 1,
                        'mispunch' => $empMonthCount->mispunch >= 0 ? $empMonthCount->mispunch - 1 : 0,
                    ]);
                    // dd('2');
                }
                // dd('Updated');
                self::MyCountForDaily(date('Y-m-d'), Session::get('business_id'));
            }
        }
        // dd(isset($misPunchRequests));
        return 0;
    }



    // get employees month detailsfilter
    static function employeeAttendanceFiterForMonth($Emp)
    {
        $i = 0;
        $month = $Emp['month'];
        $year = $Emp['year'];
        $EmpID = $Emp['emp_id'];
        $AllData = [];

        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $EmpID)
            ->select('emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();

        $holiday_policy = json_decode($employee->holiday_policy_ids_list ?? 0, true);
        $weekly_policy = json_decode($employee->weekly_policy_ids_list ?? 0, true);
        $leave_policy = json_decode($employee->leave_policy_ids_list ?? 0, true);


        if ($employee !== null && ($employee->method_switch ?? 0) == 1) {

            $attendanceList = DB::table('attendance_list')
                ->where('business_id', Session::get('business_id'))
                ->where('emp_id', $EmpID)
                ->whereMonth('punch_date', $month)
                ->whereYear('punch_date', $year)
                ->get();


            $leaveRequestList = DB::table('request_leave_list')
                ->where([
                    'business_id' => Session::get('business_id'),
                    'emp_id' => $EmpID,
                    'final_status' => 1,
                ])
                ->whereMonth('from_date', $month)
                ->get();


            $Holiday = PolicyHolidayDetail::where([
                'business_id' => Session::get('business_id'),
                'template_id' => $holiday_policy,
            ])->whereMonth('holiday_date', $month)
                ->whereYear('holiday_date', $year)
                ->get();

            $weekoffDate = self::getWeekOffDate($weekly_policy, $month, $year);



            // dd($weekoffDate);


            foreach ($attendanceList as $key => $AList) {
                // dd($AList->punch_date);
                $AllData[$i++] = [
                    'date' => $AList->punch_date,
                    'dayName' => date('l', strtotime($AList->punch_date)),
                    'status' => $AList->today_status,
                    'in' => $AList->punch_in_time,
                    'out' => $AList->punch_out_time,
                    'workingHour' => $AList->total_working_hour,
                    'overtime' => $AList->overtime,
                    'late' => $AList->late_by,
                    'early' => $AList->early_exit,
                    'isLeave' => 0,
                    'leaveID' => 0,
                    'leaveType' => 0,
                    'shift' => 0,
                    'isHoliday' => 0,
                    'holiday' => '',
                    'isWeekOff' => 0,

                ];
            }
            foreach ($leaveRequestList as $key => $LList) {
                $fromDate = $LList->from_date;
                $to = $LList->to_date;
                $diff = $LList->days;
                $start = 0;
                // dd($LList);

                while ($start <= $diff) {
                    // dd($LList);
                    $AllData[$i++] = [
                        'date' => date('Y-m-d', strtotime($fromDate . ' +' . $start . ' day')),
                        'dayName' => date('l', strtotime($fromDate . ' +' . $start . ' day')),
                        'status' => 10,
                        'in' => 0,
                        'out' => 0,
                        'workingHour' => 0,
                        'overtime' => 0,
                        'late' => 0,
                        'early' => 0,
                        'isLeave' => 1,
                        'leaveID' => $LList->leave_category,
                        'leaveType' => $LList->leave_type,
                        'shift' => $LList->shift_type,
                        'isHoliday' => 0,
                        'holiday' => '',
                        'isWeekOff' => 0,
                    ];
                    $start++;
                }
            }
            foreach ($Holiday as $key => $holi) {
                // dd($holi);
                $AllData[$i++] = [
                    'date' => $holi->holiday_date,
                    'dayName' => date('l', strtotime($holi->holiday_date)),
                    'status' => 6,
                    'in' => 0,
                    'out' => 0,
                    'workingHour' => 0,
                    'overtime' => 0,
                    'late' => 0,
                    'early' => 0,
                    'isLeave' => 0,
                    'leaveID' => 0,
                    'leaveType' => 0,
                    'shift' => 0,
                    'isHoliday' => 1,
                    'holiday' => $holi->holiday_name,
                    'isWeekOff' => 0,
                ];
            }
            foreach ($weekoffDate as $key => $week) {
                // dd($holi);
                $AllData[$i++] = [
                    'date' => $week,
                    'dayName' => date('l', strtotime($week)),
                    'status' => 7,
                    'in' => 0,
                    'out' => 0,
                    'workingHour' => 0,
                    'overtime' => 0,
                    'late' => 0,
                    'early' => 0,
                    'isLeave' => 0,
                    'leaveID' => 0,
                    'leaveType' => 0,
                    'shift' => 0,
                    'isHoliday' => 0,
                    'holiday' => '',
                    'isWeekOff' => 1,
                ];
            }

            $day = 1; // Start from the first day of the month
            while ($day <= date('t', strtotime($year . '-' . $month . '-01'))) {
                $found = false;
                foreach ($AllData as $data) {
                    $date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
                    $date1 = date('Y-m-d', strtotime($data['date']));
                    if ($date === $date1) {
                        $found = true;
                        break; // Exit the loop if a match is found
                    }
                }

                if (!$found) {
                    $AllData[] = [
                        'date' => $date,
                        'dayName' => date('l', strtotime($date)),
                        'status' => 2,
                        'in' => 0,
                        'out' => 0,
                        'workingHour' => 0,
                        'overtime' => 0,
                        'late' => 0,
                        'early' => 0,
                        'isLeave' => 0,
                        'leaveID' => 0,
                        'leaveType' => 0,
                        'shift' => 0,
                        'isHoliday' => 0,
                        'holiday' => '',
                        'isWeekOff' => 0,
                    ];
                }

                $day++; // Increment day after processing
            }
        }


        return $AllData;
    }

    // get week off day
    static function getWeekOffDate($weeklyPolicy, $month, $year)
    {
        $weekOffDates = [];

        // foreach ($weeklyPolicy as $key => $wPolicy) {
        $weekOff = DB::table('policy_weekly_holiday_list')
            ->where([
                'business_id' => Session::get('business_id'),
                'id' => $weeklyPolicy,
            ])->first();

        if ($weekOff != null) {
            foreach (json_decode($weekOff->days) as $day) {
                $WeekDay = date('N', strtotime($day));
                $totalDayinMonth = date('t', strtotime($year . '-' . $month . '-01'));
                $startDay = 0;

                while (++$startDay <= $totalDayinMonth) {
                    $NDay = date('N', strtotime(Carbon::parse($year . '-' . $month . '-' . $startDay)->toDateString()));
                    if ($NDay == $WeekDay) {
                        $weekOffDates[] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $startDay));
                    }
                }
            }
        }
        // }

        return $weekOffDates;
    }


    static function calculateLeaveCountApi($EmpID, $LeaveCategory, $month, $year)
    {

        $leaveData = [
            'opening' => '0',
            'alloted' => '0',
            'used' => '0',
            'remaining' => '0',
        ];
        $Data = self::leaveBalanceList($EmpID);
        // dd($Data);
        foreach ($Data as $key => $value1) {

            if ($value1['policy_type_id'] == $LeaveCategory) {
                $leaveData['opening'] = $value1['leave_opening'] == 0 ? '0' : $value1['leave_opening'];
                $leaveData['alloted'] = $value1['leave_allotted'] == 0 ? '0' : $value1['leave_allotted'];
                $leaveData['used'] = $value1['leave_taken'] == 0 ? '0' : $value1['leave_taken'];
                $leaveData['remaining'] = $value1['leave_remaining'] == 0 ? '0' : $value1['leave_remaining'];
            }
        }


        return $leaveData;
    }
    static function leaveBalanceList($empId)
    {

        $business = Session::get('business_id');
        $emp = EmployeePersonalDetail::where('emp_id', $empId)
            ->where('business_id', $business)
            ->first();

        if ($emp != null) {
            $getData = PolicySettingLeavePolicy::where('policy_setting_leave_policy.business_id', $business)
                ->leftJoin('policy_master_endgame_method', 'policy_setting_leave_policy.id', '=', 'policy_master_endgame_method.leave_policy_ids_list')
                ->where('policy_master_endgame_method.method_switch', 1)
                ->where('policy_setting_leave_policy.business_id', $business)
                ->select('policy_setting_leave_policy.*')
                ->first();

            if ($getData != null) {
                $Item = PolicySettingLeaveCategory::where('business_id', $business)
                    ->leftJoin('static_leave_category', 'policy_setting_leave_category.category_name', '=', 'static_leave_category.id')
                    ->leftJoin('static_leave_category_applicable_to', 'policy_setting_leave_category.applicable_to', '=', 'static_leave_category_applicable_to.id')
                    ->where('leave_policy_id', $getData->id)
                    ->select('policy_setting_leave_category.*', 'static_leave_category.name as apply_category_name', 'static_leave_category_applicable_to.name as applicable_name')
                    ->get();

                $applyLeaveRequests = RequestLeaveList::where('business_id', $business)
                    ->where('emp_id', $empId)
                    ->get();

                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $LoadPolicyCase = [];
                $StoreModel = [];
                foreach ($Item as $key => $requests) {
                    $DOJ = Carbon::parse($emp->emp_date_of_joining);

                    // Calculate the start and end dates for the previous year
                    $previousYearStart = Carbon::now()
                        ->subYear()
                        ->startOfYear();
                    $previousYearEnd = Carbon::now()
                        ->subYear()
                        ->endOfYear();

                    // previous mode
                    $previousLeaveTaken = $applyLeaveRequests
                        ->where('leave_category', $requests->category_name)
                        ->filter(function ($request) use ($previousYearStart, $previousYearEnd) {
                            $requestDate = Carbon::parse($request->from_date);
                            return $requestDate->between($previousYearStart, $previousYearEnd);
                        })
                        ->sum('days');

                    // sensitive
                    $cycleLimitFrom = Carbon::parse($getData->temp_from);
                    $cycleLimitTo = Carbon::parse($getData->temp_to);

                    $monthsCount = 0;
                    $leaveAllotted = 0;
                    $leaveTaken = 0;
                    $leaveRemaining = 0;
                    $lwpDays = 0;

                    for ($date = $cycleLimitFrom; $date->lessThanOrEqualTo($cycleLimitTo); $date->addMonth()) {
                        $month = $date->month;
                        $year = $date->year;

                        if ($year < $currentYear || ($year === $currentYear && $month <= $currentMonth)) {
                            $monthsCount++;
                            // current mode request list
                            $leaveTaken = $applyLeaveRequests
                                ->where('leave_category', $requests->category_name)
                                ->filter(function ($request) use ($currentMonth, $DOJ) {
                                    $requestDate = Carbon::parse($request->from_date);
                                    // start doj year only and accept in status only request and accept status
                                    return $requestDate->month === $currentMonth && $requestDate->year >= $DOJ->year && ($request->final_status === 0 || $request->final_status === 1);
                                })
                                ->sum('days');

                            $leaveAllotted += $requests->days;

                            // Unused Leave Rule Set Show Restriction
                            $ruleType = $requests->unused_leave_rule;
                            if ($ruleType === 2) {
                                $openingBalance = $leaveAllotted - $previousLeaveTaken;
                                $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining];
                                // Apply carry forward limit logic to the opening balance
                            }
                            if ($ruleType === 1) {
                                // Lapse set logic (if needed)
                                $openingBalance = 0;
                                $leaveRemaining = $leaveAllotted - $leaveTaken;
                                $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining];
                            }
                            // Gender Restriction with category Show Hide
                            if (($emp->emp_gender === 1 || $emp->emp_gender === 3) && $requests->category_name === 4) {
                                //Restriction Paternity leave (PL)
                                continue; // Skip if the employee is male and the category is not maternity
                            }
                            if ($emp->emp_gender === 2 && $requests->category_name === 5) {
                                //Restriction Maternity leave (ML)
                                continue; // Skip if the employee is female and the category is not paternity
                            }

                            // 'information' => $Item->where('category_name', $requests->category_name)->first(),
                            $LoadPolicyCase[$key] = [
                                'current_month' => $monthsCount,
                                'leave_policy_id' => $requests->leave_policy_id,
                                'business_id' => $requests->business_id,
                                'policy_type_id' => $requests->category_name, //category_id
                                'policy_category_name' => $requests->apply_category_name, //category_name
                                'policy_monthly_cycle' => $requests->leave_cycle_monthly_yearly,
                                'policy_days' => $requests->days,
                                'policy_unused_leave_rule' => $requests->unused_leave_rule,
                                'policy_carry_forward_limit' => $requests->carry_forward_limit,
                                'policy_applicable_to_gender_id' => $requests->applicable_to, //gender ID
                                'policy_applicable_to_gender_name' => $requests->applicable_name, //gender name
                                'leave_opening' => $StoreModel[0],
                                'leave_allotted' => $StoreModel[1],
                                'leave_taken' => $StoreModel[2],
                                'leave_remaining' => $StoreModel[3],
                            ];
                            // Push the data for this leave type into $LoadPolicyCase
                            // $LoadPolicyCase[] = $leaveTypeData;
                        }
                    }
                }

                // add external Like : LWP or Comp OFF
                $externalData = [
                    [
                        'current_month' => 0,
                        'leave_policy_id' => 0,
                        'business_id' => $requests->business_id,
                        'policy_type_id' => 9, //category_id
                        'policy_category_name' => 'Leave Without Pay (LWP)', //category_name
                        'policy_monthly_cycle' => 0,
                        'policy_days' => 0,
                        'policy_unused_leave_rule' => 0,
                        'policy_carry_forward_limit' => 0,
                        'policy_applicable_to_gender_id' => 0, //gender ID
                        'policy_applicable_to_gender_name' => 0, //gender name
                        'leave_opening' => 0,
                        'leave_allotted' => 0,
                        'leave_taken' => $lwpDays,
                        'leave_remaining' => 0,
                    ],
                    [
                        'current_month' => 0,
                        'leave_policy_id' => 0,
                        'business_id' => $requests->business_id,
                        'policy_type_id' => 8, //category_id
                        'policy_category_name' => 'Comp-Off (CO)', //category_name
                        'policy_monthly_cycle' => 0,
                        'policy_days' => 0,
                        'policy_unused_leave_rule' => 0,
                        'policy_carry_forward_limit' => 0,
                        'policy_applicable_to_gender_id' => 0, //gender ID
                        'policy_applicable_to_gender_name' => 0, //gender name
                        'leave_opening' => 0,
                        'leave_allotted' => 0,
                        'leave_taken' => 0,
                        'leave_remaining' => 0,
                    ],
                    // Add more external data as needed
                ];
                $data = array_merge($LoadPolicyCase, $externalData);
                return $data;
            } else {
                return [];
            }
        }
    }

    //********************************************************************************************************************************************//

}
