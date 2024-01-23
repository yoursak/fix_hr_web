<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use App\Models\admin\setupsettings\MasterEndGameModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

use App\Models\ModelHasPermission;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestMispunchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
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
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicyPolicyHolidayDetail;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicyHolidayDetail;
use App\Models\StaticApprovalName;

// use Alert;

use RealRashid\SweetAlert\Facades\Alert;

class NewPermission extends Controller
{
    public function index()
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
            'description' => $request->description,
        ];
        $truechecking_id = PolicySettingRoleCreate::insert($storeData);

        // $adminRole = Role::create(['name' => $request->role_name, 'branch_id' => Session::get('branch_id'), 'business_id' => $BusinessID]);
        if ($truechecking_id) {
            $latestID = PolicySettingRoleCreate::latest()
                ->select('id')
                ->first();

            if (isset($latestID)) {
                $latestLeavePolicyID = $latestID->id; //generate policy ID run time

                $permission = $request->permissio;

                for ($i = 0; $i < sizeof($request->permissio); $i++) {
                    $collectionDataSet = [
                        'role_create_id' => $latestLeavePolicyID,
                        'business_id' => $BusinessID,
                        'branch_id' => '',
                        'model_name' => $permission[$i],
                    ];
                    // print_r($collectionDataSet);
                    PolicySettingRoleItem::insert($collectionDataSet);
                }
            }
            // session()->flash('success', 'Setup is Active Now');
            Alert::success('Added', 'Your Create Role Added Successfully');
        } else {
            Alert::info('Not Added', 'Your Role Not Added');
        }

        return redirect('Role-permission/role_permission');
        // return back();
    }

    public function createAssignPermission(Request $request)
    {
        //QA OK
        // dd($request->all());
        $BusinessID = Session::get('business_id');
        $empID = $request->emp_id;
        $roleID = $request->roleID;
        $branchID = $request->branch_id;
        $departmentID = $request->department_id;
        $designationID = $request->designation_id;

        $load = EmployeePersonalDetail::where('emp_id', $empID)
            ->where('business_id', $BusinessID)
            ->first();
        $empLoginAdmin = LoginAdmin::where('email', $load->emp_email)
            ->where('business_id', $load->business_id)
            ->first();
        if (Session::get('business_id') != null) {
            $checkexits = PolicySettingRoleAssignPermission::where('business_id', $BusinessID)
                ->where('emp_id', $empID)
                ->first();
            // ->where('branch_id', $branchID)->where('role_id', $roleID)
            if (isset($checkexits)) {
                //     $storeData = [
                //         'business_id' => $BusinessID,
                //         'emp_id' => $empID,
                //         'role_id' => $roleID,
                //         'branch_id' => $branchID,
                //         'department_id' => $departmentID,
                //         'designation_id' => $designationID

                //     ];
                //     $truechecking_id = PolicySettingRoleAssignPermission::update($storeData);
                //     EmployeePersonalDetail::where('emp_id', $empID)->where('business_id', $BusinessID)->update(['role_id' => $roleID]);
                //     if ($truechecking_id) {
                //         Alert::success('Update', 'Permission has been Updated Successfully');
                //     } else {
                //         Alert::warning('Not Updated', ' Permission is Already Assigned!');
                //     }
                Alert::info('', 'Employee already Assigned Role');
            } else {
                $storeData = [
                    'business_id' => $BusinessID,
                    'emp_id' => $empID,
                    'role_id' => $roleID,
                    'branch_id' => $branchID,
                    'department_id' => $departmentID,
                    'designation_id' => $designationID,
                ];
                $truechecking_id = PolicySettingRoleAssignPermission::insert($storeData);
                $get = EmployeePersonalDetail::where('emp_id', $empID)
                    ->where('business_id', $BusinessID)
                    ->first();
                $empDetails = EmployeePersonalDetail::where('emp_id', $empID)
                    ->where('business_id', $BusinessID)
                    ->update(['role_id' => $roleID, 'is_admin' => 2]);
                $empLoginAdmin = LoginAdmin::insert([
                    'business_id' => $BusinessID,
                    'name' => $get->emp_name,
                    'email' => $get->emp_email,
                    'country_code' => '+91',
                    'phone' => $get->emp_mobile_number,
                    'is_verified' => 0,
                ]);

                if ($get != null && isset($empDetails) && isset($empLoginAdmin)) {
                    if (isset($truechecking_id)) {
                        $details = [
                            'name' => $get->emp_name,
                            'title' => 'You have assigned as ' . Central_unit::RoleIdToName2($roleID) . ' from FixingDots',
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
        $get = PolicySettingRoleItem::where('role_create_id', $request->role_id)->get();
        return response()->json(['checking' => $get]);
    }

    // permission edit
    public function previewAssignedUsers(Request $request)
    {
        if (Session::get('business_id') != null && Session::get('branch_id') != null) {
            $role = $request->role;
            $businessId = Session::get('business_id');
            $branch = Session::get('branch_id');

            $delete = PolicySettingRoleItem::where('role_create_id', $role)
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

                        PolicySettingRoleItem::insert($collectionDataSet);
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

            $delete = PolicySettingRoleItem::where('role_create_id', $role)
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

                        PolicySettingRoleItem::insert($collectionDataSet);
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
            $deleted = PolicySettingRoleCreate::where('id', $getID)
                ->where('business_id', $businessID)
                ->where('branch_id', $branchID)
                ->delete();
            $load = PolicySettingRoleAssignPermission::where('role_id', $getID)
                ->where('business_id', $businessID)
                ->where('branch_id', $branchID)
                ->delete();
            $lao = EmployeePersonalDetail::where('role_id', $getID)
                ->where('business_id', $businessID)
                ->where('branch_id', $branchID)
                ->update(['role_id' => 0]);

            if ($deleted) {
                // Delete related permissions or items if needed
                PolicySettingRoleItem::where('role_create_id', $getID)
                    ->where('business_id', $businessID)
                    ->where('branch_id', $branchID)
                    ->delete();

                Alert::success('Deleted', 'Role and associated permissions deleted successfully');
            } else {
                Alert::error('Error', 'Role deletion failed');
            }
        }
        if ($businessID != null) {
            // Perform the deletion of the role with the given ID
            $deleted = PolicySettingRoleCreate::where('id', $getID)
                ->where('business_id', $businessID)
                ->delete();
            $load = PolicySettingRoleAssignPermission::where('role_id', $getID)
                ->where('business_id', $businessID)
                ->delete();
            EmployeePersonalDetail::where('role_id', $getID)
                ->where('business_id', $businessID)
                ->update(['role_id' => 0]);
            // DB::table('roles')->where('business_id', $businessID)->delete();
            if ($deleted && $load) {
                // Delete related permissions or items if needed
                PolicySettingRoleItem::where('role_create_id', $getID)
                    ->where('business_id', $businessID)
                    ->delete();
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

            $deleteResult = PolicySettingRoleAssignPermission::where('business_id', $businessId)
                ->where('branch_id', $branchId)
                ->where('emp_id', $empId)
                ->delete();
            $getDatails = EmployeePersonalDetail::where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->first();
            $deletelogin = DB::table('login_admin')
                ->where('business_id', $getDatails->business_id)
                ->where('email', $getDatails->emp_email)
                ->delete();

            if ($updateResult !== false && $deleteResult !== false && $deletelogin !== false) {
                Alert::success('Deleted Assigned Admin');
            } else {
                Alert::error('Not Deleted');
            }
        } elseif ($businessId) {
            $updateResult = DB::table('employee_personal_details')
                ->where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->update(['role_id' => 0]);

            $deleteResult = PolicySettingRoleAssignPermission::where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->delete();

            $getDatails = EmployeePersonalDetail::where('business_id', $businessId)
                ->where('emp_id', $empId)
                ->first();
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

    //approval Setup
    public function ApprovalSettings()
    {
        // echo "SDF";
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];
        // dd($attendanceTrackInOut)
        // $attendaceShift = DB::table('attendance_shift_settings')->get();
        // alert()->success('Success Title', 'Success Message');

        // alert()->success('Success Title', 'Success Message');
        // alert()->success('Success Title', 'Success Message');
        // Alert::success('Success', 'Updated Rule Method Successfully');
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');

        // return redirect('/admin/setting/permissions/approval_management');
        return view('admin/setting/permissions/approval_management', $root);
    }
    public function SetApprovalSectionData($approvalTypeID)
    {
        $approvalSystemManagement = RulesManagement::ApprovalGetDetails($approvalTypeID)[0];
        return response()->json(['data' => $approvalSystemManagement]);
    }
    // used Component X-ApprovalManagement
    public function ApprovalSubmit(Request $request)
    {
        // dd($request->all());
        $businessID = Session::get('business_id');
        $loadType = $request->load;
        $radioBtn = $request->btnradio;
        $approvalSelection = $request->input('approval_select');
        // dd($approvalSelection);
        if ($approvalSelection == null) {
            Alert::info('The complete approval cycle cannot be erased. You have to choose at least one role to get approved for.');

            return back();
        }
        $initialIndex = $approvalSelection[0]; // Index of the next element you want to access
        $lastIndex = $approvalSelection[sizeof($approvalSelection) - 1];
        // dd($lastIndex);
        // dd($request->all(), $lastIndex);
        $point = ApprovalManagementCycle::where('business_id', $businessID)
            ->where('approval_type_id', $loadType)
            ->first();
        // $root = DB::table('approval_status_list')
        //     ->where('applied_cycle_type', 1)->where('approval_type_id', 2)->get();
        // if ($root) {

        // }
        // dd($root);

        // !
        if (!isset($point)) {
            //?? false
            $save = ApprovalManagementCycle::insert([
                'approval_type_id' => $loadType,
                'business_id' => $businessID,
                'cycle_type' => $radioBtn,
                'role_id' => json_encode($approvalSelection),
            ]);
            // LeaveRequestList Update Particular BusinessID
            // $load = RequestLeaveList::where('business_id', $businessID)->update(['runtime_cycle_update' => $radioBtn]);
            // && isset($load
            if (isset($save)) {
                Alert::success('Submit Active Attendance Approval ');
            } else {
                Alert::info('Not Updated Attendance Approval ');
            }
        } else {
            $update_all_ready = ApprovalManagementCycle::where('business_id', $businessID)
                ->where('approval_type_id', $loadType)
                ->update([
                    'approval_type_id' => $loadType,
                    'business_id' => $businessID,
                    'cycle_type' => $radioBtn,
                    'role_id' => json_encode($approvalSelection),
                ]);
            // LeaveRequestList Update Particular BusinessID 'runtime_cycle_update' => $radioBtn
            // $initialIndex'initial_level_role_id' => 0,
            // $loadmispunch = RequestLeaveList::where('business_id', $businessID)->where('process_complete', '==', $loadType)->update(['forward_by_role_id' => $initialIndex, 'final_level_role_id' => $lastIndex, 'forward_by_status' => 0]);
            // $loadType
            if ($loadType == 1) {
                $load = DB::table('attendance_list')->where('process_complete', '0')->update(['forward_by_role_id' => $initialIndex, 'final_level_role_id' => $lastIndex, 'forward_by_status' => 0]);
                $NameType = 'Attendance';
            } elseif ($loadType == 2) {
                $load = RequestLeaveList::where('business_id', $businessID)
                    ->where('process_complete', '0')
                    ->update(['forward_by_role_id' => $initialIndex, 'final_level_role_id' => $lastIndex, 'forward_by_status' => 0]);
                $NameType = 'Leave';
            } elseif ($loadType == 3) {
                $load = DB::table('request_mispunch_list')
                    ->where('business_id', $businessID)
                    ->where('process_complete', 0)
                    ->update(['forward_by_role_id' => $initialIndex, 'final_level_role_id' => $lastIndex, 'forward_by_status' => 0]);
                $NameType = 'Mispunch';
            } elseif ($loadType == 4) {
                $load = DB::table('request_gatepass_list')
                    ->where('business_id', $businessID)
                    ->where('process_complete', 0)
                    ->update(['forward_by_role_id' => $initialIndex, 'final_level_role_id' => $lastIndex, 'forward_by_status' => 0]);
                $NameType = 'Gatepass';
            }

            // DB::table('approval_status_list')->where('approval_type_id', 2)
            //     ->where('business_id', $businessID)->where('status', '!=', 1)->update([
            //         'applied_cycle_type' => $radioBtn
            //     ]);
            if (isset($update_all_ready) && isset($load)) {
                if ($radioBtn == 2) {
                    Alert::success('', "Your Updated Parallel Approval System   also Update Request $NameType List");
                }
                if ($radioBtn == 1) {
                    Alert::success('', "Your Updated Sequential Approval System   also Update Request $NameType List");
                }
            } else {
                Alert::info('', 'Not Updated Approval System ');
            }
        }
        return back();
    }
}
