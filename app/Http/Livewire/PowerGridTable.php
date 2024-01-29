<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Session;

use App\Models\EmployeePersonalDetail;

class PowerGridTable extends Component
{

    public $powerGrids;

    public function mount()
    {
        $query = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->get();


        $this->powerGrids = $query; // Fetch your PowerGrid data here
    }

    public function render()
    {
        $powerGrids = $this->powerGrids;
        return view('livewire.power-grid-table', compact('powerGrids'));
    }
}
