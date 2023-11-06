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
use App\Models\LoginAdmin;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
use App\Models\ModelHasPermission;
use App\Models\BusinessDetailsList;
use App\Models\PolicyHolidayDetail;
use App\Models\AdminNotice;

use App\Models\EmployeePersonalDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Emp = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();
        $Holiday = PolicyHolidayDetail::where('business_id', Session::get('business_id'))->get();
        $Notice = AdminNotice::where('business_id', Session::get('business_id'))->get();

        $root = compact('moduleName', 'permissions', 'Emp', 'Holiday', 'Notice');
        return view('admin.dashboard.dashboard', $root);
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/thankyou');
    }
}
