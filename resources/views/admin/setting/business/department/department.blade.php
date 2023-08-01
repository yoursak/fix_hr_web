@extends('admin.setting.setting')
@section('subtitle')
    Salary / Department Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Department Setting</div>
            <p class="text-muted">2 Active Department</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" id="addNewDepartment" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Assign Department</button>
                        <button type="button" id="SaveNewDepartment" class="btn btn-outline-success d-none" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Save Department</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Departmentes</b></span></h4>
            </div>
            <div class="card-body d-none" id="addDepartment">
                <div class="row" >
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Department Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department's Name</p>
                                        <input type="text" class="form-control" value="" placeholder="Enter Name" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department's Manager</p>
                                        <select class="form-control select2" data-placeholder="Department">
                                            <option label="Fixed Amount"></option>
                                            <option selected>Kunal Pandit</option>
                                            <option>Dilip Sahu</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Branch</p>
                                        <select class="form-control select2" data-placeholder="Department">
                                            <option label="Fixed Amount"></option>
                                            <option selected>Fixing Dots</option>
                                            <option>KES</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Phone</p>
                                        <input type="text" class="form-control" value="" placeholder="Enter Phone" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Employees</b></span></h5>
                                <p class="text-muted">You can add active Employees</p>
                            </div>
                        </div>
                        <div class="card-body" style="height:15rem; overflow:scroll">
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
                                                    class="feather feather-edit  text-primary"></i></a>
                                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete"><i
                                                    class="feather feather-trash-2 text-danger"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-4 my-auto">
                        <h5 class="my-auto">Infomation Tech.</h5>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">FixingDots</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><b>Kunal Pandit</b></p>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Department Branch</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>+91 8548658547</p>
                    </div>
                    <div class="col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="DepartmentEditbtn"  title="Edit">
                                <i class="feather feather-edit  text-dark"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-btns text-primary d-none" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="DepartmentSavebtn"  title="Save">Save</a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="DepartmentDeletebtn"  title="Delete">
                                <i class="feather feather-trash text-dark"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row d-none" id="editDepartment">
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Edit Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body" id="editDepartment1">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department Name</p>
                                        <input type="text" class="form-control" value="Infomation Tech." placeholder="Enter Name" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department Branch</p>
                                        <select class="form-control select2" data-placeholder="Department">
                                            <option label="Fixed Amount"></option>
                                            <option selected>FixingDots</option>
                                            <option>KES</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Manager</p>
                                        <select class="form-control select2" data-placeholder="Department">
                                            <option label="Fixed Amount"></option>
                                            <option selected>Kunal Pandit</option>
                                            <option>Dilip Sahu</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Phone</p>
                                        <input type="text" class="form-control" value="+91 8548658547" placeholder="Enter Phone" aria-label="Search" tabindex="1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header  border-0" id="editDepartment2">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Assign Employee</b></span></h5>
                                <p class="text-muted">2 Employees Assigned</p>
                            </div>
                        </div>
                        <div class="card-body" id="editDepartment3" style="height:15rem; overflow:scroll">
                            <table class="table mb-0 text-nowrap">
                                <thead class="my-auto">
                                    <label class="custom-switch my-auto">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="allEmp">
                                        <span class="custom-switch-indicator"></span>
                                        <label for="all" class="mx-2 text-dark my-auto"><b>All</b></label>
                                    </label>
                                </thead>
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
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
                                                data-bs-placement="top" title="Edit"><i
                                                    class="feather feather-edit  text-primary"></i></a>
                                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete"><i
                                                    class="feather feather-trash-2 text-danger"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div>
@endsection
