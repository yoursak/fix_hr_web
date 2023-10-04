<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mail\AuthMailer;
use App\Helpers\Central_unit;
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;

class DashboardController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName=$accessPermission[0];
        $permissions=$accessPermission[1];
        $Emp = DB::table("employee_personal_details")->where('business_id',Session::get('business_id'))->get();
        $root= compact('moduleName', 'permissions','Emp');
        return view('admin.dashboard.dashboard',$root);
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/thankyou');
    }
}
