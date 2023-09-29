<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Central_unit;
class LocalizationController extends Controller
{
    public function index()
    {   $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
     
        
        return view('admin.setting.localization.localization',compact('permissions','moduleName'));
    }
}
