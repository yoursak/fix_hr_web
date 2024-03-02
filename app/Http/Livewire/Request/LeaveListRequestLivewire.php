<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use Session;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;

// models
use App\Models\ApprovalManagementCycle;
use App\Models\StaticLeaveShiftType;
use App\Models\StaticRequestLeaveType;
use App\Models\RequestLeaveList;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\EmployeePersonalDetail;

// use Alert;
use Carbon\Carbon;
use Livewire\WithPagination;

class LeaveListRequestLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $tableShows;

    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $FromFilter, $ToFilter;
    public $perPage;

    public function mount()
    {
        $this->FromFilter = date('Y-m-d', strtotime(date('Y-m-') . '1'));
        $this->ToFilter = date('Y-m-d', strtotime(date('Y-m-') . date('t')));
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
        $fromDate = Carbon::now()->firstOfMonth()->toDateString(); // Format as 'Y-m-d'
        $toDate = Carbon::now()->lastOfMonth()->toDateString();    // Format as 'Y-m-d'

        $page = $this->perPage ?? 10;
        // session data
        $businessId = session('business_id');
        $roleIdToCheck = session('login_role');

        $Branch = Central_unit::BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();
        [$moduleName, $permissions] = Central_unit::AccessPermission();

        [$checkApprovalCycleType, $loginRoleBID, $loginEmpID, $loginRoleID] = RulesManagement::PassBy();
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(2)[1];
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', session('login_emp_id'))
            ->first();

        $shiftType = StaticLeaveShiftType::all();
        $leaveType = StaticRequestLeaveType::all();

        // main table data
        $leaveQuery = RequestLeaveList::join('employee_personal_details', 'request_leave_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_leave_category', 'static_leave_category.id', '=', 'request_leave_list.leave_category')
            ->join('static_request_leave_type', 'static_request_leave_type.id', '=', 'request_leave_list.leave_type')
            ->where('request_leave_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('request_leave_list.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            // ->where(function ($query) use ($fromDate, $toDate) {
            //     $query->where(function ($subquery) {
            //         $subquery->whereMonth('request_leave_list.apply_date', now()->month)
            //             ->whereYear('request_leave_list.apply_date', now()->year);
            //     })->orWhere(function ($subquery) use ($fromDate, $toDate) {
            //         $subquery->whereBetween('request_leave_list.from_date', [$fromDate, $toDate])
            //             ->orWhereBetween('request_leave_list.to_date', [$fromDate, $toDate]);
            //     });
            // })
            // ->where('request_leave_list.id', 284)
            ->when($this->FromFilter !== null && $this->FromFilter !== '' && $this->ToFilter !== null && $this->ToFilter !== '', function ($query) {
                $query->where('request_leave_list.from_date', '>=', $this->FromFilter)
                    ->where('request_leave_list.to_date', '<=', $this->ToFilter);
            })
            ->orderByDesc('request_leave_list.id')
            ->select('request_leave_list.*', 'static_request_leave_type.leave_day', 'static_leave_category.name as category_name', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.designation_id', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname');

        $DATALEAVE = $leaveQuery->when($checkBranchPermission !== null && !empty($checkBranchPermission) && $roleIdToCheck != 1 && ($checkBranchPermission->permission_type == 2), function ($query) use ($checkBranchPermission) {
            return $query->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id);
        })->paginate($page)->withQueryString();

        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', session('business_id'))
            ->where('approval_type_id', 2)
            ->where('cycle_type', 2)
            ->whereJsonContains('role_id', (string) $roleIdToCheck)
            ->first();

        $Count = Central_unit::LeaveSectionCount();
        return view('livewire.request.leave-list-request-livewire', compact('parallerCaseApprovalListRoleIdCheck', 'moduleName', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATALEAVE', 'leaveType', 'shiftType', 'Branch', 'Count', 'Department', 'Designation'));
    }
}
