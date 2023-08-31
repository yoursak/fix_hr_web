@extends('admin.layout.master')
@section('title')
Employee
@endsection

@section('css')
<style>
    .dataTables_wrapper .dt-buttons {
        float: none;
        text-align: center;

    }

    .top {
        padding: 10px;
    }

    th {
        text-align: center;
    }

    /* Aman Sir */
    .animatedBtn,
    {
    position: relative;
    animation-name: example;
    animation-duration: 200ms;
    }
    @keyframes example {
        0% {
            left: 10px;

        }

        100% {
            left: 0px;

        }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

@section('contents')

<div class="container-fluid">
    <!-- ROW -->
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Employees</span>
                                <h3 class="mb-0 mt-1 text-success">5,678</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-success-transparent my-auto  float-end"> <i class="las la-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Male Employees</span>
                                <h3 class="mb-0 mt-1 text-primary">3,876</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-primary-transparent my-auto  float-end"> <i class="las la-male"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Female
                                    Employees</span>
                                <h3 class="mb-0 mt-1 text-secondary">1,396</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i
                                    class="las la-female"></i> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">New Employees</span>
                                <h3 class="mb-0 mt-1 text-danger">398</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-danger-transparent my-auto  float-end"> <i
                                    class="las la-user-friends"></i> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    <!-- ROW -->
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">Employees List</h4>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-outline-primary border-0 my-auto"
                                    data-effect="effect-scale" data-bs-toggle="modal" href="#empType">Add New
                                    Employee</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Branch:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Branch">
                                    <option label="Select Branch"></option>
                                    <option value="1">Raipur</option>
                                    <option value="2">Gudgaon</option>
                                    <option value="3">Ludhiana</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Department:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Department">
                                    <option label="Select Department"></option>
                                    <option value="1">Faith Harris</option>
                                    <option value="2">Austin Bell</option>
                                    <option value="3">Maria Bower</option>
                                    <option value="4">Peter Hill</option>
                                    <option value="5">Victoria Lyman</option>
                                    <option value="6">Adam Quinn</option>
                                    <option value="7">Melanie Coleman</option>
                                    <option value="8">Max Wilson</option>
                                    <option value="9">Amelia Russell</option>
                                    <option value="10">Justin Metcalfe</option>
                                    <option value="11">Ryan Young</option>
                                    <option value="12">Jennifer Hardacre</option>
                                    <option value="13">Justin Parr</option>
                                    <option value="14">Julia Hodges</option>
                                    <option value="15">Michael Sutherland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Designation:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Designation">
                                    <option label="Select Designation"></option>
                                    <option value="1">Faith Harris</option>
                                    <option value="2">Austin Bell</option>
                                    <option value="3">Maria Bower</option>
                                    <option value="4">Peter Hill</option>
                                    <option value="5">Victoria Lyman</option>
                                    <option value="6">Adam Quinn</option>
                                    <option value="7">Melanie Coleman</option>
                                    <option value="8">Max Wilson</option>
                                    <option value="9">Amelia Russell</option>
                                    <option value="10">Justin Metcalfe</option>
                                    <option value="11">Ryan Young</option>
                                    <option value="12">Jennifer Hardacre</option>
                                    <option value="13">Justin Parr</option>
                                    <option value="14">Julia Hodges</option>
                                    <option value="15">Michael Sutherland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Employee:</label>
                                <input type="search" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2 m-auto">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-primary btn-sm">Copy</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">CSV</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">Excel</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">PDF</button>
                                <button type="button" class="btn btn-outline-primary btn-sm">Print</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                    </div>
                </div>
                
                {{-- <div class="card-body ant-table" style="padding:0px">
                    <div class="table-responsive">
                        <table id="example" class="display nowrap" style="width:100%"
                            data-order="[[ 1, &quot;asc&quot; ]]"> --}}
                            <div class="card-body ant-table" style="padding:0px">
                                <div class="table-responsive" style="text-align: center;">
                                    <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 text-center">Employee Name</th>
                                    <th class="border-bottom-0 text-center">Employee ID</th>
                                    <th class="border-bottom-0 text-center">Department</th>
                                    <th class="border-bottom-0 text-center">Designation</th>
                                    <th class="border-bottom-0 text-center">Joining Date</th>
                                    <th class="border-bottom-0 text-center">Phone Number</th>
                                    <th class="border-bottom-0 text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody style="padding: 0px;">
                                <tr>
                                    <td style="text-align: center">
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3"
                                                style="background-image: url()"></span>
                                            <div class="my-auto">
                                                <h6 class="mb-1 fs-14 my-auto"><a href="{{ url('admin/employee/profile') }}">Aman
                                                        Sahu</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>FD2987</td>
                                    <td>Designing Department</td>
                                    <td>Web Designer</td>
                                    <td>05-05-2017</td>
                                    <td>+9685321475</td>
                                    <td>
                                        <div class="d-flex">
                                            <div id="actionBtn1" class="d-none">
                                                <a href="javascript:void(0);" class="action-btns1 "
                                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                    <i class="feather feather-edit secondary text-secondary"
                                                        data-bs-toggle="tooltip" data-original-title="View"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-btns1"
                                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                    <i class="feather feather-trash danger text-danger"
                                                        data-bs-toggle="tooltip" data-original-title="View"></i>
                                                </a>
                                            </div>

                                            <div class="ms-auto"><i id="moreBtn" class="btn si si-options-vertical ms-auto"></i>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END ROW -->
</div>


{{-- add regular employee --}}
<div class="modal fade" id="addempmodal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body" style="5rem">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <h3 class="card-title">Add Regular Employee</h3>
                        <div class="tab-menu-heading hremp-tabs p-0 ">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class="ms-4"><a href="#tab5" class="active" data-bs-toggle="tab">Personal
                                            Details</a></li>
                                    <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body hremp-tabs1 p-0" style="height: 30rem; overflow:scroll">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab5">
                                    <div class="card-body">
                                        <h4 class="mb-4 font-weight-bold">Basic</h4>
                                        <div class="form-group d-flex justify-content-center">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="file" class="dropify" data-height="180" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Employee Type</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select Type">
                                                        <option label="Select Type"></option>
                                                        <option value="0">Full-Time</option>
                                                        <option value="1">Part-Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Employee Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control mb-md-0 mb-5"
                                                                placeholder="First Name">
                                                            <span class="text-muted"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Contact Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Alternative Contact
                                                        Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                        placeholder="Contact Number01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fc-datepicker"
                                                        placeholder="DD-MM-YYY">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Gender</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="custom-controls-stacked d-md-flex">
                                                        <label class="custom-control custom-radio me-4">
                                                            <input type="radio" class="custom-control-input"
                                                                name="example-radios4" value="option1">
                                                            <span class="custom-control-label">Male</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="example-radios4" value="option2">
                                                            <span class="custom-control-label">Female</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="example-radios4" value="option2">
                                                            <span class="custom-control-label">Other</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Address</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea rows="3" class="form-control"
                                                        placeholder="Address2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-7">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label">Manual Attendance with Location, Face Id
                                                        And QR Code:</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox"
                                                            class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Active/Inactive</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Employee ID</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="#ID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Branch</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">IT</option>
                                                        <option value="2">Management</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Department</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">Software Developer</option>
                                                        <option value="2">Web Developer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Designation</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">Software Developer</option>
                                                        <option value="2">Web Developer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fc-datepicker"
                                                        placeholder="DD-MM-YYYY">
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-5 mt-7 font-weight-bold">Shift</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Select Shift</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select Type">
                                                        <option label="Select Type"></option>
                                                        <option value="0">Assigned</option>
                                                        <option value="1">Not Assigned</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="example-checkbox1" value="option1" checked>
                                                        <span class="custom-control-label"><b>Send SMS
                                                                Employee</b></span>
                                                        <span class="fs-11">By continuing you agree to <b><a href="#"
                                                                    class="text-primary">Tearm &
                                                                    Conditions</a></b></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-dismiss="modal">Save</a>
                            <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- add employee --}}

{{-- delete confirmation --}}
<div class="modal fade" id="deletemodal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <h3>Are you sure want to delete ?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-danger"
                    data-bs-toggle="modal" data-bs-target="#">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- delete confirmation --}}

{{-- Employee Type --}}
<div class="modal fade" id="empType" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5>Add Employee</h5>
            </div>
            <div class="modal-body d-flex justify-content-around">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <div>
                            <h3><b style="color: rgb(22, 109, 83)">Add New Employee</b></h3>
                            <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic, HRA, PF,
                                ESI, etc.)</p>
                        </div>
                        <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                            data-bs-target="#addempmodal"><b>Add Employee</b></a>
                        <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal" data-bs-target="#"><b><i
                                    class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Employee Type --}}

{{-- online pay --}}
<div class="modal fade" id="bulkOnlinePay">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body" style="5rem">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <h3 class="card-title">Add New Employee</h3>
                        <div class="tab-menu-heading hremp-tabs p-0 ">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class="ms-4"><a href="#tab5" class="active" data-bs-toggle="tab">Personal
                                            Details</a></li>
                                    <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                    <li><a href="#tab7" data-bs-toggle="tab">Bank Details</a></li>
                                    <li><a href="#tab8" data-bs-toggle="tab">Upload Documents</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body hremp-tabs1 p-0" style="height: 30rem; overflow:scroll">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab5">
                                    <div class="card-body">
                                        <h4 class="mb-4 font-weight-bold">Basic</h4>
                                        <div class="form-group d-flex justify-content-center">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="file" class="dropify" data-height="180" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Employee Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control mb-md-0 mb-5"
                                                                name="emp_name" placeholder="First Name">
                                                            <span class="text-muted"></span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                placeholder="Last Name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Contact Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="emp_number"
                                                        placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Alternative Contact
                                                        Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="emp_anumber"
                                                        placeholder="Contact Number01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="emp_email"
                                                        placeholder="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fc-datepicker" name="dob"
                                                        placeholder="DD-MM-YYY">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Gender</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="custom-controls-stacked d-md-flex">
                                                        <label class="custom-control custom-radio me-4">
                                                            <input type="radio" class="custom-control-input"
                                                                name="example-radios4" value="option1">
                                                            <span class="custom-control-label">Male</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                name="example-radios4" value="option2">
                                                            <span class="custom-control-label">Female</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Address</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea rows="3" class="form-control" name="emp_address"
                                                        placeholder="Address2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-7">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label">Manual Attendance with Location, Face Id
                                                        And QR Code:</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox"
                                                            class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Active/Inactive</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Employee ID</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="#ID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Branch</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">IT</option>
                                                        <option value="2">Management</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Department</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">Software Developer</option>
                                                        <option value="2">Web Developer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Designation</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select">
                                                        <option label="Select"></option>
                                                        <option value="1">Software Developer</option>
                                                        <option value="2">Web Developer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fc-datepicker"
                                                        placeholder="DD-MM-YYYY">
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-5 mt-7 font-weight-bold">Salary</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Type</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select Type">
                                                        <option label="Select Type"></option>
                                                        <option value="0">Full-Time</option>
                                                        <option value="1">Part-Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Salary</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="$Salary">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Salary Cycle:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="date" class="form-control" placeholder="$Salary">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Opening Balance:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select Type">
                                                        <option label="Select Type"></option>
                                                        <option value="0">Advance</option>
                                                        <option value="1">Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Select Shift</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select name="projects" class="form-control custom-select select2"
                                                        data-placeholder="Select Type">
                                                        <option label="Select Type"></option>
                                                        <option value="0">Assigned</option>
                                                        <option value="1">Not Assigned</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-7">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Allow Current Salary Cycle
                                                        Access:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox"
                                                            class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Active/Inactive</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-7">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Salary Detail Access:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox"
                                                            class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Active/Inactive</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab7">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Account Holder</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Account Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Bank Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Branch Location</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Location">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Bank Code (IFSC)
                                                        <span class="form-help" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Bank Identify Number in your Country">?</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="Code">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Tax Payer ID (PAN)
                                                        <span class="form-help" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Taxpayer Identification Number Used in your Country">?</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" placeholder="ID No">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab8">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">Resume</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">ID Proof</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">Offer Letter</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">Joining Letter</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">Agreement Letter</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-label mb-0 mt-2">Experience Letter</div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label"></label>
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-dismiss="modal">Save</a>
                            <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- online pay --}}

<script>
</script>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script>
    new DataTable('#example10', {
        dom: '<"top"lfB>rtip'
        , buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
    , });

</script>
{{-- AmanSir --}}
<script>
    $(document).ready(function() {
        $('#moreBtn').on('click', function() {
            $('#actionBtn1').toggleClass('d-none');
            $('#actionBtn1').toggleClass('animatedBtn');

        });
    });
</script>
{{-- <script>
    new DataTable('#example', {
            scrollX: true,
            responsive: true,
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        let column = this;

                        // Create select element
                        let select = document.createElement('select');
                        select.add(new Option(''));
                        column.footer().replaceChildren(select);

                        // Apply listener for user change in value
                        select.addEventListener('change', function() {
                            var val = DataTable.util.escapeRegex(select.value);

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                        // Add list of options
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.add(new Option(d));
                            });
                    });
            }
        });
</script> --}}
@endsection