<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Exports\UsersExport;
use App\Imports\BioMetricImport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Helpers\Central_unit;
use App\Models\PolicySettingRoleAssignPermission;

class ReportController extends Controller
{

    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.reports.report', compact('permissions'));
    }




    public function LeaveManagement(Request $request)
    {
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        $branch = $request->branch_id;
        $date = $request->date;
        $export = $request->export1;

        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $EmpQuery = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('active_emp', 1)->orderBy('emp_id');
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $Emp = $EmpQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->get();
        } else {
            $Emp = $EmpQuery->get();
        }
        $category = DB::table('static_leave_category')->where('dynamic_table_print', 1)->get();
        // // if ($Emp->isEmpty()) {
        // //     return redirect()->back()->with('error', 'No records to export.');
        // // }

        if ($request->id == 1) {
            $pdf = PDF::loadView('generate-pdf.employee_leave_managemet', compact('Emp', 'category', 'branch', 'date'));
            $response = $pdf->stream('FixHr-Leave_Balance_Report.pdf');
            return $response;
        }

        // return $pdf->download('disney.pdf');
    }


    // attendance report

    public function DailyAttendanceReport(Request $request)
    {
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();

        $EmpQuery = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id');
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $Emp = $EmpQuery->whereIn('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->get();
        } else {
            $Emp = $EmpQuery->get();
        }
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $branch = DB::table('branch_list')->where('branch_id', Session::get('branch_id'))->where('business_id', Session::get('business_id'))->first();
        $length = $Emp->count();
        $month = date('m', strtotime($request->date));
        $year = date('Y', strtotime($request->date));
        $day = date('d', strtotime($request->date));
        return Excel::download(new UsersExport($Emp, $length, 7, $month, $year, $day, $branch->branch_name ?? 'All Branch'), 'EmployeeDailyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMusterRoll(Request $request)
    {

        $branchId = $request->branch_id;
        $month = $request->month;
        $year = $request->year;
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission =
            PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $EmpQuery = DB::table('employee_personal_details')
            ->where('business_id', $businessId)
            ->where('active_emp', 1)
            ->orderBy('emp_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            });
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $Emp = $EmpQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->get();
        } else {
            $Emp = $EmpQuery->get();
        }
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $branch = DB::table('branch_list')->where('branch_id', $branchId)->where('business_id', Session::get('business_id'))->first();
        $length = $Emp->count();
        return Excel::download(new UsersExport($Emp, $length, 9, $month, $year, 01, $branch->branch_name ?? 'All Branch'), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMonthlyAttendanceReport(Request $request)
    {
        // dd($request->all());
        $EmpID = $request->empID;
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $EmpDetailsQuery = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id', $EmpID);
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermissionp->permission_type == 2)) {
            $EmpDetails = $EmpDetailsQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->first();
        } else {
            $EmpDetails = $EmpDetailsQuery->first();
        }
        if ($EmpDetails) {
            $branch = DB::table('branch_list')->where('branch_id', $EmpDetails->branch_id)->where('business_id', $EmpDetails->business_id)->first();
        }
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $month = date('m', strtotime($request->month . '-01'));
        $year = date('Y', strtotime($request->month . '-01'));
        $day = date('d', strtotime($request->month . '-01'));
        $length = $month == date('m') ? date('j') : cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // dd($month,$year,$length);

        return Excel::download(new UsersExport($EmpDetails, $length, 13, $month, $year, $day, $branch->branch_name), 'EmployeeMonthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function employeeMonthlyAttendanceReportWithGeoLocation(Request $request)
    {
        // dd($request->all());
        $EmpID = $request->empID;
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $EmpDetailsQuery = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id', $EmpID);
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $EmpDetails = $EmpDetailsQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->first();
        } else {
            $EmpDetails = $EmpDetailsQuery->first();
        }
        if ($EmpDetails) {
            $branch = DB::table('branch_list')->where('branch_id', $EmpDetails->branch_id)->where('business_id', $EmpDetails->business_id)->first();
        }
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $month = date('m', strtotime($request->month . '-01'));
        $year = date('Y', strtotime($request->month . '-01'));
        $day = date('d', strtotime($request->month . '-01'));
        $length = $month == date('m') ? date('j') : cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // dd($month,$year,$length);

        return Excel::download(new UsersExport($EmpDetails, $length, 11, $month, $year, $day, $branch->branch_name), 'EmployeeMonthlyAttendanceReportWithGoeLocationAndSelfie.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


    public function employeeARReport(Request $request)
    {

        $EmpID = $request->empID;
        $EmpDetailsQuery = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id', $EmpID);
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        // check karta hai ki owner or other role  if case for other role and else case for owner
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $EmpDetails = $EmpDetailsQuery->whereIn('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->first();
        } else {
            $EmpDetails = $EmpDetailsQuery->first();
        }
        $branch = DB::table('branch_list')->where('branch_id', $EmpDetails->branch_id)->where('business_id', $EmpDetails->business_id)->first();
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $month = date('m', strtotime($request->month . '-01'));
        $year = date('Y', strtotime($request->month . '-01'));
        $day = date('d', strtotime($request->month . '-01'));
        $length = $month == date('m') ? date('j') : cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // dd($EmpDetails, $length, 12, $month, $year, $day);
        return Excel::download(new UsersExport($EmpDetails, $length, 12, $month, $year, $day, $branch->branch_name), 'EmployeeMonthlyARReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    // leave report
    public function employeeLeaveBalanceMusterRoll(Request $request)
    {
        $branchId = $request->branch_id;
        $month = $request->month;
        $year = $request->year;
        $businessId = Session::get('business_id');
        // roleIdCheck jo login kiya hai uska role 1 => owner and other for other roles
        $roleIdToCheck = Session::get('login_role');
        // permisssion check kis branch ka diya gaya hai
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();

        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $Emp = DB::table('employee_personal_details')
                ->where('business_id', $businessId)
                ->where('branch_id', $checkBranchPermission->permission_branch_id)
                ->where('active_emp', 1)
                ->orderBy('emp_id')
                ->when($branchId, function ($query) use ($branchId) {
                    $query->where('employee_personal_details.branch_id', $branchId);
                })->get();
            $branch = DB::table('branch_list')->where('branch_id', $branchId)->where('business_id', $businessId)->where('branch_id', $checkBranchPermission->permission_branch_id)->first();
        } else {
            $Emp = DB::table('employee_personal_details')
                ->where('business_id', $businessId)
                ->where('active_emp', 1)
                ->orderBy('emp_id')
                ->when($branchId, function ($query) use ($branchId) {
                    $query->where('employee_personal_details.branch_id', $branchId);
                })->get();
            $branch = DB::table('branch_list')->where('branch_id', $branchId)->where('business_id', $businessId)->first();
        }
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $length = $Emp->count();

        return Excel::download(new UsersExport($Emp, $length, 10, $month, $year, 01, $branch->branch_name ?? 'All Branch'), 'EmployeeLeaveBalanceMusterRoll.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
