@extends('admin.pagelayout.master')
@section('title', 'Dashboard')
@section('css')
    <style>
        .pignose-calendar .pignose-calendar-unit a {
            width: 1.5rem;
            height: 1.5rem;
            line-height: 1.5rem;
        }

        .pignose-calendar .pignose-calendar-unit {
            height: 2.3rem;
        }

        .pignose-calendar .pignose-calendar-top {
            padding: 1rem 0 1rem 0;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-date {
            top: -6px;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-month {
            font-size: 100%;
            line-height: 2rem;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-year {
            font-size: 100%;
        }

        .pignose-calendar .pignose-calendar-header .pignose-calendar-week {
            height: 2em;
            line-height: 2em;
        }

        .fc-datepicker {
            height: 2.65rem;
            border: 1px solid #1877f2;
            border-radius: 6px;
            font-weight: 500;
            width: 10rem;
            padding-inline: 1rem;
            background: transparent;
        }
    </style>

@endsection
@if (in_array('Dashboard.All', $permissions) || in_array('"Dashboard.View', $permissions))
    @section('content')
        <div class=" p-0 pb-4">
            <div class="container-fluid" id="confetti">
                @php
                    $root = new App\Helpers\Central_unit();
                    $DailyCount = $root->getDashboardCount(Session::get('business_id'), date('Y-m-d'));
                    $ManageCount = $root->getThinksToDoCount(Session::get('business_id'), date('Y-m-d'));

                @endphp
                <div class="page-header d-flex">
                    <div class="page-leftheader">
                        <div class="page-title"><i class="feather feather-home sidemenu_icon"> <b
                                    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Dashboard</b></i>
                        </div>
                    </div>
                    <div class="page-rightheader ms-auto" wire:ignore>
                        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                            <div class="d-flex ms-auto">
                                <div class="header-datepicker me-3">
                                    <div class= "input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"
                                                style="background-color: #1877f2; border: solid 1px #1877f2;">
                                                <i class="feather feather-calendar" style="color: #fff"></i>
                                            </div>
                                        </div>

                                        <input class="form-control bg-light fc-datepicker"
                                            data-currentdate="{{ date('d M Y') }}" type="text" id="dashboardTimePicker"
                                            onchange="dashboardCountAjax(this)" style="border: solid 1px #1877f2;">
                                    </div>
                                </div>
                                <script>
                                    function dashboardTimeFormate() {
                                        var element = document.getElementById('dashboardTimePicker');
                                        element.value = element.getAttribute('data-currentdate');
                                        console.log(element.value);
                                    }
                                    window.onload = dashboardTimeFormate;
                                </script>
                                <div class="header-datepicker me-3 d-none d-md-block">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text d-xl-block"
                                                style="background-color: #1877f2; border: solid 1px #1877f2;">
                                                <i class="feather feather-clock mt-1" style="color: #fff"></i>
                                            </div>
                                        </div><!-- input-group-prepend -->
                                        <input id="tpBasic" type="text" placeholder="{{ date('h:i A') }}"
                                            class="form-control input-small fw-bolder bg-light"
                                            style="border: solid 1px #1877f2;" disabled>
                                    </div>
                                </div><!-- wd-150 -->
                            </div>

                            <div class="d-lg-flex d-block">
                                @if (in_array('Dashboard.Update', $permissions))
                                    <div class="btn-list">

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Total Employee</span>
                                        <h3 class=" mb-1 mt-1 text-primary  font-weight-bold" id="totalEmpCount">
                                            {{ $DailyCount['totalEmp'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body "> <span>Present</span>
                                        <h3 class=" mb-1 mt-1  font-weight-bold"><span class="present-status"
                                                id="totalPresentCount">
                                                {{ $DailyCount['present'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Absent</span>
                                        <h3 class=" mb-1 mt-1 font-weight-bold"><span class="absent-status"
                                                id="totalAbsentCount">
                                                {{ $DailyCount['absent'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Half Day</span>
                                        <h3 class=" mb-1 mt-1 font-weight-bold"><span class="halfday-status"
                                                id="totalHalfDayCount">
                                                {{ $DailyCount['halfday'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Leave</span>
                                        <h3 class=" mb-1 mt-1  font-weight-bold"><span class="leave-status"
                                                id="totalLeaveCount">
                                                {{ $DailyCount['leave'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Mis-Punch</span>
                                        <h3 class=" mb-1 mt-1  font-weight-bold"><span class="mispunch-status"
                                                id="totalMispunchCount">
                                                {{ $DailyCount['mispunch'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Late In</span>
                                        <h3 class=" mb-1 mt-1  font-weight-bold"><span class="late-status"
                                                id="totalLateCount">
                                                {{ $DailyCount['late'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3 col-lg-6">
                                <div class="card text-center">
                                    <div class="card-body"> <span>Overtime</span>
                                        <h3 class=" mb-1 mt-1 font-weight-bold"><span class="overtime-status"
                                                id="totalOvertimeCount">
                                                {{ $DailyCount['overtime'] }}

                                            </span></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function dashboardCountAjax(context) {
                            var date = context.value;
                            // const formattedDate = formatDate(date);
                            // context.value = formattedDate;

                            $.ajax({
                                url: "{{ url('/admin/attendance/dashboard_attendance_count') }}",
                                type: "POST",
                                data: {
                                    date: date,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    document.getElementById('totalEmpCount').innerHTML = result.totalEmp;
                                    document.getElementById('totalPresentCount').innerHTML = result.present;
                                    document.getElementById('totalAbsentCount').innerHTML = result.absent;
                                    document.getElementById('totalHalfDayCount').innerHTML = result.halfday;
                                    document.getElementById('totalLeaveCount').innerHTML = result.leave;
                                    document.getElementById('totalMispunchCount').innerHTML = result.mispunch;
                                    document.getElementById('totalLateCount').innerHTML = result.late;
                                    document.getElementById('totalOvertimeCount').innerHTML = result.overtime;
                                }
                            });
                        }

                        function formatDate(inputDate) {
                            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                                'October', 'November', 'December'
                            ];
                            const dateParts = inputDate.split(' ');
                            const day = dateParts[0];
                            const monthIndex = months.findIndex(month => month === dateParts[1]) + 1;
                            const year = dateParts[2];
                            return `${day} ${months[monthIndex - 1].slice(0, 3)} ${year}`;
                        }
                    </script>
                    <div class="col-xl-3 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-0">
                                <div class="card-title">
                                    Thinks To Do
                                </div>
                            </div>
                            <div class="card-body" style="padding-top:0 ">
                                <div class="list-group list-group-transparent mb-0 mail-inbox">
                                    <a href="{{ url('/admin/attendance') }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 bg-primary"></div>
                                            <div class="double-bounce2 bg-primary"></div>
                                        </div>
                                        <b>Manage Attendance</b>
                                        <span class="ms-auto badge bg-primary"> {{ $ManageCount[0] }}</span> <b
                                            class="mx-2">Days</b>
                                    </a>
                                    <a href="{{ url('/admin/requests/mispunch') }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 bg-secondary"></div>
                                            <div class="double-bounce2 bg-secondary"></div>
                                        </div><b>Manage Mis-Punch</b> <span class="ms-auto badge bg-secondary">
                                            {{ $ManageCount[1] }}</span><b class="mx-2">Days</b>
                                    </a>
                                    <a href="{{ url('/admin/requests/leaves') }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                        <div class="spinner1">
                                            <div class="double-bounce1 " style="background-color:brown"></div>
                                            <div class="double-bounce2 " style="background-color:brown"></div>
                                        </div> <b>Manage Leaves</b> <span class="ms-auto badge"
                                            style="background-color:brown"> {{ $ManageCount[2] }}</span><b
                                            class="mx-2">Days</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-12 col-lg-12">
                        <div class="card-header border-bottom-0 pt-2 pb-4 ps-0">
                            <h4 class="card-title">Calendar</h4>
                        </div>
                        <div class="card">
                            <div class="p-0">
                                <div class="calendar p-1 pt-0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-lg-12">
                        <div class="mb-4">
                            <div class="card-header border-bottom-0 pt-2 pb-4 ps-0">
                                <h4 class="card-title">Birthdays</h4>
                            </div>
                            <ul class="vertical-scroll">
                                <?php $empCount = 0; ?>
                                @foreach ($Emp as $emp)
                                    <?php
                            $birth_y = date('Y', strtotime($emp->emp_date_of_birth));
                            $birth_d = date('d', strtotime($emp->emp_date_of_birth));
                            $birth_m = date('m', strtotime($emp->emp_date_of_birth));

                            if($birth_m >= date('m') && $birth_d >= date('d') && ++$empCount <= 5){ ?>
                                    <li class="item">
                                        <div class="card px-4 py-4">
                                            <div class="d-flex comming_events calendar-icon icons">
                                                <span class="date_time bg-success-transparent bradius me-3"
                                                    style="border: solid 1px #1877f2;background-color:#fff"><span
                                                        class="date fs-18"
                                                        style="color:#1877f2">{{ date('d', strtotime($emp->emp_date_of_birth)) }}</span>
                                                    <span class="month fs-12"
                                                        style="color:#1877f2">{{ date('M', strtotime($emp->emp_date_of_birth)) }}</span>
                                                </span>
                                                <?php
                                                $current_y = date('Y');
                                                $year = $current_y - $birth_y;
                                                ?>

                                                @if (date('m', strtotime($emp->emp_date_of_birth)) == date('m') &&
                                                        date('d', strtotime($emp->emp_date_of_birth)) == date('d'))
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1">Today is {{ $emp->emp_name }}'s Birthday</h6>
                                                        <span class="clearfix"></span>
                                                        <small>{{ $year }}th Birthday Celebration</small>
                                                    </div>
                                                    <a href="#"><span class="btn btn-sm btn-outline-orange"><i
                                                                class="fa fa-birthday-cake text-orange"></i></span></a>
                                                @else
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1">{{ $emp->emp_name }}'s Birthday</h6>
                                                        <span class="clearfix"></span>

                                                        <small>{{ $year }}th Birthday on
                                                            {{ date('d', strtotime($emp->emp_date_of_birth)) }}th of
                                                            {{ date('M', strtotime($emp->emp_date_of_birth)) }}</small>
                                                        {{-- <small>{{$birth_m.'-'.$birth_d}}</small> --}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <?php }?>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-lg-12">
                        <div class="mb-4">
                            <div class="card-header border-bottom-0 pt-2 pb-4 ps-0">
                                <h4 class="card-title">Upcoming Holidays</h4>
                            </div>

                            <ul class="vertical-scroll">
                                <?php $holidayCount = 0; ?>
                                @foreach ($Holiday as $holiday)
                                    <?php
                            $holidayD = date('d', strtotime($holiday->holiday_date));
                            $holidayM = date('m', strtotime($holiday->holiday_date));
                            $holidayY = date('Y', strtotime($holiday->holiday_date));
                            $holidayDayName = date('l', strtotime($holiday->holiday_date));
                            if(date('Y-m-d') <= date('Y-m-d', strtotime($holiday->holiday_date)) && ++$holidayCount <= 5){ ?>
                                    <li class="item">
                                        <div class="card px-4 py-4">
                                            <div class="d-flex comming_events calendar-icon icons">
                                                <span class="date_time bg-pink-transparent bradius me-3"
                                                    style="border: solid 1px #1877f2;background-color:#fff"><span
                                                        class="date fs-18"
                                                        style="color:#1877f2">{{ $holidayD }}</span>
                                                    <span class="month fs-12"
                                                        style="color:#1877f2">{{ date('M', strtotime($holiday->holiday_date)) }}</span>
                                                </span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1">{{ $holiday->holiday_name }}</h6>
                                                    <span class="clearfix"></span>
                                                    <small>{{ $holiday->holiday_name }} on
                                                        <b>{{ $holidayDayName }}</b></small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-lg-12">
                        <div class="mb-4">
                            <div class="card-header border-bottom-0 pt-2 pb-4 ps-0">
                                <h4 class="card-title">Notice Board</h4>
                            </div>
                            <ul class="vertical-scroll">
                                <?php $noticeCount = 0; ?>
                                @foreach ($Notice as $notice)
                                    <?php
                                    // dd(date('Y-m-d',strtotime('2010')) > date('Y-m-d',strtotime('2011')));
                                    $noticeD = date('d', strtotime($notice->date));
                                    $noticeM = date('M', strtotime($notice->date));
                                    $noticeY = date('Y', strtotime($notice->date));
                                    $noticeDayName = date('l', strtotime($notice->date)); ?>
                                    <?php if (date('Y-m-d', strtotime($noticeY.'-'.$noticeM.'-'.$noticeD)) <= date('Y-m-d') && $noticeCount++ < 5) { ?>
                                    <li class="item">
                                        <div class="card px-4 py-4 ">
                                            <a href="{{ url('notice_uploads/' . $notice->file) }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <div class="d-flex comming_events calendar-icon icons">
                                                    <span class="date_time bg-pink-transparent bradius me-3"
                                                        style="border: solid 1px #1877f2;background-color:#fff"><span
                                                            class="date fs-18"
                                                            style="color:#1877f2">{{ $noticeD }}</span>
                                                        <span class="month fs-12"
                                                            style="color:#1877f2">{{ $noticeM }}</span>
                                                    </span>
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1">{{ $notice->title }}</h6>
                                                        <span class="clearfix"></span>
                                                        <small>{{ $notice->description }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li> <?php } ?>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row" id="employee_summary">
                    <div class="card p-0">
                        <div class="card-header border-bottom-0">
                            <div class="card-title">
                                Attendance Summary
                            </div>
                            <div class="page-rightheader ms-auto">
                                <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                    <div class="btn-list d-flex">
                                        <div>
                                            <a href="{{ url('/admin/attendance/month-summary') }}"
                                                class="btn btn-md btn-primary ms-auto">View More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  table-vcenter text-nowrap border-bottum ">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Employee</th>
                                            <th class="text-center border-bottom-0 ">Emp ID</th>
                                            <th class="text-center border-bottom-0 ">Present</th>
                                            <th class="text-center border-bottom-0 ">Absent</th>
                                            <th class="text-center border-bottom-0 ">Half Days</th>
                                            <th class="text-center border-bottom-0 ">Leave</th>
                                            <th class="text-center border-bottom-0 ">WeekOff</th>
                                            <th class="text-center border-bottom-0 ">Holiday</th>
                                            <th class="text-center border-bottom-0 ">Mis-Punch</th>
                                            <th class="text-center border-bottom-0 ">Overtime</th>
                                            <th class="text-center border-bottom-0 ">Late</th>
                                            <th class="text-center border-bottom-0 ">Early Exit</th>
                                            <th class="text-center border-bottom-0 ">Total Attendance</th>
                                            <th class="text-center border-bottom-0">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                            @foreach ($Emp as $key => $emp)
                                                @php
                                                    $root->MyCountForMonth($emp->emp_id, date('Y-m-d'), Session::get('business_id'), $emp->branch_id);
                                                    $monthlyCount = $root->getMonthlyCountFromDB($emp->emp_id, date('Y'), date('m'), Session::get('business_id'), $emp->branch_id);
                                                @endphp
                                                @if ($monthlyCount['present'] != 0)
                                                    <tr>
                                                        <td id="{{ $emp->emp_id }}['profile']">
                                                            <div class="d-flex">
                                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                                    style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                                    <h6 class="mb-1 fs-14">
                                                                        <a
                                                                            href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                                                            {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}
                                                                        </a>
                                                                    </h6>
                                                                    <p class="text-muted mb-0 fs-12">
                                                                        <?= $root->DesingationIdToName($emp->designation_id) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['empId']">
                                                            {{ $emp->emp_id }}</td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['present']">
                                                            {{ $monthlyCount['present'] }}
                                                        </td>

                                                        <td class="text-center" id="{{ $emp->emp_id }}['absent']">
                                                            {{ $monthlyCount['absent'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['halfday']">
                                                            {{ $monthlyCount['halfday'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['paidleave']">
                                                            {{ $monthlyCount['leave'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['weekoff']">
                                                            {{ $monthlyCount['weekoff'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['holiday']">
                                                            {{ $monthlyCount['holiday'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['mispunch']">
                                                            {{ $monthlyCount['mispunch'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['overtime']">
                                                            {{ $monthlyCount['overtime'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['late']">
                                                            {{ $monthlyCount['late'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['early']">
                                                            {{ $monthlyCount['early'] }}
                                                        </td>
                                                        <td class="text-center" id="{{ $emp->emp_id }}['total']">
                                                            {{ $monthlyCount['total'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                                data-bs-toggle="tooltip" data-original-title="View">

                                                                <a
                                                                    href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                                    <i class="feather feather-eye"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif
@section('js')
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js?v=0.1') }}"></script>
    <script src="{{ asset('assets/plugins/vertical-scroll/vertical-scroll.js?v=0.1') }}"></script>
    <!-- INTERNAL PG-CALENDAR-MASTER JS -->
    <script src="{{ asset('assets/js/index2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="{{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js?v=1.1') }}"></script>

    <script>
        $('#printBtn').on('click', function() {
            var divToPrint = document.getElementById("hr-attendance1");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        })
    </script>
@endsection
