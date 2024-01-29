<?php

namespace App\Http\Livewire;

use App\Exports\TableExcelExport;
use LaravelViews\Views\TableView;

use App\Models\EmployeePersonalDetail;
use Session;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Views\Traits\WithAlerts;
use LaravelViews\Facades\Header;
use LaravelViews\Views\View;

use Maatwebsite\Excel\Facades\Excel;
use App\Filters\Admin\EmployeePage\DepartmentActiveFilter;

use App\Filters\Admin\EmployeePage\BranchActiveFilter;
use App\Filters\Admin\EmployeePage\DesignationActiveFilter;
use App\Filters\Admin\EmployeePage\UsersActiveFilter;
use App\Filters\Admin\EmployeePage\CreatedFilter;
use LaravelViews\Facades\UI;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Storage;

use App\Models\BranchList;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\AttendanceList;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use LaravelViews\Actions\Action;

use App\Models\BusinessDetailsList;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Route;

//Implementation By Jayant
class EmployeePageTableView extends TableView
{
    use WithAlerts;
    public $employees;
    public $branch, $department, $designation, $searchFilter;
    protected $sortable = true;
    protected $paginate = 10;
    protected $model = EmployeePersonalDetail::class;
    protected $collection;

    protected $label = true;
    // public $searchBy = ['emp_id', 'emp_name', 'emp_mname', 'emp_lname', 'emp_mobile_number', 'branch_name', 'depart_name', 'desig_name'];
    protected $listeners = ['filterChanged', 'filterSearch', 'exportFile', 'copyTable', 'generatePdf', 'filedownload'];
    public $selectedBranch;
    protected $ruleManagement;

    // new CreatedFilter
    public $selectedColumns = [];



    // protected function filters()
    // {
    //     return [
    //         new BranchActiveFilter,
    //         new DepartmentActiveFilter,
    //         new DesignationActiveFilter,
    //         new UsersActiveFilter

    //     ];
    // }
    public function filterChanged($selected)
    {

        $this->branch = $selected[0];
        $this->department = $selected[1];
        $this->designation = $selected[2];
    }
    public function filterSearch($searchName)
    {
        $this->searchFilter = $searchName;
    }


    /**
     * CreateCurrentActiveTableActionData function creates the current active table action data.
     *
     * @return array Returns an array containing the employee details, branch active filter, department active filter, designation active filter, active filter, sort by, and sort order.
     */
    // public function CreateCurrentActiveTableActionData()
    // {
    //     $queryParams = RulesManagement::getDecodeUrlFiltration();
    //     $branchActiveFilter = $queryParams['filters']['branch-active-filter'] ?? null;
    //     $DesignationActiveFilter = $queryParams['filters']['designation-active-filter'] ?? null;
    //     $DepartmentActiveFilter = $queryParams['filters']['department-active-filter'] ?? null;
    //     $ActiveFilter = $queryParams['filters']['users-active-filter'] ?? null;
    //     $sortBy = $queryParams['sortBy'] ?? null;
    //     $sortOrder = $queryParams['sortOrder'] ?? null;
    //     $employeeDetailsQuery = $this->model::query();


    //     $this->joinAndFilter($employeeDetailsQuery);
    //     // ->join('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
    //     //     ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
    //     //     ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
    //     //     ->where('employee_personal_details.business_id', Session::get('business_id'))
    //     //     ->select('employee_personal_details.*', 'branch_list.branch_name as branch_name', 'department_list.depart_name as depart_name', 'designation_list.desig_name as designation_name');
    //     if ($branchActiveFilter !== null) {
    //         $employeeDetailsQuery->where('branch_name', $branchActiveFilter);
    //     }
    //     if ($DepartmentActiveFilter !== null) {
    //         $employeeDetailsQuery->where('depart_name', $DepartmentActiveFilter);
    //     }
    //     if ($DesignationActiveFilter !== null) {
    //         $employeeDetailsQuery->where('designation_name', $DesignationActiveFilter);
    //     }
    //     if ($ActiveFilter !== null) {
    //         $employeeDetailsQuery->where('active_emp', $ActiveFilter);
    //     }
    //     if ($sortBy !== null && $sortOrder !== null) {
    //         $employeeDetailsQuery->orderBy($sortBy, $sortOrder);
    //     }
    //     // Fetch the results
    //     $employeeDetails = $employeeDetailsQuery->get();

    //     // runtime cloning set count active employee or in - active
    //     $activeEmployeeDetailsQuery = clone $employeeDetailsQuery;
    //     $inactiveEmployeeDetailsQuery = clone $employeeDetailsQuery;
    //     $activeCount = $activeEmployeeDetailsQuery->where('active_emp', '1')->count();
    //     $inactiveCount = $inactiveEmployeeDetailsQuery->where('active_emp', '0')->count();

    //     return [$employeeDetails, $branchActiveFilter, $DepartmentActiveFilter, $DesignationActiveFilter, $ActiveFilter, $sortBy, $sortOrder, $activeCount, $inactiveCount];
    // }

    // public function generateEmployeePage($id)
    // {
    //     $collect = $this->CreateCurrentActiveTableActionData();
    //     $GetAllData = $collect[0];
    //     $branchName = $collect[1];
    //     $ActiveCount = $collect[7];
    //     $InActiveCount = $collect[8];

    //     $BusinessData = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
    //     $send = compact('GetAllData', 'BusinessData', 'branchName', 'ActiveCount', 'InActiveCount');


    //     $redirectRoute = 'admin/employee'; // Set your desired redirect route
    //     $pdf = PDF::loadView('generate-pdf.employee_table', $send);

    //     switch ($id) {
    //         case 1:
    //             $response = Excel::download($GetAllData, 'FixHr-EmployeeList.csv');
    //             break;

    //         case 2:
    //             $response = Excel::download($GetAllData, 'FixHr-EmployeeList.xlsx');
    //             break;

    //         case 3:
    //             $response = $pdf->download('FixHr-EmployeeList.pdf');
    //             break;

    //         case 4:
    //             $response = $pdf->stream('FixHr-EmployeeList.pdf');
    //             break;

    //         default:
    //             $response = null; // Handle the default case
    //             break;
    //     }

    //     if ($response) {
    //         return $response->withHeaders(['Location' => $redirectRoute]);
    //     }

    //     return redirect()->to($redirectRoute);
    // }



    public function filedownload()
    {
        $this->emit('filedownloads');
    }



    public function exportFile($id)
    {
        $pdf = PDF::loadView('generate-pdf.employee_table');

        return $pdf->download('EmployeePage-FixHr.pdf');
    }
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */

    public function headers(): array
    {

        return [
            Header::title('S.No'), Header::title('Employee ID')->sortBy('emp_id')->width('10%'),
            Header::title('Employee Profile')->sortBy('designation_name'), Header::title('Branch')->sortBy('branch_name'), Header::title('Department')->sortBy('depart_name'), Header::title('Joining Date')->sortBy('emp_date_of_joining'), Header::title('Phone Number')->sortBy('emp_mobile_number'), Header::title('Active')->sortBy('active_emp'), 'Action'
        ];
    }


    public function copyTable()
    {

        // dd("DS");   // Emit a JavaScript event to copy the table content
        $this->emit('copyTableContent');
        // // Show a flash message after the copy action
        $this->emit('showMessage', 'Table content copied to clipboard!');
    }

    public function exportCompleted()
    {
        // dd('d');
    }
    /**
     * Sets a model class to get the initial data
     */
    // protected $model = EmployeePersonalDetail::class;
    /**
     * Sets a initial query with the data to fill the table
     *
     * @return Builder Eloquent query
     */
    public function repository(): Builder
    {
        $query = $this->model::query();

        $this->joinAndFilter($query);

        $this->employees = $query->get();

        return $query;
    }

    private function joinAndFilter($query): void
    {
        $query->join('branch_list', 'branch_list.branch_id', '=', 'employee_personal_details.branch_id')
            ->join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select(
                'employee_personal_details.*',
                'branch_list.branch_name as branch_name',
                'department_list.depart_name as depart_name',
                'designation_list.desig_name as designation_name'
            );

        $this->applyLevelFilters($query);
    }
    private function applyLevelFilters($query): Builder
    {
        // $this->employees = $query;
        return $query->when($this->branch !== null && $this->branch !== '', function ($query) {
            $query->where('employee_personal_details.branch_id', $this->branch);
        })
            ->when($this->department !== null && $this->department !== '', function ($query) {
                $query->where('employee_personal_details.department_id', $this->department);
            })
            ->when($this->designation !== null && $this->designation !== '', function ($query) {
                $query->where('employee_personal_details.designation_id', $this->designation);
            })
            ->when($this->searchFilter !== null && $this->searchFilter !== '', function ($query) {
                $searchFind = "%{$this->searchFilter}%";
                $query->where(function ($query) use ($searchFind) {
                    $query->where('employee_personal_details.emp_name', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_mname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_lname', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_id', 'like', $searchFind)
                        ->orWhere('employee_personal_details.emp_date_of_joining', 'like', date('d-M-Y', strtotime($searchFind)))
                        ->orWhere('employee_personal_details.emp_mobile_number', 'like', $searchFind)
                        ->orWhere('branch_list.branch_name', 'like', $searchFind)
                        ->orWhere('department_list.depart_name', 'like', $searchFind)
                        ->orWhere('designation_list.desig_name', 'like', $searchFind);
                });
            });
    }


    public function editStudent($employee)
    {
        $this->emit('editStudent', $employee); //call by EmployeePageComponent in Live-wire

    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        $index = $this->employees->search($model) + 1;
        $status = ($model->active_emp) ?
            '<svg xmlns="http://www.w3.org/2000/svg" style="width:1.2em;height:1.2em;" class="d-inline-block  text-success " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>' : '<svg xmlns="http://www.w3.org/2000/svg" style="width:1.2em;height:1.2em;" class="d-inline-block  text-danger " fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>';

        // UI::badge('In Active', 'danger');

        // $i = 1;btn btn-primary btn-icon btn-sm
        // dd($model);
        return [

            $index,
            $model->emp_id,
            '<div class="d-flex">
                <span class="avatar avatar-md brround me-3 rounded-circle" style="background-image: url(\'https://fixhr.app/storage/livewire_employee_profile/' . $model->profile_photo . '\')"></span>
                <div class="me-3 mt-0 mt-sm-1 d-block">
                    <h6 class="mb-1 fs-14">
                        <a href="employee/profile/' . $model->emp_id . '">
                            ' . $model->emp_name . '&nbsp;' . $model->emp_mname . '&nbsp;' . $model->emp_lname . '
                        </a>
                    </h6>
                    <p class="text-muted mb-0 fs-12">
                        ' . $model->designation_name . '
                    </p>
                </div>
            </div>',
            $model->branch_name,
            $model->depart_name,
            \Carbon\Carbon::parse($model->emp_date_of_joining)->format('d-m-Y'),
            $model->emp_mobile_number,
            $status,
            '<a type="button" data-bs-toggle="modal"
            data-bs-target="#updateStudentModal"
            wire:click="editStudent(' . htmlentities(json_encode([$model->id, $model->emp_id, $model->business_id])) . ')"
            class=" btn btn-primary btn-icon btn-sm">
            <i class="feather feather-edit"   data-bs-toggle="tooltip"
            data-original-title="View"></i>
            </a>'
        ];
    }
}
