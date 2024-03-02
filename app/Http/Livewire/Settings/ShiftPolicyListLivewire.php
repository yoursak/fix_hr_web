<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;

class ShiftPolicyListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $toDateFilter, $fromDateFilter, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $attendaceShift = DB::table('policy_attendance_shift_settings')->where('business_id', Session::get('business_id'))->paginate($page)
            ->withQueryString();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('livewire.settings.shift-policy-list-livewire', compact('permissions', 'moduleName', 'attendaceShift'));
    }
}
