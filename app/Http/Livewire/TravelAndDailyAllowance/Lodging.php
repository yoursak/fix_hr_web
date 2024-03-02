<?php

namespace App\Http\Livewire\TravelAndDailyAllowance;

use App\Models\employee\EmployeePersonalDetail;
use App\Models\PolicyTadaLodging;
use Livewire\Component;
use Session;

class Lodging extends Component
{
    public $i = 0;
    public $lodging_limit_action = '';
    public $inputs = [];
    public $add_row = 0;
    public $increase = [];
    // public $selectedDesignations, $gradeCategory, $lodging_limit, $double_occupancy,$select_occupancy,$select_grade;
    public $gradeCategory, $travel, $travel_category,$lodging_limit,$select_occupancy,$double_occupancy,$currency;


    // public function add(){
    //     // array_pyssh($this->$increase) = $this->$add_row++;
    //     array_push($this->increase, $this->i++);
    //     // $this->increase[] = $this->add_row++;
    // }
    public function add()
    {
        array_push($this->increase, $this->i++);
    }

    public function remove($i)
    {
        // dd($i);
        unset($this->increase[$i]);
        $this->increase = array_values($this->increase);
    }

    public function lodging_limit_action($index)
    {
        // dd($index,'new');
        $occupancy = $this->lodging_limit[$index];
        $value =  $occupancy == 2 ? "Actual" : "";
        $this->select_occupancy[$index] = $value;
        $this->double_occupancy[$index] = $value;
    }
    public function lodging_limit($lodging_limit)
    {
        dd($this->lodging_limit);
    }
    public function store()
    {
        dd($this->gradeCategory,$this->travel,$this->travel_category,$this->lodging_limit,$this->select_occupancy,$this->double_occupancy);
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');
        foreach( $this->gradeCategory as $key => $all_data ){
            $lodging = new PolicyTadaLodging();
            $lodging->business_id = $business_id;
            $lodging->branch_id = $branch_id;
            $lodging->gradeCategory = $this->gradeCategory[$key];
            $lodging->travel = $this->travel[$key];
            $lodging->travel_category = $this->travel_category[$key];
            $lodging->lodging_limit = $this->lodging_limit[$key];
            $lodging->select_occupancy = $this->select_occupancy[$key];
            $lodging->double_occupancy = $this->double_occupancy[$key];
            // $lodging->currency = $this->currency;
            $lodging->save();
        }
        // dd($this->increase, $this->selectedDesignations);
    }

    public function render()
    {
        return view('livewire.travel-and-daily-allowance.lodging');
    }
}
