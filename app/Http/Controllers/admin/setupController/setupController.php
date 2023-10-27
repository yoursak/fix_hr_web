<?php

namespace App\Http\Controllers\admin\setupController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\BranchList;
use App\Models\admin\LoginAdmin;
use App\Models\admin\DepartmentList;
use App\Models\admin\DesignationList;
use App\Models\admin\WeeklyHolidayList;
use App\Models\admin\SettingLeaveCategory;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Central_unit;
use Carbon\Carbon;
use File;
use App\Models\admin\setupsettings\MasterEndGameModel;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Ixudra\Curl\Facades\Curl;

class setupController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.setupLayout.employee.Employee");
    }

    public function subscription()
    {
        return view('admin.setupLayout.setting.subscription.subscription');
    }

    public function loaderM(Request $request)
    {
        return $request->all();
    }
    public function accountSetup(Request $request)
    {
        $accDetail = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view("admin.setupLayout.setting.account.account", compact('permissions', 'moduleName', 'accDetail'));
    }

    public function businessSetup(Request $request)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view("admin.setupLayout.setting.business.business", compact('permissions', 'moduleName'));
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
        return view('admin.setupLayout.setting.business.holiday_policy.holiday_policy');
    }

    public function leavePolicySetup(Request $request)
    {
        $call = new Central_unit();
        $BranchList = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $Leaves = DB::table('setting_leave_category')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        $leavePolicy = DB::table('setting_leave_policy')
            ->where('business_id', Session::get('business_id'))
            ->get();
        // dd($leavePolicy);
        return view('admin.setupLayout.setting.business.leave_policy.leave_policy', compact('leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName'));
    }

    public function noticeSetup(Request $request)
    {
        $Notice = DB::table('admin_notices')->where('business_id', $request->session()->get('business_id'))->get();
        // dd($Notice);
        return view('admin.setupLayout.setting.business.notice.notice', compact('Notice'));
    }

    public function weeklyHolidaySetup()
    {
        $data = WeeklyHolidayList::where('business_id', Session::get('business_id'))->get();

        // dd($data);
        $days = [];

        foreach ($data as $item) {
            $days = json_decode($item->days, true); // Assuming 'days' column contains JSON data
        }

        return view('admin.setupLayout.setting.business.weekly_holiday.weekly_holiday', compact('data', 'days'));
    }

    public function attendanceSetup()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Track = DB::table('attendance_track_in_out')
            ->where('business_id', Session::get('business_id'))
            ->first();

        $Modes = DB::table('attendance_mode')
            ->where('business_id', Session()->get('business_id'))
            ->first();
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];

        $AttendanceData = RulesManagement::AttendaceMethodTypeCounter();

        // $BusinessDetails = $List[1];
        // $BranchList = $List[2];
        // $LeavePolicy = $List[3];
        // $HolidayPolicy = $List[4];
        // $weeklyPolicy = $List[5];
        // $attendanceModePolicy = $List[6];
        // $attendanceShiftPolicy = $List[7];
        // $attendanceTrackInOut = $List[8];
        return view('admin.setupLayout.setting..attendance.attendance', compact('Modes', 'Track', 'FinalEndGameRule', 'permissions', 'moduleName', 'AttendanceData'));
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

        $lateEntryData = DB::table('atten_rule_late_entry')->where('business_id', Session::get('business_id'))->first();
        $earlyExitData = DB::table('atten_rule_early_exit')->where('business_id', Session::get('business_id'))->first();
        $overtimeData = DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->first();
        $breakData = DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->first();
        $missPunchData = DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->first();
        $gatePassData = DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->first();

        return view('admin.setupLayout.setting..attendance.automation', compact('permissions', 'moduleName', 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));
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
        $modes = DB::table("attendance_methods")->get();
        $bName = DB::table("business_details_list")->where("business_id", Session::get('business_id'))->first('business_name');
        $cameraAccess = DB::table("camera_permission")
            ->where("camera_permission.business_id", Session::get('business_id'))
            ->leftJoin('attendance_methods', 'camera_permission.mode_check', '=', 'attendance_methods.id')
            ->orderBy('camera_permission.id', 'DESC')
            ->select('camera_permission.*', 'attendance_methods.id as attmethodid', 'attendance_methods.method_name')
            ->get();
        return view("admin.setupLayout.setting.attendance.cameraAccess", compact(['bName', 'cameraAccess', 'modes']));
    }

    public function ActiveModeSetup()
    {
        $accessPermission = Central_unit::AccessPermission();

        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];

        // dd($FinalEndGameRule);
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setupLayout.setting.active_rules.active_end_game', $root);
    }


}
