@extends('admin.layout.master')
@section('title')
    Dashboard
@endsection

@section('contents')
    <div class="container-fluid">
        @php
            // dd(Session::get('Fail'));
        @endphp
        <div class="page-header d-md-flex d-block">
            <div class="page-leftheader">
                <div class="page-title">Attendance</div>
            </div>
            <div class="page-rightheader ms-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="d-flex">
                        <div class="header-datepicker me-3">
                            <div class="input-group">
                                <div class="input-group-prepend ">
                                    <div class="input-group-text d-none d-xl-block">
                                        <i class="feather feather-calendar"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" placeholder="19 Feb 2020"
                                    type="text">
                            </div>
                        </div>
                        <div class="header-datepicker me-3 d-none d-md-block">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text d-none d-xl-block">
                                        <i class="feather feather-clock"></i>
                                    </div>
                                </div><!-- input-group-prepend -->
                                <input id="tpBasic" type="text" placeholder="09:30am"
                                    class="form-control input-small">
                            </div>
                        </div><!-- wd-150 -->
                    </div>
                    <div class="d-lg-flex d-block">
                        <div class="btn-list">
                            <a href="{{asset('admin/attendance')}}" type="button" class="btn btn-primary">Attendance
                                Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Total Employee</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Present</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Absent</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Half Day</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Leave</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Miss Punch</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Late In</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body"> <span>Overtime</span>
                                <h3 class=" mb-1 mt-1 font-weight-bold">6532</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-0">
                                <div class="card-title">
                                    Thinks To Do
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-transparent mb-0 mail-inbox">
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 bg-danger"></div>
                                            <div class="double-bounce2 bg-danger"></div>
                                        </div>
                                        <b>Manage Attendance</b>
                                        <span class="ms-auto badge bg-primary">12</span>
                                    </a>
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 bg-success"></div>
                                            <div class="double-bounce2 bg-success"></div>
                                        </div>
                                        </span> <b>Manage Miss Punch</b> <span class="ms-auto badge bg-success">12</span>
                                    </a>
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 bg-success"></div>
                                            <div class="double-bounce2 bg-success"></div>
                                        </div>
                                        </span> <b>Manage Leaves</b> <span class="ms-auto badge bg-secondary">2</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="card-title">
                        Employee Summary
                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                <div>
                                    <button class="btn btn-outline-primary mx-3 border-0" href="#">Expand All</button>
                                </div>

                                <div>
                                    <button class="btn btn-outline-primary mx-3 border-0" href="#">Download</button>
                                </div>
                                <div class="my-auto d-none d-md-block">
                                    <select name="month" class="form-control btn-outline-primary mx-3 border-0"
                                        data-placeholder="Select Cycle">
                                        <option label="Select Cycle"></option>
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
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom table-striped"
                            id="hr-attendance1">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center border-bottom-0">Action</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Emp ID</th>
                                    <th rowspan="2" class="border-bottom-0 ">Employee</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Present</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Absent</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Half Days</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Paid Leave</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Miss Punch</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Overtime</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Fine</th>
                                    <th rowspan="2" class="text-center border-bottom-0 ">Total Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                            data-bs-toggle="tooltip" data-original-title="View">
                                            <i class="feather feather-eye"></i>
                                        </div>
                                    </td>
                                    <td>FD22311</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar brround me-3"
                                                style="background-image: url(imgs/user.png)"></span>
                                            <div class="me-3 mt-0 mt-sm-2 d-block">
                                                <h6 class=" fs-14"><a href="{{ url('/emprofile') }}">Aman Sahu</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">5</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rescalendar" id="my_calendar_en"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <style>

    </style>
@endsection
