<div>
    @php
        $centralUnit = new App\Helpers\Central_unit();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $ITEM = $LOADED->SectionEmployeeCounters();
        //dd($ITEM);
        $Designation = $centralUnit->DesignationList();
    @endphp
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/payroll') }}">Payroll Setup</a></li>
            <li class="active"><span><b>Salary Template</b></span></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12 p-5   ">
            <div class="card">

                <div class="card-header border-0">
                    <h4 class="card-title">Salary Template
                    </h4>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <div class="form-group pt-2">

                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                    data-bs-toggle="modal" wire:click="createSalaryTemplate">Create Salary
                                    Template</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">



                </div>
            </div>
        </div>
    </div>

</div>
