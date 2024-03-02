<?php

namespace App\Http\Livewire\RolePermission;

use Livewire\Component;

use Session;
use App\Helpers\Central_unit;

use App\Models\EmployeePersonalDetail;
use App\Helpers\Layout;
use Illuminate\Support\Facades\DB;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\RequestLeaveList;
use App\Models\LoginAdmin;
use App\Models\BranchList;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicySettingRoleCreate;
use App\Models\Permission;
use App\Models\PolicySettingRoleItem;
use App\Models\ApprovalManagementCycle;
use Livewire\WithPagination;

class RoleAndPermissionLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $tableShows;

    public $branchFilter, $departmentFilter, $designationFilter, $activeFilter, $searchFilter, $sortBy, $dateFilter;
    public $perPage;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $rooted1 = new Layout();
        $accessPermission = Central_unit::AccessPermission();
        $BranchList = BranchList::where('business_id', Session::get('business_id'))->get();
        $RolesData = PolicySettingRoleCreate::where('business_id', Session::get('business_id'))
            ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
                $searchFind = "%{$this->searchFilter}%";
                $query->where(function ($query) use ($searchFind) {
                    $query
                        ->where('roles_name', 'like', $searchFind) // Removed the extra space after 'roles_name'
                        ->orWhere('description', 'like', $searchFind);
                });
            })
            ->paginate($page)
            ->withQueryString();

        $EmployeeList = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();
        $permissions = Permission::where('business_id', Session::get('business_id'))->get();
        $Modules = $rooted1->SidebarMenu();
        $moduleName = $accessPermission[0];
        $permission = $accessPermission[1];
        $send = compact('moduleName', 'permission', 'Modules', 'permissions', 'RolesData', 'EmployeeList', 'BranchList');
        return view('livewire.role-permission.role-and-permission-livewire', $send);
    }
}
