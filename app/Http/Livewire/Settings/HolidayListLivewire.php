<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

use Session;
use DB;
use App\Helpers\Central_unit;
use App\Models\PolicyMasterEndgameMethod;
use Livewire\WithPagination;
class HolidayListLivewire extends Component
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
        $HolidayTemplate = DB::table('policy_holiday_template')->where('business_id',Session::get('business_id'))->paginate($page)->withQueryString();
        $masterEndAssignCheck = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))->select('holiday_policy_ids_list')->get();
        return view('livewire.settings.holiday-list-livewire',compact('moduleName','permissions','HolidayTemplate','masterEndAssignCheck'));
    }
}
