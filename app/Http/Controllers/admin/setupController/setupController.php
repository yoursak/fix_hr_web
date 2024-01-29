<?php

namespace App\Http\Controllers\admin\setupController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoginAdmin;
use App\Models\DepartmentList;
use App\Models\DesignationList;
use App\Models\WeeklyHolidayList;
use App\Models\SettingLeaveCategory;
use Session;
use App\Models\PolicyAttendanceMode;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\BusinessDetailsList;
use App\Models\BranchList;
use App\Models\PolicyAttendanceTrackInOut;
use App\Helpers\Central_unit;
use Carbon\Carbon;
use File;
use App\Models\PolicyWeeklyHolidayList;
use App\Models\PolicySettingLeavePolicy;
use App\Models\admin\setupsettings\MasterEndGameModel;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Ixudra\Curl\Facades\Curl;
use App\Models\PolicyHolidayTemplate;
use App\Models\AdminNotice;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\PolicySettingLeaveCategory;
use App\Models\StaticEmployeeJoinActiveType;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinContractualType;
use App\Models\StaticEmployeeJoinEmpType;
use App\Models\StaticEmployeeJoinGenderType;
use App\Models\StaticEmployeeJoinGovtDocType;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinReligion;
use App\Models\StaticCountryModel;
use App\Models\Subscription;
use App\Models\ModelHasPermission;
use App\Models\StaticAttendanceMethod;
use App\Models\PolicyCompOffLwopLeave;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\EmployeePersonalDetail;

class setupController extends Controller
{
    public function index(Request $request)
    {
        $empcountvalue = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();
        $getContractualType = DB::table('static_employee_join_contractual_type')->get();
        return view('admin.setupLayout.employee.Employee', compact('empcountvalue','getContractualType'));
        // return view('admin.setupLayout.employee.Employee', compact('staticbloodGroup', 'staticGender', 'staticMarital', 'statciCategory', 'staticGovId', 'getCountry', 'EmpID', 'Branch', 'Department', 'Designation', 'attendanceMethod', 'setupAssociated', 'newCurrentStep','image'));
    }

    public function ActivePermissionCheck()
    {
        $get = DB::table('policy_master_endgame_method')->where('business_id', Session::get('business_id'))->where('method_switch', 1)->first();
        return response()->json(['masterendgame' => $get]);
    }

    public function clearSession()
    {
        Session::flush();
        return response()->json(['status' => 'success']);
    }


    public function dashboard()
    {
        return view('admin.setupLayout.dashboard.dashboard');
    }

    public function subscription()
    {
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->select('business_email')->first();
        $subscriptionTable = Subscription::leftJoin('static_subscription_plan', 'subscription.plan_id', '=', 'static_subscription_plan.id')->where('business_id', Session::get('business_id'))->where('user_type', 1)->select('static_subscription_plan.plan_name as planName', 'subscription.*')->get();

        return view('admin.setupLayout.setting.subscription.subscription', compact('accDetail', 'permissions', 'subscriptionTable'));
    }

    public function loaderM(Request $request)
    {
        return $request->all();
    }
    public function accountSetup(Request $request)
    {
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $statefind = DB::table('static_states')
            ->where('country_id', $accDetail->country)
            ->orderBy('name', 'asc')
            ->get();
        $citiesfind = DB::table('static_cities')
            ->where('state_id', $accDetail->state)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.setupLayout.setting.account.account', compact('permissions', 'moduleName', 'accDetail', 'statefind', 'citiesfind'));
    }

    public function businessSetup(Request $request)
    {
        $branchCountValue = BranchList::where('business_id', Session::get('business_id'))->count();
        $departmentCountValue = DepartmentList::where('b_id', Session::get('business_id'))->count();
        $designationCountValue = DesignationList::where('business_id', Session::get('business_id'))->count();
        $holidayPolicyCountValue = PolicyHolidayTemplate::where('business_id', Session::get('business_id'))->count();
        $leavePolicyCountValue = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))->count();
        $weeklyHolidayPolicyCountValue = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))->count();
        $noticBoardCountValue = AdminNotice::where('business_id', Session::get('business_id'))->count();
        $policycompoffCoutnValue = PolicyCompOffLwopLeave::where('business_id', Session::get('business_id'))
            ->where('switch', '1')
            ->count();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.setupLayout.setting.business.business', compact('permissions', 'moduleName', 'branchCountValue', 'departmentCountValue', 'designationCountValue', 'holidayPolicyCountValue', 'leavePolicyCountValue', 'weeklyHolidayPolicyCountValue', 'policycompoffCoutnValue', 'noticBoardCountValue'));
    }

    public function branchesSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setupLayout.setting.business.branches.branches', compact('permissions', 'moduleName'));
    }

    public function departmentSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $branchList = BranchList::all();
        $deparmentList = DepartmentList::all();

        $data = compact('deparmentList', 'branchList', 'permissions', 'moduleName');

        return view('admin.setupLayout.setting.business.department.department', $data);
    }

    public function designationSetup(Request $request)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $item = DesignationList::where('desig_id', $request->id)->first();

        // if($getvalue){
        //     return response()->json(["editDesignationResult"=>$getvalue]);
        // }

        return view('admin.setupLayout.setting.business.designation.designation', compact('item', 'permissions', 'moduleName'));
    }

    public function holidayPolicySetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $masterEndAssignCheck = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))
            ->select('holiday_policy_ids_list')
            ->get();
        $holidayPolicy = PolicyHolidayTemplate::where('business_id', Session::get('business_id'))->get();
        return view('admin.setupLayout.setting.business.holiday_policy.holiday_policy', compact('holidayPolicy', 'masterEndAssignCheck', 'permissions'));
    }

    public function leavePolicySetup(Request $request)
    {
        $call = new Central_unit();
        $BranchList = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $getleavepolicy = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->select('leave_policy_ids_list')
            ->get();
        $Leaves = PolicySettingLeaveCategory::where('business_id', session()->get('business_id'))->get();
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))->get();
        $leaveType = DB::table('static_leave_category')
            ->where('id', '!=', '8')
            ->where('id', '!=', '9')
            ->get();
        $applicableTo = DB::table('static_leave_category_applicable_to')->get();
        return view('admin.setupLayout.setting.business.leave_policy.leave_policy', compact('leaveType', 'leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName', 'applicableTo', 'getleavepolicy'));
    }

    public function noticeSetup(Request $request)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Notice = DB::table('admin_notices')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        return view('admin.setupLayout.setting.business.notice.notice', compact('Notice', 'permissions'));
    }

    public function compOffLWPSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $getPolicy = DB::table('policy_comp_off_lwop_leave')
            ->where('business_id', Session::get('business_id'))
            ->first();
        return view('admin.setupLayout.setting.business.compoff.compoff', compact('getPolicy', 'permissions'));
    }

    public function createShiftSetup()
    {
        $attendaceShift = DB::table('policy_attendance_shift_settings')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.setupLayout.setting.attendance.createshift', compact('permissions', 'moduleName', 'attendaceShift'));
    }

    public function weeklyHolidaySetup()
    {
        $data = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))
            ->join('static_week_off_type', 'policy_weekly_holiday_list.weekend_policy', '=', 'static_week_off_type.id')
            ->select('policy_weekly_holiday_list.*', 'static_week_off_type.week_off_type_name')
            ->get();
        // check master endgame assign or not
        $checkMaEnAssOrNot = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->select('weekly_policy_ids_list')
            ->get();
        $staticweekoffType = DB::table('static_week_off_type')->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $days = [];
        return view('admin.setupLayout.setting.business.weekly_holiday.weekly_holiday', compact('data', 'days', 'staticweekoffType', 'checkMaEnAssOrNot', 'permissions'));
    }

    public function attendanceSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Track = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->first();
        $Modes = PolicyAttendanceMode::where('business_id', Session()->get('business_id'))->first();
        $List = RulesManagement::ALLPolicyTemplates();
        $FinalEndGameRule = $List[0];
        $AttendanceData = RulesManagement::AttendaceMethodTypeCounter();
        $shiftSettingsCountValue = PolicyAttendanceShiftSetting::where('business_id', Session::get('business_id'))->count();
        $attendanceMode = PolicyAttendanceMode::where('business_id', Session::get('business_id'))
            ->where(function ($query) {
                $query
                    ->orWhereJsonContains('attendance_active_methods', 1)
                    ->where(function ($query) {
                        $query
                            ->orWhere('office_auto', 1)
                            ->where(function ($query) {
                                $query
                                    ->orWhere('office_qr', '1')
                                    ->orWhere('office_selfie', '1')
                                    ->orWhere('office_face_id', '1');
                            })
                            ->orWhere('office_manual', 1)
                            ->where(function ($query) {
                                $query
                                    ->orWhere('office_qr', '1')
                                    ->orWhere('office_selfie', '1')
                                    ->orWhere('office_face_id', '1');
                            });
                    })
                    ->orWhereJsonContains('attendance_active_methods', 2)
                    ->where(function ($query) {
                        $query
                            ->orWhere('outdoor_auto', 1)
                            ->where(function ($query) {
                                $query->orWhere('outdoor_selfie', '1');
                            })
                            ->orWhere('outdoor_manual', 1)
                            ->where(function ($query) {
                                $query->orWhere('outdoor_selfie', '1');
                            });
                    })
                    ->orWhereJsonContains('attendance_active_methods', 3)
                    ->where(function ($query) {
                        $query
                            ->orWhere('wfh_auto', 1)
                            ->where(function ($query) {
                                $query->orWhere('wfh_selfie', '1');
                            })
                            ->orWhere('wfh_manual', 1)
                            ->where(function ($query) {
                                $query->orWhere('wfh_selfie', '1');
                            });
                    });
            })
            ->count();
        // dd($attendanceMode);
        // dd($attendanceMode);
        // dd($shiftSettingsCountValue);
        // dd($shiftSettings);
        // $BusinessDetails = $List[1];
        // $BranchList = $List[2];
        // $LeavePolicy = $List[3];
        // $HolidayPolicy = $List[4];
        // $weeklyPolicy = $List[5];
        // $attendanceModePolicy = $List[6];
        // $attendanceShiftPolicy = $List[7];
        // $attendanceTrackInOut = $List[8];
        return view('admin.setupLayout.setting..attendance.attendance', compact('attendanceMode', 'Modes', 'Track', 'FinalEndGameRule', 'permissions', 'moduleName', 'AttendanceData', 'shiftSettingsCountValue'));
    }

    public function attendanceAccessSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        // $BusinessDetails = $List[1];
        // $BranchList = $List[2];
        // $LeavePolicy = $List[3];
        // $HolidayPolicy = $List[4];
        // $weeklyPolicy = $List[5];
        // $attendanceModePolicy = $List[6];
        // $attendanceShiftPolicy = $List[7];
        // $attendanceTrackInOut = $List[8];
        $EmployeeInfomation = $List[9];

        $BusinessDetails = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $AttMode = DB::table('attendance_mode')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $Temp = DB::table('attendance_access')
            ->where('business_id', Session::get('business_id'))
            ->get();

        return view('admin.setupLayout.setting..attendance.attendance_acccess', compact('permissions', 'moduleName', 'FinalEndGameRule', 'BusinessDetails', 'AttMode', 'Temp', 'EmployeeInfomation'));
    }

    public function automationSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $lateEntryData = DB::table('policy_atten_rule_late_entry')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $earlyExitData = DB::table('policy_atten_rule_early_exit')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $overtimeData = DB::table('policy_atten_rule_overtime')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $breakData = DB::table('policy_atten_rule_break')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $missPunchData = DB::table('policy_atten_rule_misspunch')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $gatePassData = DB::table('policy_atten_rule_gatepass')
            ->where('business_id', Session::get('business_id'))
            ->first();
        // dd($accessPermission);
        return view('admin.setupLayout.setting.attendance.automation', compact('permissions', 'moduleName', 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));

        // return view('admin.setupLayout.setting.attendance.automation', compact('permissions', 'moduleName', 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));
    }

    public function attOnHolidaySetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setupLayout.setting..attendance.attendance_on_holiday', compact('permissions', 'moduleName'));
    }

    public function cameraAccessSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $modes = DB::table('static_attendance_methods')->get();
        $bName = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first('business_name');
        $cameraAccess = DB::table('camera_permission')
            ->where('camera_permission.business_id', Session::get('business_id'))
            ->leftJoin('static_attendance_methods', 'camera_permission.mode_check', '=', 'static_attendance_methods.id')
            ->orderBy('camera_permission.id', 'DESC')
            ->select('camera_permission.*', 'static_attendance_methods.id as attmethodid', 'static_attendance_methods.method_name')
            ->get();
        $Type = DB::table('static_attendance_mode')->whereIn('id',[1,2])->get();

        return view('admin.setupLayout.setting.attendance.cameraAccess', compact(['bName', 'cameraAccess', 'modes', 'Type', 'permissions']));
        // return view("admin.setupLayout.setting.attendance.cameraAccess", compact(['bName', 'cameraAccess', 'modes']));
    }

    public function ActiveModeSetup()
    {
        $accessPermission = Central_unit::AccessPermission();

        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $List = RulesManagement::ALLPolicyTemplates();
        $activeMethodCountValue = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))->where('method_switch', 1)->count();
        // dd($activeMethodCount);
        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];

        // dd($activeMethodCountValue);
        $root = compact('activeMethodCountValue', 'moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setupLayout.setting.active_rules.active_end_game', $root);
    }
}
