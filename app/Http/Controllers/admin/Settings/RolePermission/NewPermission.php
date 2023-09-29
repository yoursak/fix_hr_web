<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use App\Helpers\Layout;
use Session;
use Alert;

use App\Helpers\Central_unit;


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

        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permission = $accessPermission[1];


        $send = compact('moduleName', 'permission', 'Modules', 'permissions', 'RolesData', 'EmployeeList', 'BranchList');
        return view('admin.setting.permissions.newPermission', $send);
    }

    public function createRoleSubmit(Request $request)
    {
        // dd($request->all());
        $BusinessID = $request->business_id;
        // $branchID = $request->session()->get('branch_id');
        $storeData = [
            'business_id' => $BusinessID,
            'branch_id' => Session::get('branch_id'),
            'roles_name' => $request->role_name,
            'description' => $request->description
        ];
        $truechecking_id = DB::table('setting_role_create')->insert($storeData);

        // $adminRole = Role::create(['name' => $request->role_name, 'branch_id' => Session::get('branch_id'), 'business_id' => $BusinessID]);
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


        $load = DB::table('employee_personal_details')->where('emp_id', $empID)->where('business_id', $BusinessID)->first();
        $empLoginAdmin = DB::table('login_admin')->where('email', $load->emp_email)->where('business_id', $load->business_id)->first();
        if (Session::get('business_id') != null) {
            $checkexits = DB::table('setting_role_assign_permission')->where('business_id', $BusinessID)->where('branch_id', $branchID)->where('role_id', $roleID)->where('emp_id', $empID)->first();

            if (isset($checkexits)) {
                //     $storeData = [
                //         'business_id' => $BusinessID,
                //         'emp_id' => $empID,
                //         'role_id' => $roleID,
                //         'branch_id' => $branchID,
                //         'department_id' => $departmentID,
                //         'designation_id' => $designationID

                //     ];
                //     $truechecking_id = DB::table('setting_role_assign_permission')->update($storeData);
                //     DB::table('employee_personal_details')->where('emp_id', $empID)->where('business_id', $BusinessID)->update(['role_id' => $roleID]);
                //     if ($truechecking_id) {
                //         Alert::success('Update', 'Permission has been Updated Successfully');
                //     } else {
                //         Alert::warning('Not Updated', ' Permission is Already Assigned!');
                //     }
                Alert::info('Employee already Assigned Role');
            } else {

                $storeData = [
                    'business_id' => $BusinessID,
                    'emp_id' => $empID,
                    'role_id' => $roleID,
                    'branch_id' => $branchID,
                    'department_id' => $departmentID,
                    'designation_id' => $designationID

                ];
                $truechecking_id = DB::table('setting_role_assign_permission')->insert($storeData);
                $get = DB::table('employee_personal_details')->where('emp_id', $empID)->where('business_id', $BusinessID)->first();
                $empDetails = DB::table('employee_personal_details')->where('emp_id', $empID)->where('business_id', $BusinessID)->update(['role_id' => $roleID]);
                $empLoginAdmin = DB::table('login_admin')->insert([
                    'business_id' => $BusinessID,
                    'name' => $get->emp_name,
                    'email' => $get->emp_email,
                    'country_code' => '+91',
                    'phone' => $get->emp_mobile_number,
                    'is_verified' => 0
                ]);

                if ($get != null && isset($empDetails) && isset($empLoginAdmin)) {

                    if (isset($truechecking_id)) {
                        $details = [
                            'name' => $get->emp_name,
                            'title' => 'You have assigned as '.Central_unit::RoleIdToName2($roleID).' from FixingDots',
                            'body' => 'Your FixHR Admin Login Credential is your Mail: ' . "$get->emp_email",
                        ];
                        $sendMail = Mail::to($get->emp_email)->send(new AdminMailer($details));

                        Alert::success('Added', ' Permission Assigned Successfully and Updated RoleID');
                    } else {
                        Alert::info('Not Added', "Permission doesn't  Created!");
                    }
                }
            }
        }
        return back();
    }

    public function GetAssignUser(Request $request)
    {
        $get = DB::table('setting_role_items')->where('role_create_id', $request->role_id)->get();
        return response()->json(['checking' => $get]);
    }

    // permission edit
    public function previewAssignedUsers(Request $request)
    {

        if (Session::get('business_id') != null && Session::get('branch_id') != null) {

            $role = $request->role;
            $businessId = Session::get('business_id');
            $branch = Session::get('branch_id');

            $delete = DB::table('setting_role_items')
                ->where('role_create_id', $role)
                ->where('business_id', $businessId)
                ->where('branch_id', $branch)
                ->delete();

            // // 2. Update existing data (if needed)
            // // If you need to update existing records, do it here.

            // // 3. Insert new data
            if (isset($delete)) {
                $latestLeavePolicyID = $request->role;
                $permissions = $request->permissions;

                if (isset($latestLeavePolicyID)) {
                    foreach ($permissions as $permission) {

                        $collectionDataSet = [
                            'role_create_id' => $latestLeavePolicyID,
                            'business_id' => $businessId,
                            'branch_id' => $branch,
                            'model_name' => $permission,
                        ];

                        DB::table('setting_role_items')->insert($collectionDataSet);
                    }
                    Alert::success('Updated', 'Permission Assigned Successfully Updated');
                } else {

                    Alert::success('Not Updated', 'Permission Assigned Not Updated!');
                }
            }
        }
        if (Session::get('business_id') != null) {


            $role = $request->role;
            $businessId = Session::get('business_id');

            $delete = DB::table('setting_role_items')
                ->where('role_create_id', $role)
                ->where('business_id', $businessId)
                ->delete();

            // // 2. Update existing data (if needed)
            // // If you need to update existing records, do it here.

            // // 3. Insert new data
            if (isset($delete)) {
                $latestLeavePolicyID = $request->role;
                $permissions = $request->permissions;

                if (isset($latestLeavePolicyID)) {
                    foreach ($permissions as $permission) {

                        $collectionDataSet = [
                            'role_create_id' => $latestLeavePolicyID,
                            'business_id' => $businessId,
                            'branch_id' => '',
                            'model_name' => $permission,
                        ];

                        DB::table('setting_role_items')->insert($collectionDataSet);
                    }
                    Alert::success('Updated', 'Permission Assigned Successfully Updated');
                } else {
                    Alert::success('Not Updated', 'Permission Assigned Not Updated!');
                }
            }
        }
        return back();
    }

    // delete permission
    public function deletePermission(Request $request)
    {
        $getID = $request->role_set;
        $businessID = Session::get('business_id');
        $branchID = Session::get('branch_id');
        // dd($businessID);
        if ($businessID != null && $branchID != null) {
            $deleted = DB::table('setting_role_create')->where('id', $getID)->where('business_id', $businessID)->where('branch_id', $branchID)->delete();
            $load = DB::table('setting_role_assign_permission')->where('role_id', $getID)->where('business_id', $businessID)->where('branch_id', $branchID)->delete();
            $lao = DB::table('employee_personal_details')->where('role_id', $getID)->where('business_id', $businessID)->where('branch_id', $branchID)->update(['role_id' => 0]);

            if ($deleted) {
                // Delete related permissions or items if needed
                DB::table('setting_role_items')->where('role_create_id', $getID)->where('business_id', $businessID)->where('branch_id', $branchID)->delete();

                Alert::success('Deleted', 'Role and associated permissions deleted successfully');
            } else {
                Alert::error('Error', 'Role deletion failed');
            }
        }
        if ($businessID != null) {
            // Perform the deletion of the role with the given ID
            $deleted = DB::table('setting_role_create')->where('id', $getID)->where('business_id', $businessID)->delete();
            $load = DB::table('setting_role_assign_permission')->where('role_id', $getID)->where('business_id', $businessID)->delete();
            $lao = DB::table('employee_personal_details')->where('role_id', $getID)->where('business_id', $businessID)->update(['role_id' => 0]);
            DB::table('roles')->where('business_id', $businessID)->delete();
            if ($deleted && $load) {
                // Delete related permissions or items if needed
                DB::table('setting_role_items')->where('role_create_id', $getID)->where('business_id', $businessID)->delete();
                Alert::success('Deleted', 'Role and associated permissions deleted successfully');
            } else {
                Alert::error('Error', 'Role deletion failed');
            }
        }
        return back(); // Redirect to the role listing page
    }

    public function DeleteAdminAssign(Request $request)
    {
        // dd($request->all());
        $businessId = Session::get('business_id');
        $branchId = Session::get('branch_id');
        $empId = $request->emp_id;

        // Check if both business_id and branch_id match before updating and deleting
        if ($businessId && $branchId) {
            $updateResult = DB::table('employee_personal_details')
                ->where('business_id', $businessId)
                ->where('branch_id', $branchId)
                ->where('emp_id', $empId)
                ->update(['role_id' => 0]);

            $deleteResult = DB::table('setting_role_assign_permission')
                ->where('business_id', $businessId)
                ->where('branch_id', $branchId)
                ->where('emp_id', $empId)
                ->delete();
            $getDatails = DB::table('employee_personal_details')->where('business_id', $businessId)->where('emp_id', $empId)->first();
            $deletelogin = DB::table('login_admin')
                ->where('business_id', $getDatails->business_id)
                ->where('email', $getDatails->emp_email)
                ->delete();


            if ($updateResult !== false && $deleteResult !== false && $deletelogin !== false) {
                Alert::success('Deleted Assigned Admin');
            } else {
                Alert::error('Not Deleted');
            }
        } else if ($businessId) {
            $updateResult = DB::table('employee_personal_details')
                ->where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->update(['role_id' => 0]);


            $deleteResult = DB::table('setting_role_assign_permission')
                ->where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->delete();

            $getDatails = DB::table('employee_personal_details')->where('business_id', $businessId)->where('emp_id', $empId)->first();
            $deletelogin = DB::table('login_admin')
                ->where('business_id', $getDatails->business_id)
                ->where('email', $getDatails->emp_email)
                ->delete();

            if ($updateResult !== false && $deleteResult !== false && $deletelogin !== false) {
                Alert::success('Deleted Assigned Admin');
            } else {
                Alert::error('Not Deleted');
            }
        } else {
            Alert::error('Invalid Business ID or Branch ID');
        }

        return back();
    }
}
