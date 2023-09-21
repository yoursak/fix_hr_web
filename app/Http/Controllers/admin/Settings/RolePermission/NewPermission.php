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
        $Modules = $rooted1->SidebarMenu();
        $permissions = DB::table('permissions')->where('business_id', Session::get('business_id'))->get();
        $send = compact('Modules', 'permissions');
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
                        'branch_id'=>'',
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
        dd($request->all());
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
                        'branch_id'=>'',
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
    



}
