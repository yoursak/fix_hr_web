<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Helpers\Central_unit;
use App\Models\admin\setupsettings\MasterEndGameModel;

use Illuminate\Support\Facades\Route;
use App\Helpers\MasterRulesManagement\RulesManagement;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

// models
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\ApprovalManagementCycle;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\AttendanceList;
use App\Models\AttendanceTimeLog;
use App\Models\EmployeePersonalDetail;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\LoginEmployee;
use App\Models\PolicyMasterEndgameMethod;
// use Alert;
use Carbon\Carbon;

use Livewire\WithPagination;
class AttendanceSummaryLvewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $monthFilter, $totalDays, $today, $perPage;
    public function mount()
    {
        $this->getDepartment();
        $this->getDesignation();
        $this->totalDays = date('t');
        $this->today = date('d');
        $this->monthFilter = date('Y-m');
    }

    public function MonthFilter($value)
    {
        $this->monthFilter = $value;
        list($year, $month) = explode('-', $value);
        $year = (int) $year;
        $month = (int) $month;
        $this->totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $this->today = $month == date('m') && $year == date('Y') ? $this->today : $this->totalDays;
    }
    public function getDepartment()
    {
        $branch_ID = $this->branchFilter;
        $get = EmployeePersonalDetail::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')->where('employee_personal_details.branch_id', $branch_ID)->where('employee_personal_details.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')->distinct()->get();
        return $get;
    }
    public function getDesignation()
    {

        $branch_ID = $this->branchFilter;
        $get = EmployeePersonalDetail::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $this->departmentFilter)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return $get;
    }
    public function render()
    {


        $monthFilter = $this->monthFilter;
        $totalDays = $this->totalDays;
        $call = new Central_unit();
        $Branch = $call->BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', $businessId)->where('emp_id', Session::get('login_emp_id'))->first();

        $Emp = EmployeePersonalDetail::where('employee_personal_details.business_id', $businessId)
            ->leftJoin('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
            ->leftJoin('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->leftJoin('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
                $searchFind = "%{$this->searchFilter}%";
                $query->where(function ($query) use ($searchFind) {
                    $query
                        ->where('employee_personal_details.emp_name', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_mname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_lname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_id', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_date_of_joining', 'like', date('d-M-Y', strtotime($searchFind)))
                        ->orWhere('employee_personal_details.emp_mobile_number', 'like', $searchFind)
                        ->orWhere('branch_list.branch_name', 'like', $searchFind)
                        ->orWhere('department_list.depart_name', 'like', $searchFind)
                        ->orWhere('designation_list.desig_name', 'like', $searchFind);
                });
            })
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('employee_personal_details.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            ->where('active_emp', 1)
            ->select('employee_personal_details.*');

        if ($permissionBranchId !== null && !empty($permissionBranchId) && $roleIdToCheck != 1 && $permissionBranchId->permission_type == 2) {
            $page = $this->perPage != null ? $this->perPage : 10;
            $Emp = $Emp
                ->where('employee_personal_details.branch_id', $permissionBranchId->permission_branch_id)
                ->paginate($page)
                ->withQueryString();
        } else {
            $page = $this->perPage != null ? $this->perPage : 10;
            $Emp = $Emp->paginate($page)->withQueryString();
        }
        $designation = DesignationList::where('business_id', $businessId)->first();
        return view('livewire.attendance.attendance-summary-lvewire', compact('Emp', 'Branch', 'Department', 'Designation', 'totalDays', 'monthFilter'));
    }
}
