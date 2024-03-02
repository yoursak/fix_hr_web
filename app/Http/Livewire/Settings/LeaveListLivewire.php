<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use App\Models\PolicySettingLeaveCategory;
use App\Models\PolicySettingLeavePolicy;
use Livewire\WithPagination;

class LeaveListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $toDateFilter, $fromDateFilter, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $call = new Central_unit();
        $BranchList = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $getleavepolicy = DB::table('policy_master_endgame_method')->where('business_id', Session::get('business_id'))->select('leave_policy_ids_list')->get();
        $Leaves = PolicySettingLeaveCategory::where('business_id', session()->get('business_id'))->get();
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))->paginate($page)->withQueryString();
        $leaveType = DB::table('static_leave_category')
            ->where('id', '!=', '8')
            ->where('id', '!=', '9')
            ->get();
        $applicableTo = DB::table('static_leave_category_applicable_to')->get();
        return view('livewire.settings.leave-list-livewire',compact('leaveType', 'leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName', 'applicableTo', 'getleavepolicy'));
    }
}
