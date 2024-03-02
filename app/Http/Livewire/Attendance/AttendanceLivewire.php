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

class AttendanceLivewire extends Component
{
    use WithPagination;
    public $listeners = ['showPresentModel' => 'modeGet'];
    protected $paginationTheme = 'bootstrap';
    protected $tableShows;

    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $dateFilter;
    public $perPage;

    public function mount()
    {
        $this->dateFilter = date('Y-m-d');
        $this->getData();
        $this->getDepartment();
        $this->getDesignation();
    }

    public function showPresentModel($data)
    {

        $this->emit('modeGet', $data);

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
    public function getData()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::now()->day;
        $currentDate = $this->dateFilter ? $this->dateFilter : date('Y-m-d');

        $checkSeqId = 0;
        $loginRoleID = Session::get('login_role');
        $businessId = Session::get('business_id');
        $page = $this->perPage != null ? $this->perPage : 10;
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(1)[1];
        $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::where('business_id', $businessId)
            ->where('approval_type_id', 1)
            ->where('cycle_type', 2)
            ->where(function ($query) use ($loginRoleID) {
                $query->whereJsonContains('role_id', (string) $loginRoleID)->orWhereJsonContains('role_id', (string) $loginRoleID);
            })
            ->first();
        $DATA = AttendanceList::
            join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
            ->leftJoin('branch_list', 'branch_list.branch_id', '=', 'attendance_list.branch_id')
            ->leftJoin('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->leftJoin('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
            ->leftJoin('static_attendance_shift_type', 'static_attendance_shift_type.id', '=', 'employee_personal_details.assign_shift_type') // Use leftJoin for inclusion of null values
            // ->where('employee_personal_details.active_emp', '1')
            ->where('employee_personal_details.business_id', $businessId)
            ->whereDate('attendance_list.punch_date', ($this->dateFilter ? $this->dateFilter : date('Y-m-d')))
            ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                $query->where('attendance_list.branch_id', $this->branchFilter);
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
                        ->orWhere('employee_personal_details.emp_date_of_joining', 'like', date('d-M-Y', strtotime($searchFind)))
                        ->orWhere('employee_personal_details.emp_mobile_number', 'like', $searchFind)
                        ->orWhere('branch_list.branch_name', 'like', $searchFind)
                        ->orWhere('department_list.depart_name', 'like', $searchFind)
                        ->orWhere('designation_list.desig_name', 'like', $searchFind)
                        ->orWhere('static_attendance_shift_type.name', 'like', $searchFind)
                        ->orWhere('static_attendance_methods.method_name', 'like', $searchFind);
                });
            })
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('attendance_list.*', DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"), DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"), 'employee_personal_details.emp_name', 'employee_personal_details.emp_mname', 'static_attendance_methods.method_name', 'employee_personal_details.profile_photo', 'employee_personal_details.designation_id', 'employee_personal_details.emp_lname', 'employee_personal_details.department_id')
            ->orderBy('attendance_list.id', 'desc');
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', $businessId)->where('emp_id', Session::get('login_emp_id'))->first();
        if ($permissionBranchId !== null && !empty($permissionBranchId)) {
            $permissionType = $permissionBranchId->permission_type;
            $permissionBranchIdCheck = $permissionBranchId->permission_branch_id;

        }

        if ($permissionBranchId !== null && !empty($permissionBranchId) && $loginRoleID != 1 && $permissionType != 1) {
            $tableShows = $DATA->where('attendance_list.branch_id', $permissionBranchIdCheck)->paginate($page)->withQueryString();
            if ($checkApprovalCycleType == 2) {
                $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::join('attendance_list', 'attendance_list.business_id', '=', 'approval_management_cycle.business_id')
                    ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
                    ->where('approval_management_cycle.business_id', $businessId)
                    ->where('attendance_list.branch_id', $permissionBranchIdCheck)
                    ->where('attendance_list.emp_today_current_status', 2)
                    ->where('attendance_list.final_status', 0)
                    ->where('approval_management_cycle.approval_type_id', 1)
                    ->where('approval_management_cycle.cycle_type', 2)
                    ->whereDate('attendance_list.punch_date', ($this->dateFilter ? $this->dateFilter : date('Y-m-d')))
                    ->where(function ($query) use ($loginRoleID) {
                        $query->whereJsonContains('approval_management_cycle.role_id', (string) $loginRoleID)
                            ->orWhereJsonContains('approval_management_cycle.role_id', (string) $loginRoleID);
                    })
                    ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                        $query->where('attendance_list.branch_id', $this->branchFilter);
                    })
                    ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                        $query->where('employee_personal_details.department_id', $this->departmentFilter);
                    })
                    ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                        $query->where('employee_personal_details.designation_id', $this->designationFilter);
                    })

                    ->first();

            } else if ($checkApprovalCycleType == 1) {
                $checkSeqId = DB::table('attendance_list')
                    ->where('attendance_list.business_id', $businessId)
                    ->where('attendance_list.branch_id', $permissionBranchIdCheck)
                    ->whereYear('attendance_list.punch_date', $currentYear)
                    ->whereMonth('attendance_list.punch_date', $currentMonth)
                    ->whereDate('attendance_list.punch_date', '<>', Carbon::today()) // Exclude today's data
                    ->where('forward_by_role_id', $loginRoleID)->first();
            }
            $distinctPunchDates = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('attendance_list.final_status', '0')
                ->where('attendance_list.business_id', Session::get('business_id'))
                ->where('attendance_list.branch_id', $permissionBranchIdCheck)
                ->whereYear('attendance_list.punch_date', $currentYear)
                ->whereMonth('attendance_list.punch_date', $currentMonth)
                ->whereDate('attendance_list.punch_date', '<>', Carbon::today()) // Exclude today's data
                ->select('attendance_list.punch_date', 'final_status')
                ->distinct()
                ->get();
        } else {

            $tableShows = $DATA->paginate($page)->withQueryString();
            if ($checkApprovalCycleType == 2) {
                $parallerCaseApprovalListRoleIdCheck = ApprovalManagementCycle::join('attendance_list', 'attendance_list.business_id', '=', 'approval_management_cycle.business_id')
                    ->join('employee_personal_details', 'attendance_list.emp_id', '=', 'employee_personal_details.emp_id')
                    ->where('approval_management_cycle.business_id', $businessId)
                    ->where('approval_management_cycle.approval_type_id', 1)
                    ->where('attendance_list.emp_today_current_status', 2)
                    ->where('attendance_list.final_status', 0)
                    ->where('approval_management_cycle.cycle_type', 2)
                    ->whereDate('attendance_list.punch_date', ($this->dateFilter ? $this->dateFilter : date('Y-m-d')))
                    ->where(function ($query) use ($loginRoleID) {
                        $query->whereJsonContains('approval_management_cycle.role_id', (string) $loginRoleID)
                            ->orWhereJsonContains('approval_management_cycle.role_id', (string) $loginRoleID);
                    })
                    ->when($this->branchFilter !== null && $this->branchFilter !== '', function ($query) {
                        $query->where('attendance_list.branch_id', $this->branchFilter);
                    })
                    ->when($this->departmentFilter !== null && $this->departmentFilter !== '', function ($query) {
                        $query->where('employee_personal_details.department_id', $this->departmentFilter);
                    })
                    ->when($this->designationFilter !== null && $this->designationFilter !== '', function ($query) {
                        $query->where('employee_personal_details.designation_id', $this->designationFilter);
                    })
                    ->first();
            } else if ($checkApprovalCycleType == 1) {
                $checkSeqId = DB::table('attendance_list')
                    ->where('attendance_list.business_id', $businessId)
                    ->whereYear('attendance_list.punch_date', $currentYear)
                    ->whereMonth('attendance_list.punch_date', $currentMonth)
                    ->whereDate('attendance_list.punch_date', '<>', Carbon::today()) // Exclude today's data
                    ->where('forward_by_role_id', $loginRoleID)->first();
            }
            $distinctPunchDates = AttendanceList::join('employee_personal_details', 'employee_personal_details.emp_id', '=', 'attendance_list.emp_id')
                ->where('employee_personal_details.active_emp', '1')
                ->where('attendance_list.final_status', '0')
                ->where('attendance_list.business_id', Session::get('business_id'))
                ->whereYear('attendance_list.punch_date', $currentYear)
                ->whereMonth('attendance_list.punch_date', $currentMonth)
                ->whereDate('attendance_list.punch_date', '<>', Carbon::today()) // Exclude today's data
                ->select('attendance_list.punch_date', 'final_status')
                ->distinct()
                ->get();
        }

        $checkApprovalforwardId = AttendanceList::where('business_id', Session::get('business_id'))->where('forward_by_role_id', $loginRoleID)->where('emp_today_current_status', 2)->where('final_status', '0')->where('punch_date', $currentDate)->first();
        // dd(Session::get('business_id'));
        $valueForCheckBox = $checkApprovalCycleType != null ? ($checkApprovalCycleType == 1 ? ($checkApprovalforwardId == null ? '0' : '1') : ($checkApprovalCycleType == 2 ? ($parallerCaseApprovalListRoleIdCheck == null ? '0' : '1') : '')) : '0';
        return [$tableShows, $valueForCheckBox, $parallerCaseApprovalListRoleIdCheck, $checkSeqId, $distinctPunchDates];
    }



    public function render()
    {
        // permission check view, edit, delete, update
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // session and helper data
        $loginRoleID = RulesManagement::PassBy()[3];
        $loginRoleBID = RulesManagement::PassBy()[1];
        $call = new Central_unit();
        $checkApprovalCycleType = RulesManagement::ApprovalGetDetails(1)[1];
        // for pending check current year or month or day
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::now()->day;
        $currentDate = date('Y-m-d');
        // sequential and parallel roleId Check
        $Branch = $call->BranchList();
        $Department = $this->getDepartment();
        $Designation = $this->getDesignation();
        $DATA = $this->getData()[0];
        $valueForCheckBox = $this->getData()[1];
        $parallerCaseApprovalListRoleIdCheck = $this->getData()[2];
        $checkSeqId = $this->getData()[3];
        $distinctPunchDates = $this->getData()[4];
        $DailyCount = $call->getDailyCountForDashboardAndDailyList(Session::get('business_id'), $this->dateFilter ?? date('Y-m-d'), Session::get('login_role'), Session::get('login_emp_id'));

        $checkApprovalPermission = DB::table('approval_management_cycle')->where('business_id', $loginRoleBID)->where('approval_type_id', 1)->whereJsonContains('role_id', (string) $loginRoleID)->first();

        $checkApprovalforwardId = AttendanceList::where('business_id', $loginRoleBID)->where('forward_by_role_id', $loginRoleID)->where('emp_today_current_status', 2)->where('final_status', '0')->where('punch_date', $currentDate)->first();

        $approvalPendingCount = count($distinctPunchDates);
        $loginRoleBID = RulesManagement::PassBy()[1];
        return view('livewire.attendance.attendance-livewire', compact('permissions', 'moduleName', 'loginRoleID', 'checkApprovalCycleType', 'checkApprovalPermission', 'Branch', 'Department', 'Designation', 'DATA', 'valueForCheckBox', 'checkSeqId', 'parallerCaseApprovalListRoleIdCheck', 'approvalPendingCount', 'DailyCount', 'checkApprovalforwardId'));
    }
}
