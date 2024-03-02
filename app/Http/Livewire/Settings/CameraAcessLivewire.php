<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;

class CameraAcessLivewire extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $toDateFilter, $fromDateFilter, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $modes = DB::table('static_attendance_methods')->get();
        $bName = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first('business_name');
        $cameraAccess = DB::table('camera_permission')
            ->where('camera_permission.business_id', Session::get('business_id'))
            ->leftJoin('static_attendance_methods', 'camera_permission.mode_check', '=', 'static_attendance_methods.id')
            ->orderBy('camera_permission.id', 'DESC')
            ->select('camera_permission.*', 'static_attendance_methods.id as attmethodid', 'static_attendance_methods.method_name')
            ->paginate($page)
            ->withQueryString();
        $Type = DB::table('static_attendance_mode')->whereIn('id', [1, 2])->get();
        return view('livewire.settings.camera-acess-livewire', compact(['bName', 'cameraAccess', 'modes', 'Type', 'permissions']));
    }
}
