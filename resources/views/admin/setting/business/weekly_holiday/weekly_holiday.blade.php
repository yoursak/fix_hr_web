@extends('admin.setting.setting')
@section('subtitle')
    Salary / Department Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Weekly Holiday Setting</div>
            <p class="text-muted">Assign weekly off days of your business to automatically mark attendance for those days.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Weekly Off</b></span></h4>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-4 my-auto">
                        <h5 class="my-auto"> Weekly Off Preferences</h5>
                    </div>
                    <div class="col-xl-5 my-auto">
                        <p class="my-auto fs-13 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                    </div>
                    <div class="col-xl-3">
                        <div class="btn-list radiobtns">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioCount2"=""
                                    data-bs-toggle="modal" data-bs-target="#businessLavel" checked>
                                <label class="btn btn-outline-dark" for="btnradioCount2">Business</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioIgnore2"
                                    data-bs-toggle="modal" data-bs-target="#employeeLavel">
                                <label class="btn btn-outline-dark" for="btnradioIgnore2">Employee</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <p class="card-title"><span style="color:rgb(104, 96, 151)"><b>Holiday Days</b></span></p>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"
                                checked>
                            <span class="custom-control-label fs-18">Sunday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Monday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Tuesday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Wednesday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Thrusday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Satureday</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div>

    <!-- Business Lavel MODAL -->
    <div class="modal fade" id="businessLavel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-5">
                        <h4 class="mb-1 fs-20 font-weight-semibold">Switch To Busines Lavel</h4>
                        <p class="my-auto fs-12 mt-5 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                            <div class="d-lg-flex d-block mt-5">
                                <div class="btn-list ms-auto">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Cancel</button>
                                    <button type="button"  class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Switch</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Business Lavel MODAL  -->
    <!-- Business Lavel MODAL -->
    <div class="modal fade" id="employeeLavel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-5">
                        <h4 class="mb-1 fs-20 font-weight-semibold">Switch To Employee Lavel</h4>
                        <p class="my-auto fs-12 mt-5 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                            <div class="d-lg-flex d-block mt-5">
                                <div class="btn-list ms-auto">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Cancel</button>
                                    <button type="button"  class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Switch</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Business Lavel MODAL  -->
@endsection
