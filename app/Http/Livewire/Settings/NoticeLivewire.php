<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Session;
use DB;
use App\Helpers\Central_unit;
use Livewire\WithPagination;
class NoticeLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage;
    public $toDateFilter, $fromDateFilter, $searchFilter;
    public function mount(){
        $this->fromDateFilter = date('Y-m-d', strtotime(date('Y-m-') . '1'));
        $this->toDateFilter = date('Y-m-d', strtotime(date('Y-m-') . date('t')));
    }
    public function render()
    {
        $from = $this->fromDateFilter != null ? date('Y-m-d', strtotime($this->fromDateFilter)) : $this->fromDateFilter;
        $to = $this->toDateFilter != null ? date('Y-m-d', strtotime($this->toDateFilter)) : $this->toDateFilter;
        $page = $this->perPage != null ? $this->perPage : 10;
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Notice = DB::table('admin_notices')
            ->where('business_id', Session::get('business_id'))
            ->when($from, function ($query) use ($from) {
                $query->where('date', '<=', $from);
            })
            ->when($to, function ($query) use ($to) {
                $query->where('date', '>=', $to);
            })
            ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
                $searchFind = "%{$this->searchFilter}%";
                $query->where(function ($query) use ($searchFind) {
                    $query
                    ->where('title', 'like', $searchFind)
                    ->orWhere('description', 'like', $searchFind)
                    ->orWhere('date', 'like', $searchFind);
                });
            })
            ->paginate($page)
            ->withQueryString();

        return view('livewire.settings.notice-livewire',compact('Notice','permissions','moduleName'));
    }
}
