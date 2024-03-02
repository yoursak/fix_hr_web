<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\DepartmentList;
use App\Models\BranchList;
use App\Helpers\Central_unit;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Session;

class DepartmentListLivewire extends Component
{
    public $perPage, $searchFilter;
    public function render()
    {
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $branch = Session::get("branch_id") != '' ? Session::get('branch_id') : null;

        $Departments = DB::table("department_list")
        ->where('b_id',Session::get('business_id'))
        ->when($branch, function($query) use ($branch){
            $query->where('branch_id', $branch);
        })
        ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
            $searchFind = "%{$this->searchFilter}%";
            $query->where(function ($query) use ($searchFind) {
                $query
                ->where('depart_name', 'like', $searchFind);
            });
        })
        ->paginate($page)
        ->withQueryString();

        $data = compact('Departments', 'permissions', 'moduleName');
        return view('livewire.settings.department-list-livewire', $data);
    }

}
