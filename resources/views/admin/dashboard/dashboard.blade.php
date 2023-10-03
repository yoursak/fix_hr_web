@extends('admin.pagelayout.master')
@section('title', 'Dashboard')
@section('css')
<style>
    .pignose-calendar .pignose-calendar-unit a{
        width: 1.5rem;
        height: 1.5rem;
        line-height: 1.5rem;
    }
    .pignose-calendar .pignose-calendar-unit{
        height: 2.3rem;
    }

    .pignose-calendar .pignose-calendar-top{
        padding: 0.8rem 0 0.8rem 0;
    }

    .pignose-calendar .pignose-calendar-top .pignose-calendar-top-date{
        top: -6px;
    }
    .pignose-calendar .pignose-calendar-top .pignose-calendar-top-month{
        font-size: 100%;
    }
    .pignose-calendar .pignose-calendar-top .pignose-calendar-top-year{
        font-size: 100%;
    }
    .pignose-calendar .pignose-calendar-header .pignose-calendar-week{
        height: 2em;
        line-height: 2em;
    }
    
</style>
@endsection
@section('content')
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
                                </div><input class="form-control fc-datepicker" placeholder="19 Feb 2020" type="text">
                            </div>
                        </div>
                        <div class="header-datepicker me-3 d-none d-md-block">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text d-none d-xl-block">
                                        <i class="feather feather-clock"></i>
                                    </div>
                                </div><!-- input-group-prepend -->
                                <input id="tpBasic" type="text" placeholder="09:30am" class="form-control input-small">
                            </div>
                        </div><!-- wd-150 -->
                    </div>

                    <div class="d-lg-flex d-block">
                        @if (in_array('Dashboard.Update', $permissions))
                            <div class="btn-list">
                                <a href="{{ asset('admin/attendance') }}" type="button" class="btn btn-primary">Attendance
                                    Report</a>
                            </div>
                        @endif
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
            <div class="col-xl-3 col-md-12 col-lg-123">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <div class="card-title">
                            Notice Board
                        </div>
                    </div>
                    <div class="mb-4">
                        <ul class="vertical-scroll">
                            <li class="item">
                                <div class="card p-4 ">
                                    <div class="d-flex">
                                        <img src="assets/images/users/16.jpg" alt="img"
                                            class="avatar avatar-md bradius me-3">
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1">Vanessa James</h6>
                                            <span class="clearfix"></span>
                                            <small>Birthday on Feb 16</small>
                                        </div>
                                        <span class="avatar bg-primary ms-auto bradius mt-1"> <i
                                                class="feather feather-mail text-white"></i> </span>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="card p-4 ">
                                    <div class="d-flex comming_events calendar-icon icons">
                                        <span class="date_time bg-success-transparent bradius me-3"><span
                                                class="date fs-18">21</span>
                                            <span class="month fs-10">Feb</span>
                                        </span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1">Anniversary</h6>
                                            <span class="clearfix"></span>
                                            <small>3rd Anniversary on 21st Feb</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="card p-4 ">
                                    <div class="d-flex">
                                        <img src="assets/images/users/4.jpg" alt="img"
                                            class="avatar avatar-md bradius me-3">
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1">Faith Harris</h6>
                                            <span class="clearfix"></span>
                                            <small>Smart Device Trade Show</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="card p-4 ">
                                    <div class="d-flex comming_events calendar-icon icons">
                                        <span class="date_time bg-pink-transparent bradius me-3"><span
                                                class="date fs-18">25</span>
                                            <span class="month fs-10">Mar</span>
                                        </span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1">Meeting</h6>
                                            <span class="clearfix"></span>
                                            <small>It will be held in meeting room</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-12 col-lg-12">
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
            <div class="col-xl-3 col-md-12 col-lg-12">
                <div class="card">
                    <div class="p-0">
                        <div class="calendar p-1 pt-0"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-12 col-lg-12">
                <div class="mb-4">
                    <div class="card-header border-bottom-0 pt-2 ps-0">
                        <h4 class="card-title">Upcomming Holidays</h4>
                    </div>
                    <ul class="vertical-scroll">
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex">
                                    <img src="assets/images/users/16.jpg" alt="img"
                                        class="avatar avatar-md bradius me-3">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Vanessa James</h6>
                                        <span class="clearfix"></span>
                                        <small>Birthday on Feb 16</small>
                                    </div>
                                    <span class="avatar bg-primary ms-auto bradius mt-1"> <i
                                            class="feather feather-mail text-white"></i> </span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex comming_events calendar-icon icons">
                                    <span class="date_time bg-success-transparent bradius me-3"><span
                                            class="date fs-18">21</span>
                                        <span class="month fs-10">Feb</span>
                                    </span>
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Anniversary</h6>
                                        <span class="clearfix"></span>
                                        <small>3rd Anniversary on 21st Feb</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex">
                                    <img src="assets/images/users/4.jpg" alt="img"
                                        class="avatar avatar-md bradius me-3">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Faith Harris</h6>
                                        <span class="clearfix"></span>
                                        <small>Smart Device Trade Show</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex comming_events calendar-icon icons">
                                    <span class="date_time bg-pink-transparent bradius me-3"><span
                                            class="date fs-18">25</span>
                                        <span class="month fs-10">Mar</span>
                                    </span>
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Meeting</h6>
                                        <span class="clearfix"></span>
                                        <small>It will be held in meeting room</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-md-12 col-lg-12">
                <div class="mb-4">
                    <div class="card-header border-bottom-0 pt-2 ps-0">
                        <h4 class="card-title">Upcomming Birthdays</h4>
                    </div>
                    <ul class="vertical-scroll">
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex">
                                    <img src="assets/images/users/16.jpg" alt="img" class="avatar avatar-md bradius me-3">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Vanessa James</h6>
                                        <span class="clearfix"></span>
                                        <small>Birthday on Feb 16</small>
                                    </div>
                                    <span class="avatar bg-primary ms-auto bradius mt-1"> <i class="feather feather-mail text-white"></i> </span>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex comming_events calendar-icon icons">
                                    <span class="date_time bg-success-transparent bradius me-3"><span class="date fs-18">21</span>
                                        <span class="month fs-10">Feb</span>
                                    </span>
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Anniversary</h6>
                                        <span class="clearfix"></span>
                                        <small>3rd Anniversary on 21st Feb</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex">
                                    <img src="assets/images/users/4.jpg" alt="img" class="avatar avatar-md bradius me-3">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Faith Harris</h6>
                                        <span class="clearfix"></span>
                                        <small>Smart Device Trade Show</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <div class="card p-4 ">
                                <div class="d-flex comming_events calendar-icon icons">
                                    <span class="date_time bg-pink-transparent bradius me-3"><span class="date fs-18">25</span>
                                        <span class="month fs-10">Mar</span>
                                    </span>
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1">Meeting</h6>
                                        <span class="clearfix"></span>
                                        <small>It will be held in meeting room</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
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
                                    <button class="btn btn-outline-primary mx-3 border-0" href="#">Expand
                                        All</button>
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

@section('js')
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}"></script>
    <script src="{{ asset('assets/plugins/vertical-scroll/vertical-scroll.js') }}"></script>

    <!-- INTERNAL PG-CALENDAR-MASTER JS -->
    <script src="{{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/index2.js') }}"></script>

@endsection
