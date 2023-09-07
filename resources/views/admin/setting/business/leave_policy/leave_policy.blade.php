@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
                        {{-- <a href="javascript:void(0);" type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#deletemodalview">Create Templates</a> --}}
                        {{-- <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal" id="newTempFormBtn">Create Templates</button> --}}
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#myModal">
                            Create Templates
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-3 p-auto">
                        <form action="" method="post">
                            <div class="row ">
                                <div class="border-0 pl-3">
                                    <h4 class="card-title "><span>Leave Setting</span></h4>
                                </div>
                                <div class="card-body pb-2">
                                    {{-- <div class="row form-group">
                                        <div class="col-4 col-xl-4">
                                            <p class="fs-15 form-label">Policy Name</p>
                                        </div>
                                        <div class="col-8 col-xl-4 ">
                                            <input type="text" class="form-control bg-muted form-label" id="inputName"
                                                placeholder="Enter Template Name">
                                        </div>
                                    </div> --}}

                                    
                                    <div class="row from-group">
                                        <div class="col-4 col-xl-4 ">
                                            <p class="my-auto fs-15 form-label">Policy Name</p>
                                        </div>
                                        <div class="col-8 col-xl-4 ">
                                            <input type="text" class="form-control bg-muted form-label" id="inputName"
                                                placeholder="Enter Template Name">
                                        </div>
                                    </div>

                                    <div class="row pt-3">
                                        <div class="col-4 col-xl-4 ">
                                            <p class="my-auto fs-15 form-label">Leave Policy Cycle</p>
                                        </div>
                                        <div class="col-8 col-xl-4 ">
                                            <div class="btn-group" role="group"
                                                aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth"
                                                    checked="">
                                                <label class="btn btn-outline-dark" for="btnradiomonth">Monthly</label>
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradioyear">
                                                <label class="btn btn-outline-dark" for="btnradioyear">Yearly</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-3">
                                        <div class="col-xl-4">
                                            <p class="my-auto fs-15 form-label">Leave Period</p>
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
                                    {{-- <div class="row my-5">
                                <div class="col-4 col-xl-4 my-auto">
                                    <p class="my-auto fs-15"><b>Sandwitch Leave</b></p>
                                </div>
                                <div class="col-8 col-xl-4 my-auto">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio" id="btnradioCount1" checked="">
                                        <label class="btn btn-outline-dark" for="btnradioCount1">Count</label>
                                        <input type="radio" class="btn-check" name="btnradio" id="btnradioIgnore1">
                                        <label class="btn btn-outline-dark" for="btnradioIgnore1">Ignore</label>
                                    </div>
                                </div>
                            </div> --}}
                                </div>
                            </div>
                            <hr style="background: black" />
                            <div class="row pt-3 mt-3">
                                <div class="  col border-0">
                                    <h4 class="card-title"><span>Leave Category</span></h4>
                                </div>
                                <div class="col text-end mr-3">
                                    <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete" value="Add More" onclick="addMore()"><i
                                            class="fe fe-plus text-primary">Add</i></a>
                                </div>
                                {{-- <div class="card-body" id="dynamictable"> --}}
                                    <div class="row card-body pt-0 pr-0 " id="dynamictable">
                                        <div class="col-xl-3 pt-3">
                                            <label for="inputCity" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" id="inputCity"
                                                placeholder="Category Name">
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputCity" class="form-label ">Days</label>
                                            {{-- <input type="text" class="form-control bg-muted" id="inputCity"
                                            placeholder="Days"> --}}
                                            <input type="number" class="form-control bg-muted" placeholder="Count">
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputState" class="form-label">Unused Leave Rule</label>
                                            <select class="form-control select2" data-placeholder="Leave Rule">
                                                <option label="Fixed Amount"></option>
                                                <option>Lapse</option>
                                                <option>Carry Forward</option>
                                                <option>Encash</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputCity" class="form-label">Carry Forward Limit</label>
                                            <input type="text" class="form-control" id="inputCity"
                                                placeholder="Days">
                                        </div>

                                        <div class="col-xl-2 pt-3">
                                            <label for="inputState" class="form-label">Applicable To</label>
                                            <select class="form-control select2" data-placeholder="Applicable To">
                                                <option label="Fixed Amount"></option>
                                                <option>All</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-1 text-end" style="padding-top:45px;">
                                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete"><i
                                                    class="feather feather-trash danger text-danger"></i></a>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                            {{-- <hr style="background: black" />
                        {{-- style="margin: auto;" --}}
                            {{-- <div class="row pb-4">
                            <div class="card-header  border-0">
                                <div class="col-xl-8 p-0">
                                <h4 class="card-title"><span >Leave Approval</span></h4>
                            </div>
                                <div class="text-end col-xl-4 p-0 ">
                                <select class="form-select" aria-label="Default">
                                    <option selected>Set Multilavel Approval</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select></div>
                            </div>
                        
                        </div> --}}

                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#">Apply</button>
                        </div>

                        {{-- <div class="">
                            {{-- <button class="btn btn-danger mx-2" data-bs-dismiss="modal">Decline</button> --}}
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    {{-- delete confirmation --}}

    {{-- delete confirmation --}}


    <div class="row">
        <div class="card">
            <div class="card-body border-bottum-0 p-2">
                <div class="row">
                    <div class="col-6 col-xl-3 my-auto">
                        <h5 class="my-auto">FD Leave Template</h5>
                    </div>
                    <div class="col-6 col-xl-2 my-auto">
                        <p class="my-auto text-muted">2 Leaves Per Month</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto text-muted">Applied to 14 Employees</p>
                    </div>
                    <div class="col-8 col-xl-2">
                        <p class="my-auto text-muted">
                            <a class="btn text-primary" id="manageemp1" href="#"><b>Manage Employee List</b></a>
                            <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                    <div class="col-4 col-xl-2">
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
            < </div>
        </div>

        <div class=" text-end">
            <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Apply Changes</a>
        </div>

        {{-- Set Multilavel Approval Modal --}}
        <div class="modal fade" id="SetMultilavelApprovalModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body border-0 ">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h6 class="card-title">Set Multilavel Approval</h6>
                            </div>
                            <div class="card-body border-0">
                                <div class="row">
                                    <div class="col-md-12 col-xl-12">
                                        <div class="form-group">
                                            <label class="form-label">Choose Type of Approval:</label>
                                            <select name="attendance" class="form-control custom-select select2"
                                                data-placeholder="Type of Approval" id='lavelofapproval'>
                                                <option label="Select Employee"></option>
                                                <option value="1">Lavel One</option>
                                                <option value="2">Lavel Two</option>
                                                <option value="3">Lavel Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <div class="row">
                                            <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                                <div class="form-group d-none" id="firstlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">First
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                                <div class="form-group d-none" id="secondlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">Second
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                                <div class="form-group d-none" id="thirdlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">Final
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit Multilavel Approval Modal --}}
        <div class="modal fade" id="EditMultilavelApprovalModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body border-0">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h6 class="card-title">Edit Multilavel Approval</h6>
                            </div>
                            <div class="card-body border-0">
                                <div class="row">
                                    <div class="col-md-12 col-xl-12">
                                        <div class="form-group">
                                            <label class="form-label">Choose Type of Approval:</label>
                                            <select name="attendance" class="form-control custom-select select2"
                                                data-placeholder="Type of Approval" id='Editlavelofapproval'>
                                                <option label="Select Employee"></option>
                                                <option value="1">Lavel One</option>
                                                <option value="2">Lavel Two</option>
                                                <option value="3">Lavel Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <div class="row">
                                            <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                                <div class="form-group d-none" id="Editfirstlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">First
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                                <div class="form-group d-none" id="Editsecondlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">Second
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                                <div class="form-group d-none" id="Editthirdlavel">
                                                    <label class="form-label fs-12"
                                                        style="color: rgb(173, 139, 144);">Final
                                                        Approved By:</label>
                                                    <select name="attendance"
                                                        class="form-control custom-select select2 d-none"
                                                        data-placeholder="Select Employee">
                                                        <option label="Select Employee"></option>
                                                        <option value="1">Employer</option>
                                                        <option value="2">Manager</option>
                                                        <option value="3">HR</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            function addMore() {
                $('#dynamictable').append(
                    ' <div class="col-xl-3 pt-3"> <label for="inputCity" class="form-label">Category Name</label> <input type="text" class="form-control" id="inputCity" placeholder="Category Name"> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Days</label> <input type="number" class="form-control bg-muted" placeholder="Count"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Unused Leave Rule</label> <select class="form-control select2" data-placeholder="Leave Rule"> <option label="Leave Rule"></option> <option>Lapse</option> <option>Carry Forward</option> <option>Encash</option> </select> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Carry Forward Limit</label> <input type="text" class="form-control" id="inputCity" placeholder="Days"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Applicable To</label> <select class="form-control select2" data-placeholder="Applicable To"> <option label="Applicable To"></option> <option>All</option> <option>Male</option> <option>Female</option> </select> </div> <div class="col-xl-1  text-end"  style="padding-top:45px;"> <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash danger text-danger"></i></a>  '
                );
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
