<?php

namespace App\Http\Livewire\PowerGrid;


// use {{ modelName }};
use App\Models\EmployeePersonalDetail;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Session;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
// use PowerComponents\LivewirePowerGrid\Button;
final class EmployeePageTable extends PowerGridComponent
{
    use ActionButton, WithExport;
    public int $perPage = 10;

    //Custom per page values
    public array $perPageValues = [0, 10, 20, 50];

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        // $this->showCheckBox();


        return [
            // Column::make('S.No')
            //     ->value(function ($data, $index) {
            //         return $index + 1;
            //     }),
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showToggleColumns()->showSearchInput(),

            // Footer::make()
            //     ->showPerPage()
            //     ->showRecordCount(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\{{ modelName }}>
     */
    public function datasource(): Builder
    {
        $businessID = Session::get('business_id');

        return EmployeePersonalDetail::query()
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->join('department_list', 'employee_personal_details.department_id', '=', 'department_list.depart_id')
            ->where('employee_personal_details.business_id', $businessID)
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY employee_personal_details.id) AS row_number')
            ->select('employee_personal_details.*', 'branch_list.branch_name', 'department_list.depart_name')
            ->orderBy('employee_personal_details.id', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */
    // protected function getRowNumber($row)
    // {
    //     $pageNumber = $this->paginator['current_page'] ?? 1; // Get current page number
    //     $index = $this->paginator['per_page'] * ($pageNumber - 1); // Calculate starting index for the current page
    //     return $index + $this->loopIndex + 1; // Calculate the row number (adding 1 for the base 1 indexing)
    // }
    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    // public function addColumns(): PowerGridColumns
    // {

    //     $counter = 0;
    //     return PowerGrid::columns()
    //         ->addColumn('id')
    //         ->addColumn('profile_photo')
    //         ->addColumn('emp_id')
    //         ->addColumn('branch_name')
    //         ->addColumn('depart_name');
    // }
    // ->addColumn('fname');
    // ->addColumn('name_lower', fn(EmployeePersonalDetail $model) => strtolower(e($model->fname)));
    // ->addColumn('created_at')
    // ->addColumn('created_at_formatted', fn(EmployeePersonalDetail $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));

    public function columns(): array
    {
        $counter = 0;
        return [

            Column::make('S.No', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Employee Profile', 'profile_photo')
                ->sortable()
                ->searchable(),
            Column::make('Employee ID', 'emp_id')
                ->searchable()
                ->sortable(),
            Column::make('Branch', 'branch_name')
                ->searchable()
                ->sortable(),
            Column::make('Department', 'depart_name')
                ->searchable()
                ->sortable(),
            Column::make('Joining Date', 'emp_date_of_joining')
                ->searchable()
                ->sortable(),
            Column::make('Phone Number', 'emp_mobile_number')
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
            Filter::inputText('fname'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }
    public function actions(): array
    {
        return [
            //    Button::make('edit', 'Edit')
            //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
            //        ->route('{{ modelKebabCase }}.edit', ['{{ modelKebabCase }}' => 'id']),
            // Button::make('edit', 'Edit')
            //     ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
            //     ->dispatch('editStudent', ['dishId' => 'id'])
            Button::add('new-language')
                ->caption('<i class="feather feather-edit"></i>')
                ->class('btn btn-primary btn-icon btn-sm')
                ->openModal('editStudent', []),
            //    Button::make('destroy', 'Delete')
            //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //        ->route('{{ modelKebabCase }}.destroy', ['{{ modelKebabCase }}' => 'id'])
            //        ->method('delete')
        ];
    }

    /*
->editStudent('<?php echo htmlentities(json_encode($sendData)); ?>');
    
        //        <a type="button" data-bs-toggle="modal" data-bs-target="#updateStudentModal"
        //        wire:click="editStudent('<?php echo htmlentities(json_encode($sendData)); ?>')"
        //        class="btn btn-primary btn-icon btn-sm">
        //        <i class="feather feather-edit" data-bs-toggle="tooltip"
        //            data-original-title="View"></i>
        //    </a>

    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid  EmployeePersonalDetail  Action Buttons.
     *
     * @return array<int, Button>
     */

    /*

    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('{{ modelKebabCase }}.edit', ['{{ modelKebabCase }}' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('{{ modelKebabCase }}.destroy', ['{{ modelKebabCase }}' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid  EmployeePersonalDetail  Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn(${{ modelKebabCase }}) => ${{ modelKebabCase }}->id === 1)
                ->hide(),
        ];
    }
    */
}
