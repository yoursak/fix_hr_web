@extends('admin.layout.master')
@section('title')
Attendance
@endsection

@section('contents')
<!-- ROW -->
<div class="row">
    
    <div class="col-xl-9 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Days Overview</h4>
            </div>
            <div class="card-body pt-0 pb-3">
                <div class="row mb-0 pb-0">
                    <div class="col-6 col-md-4 col-xl-2 text-center py-5">
                        <span class="avatar avatar-md bradius fs-20 bg-primary-transparent">31</span>
                        <h5 class="mb-0 mt-3">Total Employee</h5>
                    </div>
                    <div class=" col-6 col-md-4 col-xl-2 text-center py-5 ">
                        <span class="avatar avatar-md bradius fs-20 bg-success-transparent">24</span>
                        <h5 class="mb-0 mt-3">Present</h5>
                    </div>
                    <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                        <span class="avatar avatar-md bradius fs-20 bg-danger-transparent">2</span>
                        <h5 class="mb-0 mt-3">Absent</h5>
                    </div>
                    <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                        <span class="avatar avatar-md bradius fs-20 bg-warning-transparent">0</span>
                        <h5 class="mb-0 mt-3">Half Days</h5>
                    </div>
                    <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5 ">
                        <span class="avatar avatar-md bradius fs-20 bg-orange-transparent">2</span>
                        <h5 class="mb-0 mt-3">Late</h5>
                    </div>
                    <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                        <span class="avatar avatar-md bradius fs-20 bg-pink-transparent">5</span>
                        <h5 class="mb-0 mt-3">Leave</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body ">
                <div class="countdowntimer mt-3">
                    <span id="clocktimer2" class="border-0"></span>
                    <label class="form-label">Panding Approvals for abc days</label>
                </div>
                <div class="btn-list text-center mt-5 mb-5">
                    <a  type="submit" class="btn ripple btn-primary">Approve All</a>
                    {{-- <a href="javascript:void(0);" class="btn ripple btn-primary disabled">Punch Out</a> --}}
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
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control custom-select select2" data-placeholder="Select Department">
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
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Designation:</label>
                                    <select name="attendance"  class="form-control custom-select select2" data-placeholder="Select Designation">
                                        <option label="Select Month"></option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Employee Name:</label>
                                    <select name="attendance"  class="form-control custom-select select2" data-placeholder="Select Employee">
                                        <option label="Select Year"></option>
                                        <option value="1">2024</option>
                                        <option value="2">2023</option>
                                        <option value="3">2022</option>
                                        <option value="4">2021</option>
                                        <option value="5">2020</option>
                                        <option value="6">2019</option>
                                        <option value="7">2018</option>
                                        <option value="8">2017</option>
                                        <option value="9">2016</option>
                                        <option value="10">2015</option>
                                        <option value="11">2014</option>
                                        <option value="12">2013</option>
                                        <option value="13">2012</option>
                                        <option value="14">2011</option>
                                        <option value="15">2019</option>
                                        <option value="16">2010</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-2">
                        <div class="form-group mt-5">
                            <a  href="javascript:void(0);" class="btn btn-primary btn-block">Search</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hr-checkall">
                            <label class="custom-control custom-checkbox mb-0">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <span class="custom-control-label">Check All</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-5">#Emp ID</th>
                                <th class="border-bottom-0">Emp Name</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Punch In</th>
                                <th class="border-bottom-0">Punch Out</th>
                                <th class="border-bottom-0">Production Hour</th>
                                <th class="border-bottom-0">IP Address</th>
                                <th class="border-bottom-0">Working From</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#2987</td>
                                <td>
                                    <div class="d-flex">
                                        <span class="avatar avatar-md brround me-3"
                                            style="background-image: url(assets/images/users/1.jpg)"></span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1 fs-14">Faith Harris</h6>
                                            <p class="text-muted mb-0 fs-12">Web Designer</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-success-light">Present</span></td>
                                <td>09:30 AM</td>
                                <td>06:30 PM</td>
                                <td>04:08 Hr</td>
                                <td>225.192.45.1</td>
                                <td>Office</td>
                                <td>
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox-md">
                                            <input type="checkbox" class="custom-control-input-success"
                                                name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label-md success"></span>
                                        </label>
                                        <a href="{{url('/admin/attendance/details')}}" class="action-btns1 bg-light">
                                            <i class="feather feather-eye primary text-primary" data-bs-toggle="tooltip"
                                                data-original-title="View"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="javascript:void(0);" class="btn btn-primary float-end">Save All</a>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->

{{-- <!-- PRESENT MODAL -->
<div class="modal fade" id="presentmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-5 mt-4">
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold">09:30 AM</h6>
                            <small class="text-muted fs-14">Punch In</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-circle chart-circle-md" data-value="100" data-thickness="6"
                            data-color="#0dcd94">
                            <div class="chart-circle-value text-muted">09:00 hrs</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold"> 06:30 PM</h6>
                            <small class="text-muted fs-14">Punch Out</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" disabled
                        data-placeholder="Select">
                        <option label="Select"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a>
            </div>
        </div>
    </div>
</div>
<!-- END PRESENT MODAL  --> --}}

{{-- <!-- EDIT MODAL -->
<div class="modal fade" id="editmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch In</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="9:30 AM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input orange">
                            <span class="custom-switch-indicator "></span>
                            <span class="custom-switch-description text-dark">Late</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch Out</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="06: 30 PM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input  orange">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">half Day</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" disabled
                        data-placeholder="Select">
                        <option label="Select"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer d-flex">
                <div>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-toggle="modal"
                        data-bs-target="#presentmodal" data-bs-dismiss="modal"><i
                            class="feather feather-arrow-left me-1"></i>Back</a>
                </div>
                <div class="ms-auto">
                    <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                    <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT MODAL --> --}}

<!-- PRESENT MODAL1 -->
<div class="modal fade" id="presentmodal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-5 mt-4">
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold">09:30 AM</h6>
                            <small class="text-muted fs-14">Punch In</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-circle chart-circle-md" data-value="100" data-thickness="6"
                            data-color="#0dcd94">
                            <div class="chart-circle-value text-muted">09:00 hrs</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold"> 06:30 PM</h6>
                            <small class="text-muted fs-14">Punch Out</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1">
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" data-placeholder="Select">
                        <option label="Select"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#editmodal1" data-bs-dismiss="modal">Edit</a>
            </div>
        </div>
    </div>
</div>
<!-- End PRESENT MODAL1 -->

<!-- EDIT1 MODAL -->
<div class="modal fade" id="editmodal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch In</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="9:30 AM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input orange">
                            <span class="custom-switch-indicator "></span>
                            <span class="custom-switch-description text-dark">Late</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch Out</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="06: 30 PM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input  orange">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">half Day</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1">
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" data-placeholder="Select">
                        <option label="0"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer d-flex">
                <div>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-toggle="modal"
                        data-bs-target="#presentmodal1" data-bs-dismiss="modal"><i
                            class="feather feather-arrow-left me-1"></i>Back</a>
                </div>
                <div class="ms-auto">
                    <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                    <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT1 MODAL  -->

<!--HALFPRESENT MODAL -->
<div class="modal fade" id="halfpresentmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details <span class="badge badge-orange">Half Day</span></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-5 mt-4">
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold">09:30 AM</h6>
                            <small class="text-muted fs-14">Punch In</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-circle chart-circle-md" data-value=".50" data-thickness="6"
                            data-color="#0dcd94">
                            <div class="chart-circle-value text-muted">04:30 hrs</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pt-5 text-center">
                            <h6 class="mb-1 fs-16 font-weight-semibold"> 01:30 PM</h6>
                            <small class="text-muted fs-14">Punch Out</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" disabled
                        data-placeholder="Select">
                        <option label="Select"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#halfdayeditmodal" data-bs-dismiss="modal">Edit</a>
            </div>
        </div>
    </div>
</div>
<!-- END HALFPRESENT MODAL  -->

<!-- HALFDAY EDIT MODAL -->
<div class="modal fade" id="halfdayeditmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Details <span class="badge badge-orange">Half Day</span></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch In</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="9:30 AM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input  orange">
                            <span class="custom-switch-indicator "></span>
                            <span class="custom-switch-description text-dark">Late</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Punch Out</label>
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" value="01: 30 PM">
                                <div class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="custom-switch mt-md-6">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input  orange"
                                checked>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">half Day</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">IP Address</label>
                    <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Working Form</label>
                    <select name="projects" class="form-control custom-select select2" disabled
                        data-placeholder="Select">
                        <option label="Select"></option>
                        <option value="1" selected>Office</option>
                        <option value="2">Home</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer d-flex">
                <div>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-toggle="modal"
                        data-bs-target="#halfpresentmodal" data-bs-dismiss="modal"><i
                            class="feather feather-arrow-left me-1"></i>Back</a>
                </div>
                <div class="ms-auto">
                    <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                    <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END HALFDAY EDIT MODAL  -->
@endsection
