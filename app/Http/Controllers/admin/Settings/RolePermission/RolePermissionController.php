<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Central_unit;
use App\Models\LoginAdmin;
use App\Models\ModelHasPermission;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
use App\Models\BranchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use App\Models\Permission;
use App\Models\PendingAdmin;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicyPolicyHolidayDetail;
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyHolidayDetail;
use App\Models\PolicyMasterEndgameMethod;

class RolePermissionController extends Controller
{
    public function index()
    {
        $Admins = LoginAdmin::where([
            'business_id' => $request->session()->get('business_id'),
            'user' => '1',
        ])->get();
        // $roles = DB::table('roles')->get();
        $permissions = Permission::where([
            'business_id' => $request->session()->get('business_id'),
        ])->get();
        return view('admin.setting.permissions.Permissions', compact('permissions', 'Admins'));
    }

    public function AdminList(Request $request)
    {
        $admins = LoginAdmin::where([
            'business_id' => $request->session()->get('business_id'),
        ])->get();
        $roles = PolicySettingRoleCreate::where([
            'business_id' => $request->session()->get('business_id'),
        ])->get();
        $pendings = PendingAdmin::where([
            'business_id' => $request->session()->get('business_id'),
        ])->get();
        $permissions = Permission::where([
            'business_id' => $request->session()->get('business_id'),
        ])->get();

        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permission = $accessPermission[1];
        return view('admin.setting.permissions.AdminList', compact('moduleName', 'permission', 'admins', 'roles', 'pendings', 'permissions'));
    }

    // assign send mail
    public function addAdmin(Request $request)
    {
        // dd($request->all());
        $is_Emp = EmployeePersonalDetail::where([
            'emp_id' => $request->employee,
            'business_id' => $request->session()->get('business_id'),
        ])->first();
        if (isset($is_Emp)) {
            $pending_admin = PendingAdmin::insert([
                'emp_id' => $is_Emp->emp_id,
                'business_id' => $is_Emp->business_id,
                'branch_id' => $is_Emp->branch_id,
                'emp_name' => $is_Emp->emp_name,
                'emp_email' => $is_Emp->emp_email,
                'emp_phone' => $is_Emp->emp_mobile_number,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // dd( $pending_admin );
            if (isset($pending_admin)) {
                $details = [
                    'name' => $is_Emp->emp_name,
                    'title' => 'You have assigned as Admin from FixingDots',
                    'body' => 'Your FixHR Admin Login Credential is your Mail: ' . "$is_Emp->emp_email",
                ];
                $sendMail = Mail::to($is_Emp->emp_email)->send(new AdminMailer($details));
            }
        }
        return redirect('Role-permission/admin-list');
    }

    public function makeAdmin(Request $request)
    {
        // if($request->session()->get('business_id')){
        // dd($request->session()->get('business_id'));
        $now_is_admin = LoginAdmin::insert([
            'static_role' => $request->session()->get('login_role'),
            'business_id' => $request->session()->get('business_id'),
            'name' => $request->session()->get('login_name'),
            'email' => $request->session()->get('login_email'),
            'phone' => $request->session()->get('login_phone'),
            'country_code' => +91,
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (isset($now_is_admin)) {
            $approved = PendingAdmin::where('emp_email', $request->session()->get('login_email'))->delete();

            if (isset($approved)) {
                Alert::success('Login Successfully', 'Now you are a Admin Position at FixingDots');
                return redirect('/');
            }
        }

    }

    public function assignPermissionToModel(Request $request)
    {
        $data = $request->all();
        $admin = $request->admin;

        $employee = EmployeePersonalDetail::where('emp_email', $request->admin)->first();
        $RoleDetails = DB::table('model_has_roles')
            ->where('model_id', $employee->emp_id)
            ->first();

        $permit_id = Permission::where('id', $request->permission_id)->first();
        $module = DB::table('sidebar_menu')
            ->where('menu_id', $permit_id->module_id)
            ->first();
        $assignPermision = DB::table('model_has_permissions')->insert([
            'permission_id' => $request->permission_id,
            'module_id' => $module->menu_id,
            'permission_name' => $request->permission,
            'business_id' => $request->session()->get('business_id'),
            'branch_id' => $RoleDetails->branch_id,
            'role_id' => $RoleDetails->role_id,
            'model_type' => $RoleDetails->model_type,
            'model_id' => $RoleDetails->model_id,
        ]);
        return response()->json($RoleDetails);
    }

    public function removePermission(Request $request)
    {
        $permission = DB::table('model_has_permissions')
            ->where('permission_id', $request->permission_id)
            ->delete();
        return response()->json($permission);
    }

    public function getPermissions(Request $request)
    {
        if ($request->ajax()) {
            $admin_mail = $request->valueq;
            $employee = EmployeePersonalDetail::where('emp_email', $admin_mail)->first();
            $modelHasRole = DB::table('model_has_permissions')
                ->where('model_id', $employee->emp_id)
                ->get();

            return response()->json($modelHasRole);
        }
    }

    public function assignRoleToModel(Request $request)
    {
        // dd($request->all());

        $check = DB::table('model_has_roles')
            ->where('model_id', $request->model)
            ->first();

        if (isset($check)) {
            $model_has_role1 = DB::table('model_has_roles')
                ->where('model_id', $request->model)
                ->update([
                    'role_id' => $request->role,
                ]);

            if (isset($model_has_role1)) {
                // $model_has_role->assignRole($model_has_role);
                $update_employee = EmployeePersonalDetail::where([
                    'emp_id' => $request->model,
                    'business_id' => $request->session()->get('business_id'),
                ])->update([
                    'role_id' => $request->role,
                ]);

                if (isset($update_employee)) {
                    Alert::success('Congratulations', 'Role Assigned Successfully');
                }
            }
        } else {
            $model_has_role2 = DB::table('model_has_roles')->insert([
                'role_id' => $request->role,
                'business_id' => $request->session()->get('business_id'),
                'branch_id' => $request->branch,
                'model_id' => $request->model,
                'model_type' => 'admin',
            ]);
            if (isset($model_has_role2)) {
                // $model_has_role->assignRole($model_has_role);
                $update_employee = EmployeePersonalDetail::where([
                    'emp_id' => $request->model,
                    'business_id' => $request->session()->get('business_id'),
                ])->update([
                    'role_id' => $request->role,
                ]);

                if (isset($update_employee)) {
                    Alert::success('Congratulations', 'Role Assigned Successfully');
                }
            }
        }

        return redirect('/Role-permission/admin-list');
    }
}
