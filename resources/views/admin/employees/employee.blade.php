@extends('admin.layout.master')
@section('title')
    Employee
@endsection

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
                    <div class="card-header  border-0">
                        <h4 class="card-title">Employees List</h4>
                        <div class="page-rightheader ms-md-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="btn-list d-flex">
                                    <a class="modal-effect btn btn-primary btn-block mb-3" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#addempmodal">Add New Employee</a>
                                    <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Make Payment"><i class="feather feather-credit-card me-2"></i>Make Bulk
                                        Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Department:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Select Employee">
                                        <option label="Select Employee"></option>
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
                                        data-placeholder="Select Employee">
                                        <option label="Select Employee"></option>
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
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Select Priority">
                                        <option label="Select Priority"></option>
                                        <option value="1">High</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0 w-5">Emp ID</th>
                                        <th class="border-bottom-0">Emp Name</th>
                                        <th class="border-bottom-0">Department</th>
                                        <th class="border-bottom-0">Designation</th>
                                        <th class="border-bottom-0">Phone Number</th>
                                        <th class="border-bottom-0">Join Date</th>
                                        <th class="border-bottom-0">Add Payment</th>
                                        <th class="border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>FD2987</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3"
                                                    style="background-image: url(assets/images/users/1.jpg)"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">Faith Harris</h6>
                                                    <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Designing Department</td>
                                        <td>Web Designer</td>
                                        <td>+9685321475</td>
                                        <td>05-05-2017</td>
                                        <td>
                                            <a class="modal-effect btn btn-success btn-block mb-3"
                                                data-effect="effect-super-scaled" data-bs-toggle="modal"
                                                href="#modaldemo8">Make Payment</a>
                                        <td>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                <i class="feather feather-edit primary text-primary" data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                <i class="feather feather-trash primary text-primary" data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
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

    {{-- payment confirmation --}}
    <div class="modal fade" id="modaldemo8" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('imgs/museum.png') }}" class="rounded m-3" alt="" height="60">
                        <h4>Bank Detail</h4>
                    </div>
                    <table class="table table-striped text-center">
                        <tbody>
                            <tr class="table-primary">
                                <td><b>Bank Name</b></td>
                                <td class="text-start">Indus Bank</td>
                            </tr>
                            <tr class="table-active">
                                <td><b>A/C Name</b></td>
                                <td class="text-start">Rajiv Sing Mehta</td>
                            </tr>
                            <tr class="table-primary">
                                <td><b>A/C Name</b></td>
                                <td class="text-start">117120610455</td>
                            </tr>
                            <tr class="table-primary">
                                <td><b>A/C Type</b></td>
                                <td class="text-start">Salary Account</td>
                            </tr>
                            <tr class="table-active">
                                <td><b>Branch</b></td>
                                <td class="text-start">Devendra Nagar, Raipur</td>
                            </tr>
                            <tr class="table-primary">
                                <td><b>IFSC Code</b></td>
                                <td class="text-start">INDB0005466</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button> <button class="btn btn-light"
                        data-bs-toggle="modal" data-bs-target="#success">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    {{-- payment confirmation --}}

    {{-- success confirmation --}}
    <div class="modal fade" id="success" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body text-center p-4">
                    {{-- <div id="pay-loader">
                        <img src={{ asset('imgs/loader.gif')}} alt="loader">
                    </div> --}}
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                    <img src="{{asset('imgs/check.gif')}}" alt="">
                    <h4 class="text-success mb-4">Payment Successful!</h4>
                    <p class="mb-4 mx-4">There are many variations of passages of Lorem Ipsum available, but the majority
                        have suffered alteration.</p><button class="btn btn-success pd-x-25" data-bs-dismiss="modal">Print
                        Reciept</button>
                </div>
            </div>
        </div>
    </div>
    {{-- success confirmation --}}

    {{-- add employee --}}
    <div class="modal fade" id="addempmodal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-lg-12">
                            <h3 class="card-title">Add New Employee</h3>
                            <div class="tab-menu-heading hremp-tabs p-0 ">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class="ms-4"><a href="#tab5" class="active"
                                                data-bs-toggle="tab">Personal Details</a></li>
                                        <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                        <li><a href="#tab7" data-bs-toggle="tab">Bank Details</a></li>
                                        <li><a href="#tab8" data-bs-toggle="tab">Upload Documents</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab5">
                                        <div class="card-body">
                                            <h4 class="mb-4 font-weight-bold">Basic</h4>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">User Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control mb-md-0 mb-5"
                                                                    placeholder="First Name">
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
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Father Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Contact Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Phone Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Emergency Contact Number
                                                            01</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Contact Number01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Emergency Contact Number
                                                            02</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Contact Number02">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Marital Status</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select">
                                                            <option label="Select"></option>
                                                            <option value="1">Single</option>
                                                            <option value="2">Married</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Blood Group</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select Group">
                                                            <option label="Select Group"></option>
                                                            <option value="1">A+</option>
                                                            <option value="2">B+</option>
                                                            <option value="3">O+</option>
                                                            <option value="4">AB+</option>
                                                            <option value="5">A-</option>
                                                            <option value="6">B-</option>
                                                            <option value="7">O-</option>
                                                            <option value="8">AB-</option>
                                                        </select>
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
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Present Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea rows="3" class="form-control" placeholder="Address1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Permanent Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea rows="3" class="form-control" placeholder="Address2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-label mb-0 mt-2">Upload Photo</div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="form-label"></label>
                                                            <input class="form-control" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="mb-5 mt-7 font-weight-bold">Account Login</h4>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Employee Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="employee email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Password</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="password" class="form-control"
                                                            placeholder="password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-7">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Email Notification:</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="custom-switch-checkbox"
                                                                class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">On/Off</span>
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
                                                        <label class="form-label mb-0 mt-2">Department</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Department">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Designation</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Designation">
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
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Resignation Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control fc-datepicker"
                                                            placeholder="DD-MM-YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Termination Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control fc-datepicker"
                                                            placeholder="DD-MM-YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Credit Leaves
                                                            <span class="form-help" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Unused leaves for the Employee">?</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="0">
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
                                            <div class="form-group mt-7">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Status:</label>
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
                                                        <input type="text" class="form-control"
                                                            placeholder="Location">
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
                                    <div class="card-footer text-end">
                                        <a href="javascript:void(0);" class="btn btn-primary"
                                            data-bs-dismiss="modal">Save</a>
                                        <a href="javascript:void(0);" class="btn btn-danger"
                                            data-bs-dismiss="modal">Cancel</a>
                                    </div>
                                </div>
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
@endsection
