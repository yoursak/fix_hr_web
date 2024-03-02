<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;
use App\Models\DesignationList;

class DesignatonListLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $searchFilter;
    public function render()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $page = $this->perPage != null ? $this->perPage : 10;
        $Designation = DB::table('designation_list')
        ->where('business_id',Session::get('business_id'))
        ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
            $searchFind = "%{$this->searchFilter}%";
            $query->where(function ($query) use ($searchFind) {
                $query
                ->where('desig_name', 'like', $searchFind);
            });
        })
        ->paginate($page)
        ->withQueryString();

        return view('livewire.settings.designaton-list-livewire',compact('Designation','permissions','moduleName'));
    }
}
