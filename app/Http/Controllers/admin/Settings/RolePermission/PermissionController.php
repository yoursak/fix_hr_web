<?php

namespace App\Http\Controllers\admin\Settings\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function store(Request $request)
    {
        // dd(data);
        $added = DB::table('permissions')->insert([
            'name' => $request->Permission,
            'description' => $request->Description,
            'module_id' => $request->module,
            'branch_id' => $request->branch,
            'business_id' => $request->session()->get('business_id')
        ]);

        return back();


    }

}