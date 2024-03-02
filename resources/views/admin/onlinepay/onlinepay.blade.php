@extends('admin.layout.master')
@section('title')
    Online Pay
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Net Pay</span>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Payment</span>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Pending Payment</span>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Deduction</span>
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
                        <div class="page-rightheader ms-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="btn-list d-flex">
                                    <a class="modal-effect btn btn-outline-dark btn-block mb-3"
                                        data-effect="effect-scale" data-bs-toggle="modal" href="#BulkpayAdd">Add Bulk Payment</a>
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
                                        <th class="border-bottom-0">Pending</th>
                                        <th class="border-bottom-0">Actual Payment</th>
                                        <th class="border-bottom-0">Total Payment</th>
                                        <th class="border-bottom-0">Total Deduction</th>
                                        <th class="border-bottom-0">Payment Details</th>
                                        <th class="border-bottom-0">Add Payment</th>
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
                                        <td>Rs.5000</td>
                                        <td>Rs.12000</td>
                                        <td>Rs.17000</td>
                                        <td>Rs.1000</td>
                                        <td>
                                            <span><b>A/c:</b></span>
                                            <span>XXXX XXXX XX12</span>
                                            <i class=" btn feather feather-edit primary text-primary"
                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                            <p class="text-muted mb-0 fs-12">UBI0005466</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-outline-success btn-sm"
                                                data-effect="effect-scale" data-bs-toggle="modal"
                                                data-bs-target="#modaldemo8">Add Payment</a>
                                        </td>
                                    </tr>
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
                                        <td>Rs.0</td>
                                        <td>Rs.0</td>
                                        <td>Rs.0</td>
                                        <td>Rs.0</td>
                                        <td>
                                            <span><b>UPI:</b></span>
                                            <span>amansahu@ybl</span>
                                            <i class=" btn feather feather-edit primary text-primary"
                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                            <p class="text-muted mb-0 fs-12">UBI0005466</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-outline-success btn-sm"
                                                data-effect="effect-scale" data-bs-toggle="modal" data-bs-target="">Print
                                                Reciept</a>
                                        </td>
                                    </tr>
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
                                        <td>Rs.5000</td>
                                        <td>Rs.12000</td>
                                        <td>Rs.17000</td>
                                        <td>Rs.1000</td>
                                        <td>
                                            <a class="modal-effect btn btn-primary btn-sm mb-3" data-effect="effect-scale"
                                                data-bs-toggle="modal" href="#payAdd">Add Payment Detail</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-outline-muted btn-sm">Add Payment</a>
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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

    {{-- Bank Ac Payment --}}
    <div class="modal fade" id="bankAcPay" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12 mb-0">
                            <div class="form-group">
                                <label class="form-label">A/c Holder Name</label>
                                <input type="text" class="form-control" id="number" placeholder="Placeholder">
                            </div>
                        </div>
                        <div class="form-group col-12 mb-0">
                            <div class="form-group">
                                <label class="form-label">Bank A/c Number</label>
                                <input type="password" class="form-control" id="number" placeholder="A/c Number">
                            </div>
                        </div>
                        <div class="form-group col-12 mb-0">
                            <div class="form-group">
                                <label class="form-label">Bank A/c Number</label>
                                <input type="text" class="form-control" id="number" placeholder="A/c Number">
                            </div>
                        </div>
                        <div class="form-group col-12 mb-0">
                            <div class="form-group">
                                <label class="form-label">IFSC Code</label>
                                <div id="container" class="card">
                                    <input class="form-control input_field" placeholder="IFSC" id="ifsccode">
                                    <a id="btn" class="waves-effect waves-light btn light-green darken-2">Get
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#saved">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Bank Ac Payment --}}

    {{-- Upi Payment --}}
    <div class="modal fade" id="upiPay" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group m-5">
                            <div class="form-group col-12">
                                <label class="form-label">Enter UPI ID</label>
                               <div class="d-flex">
                                <input type="text" class="form-control " id="upiId" placeholder="UPI ID">
                                <a href="#" class="btn btn-success">Validate</a>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#saved">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Upi Payment --}}

    {{-- payment addreses --}}
    <div class="modal fade" id="payAdd" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>Type Of Payment Detail</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#bankAcPay">Bank A/c
                        Number</button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upiPay">UPI
                        ID</button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#saved">Offline
                        Payment</button>
                </div>
            </div>
        </div>
    </div>
    {{-- payment address --}}

    {{-- Bulk payment addreses --}}
    <div class="modal fade" id="BulkpayAdd" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>Type Of Payment Detail</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#BulkAcpayAdd">Bank A/c
                        Number</button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#BulkUPIpayAdd">UPI
                        ID</button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#saved"><i class="fa fa-file-excel-o me-1"></i>Upload Bulk by Sheet</button>
                </div>
            </div>
        </div>
    </div>
    {{--Bulk payment address --}}


    {{-- Bulk bank Ac addreses --}}
    <div class="modal fade" id="BulkAcpayAdd" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>Bank Account Detail</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <div class="table-responsive" style="height:30rem; overflow:scroll">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">Emp ID</th>
                                    <th class="border-bottom-0">Emp Name</th>
                                    <th class="border-bottom-0">Department</th>
                                    <th class="border-bottom-0">Payment Details</th>
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
                                    <td>
                                        <input type="text" placeholder="A/c Number ">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <a href="javascript:void(0);" class="btn btn-primary"
                        data-bs-dismiss="modal">Save</a>
                    <a href="javascript:void(0);" class="btn btn-danger"
                        data-bs-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    {{--Bulk Bank acaddress --}}

    {{-- Bulk Upi addreses --}}
    <div class="modal fade" id="BulkUPIpayAdd" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>UPI Address Detail</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <div class="table-responsive" style="height:30rem; overflow:scroll">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">Emp ID</th>
                                    <th class="border-bottom-0">Emp Name</th>
                                    <th class="border-bottom-0">Department</th>
                                    <th class="border-bottom-0">Payment Details</th>
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
                                    <td>
                                        <input type="text" placeholder="A/c Number ">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <a href="javascript:void(0);" class="btn btn-primary"
                        data-bs-dismiss="modal">Save</a>
                    <a href="javascript:void(0);" class="btn btn-danger"
                        data-bs-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    {{--Bulk UPi acaddress --}}

    {{-- save confirmation --}}
    <div class="modal fade" id="saved" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body text-center p-5">
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="text-success m-5">Payment Address Added Successfully</h4>
                    <p class="mb-4 mx-4">There are many variations of passages of Lorem Ipsum available, but the majority
                        have suffered alteration.</p>
                    <button class="btn btn-danger pd-x-25" data-bs-dismiss="modal">No Thanks</button>
                    <button class="btn btn-success pd-x-25" data-bs-toggle="modal" data-bs-target="#modaldemo8">Continue
                        to Add Payment</button>
                </div>
            </div>
        </div>
    </div>
    {{-- save confirmation --}}

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
                    <img src="{{ asset('imgs/check.gif') }}" alt="">
                    <h4 class="text-success mb-4">Payment Successful!</h4>
                    <p class="mb-4 mx-4">There are many variations of passages of Lorem Ipsum available, but the majority
                        have suffered alteration.</p><button class="btn btn-success pd-x-25" data-bs-dismiss="modal">Print
                        Reciept</button>
                </div>
            </div>
        </div>
    </div>
    {{-- success confirmation --}}

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
