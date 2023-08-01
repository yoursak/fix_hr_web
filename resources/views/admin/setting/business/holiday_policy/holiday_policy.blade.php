    @extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
@endsection
@section('settings')

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Holiday Templates</div>
        <p class="text-muted">Create Template to give automatic paid leaves to staff on public holidays</p>
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
                    <h5 class="my-auto">FY 23-24</h5>
                </div>
                <div class="col-xl-2 my-auto">
                    <p class="my-auto text-muted">7 Holidays</p>
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
                                <input type="checkbox" name="custom-switch-checkbox"
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
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
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
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
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
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
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
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
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
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
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
        <div class="card-body d-none" id="searchTemp">
            <div class="row">
                <div class="col-md-12 col-xl-4">
                    <div class="form-group">
                        <p class="form-label">Search By template Name</p>
                        <input type="search" class="form-control header-search" placeholder="Search Template" aria-label="Search" tabindex="1">
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <p class="form-label">Annual Holiday Period</p>
                    <div class="form-group d-flex">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                        </div>
                        <label class="form-label mx-3 my-auto">To</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body d-none" id="editTempForm">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h4 class="title">Holidays</h4>
                            <div class="page-rightheader ms-md-auto">
                                <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                    <div class="btn-list d-flex">
                                        <a class="modal-effect btn btn-block mb-3" data-effect="effect-scale"
                                            data-bs-toggle="modal" href="#addempmodal"><b class="text-primary">Add New Holiday</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5 my-auto">
                                    <p class="my-auto ">Holiday Name</p>
                                </div>
                                <div class="col-xl-6 my-auto">
                                    <p class="my-auto ">Holiday Date</p>
                                </div>
                            </div>
                            <div class="row my-auto py-2">
                                <div class="col-xl-5 my-auto">
                                        <input type="text" class="form-control bg-muted" id="inputName" placeholder="Enter Holiday Name">
                                </div>
                                <div class="col-xl-4 my-auto">
                                    <div class="form-group d-flex my-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-1 my-auto">
                                    <div class="d-flex justify-content-end">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </div>
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
        <div class="card-body" id="TempName">
            <div class="row">
                <div class="col-md-12 col-xl-4">
                    <div class="form-group">
                        <p class="form-label">Template Name</p>
                        <input type="search" class="form-control header-search" placeholder="Enter Template" aria-label="Search" tabindex="1">
                    </div>
                </div>
                <div class="col-md-12 col-xl-6">
                    <p class="form-label">Annual Holiday Period</p>
                    <div class="form-group d-flex">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                        </div>
                        <label class="form-label mx-3 my-auto">To</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" id="TempForm">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h4 class="title">Holidays</h4>
                            <div class="page-rightheader ms-md-auto">
                                <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                    <div class="btn-list d-flex">
                                        <a class="modal-effect btn btn-block mb-3" data-effect="effect-scale"
                                            data-bs-toggle="modal" href="#addempmodal"><b class="text-primary">Add New Holiday</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5 my-auto">
                                    <p class="my-auto ">Holiday Name</p>
                                </div>
                                <div class="col-xl-6 my-auto">
                                    <p class="my-auto ">Holiday Date</p>
                                </div>
                            </div>
                            <div class="row my-auto py-2">
                                <div class="col-xl-5 my-auto">
                                        <input type="text" class="form-control bg-muted" id="inputName" placeholder="Enter Holiday Name">
                                </div>
                                <div class="col-xl-4 my-auto">
                                    <div class="form-group d-flex my-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-1 my-auto">
                                    <div class="d-flex justify-content-end">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" text-end">
                <a href="#" class="btn btn-outline-primary" id="tempSave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Apply Template</a>
            </div>
        </div>
    </div>
</div>
<div class=" text-end">
    <a href="{{url('settings/businesssetting')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Apply Changes</a>
</div>
@endsection
