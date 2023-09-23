<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use  App\Helpers\Layout;
use Session;
use Alert;

class NewPermission extends Controller
{
    public function index()
    {

        $rooted1 = new Layout();
        $BranchList = DB::table('branch_list')->where('business_id', Session::get('business_id'))->get();
        $RolesData = DB::table('setting_role_create')->where('business_id', Session::get('business_id'))->get();
        $EmployeeList = DB::table('employee_personal_details')->where('business_id', Session::get('business_id'))->get();
        $Modules = $rooted1->SidebarMenu();
        $permissions = DB::table('permissions')->where('business_id', Session::get('business_id'))->get();
        $send = compact('Modules', 'permissions', 'RolesData', 'EmployeeList', 'BranchList');
        return view('admin.setting.permissions.newPermission', $send);
    }

    public function createRoleSubmit(Request $request)
    {
        // dd($request->all());
        $BusinessID = $request->business_id;
        // $branchID = $request->session()->get('branch_id');
        $storeData = [
            'business_id' => $BusinessID,
            'role_name' => $request->role_name,
            'description' => $request->description
        ];
        $truechecking_id = DB::table('setting_role_create')->insert($storeData);
        if ($truechecking_id) {
            $latestID = DB::table('setting_role_create')
                ->latest()
                ->select('id')
                ->first();

            if (isset($latestID)) {
                $latestLeavePolicyID = $latestID->id; //generate policy ID run time

                $permission = $request->permissions;

                for ($i = 0; $i < sizeof($request->permissions); $i++) {
                    $collectionDataSet = [
                        'role_create_id' => $latestLeavePolicyID,
                        'business_id' => $BusinessID,
                        'branch_id' => '',
                        'model_name' => $permission[$i],
                    ];
                    // print_r($collectionDataSet);
                    DB::table('setting_role_items')->insert($collectionDataSet);
                }
            }
            Alert::success('Added', 'Your Create Role Added Successfully');
        } else {
            Alert::info('Not Added', 'Your Role Not Added');
        }
        return back();
    }

    public function createAssignPermission(Request $request)
    {
        // dd($request->all());
        $BusinessID = Session::get('business_id');
        $empID = $request->emp_id;
        $roleID = $request->roleID;
        $branchID = $request->branch_id;
        $departmentID = $request->department_id;
        $designationID = $request->designation_id;

        $checkexits = DB::table('setting_role_assign_permission')->where('business_id', $BusinessID)->where('branch_id', $branchID)->where('department_id',  $departmentID)->where('role_id', $roleID)->where('emp_id', $empID)->first();

        if (isset($checkexits)) {
            $storeData = [
                'business_id' => $BusinessID,
                'emp_id' =>  $empID,
                'role_id' =>  $roleID,
                'branch_id' => $branchID,
                'department_id' => $departmentID,
                'designation_id' => $designationID

            ];
            $truechecking_id = DB::table('setting_role_assign_permission')->update($storeData);

            if ($truechecking_id) {
                Alert::success('Update', 'Permission has been Updated Successfully');
            } else {
                Alert::warning('Not Updated', ' Permission is Already Assigned!');
            }
        } else {

            $storeData = [
                'business_id' => $BusinessID,
                'emp_id' =>  $empID,
                'role_id' =>  $roleID,
                'branch_id' => $branchID,
                'department_id' => $departmentID,
                'designation_id' =>  $designationID

            ];
            $truechecking_id = DB::table('setting_role_assign_permission')->insert($storeData);
            if ($truechecking_id) {
                Alert::success('Added', ' Permission Assigned Successfully');
            } else {
                Alert::info('Not Added', "Permission doesn't  Created!");
            }
        }
        return back();
    }

    public function GetAssignUser(Request $request)
    {
        $get = DB::table('setting_role_items')->where('role_create_id', $request->role_id)->get();
        return  response()->json(['checking' => $get]);
    }

    public function previewAssignedUsers(Request $request)
    {
        dd($request->all());
    }
}
