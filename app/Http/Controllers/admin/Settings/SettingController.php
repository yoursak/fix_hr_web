<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\BranchList;
use App\Models\admin\DepartmentList;
use App\Models\admin\DesignationList;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

// Use Alert;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.setting');
    }

    // account setting 
    public function account()
    {
        $accDetail = DB::table('login_admin')->where('business_id', Session::get('business_id'))->first();
        return view('admin.setting.account.account', compact('accDetail'));
    }

    // business setting 
    public function business()
    {
        return view('admin.setting.business.business');
    }
    public function admin()
    {
        return view('admin.setting.business.admin.admin_setting');
    }
    public function branches()
    {
        return view('admin.setting.business.branches.branches');
    }
    public function department()
    {

        $branchList = BranchList::all();
        $deparmentList = DepartmentList::all();

        $data = compact('deparmentList', 'branchList');

        // <?=DB::table('department_list')->where('branch_id',$items->branch_id)->select('depart_name')->get()
        return view('admin.setting.business.department.department', $data);
    }
    public function designation(Request $request)
    {
        $item = DesignationList::where('desig_id', $request->id)->first();


        // if($getvalue){
        //     return response()->json(["editDesignationResult"=>$getvalue]);
        // }

        return view('admin.setting.business.designation.designation', compact($item));
    }

    // designationDetails ajax list shows
    public function allDepartment(Request $request)
    {

        $get = DepartmentList::where('branch_id', $request->brand_id)->get();
        return response()->json(["department" => $get]);
    }
    public function designationDetails(Request $request)
    {
        // return response()->json(['editDesignationResult'=>$getvalue]);
    }

    // addition functions 
    public function AddBranch(Request $request)
    {

        $data = [
            'business_id' => $request->session()->get('business_id'),
            'branch_id' => md5($request->session()->get('business_id') . $request->branch),
            'branch_name' => $request->branch
        ];
        $addBranch = DB::table('branch_list')->insert($data);

        if ($addBranch) {
            Alert::success('Added Success', 'Create Branch Successfully');
        }
        return redirect()->route('admin.branch');
    }

    public function AddDepartment(Request $request)
    {
        // dd($request);
        $department = new DepartmentList;
        $department->depart_name = $request->department;
        $department->branch_id = $request->branch;
        $department->status = 0;
        if ($department->save()) {
            Alert::success('Added Success', 'Create Department Name Successfully');
        }
        return redirect()->route('admin.department');
    }
    public function AddDesignation(Request $request)
    {
        $designation = new DesignationList;
        $designation->business_id = $request->session()->get('business_id');
        $designation->desig_name = $request->designation;
        $designation->department_id = $request->department;
        $designation->branch_id = $request->branch;

        if ($designation->save()) {
            Alert::success('Added Success', 'Create Designation Name Successfully');
        }
        return redirect()->route('admin.designation');
    }




    // update Functions 
    public function UpdateBranch(Request $request)
    {
        $branch = DB::table('branch_list')->where('id', $request->editBranchId)->where('business_id', Session::get('business_id'))->update(['branch_name' => $request->editbranch]);

        if ($branch) {
            Alert::success('Data Updated', 'Updated  Created');
            return redirect()->route('admin.branch');
        }
    }
    public function UpdateDepartment(Request $request)
    {
        $department = DepartmentList::where('depart_id', $request->editid)
            ->where('b_id', $request->session()->get('business_id'))
            ->update([
                'b_id' => $request->session()->get('business_id'),
                'branch_id' => $request->editbranch,
                'depart_name' => $request->editdepartment,
            ]);

        if ($department) {
            Alert::success('Data Designation Updated', 'Updated Designation Created');
        }
        return redirect()->route('admin.department');
    }
    public function UpdateDesignation(Request $request)
    {
        // dd($request->all());
        $designation = DesignationList::where('desig_id', $request->editid)
            ->where('business_id', $request->session()->get('business_id'))
            ->update([
                'business_id' => $request->session()->get('business_id'),
                'branch_id' => $request->editbranch,
                'department_id' => $request->editdepartment,
                'desig_name' => $request->editdesignation
            ]);
        if ($designation) {
            Alert::success('Data Designation Updated', 'Updated Designation Created');
        }
        return redirect()->route('admin.designation');
    }


    // Delete Functions
    public function DeleteBranch($id)
    {

        $branchLList = DB::table('branch_list')->where('id', $id)->where('business_id', Session::get('business_id'))->first();
        $departmentList = DB::table('department_list')->where('branch_id', $branchLList->branch_id)->first();
        if (isset($departmentList)) {
            // echo "DATA hy iska";
            Alert::warning('Data Persent', 'Department also  created');
        }
        if (!isset($departmentList)) {
            // echo "empty hy ayh";
            $roos = DB::table('branch_list')->where('id', $id)->delete();
            // if (isset($roos)) {
            Alert::success(' Delete Success', 'Your Added Delete Successfully');
            // }
        }
        return redirect()->route('admin.branch');
    }

    public function DeleteDepartment($departID)
    {
        $department = DB::table('department_list')->where('depart_id', $departID)->first();
        $designation = DB::table('designation_list')->where('department_id', $department->depart_id)->first();

        if (isset($designation)) {
            // echo "DATA hy iska";
            Alert::warning('Data Persent', 'Designation also  created');
        }
        if (!isset($designation)) {
            // echo "empty hy ayh";
            $roos = DB::table('department_list')->where('depart_id', $departID)->delete();
            // if (isset($roos)) {
            Alert::success(' Delete Success', 'Your Added Delete Successfully');
            // }
        }
        return redirect()->route('admin.department');
    }

    public function DeleteDesignation($id)
    {
        $designation = DesignationList::where('desig_id', $id)->delete();
        // dd($designation);
        if ($designation) {
            Alert::success('Delete Success', 'Delete Desgination Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !'); 
        return redirect()->route('admin.designation');
    }

    public function holidayPolicy()
    {
        return view('admin.setting.business.holiday_policy.holiday_policy');
    }
    public function inviteEmpl()
    {
        return view('admin.setting.business.invite_empl.invite_empl');
    }
    public function leavePolicy()
    {
        $listData = DB::table('setting_leave_policy')->get();
        $load = compact('listData');
        return view('admin.setting.business.leave_policy.leave_policy', $load);
    }

    public function leavePolicySubmit(Request $request)
    {
        // dd($request->all());
        $BusinessID = $request->session()->get('business_id');
        $branchID = $request->session()->get('branch_id');
        $storeData = [
            'business_id' => $BusinessID,
            'branch_id' => ($branchID != '') ? $branchID : '',
            'policy_name' => $request->policyname,
            'leave_policy_cycle_monthly' => ($request->btnradio != 1) ? 0 : 1,
            'leave_policy_cycle_yearly' => ($request->btnradio != 2) ? 0 : 2,
            'leave_period_from' => $request->leave_periodfrom,
            'leave_period_to' => $request->leave_periodto,
        ];
        $truechecking_id = DB::table('setting_leave_policy')->insert($storeData);
        if ($truechecking_id) {
            $latestID = DB::table('setting_leave_policy')->latest()->select('id')->first();
            if (isset($latestID)) {
                $latestLeavePolicyID = $latestID->id; //generate policy ID run time

                $CategoryName = $request->category_name;
                $Days = $request->days;
                $UnusedLeaveRule = $request->unused_leave_rule;
                $carryForwardLimit = $request->carry_forward_limit;
                $applicationTo = $request->applicable_to;

                for ($i = 0; $i < sizeof($request->category_name); $i++) {
                    $collectionDataSet = [
                        'leave_policy_id' => $latestLeavePolicyID,
                        'business_id' => $BusinessID,
                        'branch_id' => $branchID,
                        'category_name' => $CategoryName[$i],
                        'days' => $Days[$i],
                        'unused_leave_rule' => $UnusedLeaveRule[$i],
                        'carry_forward_limit' => $carryForwardLimit[$i],
                        'applicable_to' => $applicationTo[$i]
                    ];
                    print_r($collectionDataSet);
                    DB::table('setting_leave_category')->insert($collectionDataSet);
                }
            }
            Alert::success('Added', 'Your Leave-Policy Added Successfully');
        } else {
            Alert::info('Not Added', 'Your Leave-Policy Not Added');
        }
        return back();
    }

    public function manageEmpDetails()
    {
        return view('admin.setting.business.manage_emp.manage');
    }
    public function manager()
    {
        return view('admin.setting.business.manager.manager');
    }
    public function weeklyHoliday()
    {
        return view('admin.setting.business.weekly_holiday.weekly_holiday');
    }

    // business info 
    public function businessinfo()
    {
        return view('admin.setting.businessinfo.businessinfo');
    }


    // attendance setting 
    public function attendance()
    {
        return view('admin.setting.attendance.attendance');
    }
    public function createShift()
    {
        $Shifts = DB::table('shifts')->where('business_id', Session::get('business_id'))->GET();
        return view('admin.setting.attendance.createshift', compact('Shifts'));
    }


    // automation rule
    public function automation()
    {
        return view('admin.setting.attendance.automation');
    }
    public function asignEmp()
    {
        return view('admin.setting.attendance.rules.add_emp');
    }
    public function breakRule()
    {
        return view('admin.setting.attendance.rules.break_rule');
    }
    public function earlyExit()
    {
        return view('admin.setting.attendance.rules.early_exit');
    }
    public function lateEntry()
    {
        return view('admin.setting.attendance.rules.late_entry');
    }
    public function overtimeRule()
    {
        return view('admin.setting.attendance.rules.overtime_rule');
    }
    public function earlyOvertimes()
    {
        return view('admin.setting.attendance.rules.early_overtimes');
    }

    public function attOnHoliday()
    {
        return view('admin.setting.attendance.attendance_on_holiday');
    }



    // salary setting
    public function salary()
    {
        return view('admin.setting.salary.salary');
    }
    public function salaryTemp()
    {
        return view('admin.setting.salary.salary_structure_temp');
    }
    public function EmpAcDetail()
    {
        return view('admin.setting.salary.employee_acc_detail');
    }
    public function other()
    {
        return view('admin.setting.other.other');
    }
}
