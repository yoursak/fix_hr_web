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
use App\Models\StaticApprovalName;
// use Illuminate\Support\Facades\Crypt;
use App\Models\StaticCountryModel;
use App\Models\StaticAttendanceMode;
use App\Models\StaticStatesModel;
use App\Models\StaticCityModel;
use App\Models\StaticEmployeeJoinEmpType;
use App\Exports\TableExcelExport;
use App\Models\StaticEmployeeJoinGenderType;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\StaticAttendanceMethod;
use App\Models\StaticAttendanceShiftType;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinGovtDocType;
use App\Models\StaticEmployeeJoinReligion;
use App\Models\PolicyCompOffLwopLeave;
use App\Models\AttendanceHolidayList;
use App\Exports\ExportEmployeeDetails;
use App\Models\EmployeeLeaveBalance;
use App\Models\PolicySettingLeaveCategory;
use App\Models\StaticEmployeeJoinContractualType;
use App\Models\StaticEmployeeJoinActiveType;
use Barryvdh\DomPDF\Facade\Pdf;

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
    static function generateAndDownloadPDF($getData)
    {
        $data = $getData;
        $pdf = PDF::loadView('your-pdf-view', compact('data'));
        return $pdf->download('EmployeePage-FixHr.pdf');
    }

    // use IN EmployeePage - Component
    static function GeneratePDF($DataCollection, $fileName, $OtherArrayData)
    {
        $data = $DataCollection;
        $OtherData = $OtherArrayData;
        $file_name = $fileName . '.pdf';
        $pdf = PDF::loadView('generate-pdf.employee_table', compact('data', 'OtherData'))->setPaper('a4', 'landscape'); //PDF
        return $pdf->download($file_name);
    }

    // Filteration Decode URL CODE MODE
    public static function getDecodeUrlFiltration()
    {
        $fullUrl = request()->fullUrl();
        // dd($fullUrl);
        // Extract the query stringdd from the full URL
        $queryString = parse_url($fullUrl, PHP_URL_QUERY);

        // // Decode the URL-encoded query string
        parse_str($queryString, $queryParams);
        // dd($queryParams);
        return $queryParams;
    }

    public static function myHelperFunction($parameter)
    {
        return "Hello THIS IS Rule MANAGEMENT, $parameter!";
    }

    // Todays Status started
    public static function TodayStatus()
    {
        $load = Session::get('business_id');
        // $data = "aman ' .$load  . '";
        return [self::allValueGet()[0], $load];
    }

    // Checking branch-department-designation
    public static function getCheckingBusinessCheck($branch, $department, $designation)
    {
        $SessionBusiness = Session::get('business_id');

        $Branch = BranchList::where('business_id', $SessionBusiness)
            ->where('branch_name', '=', $branch)
            ->first();
        $Department = DepartmentList::where('business_id', $SessionBusiness)
            ->where('depart_name', '=', $department)
            ->first();
        $Designation = DesignationList::where('business_id', $SessionBusiness)
            ->where('desig_name', '=', $designation)
            ->first();

        if ($Branch != null && $Department != null && $Designation != null) {
            return [$Branch->branch_name, $Department->depart_name, $Designation->desig_name];
        } else {
            return ['', '', ''];
        }
    }
    public static function getCheckingBusinessCheckP2($BID, $branchID)
    {
        // , $departmentID, $designationID
        $Branch = BranchList::where('business_id', $BID)
            ->where('branch_id', $branchID)
            ->first();
        // $Department = DepartmentList::where('b_id', $BID)->where('depart_id',  $departmentID)->first();
        // $Designation = DesignationList::where('business_id', $BID)->where('desig_id', '=', $designationID)->first();

        if ($Branch != null) {
            return [$Branch->branch_name];
        } else {
            return [''];
        }
    }

    // Checking Country-State-City return By ID or Name default false
    public static function getCheckingCountryStateCity($type, $country, $state, $city)
    {
        //remove space
        $countries = self::removeSpaces($country);
        $states = self::removeSpaces($state);
        $cities = self::removeSpaces($city);
        $AllCountry = StaticCountryModel::where('name', '=', $countries)->first();
        $AllStates = null;
        $AllCities = null;

        if ($AllCountry != null) {
            $AllStates = StaticStatesModel::where('country_id', $AllCountry->id)
                ->where('name', '=', $states)
                ->first();
        }

        if ($AllStates != null) {
            $AllCities = StaticCityModel::where('state_id', $AllStates->id)
                ->where('name', '=', $cities)
                ->first();
        }

        if ($AllCountry != null && $AllStates != null && $AllCities != null) {
            if ($type) {
                return [$AllCountry->id, $AllStates->id, $AllCities->id];
            } else {
                return [$AllCountry->name, $AllStates->name, $AllCities->name];
            }
        } else {
            return ['', '', ''];
        }
    }
    // Regular Only EXCEL IMPORT DATA
    public static function getImportAllContent($BID, $GenderName, $MaritalType, $ReligionType, $CastCategoryType, $BloodGroupType, $GovtDocType, $BranchFind, $DepartmentFind, $DesignationFind, $EmployeeType, $MasterPolicyEndGameType, $AttendanceMethod, $PolicyShiftType, $ActiveEmployee, $countries, $empID, $mobileNo, $email, $reportingName)
    {
        $genderType = StaticEmployeeJoinGenderType::where('gender_type', '=', $GenderName)
            ->select('id')
            ->first();
        $maritalType = StaticEmployeeJoinMaritalType::where('marital_type', '=', $MaritalType)
            ->select('id')
            ->first();
        $religionType = StaticEmployeeJoinReligion::where('religion_name', '=', $ReligionType)
            ->select('id')
            ->first();
        $castCategoryType = StaticEmployeeJoinCategoryCaste::where('caste_category', $CastCategoryType)
            ->select('id')
            ->first();
        $bloodGroupType = StaticEmployeeJoinBloodGroup::where('blood_group', $BloodGroupType)
            ->select('id')
            ->first();
        $govtDocType = StaticEmployeeJoinGovtDocType::where('govt_type', $GovtDocType)
            ->select('id')
            ->first();
        $branchFind = BranchList::where('business_id', $BID)
            ->where('branch_name', $BranchFind)
            ->select('branch_id')
            ->first();
        $departmentFind = DepartmentList::where('b_id', $BID)
            ->where('depart_name', $DepartmentFind)
            ->select('depart_id')
            ->first();
        $designationFind = DesignationList::where('business_id', $BID)
            ->where('desig_name', $DesignationFind)
            ->select('desig_id')
            ->first();
        $employeeType = StaticEmployeeJoinEmpType::where('emp_type', $EmployeeType)
            ->select('type_id')
            ->first();
        $attendanceMethod = StaticAttendanceMethod::where('method_name', $AttendanceMethod)
            ->select('id')
            ->first();
        $policyShiftType = PolicyAttendanceShiftSetting::where('business_id', $BID)
            ->where('shift_type_name', $PolicyShiftType)
            ->select('id')
            ->first();
        $ShiftType = PolicyAttendanceShiftSetting::where('business_id', $BID)
            ->where('id', $policyShiftType->id)
            ->select('shift_type')
            ->first();
        $activeEmployee = StaticEmployeeJoinActiveType::where('name', $ActiveEmployee)
            ->select('id')
            ->first();
        $masterPolicyEndGameType = PolicyMasterEndgameMethod::where('business_id', $BID)
            ->where('method_name', $MasterPolicyEndGameType)
            ->select('id')
            ->first();

        $countrie = self::removeSpaces($countries);
        $AllCountry = StaticCountryModel::where('name', '=', $countrie)
            ->select('phonecode')
            ->first();
        $firstLoad = LoginEmployee::where('emp_id', $empID)
            ->where('business_id', $BID)
            ->first();

        if ($activeEmployee->id != 0) {
            if (isset($firstLoad)) {
                LoginEmployee::where('emp_id', $empID)
                    ->where('business_id', $BID)
                    ->update([
                        'emp_id' => $empID,
                        'business_id' => $BID,
                        'email' => $email,
                        'phone' => $mobileNo,
                        'country_code' => $AllCountry->phonecode,
                    ]);
            }

            if (!isset($firstLoad)) {
                LoginEmployee::where('emp_id', $empID)
                    ->where('business_id', $BID)
                    ->insert([
                        'emp_id' => $empID,
                        'business_id' => $BID,
                        'email' => $email,
                        'phone' => $mobileNo,
                        'country_code' => $AllCountry->phonecode,
                    ]);
            }
        }
        $genderId = $genderType ? $genderType->id : 0;
        $maritalId = $maritalType ? $maritalType->id : 0;
        $religionId = $religionType ? $religionType->id : 0;
        $castCategoryId = $castCategoryType ? $castCategoryType->id : 0;
        $bloodGroupId = $bloodGroupType ? $bloodGroupType->id : 0;
        $govtDocTypeId = $govtDocType ? $govtDocType->id : 0;
        $branchId = $branchFind ? $branchFind->branch_id : 0;
        $departmentId = $departmentFind ? $departmentFind->depart_id : 0;
        $designationId = $designationFind ? $designationFind->desig_id : 0;
        $employeeTypeId = $employeeType ? $employeeType->type_id : 0;
        $attendanceMethodId = $attendanceMethod ? $attendanceMethod->id : 0;
        $policyShiftTypeId = $policyShiftType ? $policyShiftType->id : 0;
        $assignShiftType = $ShiftType ? $ShiftType->shift_type : 0;
        $activeEmployeeId = $activeEmployee ? $activeEmployee->id : 0;
        $masterPolicyEndGameTypeId = $masterPolicyEndGameType ? $masterPolicyEndGameType->id : 0;


        // Split the full name into an array of parts
        $nameParts = explode(" ", $reportingName);

        // Initialize variables for first, middle, and last names
        $firstName = $nameParts[0]; // First name is the first element
        $lastName = end($nameParts); // Last name is the last element
        // Middle name is everything between first and last names
        // Use array_slice to get elements between the first and last names, then implode them back into a string
        $middleName = implode(" ", array_slice($nameParts, 1, -1));

        $getDetails = EmployeePersonalDetail::where('business_id', $BID)
            ->where(function ($query) use ($firstName, $lastName, $middleName) {
                $query->where('emp_name', $firstName)
                    ->orWhere('emp_mname', $middleName)
                    ->orWhere('emp_lname', $lastName);
            })
            ->select('emp_id', 'emp_name', 'emp_mname', 'emp_lname')
            ->first();
        $ReportingfinalEmpId =  $getDetails ?  $getDetails->emp_id : '';
        $ReportingfinalFullName =  $getDetails ?  $getDetails->emp_name . ' ' . $getDetails->emp_mname . ' ' . $getDetails->emp_lname  : '';


        return [$genderId, $maritalId, $religionId, $castCategoryId, $bloodGroupId, $govtDocTypeId, $branchId, $departmentId, $designationId, $employeeTypeId, $masterPolicyEndGameTypeId, $attendanceMethodId, $policyShiftTypeId, $assignShiftType, $activeEmployeeId, $ReportingfinalEmpId, $ReportingfinalFullName];
    }
    // $contractualType Only
    public static function getImportAllContentP2($BID, $GenderName, $MaritalType, $ReligionType, $CastCategoryType, $BloodGroupType, $GovtDocType, $BranchFind, $DepartmentFind, $DesignationFind, $EmployeeType, $contractualType, $MasterPolicyEndGameType, $AttendanceMethod, $PolicyShiftType, $ActiveEmployee, $countries, $empID, $mobileNo, $email, $reportingName)
    {
        $genderType = StaticEmployeeJoinGenderType::where('gender_type', '=', $GenderName)
            ->select('id')
            ->first();
        $maritalType = StaticEmployeeJoinMaritalType::where('marital_type', '=', $MaritalType)
            ->select('id')
            ->first();
        $religionType = StaticEmployeeJoinReligion::where('religion_name', '=', $ReligionType)
            ->select('id')
            ->first();
        $castCategoryType = StaticEmployeeJoinCategoryCaste::where('caste_category', $CastCategoryType)
            ->select('id')
            ->first();
        $bloodGroupType = StaticEmployeeJoinBloodGroup::where('blood_group', $BloodGroupType)
            ->select('id')
            ->first();
        $govtDocType = StaticEmployeeJoinGovtDocType::where('govt_type', $GovtDocType)
            ->select('id')
            ->first();
        $branchFind = BranchList::where('business_id', $BID)
            ->where('branch_name', $BranchFind)
            ->select('branch_id')
            ->first();
        $departmentFind = DepartmentList::where('b_id', $BID)
            ->where('depart_name', $DepartmentFind)
            ->select('depart_id')
            ->first();
        $designationFind = DesignationList::where('business_id', $BID)
            ->where('desig_name', $DesignationFind)
            ->select('desig_id')
            ->first();
        $employeeType = StaticEmployeeJoinEmpType::where('emp_type', $EmployeeType)
            ->select('type_id')
            ->first();
        $contractualType = StaticEmployeeJoinContractualType::where('contractual_type', $contractualType)
            ->select('id')
            ->first();
        $attendanceMethod = StaticAttendanceMethod::where('method_name', $AttendanceMethod)
            ->select('id')
            ->first();
        $policyShiftType = PolicyAttendanceShiftSetting::where('business_id', $BID)
            ->where('shift_type_name', $PolicyShiftType)
            ->select('id')
            ->first();
        $ShiftType = PolicyAttendanceShiftSetting::where('business_id', $BID)
            ->where('id', $policyShiftType->id)
            ->select('shift_type')
            ->first();
        $activeEmployee = StaticEmployeeJoinActiveType::where('name', $ActiveEmployee)
            ->select('id')
            ->first();
        $masterPolicyEndGameType = PolicyMasterEndgameMethod::where('business_id', $BID)
            ->where('method_name', $MasterPolicyEndGameType)
            ->select('id')
            ->first();

        $countrie = self::removeSpaces($countries);
        $AllCountry = StaticCountryModel::where('name', '=', $countrie)
            ->select('phonecode')
            ->first();
        $firstLoad = LoginEmployee::where('emp_id', $empID)
            ->where('business_id', $BID)
            ->first();

        if ($activeEmployee->id != 0) {
            if (isset($firstLoad)) {
                LoginEmployee::where('emp_id', $empID)
                    ->where('business_id', $BID)
                    ->update([
                        'emp_id' => $empID,
                        'business_id' => $BID,
                        'email' => $email,
                        'phone' => $mobileNo,
                        'country_code' => $AllCountry->phonecode,
                    ]);
            }
            if (!isset($firstLoad)) {
                LoginEmployee::where('emp_id', $empID)
                    ->where('business_id', $BID)
                    ->insert([
                        'emp_id' => $empID,
                        'business_id' => $BID,
                        'email' => $email,
                        'phone' => $mobileNo,
                        'country_code' => $AllCountry->phonecode,
                    ]);
            }
        }

        $genderId = $genderType ? $genderType->id : 0;
        $maritalId = $maritalType ? $maritalType->id : 0;
        $religionId = $religionType ? $religionType->id : 0;
        $castCategoryId = $castCategoryType ? $castCategoryType->id : 0;
        $bloodGroupId = $bloodGroupType ? $bloodGroupType->id : 0;
        $govtDocTypeId = $govtDocType ? $govtDocType->id : 0;
        $branchId = $branchFind ? $branchFind->branch_id : 0;
        $departmentId = $departmentFind ? $departmentFind->depart_id : 0;
        $designationId = $designationFind ? $designationFind->desig_id : 0;
        $employeeTypeId = $employeeType ? $employeeType->type_id : 0;
        $contractualTypeId = $contractualType ? $contractualType->id : 0;
        $attendanceMethodId = $attendanceMethod ? $attendanceMethod->id : 0;
        $policyShiftTypeId = $policyShiftType ? $policyShiftType->id : 0;
        $assignShiftType = $ShiftType ? $ShiftType->shift_type : 0;
        $activeEmployeeId = $activeEmployee ? $activeEmployee->id : 0;
        $masterPolicyEndGameTypeId = $masterPolicyEndGameType ? $masterPolicyEndGameType->id : 0;

        // Split the full name into an array of parts
        $nameParts = explode(" ", $reportingName);

        // Initialize variables for first, middle, and last names
        $firstName = $nameParts[0]; // First name is the first element
        $lastName = end($nameParts); // Last name is the last element
        // Middle name is everything between first and last names
        // Use array_slice to get elements between the first and last names, then implode them back into a string
        $middleName = implode(" ", array_slice($nameParts, 1, -1));

        $getDetails = EmployeePersonalDetail::where('business_id', $BID)
            ->where(function ($query) use ($firstName, $lastName, $middleName) {
                $query->where('emp_name', $firstName)
                    ->orWhere('emp_mname', $middleName)
                    ->orWhere('emp_lname', $lastName);
            })
            ->select('emp_id', 'emp_name', 'emp_mname', 'emp_lname')
            ->first();
        $ReportingfinalEmpId =  $getDetails ?  $getDetails->emp_id : '';
        $ReportingfinalFullName =  $getDetails ?  $getDetails->emp_name . ' ' . $getDetails->emp_mname . ' ' . $getDetails->emp_lname  : '';

        return [$genderId, $maritalId, $religionId, $castCategoryId, $bloodGroupId, $govtDocTypeId, $branchId, $departmentId, $designationId, $employeeTypeId, $contractualTypeId, $masterPolicyEndGameTypeId, $attendanceMethodId, $policyShiftTypeId, $assignShiftType, $activeEmployeeId, $ReportingfinalEmpId, $ReportingfinalFullName];
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
    public static function removeSpaces($string)
    {
        return str_replace(' ', '', $string);
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
    // Management employee side section STEP 1
    static function StaticModelActive($attendanceMethodID, $attendanceModeID, $shiftType)
    {
        $AttendanceName = StaticAttendanceMethod::where('id', $attendanceMethodID)
            ->select('method_name')
            ->first();
        $AttendanceMode = StaticAttendanceMode::where('id', $attendanceModeID)
            ->select('mode_name')
            ->first();
        $ShiftType = StaticAttendanceShiftType::where('id', $shiftType)
            ->select('name as shift_type')
            ->first();
        if ($AttendanceName != null || $AttendanceMode != null || $ShiftType != null) {
            return [$AttendanceName, $AttendanceMode, $ShiftType];
        } else {
            return ['', '', ''];
        }
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
            ->join('policy_setting_role_assign_permission', 'policy_setting_role_assign_permission.role_id', '=', 'policy_setting_role_create.id')
            ->where('policy_setting_role_create.business_id', self::allValueGet()[5])
            ->select('policy_setting_role_create.*')
            ->distinct('policy_setting_role_create.id')
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
    // Subscription Mode Plans
    static function GetSubscriptionMode($type)
    {
        // $currentDate = now();
        $currentDate = Carbon::now();
        $mytime = Carbon::now();
        switch ($type) {
            case 1:
                $firstDayOfNextMonth1 = \Carbon\Carbon::parse($currentDate)
                    ->addMonths()
                    ->day($mytime->day);
                $previousDay1 = $firstDayOfNextMonth1->copy()->subDay();

                $dates = [
                    'start' => $mytime->toDateString(), // Start from the current date
                    'final' => $previousDay1->toDateString(),
                    'reminder' => $firstDayOfNextMonth1->toDateString(),
                ];
                return [$type, $dates];
            case 3:
                $firstDayOfNextMonth2 = \Carbon\Carbon::parse($currentDate)
                    ->addMonths(3) //2
                    ->day($mytime->day);
                $previousDay2 = $firstDayOfNextMonth2->copy()->subDay();
                $dates = [
                    'start' => $mytime->toDateString(), // Start from the current date
                    'final' => $previousDay2->toDateString(),
                    'reminder' => $firstDayOfNextMonth2->toDateString(),
                ];
                return [$type, $dates];

            case 6:
                $firstDayOfNextMonth3 = \Carbon\Carbon::parse($currentDate)
                    ->addMonths(5)
                    ->day($mytime->day); // Gives 2016-04-25
                $previousDay3 = $firstDayOfNextMonth3->copy()->subDay();
                $dates = [
                    'start' => $mytime->toDateString(), // Start from the current date
                    'final' => $previousDay3->toDateString(),
                    'reminder' => $firstDayOfNextMonth3->toDateString(),
                ];
                return [$type, $dates];
            case 12:
                $firstDayOfNextMonth = \Carbon\Carbon::parse($currentDate)
                    ->addMonths(11)
                    ->day($mytime->day); // Gives 2016-07-25
                // Calculate the first day of the next year
                // $firstDayOfNextMonth = $mytime->copy()->addMonths(11)->startOfYear();

                $previousDay4 = $firstDayOfNextMonth->copy()->subDay();
                $dates = [
                    'start' => $mytime->toDateString(), // Start from the current date
                    'final' => $previousDay4->toDateString(),
                    'reminder' => $firstDayOfNextMonth->toDateString(),
                ];
                return [$type, $dates];

            default:
                // Handle other cases or set a default type
                return [0, null];
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

    static function LeaveManagementProviderValue($statuses)
    {
        $comp_off = 0.0;

        if ($statuses !== null) {
            $arrayPresent = [1, 3, 9, 12]; // Present
            $arrayHalfDay = [8]; // Half Day

            $comp_off = (float) in_array($statuses, $arrayPresent) ? 1.0 : (in_array($statuses, $arrayHalfDay) ? 0.5 : 0.0);

            // Return the computed values
            return [$comp_off, 0, 0, 0, 0];
        } else {
            return [0, 0, 0, 0, 0];
        }
    }

    static function LeaveManagementProviderDynamicTable($leave_type, $BID, $empID, $specialCase)
    {
        $business = $BID;
        $openingBalance = number_format(0.0, 2); // Initialize with a floating-point value
        $leaveAllotted = number_format(0.0, 2);
        $leaveTaken = number_format(0.0, 2);
        $leaveRemaining = number_format(0.0, 2);

        // case if 8 or 9 special set in leave type lwp or compo off
        if ($leave_type != 8 && $leave_type != 9 && $leave_type != null && $empID != null && $business != null) {
            $emp = EmployeePersonalDetail::where('emp_id', $empID)
                ->where('business_id', $business)
                ->where('active_emp', 1)
                ->first();

            $getData = PolicySettingLeavePolicy::leftJoin('policy_master_endgame_method', 'policy_setting_leave_policy.id', '=', 'policy_master_endgame_method.leave_policy_ids_list')
                ->where('policy_master_endgame_method.method_switch', 1)
                ->where('policy_setting_leave_policy.business_id', $business)
                ->select('policy_setting_leave_policy.*')
                ->first();

            if ($getData != null) {
                $Item = PolicySettingLeaveCategory::leftJoin('static_leave_category', 'policy_setting_leave_category.category_name', '=', 'static_leave_category.id')
                    ->leftJoin('static_leave_category_applicable_to', 'policy_setting_leave_category.applicable_to', '=', 'static_leave_category_applicable_to.id')
                    ->where('leave_policy_id', $getData->id)
                    ->where('policy_setting_leave_category.business_id', $business)
                    ->where('policy_setting_leave_category.category_name', $leave_type)
                    ->select('policy_setting_leave_category.*', 'static_leave_category.name as apply_category_name', 'static_leave_category_applicable_to.name as applicable_name')
                    ->first();

                $applyLeaveRequests = RequestLeaveList::where('business_id', $business)
                    ->where('emp_id', $emp->emp_id)
                    ->where('leave_category', $leave_type)
                    ->get();

                // Calculate the start and end dates for the previous year
                $previousYearStart = Carbon::now()
                    ->subYear()
                    ->startOfYear();
                $previousYearEnd = Carbon::now()
                    ->subYear()
                    ->endOfYear();
                // Parse leave cycle dates
                $cycleLimitFrom = Carbon::parse($getData->leave_period_from);
                $cycleLimitTo = Carbon::parse($getData->leave_period_to);

                $currentMonthStart = Carbon::now()->startOfMonth();
                $currentMonthEnd = Carbon::now()->endOfMonth();

                // Adjust current month range if it's within the leave cycle bounds
                if ($currentMonthStart < $cycleLimitFrom) {
                    $currentMonthStart = $cycleLimitFrom;
                }

                if ($currentMonthEnd > $cycleLimitTo) {
                    $currentMonthEnd = $cycleLimitTo;
                }

                $currentYear = Carbon::now()->year;

                // Fetch leave requests using Eloquent where clause for specific conditions
                $leaveRequests = $applyLeaveRequests
                    ->where('emp_id', $empID)
                    ->where('leave_category', $Item->category_name)
                    ->whereIn('final_status', [1, 0]);

                // Filter the collection to get leave requests within the current month and year
                $filteredRequests = $leaveRequests->filter(function ($request) use ($currentYear, $currentMonthStart, $currentMonthEnd) {
                    $fromDate = Carbon::parse($request->from_date);
                    return $fromDate->year === $currentYear && $fromDate->between($currentMonthStart, $currentMonthEnd);
                });

                $openingBalance = $applyLeaveRequests
                    ->where('leave_category', $Item->category_name)
                    ->where('emp_id', $empID)
                    ->filter(function ($request) use ($previousYearStart, $previousYearEnd) {
                        $requestDate = Carbon::parse($request->from_date);
                        return $requestDate->between($previousYearStart, $previousYearEnd);
                    })
                    ->sum('days');
                $leaveAllotted = $Item->days;

                // Sum the 'days' attribute of the filtered requests
                $leaveTaken = $filteredRequests->sum('days');

                $leaveRemainingPoiniting = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                $leaveRemaining = $leaveRemainingPoiniting < 0 ? 0 : $leaveRemainingPoiniting;

                return [number_format($openingBalance, 2), number_format($leaveAllotted, 2), number_format($leaveTaken, 2), number_format($leaveRemaining, 2)];
            }
        }
        if ($specialCase != null && $empID != null) {
            return [number_format($openingBalance, 2), number_format($leaveAllotted, 2), number_format($leaveTaken, 2), number_format($leaveRemaining, 2)];
            // return [0.00, 0.00, 0.00, 0.00];
        } else {
            return [0.0, 0.0, 0.0, 0.0];
        }
    }

    // Attendance Comp-off Set QA Activate
    static function AttendaceCompOffSet($empID, $BID, $dates, $primaryID)
    {
        // strtotime('2023-10-31')
        // now()->toDateString()strtotime($date)
        $date = date('Y-m-d', strtotime($dates)); //2023-10-31 2023-12-11 2023-12-23 Saturday
        // $date = now()->toDateString();
        $leavel_type = 8; //Comp_off
        // '2023-02-22'
        $loaded = PolicyCompOffLwopLeave::where('business_id', $BID)
            ->where('switch', 1)
            ->where('holiday_weekly_checked', 1)
            ->first();
        if ($loaded != null) {
            if ($loaded->switch != 0) {
                //ON Case
                // now()->toDateString()
                $root = AttendanceHolidayList::where('business_id', $BID)
                    ->whereDate('holiday_date', '=', $date)
                    ->first();
                $attendanceData = AttendanceList::where('business_id', $BID)
                    ->where('id', $primaryID)
                    ->where('emp_id', $empID)
                    ->whereDate('punch_date', $date)
                    ->first();
                if ($root != null && $attendanceData != null) {
                    //comp-off today checking and holiday checking
                    // $getData = EmployeePersonalDetail::where('business_id', $BID)->whereIn('emp_id',  $attendanceData->pluck('emp_id')->toArray())->get();
                    // $getLoad = AttendanceList::where('business_id', $BID)->whereDate('punch_date', '=', $date)->where('emp_id', $getData->pluck('emp_id')->get())->get();

                    // if($attendanceData->today_status)
                    // $empIds = $attendanceData->pluck('emp_id')->toArray();
                    // $getData = EmployeePersonalDetail::where('business_id', $BID)->where('emp_id', $empID)->where('active_emp', 1)->first();

                    // $getLoad = AttendanceList::where('business_id', $BID)
                    //     ->whereDate('punch_date', $date)
                    //     ->whereIn('emp_id', $getData->pluck('emp_id')->toArray())
                    //     ->where('today_status', '<>', 2)
                    //     ->where('comp_off_active', '<>', 0)
                    //     ->select('comp_off_active', 'comp_off_value_get', 'emp_id', 'punch_date', 'today_status')
                    //     ->get();
                    // $CompOffBalanceData = [];
                    // // foreach ($getLoad as $attendancePow) {
                    // $CompOffBalanceData = [
                    //     // 'today_status' => 8,
                    //     // 'emp_id' => $getData->emp_id,
                    //     'leave_type_category' => 8,
                    //     'comp_off_active' => 1,
                    //     'comp_off_value_get' => 1, // self::LeaveManagementProviderValue($attendanceData->today_status)[0] // $attendancePow->comp_off_value_get,
                    // ];
                    // AttendanceList::where('id', $primaryID)->where('business_id', $BID)->where('punch_date', '=', $date)->where('emp_id', $attendanceData->emp_id)->update($CompOffBalanceData);
                    //     // print_r($CompOffBalanceData);
                    // }
                    // AttendanceList
                    // EmployeeLeaveBalance::insert($leaveBalanceData);

                    // AttendanceList::where('business_id', $BID)->where('punch_date', $date)->where('emp_id', '=', $attendanceData->emp_id)->update($CompOffBalanceData);
                    return [$leavel_type, 1, 1]; //true then allotted comp-off(8) 1 count['leave_type','activecheck','value_allotted']
                } else {
                    return [0, 0, 0];
                }

                // dd($CompOffBalanceData);
                return [0, 0, 0];
            }
        } else {
            return [0, 0, 0];
        }
    }

    // Automatic Comp-Off allotted as any Employee Comp-off-allotted Generate update in DB Directly with auto correct with punchdate
    static function CompOffAllotted($EmpID, $BID)
    {
        $totalOvertimeMinutes = 0;
        $compOffAllocated = 0;
        $overtimeData = [];
        $previousRemainingSum = 0; // Initialize previous remaining sum
        $count = 0;
        $attendanceList = AttendanceList::where('emp_id', $EmpID)->where('business_id', $BID)->select('id', 'overtime')->get();
        $loaded = PolicyCompOffLwopLeave::where('business_id', $BID)
            ->where('switch', 1)->first();
        if ($loaded->switch != 0 && $loaded->overtime_hr != 0 && $loaded->overtime_checked != 0) {
            foreach ($attendanceList as $item) {
                if (!empty($item->overtime)) {
                    $overtimeMinutes = $item->overtime;
                    $overtimeAllotted = $loaded->overtime_hr * 60; //minutes

                    $totalOvertimeMinutes = ($totalOvertimeMinutes >= $overtimeAllotted && $count == 1 ? 0 : $totalOvertimeMinutes)  + $overtimeMinutes + ($totalOvertimeMinutes >= $overtimeAllotted && $count == 0 ? 0 : $previousRemainingSum);

                    $compOffAllocated = ($totalOvertimeMinutes >= $overtimeAllotted) ? 1 : 0;

                    $remainingOvertime = ($totalOvertimeMinutes >= $overtimeAllotted) ? ($totalOvertimeMinutes % $overtimeAllotted) : 0;

                    $COMPFFALLOTTED = ($totalOvertimeMinutes >= $overtimeAllotted && $count != 1) ? 1 : 0;
                    $count = $COMPFFALLOTTED;

                    $remainingSum = ($compOffAllocated == 0) ? $remainingOvertime : ($previousRemainingSum + $remainingOvertime);

                    $overtimeData[] = [
                        'id' => $item->id,
                        'comp_off_overtime_sum' => $totalOvertimeMinutes,
                        'comp_off_overtime_value_get' => $compOffAllocated,
                        'comp_off_overtime_remaining' => $remainingSum,
                    ];

                    $previousRemainingSum = $remainingSum;
                }
            }

            // Batch update the records
            foreach ($overtimeData as $data) {
                AttendanceList::where('business_id', $BID)->where('comp_off_active', '<>', 1)->where('emp_id', $EmpID)->where('id', $data['id'])->update([
                    'comp_off_overtime_sum' => $data['comp_off_overtime_sum'],
                    'comp_off_overtime_value_get' => $data['comp_off_overtime_value_get'],
                    'comp_off_overtime_remaining' => $data['comp_off_overtime_remaining'],
                    'comp_off_active' => ($data['comp_off_overtime_value_get'] != 0) ? 1 : 0,
                ]);
            }
            return true;
        } else {
            return false;
        }
    }


    //Clone-EmployeeLeaveDetails with central_uril
    public static function getEmpLeaveDetails($empID, $Date, $BIDs)
    {
        $bID = $BIDs;
        $leave = DB::table('request_leave_list')
            ->join('static_leave_category', 'request_leave_list.leave_category', '=', 'static_leave_category.id')
            ->where('request_leave_list.emp_id', $empID)->where('request_leave_list.from_date', '<=', $Date)
            ->whereDate('request_leave_list.to_date', '>=', $Date)
            ->where('request_leave_list.business_id', $BIDs)
            ->first();
        return $leave;
    }

    //Clone-EmployeeLeaveDetails with central_uril
    static function getAttendanceSummaryDetaisl($Emp, $BIDs)
    {

        $bID = $BIDs;
        $employee = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', $bID)
            ->where('employee_personal_details.emp_id', $Emp['emp_id'])
            ->select('emp_date_of_joining', 'master_endgame_id', 'emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();

        $shift_policy = $employee->shift_settings_ids_list;
        $leave_policy = $employee->leave_policy_ids_list;


        $attendanceList = DB::table('attendance_list')->where('business_id', $bID)->where($Emp)->first();
        $Status = $attendanceList->today_status ?? 2;


        $shiftStart = $attendanceList->applied_shift_comp_start_time ?? false;
        $shiftEnd = $attendanceList->applied_shift_comp_end_time ?? false;

        if (!isset($attendanceList) && $employee->method_switch == 1) {
            $leaveList = DB::table('request_leave_list')->where('business_id', $bID)->where('emp_id', $Emp['emp_id'])->whereDate('from_date', '<=', $Emp['punch_date'])
                ->whereDate('to_date', '>=', $Emp['punch_date'])->where('final_status', 1)->first();
            if (isset($leaveList)) {
                $Status = 10;
            } else {

                // $isTodayHoliday = PolicyHolidayDetail::where(['business_id' => $bID, 'holiday_date' => $Emp['punch_date'], 'template_id' => $holiday_policy,])->first();
                $holidays = DB::table('attendance_holiday_list')->where('business_id', $bID)->where('master_end_method_id', $employee->master_endgame_id)->where('holiday_date', $Emp['punch_date'])->first();


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

    //Clone-EmployeeLeaveDetails with central_uril
    static function calculateLeaveCountApi($EmpID, $LeaveCategory, $month, $year, $businessID)
    {

        $leaveData = [
            'opening' => '0',
            'alloted' => '0',
            'used' => '0',
            'remaining' => '0',
        ];
        $detailsList = self::checkingCurrentLeaveBalanceList($EmpID, $businessID);
        // dd($Data);
        $Data = $detailsList['leave_status_list'];
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
    //Create or Implementation By JAYANT at underprocess
    //Clone-EmployeeLeaveDetails with Central_uril
    static function checkingCurrentLeaveBalanceList($empId, $BIDs)
    {

        $business = $BIDs; //Session::get('business_id');
        $emp = EmployeePersonalDetail::where('emp_id', $empId)
            ->where('business_id', $business)
            ->first();
        $data = [];
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
                // RequestLeaveList::where('leave_category', 7)->update([
                //     'leave_allotted'=>15
                // ]);

                $DOJ = Carbon::parse($emp->emp_date_of_joining);


                // CarbonPeriod
                foreach ($Item as $key => $requests) {

                    // Calculate the start and end dates for the previous year
                    $previousYearStart = Carbon::now()
                        ->subYear()
                        ->startOfYear();
                    $previousYearEnd = Carbon::now()
                        ->subYear()
                        ->endOfYear();

                    // previous mode
                    $previousLeaveRemaining = $applyLeaveRequests
                        ->where('leave_category', $requests->category_name)
                        ->where('final_status', '<>', 2) //equalNot
                        ->filter(function ($request) use ($previousYearStart, $previousYearEnd) {
                            $requestDate = Carbon::parse($request->from_date);
                            return $requestDate->between($previousYearStart, $previousYearEnd);
                        })
                        ->sum('leave_remaining'); //days

                    $checkingMonthlyWorkingLeaveSet = $requests->leave_cycle_monthly_yearly;
                    $openingCaseHandling = $requests->category_name; //all leave policy type standar. str. add new


                    $monthsCount = 0;
                    $leaveAllotted = 0.00;
                    $leaveTaken = 0.00;
                    $leaveRemaining = 0.00;

                    // sensitive
                    $cycleLimitFrom = Carbon::parse($getData->leave_period_from); //$getData->leave_period_from
                    $cycleLimitTo = Carbon::parse($getData->leave_period_to); //$getData->leave_period_to


                    // Rendar cycle process
                    for ($date = $cycleLimitFrom; $date->lessThanOrEqualTo($cycleLimitTo); $date->addMonth()) {
                        $month = $date->month;
                        $year = $date->year;

                        if ($year < $currentYear || ($year === $currentYear && $month <= $currentMonth)) {
                            $monthsCount++;

                            // Current mode request list some time's pass Case Stable
                            $leaveTaken = RequestLeaveList::where('business_id', $business)
                                ->where('emp_id', $empId)
                                ->where('leave_category', $requests->category_name)
                                ->where('final_status', '<>', 2) // Filter out requests with final_status not equal to 2
                                ->where(function ($query) use ($DOJ, $currentYear, $currentMonth) {
                                    // Compare the from_date month and year with the DOJ month and year
                                    $query->where(function ($subQuery) use ($DOJ) {
                                        $subQuery->whereYear('from_date', '>', $DOJ->year)
                                            ->orWhere(function ($q) use ($DOJ) {
                                                $q->whereYear('from_date', $DOJ->year)
                                                    ->whereMonth('from_date', '>=', $DOJ->month);
                                            });
                                    });
                                    // ->where(function ($subQuery) use ($currentYear, $currentMonth) {
                                    //     // Exclude requests from future months
                                    //     $subQuery->whereYear('from_date', '<', $currentYear)
                                    //         ->orWhere(function ($q) use ($currentYear, $currentMonth) {
                                    //             $q->whereYear('from_date', $currentYear)
                                    //                 ->whereMonth('from_date', '<=', $currentMonth);
                                    //         })
                                    // });
                                })
                                ->sum('leave_summary_debit_value');

                            // Gender Restriction with category Show Hide
                            if (($emp->emp_gender === 1 || $emp->emp_gender === 3) && $requests->category_name === 4) {
                                //Restriction Paternity leave (PL)
                                continue; // Skip if the employee is male and the category is not maternity
                            }
                            if ($emp->emp_gender === 2 && $requests->category_name === 5) {
                                //Restriction Maternity leave (ML)
                                continue; // Skip if the employee is female and the category is not paternity
                            }


                            //monthly working leave
                            // monthly getloading ++ inc. but Year sum hold yearly not sum incre. inc.
                            if ($checkingMonthlyWorkingLeaveSet == 1) { //specialization hendler case for monthly working leave

                                switch ($openingCaseHandling) {
                                    case 1: //CL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveRemaining;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) { //Lapse
                                            $leaveAllotted = $requests->days;
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                        break;
                                        // dd($checkingMonthlyWorkingLeaveSet   );
                                        // Unused Leave Rule Set Show Restriction
                                    case 2: //SL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working

                                            $openingBalance =  $previousLeaveRemaining;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                        break;
                                    case 3: //EL

                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working

                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                    case 4:
                                        //Mater.L
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working

                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 5:
                                        //PL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 6:
                                        //MarriageL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working

                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 7:
                                        //BL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $leaveAllotted += $requests->days; //Monthly Checking Carry Forward or monthly on then running working
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                }
                            }

                            //yearly working leave
                            if ($checkingMonthlyWorkingLeaveSet == 2) {
                                $leaveAllotted = $requests->days;

                                //specialization hendler case for yearly working leave
                                switch ($openingCaseHandling) {
                                    case 1: //CL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward

                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                        break;
                                    case 2: //SL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                        break;
                                    case 3: //EL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }

                                    case 4:
                                        //ML
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 5:
                                        //PL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 6:
                                        //MarriageL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                    case 7:
                                        //BearmentL
                                        $ruleType = $requests->unused_leave_rule;

                                        if ($ruleType === 2) { //Carry Forward
                                            $openingBalance = $previousLeaveRemaining; //$leaveAllotted - $previousLeaveTaken;
                                            $leaveRemaining = $openingBalance != null && $openingBalance != 0 ? $openingBalance + ($leaveAllotted - $leaveTaken) : $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                            // Apply carry forward limit logic to the opening balance
                                        }
                                        if ($ruleType === 1) {
                                            $leaveAllotted = $requests->days;
                                            //Lapse
                                            // Lapse set logic (if needed)
                                            $openingBalance = 0;
                                            $leaveRemaining = $leaveAllotted - $leaveTaken;
                                            $StoreModel = [$openingBalance, $leaveAllotted, $leaveTaken, $leaveRemaining, $checkingMonthlyWorkingLeaveSet];
                                        }
                                        break;
                                }
                            }

                            // 'information' => $Item->where('category_name', $requests->category_name)->first(),
                            $LoadPolicyCase[$key] = [
                                'current_month' => $monthsCount,
                                'checking_monthly_yearly' => $StoreModel[4],
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
                                'leave_remaining' => ($StoreModel[3] > 0) ? $StoreModel[3] : 0, //if negative value show as zero
                            ];
                            // Push the data for this leave type into $LoadPolicyCase
                            // $LoadPolicyCase[] = $leaveTypeData;
                        }
                    }
                }
                // Policy Applied Comp-Off & LWP Policy at Rule IN switch ON/OFF
                $checkingLWPCountAndSelectOnOff = PolicyCompOffLwopLeave::where('business_id', $business)->first();
                $totalHourlyOvertimeAppliedCount = 0;

                if (($checkingLWPCountAndSelectOnOff->switch != 0) && ($checkingLWPCountAndSelectOnOff->holiday_weekly_checked != 0) &&  ($checkingLWPCountAndSelectOnOff->lwop_leave_checked != 0) && ($checkingLWPCountAndSelectOnOff->expiry_point != 0)) //policyChecking IN switch ON/OFF
                {
                    $CompOffValue =  AttendanceList::where('business_id', $business)
                        ->where('emp_id', $empId)
                        ->where('leave_type_category', 8) //checked Comp-Off
                        ->where('comp_off_active', 1) //active
                        ->sum('comp_off_value_get');
                    // ->select(DB::raw('CAST(SUM(comp_off_value_get) AS decimal(10,2)) as total_compoff_value'))
                    $listItems = AttendanceList::where('emp_id', $empId)
                        ->where('business_id', $business)
                        ->where('comp_off_active', 1)
                        ->where('comp_off_overtime_value_get', 1)
                        ->get();

                    $totalSumHourlyCompOff = AttendanceList::where('emp_id', $empId)
                        ->where('business_id', $business)
                        ->where('comp_off_active', 1)
                        ->where('comp_off_overtime_value_get', 1)
                        ->sum('comp_off_overtime_value_get');
                    $totalSumCompOffBoth = $totalSumHourlyCompOff + $CompOffValue;
                    foreach ($listItems as $item) {
                        // Calculate the expiration date
                        $expirationDate = Carbon::parse($item->punch_date)->addDays($checkingLWPCountAndSelectOnOff->expiry_point)->format('Y-m-d');
                        // print_r('<br>' .  $item->punch_date . ' ' . $expirationDate . ' ' . $item->comp_off_overtime_value_get);

                        // Create Carbon instances for the current date and the provided date
                        $currentDate = Carbon::now(); //parse("2023-12-19");
                        $providedDate = Carbon::createFromFormat('Y-m-d', $expirationDate);

                        // Check if the provided date is before the current date
                        if ($providedDate->isBefore($currentDate)) {
                            $totalSumCompOffBoth -= 1;
                            // echo $dateString . ' is before the current date.' .     $totalSumHourlyCompOff;
                        }
                    }

                    // // Ensure the total overtime is not negative
                    $totalHourlyOvertimeAppliedCount = max($totalSumHourlyCompOff, 0);

                    // Current mode request list some time's pass Case Stable
                    $CompOffleaveTakenDebitValue = RequestLeaveList::where('business_id', $business)
                        ->where('emp_id', $empId)
                        ->where('leave_category', 8)
                        ->where('final_status', '<>', 2) // Filter out requests with final_status not equal to 2
                        ->where(function ($query) use ($DOJ, $currentYear, $currentMonth) {
                            // Compare the from_date month and year with the DOJ month and year
                            $query->where(function ($subQuery) use ($DOJ) {
                                $subQuery->whereYear('from_date', '>', $DOJ->year)
                                    ->orWhere(function ($q) use ($DOJ) {
                                        $q->whereYear('from_date', $DOJ->year)
                                            ->whereMonth('from_date', '>=', $DOJ->month);
                                    });
                            });
                        })
                        ->sum('leave_summary_debit_value');

                    $CompOffOpeningBalance = 0;
                    $CompOffleaveTaken = $CompOffleaveTakenDebitValue;
                    $CompOffleaveAllotted = $totalHourlyOvertimeAppliedCount; //weekl or holiday + overtime count hour or minute
                    $leaveRemaining = $CompOffleaveAllotted - $CompOffleaveTaken;
                    $StoreModel = [$CompOffOpeningBalance, $CompOffleaveAllotted, $CompOffleaveTaken, $leaveRemaining];

                    // LWP Mode Sum Count
                    // Filter out requests with final_status not equal to 2
                    $sumOfUnpaidLeave = RequestLeaveList::where('business_id', $business)
                        ->where('emp_id', $empId)
                        ->where('final_status', '<>', 2)
                        ->select(DB::raw('CAST(SUM(leave_summary_unpaid_value) AS decimal(10,2)) as total_unpaid_leave'))
                        ->value('total_unpaid_leave');

                    $LWPAdding = [
                        'current_month' => 0,
                        'checking_monthly_yearly' => 0,
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
                        'leave_taken' => $sumOfUnpaidLeave,
                        'leave_remaining' => 0,
                    ];

                    $CompOFFAdding = [
                        'current_month' => 0,
                        'checking_monthly_yearly' => 0,
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
                        'leave_opening' => $StoreModel[0],
                        'leave_allotted' => $StoreModel[1],
                        'leave_taken' => $StoreModel[2],
                        'leave_remaining' => ($StoreModel[3] > 0) ? $StoreModel[3] : 0, //if negative value show as zero
                    ];
                    // add external : LWP or Comp OFF  //LWP Mode Sum Count
                    $externalData = [
                        $LWPAdding, $CompOFFAdding
                    ];

                    $data = array_merge($LoadPolicyCase, $externalData);
                } else {

                    $data = array_merge($LoadPolicyCase);
                }
                return ['emp_id' => $empId, 'doj' => $emp->emp_date_of_joining, 'start_date' => $getData->leave_period_from, 'end_date' => $getData->leave_period_to, 'leave_status_list' => $data, 'status' => true, 'case' => 1];
            } else {
                // return [];
                return  ['emp_id' => '', 'doj' => '', 'start_date' => '', 'end_date' => '', 'leave_status_list' => [], 'status' => false, 'case' => 2];
            }
        }
    }
    static function UploadReport()
    {
        // balance report overall data; ab tak
        // leave month allotted report
        // leave taken or used report
        // pending leave report
        // Comp-off report

        // Mode checking updated
        // AttendanceList::where('business_id', self::allValueGet()[5])->where('comp_off_active', 1)->update([
        //     'leave_type' => 8
        // ]);

        // $rooted = EmployeeLeaveBalance::where('business_id', Session::get('business_id'))->get();
        $today = Carbon::parse('2024-1-12');

        // Carbon::now();
        // $lastDayOfMonth = Carbon::parse('2023-10-12'); // ->endOfMonth();
        $businessId = Session::get('business_id');
        $getData = AttendanceList::where('business_id', $businessId)
            ->where('comp_off_active', 1)
            ->whereYear('punch_date', $today->year)
            ->whereMonth('punch_date', $today->month)
            ->get();

        $modeActive = EmployeeLeaveBalance::where('business_id')
            ->whereYear('range_date', $today->year)
            // ->whereMonth('range_date', $today->month)
            ->first();
        $leaveBalanceData = [];
        if ($modeActive != null) {
            // updated case
        } else {
            // insert case
            $empDetails = EmployeePersonalDetail::where('business_id', $businessId)
                ->select('emp_id')
                ->get();
            foreach ($empDetails as $emp) {
                $empDetailsId = AttendanceList::where('business_id', $businessId)
                    ->whereYear('punch_date', $today->year)
                    ->whereMonth('punch_date', $today->month)
                    ->where('emp_id', $emp->emp_id)
                    ->where('comp_off_active', 1)
                    ->first();
                $leaveType = $empDetailsId->leave_type ?? 0;
                $TotalLeavePerMonth = AttendanceHolidayList::where('business_id', $businessId)
                    ->whereYear('holiday_date', $today->year)
                    ->whereMonth('holiday_date', $today->month)
                    ->where('master_end_method_id', 260)
                    ->count();
                $statusCheckingReload = RequestLeaveList::where('business_id', $businessId)
                    ->where('emp_id', $emp->emp_id)
                    ->where('leave_category', 8)
                    ->select('days')
                    ->count();
                $leave_allotted = AttendanceList::where('business_id', $businessId)
                    ->whereYear('punch_date', $today->year)
                    ->whereMonth('punch_date', $today->month)
                    ->where('comp_off_active', 1)
                    ->where('emp_id', $emp->emp_id)
                    ->count();

                $leaveCountRequestSET = RequestLeaveList::where('business_id', $businessId)
                    ->where('emp_id', $emp->emp_id)
                    ->where('leave_category', 8)
                    ->whereIn('final_status', [0, 1])
                    ->first();

                $leaveTakenCount = floatval($leaveCountRequestSET->days ?? 0);
                $leave_remaining = $leave_allotted - $leaveTakenCount;

                $leaveBalanceData[] = [
                    'business_id' => $businessId,
                    'emp_id' => $emp->emp_id,
                    'month' => $today->month,
                    'year' => $today->year,
                    'range_date' => $today->format('Y-m-d'),
                    'leave_type' => $leaveType,
                    'user_present_in_holiday_counting' => $leave_allotted,
                    'monthly_total_holiday_counting' => $TotalLeavePerMonth,
                    'request_list_days' => floatval($statusCheckingReload),
                    'leave_allotted' => floatval($leave_allotted),
                    'leave_taken' => $leaveTakenCount,
                    'leave_remaining' => floatval($leave_remaining),
                ];
            }
        }
        // dd($leaveBalanceData, $getData->pluck('emp_id')->toArray());
    }

    static function calculationByLeavePolicy($employeeIDs)
    {
        $mode = EmployeePersonalDetail::where('business_id', self::allValueGet()[5])
            ->where('emp_id', $employeeIDs)
            ->count();
        return [$mode];
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
        $loginEmpId = Session::get('login_emp_id');
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', self::allValueGet()[5])
            ->where('emp_id', $loginEmpId)->first();
        // dd($permissionBranchId);
        if ($permissionBranchId !== null && !empty($permissionBranchId) && (Session::get('login_role')) != 1 && ($permissionBranchId->permission_type != 1)) {
            $totalEmployee = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('branch_id', $permissionBranchId->permission_branch_id)
                ->count();
            $GenderMale = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('emp_gender', 1)
                ->where('branch_id', $permissionBranchId->permission_branch_id)
                ->count();
            $GenderFemale = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('emp_gender', 2)
                ->where('active_emp', 1)
                ->where('branch_id', $permissionBranchId->permission_branch_id)
                ->count();
            $GenderOther = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('emp_gender', 3)
                ->where('branch_id', $permissionBranchId->permission_branch_id)
                ->count();
            $CurrentMonthCounterEmployeeAdd = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('branch_id', $permissionBranchId->permission_branch_id)
                ->whereMonth('created_at', self::allValueGet()[2])
                ->count();
        } else {
            $totalEmployee = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->count();
            $GenderMale = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('emp_gender', 1)
                ->count();
            $GenderFemale = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('emp_gender', 2)
                ->where('active_emp', 1)
                ->count();
            $GenderOther = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->where('emp_gender', 3)
                ->count();
            $CurrentMonthCounterEmployeeAdd = DB::table('employee_personal_details')
                ->where('business_id', self::allValueGet()[5])
                ->where('active_emp', 1)
                ->whereMonth('created_at', self::allValueGet()[2])
                ->count();
        }
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

    // Notification SendMode
    public static function NotificationSendMode($tokenFCM, $title, $body, $data)
    {
        $SERVER_API_KEY = 'AAAAB9VqZPk:APA91bF8g1Uw0WUfMvjY2j3_pIWTZg6Mz56_coB5sFD8j5RwF8T35lSm98g3UUMC_txSErST1SotTOh0XfFsY2ZupP_8yTJPl5QocX-8Y420u8VbPVRgktd_moVqj9ejwzwGc1nXcUqX';
        $messageSend = [
            'registration_ids' => $tokenFCM,
            // 'to' => $tokenFCM,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
            // [
            //     // "redirect_id" => 1,
            //     // "primary_id" => 222,
            //     // "punch_date" => $punchDate,
            // ]
        ];
        $dataString = json_encode($messageSend);

        $headers = ['Authorization: key=' . $SERVER_API_KEY, 'Content-Type: application/json'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    // conversion 24 to 12 horus Time any-value
    public static function Convert24To12($value)
    {
        $valueNOTNull = '';
        if ($value != null) {
            $valueNOTNull = date('h:i A', strtotime($value)); //twentyFourHourTime
            return $valueNOTNull;
        }
        return $valueNOTNull;
    }
    public static function Convert12To24($value)
    {
        // Check if the input is not null
        if ($value != null) {
            // Parse the input using Carbon
            $dateTime = Carbon::parse($value);

            // Format the result in 24-hour format
            return $dateTime->format('H:i:s');
        }

        // Return the value as is if it's null
        return $value;
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
            ->where('business_id', Session::get('business_id'))
            ->where('id', $ID)
            ->first();

        if ($check != null) {
            return [$check];
        } elseif ($ID == 1) {
            $check = (object) [
                'id' => 1,
                'business_id' => Session::get('business_id'),
                'branch_id' => Session::get('branch_id'),
                'roles_name' => 'Owner',
                'description' => 'Owner has complete access to assign all the bussiness.',
                'created_at' => now(), // Set to the current date and time
                'updated_at' => now(),
            ];
            return [$check];
        } else {
            return [0];
        }
    }

    public static  function roleIDToNameConvert($LoginType, $BID)
    {
        $load = DB::table('business_details_list')->where('login_type', $LoginType)->where('business_id', $BID)->first();
        if (isset($load)) {
            return 'Owner';
        } else {

            $result = PolicySettingRoleCreate::where('business_id', $BID)->where('id', $LoginType)
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

        if ($maxStatusValue != null) {
            return [$maxStatusValue];
        } else {
            return [0];
        }
    }

    // gatepass approval status
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

                    if ($CheckCurrentStaticStatus != null) {
                        if ($LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        } else {
                            if ($checkingCover->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $checkingCover->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        }
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0]; // check the next role id
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";

                        if ($itemIteration->process_complete == 1) {
                            // if all final process completer
                            $SD = RequestGatepassList::join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')
                                ->where('request_gatepass_list.business_id', $loginRoleBID)
                                ->where('request_gatepass_list.id', $itemID)
                                ->select('request_gatepass_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name ?? "Role-Deleted";
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $DeclinedName . ') <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $GatepassApprovalName . '(' . $ForwardStaticName . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardStaticName . ') <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name ?? "Role-Deleted";
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

                            $gotoPow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotoPow->roles_name ?? "Role-Deleted";
                            if ($ApprovedName2 != 0) {
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
                        if ($requestGet->role_id == 1) {
                            $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                ->pluck('client_name')
                                ->first();
                        } else {
                            $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                ->where('emp_id', $requestGet->emp_id)
                                ->select('emp_name', 'emp_mname', 'emp_lname')
                                ->first();
                            $empName = $GatepassApprovalName->emp_name ?? '';
                            $empMName = $GatepassApprovalName->emp_mname ?? '';
                            $empLName = $GatepassApprovalName->emp_lname ?? '';
                            $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                        }
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $LastDeclineName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $LastDeclineName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $LastDeclineName->emp_name ?? '';
                                $empMName = $LastDeclineName->emp_mname ?? '';
                                $empLName = $LastDeclineName->emp_lname ?? '';
                                $LastDeclineName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<br>Declined By ' . $LastDeclineName . '(' . $DeclinedName . ')<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
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
                        if ($CheckCurrentStaticStatusSecond) {
                            if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $CheckCurrentStaticStatusSecond->approval_emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }

                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $check = DB::table('business_details_list')
                                ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                ->first();
                            $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));
                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                if ($LastDeclineStatusRemark->role_id == 1) {
                                    $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                        ->pluck('client_name')
                                        ->first();
                                } else {
                                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                        ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                        ->select('emp_name', 'emp_mname', 'emp_lname')
                                        ->first();
                                    $empName = $GatepassApprovalName->emp_name ?? '';
                                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                                }
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name  ?? "Role-Deleted";;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $GatepassApprovalName . ' (' . $DeclinedName . ')<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {

                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-clock"></i> Pending</small>';
                                }
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';
                        }
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
            // dd($CheckCurrentStaticStatusSecond);
            if (!empty($CheckCurrentStaticStatusSecond)) {
                if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                    $GatepassApprovalName = DB::table('business_details_list')
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('client_name')
                        ->first();
                    // dd($GatepassApprovalName);
                } else {
                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                        ->where('emp_id', $CheckCurrentStaticStatusSecond->emp_id)
                        ->select('emp_name', 'emp_mname', 'emp_lname')
                        ->first();
                    $empName = $GatepassApprovalName->emp_name ?? '';
                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                }
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="feather feather-x-circle text-danger"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';
                }
            } else {
                return '<span class="badge badge-primary-light">Requested</span>';
            }
        }
    }

    public static function RequestLeaveApprovalManage($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID)
    {
        // dd($checkApprovalCycleType, $itemIteration, $itemID, $approvalTypeIdStatic, $loginRoleID);
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
                        if ($LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        } else {
                            if ($checkingCover->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $checkingCover->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        }
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

                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name ?? "Role-Deleted";
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i>' : '<i class="ion-close-circled"></i>';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;

                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                // dd($itemIteration->process_complete);
                                // dd($LastDeclineStatusRemark->role_id);
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $DeclinedName . ') <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $GatepassApprovalName . ' (' . $ForwardStaticName . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {

                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardStaticName . ') <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                        } else {
                            // $forwared = true;

                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name ?? "Role-Deleted";

                            if ($LatestStatusValue == 1) {
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {

                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="feather feather-x-circle text-danger"></i> ' . nl2br($LatestStatusName) . '</small>';
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
                            $ApprovedName2 = $gotopow->roles_name ?? "Role-Deleted";

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

                    if ($requestGet ?? false) {
                        if ($requestGet->role_id == 1) {
                            $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                ->pluck('client_name')
                                ->first();
                        } else {
                            $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                ->where('emp_id', $requestGet->emp_id)
                                ->select('emp_name', 'emp_mname', 'emp_lname')
                                ->first();
                            $empName = $GatepassApprovalName->emp_name ?? '';
                            $empMName = $GatepassApprovalName->emp_mname ?? '';
                            $empLName = $GatepassApprovalName->emp_lname ?? '';
                            $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                        }
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $LastDeclineName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $LastDeclineName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $LastDeclineName->emp_name ?? '';
                                $empMName = $LastDeclineName->emp_mname ?? '';
                                $empLName = $LastDeclineName->emp_lname ?? '';
                                $LastDeclineName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardName . ')<br>Declined By ' . $LastDeclineName . ' (' . $DeclinedName . ')<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardName . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardName . ')<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                    } else {
                        // return '';

                        $CheckCurrentStaticStatusSecond = DB::table('request_leave_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
                            ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('request_leave_list.id', $itemID)
                            ->where('request_leave_list.business_id', $loginRoleBID)
                            ->select('request_leave_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->first();
                        if ($CheckCurrentStaticStatusSecond) {
                            if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $CheckCurrentStaticStatusSecond->approval_emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            $check = DB::table('business_details_list')
                                ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                ->first();
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));

                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                if ($LastDeclineStatusRemark->role_id == 1) {
                                    $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                        ->pluck('client_name')
                                        ->first();
                                } else {
                                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                        ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                        ->select('emp_name', 'emp_mname', 'emp_lname')
                                        ->first();
                                    $empName = $GatepassApprovalName->emp_name ?? '';
                                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                                }
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $GatepassApprovalName . '(' . $DeclinedName . ')<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-close-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';

                                //    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $GatepassApprovalName . '(' . $ForwardNameGET . ') <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';

                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-clock"></i> Pending</small>';
                                    // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';
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
                if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                    $GatepassApprovalName = DB::table('business_details_list')
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('client_name')
                        ->first();
                } else {
                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                        ->where('emp_id', $CheckCurrentStaticStatusSecond->emp_id)
                        ->select('emp_name', 'emp_mname', 'emp_lname')
                        ->first();
                    $empName = $GatepassApprovalName->emp_name ?? '';
                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                }
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-close-circled"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';
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
                        if ($LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        } else {
                            if ($checkingCover->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $checkingCover->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        }
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0];
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";;
                        if ($itemIteration->process_complete == 1) {
                            $SD = DB::table('request_mispunch_list')
                                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                ->where('request_mispunch_list.business_id', $loginRoleBID)
                                ->where('request_mispunch_list.id', $itemID)
                                ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();

                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name ?? "Role-Deleted";;
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;
                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";;
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $DeclinedName . ') <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $GatepassApprovalName . '(' . $ForwardStaticName . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $ForwardStaticName . ') <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name ?? "Role-Deleted";

                            if ($LatestStatusValue == 1) {
                                // return ;
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                            }
                            if ($LatestStatusValue == 2) {
                                return '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="feather feather-x-circle text-danger"></i> ' . nl2br($LatestStatusName) . '</small>';
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

                            $gotopow = self::RoleName($CheckingLoad->role_id ?? 0)[0];
                            $ApprovedName2 = $gotopow->roles_name ?? "Role-Deleted";

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
                    if ($requestGet ?? false) {
                        if ($requestGet->role_id == 1) {
                            $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                ->pluck('client_name')
                                ->first();
                        } else {
                            $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                ->where('emp_id', $requestGet->emp_id)
                                ->select('emp_name', 'emp_mname', 'emp_lname')
                                ->first();
                            $empName = $GatepassApprovalName->emp_name ?? '';
                            $empMName = $GatepassApprovalName->emp_mname ?? '';
                            $empLName = $GatepassApprovalName->emp_lname ?? '';
                            $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                        }
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $LastDeclineName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $LastDeclineName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $LastDeclineName->emp_name ?? '';
                                $empMName = $LastDeclineName->emp_mname ?? '';
                                $empLName = $LastDeclineName->emp_lname ?? '';
                                $LastDeclineName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<br>Declined By ' . $LastDeclineName . '(' . $DeclinedName . ')<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        }
                    } else {
                        $CheckCurrentStaticStatusSecond = DB::table('request_mispunch_list')
                            ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
                            ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                            ->where('approval_status_list.approval_type_id', $approvalTypeIdStatic)
                            ->where('request_mispunch_list.id', $itemID)
                            ->where('request_mispunch_list.business_id', $loginRoleBID)
                            ->orderBy('approval_status_list.created_at', 'desc')
                            ->select('request_mispunch_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                            ->first();

                        if ($CheckCurrentStaticStatusSecond) {
                            if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $CheckCurrentStaticStatusSecond->approval_emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $check = DB::table('business_details_list')
                                ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                ->first();
                            $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));

                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                if ($LastDeclineStatusRemark->role_id == 1) {
                                    $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                        ->pluck('client_name')
                                        ->first();
                                } else {
                                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                        ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                        ->select('emp_name', 'emp_mname', 'emp_lname')
                                        ->first();
                                    $empName = $GatepassApprovalName->emp_name ?? '';
                                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                                }
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $GatepassApprovalName . '(' . $DeclinedName . ')<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-clock"></i> Pending</small>';
                                }
                            }
                        } else {
                            return '<span class="badge badge-primary-light">Requested</span>';
                        }
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
                if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                    $GatepassApprovalName = DB::table('business_details_list')
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('client_name')
                        ->first();
                    // dd($GatepassApprovalName);
                } else {
                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                        ->where('emp_id', $CheckCurrentStaticStatusSecond->emp_id)
                        ->select('emp_name', 'emp_mname', 'emp_lname')
                        ->first();
                    $empName = $GatepassApprovalName->emp_name ?? '';
                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                }
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                // dd($CheckingRole);
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));

                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    //dd($CheckCurrentStaticStatusSecond->role_id);
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="feather feather-x-circle text-danger"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
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
        $attendanceListAutoCheck = AttendanceList::where('business_id', Session::get('business_id'))
            ->where('id', $itemID)
            ->where('emp_today_current_status', '2')
            ->where('attendance_list_edit_check', '0')
            ->where('method_auto', '1')
            ->first();
        if ($attendanceListAutoCheck) {
            return '<small class="badge badge-success-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Auto Approval" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved" data-bs-original-title="Declined Approved"><i class="ion-checkmark-circled"></i> Approved</small>';
        }
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
                        if ($LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        } else {
                            if ($checkingCover->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $checkingCover->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                        }
                        $CheckingRole = self::RoleName($CheckCurrentStaticStatus->next_role_id)[0]; // check the next role id
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";
                        // dd($item->process_complete);
                        if ($itemIteration->process_complete == 1) {
                            // if all final process completer
                            $SD = DB::table('attendance_list')
                                ->join('static_status_request', 'attendance_list.final_status', '=', 'static_status_request.id')
                                ->where('attendance_list.business_id', $loginRoleBID)
                                ->where('attendance_list.id', $itemID)
                                ->select('attendance_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                ->first();
                            $ForwardStaticName = self::RoleName($checkingCover->role_id)[0]->roles_name ?? "Role-Deleted";
                            $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                            $statusColor = $SD->request_color;
                            $statusResponse = $SD->request_response;

                            if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $DeclinedName . ') <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            } elseif ($SD->final_status == 1) {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $GatepassApprovalName . '(' . $ForwardStaticName . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                            } else {
                                return '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . '(' . $ForwardStaticName . ') <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-close-circled"></i> ' . nl2br($statusResponse) . '</small>';
                            }
                            // return '<small><span class="' . $statusColor . '">' . $statusIcon . ' ' . $statusResponse . '</span></small>';
                        } else {
                            $ForwardStaticName = self::RoleName($itemIteration->forward_by_role_id)[0]->roles_name ?? "Role-Deleted";

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
                            $ApprovedName2 = $gotopow->roles_name ?? "Role-Deleted";
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
                        if ($requestGet->role_id == 1) {
                            $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                ->pluck('client_name')
                                ->first();
                        } else {
                            $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                ->where('emp_id', $requestGet->emp_id)
                                ->select('emp_name', 'emp_mname', 'emp_lname')
                                ->first();
                            $empName = $GatepassApprovalName->emp_name ?? '';
                            $empMName = $GatepassApprovalName->emp_mname ?? '';
                            $empLName = $GatepassApprovalName->emp_lname ?? '';
                            $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                        }
                        $CheckingRole = self::RoleName($requestGet->current_role_id ?? 0)[0];
                        $ForwardName = $CheckingRole->roles_name ?? "Role-Deleted";
                        $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                        if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                            if ($LastDeclineStatusRemark->role_id == 1) {
                                $LastDeclineName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $LastDeclineName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $LastDeclineName->emp_name ?? '';
                                $empMName = $LastDeclineName->emp_mname ?? '';
                                $empLName = $LastDeclineName->emp_lname ?? '';
                                $LastDeclineName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";

                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>' . $DeclinedName . '  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // } elseif ($requestGet->status == 1) {
                            //     // dd($requestGet);
                            //     return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            //     // return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // } else {
                            //     // dd($requestGet);

                            //     return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                            // }
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<br>Declined By ' . $LastDeclineName . '(' . $DeclinedName . ')<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } elseif ($requestGet->status == 1) {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                        } else {
                            return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . '(' . $ForwardName . ')<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
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
                            if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                                $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                    ->pluck('client_name')
                                    ->first();
                            } else {
                                $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                    ->where('emp_id', $CheckCurrentStaticStatusSecond->approval_emp_id)
                                    ->select('emp_name', 'emp_mname', 'emp_lname')
                                    ->first();
                                $empName = $GatepassApprovalName->emp_name ?? '';
                                $empMName = $GatepassApprovalName->emp_mname ?? '';
                                $empLName = $GatepassApprovalName->emp_lname ?? '';
                                $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                            }
                            $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                            $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                            $check = DB::table('business_details_list')
                                ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                ->first();
                            $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));

                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                if ($LastDeclineStatusRemark->role_id == 1) {
                                    $GatepassApprovalName = BusinessDetailsList::where('business_id', Session::get('business_id'))
                                        ->pluck('client_name')
                                        ->first();
                                } else {
                                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                                        ->where('emp_id', $LastDeclineStatusRemark->emp_id)
                                        ->select('emp_name', 'emp_mname', 'emp_lname')
                                        ->first();
                                    $empName = $GatepassApprovalName->emp_name ?? '';
                                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                                }
                                $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id ?? 0)[0]->roles_name ?? "Role-Deleted";
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                            } else {
                                if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $GatepassApprovalName . ' (' . $ForwardNameGET . ')<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                    return '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-clock"></i> Pending</small>';
                                }
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
                if ($CheckCurrentStaticStatusSecond->role_id == 1) {
                    $GatepassApprovalName = DB::table('business_details_list')
                        ->where('business_id', Session::get('business_id'))
                        ->pluck('client_name')
                        ->first();
                    // dd($GatepassApprovalName);
                } else {
                    $GatepassApprovalName = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                        ->where('emp_id', $CheckCurrentStaticStatusSecond->emp_id)
                        ->select('emp_name', 'emp_mname', 'emp_lname')
                        ->first();
                    $empName = $GatepassApprovalName->emp_name ?? '';
                    $empMName = $GatepassApprovalName->emp_mname ?? '';
                    $empLName = $GatepassApprovalName->emp_lname ?? '';
                    $GatepassApprovalName = $empName . ' ' . $empMName . ' ' . $empLName;
                }
                $CheckingRole = self::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                $check = DB::table('business_details_list')
                    ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                    ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                    ->first();
                $ForwardNameGET = (($CheckingRole !== null && $CheckingRole !== 0) ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : "Role-Deleted"));
                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ')" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                    // return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                    $DeclinedName = self::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name ?? "Role-Deleted";
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                    return '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $GatepassApprovalName . ' (' . $ForwardNameGET . ') <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="feather feather-x-circle text-danger"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                } else {
                    return '<span class="badge badge-primary-light">Requested</span>';
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
        self::$LoginRole = Session::get('login_role'); //role table id : 8 assign_role onwer 1 dami orh admin 2 dynamic alos role_id dynamic
        self::$UserType = Session::get('user_type'); //Other checking loader
        self::$BusinessID = Session::get('business_id');
        self::$BranchID = Session::get('branch_id');
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
        // dd(self::$LoginRole);
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
