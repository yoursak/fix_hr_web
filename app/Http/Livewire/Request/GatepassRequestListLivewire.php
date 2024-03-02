<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use Session;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticGoingThroughType;
use App\Models\RequestGatepassList;
use App\Models\ApprovalManagementCycle;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;

use Carbon\Carbon;
use Livewire\WithPagination;

class GatepassRequestListLivewire extends Component
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
        $page = $this->perPage ?? 10;
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        list($moduleName, $permissions) = Central_unit::AccessPermission();
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $baseQuery = RequestGatepassList::join('employee_personal_details', 'request_gatepass_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->where('request_gatepass_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('request_gatepass_list.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            ->when($this->FromFilter !== null && $this->FromFilter !== '' && $this->ToFilter !== null && $this->ToFilter !== '', function ($query) {
                $query->where('request_gatepass_list.date', '>=', $this->FromFilter)
                    ->where('request_gatepass_list.date', '<=', $this->ToFilter);
            })
            ->select(
                'request_gatepass_list.*',
                'employee_personal_details.profile_photo',
                'employee_personal_details.emp_name',
                'employee_personal_details.emp_mname',
                'employee_personal_details.emp_lname',
                'employee_personal_details.designation_id',
                'employee_personal_details.emp_mobile_number'
            )
            ->select(
                'request_gatepass_list.*',
                'employee_personal_details.profile_photo',
                'employee_personal_details.emp_name',
                'employee_personal_details.emp_mname',
                'employee_personal_details.emp_lname',
                'employee_personal_details.designation_id',
                'employee_personal_details.emp_mobile_number'
            )
            ->orderByDesc('request_gatepass_list.id');

        $DATA = $baseQuery->when($checkBranchPermission && $roleIdToCheck != 1 && $checkBranchPermission->permission_type == 2, function ($query) use ($checkBranchPermission, $page) {
            return $query->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->paginate($page)->withQueryString();
        }, function ($query) use ($page) {
            return $query->paginate($page)->withQueryString();
        });

        $approvalDetails = RulesManagement::ApprovalGetDetails(4);
        $checkApprovalCycleType = $approvalDetails[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];
        $going_through = StaticGoingThroughType::all();
        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', $businessId)
            ->where('approval_type_id', 4)
            ->where('cycle_type', 2)
            ->whereJsonContains('role_id', (string) $roleIdToCheck)
            ->first();



        $Branch = Central_unit::BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();
        $root = compact('parallerCaseApprovalListRoleIdCheck', 'Branch', 'Department', 'Designation', 'moduleName', 'going_through', 'permissions', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'DATA');

        return view('livewire.request.gatepass-request-list-livewire', $root);
    }
}
