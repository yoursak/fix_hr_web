<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use Session;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\RequestMispunchList;
use App\Models\StaticMisPunchTimeType;
use App\Models\EmployeePersonalDetail;
use App\Models\ApprovalManagementCycle;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;

use Carbon\Carbon;
use Livewire\WithPagination;

class MispunchRequestListLivewire extends Component
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
        $checkBranchPermission = PolicySettingRoleAssignPermission::where('business_id', $businessId)
            ->where('emp_id', Session::get('login_emp_id'))
            ->first();
        $misPunchQuery = RequestMispunchList::join('employee_personal_details', 'request_mispunch_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->join('static_mispunch_timetype', 'request_mispunch_list.emp_miss_time_type', '=', 'static_mispunch_timetype.id')
            ->where('request_mispunch_list.business_id', $businessId)
            ->where('employee_personal_details.active_emp', '1')
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('request_mispunch_list.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            ->when($this->FromFilter !== null && $this->FromFilter !== '' && $this->ToFilter !== null && $this->ToFilter !== '', function ($query) {
                $query->where('request_mispunch_list.emp_miss_date','>=', $this->FromFilter)
                ->where('request_mispunch_list.emp_miss_date','<=', $this->ToFilter);
            })
            // ->where('request_mispunch_list.id', 268)
            ->orderByDesc('request_mispunch_list.id')
            ->select('request_mispunch_list.*', 'static_mispunch_timetype.time_type', 'employee_personal_details.profile_photo', 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.designation_id');

        if ($checkBranchPermission && $roleIdToCheck != 1 && $checkBranchPermission->permission_type == 2) {
            $DATA = $misPunchQuery->where('employee_personal_details.branch_id', $checkBranchPermission->permission_branch_id)->paginate($page)->withQueryString();
        } else {
            $DATA = $misPunchQuery->paginate($page)->withQueryString();
        }

        // dropdown static data
        $staticMisspunchTimeType = StaticMisPunchTimeType::all();

        $accessPermission = Central_unit::AccessPermission();
        list($moduleName, $permissions) = $accessPermission;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(3)[1];
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $loginEmpID = RulesManagement::PassBy()[2];


        $checkFirstRoleId = ApprovalManagementCycle::where('approval_type_id', 3)
            ->where('business_id', $businessId)
            ->pluck('role_id')
            ->first();

        $firstRoleIdData = json_decode($checkFirstRoleId ?? 0, true);
        $checkmfirstRoleId = !empty($firstRoleIdData) && is_array($firstRoleIdData) ? $firstRoleIdData[0] : 0;
        $roleIdData = json_decode($checkFistRoleId->role_id ?? 0);


        $Branch = Central_unit::BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();


        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', $businessId)
            ->where('approval_type_id', 3)
            ->where('cycle_type', 2)
            ->whereJsonContains('role_id', (string) $roleIdToCheck)
            ->first();


        $root = compact('checkmfirstRoleId', 'checkFirstRoleId', 'Branch', 'Department', 'Designation', 'checkApprovalCycleType', 'loginRoleBID', 'loginRoleID', 'loginEmpID', 'moduleName', 'permissions', 'DATA', 'staticMisspunchTimeType', 'parallerCaseApprovalListRoleIdCheck');

        return view('livewire.request.mispunch-request-list-livewire', $root);
    }
}
