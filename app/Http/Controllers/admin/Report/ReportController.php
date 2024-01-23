<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        return view('admin.reports.report');
    }


    // attendance report 

    public function monthlyAttendanceReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,1), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyLateReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,2), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyEarlyExitReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,3), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyMispunchReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,4), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyOvertimeReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,5), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyHalfdayReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,6), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function DailyAttendanceReport(Request $request)
    {
        // dd($request->all());
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $length = $Emp->count();
        $month = date('m',strtotime($request->date));
        $year = date('Y',strtotime($request->date));
        $day = date('d',strtotime($request->date));
        return Excel::download(new UsersExport($Emp,$length,7,$month,$year,$day), 'EmployeeDailyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function GatePasReport()
    {
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,8), 'monthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMusterRoll(Request $request){
        // dd($request->all());
        $branchId = $request->branch_id;
        $month = $request->month;
        $year = $request->year;

        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')
        ->when($branchId, function ($query) use ($branchId) {
            $query->where('attendance_list.branch_id', $branchId);
        })->get();

        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        $length = $Emp->count();
        return Excel::download(new UsersExport($Emp,$length,9,$month,$year,01), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function employeeMonthlyAttendanceReport(Request $request){
        // dd($request->all());
        $EmpID = $request->empID;
        $EmpDetails = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->where('emp_id',$EmpID)->first();
       
        if ($EmpDetails == null) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        
        $month = date('m',strtotime($request->month.'-01'));
        $year = date('Y',strtotime($request->month.'-01'));
        $day = date('d',strtotime($request->month.'-01'));
        $length = date('m-Y',strtotime($request->month.'-01')) == date('m-Y') ? date('j') : date('t');
        return Excel::download(new UsersExport($EmpDetails,$length,11,$month,$year,$day), 'EmployeeMonthlyAttendanceReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }



    // leave report 
    public function employeeLeaveBalanceMusterRoll(){
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,10), 'EmployeeLeaveBalanceMusterRoll.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }



    public function compensatoryOffReport(){
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,11), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function monthlyAvailedLeaveReport(){
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,12), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function detailAvailedLeaveReport(){
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,13), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    public function pendingLeaveApplicationReport(){
        $Emp = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->orderBy('emp_id')->get();
        if ($Emp->isEmpty()) {
            return redirect()->back()->with('error', 'No records to export.');
        }
        return Excel::download(new UsersExport($Emp,14), 'EmployeeMusterRollReport.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
