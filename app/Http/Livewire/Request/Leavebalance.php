<?php

namespace App\Http\Livewire\Request;

use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Resources\Api\UserSideResponse\LeaveBalanceListResource;
use App\Models\admin\AttendanceList;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\PolicyCompOffLwopLeave;
use App\Models\PolicySettingLeaveCategory;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\RequestLeaveList;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Leavebalance extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $tableShows;
    public $count = 1;
    public $arrayList, $perPage, $AllData;
    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $dateFilter;

    public function mount()
    {
        $this->getData();
        $this->getDepartment();
        $this->getDesignation();
    }

    public function getDepartment()
    {
        $branch = $this->branchFilter;
        $get = EmployeePersonalDetail::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')->where('employee_personal_details.branch_id', $branch)->where('employee_personal_details.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')->distinct()->get();
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

    public function getData()
    {
        $LeaveBalance = [];
        $loginRoleID = Session::get('login_role');
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', Session::get('business_id'))->where('emp_id', Session::get('login_emp_id'))->first();
        if ($permissionBranchId !== null && !empty($permissionBranchId)) {
            $permissionType = $permissionBranchId->permission_type;
            $permissionBranchIdCheck = $permissionBranchId->permission_branch_id;
        }
        $query = DB::table('employee_personal_details')
            ->leftJoin('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
            ->leftJoin('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->leftJoin('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.active_emp', '1')
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('employee_personal_details.branch_id', $this->branchFilter);
            })
            ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->departmentFilter);
            })
            ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designationFilter);
            })
            ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
                $searchFind = "%{$this->searchFilter}%";
                $query->where(function ($query) use ($searchFind) {
                    $query
                        ->where('employee_personal_details.emp_name', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_mname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_lname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_id', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_mobile_number', 'like', $searchFind)
                        ->orWhere('branch_list.branch_name', 'like', $searchFind)
                        ->orWhere('department_list.depart_name', 'like', $searchFind)
                        ->orWhere('designation_list.desig_name', 'like', $searchFind);
                });
            })
            ->select('employee_personal_details.*', 'designation_list.desig_name');
        if ($permissionBranchId !== null && !empty($permissionBranchId) && $loginRoleID != 1 && $permissionType != 1) {
            $this->tableShows = $query->where('employee_personal_details.branch_id', $permissionBranchIdCheck)->get();
        } else {
            $this->tableShows = $query->get();
        }
        // RulesManagement::checkingCurrentleaveBalanceList
        // dd($ds);
        // $responseArray = json_decode($ds->getContent(), true);
        // $LeaveBalance[] = $responseArray;
        foreach ($this->tableShows as $key => $value) {
            $responseArray =  RulesManagement::checkingCurrentLeaveBalanceList($value->emp_id, $value->business_id);
            $Employee = EmployeePersonalDetail::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
                ->where('employee_personal_details.business_id', Session::get('business_id'))->where('employee_personal_details.emp_id', $responseArray['emp_id'])->select('employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'employee_personal_details.emp_lname', 'employee_personal_details.profile_photo', 'designation_list.desig_name')->first();
            $responseArray['full_name'] = ($Employee->emp_name ?? '') . ' ' . ($Employee->emp_mname ?? '') . '' . ($Employee->emp_lname ?? '');
            $responseArray['desig_name'] = $Employee->desig_name;
            $responseArray['profile_photo'] = $Employee->profile_photo;
            $LeaveBalance[] = $responseArray;
        }
        $this->AllData = $LeaveBalance;
        $paginatedData = $this->paginate($this->AllData);
        $Emp = $paginatedData;
        return $Emp;
    }

    public function render()
    {
        $Emp =  $this->getData();
        $StaticLeavesCategory = DB::table('policy_master_endgame_method')
            ->leftJoin('policy_setting_leave_policy', 'policy_setting_leave_policy.id', '=', 'policy_master_endgame_method.leave_policy_ids_list')
            ->leftJoin('policy_setting_leave_category', 'policy_setting_leave_category.leave_policy_id', '=', 'policy_setting_leave_policy.id')
            ->leftJoin('static_leave_category', 'static_leave_category.id', '=', 'policy_setting_leave_category.category_name')
            ->where('policy_master_endgame_method.method_switch', '1')
            ->where('policy_master_endgame_method.business_id', Session::get('business_id'))
            ->select('static_leave_category.*')
            ->distinct()
            ->get();

        $checkCompOff = DB::table('policy_comp_off_lwop_leave')->where('business_id', Session::get('business_id'))->first();

        if ($checkCompOff) {
            $newElements = []; // Initialize an array to store new elements

            if ($checkCompOff->holiday_weekly_checked || $checkCompOff->overtime_checked) {
                $newElementCO = (object) [
                    'id' => 8,
                    'name' => 'Comp-Off (CO)',
                    'sort_name' => 'CO',
                    'description' => 'Description of Comp-Off (CO)',
                    'paid_leave' => 1,
                    'unpaid_leave' => 0,
                    'dynamic_table_print' => 1,
                ];
                $newElements[] = $newElementCO; // Add CO element to the array
            }

            if ($checkCompOff->lwop_leave_checked) {
                $newElementLWP = (object) [
                    'id' => 9,
                    'name' => 'Leave Without Pay (LWP)',
                    'sort_name' => 'CO',
                    'description' => 'Description of Leave Without Pay (LWP)',
                    'paid_leave' => 1,
                    'unpaid_leave' => 0,
                    'dynamic_table_print' => 1,
                ];
                $newElements[] = $newElementLWP; // Add LWP element to the array
            }

            // Merge new elements into StaticLeavesCategory
            $StaticLeavesCategory = array_merge($StaticLeavesCategory->toArray(), $newElements);
        }

        // Now $StaticLeavesCategory contains both the original elements and the new elements
        $Branch = Central_unit::BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();

        return view('livewire.request.leavebalance', compact('Branch', 'Emp', 'StaticLeavesCategory',  'Department', 'Designation'));
    }

    public function paginate($items)
    {
        $currentPage = $this->page ?: 1;
        $perPage = $this->perPage > 0 ? $this->perPage : 10; // Set a default value if $perPage is zero or not initialized

        // Manually paginate the array
        $offset = ($currentPage - 1) * $perPage;
        $items = array_slice($items, $offset, $perPage);

        // Create a LengthAwarePaginator instance
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            count($this->AllData),
            $perPage,
            $currentPage
        );
    }
}
