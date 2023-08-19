<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


}
