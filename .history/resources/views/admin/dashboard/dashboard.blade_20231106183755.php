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
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-year {
            font-size: 100%;
        }

        .pignose-calendar .pignose-calendar-header .pignose-calendar-week {
            height: 2em;
            line-height: 2em;
        }
    </style>
@endsection
@section('content')
    <?php

    // $REAL_IP = getenv('HTTP_X_REAL_IP');
    // $FORWARDED_CONTINENT = getenv('HTTP_X_FORWARDED_CONTINENT');
    // $FORWARDED_COUNTRY = getenv('HTTP_X_FORWARDED_COUNTRY');

    // echo 'Real IP  : ' . $REAL_IP . '<br>';
    // echo 'Source IP Continent : ' . $FORWARDED_CONTINENT . '<br>';
    // echo 'Source IP Country : ' . $FORWARDED_COUNTRY . '<br>';
    ?>
    <div class=" p-0 pb-4">

        <div class="container-fluid">
            @php
                $root = new App\Helpers\Central_unit();
                $Count = $root->GetCount();
                // $empCount = GetEmpCount();
            @endphp
            <div class="page-header d-md-flex d-block">
                <div class="page-leftheader">
                    {{-- <a class="side-menu__item" href="{{ url('/admin') }}">
                <i class="feather feather-home sidemenu_icon"></i>
                <span class="side-menu__label">Dashboard</span>
                </a> --}}
                    <div class="page-title"><i class="feather feather-home sidemenu_icon"> <b
                                style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Dashborad</b></i>
                    </div>
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
                                    </div><input class="form-control fc-datepicker"
                                        placeholder="{{ date('d' . '/' . 'M' . '/' . 'Y') }}" type="text">
                                </div>
                            </div>
                            <div class="header-datepicker me-3 d-none d-md-block">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text d-none d-xl-block">
                                            <i class="feather feather-clock"></i>
                                        </div>
                                    </div><!-- input-group-prepend -->
                                    <input id="tpBasic" type="text" placeholder="{{ date('h:i') }}"
                                        class="form-control input-small">
                                </div>
                            </div><!-- wd-150 -->
                        </div>

                        <div class="d-lg-flex d-block">
                            @if (in_array('Dashboard.Update', $permissions))
                                <div class="btn-list">
                                    <a href="{{ asset('admin/attendance') }}" type="button"
                                        class="btn btn-primary">Attendance
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
                                    <h3 class=" mb-1 mt-1 font-weight-bold">{{ $Count[0] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Present</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">{{ $Count[1] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Absent</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">{{ $Count[4] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Half Day</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Leave</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">{{ $Count[3] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Miss Punch</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">{{ $Count[2] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Late In</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body"> <span>Overtime</span>
                                    <h3 class=" mb-1 mt-1 font-weight-bold">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <span class="ms-auto badge bg-primary">{{ $Count[1] }}</span>
                                </a>
                                <a href="#"
                                    class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                    <div class="spinner1">
                                        <div class="double-bounce1 bg-success"></div>
                                        <div class="double-bounce2 bg-success"></div>
                                    </div>
                                    </span> <b>Manage Miss Punch</b> <span
                                        class="ms-auto badge bg-success">{{ $Count[2] }}</span>
                                </a>
                                <a href="#"
                                    class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                    <div class="spinner1">
                                        <div class="double-bounce1 bg-success"></div>
                                        <div class="double-bounce2 bg-success"></div>
                                    </div>
                                    </span> <b>Manage Leaves</b> <span
                                        class="ms-auto badge bg-secondary">{{ $Count[3] }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-12 col-lg-12">
                    <div class="card-header border-bottom-0 pt-2 ps-0">
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
                        <div class="card-header border-bottom-0 pt-2 ps-0">
                            <h4 class="card-title">Birthdays (<span>{{ date('F') }}</span>)</h4>
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
                                    {{-- <p>{{$birth_m}}</p> --}}
                                    <div class="card px-4 py-4">
                                        <div class="d-flex comming_events calendar-icon icons">
                                            <span class="date_time bg-success-transparent bradius me-3"><span
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
                                                    {{-- <small>{{$birth_m'-'$birth_d}}</small> --}}
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
                        <div class="card-header border-bottom-0 pt-2 ps-0">
                            <h4 class="card-title">Upcomming Holidays</h4>
                        </div>
                        {{-- @php
                        dd($Holiday);
                    @endphp --}}
                        <ul class="vertical-scroll">
                            <?php $holidayCount = 0; ?>
                            @foreach ($Holiday as $holiday)
                                <?php
                            $holidayD = date('d', strtotime($holiday->holiday_date));
                            $holidayM = date('m', strtotime($holiday->holiday_date));
                            $holidayY = date('Y', strtotime($holiday->holiday_date));
                            $holidayDayName = date('l', strtotime($holiday->holiday_date));
                            if($holidayM >= date('m') &&  $holidayD >= date('d') && $holidayY >= date('Y') && ++$holidayCount <= 5){ ?>
                                <li class="item">
                                    <div class="card px-4 py-4 ">
                                        <div class="d-flex comming_events calendar-icon icons">
                                            <span class="date_time bg-pink-transparent bradius me-3"><span
                                                    class="date fs-18" style="color:#1877f2">{{ $holidayD }}</span>
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
                        <div class="card-header border-bottom-0 pt-2 ps-0">
                            <h4 class="card-title">Notice Board</h4>
                        </div>
                        <ul class="vertical-scroll">
                            <?php $noticeCount = 0; ?>
                            @foreach ($Notice as $notice)
                                <?php
                                $noticeD = date('d', strtotime($notice->date));
                                $noticeM = date('M', strtotime($notice->date));
                                $noticeY = date('Y', strtotime($notice->date));
                                $noticeDayName = date('l', strtotime($notice->date)); ?>
                                <?php if($noticeM >= date('m') &&  $noticeD >= date('d') && $noticeY >= date('Y') && ++$noticeCount <= 5){ ?>
                                <li class="item">
                                    <div class="card px-4 py-4 ">
                                        <a href="{{ url('notice_uploads/' . $notice->file) }}" target="_blank"
                                            rel="noopener noreferrer">
                                            <div class="d-flex comming_events calendar-icon icons">
                                                <span class="date_time bg-pink-transparent bradius me-3"><span
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
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <div class="card-title">
                            Attendance Summary
                        </div>
                        <div class="page-rightheader ms-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="btn-list d-flex">
                                    <div>
                                        <button class="btn btn-primary mx-3 border-0" id="printBtn">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap table-striped" id="hr-attendance1">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="border-bottom-0 ">Employee</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Emp ID</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Present</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Absent</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Half Days</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Paid Leave</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Miss Punch</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Overtime</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Fine</th>
                                        <th rowspan="2" class="text-center border-bottom-0 ">Total Attendance</th>
                                        <th rowspan="2" class="text-center border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $limit = 10;
                                    @endphp
                                    @foreach ($Emp as $emp)
                                        @php
                                            $resCode = $root->attendanceCount($emp->emp_id,date('Y'),date('m'));
                                            // dd($resCode);
                                        @endphp
                                        @if ($resCode[1] + $resCode[3] + $resCode[9] + $resCode[8] / 2 != 0)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <span class="avatar avatar-md brround me-3 rounded-circle"
                                                            style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                                            <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                                            <h6 class="mb-1 fs-14">
                                                                    {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}
                                                                </h6>
                                                            </a>
                                                            <p class="text-muted mb-0 fs-12">
                                                                <?= $root->DesingationIdToName($emp->designation_id) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $emp->emp_id }}</td>

                                                <td class="text-center">
                                                    {{ $resCode[1] + $resCode[3] + $resCode[9] + $resCode[8] / 2 }}</td>
                                                <td class="text-center">{{ $resCode[2] }}</td>
                                                <td class="text-center">{{ $resCode[8] }}</td>
                                                <td class="text-center">{{ '0' }}</td>
                                                <td class="text-center">{{ $resCode[9] }}</td>
                                                <td class="text-center">{{ $resCode[3] }}</td>
                                                <td class="text-center">{{ '0' }}</td>
                                                <td class="text-center">{{ $resCode[1] }}</td>
                                                <td class="text-center">
                                                    <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                        data-bs-toggle="tooltip" data-original-title="View">
                                                        <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            @php
                                                if ($limit-- <= 0) {
                                                    break;
                                                }
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex">
                                <a href="{{ url('/admin/attendance/month-summary') }}"
                                    class="btn btn-sm btn-outline-primary ms-auto">View More</a>
                            </div>
                        </div>
                        <div class="rescalendar" id="my_calendar_en"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js?v=0.1') }}"></script>
        <script src="{{ asset('assets/plugins/vertical-scroll/vertical-scroll.js?v=0.1') }}"></script>

        <!-- INTERNAL PG-CALENDAR-MASTER JS -->
        <script src="{{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/index2.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

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
