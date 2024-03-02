<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;
use App\Models\GradeList;

class GradeLstLivewre extends Component
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
        $data = GradeList::where('business_id', Session::get('business_id'))
        ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
            $searchFind = "%{$this->searchFilter}%";
            $query->where(function ($query) use ($searchFind) {
                $query
                ->where('grade_name', 'like', $searchFind);
            });
        })
        ->paginate($page)
        ->withQueryString();
        return view('livewire.settings.grade-lst-livewre', compact('permissions','moduleName','data'));
    }
}
