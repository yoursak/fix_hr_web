<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permissions\Role;

class RoleController extends Controller
{
    
    public function store(Request $request)
    {
        // dd($request);
        $role = new Role();
        $role->name = $request->role;
        $role->branch_id = $request->branch;
        $role->business_id =$request->session()->get('business_id');
        $role->description =$request->Description;
        if($role->save()){
            return back();
        }

    }
}
