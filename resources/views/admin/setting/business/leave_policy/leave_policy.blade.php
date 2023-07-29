@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Leave Templates</div>
            <p class="text-muted">Create Template to give leaves to staff on month if they want</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn">Create Templates</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-3 my-auto">
                        <h5 class="my-auto">FD Leave Template</h5>
                    </div>
                    <div class="col-xl-2 my-auto">
                        <p class="my-auto text-muted">2 Leaves Per Month</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto text-muted">Applied to 14 Employees</p>
                    </div>
                    <div class="col-xl-2">
                        <p class="my-auto text-muted">
                            <a class="btn text-primary" id="manageemp1" href="#"><b>Manage Employee List</b></a>
                            <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                    <div class="col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a class="btn text-primary" id="editTempBtn" href="#"><b>Edit Template</b></a>
                            <a class="btn btn-outline-success d-none" id="applyTempBtn" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 d-none" style="height: 20rem; overflow:scroll" id="emplist1">
                <table class="table mb-0 text-nowrap">
                    <tbody>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body d-none" id="editTempForm">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Setting</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Template Name</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <input type="text" class="form-control bg-muted" id="inputName"
                                            placeholder="Enter Template Name">
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Leave Policy Cycle</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto ">Yearly</p>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Accrual Type</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <div class="form-group">
                                            <select class="form-control select2" data-placeholder="Policy Cycle">
                                                <option label="Fixed Amount"></option>
                                                <option>Monthly</option>
                                                <option>Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Leave Period</b></p>
                                    </div>
                                    <div class="col-xl-6 my-auto">
                                        <div class="form-group d-flex">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                    type="text">
                                            </div>
                                            <label class="form-label mx-3 my-auto">To</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Sandwitch Leave</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <div class="btn-list radiobtns">
                                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio111" checked="">
                                                <label class="btn btn-outline-primary" for="btnradio111">Count</label>
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradio333">
                                                <label class="btn btn-outline-primary" for="btnradio333">Ignore</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Category</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Category Name</b></p>
                                    </div>
                                    <div class="col-xl-2 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Count</b></p>
                                    </div>
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Unused Leave Rule</b></p>
                                    </div>
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Encashment/Carry Forward
                                                Limited</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <input type="text" class="form-control bg-muted" placeholder="Casual Leave">
                                    </div>
                                    <div class="col-xl-2">
                                        <input type="number" class="form-control bg-muted" placeholder="count">
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select class="form-control select2" data-placeholder="Carry Forward">
                                                <option label="Fixed Amount"></option>
                                                <option>Monthly Regular</option>
                                                <option>Hourly Regular</option>
                                                <option>Daily Regular</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <input type="text" class="form-control bg-muted" placeholder="Days">
                                    </div>
                                    <div class="col-xl-1">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </div>
                                    <div>
                                        <a href="#" class="btn text-primary my-3"><b>Add Leave category</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Approval</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-xl-6 my-auto">
                                        <p class="my-auto d-flex">
                                            <b class="mx-2">1. Employee</b>
                                            <b class="mx-2">--------</b>
                                            <b class="mx-2">2. Employer</b>
                                            <b class="mx-2 text-success">--------</b>
                                            <b class="mx-2 text-success">Approval</b>
                                        </p>
                                    </div>
                                    <div class="col-xl-6 my-auto text-end">
                                        <a href="#" class="btn btn-outline-primary btn-sm"><span>Edit</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card d-none" id="newTemplate">
            <div class="card-body" id="TempForm">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Setting</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Template Name</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <input type="text" class="form-control bg-muted" id="inputName"
                                            placeholder="Enter Template Name">
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Leave Policy Cycle</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio111" checked="">
                                            <label class="btn btn-outline-primary" for="btnradio111">Monthly</label>
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio333">
                                            <label class="btn btn-outline-primary" for="btnradio333">Yearly</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Accrual Type</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <div class="form-group">
                                            <select class="form-control select2" data-placeholder="Policy Cycle">
                                                <option label="Fixed Amount"></option>
                                                <option>Monthly</option>
                                                <option>Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Leave Period</b></p>
                                    </div>
                                    <div class="col-xl-6 my-auto">
                                        <div class="form-group d-flex">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                    type="text">
                                            </div>
                                            <label class="form-label mx-3 my-auto">To</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-xl-4 my-auto">
                                        <p class="my-auto fs-15"><b>Sandwitch Leave</b></p>
                                    </div>
                                    <div class="col-xl-4 my-auto">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio111" checked="">
                                            <label class="btn btn-outline-primary" for="btnradio111">Count</label>
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio333">
                                            <label class="btn btn-outline-primary" for="btnradio333">Ignore</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Category</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Category Name</b></p>
                                    </div>
                                    <div class="col-xl-2 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Count</b></p>
                                    </div>
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Unused Leave Rule</b></p>
                                    </div>
                                    <div class="col-xl-3 my-auto">
                                        <p class="my-auto"><b class="fs-13 text-muted">Encashment/Carry Forward
                                                Limited</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <input type="text" class="form-control bg-muted" placeholder="Casual Leave">
                                    </div>
                                    <div class="col-xl-2">
                                        <input type="number" class="form-control bg-muted" placeholder="count">
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <select class="form-control select2" data-placeholder="Carry Forward">
                                                <option label="Fixed Amount"></option>
                                                <option>Monthly Regular</option>
                                                <option>Hourly Regular</option>
                                                <option>Daily Regular</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <input type="text" class="form-control bg-muted" placeholder="Days">
                                    </div>
                                    <div class="col-xl-1">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </div>
                                    <div>
                                        <a href="#" class="btn text-primary my-3"><b>Add Leave category</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(119, 110, 79)">Leave Approval</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-xl-6 my-auto">
                                        <p class="my-auto d-flex text-muted">
                                            Multilavel Approval Setting is set to lavel 1 by default
                                        </p>
                                    </div>
                                    <div class="col-xl-6 my-auto text-end">
                                        <a href="#" class="btn btn-secondary"><span>Set Multilavel Approval</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" text-end">
                    <a href="#" class="btn btn-outline-primary" id="tempSave" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Save">Apply Template</a>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Apply Changes</a>
    </div>
@endsection
