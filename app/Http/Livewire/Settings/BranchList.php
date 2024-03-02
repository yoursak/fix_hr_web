<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;

class BranchList extends Component
{
    public $perPage, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $branch = DB::table('branch_list')
        ->where('business_id', Session::get('business_id'))
        ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
            $searchFind = "%{$this->searchFilter}%";
            $query->where(function ($query) use ($searchFind) {
                $query
                ->where('branch_name', 'like', $searchFind)
                ->orWhere('branch_email', 'like', $searchFind);
            });
        })
        ->select('*')
        ->paginate($page)
        ->withQueryString();
        return view('livewire.settings.branch-list',compact('branch','moduleName','permissions'));
    }
}
