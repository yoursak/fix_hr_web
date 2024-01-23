<?php

namespace App\Http\Livewire\RoleManagement;

use Livewire\Component;
use Livewire\WithPagination;

use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Layout;
use Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\Central_unit;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\RequestLeaveList;
use App\Models\LoginAdmin;
use App\Models\BranchList;
use App\Models\EmployeePersonalDetail;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicySettingRoleCreate;
use App\Models\Permission;
use App\Models\PolicySettingRoleItem;
use App\Models\ApprovalManagementCycle;

class RoleManage extends Component
{
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $rooted1 = new Layout();
        $accessPermission = Central_unit::AccessPermission();
        $BranchList = BranchList::where('business_id', Session::get('business_id'))->get();
        $RolesData = PolicySettingRoleCreate::where('business_id', Session::get('business_id'))->get();
        $EmployeeList = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();
        $permissions = Permission::where('business_id', Session::get('business_id'))->get();
        $Modules = $rooted1->SidebarMenu();
        $moduleName = $accessPermission[0];
        $permission = $accessPermission[1];

        $send = [
            'moduleName' => $moduleName,
            'permission' => $permission,
            'Modules' => $Modules,
            'permissions' => $permissions,
            'RolesData' => $RolesData,
            'EmployeeList' => $EmployeeList,
            'BranchList' => $BranchList,
        ];
        // $send = compact('moduleName', 'permission', 'Modules', 'permissions', 'RolesData', 'EmployeeList', 'BranchList');


        return view('livewire.role-management.role-management', $send);
    }
}
