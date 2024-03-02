<?php

namespace App\Http\Livewire\Request;

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
use App\Models\RequestOutdoorList;
use App\Models\LoginEmployee;
use App\Models\PolicyMasterEndgameMethod;
// use Alert;
use Carbon\Carbon;
use Livewire\WithPagination;

class OutDoorListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $tableShows;

    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $fromFilter, $toFilter;
    public $perPage;

    public function mount(){
        $this->fromFilter = date('Y-m-d',strtotime(date('Y-m-').'1'));
        $this->toFilter = date('Y-m-d',strtotime(date('Y-m-').date('t')));
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
        // dd($this->fromFilter,$this->toFilter);
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        list($moduleName, $permissions) = Central_unit::AccessPermission();
        $businessId = Session::get('business_id');
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();

        $baseQuery = RequestOutdoorList::join('employee_personal_details', 'request_outdoor_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('request_outdoor_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            // ->whereMonth('request_outdoor_list.apply_date', now()->month)
            // ->whereYear('request_outdoor_list.apply_date', now()->year)
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('request_outdoor_list.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            ->when($this->fromFilter !== null && $this->fromFilter !== '' && $this->toFilter !== null && $this->toFilter !== '', function ($query) {
                $query->where('request_outdoor_list.apply_date','>=', $this->fromFilter)
                ->where('request_outdoor_list.apply_date','<=', $this->toFilter);
            })
            ->selectRaw('request_outdoor_list.*, department_list.depart_name, branch_list.branch_name, designation_list.desig_name, employee_personal_details.emp_name, employee_personal_details.emp_mname, employee_personal_details.emp_lname, employee_personal_details.emp_mobile_number, employee_personal_details.profile_photo, DATE_FORMAT(request_outdoor_list.apply_date, "%d-%m-%Y") as formatted_apply_date, TIME_FORMAT(request_outdoor_list.out_time, "%h:%i %p") as formatted_out_time')
            ->orderByDesc('request_outdoor_list.id');
        if ($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2)) {
            $DATA = $baseQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->paginate($page)
                ->withQueryString();
        } else {
            $DATA = $baseQuery->paginate($page)
                ->withQueryString();
        }
        $Branch = Central_unit::BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();
        $root = compact('moduleName', 'permissions', 'DATA', 'Branch', 'Department', 'Designation');
        return view('livewire.request.out-door-list-livewire', $root);
    }
}
