<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permissions\Permission;


class PermissionController extends Controller
{
    public function store(Request $request)
    {
        // dd(data);
        $permission = new Permission();
        $permission->name = $request->Permission;
        $permission->description = $request->Description;
        $permission->module_id = $request->module;
       
        $permission->branch_id = $request->branch;
        $permission->business_id = $request->session()->get('business_id');
        if($permission->save()){
            return back();
        }
        
    }

}
