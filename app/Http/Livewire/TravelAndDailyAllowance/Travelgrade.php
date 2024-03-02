<?php

namespace App\Http\Livewire\TravelAndDailyAllowance;

use App\Models\employee\EmployeePersonalDetail;
use App\Models\GradeList;
use App\Models\PolicyTadaGradeCategory;
use Livewire\Component;
use Session;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;


class Travelgrade extends Component
{
    use WithPagination;

    public $contacts, $name, $phone, $contact_id;

    public $perPage,
        $gradeFilter = [],
        $nameCategory,
        $designation = [];
    protected $tableShows;

    protected $listeners = ['getDesignation'];

    protected $paginationTheme = 'bootstrap';
    public $gradeGroup;
    public $updateMode = false;
    public $inputs = [];
    public $selectedValues = [];
    public $selectedDesignations = [];
    public $selectedDesignationIds = [];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public $i = 1;
    public function mount()
    {
        $this->getData();
    }
    public function hydrate()
    {
        // $this->getData();/
        $this->inputs;
        $this->nameCategory;
        $this->gradeFilter;
        $this->selectedDesignations;
        $this->selectedDesignationIds;
    }

    public function existItemInsert($i)
    {
        array_push($this->inputs, $i);
    }

    public function add()
    {
        $var = $this->i;
        array_push($this->inputs, $this->i++);
        $this->emit('$hydrate');
        $this->nameCategory[$var] = '';
        $this->gradeFilter[$var] = '';
        $this->selectedDesignations[$var] = '';
    }



    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function getDesignation($index)
    {
        $gradeID = $this->gradeFilter[$index];
        $this->tableShows[$index] = EmployeePersonalDetail::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')->whereIn('employee_personal_details.grade', $gradeID)->where('employee_personal_details.business_id', Session::get('business_id'))->where('employee_personal_details.active_emp', '1')->select('designation_list.desig_id', 'designation_list.desig_name')->distinct()->get();
        $this->selectedDesignations[$index] = implode(',', $this->tableShows[$index]->pluck('desig_name')->toArray());
        $this->selectedDesignationIds[$index] = $this->tableShows[$index]->pluck('desig_id')->toArray();
    }

    public function getData()
    {
        $this->tableShows = PolicyTadaGradeCategory::where('business_id', Session::get('business_id'))->get();

        if ($this->tableShows->isEmpty()) {
            // $this->tableShows is empty
            $this->inputs = [0]; // Assuming you want at least one input initially
            $this->nameCategory = []; // Assuming you want an empty value for nameCategory initially
            $this->gradeFilter = []; // Assuming you want an empty value for gradeFilter initially
            $this->selectedDesignations = []; // Assuming you want an empty value for selectedDesignations initially
        } else {
            // $this->tableShows is not empty
            $lastItem = $this->tableShows->last();
            $this->i = $lastItem->id;
            $this->i++;
            foreach ($this->tableShows as $key => $item) {
                $this->existItemInsert($item->id);
                $gradeGroupArray = json_decode($item->grade_group);
                foreach ($gradeGroupArray as $i => $grade) {
                    $this->gradeFilter[$item->id][$i] = $grade;
                }
                $this->nameCategory[$item->id] = $item->grade_category;
                $this->selectedValues[$item->id] = json_decode($item->grade_group);
                $this->selectedDesignations[$item->id] = json_decode($item->designation_group);
                $this->selectedDesignationIds[$item->id] = json_decode($item->designation_id);
            }
        }
        return $this->tableShows;
    }

    // protected $messages = [
    //     'nameCategory.*.required' => 'Category Name field is required',
    //     'gradeFilter.*.required' => 'Grade field is required',
    //     'selectedDesignations.*.required' => 'Designation field is required',
    // ];




    public function render()
    {
        $Designation = 0; //$this->getDesignation();
        $Grade = GradeList::where('business_id', Session::get('business_id'))->get();
        return view('livewire.travel-and-daily-allowance.travelgrade', compact('Grade', 'Designation'));
    }
    private function resetInputFields()
    {
        $this->nameCategory = '';
        $this->gradeFilter = '';
        $this->selectedDesignations = '';
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // Define validation rules


    protected $rules = [
        'nameCategory.*' => 'required',
        'gradeFilter.*' => 'required',
    ];

    protected $messages = [
        'nameCategory.*' => 'This category field is required.',
    ];
    public function store()
    {
        // dd($this->inputs, $this->nameCategory, $this->gradeFilter, $this->selectedDesignations, $this->selectedDesignationIds);

        // $this->validate();
        $validatedDate = $this->validate(
            [
                'nameCategory.*' => 'required',
                'gradeFilter.*' => 'required',
                'selectedDesignations.*' => 'required',
            ],
            [
                'nameCategory.*.required' => 'Category Name field is required',
                'gradeFilter.*.required' => 'Grade field is required',
                'selectedDesignations.*.required' => 'Designation field is required',
            ],
        );

        $businessId = Session::get('business_id');
        $checkExistData = PolicyTadaGradeCategory::where('business_id', $businessId)->first();
        $loadItemsCheck = PolicyTadaGradeCategory::where('business_id', $businessId)->pluck('id')->toArray();
        $inputsId = $this->inputs;
        $nonExistentIds = array_diff($loadItemsCheck, $inputsId);
        if (!empty($nonExistentIds)) { // agar empty nhi hai to
            $delete = PolicyTadaGradeCategory::where('business_id', $businessId)->whereIn('id', $nonExistentIds)->delete();
        }



        foreach ($this->inputs as $key => $value) {
            $loadItems = PolicyTadaGradeCategory::where('business_id', $businessId)->where('id', $value)->first();
            if ($loadItems) {
                PolicyTadaGradeCategory::where('business_id', $businessId)
                    ->where('id', (int) $value)
                    ->update([
                        'business_id' => $businessId,
                        'branch_id' => Session::get('branch_id'),
                        'grade_category' => $this->nameCategory[$value],
                        'grade_group' => json_encode($this->gradeFilter[$value]),
                        'designation_group' => json_encode($this->selectedDesignations[$value]),
                        'designation_id' => json_encode($this->selectedDesignationIds[$value]),
                    ]);
            } else {
                PolicyTadaGradeCategory::create([
                    'business_id' => $businessId,
                    'branch_id' => Session::get('branch_id'),
                    'grade_category' => $this->nameCategory[$value],
                    'grade_group' => json_encode($this->gradeFilter[$value]),
                    'designation_group' => json_encode($this->selectedDesignations[$value]),
                    'designation_id' => json_encode($this->selectedDesignationIds[$value]),
                ]);
            }
        }
        if (!$checkExistData) {
            Alert::success('', 'Your Grade Category has been created successfully');
        } else {
            Alert::success('', 'Your Grade Category has been updated successfully');
        }
        return redirect()->to('/admin/settings/tadasettings/travelgrade');
    }
}
