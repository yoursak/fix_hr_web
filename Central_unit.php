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
        $totalEmp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('active_emp', '1')->count();
        $present = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('attendance_list.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->where('attendance_list.punch_date', date('Y-m-d'))->whereIn('attendance_list.today_status', [1, 4, 9, 3])->count();
        $LeaveCount = RequestLeaveList::where('business_id', Session::get('business_id'))
            ->where('from_date', date('Y-m-d'))
            ->count();
        $EmpCount = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->where('active_emp' , '1')->count();
        $AttendanceCount = AttendanceList::where(['business_id' => Session::get('business_id'), 'punch_date' => date('Y-m-d')])
            ->count();
        $AbsentCount = $EmpCount - $AttendanceCount;
        $PendingLeave = DB::table('approval_status_list')->where('business_id', Session::get('business_id'))->where('approval_type_id', 2)
            ->where('status', 0)
            ->count();
            // Get the current month and year
            $currentMonth = Carbon::now()->format('m');
            $currentYear = Carbon::now()->format('Y');
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
                ->where('request_leave_list.leave_category',  '9')
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
        $business_id = Session::get('business_id');
        $emp_id = $EmpId;
        $now = DB::table('employee_personal_details')
            ->join('policy_attendance_shift_settings', 'policy_attendance_shift_settings.id', '=', 'employee_personal_details.emp_shift_type')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->select('policy_attendance_shift_settings.shift_type')
            ->first(); // Use first() to retrieve a single row
        $now = (int) $now->shift_type;
        $item = DB::table('employee_personal_details')
            ->where('employee_personal_details.emp_id', $emp_id)
            ->where('employee_personal_details.business_id', $business_id)
            ->select('emp_rotational_shift_type_item')
            ->first();
        $item = (int) $item->emp_rotational_shift_type_item;

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
            ->where('employee_personal_details.business_id', $business_id)
            ->where(function ($query) use ($now, $item) {
                if ($now == 1) {
                    //fix
                    // $query->where('policy_attendance_shift_settings.shift_type', $now);
                    $query->where('attendanceShift.shift_type', $now);
                }
                if ($now == 2) {
                    //rotation
                    $query->where('attendanceShift.shift_type', $now)->where('policy_attendance_shift_type_items.id', $item);
                }
                if ($now == 3) {
                    //open
                    $query->where('attendanceShift.shift_type', $now);
                }
            })
            ->select('employee_personal_details.*', 'employeegender.gender_type as gender', 'policypreference.policy_name', 'mem.method_name', 'mem.method_switch', 'mem.method_name', 'mem.leave_policy_ids_list', 'mem.holiday_policy_ids_list', 'mem.weekly_policy_ids_list', 'mem.shift_settings_ids_list', 'employeetype.emp_type as emp_type_name', 'am1.method_name as attendance_method_name', 'static_attendance_shift_type.name as attendance_shift_name', 'branch_list.branch_name', 'department_list.depart_name', 'designation_list.desig_name', 'policy_attendance_shift_type_items.shift_start', 'policy_attendance_shift_type_items.shift_end')
            ->first();



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
        $data = DB::table('attendance_time_log')->where(['business_id' => Session::get('business_id'), 'emp_id' => $empId, 'punch_date' => $date])->get();
        return $data;
    }

    /// function for get holiday list globally
    static function getHolidayList()
    {
        $Holidays = CalendarController::getHolidays();
        return $Holidays;
    }

    ////////////////////// Start Exact Count //////////////////////
    static function MyCountForDaily($date, $businessID)
    {
        $punchDate = date('Y-m-d', strtotime($date));

        $createDailyCount = 0;
        $updateDailyCount = 0;

        $attendance = DB::table('attendance_list')->where(['business_id' => $businessID, 'punch_date' => $punchDate])->get();

        $overtime = $attendance->where('today_status', 9)->count();
        $absent = $attendance->where('today_status', 2)->count();
        $late = $attendance->where('today_status', 3)->count();
        $early = $attendance->where('today_status', 12)->count();
        $halfday = $attendance->where('today_status', 8)->count();
        $leave1 = $attendance->where('today_status', 10)->count();
        $leave2 = $attendance->where('today_status', 12)->count();
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
                        'leave' => ($leave1 ?? 0) + ($leave2 ?? 0),
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
                'leave' => ($leave1 ?? 0) + ($leave2 ?? 0),
            ]);
        }

        return [$createDailyCount, $updateDailyCount];
    }

    // static function setCountAtOnceForDailyAndMonthly()
    // {

    //     DB::table('attendance_monthly_count')->where('business_id', Session::get('business_id'))->delete();
    //     DB::table('attendance_daily_count')->where('business_id', Session::get('business_id'))->delete();


    //     $attendanceData = DB::table('attendance_list')->where('business_id', Session::get('business_id'))->get();
    //     foreach ($attendanceData as $key => $value) {
    //         $punchDate = $value->punch_date;
    //         $status = $value->today_status;
    //         $EmpID = $value->emp_id;
    //         $businessID = $value->business_id;
    //         // dd($status);
    //         $lateEntry = PolicyAttenRuleLateEntry::where('business_id', $businessID)->first();
    //         $earlyExit = PolicyAttenRuleEarlyExit::where('business_id', $businessID)->first();
    //         $overtimeRule = PolicyAttenRuleOvertime::where('business_id', $businessID)->first();

    //         // occurance in $earlyExit  and $lateEntry
    //         if (($earlyExit->switch_is ?? 0) == 1) {
    //             if (($earlyExit->occurance_is ?? 0) == 1) {
    //                 $earlyOccurance = $earlyExit->occurance_count;
    //             } else {
    //                 $earlyOccurance = $earlyExit->occurance_hr * 60 + $earlyExit->occurance_min;
    //             }
    //         }

    //         if (($lateEntry->switch_is ?? 0) == 1) {
    //             if ($lateEntry->occurance_is == 1) {
    //                 $lateOccurance = $lateEntry->occurance_count;
    //             } else {
    //                 $lateOccurance = $lateEntry->occurance_hr * 60 + $lateEntry->occurance_min;
    //             }
    //             $ruleCount = [
    //                 0 => $earlyExit->occurance_is,
    //                 1 => $earlyOccurance ?? 0,
    //                 2 => $earlyExit->absent_is,
    //                 3 => $lateEntry->occurance_is,
    //                 4 => $lateOccurance,
    //                 5 => $lateEntry->absent_is,
    //             ];
    //         } else {
    //             $ruleCount = [
    //                 0 => 0,
    //                 1 => 0,
    //                 2 => 0,
    //                 3 => 0,
    //                 4 => 0,
    //                 5 => 0,
    //             ];
    //         }

    //         $lateCount = $value->late_by;
    //         $earlyCount = $value->early_exit;

    //         $attendanceData1 = DB::table('attendance_list')->where('emp_id', $EmpID)->get();
    //         $lateSum = $attendanceData1->sum('late_by');
    //         $earlySum = $attendanceData1->sum('early_exit');

    //         $earlyOccurrenceIs = $ruleCount[0] ?? 0;
    //         $earlyOccurrence = $ruleCount[1] ?? 0;
    //         $earlyOccurrencePenalty = $ruleCount[2] ?? 0;

    //         $lateOccurrenceIs = $ruleCount[3] ?? 0;
    //         $lateOccurrence = $ruleCount[4] ?? 0;
    //         $lateOccurrencePenalty = $ruleCount[5] ?? 0;

    //         $statusPrinted = false;

    //         if (in_array($status, [3, 12])) {
    //             if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 0) {
    //                 if (($lateOccurrenceIs == 1 && $lateCount >= $lateOccurrence) || ($lateOccurrenceIs == 2 && $lateSum >= $lateOccurrence)) {
    //                     $status = ($lateOccurrencePenalty == 1) ? 8 : 2;
    //                     $statusPrinted = true;
    //                 }

    //                 if ($earlyOccurrenceIs == 1 && !$statusPrinted && $earlyCount >= $earlyOccurrence || ($earlyOccurrenceIs == 2 && !$statusPrinted && $earlySum >= $earlyOccurrence)) {
    //                     $status = ($earlyOccurrencePenalty == 1) ? 8 : 2;
    //                     $statusPrinted = true;
    //                 }
    //             } elseif ($status == 12) {
    //                 $status = 12;
    //             } else {
    //                 $status = 3;
    //             }
    //         }

    //         $searchCriteria = [
    //             'business_id' => $businessID,
    //             'emp_id' => $EmpID,
    //             'year' => date('Y', strtotime($punchDate)),
    //             'month' => date('m', strtotime($punchDate))
    //         ];

    //         $monthlyCount = DB::table('attendance_monthly_count')->where($searchCriteria)->first();
    //         if (!isset($monthlyCount)) {
    //             $monthlyCountCreate = DB::table('attendance_monthly_count')->insert(
    //                 [
    //                     'business_id' => $businessID,
    //                     'emp_id' => $EmpID,
    //                     'year' => date('Y', strtotime($punchDate)),
    //                     'month' => date('m', strtotime($punchDate)),
    //                     'present' => 0,
    //                     'absent' => 0,
    //                     'late' => 0,
    //                     'early_exit' => 0,
    //                     'mispunch' => 0,
    //                     'holiday' => 0,
    //                     'week_off' => 0,
    //                     'half_day' => 0,
    //                     'overtime' => 0,
    //                     'leave' => 0,
    //                 ]
    //             );

    //             // $monthlyCountCreate->save();
    //         }

    //         $updateFields = [
    //             1 => 'present',
    //             2 => 'absent',
    //             3 => 'late',
    //             4 => 'mispunch',
    //             12 => 'early_exit',
    //             6 => 'holiday',
    //             7 => 'week_off',
    //             8 => 'half_day',
    //             9 => 'overtime',
    //             10 => 'leave',
    //             11 => 'leave',
    //         ];
    //         $monthlyCountUpdate = AttendanceMonthlyCount::where($searchCriteria)->first();
    //         if (array_key_exists($status, $updateFields)) {
    //             $fieldToUpdate = $updateFields[$status];
    //             $monthlyCountUpdate->$fieldToUpdate += 1;
    //             // $monthlyCountUpdate->mispunch -= 1;
    //             $monthlyCountUpdate->save();
    //         }


    //         $getTodayCount = AttendanceDailyCount::where(['business_id' => $businessID, 'date' => $punchDate])->first();
    //         $totalEmp = EmployeePersonalDetail::where('business_id', $businessID)->count();
    //         if (!isset($getTodayCount)) {
    //             $createDailyCount = AttendanceDailyCount::create([
    //                 'business_id' => $businessID,
    //                 'date' => date('Y-m-d', strtotime($punchDate)),
    //                 'total_emp' => $totalEmp ?? 0,
    //                 'present' => 0,
    //                 'absent' => $totalEmp ?? 0,
    //                 'late' => 0,
    //                 'early' => 0,
    //                 'mispunch' => 0,
    //                 'halfday' => 0,
    //                 'overtime' => 0,
    //                 'leave' => 0,
    //             ]);
    //         }

    //         $getTodayCount = AttendanceDailyCount::where(['business_id' => $businessID, 'date' => $punchDate])->first();
    //         if (isset($getTodayCount)) {
    //             $getTodayCount->update([
    //                 // 'total_emp' => $totalEmp ?? 0,
    //                 'present' => $status == 1 ? $getTodayCount->present + 1 : $getTodayCount->present ?? 0,
    //                 'absent' => $status == 2 ? $getTodayCount->absent + 1 : $getTodayCount->absent ?? 0,
    //                 'late' => $status == 3 ? $getTodayCount->late + 1 : $getTodayCount->late ?? 0,
    //                 'early' => $status == 12 ? $getTodayCount->early + 1 : $getTodayCount->early ?? 0,
    //                 'mispunch' => $status == 4 ? $getTodayCount->mispunch + 1 : $getTodayCount->mispunch ?? 0,
    //                 'halfday' => $status == 8 ? $getTodayCount->halfday + 1 : $getTodayCount->halfday ?? 0,
    //                 'overtime' => $status == 9 ? $getTodayCount->overtime + 1 : $getTodayCount->overtime ?? 0,
    //                 'leave' => in_array($status, [10, 11]) ? $getTodayCount->leave + 1 : $getTodayCount->leave ?? 0,
    //             ]);
    //         }
    //     }

    //     return 'Ho Gya';
    // }

    static function setCountAtOnceForDailyAndMonthly(){
        $Attendance = AttendanceList::where('business_id',Session::get('business_id'))->get();

        foreach ($Attendance as $key => $atten) {
            // dd($atten->punch_date);
            self::MyCountForMonth($atten->emp_id, date('Y-m-d',strtotime($atten->punch_date)), Session::get('business_id'));
            self::MyCountForDaily(date('Y-m-d',strtotime($atten->punch_date)), Session::get('business_id'));
        }
    }

    static function MyCountForMonth($empID, $date, $businessID)
    {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', $businessID)
            ->where('employee_personal_details.emp_id', $empID)
            ->select('emp_date_of_joining', 'master_endgame_id', 'emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();

        $monthlyCount = DB::table('attendance_monthly_count')->where(['business_id' => $businessID, 'emp_id' => $empID])->where('month', $month)->where('year', $year)->first();

        $attendanceData = DB::table('attendance_list')->where(['business_id' => $businessID, 'emp_id' => $empID])->whereMonth('punch_date', $month)->whereYear('punch_date', $year)->get();
        $overtime = $attendanceData->where('today_status', 9)->count();
        $absent = $attendanceData->where('today_status', 2)->count();
        $late = $attendanceData->where('today_status', 3)->count();
        $early = $attendanceData->where('today_status', 12)->count();
        $halfday = $attendanceData->where('today_status', 8)->count();
        $leave1 = $attendanceData->where('today_status', 10)->count();
        $leave2 = $attendanceData->where('today_status', 12)->count();
        $mispunch = $attendanceData->where('today_status', 4)->count();
        $present = $attendanceData->where('today_status', 1)->count() + $overtime + $late + $early;

        // dd($employee->master_endgame_id);
        $holidays = DB::table('attendance_holiday_list')
            ->where([
                'business_id' => $businessID,
                'master_end_method_id' => $employee->master_endgame_id,
                // 'holiday_package_id'=> $employee->holiday_policy_ids_list,
            ])
            ->whereMonth('holiday_date', date('m', strtotime($date)))
            ->whereYear('holiday_date', date('Y', strtotime($date)))
            ->whereDate('holiday_date', '<', date('Y-m-d', strtotime($date)))
            ->get();

            // dd($holidays);

        $weekOff = $holidays->where('holiday_type_id', 2)->count();
        $holiday = $holidays->where('holiday_type_id', 1)->count();

        $calculatedAbsent = (date('d', strtotime($date))-$present-($halfday)-$weekOff-$holiday-$leave2-$leave1-$mispunch)+$absent;

      
        if (isset($monthlyCount)) {
            DB::table('attendance_monthly_count')
                ->where([
                    'business_id' => $businessID,
                    'emp_id' => $empID,
                    'year' => $year,
                    'month' => $month,
                ])
                ->update([
                    'present' => $present ?? 0,
                    'absent' => $calculatedAbsent < 0 ? 0 : $calculatedAbsent,
                    'late' => $late ?? 0,
                    'early_exit' => $early ?? 0,
                    'mispunch' => $mispunch ?? 0,
                    'holiday' => $holiday ?? 0,
                    'week_off' => $weekOff ?? 0,
                    'half_day' => $halfday ?? 0,
                    'overtime' => $overtime,
                    'leave' => ($leave1 ?? 0) + ($leave2 ?? 0),
                ]);
        } else {
            DB::table('attendance_monthly_count')->insert([

                'business_id' => $businessID,
                'emp_id' => $empID,
                'year' => $year,
                'month' => $month,
                'present' => $present ?? 0,
                'absent' => (date('d', strtotime($date)) + ($absent ?? 0)) - (($present ?? 0) + ($halfday ?? 0) + ($weekOff ?? 0) + ($holiday ?? 0) + ($leave1 ?? 0) + ($leave2 ?? 0) + ($mispunch ?? 0)),
                'late' => $late ?? 0,
                'early_exit' => $early ?? 0,
                'mispunch' => $mispunch ?? 0,
                'holiday' => $holiday ?? 0,
                'week_off' => $weekOff ?? 0,
                'half_day' => $halfday ?? 0,
                'overtime' => $overtime,
                'leave' => ($leave1 ?? 0) + ($leave2 ?? 0),
            ]);
        }

        return 0;
    }
    ////////////////////// End Exact Count //////////////////////

    public static function getGlobal()
    {

        return [DB::table('static_countries')->get(), DB::table('static_states')->get(), DB::table('static_cities')->orderBy('Name')->get()];
    }

    public static function getCountry()
    {
        return DB::table('static_countries')->orderBy('Name')->get();
    }
    public static function getState()
    {
        return DB::table('static_states')->orderBy('Name')->get();
    }

    public static function getHolidayFromDB($Emp, $Date){
        $Emp = DB::table('employee_personal_details')->where('business_id',Session::get('business_id'))->first();
        $Holiday = DB::table('attendance_holiday_list')->where(['business_id'=>Session::get('business_id'),'master_end_method_id'=>$Emp->master_endgame_id,'holiday_date'=>date('Y-m-d',strtotime($Date))])->first();
        return $Holiday;
    }

    public static function getCity()
    {
        return
            DB::table('static_cities')->orderBy('Name')->get();
    }



    static function getNumberOfSundaysInMonth($year, $month)
    {
        $day = 0;
        $totalDayinMonth = date('t');
        $sundays = 0;

        while (++$day <= $totalDayinMonth) {
            $NDay = date('N', strtotime($year . '-' . $month . '-' . $day));
            if ($NDay == 7) {
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
        $totalDayinMonth = date('t', strtotime('01-' . $m . '-' . $y));
        $check = 0;


        while (++$check <= $totalDayinMonth) {
            $getOffDay = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-d', strtotime($y . '-' . $m . '-' . $check))]);
            $isOffDay = $getOffDay[0];
            if ($isOffDay == 6) {
                $totalHolidays++;
            } elseif ($isOffDay == 7) {
                $totalWeekOff++;
            } elseif ($isOffDay == 10) {
                $totalPaidLeave++;
            }
        }

        $day = 1;
        $noOfDay = $y == date('Y') && $m == date('m') ? date('d') : $totalDayinMonth;
        while ($day <= $noOfDay) {
            $resCode = self::getEmpAttSumm(['emp_id' => $Emp, 'punch_date' => date('Y-m-d', strtotime($y . '-' . $m . '-' . $day))]);
            // self::getEmpAttSummaryApi(['emp_id' => $Emp, 'punch_date' => date('Y-m-d', strtotime($y . '-' . $m . '-' . $day)),'business_id'=>Session::get('business_id')]);
            // dd($resCode[10]);
            // print_r($resCode[19]);
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
            $shiftWH = $shiftWH == 0 ? 480 : $shiftWH;
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
        // dd($allStatusCount);
        $twd = $allStatusCount[1] + $allStatusCount[2] + $allStatusCount[3] + $allStatusCount[4] + $allStatusCount[9] + $allStatusCount[8];
        $present = $allStatusCount[1] + $allStatusCount[3] + $allStatusCount[9] + $allStatusCount[12];
        $absent = $allStatusCount[2];
        $late = $allStatusCount[3];
        $mispunch = $allStatusCount[4];
        $holiday = $allStatusCount[6];
        $weekoff = $allStatusCount[7];
        $halfday = $allStatusCount[8];
        $overtime = $allStatusCount[9];
        $early = $allStatusCount[12];

        $remainingleave = $remLeave;
        $totalPaidOffDay = $totalHolidays + $totalWeekOff + $totalPaidLeave;
        $totalWDinMonth = $totalDayinMonth - $totalPaidOffDay;


        $cwh = ($totalTwhMin / 60);
        $twh = ($totalWDinMonth) * ($shiftWH / 60);

        $twhpercentage = ($totalTwhMin != 0 && $shiftWH != 0) ? ($cwh / ($totalWDinMonth * ($shiftWH / 60))) * 100 : 0;

        $rwh = $twh - $cwh;

        $trwh = max(0, $twh);


        $trwhpercentege = (($twh - $cwh) / $twh) * 100;

        $otwh = $totalOTMin / 60;

        $totwh = $MaxOvertime / 60;
        // dd($MaxOvertime / 60);

        $totwhpercentage = $MaxOvertime !== 0 ? ((($totalOTMin / 60) / ($MaxOvertime / 60))) * 100 : 0;
        // dd($totwhpercentage);

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
            $totwhpercentage, //18
            $early // 19
        ];

        // dd($response);
        return $response;
    }

    // All type calculation of Attendance for Dashboard and daily attendance (this  function is not in use.)
    static function GetCount($Date)
    {

        // dd(''. $Date .'');

        $leaveCount = 0;
        $misPunchCount = 0;
        $Present = 0;
        $Late = 0;
        $Early = 0;
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
            } elseif ($status == 12) {
                $Early++;
            }
        }

        $Present = $Present + $Late + $Early + $Overtime;
        $AbsentCount = $EmpCount - ($Present + $HalfDay + $misPunchCount);

        return [$EmpCount ?? 0, $Present ?? 0, $AbsentCount ?? 0, $HalfDay ?? 0, $leaveCount ?? 0, $misPunchCount ?? 0, $Late ?? 0, $Overtime ?? 0];
    }

    // Attendance Summary of Indivisual Employee for a Month 
    // $Emp = employee id 
    // $y = year 
    // $m = month
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
            ->select('attendance_list.*', 'static_attendance_methods.method_name')
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

        $totalEmp = DB::table('employee_personal_details')
            ->where('business_id', $businessID)
            ->where('active_emp', '1')
            ->pluck('emp_id')
            ->all();

        $late = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('attendance_list.business_id', Session::get('business_id'))->where('attendance_list.punch_date', date('Y-m-d'))->where('attendance_list.today_status', 3)->count();
        $overtime = DB::table('attendance_list')->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')->where('employee_personal_details.active_emp', '1')->where('attendance_list.business_id', Session::get('business_id'))->where('attendance_list.punch_date', date('Y-m-d'))->where('attendance_list.today_status', 9)->count();
        $weekoffHolidayData = DB::table('employee_personal_details')
            ->join('attendance_holiday_list', 'attendance_holiday_list.master_end_method_id', '=', 'employee_personal_details.master_endgame_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('employee_personal_details.business_id', $businessID)
            ->where('attendance_holiday_list.holiday_date', $today)
            ->pluck('employee_personal_details.emp_id')
            ->all();

        $leaveData = DB::table('request_leave_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('request_leave_list.business_id', $businessID)
            ->where('request_leave_list.final_status', '1')
            ->whereDate('request_leave_list.from_date', '<=', now())
            ->whereDate('request_leave_list.to_date', '>=', now())
            ->distinct()
            ->pluck('request_leave_list.emp_id')
            ->all();

        $presentData = DB::table('attendance_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('attendance_list.business_id', $businessID)
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.punch_date', $today)
            ->whereIn('attendance_list.today_status', [1, 4, 9, 3])
            ->pluck('attendance_list.emp_id')
            ->all();

        $halfDay = DB::table('attendance_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
            ->where('employee_personal_details.active_emp', '1')
            ->where('attendance_list.business_id', $businessID)
            ->where('attendance_list.punch_date', $today)
            ->where('attendance_list.today_status', 8)
            ->pluck('attendance_list.emp_id')
            ->all();

        $absentcheck = DB::table('attendance_list')
            ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
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
     public static function getThinksToDoCount($businessID, $Date)
    {
        $manageAttendance = DB::table('attendance_list')
        ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
        ->where('employee_personal_details.active_emp', '1')
        ->where('attendance_list.business_id', Session::get('business_id'))
        ->where('attendance_list.final_status', 0)
        ->select('attendance_list.punch_date')
        ->distinct('attendance_list.punch_date')
        ->count();
    
    $manageMispunch = DB::table('request_mispunch_list')
        ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_mispunch_list.emp_id')
        ->where('employee_personal_details.active_emp', '1')
        ->where('request_mispunch_list.business_id', Session::get('business_id'))
        ->where('request_mispunch_list.final_status', 0)
        ->select('request_mispunch_list.emp_miss_date')
        ->distinct('request_mispunch_list.emp_miss_date')
        ->count();
    
    $manageLeaves = DB::table('request_leave_list')
        ->join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'request_leave_list.emp_id')
        ->where('employee_personal_details.active_emp', '1')
        ->where('request_leave_list.business_id', Session::get('business_id'))
        ->where('request_leave_list.final_status', 0)
        ->select('request_leave_list.apply_date')
        ->distinct('request_leave_list.apply_date')
        ->count();
    if ($manageAttendance != null || $manageMispunch != null || $manageLeaves != null ) {
            return [$manageAttendance, $manageMispunch, $manageLeaves];
        } else {
            return [0, 0, 0];
        }
        // return 
    }

    // get Monthly count from Database
    static function getMonthlyCountFromDB($empID, $year, $month, $BusinessID)
    {
        $getCount = AttendanceMonthlyCount::where(['emp_id' => $empID, 'year' => $year, 'month' => $month, 'business_id' => $BusinessID])->first();
        $AbsentCount = (date('j')+($getCount->absent ?? 0))-($getCount->present ?? 0) - ($getCount->half_day ?? 0) - ($getCount->week_off ?? 0) - ($getCount->leave ?? 0) - ($getCount->mispunch ?? 0) - ($getCount->holiday ?? 0);
     
        $setCount = [
            'present' => ($getCount->present ?? 0),
            'absent' => $AbsentCount < 0 ? 0 : $AbsentCount,
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

                // if (isset($isTodayHoliday)) {
                //     $Status = 6;
                // }

                // $weekOff = DB::table('policy_weekly_holiday_list')->where(['business_id' => Session::get('business_id'), 'id' => $weekly_policy,])->first();
                // $dayName = date('N', strtotime($Emp['punch_date']));

                // if (isset($weekOff)) {
                //     if ($weekOff->weekend_policy == 4) {
                //         foreach (json_decode($weekOff->days) as $day) {
                //             if (date('N', strtotime($day)) == $dayName) {
                //                 $Status = 7;
                //                 break;
                //             }
                //         }
                //     } elseif ($weekOff->weekend_policy == 3) {
                //         if (7 == $dayName) {
                //             $Status = 7;
                //         }

                //         if (6 == $dayName && ((intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 2 || (intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 4)) {
                //             $Status = 7;
                //         }
                //     } elseif ($weekOff->weekend_policy == 2) {
                //         if (7 == $dayName) {
                //             $Status = 7;
                //         }
                //     } elseif ($weekOff->weekend_policy == 1) {
                //         if (7 == $dayName) {
                //             $Status = 7;
                //         } else {
                //             $Status = 2;
                //         }

                //         if (6 == $dayName) {
                //             $Status = 7;
                //         }
                //     }
                // } else {
                //     $Status = 2;
                // }
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
            ->select('emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom','master_endgame_id')
            ->first();

            // dd($Emp);
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

                if ($shiftType != null && ($shiftType->shift_type ?? false) && $shiftType->shift_type == 2) {
                    $shift = PolicyAttendanceShiftTypeItem::where(['business_id' => $Emp['business_id'], 'id' => $attendanceList->attendance_shift ?? 0,])->first();
                } else {
                    $shift = PolicyAttendanceShiftTypeItem::where(['business_id' => $Emp['business_id'], 'attendance_shift_id' => $employee->emp_shift_type])->first();
                }
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

                    // if (isset($isTodayHoliday)) {
                    //     $Status = 6;
                    // }

                    // $weekOff = DB::table('policy_weekly_holiday_list')->where(['business_id' => Session::get('business_id'), 'id' => $weekly_policy,])->first();
                    // $dayName = date('N', strtotime($Emp['punch_date']));

                    // if (isset($weekOff)) {
                    //     if ($weekOff->weekend_policy == 4) {
                    //         foreach (json_decode($weekOff->days) as $day) {
                    //             if (date('N', strtotime($day)) == $dayName) {
                    //                 $Status = 7;
                    //                 break;
                    //             }
                    //         }
                    //     } elseif ($weekOff->weekend_policy == 3) {
                    //         if (7 == $dayName) {
                    //             $Status = 7;
                    //         }

                    //         if (6 == $dayName && ((intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 2 || (intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 4)) {
                    //             $Status = 7;
                    //         }
                    //     } elseif ($weekOff->weekend_policy == 2) {
                    //         if (7 == $dayName) {
                    //             $Status = 7;
                    //         }
                    //     } elseif ($weekOff->weekend_policy == 1) {
                    //         if (7 == $dayName) {
                    //             $Status = 7;
                    //         } else {
                    //             $Status = 2;
                    //         }

                    //         if (6 == $dayName) {
                    //             $Status = 7;
                    //         }
                    //     }
                    // } else {
                    //     $Status = 2;
                    // }
                }

            }
            //  elseif ($isTodayHoliday) {
            //     $status = 6; // Holiday
            // } elseif (count($leaveRequestList) > 0) {
            //     // checking employee has any leave request or not

            //     foreach ($leaveRequestList as $list) {
            //         $leaveFrom = Carbon::parse($list->from_date);
            //         $leaveTo = Carbon::parse($list->to_date);
            //         $today = Carbon::parse($Emp['punch_date']);
            //         // $today = Carbon::parse(date('Y-m-d'));
            //         if ($today >= $leaveFrom && $today <= $leaveTo) {
            //             // dd($leaveDetail);
            //             if (isset($leaveDetail[$list->leave_category]['remaining'])) {
            //                 $remainingLeaves = $leaveDetail[$list->leave_category]['remaining'];
            //                 $day = $leaveFrom->diffInDays($today) + 1;
            //                 while ($day-- > 0) {
            //                     if ($remainingLeaves != 0) {
            //                         $status = 10; //paid leave
            //                         $remainingLeaves--;
            //                     } else {
            //                         $status = 11; // unpaid leave
            //                     }
            //                 }
            //             } else {
            //                 $status = 2;
            //             }
            //         } else {
            //             $weekOff = DB::table('policy_weekly_holiday_list')->where(['business_id' => Session::get('business_id'), 'id' => $weekly_policy,])->first();
            //             $dayName = date('N', strtotime($Emp['punch_date']));

            //             if (isset($weekOff)) {
            //                 if ($weekOff->weekend_policy == 4) {
            //                     foreach (json_decode($weekOff->days) as $day) {
            //                         if (date('N', strtotime($day)) == $dayName) {
            //                             $Status = 7;
            //                             break;
            //                         }
            //                     }
            //                 } elseif ($weekOff->weekend_policy == 3) {
            //                     if (7 == $dayName) {
            //                         $Status = 7;
            //                     }

            //                     if (6 == $dayName && ((intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 2 || (intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 4)) {
            //                         $Status = 7;
            //                     }
            //                 } elseif ($weekOff->weekend_policy == 2) {
            //                     if (7 == $dayName) {
            //                         $Status = 7;
            //                     }
            //                 } elseif ($weekOff->weekend_policy == 1) {
            //                     if (7 == $dayName) {
            //                         $Status = 7;
            //                     }

            //                     if (6 == $dayName) {
            //                         $Status = 7;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // } else {
            //     $weekOff = DB::table('policy_weekly_holiday_list')->where(['business_id' => Session::get('business_id'), 'id' => $weekly_policy,])->first();
            //     $dayName = date('N', strtotime($Emp['punch_date']));

            //     if (isset($weekOff)) {
            //         if ($weekOff->weekend_policy == 4) {
            //             foreach (json_decode($weekOff->days) as $day) {
            //                 if (date('N', strtotime($day)) == $dayName) {
            //                     $Status = 7;
            //                     break;
            //                 }
            //             }
            //         } elseif ($weekOff->weekend_policy == 3) {
            //             if (7 == $dayName) {
            //                 $Status = 7;
            //             }

            //             if (6 == $dayName && ((intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 2 || (intval(date('d', strtotime($Emp['punch_date'])) / 7) + 1) == 4)) {
            //                 $Status = 7;
            //             }
            //         } elseif ($weekOff->weekend_policy == 2) {
            //             if (7 == $dayName) {
            //                 $Status = 7;
            //             }
            //         } elseif ($weekOff->weekend_policy == 1) {
            //             if (7 == $dayName) {
            //                 $Status = 7;
            //             }

            //             if (6 == $dayName) {
            //                 $Status = 7;
            //             }
            //         }
            //     }
            // }



            //*********************************/ start monthly count update for a indivisual employee in daily basis /***************************//
            // dd($status);
            
            $countData = AttendanceMonthlyCount::where([
                'business_id' => $Emp['business_id'],
                'emp_id' => $Emp['emp_id'],
                'year' => date('Y',strtotime($Emp['punch_date'])),
                'month' => date('m',strtotime($Emp['punch_date']))
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


                // $updateFields = [
                //     1 => 'present',
                //     2 => 'absent',
                //     3 => 'late',
                //     4 => 'mispunch',
                //     12 => 'early_exit',
                //     6 => 'holiday',
                //     7 => 'week_off',
                //     8 => 'half_day',
                //     9 => 'overtime',
                //     10 => 'leave',
                //     11 => 'leave',
                // ];

                // if (array_key_exists($status, $updateFields)) {
                //     $fieldToUpdate = $updateFields[$status];
                //     $countData->$fieldToUpdate += 1;
                //     $countData->mispunch > 0 ? $countData->mispunch -= 1 : $countData->mispunch = 0;
                //     $countData->save();
                // }

                // // Calculate holiday and week off counts
                // $holidayCountForMonth = self::calculateHolidayCountForMonth($holiday_policy, $Emp['punch_date'], $Emp['business_id']);
                // $weekOffCount = self::calculateWeekOffCount($weekly_policy, $Emp['punch_date'], $Emp['business_id']);

                // // Update $countData with holiday and week off counts
                // $countData->holiday = $holidayCountForMonth;
                // $countData->week_off = $weekOffCount;
                // $countData->save();
            }


            //*******************/ End monthly count update for a indivisual employee in daily basis /**************//

            // mispunch calculation accourdign to rule 
            self::misPunchRuleFunction($Emp['business_id'], $Emp['punch_date']);

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

    static function lateEntryRuleCalculate($empID, $date, $businessID)
    {
        $getLateEntryRule = DB::table('policy_atten_rule_late_entry')->where('business_id', $businessID)->first();
        $graceMin = $getLateEntryRule->grace_time_hr * 60 + $getLateEntryRule->grace_time_min;

        $attendanceDetails = DB::table('attendance_list')->where(['emp_id' => $empID, 'punch_date' => $date, 'business_id' => $businessID])->first();
        if (isset($attendanceDetails)) {
            $shiftStart = Carbon::parse($attendanceDetails->applied_shift_comp_start_time);
            $punchIn = Carbon::parse($attendanceDetails->punch_in_time);
            $graceAddedTime = $shiftStart->addMinutes($graceMin);
            $lateMin = $shiftStart->diffInMinutes($punchIn);
            if (($getLateEntryRule->switch_is ?? 0) == 1 && $graceAddedTime < $punchIn) {
                DB::table('attendance_list')->where(['emp_id' => $empID, 'punch_date' => $date, 'business_id' => $businessID])->update(['late_by' => $lateMin]);
            }
        }

        return $getLateEntryRule;
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
            // dd($attendance);
            $misPunchRequests = DB::table('request_mispunch_list')->where('emp_id', $attendance->emp_id)->where('emp_miss_date', date('Y-m-d', strtotime($attendance->punch_date)))->where('business_id', $BusinessID)->first();
            $empMonthCount = DB::table('attendance_monthly_count')->where('emp_id', $attendance->emp_id)->where('year', date('Y', strtotime($attendance->punch_date)))->where('month', date('m', strtotime($attendance->punch_date)))->where('business_id', $BusinessID)->first();
            // dd($misPunchRequests);
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
            // dd(isset($misPunchRequests));
            if (!isset($misPunchRequests)) {
                // dd($attendance);

                if ($ifNotRequestedThen == 1) {

                    DB::table('attendance_list')->where('id', $attendance->id)->update(['today_status' => 8]);

                    DB::table('attendance_monthly_count')->where('id', $empMonthCount->id)->update([
                        'half_day' => $empMonthCount->half_day + 1,
                        'mispunch' => $empMonthCount->mispunch >= 0 ? $empMonthCount->mispunch - 1 : 0,
                    ]);
                    // dd('1');
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
            }
        }
        // dd(isset($misPunchRequests));
        return 0;
    }

    // counting daily for all employees
    static function setDailyAttendanceCount($empID, $date, $businessID)
    {

        $totalEmp = EmployeePersonalDetail::where('business_id', $businessID)->count();
        $getTodayCount = AttendanceDailyCount::where(['business_id' => $businessID, 'date' => $date])->first();

        // dd($totalEmp);

        if (!isset($getTodayCount)) {
            $createDailyCount = AttendanceDailyCount::create([
                'business_id' => $businessID,
                'date' => date('Y-m-d', strtotime($date)),
                'total_emp' => $totalEmp ?? 0,
                'present' => 0,
                'absent' => $totalEmp ?? 0,
                'late' => 0,
                'early' => 0,
                'mispunch' => 0,
                'halfday' => 0,
                'overtime' => 0,
                'leave' => 0,
            ]);
        }

        $employeeAttendanceData = AttendanceList::where(['punch_date' => $date, 'emp_id' => $empID, 'business_id' => $businessID,])->first();
        $status = $employeeAttendanceData->today_status ?? 0;
        $punchInOrOut = $employeeAttendanceData->emp_today_current_status ?? 0;

        $getTodayCount = AttendanceDailyCount::where(['business_id' => $businessID, 'date' => $date])->first();

        // dd($totalEmp);

        // it runs when employee punch in

        if ($punchInOrOut != null && $punchInOrOut == 1) {
            $getTodayCount->update([
                // 'total_emp' => $totalEmp ?? 0,
                'present' => $status == 1 ? $getTodayCount->present + 1 : $getTodayCount->present ?? 0,
                'absent' => ($getTodayCount->absent ?? 0) - 1,
                'late' => $status == 3 ? $getTodayCount->late + 1 : $getTodayCount->late ?? 0,
                'early' => $status == 12 ? $getTodayCount->early + 1 : $getTodayCount->early ?? 0,
                'mispunch' => $status == 4 ? $getTodayCount->mispunch + 1 : $getTodayCount->mispunch ?? 0,
                'halfday' => $status == 8 ? $getTodayCount->halfday + 1 : $getTodayCount->halfday ?? 0,
                'overtime' => $status == 9 ? $getTodayCount->overtime + 1 : $getTodayCount->overtime ?? 0,
                'leave' => in_array($status, [10, 11]) ? $getTodayCount->leave + 1 : $getTodayCount->leave ?? 0,
            ]);



            $searchCriteria = [
                'business_id' => $businessID,
                'emp_id' => $empID,
                'year' => date('Y'),
                'month' => date('m')
            ];
            AttendanceMonthlyCount::updateOrCreate($searchCriteria, [
                'mispunch' => \DB::raw('mispunch + 1')
            ]);

            $lateCalculate = self::lateEntryRuleCalculate($empID, $date, $businessID);
        }

        // it runs when employee punch out 

        if ($punchInOrOut != null && $punchInOrOut == 2) {
            if (isset($getTodayCount)) {
                $getTodayCount->update([
                    // 'total_emp' => $totalEmp ?? 0,
                    'present' => $status == 1 ? $getTodayCount->present + 1 : $getTodayCount->present ?? 0,
                    'absent' => $status == 2 ? $getTodayCount->absent + 1 : $getTodayCount->absent ?? 0,
                    'late' => $status == 3 ? $getTodayCount->late + 1 : $getTodayCount->late ?? 0,
                    'early' => $status == 12 ? $getTodayCount->early + 1 : $getTodayCount->early ?? 0,
                    'mispunch' => $status == 4 ? $getTodayCount->mispunch : $getTodayCount->mispunch - 1 ?? 0,
                    'halfday' => $status == 8 ? $getTodayCount->halfday + 1 : $getTodayCount->halfday ?? 0,
                    'overtime' => $status == 9 ? $getTodayCount->overtime + 1 : $getTodayCount->overtime ?? 0,
                    'leave' => in_array($status, [10, 11]) ? $getTodayCount->leave + 1 : $getTodayCount->leave ?? 0,
                ]);
            }
        }



        // dd($createDailyCount);
        return 0;
    }

    // holiday count for month 
    static function calculateHolidayCountForMonth($holidayPolicy, $punchDate, $businessID)
    {
        $holidayCountForMonth = 0;

        // foreach ($holidayPolicy as $Hpolicy) {
        $HolidayCount = PolicyHolidayDetail::where([
            'business_id' => $businessID,
            'template_id' => $holidayPolicy,
        ])
            ->whereMonth('holiday_date', Carbon::parse($punchDate)->format('m'))
            ->count();
        $holidayCountForMonth += $HolidayCount;
        // }

        return $holidayCountForMonth;
    }

    // get week off count
    static function calculateWeekOffCount($weeklyPolicy, $punchDate, $businessID)
    {
        $weekOffCount = 0;

        $weekOff = DB::table('policy_weekly_holiday_list')->where(['business_id' => Session::get('business_id'), 'id' => $weeklyPolicy,])->first();
        $dayName = date('N', strtotime($punchDate));

        if (isset($weekOff)) {
            if ($weekOff->weekend_policy == 4) {
                foreach (json_decode($weekOff->days) as $day) {
                    if (date('N', strtotime($day)) == $dayName) {
                        $weekOffCount++;
                        break;
                    }
                }
            } elseif ($weekOff->weekend_policy == 3) {
                if (7 == $dayName) {
                    $weekOffCount++;
                }

                if (6 == $dayName && ((intval(date('d', strtotime($punchDate)) / 7) + 1) == 2 || (intval(date('d', strtotime($punchDate)) / 7) + 1) == 4)) {
                    $weekOffCount++;
                }
            } elseif ($weekOff->weekend_policy == 2) {
                if (7 == $dayName) {
                    $weekOffCount++;
                }
            } elseif ($weekOff->weekend_policy == 1) {
                if (7 == $dayName) {
                    $weekOffCount++;
                }

                if (6 == $dayName) {
                    $weekOffCount++;
                }
            }
        }

        return $weekOffCount;
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

    // ********************************************************** End of Attendance Calculation By Aman ***************************************

    static function calculateLeaveCountApi($EmpData)
    {

        // $empID = $EmpData['empID'];                           // IT008
        // $businessID = $EmpData['businessID'];                 // e3d64177e51bdff82b499e116796fe74
        // $fullOrHalfDay = $EmpData['fullOrHafDay'];            // 1
        // $leaveID = $EmpData['leaveID'];                       // 146
        // $shift = $EmpData['shift'];                           // 1
        // $from = $EmpData['from'];                             // 2023-11-07
        // $to = $EmpData['to'];                                 // 2023-11-10
        // $day = $EmpData['day'];                               // 3

        // // dd($empID,$businessID,$fullOrHalfDay,$leaveID,$shift,$from ,$to,$day);

        // $fromDate = Carbon::parse($from);
        // $year = $fromDate->year;
        // $month = $fromDate->month;
        // $getOpening = 0;



        // $employee = DB::table('employee_personal_details')
        //     ->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
        //     ->join('policy_setting_leave_category', function ($join) {
        //         $join->on('policy_master_endgame_method.leave_policy_ids_list', 'LIKE', DB::raw('CONCAT("%", policy_setting_leave_category.leave_policy_id, "%")'));
        //     })
        //     ->where('employee_personal_details.business_id', $businessID)
        //     ->where('employee_personal_details.emp_id', $empID)
        //     ->select('emp_id', 'emp_name', 'emp_date_of_joining', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
        //     ->first();

        // $leavePolicy = PolicySettingLeavePolicy::where('id', json_decode($employee->leave_policy_ids_list ?? 0, true)[0])->first();

        // $leavesPolicyItems = DB::table('policy_setting_leave_category')
        //     ->where([
        //         'business_id' => $businessID,
        //         'leave_policy_id' => json_decode($employee->leave_policy_ids_list ?? 0, true)[0],
        //         'id' => $leaveID,
        //     ])->first();

        // $getPreviousMonthLeaveCount = RequestLeaveList::where('emp_id', $empID)->where('leave_category', $leaveID)->where('final_status', 1)->whereMonth('from_date', '<=', $month - 1)->whereYear('from_date', $year)->sum('days');
        // $getCurrentMonthApprovedLeaveCount = RequestLeaveList::where('emp_id', $empID)->where('leave_category', $leaveID)->where('final_status', 1)->whereMonth('from_date', $month)->whereYear('from_date', $year)->sum('days');
        // $getCurrentMonthUnApprovedLeaveCount = RequestLeaveList::where('emp_id', $empID)->where('leave_category', $leaveID)->where('final_status', 0)->whereMonth('from_date', $month)->whereYear('from_date', $year)->sum('days');

        // // dd($getPreviousMonthLeaveCount,$getCurrentMonthApprovedLeaveCount,$getCurrentMonthUnApprovedLeaveCount);

        // $getEmployeeLeaveBalance = EmployeeLeaveBalance::where([
        //     'emp_id' => $empID,
        //     'business_id' => $businessID,
        //     'month' => $month,
        //     'year' => $year,
        //     'leave_type' => $leavesPolicyItems->leave_type,
        // ])->first();



        // if(date('Y', strtotime($employee->emp_date_of_joining)) < date('Y', strtotime($from))) {
        //     $getOpening = EmployeeLeaveBalance::where([
        //         'emp_id' => $empID,
        //         'business_id' => $businessID,
        //         'leave_type' => $leavesPolicyItems->leave_type,
        //         'month' => 12,
        //         'year' => $year - 1,
        //     ])->first();
        //     $getOpeningVal = $getOpening->available_leave_balance;

        // }
        // // dd($getOpening);



        // if(!isset($getEmployeeLeaveBalance)) {
        //     $getPreviousMonthBalance = EmployeeLeaveBalance::where([
        //         'emp_id' => $empID,
        //         'business_id' => $businessID,
        //         'leave_type' => $leavesPolicyItems->leave_type,
        //         'month' => $month - 1,
        //         'year' => $year,
        //     ])->first();
        //     // dd(($getOpeningVal));
        //     // dd($getPreviousMonthBalance != null ? ($getPreviousMonthBalance->available_leave_balance ?? 0) + ($leavesPolicyItems->days ?? 0) : ($getOpening ?? 0) + ($leavesPolicyItems->days ?? 0)) - ($getCurrentMonthApprovedLeaveCount ?? 0);
        //     if($leavePolicy->leave_policy_cycle_monthly == 1){
        //         $createEmployeeLeaveBalance = DB::table('employee_leave_balance')->insert([
        //             'emp_id' => $empID,
        //             'business_id' => $businessID,
        //             'month' => $month,
        //             'year' => $year,
        //             'leave_type' => $leavesPolicyItems->leave_type,
        //             'leave_id' => $leavesPolicyItems->id,
        //             'leave_cycle' => $leavePolicy->leave_policy_cycle_monthly != 0 && $leavePolicy->leave_policy_cycle_monthly != null ? ($leavePolicy->leave_policy_cycle_monthly ?? 0) : ($leavePolicy->leave_policy_cycle_yearly ?? 0),
        //             'opening' => $getOpeningVal ?? 0,
        //             'accured' => $leavesPolicyItems->days ?? 0,
        //             'availed_last_month' => $getPreviousMonthLeaveCount,
        //             'availed_current_month' => $getCurrentMonthApprovedLeaveCount ?? 0,
        //             'balance' =>($getPreviousMonthBalance != null ? ($getPreviousMonthBalance->available_leave_balance ?? 0) + ($leavesPolicyItems->days ?? 0) : ($getOpeningVal ?? 0) + ($leavesPolicyItems->days ?? 0)) - ($getCurrentMonthApprovedLeaveCount ?? 0),
        //             'un_approved_leave_applied' => $getCurrentMonthUnApprovedLeaveCount ?? 0,
        //             'available_leave_balance' => ($getPreviousMonthBalance != null ? ($getPreviousMonthBalance->available_leave_balance ?? 0) + ($leavesPolicyItems->days ?? 0) : ($getOpeningVal ?? 0) + ($leavesPolicyItems->days ?? 0)) - (($getCurrentMonthApprovedLeaveCount ?? 0)+($getCurrentMonthUnApprovedLeaveCount ?? 0)),
        //         ]);
        //     }

        //     if($leavePolicy->leave_policy_cycle_yearly == 1){
        //         $createEmployeeLeaveBalance = DB::table('employee_leave_balance')->insert([
        //             'emp_id' => $empID,
        //             'business_id' => $businessID,
        //             'month' => $month,
        //             'year' => $year,
        //             'leave_type' => $leavesPolicyItems->leave_type,
        //             'leave_id' => $leavesPolicyItems->id,
        //             'leave_cycle' => $leavePolicy->leave_policy_cycle_monthly != 0 && $leavePolicy->leave_policy_cycle_monthly != null ? ($leavePolicy->leave_policy_cycle_monthly ?? 0) : ($leavePolicy->leave_policy_cycle_yearly ?? 0),
        //             'opening' => $getOpeningVal ?? 0,
        //             'accured' => $leavesPolicyItems->days ?? 0,
        //             'availed_last_month' => $getPreviousMonthLeaveCount,
        //             'availed_current_month' => $getCurrentMonthApprovedLeaveCount ?? 0,
        //             'balance' => ($getPreviousMonthBalance != null ? ($getPreviousMonthBalance->available_leave_balance ?? 0) : ($getOpeningVal ?? 0) + ($leavesPolicyItems->days ?? 0)) - ($getCurrentMonthApprovedLeaveCount ?? 0),
        //             'un_approved_leave_applied' => $getCurrentMonthUnApprovedLeaveCount ?? 0,
        //             'available_leave_balance' => ($getPreviousMonthBalance != null ? ($getPreviousMonthBalance->available_leave_balance ?? 0) : ($getOpeningVal ?? 0) + ($leavesPolicyItems->days ?? 0)) - (($getCurrentMonthApprovedLeaveCount ?? 0) + ($getCurrentMonthUnApprovedLeaveCount ?? 0)),
        //         ]);
        //     }
        // }


        // dd($getPreviousMonthLeaveCount,$getCurrentMonthApprovedLeaveCount,$getCurrentMonthUnApprovedLeaveCount);



        // if(isset($getEmployeeLeaveBalance)) {
        //     $updateEmployeeLeaveBalance = EmployeeLeaveBalance::where([
        //         'emp_id' => $empID,
        //         'business_id' => $businessID,
        //         'month' => $month,
        //         'year' => $year,
        //         'leave_type' => $leavesPolicyItems->leave_type ?? 0,
        //         'leave_id' => $leaveID,
        //     ])->update([
        //                 'accured' => $leavesPolicyItems->days ?? 0,
        //                 'opening' => $getOpening ?? 0,
        //                 'availed_last_month' => $getPreviousMonthLeaveCount,
        //                 'availed_current_month' =>  $getCurrentMonthApprovedLeaveCount,
        //                 'balance' => ($getEmployeeLeaveBalance->available_leave_balance + $getOpening)-$getCurrentMonthUnApprovedLeaveCount ?? 0,
        //                 'un_approved_leave_applied' => $getCurrentMonthUnApprovedLeaveCount,
        //                 'available_leave_balance' => ($getEmployeeLeaveBalance->available_leave_balance + $getOpening)-$getCurrentMonthUnApprovedLeaveCount - $getCurrentMonthUnApprovedLeaveCount,
        //             ]);
        // }


        // dd($createEmployeeLeaveBalance);

        return 0;
    }

    // ********************************************************** End of Leave Calculation By Aman ***************************************

}
