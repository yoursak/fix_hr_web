<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\Branch_list;
use App\Models\admin\Department_list;
use App\Models\admin\Designation_list;

class SettingController extends Controller
{
    public function index(){
        return view('admin.setting.setting');
    }

    // account setting 
    public function account(){
        return view('admin.setting.account.account');
    }

    // business setting 
    public function business(){
        return view('admin.setting.business.business');
    }
    public function admin(){
        return view('admin.setting.business.admin.admin_setting');
    }
    public function branches(){
        return view('admin.setting.business.branches.branches');
    }
    public function department(){
        return view('admin.setting.business.department.department');
    }
    public function designation(){
        return view('admin.setting.business.designation.designation');
    }
    public function holidayPolicy(){
        return view('admin.setting.business.holiday_policy.holiday_policy');
    }
    public function inviteEmpl(){
        return view('admin.setting.business.invite_empl.invite_empl');
    }
    public function leavePolicy(){
        return view('admin.setting.business.leave_policy.leave_policy');
    }
    public function manageEmpDetails(){
        return view('admin.setting.business.manage_emp.manage');
    }
    public function manager(){
        return view('admin.setting.business.manager.manager');
    }
    public function weeklyHoliday(){
        return view('admin.setting.business.weekly_holiday.weekly_holiday');
    }

    // business info 
    public function businessinfo(){
        return view('admin.setting.businessinfo.businessinfo');
    }


    // attendance setting 
    public function attendance(){
        return view('admin.setting.attendance.attendance');
    }
    public function createShift(){
        return view('admin.setting.attendance.createshift');
    }


    // automation rule
    public function automation(){
        return view('admin.setting.attendance.automation');
    }
    public function asignEmp(){
        return view('admin.setting.attendance.rules.add_emp');
    } 
    public function breakRule(){
        return view('admin.setting.attendance.rules.break_rule');
    } 
    public function earlyExit(){
        return view('admin.setting.attendance.rules.early_exit');
    } 
    public function lateEntry(){
        return view('admin.setting.attendance.rules.late_entry');
    } 
    public function overtimeRule(){
        return view('admin.setting.attendance.rules.overtime_rule');
    } 
    public function earlyOvertimes(){
        return view('admin.setting.attendance.rules.early_overtimes');
    } 

    public function attOnHoliday(){
        return view('admin.setting.attendance.attendance_on_holiday');
    } 



    // salary setting
    public function salary(){
        return view('admin.setting.salary.salary');
    }
    public function salaryTemp(){
        return view('admin.setting.salary.salary_structure_temp');
    }
    public function EmpAcDetail(){
        return view('admin.setting.salary.employee_acc_detail');
    }
    public function other(){
        return view('admin.setting.other.other');
    }





    // Deletion Functions 

    public function DeleteBranch($id){
        $department = Department_list::where('branch_id', $id)->first();
        if(isset($department)){
            return redirect()->route('admin.branch');
        }
        $branch = Branch_list::where('branch_id', $id)->delete();
        return redirect()->route('admin.branch');
    }
    public function DeleteDepartment($id){
        $designation = Designation_list::where('department_id', $id)->first();
        if(isset($designation)){
            // dd(isset($designation));
            return redirect()->route('admin.department');
        }
        $department = Department_list::where('depart_id', $id)->delete();
        return redirect()->route('admin.department');
    }

    public function DeleteDesignation($id){
        $designation = Designation_list::where('desig_id', $id)->delete();
        // dd($designation);
        // Session::flash('success', 'Succefully Deleted !'); 
        return redirect()->route('admin.designation');
    }


    // addition functions 

    public function AddBranch(Request $request){
        // dd($request->branch);
        $branch = new Branch_list;
        $branch-> branch_name = $request->branch;
        $branch-> status = 0;
        $branch-> save();


        return redirect()->route('admin.branch');
    }

    public function AddDepartment(Request $request){
        // dd($request);
        $department = new Department_list;
        $department-> depart_name = $request->department;
        $department-> branch_id = $request->branch;
        $department-> status = 0;
        $department-> save();


        return redirect()->route('admin.department');
    }
    public function AddDesignation(Request $request){
        // dd($request);
        $designation = new Designation_list;
        $designation-> desig_name = $request->designation;
        $designation-> department_id = $request->department;
        $designation-> branch_id = $request->branch;
        $designation-> save();


        return redirect()->route('admin.designation');
    }
    

}
