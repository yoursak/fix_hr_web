<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;
use App\Models\PolicyWeeklyHolidayList;

class WeekOffListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $toDateFilter, $fromDateFilter, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $data = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))
            ->join('static_week_off_type', 'policy_weekly_holiday_list.weekend_policy', '=', 'static_week_off_type.id')
            ->select('policy_weekly_holiday_list.*', 'static_week_off_type.week_off_type_name')
            ->paginate($page)
            ->withQueryString();
        // check master endgame assign or not
        $checkMaEnAssOrNot = DB::table('policy_master_endgame_method')->where('business_id', Session::get('business_id'))->select('weekly_policy_ids_list')->get();
        $staticweekoffType = DB::table('static_week_off_type')->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $days = [];

        foreach ($data as $item) {
            $days = json_decode($item->days, true); // Assuming 'days' column contains JSON data
        }
        return view('livewire.settings.week-off-list-livewire',compact('data', 'days', 'staticweekoffType', 'checkMaEnAssOrNot', 'permissions'));
    }
}
