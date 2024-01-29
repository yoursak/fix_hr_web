<?php

namespace App\Http\Livewire\PowerGrid;


// use {{ modelName }};

use App\Http\Livewire\Admin\EmployeePage;
use App\Models\EmployeePersonalDetail;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Illuminate\Support\Facades\Session;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Number;
use OpenSpout\Writer\CSV\Options;
use App\Models\BranchList;

use Livewire\Component;
// ... Your code using the Options class
// use Livewire\Component;
// use PowerComponents\LivewirePowerGrid\Traits\HasMultipleActions;

// use PowerComponents\LivewirePowerGrid\Button;
class EmployeePageTable extends PowerGridComponent
{
    use ActionButton, WithExport;
    public int $perPage = 10;
    protected $employees;

    public array $perPageValues = [0, 10, 20, 50];
    public $branchID;
    public $i = 1;
    // public bool $withSortStringNumber = true;

    // protected $listeners = ['applyFilters' => 'getData'];

    // => 'modeNode'
    public function setUp(): array
    {

        $this->showCheckBox();

        return [

            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showToggleColumns()->showSearchInput(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),

        ];
    }
    public function getData($branchID = null)
    {
        $this->branchID = $branchID;
        // $this->getListeners();
        // dd($this->branchID);
    }



    public function datasource($branch = null)
    {
        $query = EmployeePersonalDetail::where('employee_personal_details.business_id', Session::get('business_id'))
            ->join('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id');

        if ($branch != null) {
            $query->where('employee_personal_details.branch_id', $branch);
            // ->select('employee_personal_details.*', 'branch_list.branch_name', 'branch_list.branch_id')->get()
            $this->employees = $query->select('employee_personal_details.*', 'branch_list.branch_name', 'branch_list.branch_id')->get();
            // dd($this->employees);
        } else {

            $this->employees = $query->select('employee_personal_details.*', 'branch_list.branch_name', 'branch_list.branch_id')->get();
        }

        return $this->employees;
    }

    public function relationSearch(): array
    {
        return [];
    }
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn(
                'mode',
                fn ($employee) =>
                $this->employees->search($employee) + 1
            )
            ->addColumn('profile_photo', fn ($employee) =>
            '<div class="d-flex">
                <span class="avatar avatar-md brround me-3 rounded-circle" style="background-image: url(\'https://fixhr.app/storage/livewire_employee_profile/' . $employee->profile_photo . '\')"></span>
                <div class="me-3 mt-0 mt-sm-1 d-block">
                    <h6 class="mb-1 fs-14">
                        <a href="employee/profile/' . $employee->emp_id . '">
                            ' . $employee->emp_name . '&nbsp;' . $employee->emp_mname . '&nbsp;' . $employee->emp_lname . '
                        </a>
                    </h6>
                    <p class="text-muted mb-0 fs-12">
                        ' . $employee->desig_name . '
                    </p>
                </div>
            </div>')
            ->addColumn('emp_id')
            ->addColumn('branch_name', fn ($employee) => $employee->branch_name)
            ->addColumn('depart_name')
            ->addColumn(
                'doj',
                fn ($employee) =>
                Carbon::parse($employee->emp_date_of_joining)->format('d-m-Y')
            )
            ->addColumn(
                'mobile',
                fn ($employee) =>
                $employee->emp_mobile_number
            )
            ->addColumn(
                'action',
                fn ($employee) =>
                '<a type="button" data-bs-toggle="modal"
                data-bs-target="#updateStudentModal"
                wire:click="editStudent(' . htmlentities(json_encode([$employee->id, $employee->emp_id, $employee->business_id])) . ')"
                class="btn btn-primary btn-icon btn-sm">
                <i class="feather feather-edit" data-bs-toggle="tooltip"
                data-original-title="View"></i>
                </a>'
            );
    }



    public function editStudent($employee)
    {
        $this->emit('editStudent', $employee); //call by EmployeePageComponent in Livewire

    }
    public function columns(): array
    {
        return [

            Column::make('S No', 'mode')
                ->searchable(false) // Assuming the count column is not searchable
                ->sortable(false),
            Column::make('Employee Profile', 'profile_photo'),
            Column::make('Employee ID', 'emp_id')
                ->searchable()
                ->sortable(),
            Column::make('Branch', 'branch_name')
                ->searchable()
                ->sortable(),
            Column::make('Department', 'depart_name')
                ->searchable()
                ->sortable(),
            Column::make('Joining Date', 'doj')
                ->searchable()
                ->sortable(),
            Column::make('Phone Number', 'mobile')
                ->searchable()
                ->sortable(),
            Column::make('Action', 'action')
                ->searchable()
                ->sortable()
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {

        return [
            // Filter::inputText('emp_id'),
            Filter::select('branch_name')
                ->dataSource(
                    BranchList::where('business_id', Session::get('business_id'))->select('branch_id', 'branch_name')->distinct()->get()
                )
                ->optionValue('branch_name')
                ->optionLabel('branch_name')
            // ->value("Infinite Earth Solutions")

        ];
    }
}
// ->dataSource(EmployeePersonalDetail::select('branch_id')->distinct()->get())
// ->optionValue('branch_name')
// ->optionLabel('branch_name'),
// Filter::inputText('branch_name'),
// Filter::inputText('depart_name'),
// Filter::datepicker('Joining Date', 'Joining Date'),
// Filter::datepicker('created_at_formatted', 'created_at'),
// public function actions(): array
// {
//     return [

//         // Button::make('edit', 'action')
//         //     ->caption('<i class="feather feather-edit" data-bs-toggle="tooltip"
//         //     data-original-title="View"></i>')
//         //     ->class('btn btn-primary btn-icon btn-sm')
//         //     ->openModal('updateStudentModal', []) // Replace 'updateStudentModal' with your modal ID
//         //     ->onAction(function ($employee) {
//         //         $sendData = [
//         //             'id' => $employee->id,
//         //             'emp_id' => $employee->emp_id,
//         //             'business_id' => $employee->business_id,
//         //         ];
//         //         $this->emit('editStudent', $sendData);
//         //     }),
//         //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
//         //        ->route('{{ modelKebabCase }}.edit', ['{{ modelKebabCase }}' => 'id']),
//         // Button::make('edit', 'Edit')
//         //     ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
//         //     ->dispatch('editStudent', ['dishId' => 'id'])
//         // Button::add('new-language')
//         //     ->caption('<i class="feather feather-edit"></i>')
//         //     ->class('btn btn-primary btn-icon btn-sm')
//         //     ->openModal('editStudent', []),
//         //    Button::make('destroy', 'Delete')
//         //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
//         //        ->route('{{ modelKebabCase }}.destroy', ['{{ modelKebabCase }}' => 'id'])
//         //        ->method('delete')
//     ];
// }

/*
->editStudent('<?php echo htmlentities(json_encode($sendData)); ?>');

    //        <a type="button" data-bs-toggle="modal" data-bs-target="#updateStudentModal"
    //        wire:click="editStudent('<?php echo htmlentities(json_encode($sendData)); ?>')"
    //        class="btn btn-primary btn-icon btn-sm">
    //        <i class="feather feather-edit" data-bs-toggle="tooltip"
    //            data-original-title="View"></i>
    //    </a>

*/