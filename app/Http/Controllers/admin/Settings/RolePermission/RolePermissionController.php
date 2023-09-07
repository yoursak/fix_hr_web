<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use RealRashid\SweetAlert\Facades\Alert;

class RolePermissionController extends Controller
{

    public function index()
    {
        $Admins = DB::table('login_admin')->get();
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get();
        return view('admin.setting.permissions.Permissions', compact('roles', 'permissions', 'Admins'));
    }

    public function AdminList()
    {
        $admins = DB::table('login_admin')->get();
        $roles = DB::table('roles')->get();
        $pendings = DB::table('pending_admins')->get();
        $modelHasRole = DB::table('model_has_roles')->get();
        // dd($roles);
        return view('admin.setting.permissions.AdminList', compact('admins', 'roles', 'pendings','modelHasRole'));
    }


    public function addAdmin(Request $request)
    {
        // dd($request->all());
        $is_Emp = DB::table('employee_personal_details')->where([
            'emp_id' => $request->employee,
            // 'business_id'=>$request->session()->get('business_id')
        ])->first();
        // dd($is_Admin);
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


    public function assignPermissionToRole(Request $request)
    {
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
            $update_employee = DB::table('employee_personal_details')->where('emp_id', $request->model)->update([
                'role_id' => $request->role,
            ]);

            if (isset($update_employee)) {
                Alert::success('Congratulations', 'Role Assigned Successfully');
            }
        }
        return redirect('/Role-permission/admin-list');
    }

}