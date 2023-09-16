<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

    public function index(Request $request)
    {
        $params_data = $request->data;
        // dd($params_data);
        $Admins = DB::table('login_admin')->where([
            'business_id'=>$request->session()->get('business_id'),
            'user'=>'admin',
        ])->get();
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->where([
            'business_id'=>$request->session()->get('business_id'),
        ])->get();
        $RoleDetails = DB::table('model_has_roles')->where([
            'model_id'=> $params_data,
            'business_id'=> $request->session()->get('business_id'),
        ])->first();
        return view('admin.setting.permissions.Permissions', compact('roles', 'permissions', 'Admins', 'RoleDetails'));
    }

    public function AdminList(Request $request)
    {
        $admins = DB::table('login_admin')->where([
            'business_id'=> $request->session()->get('business_id'),
        ])->get();
        $roles = DB::table('roles')->where([
            'business_id'=> $request->session()->get('business_id'),
        ])->get();
        $pendings = DB::table('pending_admins')->where([
            'business_id'=> $request->session()->get('business_id'),
        ])->get();
        $permissions = DB::table('permissions')->where([
            'business_id'=> $request->session()->get('business_id'),
        ])->get();
        $modelHasRole = DB::table('model_has_roles')->where([
            'business_id'=> $request->session()->get('business_id'),
        ])->get();
        // dd($roles);
        return view('admin.setting.permissions.AdminList', compact('admins', 'roles', 'pendings', 'modelHasRole', 'permissions'));
    }


    public function addAdmin(Request $request)
    {
        // dd($request->all());
        $is_Emp = DB::table('employee_personal_details')->where([
            'emp_id' => $request->employee,
            'business_id'=>$request->session()->get('business_id'),
        ])->first();
        if (isset($is_Emp)) {
            $pending_admin = DB::table('pending_admins')->insert([
                'emp_id' => $is_Emp->emp_id,
                'business_id' => $is_Emp->business_id,
                'branch_id' => $is_Emp->branch_id,
                'emp_name' => $is_Emp->emp_name,
                'emp_email' => $is_Emp->emp_email,
                'emp_phone' => $is_Emp->emp_mobile_number,
                'created_at' => now(),
                'updated_at' => now()
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
        $now_is_admin = DB::table('login_admin')->insert([
            'user' => $request->session()->get('login_role'),
            'business_id' => $request->session()->get('business_id'),
            'name' => $request->session()->get('login_name'),
            'email' => $request->session()->get('login_email'),
            'phone' => $request->session()->get('login_phone'),
            'country_code' => +91,
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if (isset($now_is_admin)) {

            $approved = DB::table('pending_admins')->where('emp_email', $request->session()->get('login_email'))->delete();

            if (isset($approved)) {
                Alert::success('Login Successfully', 'Now you are a Admin Position at FixingDots');
                return redirect('/');
            }
        }

        // }
    }


    public function assignPermissionToModel(Request $request)
    {

        $data = $request->all();
        $admin = $request->admin;

        $employee = DB::table('employee_personal_details')->where('emp_email', $request->admin)->first();
        $RoleDetails = DB::table('model_has_roles')->where('model_id', $employee->emp_id)->first();

        $permit_id = DB::table('permissions')->where('id', $request->permission_id)->first();
        $module = DB::table('sidebar_menu')->where('menu_id', $permit_id->module_id)->first();
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

    public function removePermission(Request $request){
        $permission = DB::table('model_has_permissions')->where('permission_id',$request->permission_id)->delete();
        return response()->json($permission);
    }

    public function getPermissions(Request $request)
    {
        if ($request->ajax()) {
            $admin_mail = $request->valueq;
            $employee = DB::table('employee_personal_details')->where('emp_email', $admin_mail)->first();
            $modelHasRole = DB::table('model_has_permissions')->where('model_id', $employee->emp_id)->get();

            return response()->json($modelHasRole);
        }
    }


    public function assignRoleToModel(Request $request)
    {
        // dd($request->all());

        $model_has_role = DB::table('model_has_roles')->insert([
            'role_id' => $request->role,
            'business_id' => $request->session()->get('business_id'),
            'branch_id' => $request->branch,
            'model_id' => $request->model,
            'model_type' => 'admin'
        ]);

        if (isset($model_has_role)) {
            // $model_has_role->assignRole($model_has_role);
            $update_employee = DB::table('employee_personal_details')->where([
                'emp_id' => $request->model,
                'business_id'=> $request->session()->get('business_id'),
                ])->update([
                'role_id' => $request->role,
            ]);

            if (isset($update_employee)) {
                Alert::success('Congratulations', 'Role Assigned Successfully');
            }
        }
        return redirect('/Role-permission/admin-list');
    }

}