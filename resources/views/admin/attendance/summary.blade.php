@extends('admin.pagelayout.master')
@section('title', 'Attendance Summary')
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
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('/admin/requests/leaves') }}">Attendance</a></li> --}}
            <li class="active"><span><b>Attendance Summary</b></span></li>
        </ol>
    </div>

    <!-- ROW -->
    @php
        $root = new App\Helpers\Central_unit();
        $Count = $root->GetCount(date('Y-m-d'));
    @endphp
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Attendance Summary
                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="row">
                                <div class="col-6">
                                    <select name="dataMonth" class="form-control text-center" id="dataMonth"
                                        onchange="getAttendanceData()" data-placeholder="Select Month"
                                        style="width:100px; border:solid 1px black">
                                        <option label="Month"></option>
                                        <?php
                                        for ($month = 1; $month <= 12; $month++) {
                                            $monthName = date('F', mktime(0, 0, 0, $month, 1));
                                            $selected = $month == date('n') ? 'selected="selected"' : '';
                                            echo '<option value="' . $month . '" ' . $selected . '>' . $monthName . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="dataYear" class="form-control text-center" id="dataYear"
                                        onchange="getAttendanceData()" data-placeholder="Year"
                                        style="width:100px; border:solid 1px black">
                                        <option label="Select Year"></option>
                                        <?php
                                        $currentYear = date('Y');
                                        for ($year = $currentYear; $year >= 1897; $year--) {
                                            $selected = $year == $currentYear ? 'selected="selected"' : '';
                                            echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap border-bottum " id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No</th>
                                    <th class="border-bottom-0">Employee</th>
                                    <th class="text-center border-bottom-0 ">Emp ID</th>
                                    <th class="text-center border-bottom-0 ">Present</th>
                                    <th class="text-center border-bottom-0 ">Absent</th>
                                    <th class="text-center border-bottom-0 ">Half Days</th>
                                    <th class="text-center border-bottom-0 ">Paid Leave</th>
                                    <th class="text-center border-bottom-0 ">Miss Punch</th>
                                    <th class="text-center border-bottom-0 ">Overtime</th>
                                    <th class="text-center border-bottom-0 ">Fine</th>
                                    <th class="text-center border-bottom-0 ">Total Attendance</th>
                                    <th class="text-center border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody id='empSumData'>
                                @foreach ($Emp as $key => $emp)
                                    @php
                                        $resCode = $root->attendanceCount($emp->emp_id, date('Y'), date('m'));
                                    @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                    style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">
                                                        <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                                            {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?= $root->DesingationIdToName($emp->designation_id) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $emp->emp_id }}</td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['present']">
                                            {{ $resCode[1] + $resCode[3] + $resCode[9] + $resCode[8]}}
                                        </td>
                                        {{-- @dd($resCode[8]); --}}
                                        <td class="text-center" id="{{ $emp->emp_id }}['absent']">{{ $resCode[2] + $resCode[11] }}
                                        </td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['halfday']">{{ $resCode[8] }}
                                        </td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['paidleave']">{{$resCode[10] }}
                                        </td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['mispunch']">{{ $resCode[4] }}
                                        </td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['overtime']">{{ $resCode[9] }}
                                        </td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['fine']">{{ $resCode[8] }}</td>
                                        <td class="text-center" id="{{ $emp->emp_id }}['total']">{{ $resCode[1] + $resCode[3] + $resCode[9] + $resCode[10] + ($resCode[8] / 2) }}</td>
                                        <td class="text-center">
                                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                data-bs-toggle="tooltip" data-original-title="View">

                                                @if (($resCode[1] + $resCode[3] + $resCode[9] + $resCode[8] / 2) > 0)
                                                    <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                        <i class="feather feather-eye"></i>
                                                    </a>
                                                @else
                                                    <a>No Record</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- @dd(($resCode[1] + $resCode[3] + $resCode[9] + $resCode[8] / 2)) --}}
                                @endforeach
                            </tbody>

                            <tbody class="">
                                <tr class="">
                                    <h4 id="bodyLoading" class="text-center d-none">Loading Data......</h4>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

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

    <script>
        function getAttendanceData() {
            var month = document.getElementById('dataMonth').value;
            var year = document.getElementById('dataYear').value;
            var tBody = document.getElementById('empSumData');
            $("#empSumData").addClass('d-none');
            $("#bodyLoading").removeClass('d-none');
            $.ajax({
                url: "{{ url('/admin/attendance/attendance_calculation') }}",
                type: "POST",
                data: {
                    month: month,
                    year: year,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result[1]);
                    // tBody.innerHTML = '';
                    // tBody.innerHTML = 'Loading...';
                    $("#empSumData").removeClass('d-none');
                    $("#bodyLoading").addClass('d-none');

                    result[0].forEach(element => {

                        var Present = result[1][element['emp_id']][1] + result[1][element['emp_id']][
                            3] + result[1][element['emp_id']][9] + result[1][element['emp_id']][8] / 2;
                        var Absent = result[1][element['emp_id']][2];
                        var Halfday = result[1][element['emp_id']][8];
                        var PaidLeave = result[1][element['emp_id']][10];
                        var Mispunch = result[1][element['emp_id']][9];
                        var Overtime = result[1][element['emp_id']][3];
                        var Fine = result[1][element['emp_id']][11];
                        var Total = Present + PaidLeave;

                        document.getElementById(element['emp_id'] + "['present']").innerHTML = Present;
                        document.getElementById(element['emp_id'] + "['absent']").innerHTML = Absent;
                        document.getElementById(element['emp_id'] + "['halfday']").innerHTML = Halfday;
                        document.getElementById(element['emp_id'] + "['paidleave']").innerHTML = PaidLeave; 
                            PaidLeave;
                        document.getElementById(element['emp_id'] + "['mispunch']").innerHTML = Mispunch;
                        Mispunch;
                        document.getElementById(element['emp_id'] + "['overtime']").innerHTML = Overtime;
                        Overtime;
                        document.getElementById(element['emp_id'] + "['fine']").innerHTML = Fine;
                        document.getElementById(element['emp_id'] + "['total']").innerHTML = Total;
                    });
                }
            });
        }
    </script>

@endsection
