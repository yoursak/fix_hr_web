@extends('admin.setting.setting')
@section('subtitle')
    Salary
@endsection

@section('css')
    <style>
        .active {
            border: solid 1px black;
        }
    </style>
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fa fa-calculator"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Salary Calculation Logic</h5>
                            </a>
                            <p>General settings such as, site title, logo, other general and
                                advanced settings.</p>
                            <a href="#" data-bs-target="#salaryCalLogic" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i
                                        class="fa fa-money"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Manage Salary Templates</h5>
                            </a>
                            <p>In this settings we can change sidemenu and main page can be
                                Controlled System.</p>
                            <a href="{{url('settings/salary/salaryTemp')}}">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-danger-transparent text-danger border-danger"><i
                                        class="fa fa-newspaper-o"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Employee Bank Account Details</h5>
                            </a>
                            <p>Notifications settings we can control the notifications privacy and
                                security settings.</p>
                            <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-warning-transparent text-warning border-warning"><i
                                        class="fa fa-bank"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Business Name in Bank Statement</h5>
                            </a>
                            <p>Web apps settings such as Apps,Elements & Mail related to web apps
                                can be Controlled.</p>
                            <a href="#" data-bs-target="#bname" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-success-transparent text-success border-success"><i
                                        class="fa fa-key"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Salary Details Access to Employee</h5>
                            </a>
                            <p>Region & language settings we can Add, Delete and edit your Region &
                                language.</p>
                            <a href="#" data-bs-target="#salaryDetailAccess" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fa fa-sort-numeric-desc"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Custom Deduction Plan</h5>
                            </a>
                            <p>Blog settings such as, enable blog, max mosts in page and more can be
                                controlled.</p>
                            <a href="#" data-bs-target="#deductionPlan" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Salary Calculation Logic --}}
    <div class="modal fade" id="salaryCalLogic">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Business Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" id="logic1"
                            class="list-group-item list-group-item-action flex-column align-items-start active">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Calendar Month</h5>
                            </div>
                            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget
                                risus varius blandit.</p>
                            <small>Donec id elit non mi porta.</small>
                        </a>
                        <a href="#" id="logic2"
                            class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Every Month 30 Days</h5>
                            </div>
                            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget
                                risus varius blandit.</p>
                            <small class="text-muted">Donec id elit non mi porta.</small>
                        </a>
                        <a href="#" id="logic3"
                            class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Exclude Weekly Offs</h5>
                            </div>
                            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget
                                risus varius blandit.</p>
                            <small class="text-muted">Donec id elit non mi porta.</small>
                        </a>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Business Name in bank detail --}}
    <div class="modal fade" id="bname">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Business Name in Bank Statement</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Your Employees will see the provided business name in their
                            bank statement against the creadited salary.</p>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                        <input class="form-control" placeholder="Business Name" type="text">
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 mt-1">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Salary detail  Access--}}
    <div class="modal fade" id="salaryDetailAccess">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Salary Details Access to Employee</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Employee with salary details access can see their salary slips and payment details in their Staff App</p>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="card-header">
                        <h6 class="modal-title ms-2">Salary Details Access</h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" id="NotselectedEmployees1" class="custom-control-input" name="example-radios" value="option1" checked>
                                        <span class="custom-control-label">All Employee</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" id="NotselectedEmployees" class="custom-control-input" name="example-radios" value="option1" >
                                        <span class="custom-control-label">No access</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" id="selectedEmployees" class="custom-control-input" name="example-radios" value="option1" >
                                        <span class="custom-control-label">Only Selected Employee</span>
                                    </label>
                                </div>
                                <div class="">
                                    <label for="abc" class="my-auto text-primary">Allaw current salary Access</label>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox"
                                            class="custom-switch-input my-auto">
                                        <span class="custom-switch-indicator my-auto"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none" style="height: 250px; overflow:scroll;" id="selectEmployee">
                        <table class="table mb-0 text-nowrap">
                            <thead>
                                <h6 class="modal-title ms-2">Select Employee</h6>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td>
                                        <label class="custom-switch">
                                            <input type="checkbox" id="checkboxEmp" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-0">Faith Harris</h6>
                                                <div class="clearfix"></div>
                                                <small class="text-muted">UI designer</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-start fs-13">+91 1234567890</td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);" class="action-btns"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mail"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Deduction Plan --}}
    <div class="modal fade" id="deductionPlan">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Custom Deduction Plan</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Entered amount will be deducted on first day of every month from selected Employee.</p>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <div class="row mt-3">
                            <div class="col-6">
                                <h5 class="mb-0 pb-0 text-dark fs-14 mt-1 ">Plan Name</h5>
                            </div>
                            <div class="col-6">
                                <input class="form-control" placeholder="Name will be shown in salary slip" type="text">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h5 class="mb-0 pb-0 text-dark fs-14 mt-1 ">Amount to be deduce from Employee</h5>
                            </div>
                            <div class="col-6">
                                <input class="form-control" placeholder="RS 0.00" type="text">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h5 class="mb-0 pb-0 text-dark fs-14 mt-1 ">Assign Employee</h5>
                            </div>
                            <div class="col-6">
                                <label for="abc" class="my-auto text-primary">For all employees</label>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox"
                                        class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 mt-1">By continuing you agree to <a href="#"
                            class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>
@endsection
