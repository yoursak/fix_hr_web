<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mail\AuthMailer;
use App\Helpers\Central_unit;
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use App\Models\LoginAdmin;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\ModelHasPermission;
use App\Models\BusinessDetailsList;
use App\Models\PolicyHolidayDetail;
use App\Models\AdminNotice;
use Illuminate\Pagination\Paginator;

use App\Models\EmployeePersonalDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        // dd($accessPermission);
        $businessId = Session::get('business_id');
        $roleIdToCheck = Session::get('login_role');
        $permissionBranchId = PolicySettingRoleAssignPermission::where('business_id', $businessId)
        ->where('emp_id', Session::get('login_emp_id'))
        ->first();
        if ($permissionBranchId !== null && !empty($permissionBranchId) && $roleIdToCheck != 1 && ($permissionBranchId->permission_type == 2)) {
            $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                ->where('employee_personal_details.branch_id', $permissionBranchId->permission_branch_id)
                ->where('active_emp', 1)
                ->paginate(10);
        } else {
            $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))
                ->where('active_emp', 1)
                ->paginate(10);
        }

        $Holiday = [];
        $Notice = AdminNotice::where('business_id', Session::get('business_id'))->get();
        $endGame = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->where('method_switch', 1)
            ->distinct('holiday_policy_ids_list')
            ->select('holiday_policy_ids_list')
            ->get();
        foreach ($endGame as $key => $game) {
            $holidayItems = PolicyHolidayDetail::where('business_id', Session::get('business_id'))
                ->where('template_id', $game->holiday_policy_ids_list)
                ->get();
            foreach ($holidayItems as $key => $item) {
                $Holiday[] = $item;
            }
        }

        // dd($Holiday);

        $root = compact('moduleName', 'permissions', 'Emp', 'Holiday', 'Notice');
        return view('admin.dashboard.dashboard', $root);
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/thankyou');
    }
}
