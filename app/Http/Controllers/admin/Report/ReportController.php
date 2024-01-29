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

class ReportController extends Controller
{

    public function index()
    {

        // RulesManagement::UploadReport();
        // dd($sdf);
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.reports.report', compact('permissions'));
    }




    public function LeaveManagement(Request $request)
    {
        $branch = $request->branch_id;
        $date = $request->date;
        $export = $request->export1;
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('active_emp', 1)->orderBy('emp_id')->get();
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

    public function monthlyAttendanceReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 1), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyLateReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 2), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyEarlyExitReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 3), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyMispunchReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 4), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyOvertimeReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 5), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyHalfdayReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 6), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function DailyAttendanceReport(Request $request)
    {
        // dd($request->all());
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $branch = DB::table('branch_list')->where('branch_id',Session::get('branch_id'))->where('business_id',Session::get('business_id'))->first();
        $length = $Emp->count();
        $month = date('m', strtotime($request->date));
        $year = date('Y', strtotime($request->date));
        $day = date('d', strtotime($request->date));
        return Excel::download(new UsersExport($Emp, $length, 7, $month, $year, $day,$branch->branch_name ?? 'All Branch'), 'EmployeeDailyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function GatePasReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 8), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMusterRoll(Request $request)
    {

        $branchId = $request->branch_id;
        $month = $request->month;
        $year = $request->year;

        $Emp = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('active_emp', 1)
            ->orderBy('emp_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $branch = DB::table('branch_list')->where('branch_id',$branchId)->where('business_id',Session::get('business_id'))->first();
        $length = $Emp->count();
        return Excel::download(new UsersExport($Emp, $length, 9, $month, $year, 01,$branch->branch_name ?? 'All Branch'), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMonthlyAttendanceReport(Request $request)
    {
        // dd($request->all());
        $EmpID = $request->empID;
        $EmpDetails = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id', $EmpID)->first();
        $branch = DB::table('branch_list')->where('branch_id',$EmpDetails->branch_id)->where('business_id',$EmpDetails->business_id)->first();
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $month = date('m', strtotime($request->month . '-01'));
        $year = date('Y', strtotime($request->month . '-01'));
        $day = date('d', strtotime($request->month . '-01'));
        $length = date('m-Y', strtotime($request->month . '-01')) == date('m-Y') ? date('j') : date('t');
        return Excel::download(new UsersExport($EmpDetails, $length, 11, $month, $year, $day,$branch->branch_name), 'EmployeeMonthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


    public function employeeARReport(Request $request)
    {
        
        $EmpID = $request->empID;
        $EmpDetails = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id', $EmpID)->first();

        $branch = DB::table('branch_list')->where('branch_id',$EmpDetails->branch_id)->where('business_id',$EmpDetails->business_id)->first();
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }

        $month = date('m', strtotime($request->month . '-01'));
        $year = date('Y', strtotime($request->month . '-01'));
        $day = date('d', strtotime($request->month . '-01'));
        $length = date('m-Y', strtotime($request->month . '-01')) == date('m-Y') ? date('j') : date('t');

        // dd($EmpDetails, $length, 12, $month, $year, $day);
        return Excel::download(new UsersExport($EmpDetails, $length, 12, $month, $year, $day,$branch->branch_name), 'EmployeeMonthlyARReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    // leave report 
    public function employeeLeaveBalanceMusterRoll(Request $request)
    {
        $branchId = $request->branch_id;
        $month = $request->month;
        $year = $request->year;

        $Emp = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('active_emp', 1)
            ->orderBy('emp_id')
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('employee_personal_details.branch_id', $branchId);
            })->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $length = $Emp->count();
        $branch = DB::table('branch_list')->where('branch_id',$branchId)->where('business_id',Session::get('business_id'))->first();

        return Excel::download(new UsersExport($Emp, $length, 10, $month, $year, 01,$branch->branch_name ?? 'All Branch'), 'EmployeeLeaveBalanceMusterRoll.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function compensatoryOffReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 11), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyAvailedLeaveReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 12), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function detailAvailedLeaveReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 13), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function pendingLeaveApplicationReport()
    {
        $Emp = DB::table('employee_personal_details')->where('active_emp', 1)->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp, 14), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
