<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use DB;
use Session;
use App\Helpers\Central_unit;
use Livewire\WithPagination;

class AttendanceSubmitListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $submittedData = DB::table('attendance_submit')->where('business_id', Session::get('business_id'))->paginate($page)->withQueryString();
        return view('livewire.attendance.attendance-submit-list-livewire',compact('submittedData','permissions','moduleName'));
    }
}
