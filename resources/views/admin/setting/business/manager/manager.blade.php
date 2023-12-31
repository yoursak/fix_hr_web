@extends('admin.setting.setting')
@section('subtitle')
    Business / Manager Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        @php
            $getBranch = App\Helpers\Central_unit::BranchList();
            $getDesignation = App\Helpers\Central_unit::DesignationList();
            $getDepartment = App\Helpers\Central_unit::DepartmentList();
            // dd($getDesignation);
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Manager Setting</div>
            <p class="text-muted">2 Managers Assigned</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" id="addNewManager" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#addManager">Add Manager</button>
                        <button type="reset" id="SaveNewManager" class="btn btn-outline-success d-none">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Managers</b></span></h4>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-4 my-auto">
                        <h5 class="my-auto">Kunal Pandit</h5>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">kunalpandit@fixingdots.com</p>
                    </div>
                    <div class="col-5 col-xl-3 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><b>FixingDots</b></p>
                    </div>
                    <div class="col-5 col-xl-3 my-auto">
                        <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>+91 8548658547</p>
                    </div>
                    <div class="col-2 col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="MngEditbtn" title="Edit">
                                <i class="feather feather-edit  text-dark"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-btns text-primary d-none" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="MngSavebtn" title="Save">Save</a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="MngDeletebtn" title="Delete">
                                <i class="feather feather-trash text-dark"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row d-none" id="editManager">
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Edit Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body" id="editManager1">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Manager's Name</p>
                                        <input type="text" class="form-control" value="Kunal Pandit"
                                            placeholder="Enter Name" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department</p>
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
                                        <input type="text" class="form-control" value="+91 8548658547"
                                            placeholder="Enter Phone" aria-label="Search" tabindex="1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header  border-0" id="editManager2">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Assign Employee</b></span>
                                </h5>
                                <p class="text-muted">2 Employees Assigned</p>
                            </div>
                        </div>
                        <div class="card-body" id="editManager3" style="height:15rem; overflow:scroll">
                            <table class="table mb-0 text-nowrap">
                                <thead class="my-auto">
                                    <label class="custom-switch my-auto">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                            id="allEmp">
                                        <span class="custom-switch-indicator"></span>
                                        <label for="all" class="mx-2 text-dark my-auto"><b>All</b></label>
                                    </label>
                                </thead>
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
                        <h5 class="my-auto">Kunal Pandit</h5>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">kunalpandit@fixingdots.com</p>
                    </div>
                    <div class="col-5 col-xl-3 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><b>FixingDots</b></p>
                    </div>
                    <div class="col-5 col-xl-3 my-auto">
                        <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>+91 8548658547
                        </p>
                    </div>
                    <div class="col-2 col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="MngEditbtn" title="Edit">
                                <i class="feather feather-edit  text-dark"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-btns text-primary d-none"
                                data-bs-toggle="tooltip" data-bs-placement="top" id="MngSavebtn" title="Save">Save</a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" id="MngDeletebtn" title="Delete">
                                <i class="feather feather-trash text-dark"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row d-none" id="editManager">
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Edit Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body" id="editManager1">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Manager's Name</p>
                                        <input type="text" class="form-control" value="Kunal Pandit"
                                            placeholder="Enter Name" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Manager's Email</p>
                                        <input type="text" class="form-control" value="kunalpandit@fixingdots.com"
                                            placeholder="Enter Email" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department</p>
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
                                        <input type="text" class="form-control" value="+91 8548658547"
                                            placeholder="Enter Phone" aria-label="Search" tabindex="1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header  border-0" id="editManager2">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Assign Employee</b></span>
                                </h5>
                                <p class="text-muted">2 Employees Assigned</p>
                            </div>
                        </div>
                        <div class="card-body" id="editManager3" style="height:15rem; overflow:scroll">
                            <table class="table mb-0 text-nowrap">
                                <thead class="my-auto">
                                    <label class="custom-switch my-auto">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                            id="allEmp">
                                        <span class="custom-switch-indicator"></span>
                                        <label for="all" class="mx-2 text-dark my-auto"><b>All</b></label>
                                    </label>
                                </thead>
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

    {{-- manager modal  --}}
    <div class="modal fade" id="addManager">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <form action="{{ route('add.manager') }}" method="post">
                @csrf
                <div class="modal-content tx-size-sm">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Name</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="color: rgb(56, 113, 117)">
                            <div class="card-header border-0">
                                <div>
                                    <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Manager
                                                Detail</b></span></h5>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="form-label">Branch</p>
                                            <select class="form-control select2" id="mngrBranch" name="branch" required>
                                                @foreach ($getBranch as $branch)
                                                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="form-label">Department</p>
                                            <select class="form-control select2" id="#mngrDepartment" name="department"
                                                required>
                                                @foreach ($getDepartment as $depart)
                                                    <option value="{{ $depart->depart_id }}">{{ $depart->depart_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="form-label">Designation</p>
                                            <select class="form-control select2" id="#mngrDesignation" name="designation"
                                                required>
                                                @foreach ($getDesignation as $designation)
                                                    <option value="{{ $designation->desig_id }}">
                                                        {{ $designation->desig_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="form-label">Manager's Employee ID</p>
                                            <input type="text" class="form-control" id="mngrID" value=""
                                                placeholder="Enter Name" aria-label="Search" tabindex="1"
                                                name="EmpId" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p class="form-label">Manager's Name</p>
                                            <input type="text" class="form-control" id="mngrName" value=""
                                                placeholder="Enter Name" aria-label="Search" tabindex="1"
                                                name="name" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  border-0">
                        <button type="submit" class="btn btn-primary">Assign Manager</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- @section('script')
<script>
    $(document){
        $('#mngrName').on('change', function() {
            alert(this.value);
        });
    }
</script>
@endsection --}}
