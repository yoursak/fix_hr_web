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

        .card-body {
            padding: 0;
        }
    </style>
@endsection
@if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.View', $permissions))

@section('content')
    @php
        $root = new App\Helpers\Central_unit();
        // $Count = $root->GetCount(date('Y-m-d'));
        $Department = $root->DepartmentList();
        $Branch = $root->BranchList();
        $Designation = $root->DesignationList();
        $Employee = $root->EmployeeDetails();
    @endphp
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                {{-- <li><a href="{{ url('/admin/requests/leaves') }}">Attendance</a></li> --}}
                <li class="active"><span><b>Attendance Summary</b></span></li>
            </ol>
        </div>

        <!-- ROW -->
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

                                </div>
                            </div>
                        </div>
                    </div>
             
                    <div class="card-body">
                        <div class="row mx-3">
                            <div class="col-md-12 col-lg-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Branch</p>
                                            <select name='branch_id' id="branchSelect" class="form-control"
                                                onchange="getAttendanceData()">
                                                <option value="">All Branch</option>
                                                @foreach ($Branch as $data)
                                                    <option value="{{ $data->branch_id }}">
                                                        {{ $data->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Department</p>
                                            <div class="form-group mb-3">
                                                <select id="DepartmentSelect" name="department_id" class="form-control"
                                                    onchange="getAttendanceData()">
                                                    <option value="">All Department</option>
                                                    @foreach ($Department as $data)
                                                        <option value="{{ $data->depart_id }}">
                                                            {{ $data->depart_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Designation</p>
                                            <div class="form-group mb-3">
                                                <select id="DesignationSelect" name="designation_id" class="form-control"
                                                    onchange="getAttendanceData()">
                                                    <option value="">All Designation</option>
                                                    @foreach ($Designation as $data)
                                                        <option value="{{ $data->desig_id }}">
                                                            {{ $data->desig_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div>
                                                {{-- <input type="month" value="{{ date('Y-m') }}" class="form-control fc-datepicker" id="monthSelect" name="date_select_name" placeholder="YYYY-MM" /> --}}
                                                <input type="month" class="form-control" name="date_select_name"
                                                    id="monthSelect" value="{{ now()->format('Y-m') }}"
                                                    onchange="getAttendanceData()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap border-bottum " id="basic-datatable">
                                <thead>
                                    <tr>
                                        {{-- <th class="border-bottom-0">S.No</th> --}}
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
                                <tbody id='empSumData'>
                                    @foreach ($Emp as $key => $emp)
                                        @php
                                            $resCode = $root->attendanceCount($emp->emp_id, date('Y'), date('m'));
                                            $monthlyCount = $root->getMonthlyCountFromDB($emp->emp_id, date('Y'), date('m'), Session::get('business_id'));
                                            $root->MyCountForMonth($emp->emp_id, date('Y-m-d'), Session::get('business_id'));
                                            // dd($monthlyCount);
                                        @endphp
                                        <tr>
                                            {{-- <td>{{ ++$key }}</td> --}}
                                            <td id="{{ $emp->emp_id }}['profile']">
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3 rounded-circle"
                                                        style="background-image: url('/storage/livewire_employee_profile/{{ $emp->profile_photo }}')"></span>
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
                                            <td id="{{ $emp->emp_id }}['empId']">{{ $emp->emp_id }}</td>
                                            <td class="text-center" id="{{ $emp->emp_id }}['present']">
                                                {{ $monthlyCount['present'] }}
                                            </td>
                                            {{-- @dd($resCode[8]); --}}
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
                                            {{-- <td class="text-center" id="{{ $emp->emp_id }}['fine']">{{ $resCode[8] }}</td> --}}
                                            <td class="text-center" id="{{ $emp->emp_id }}['total']">
                                                {{ $monthlyCount['total'] }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                    data-bs-toggle="tooltip" data-original-title="View">

                                                    <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                        <i class="feather feather-eye"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
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
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>

    <!-- INTERNAL PG-CALENDAR-MASTER JS -->
    <script src="{{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/index2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#branchSelect, #DepartmentSelect, #DesignationSelect, #monthSelect').change(function() {
                var branchId = $('#branchSelect').val();
                var departmentId = $('#DepartmentSelect').val();
                var designationId = $('#DesignationSelect').val();
                var selectedDate = $('#monthSelect').val();
    
                var splitedMonthYear = selectedDate.split("-");
                var year = splitedMonthYear[0];
                var month = splitedMonthYear[1];
    
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/attendance/attendance_calculation') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId,
                        month: month,
                        year: year,
                    },
                    success: function(result) {
                        console.log(result);
    
                        var employeesData = result[0];
                        var attendanceData = result[1];
    
                        // Select the tbody element
                        var tbody = $("#empSumData");
    
                        // Clear existing content
                        tbody.empty();
    
                        employeesData.forEach(function(element) {
                            var sd = element.emp_id;
                            var newRow =
                                `<tr>
                                    <td id="${element.emp_id}['profile']">
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                style="background-image: url('/storage/livewire_employee_profile/${element.profile_photo}')"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">
                                                    <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                                        ${element.emp_name} ${element.emp_mname != null ? element.emp_mname : ''} ${element.emp_lname}
                                                    </a>
                                                </h6>
                                                <p class="text-muted mb-0 fs-12">
                                                    ${element.desig_name}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="${element.emp_id}['empId']">${element.emp_id}</td>
                                    <td class="text-center" id="${element.emp_id}['present']">
                                        ${attendanceData[element.emp_id]['present']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['absent']">
                                        ${attendanceData[element.emp_id]['absent']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['halfday']">
                                        ${attendanceData[element.emp_id]['halfday']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['paidleave']">
                                        ${attendanceData[element.emp_id]['leave']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['weekoff']">
                                        ${attendanceData[element.emp_id]['weekoff']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['holiday']">
                                        ${attendanceData[element.emp_id]['holiday']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['mispunch']">
                                        ${attendanceData[element.emp_id]['mispunch']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['overtime']">
                                        ${attendanceData[element.emp_id]['overtime']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['late']">
                                        ${attendanceData[element.emp_id]['late']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['early']">
                                        ${attendanceData[element.emp_id]['early']}
                                    </td>
                                    <td class="text-center" id="${element.emp_id}['total']">
                                        ${attendanceData[element.emp_id]['total']}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                            data-bs-toggle="tooltip" data-original-title="View">
                                            <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                <i class="feather feather-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>`;
    
                            // Append the new row to the tbody
                            tbody.append(newRow);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle errors if any
                    }
                });
            });
        });
    </script>
    

    <script>
        $('#printBtn').on('click', function() {
            var divToPrint = document.getElementById("hr-attendance1");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        })
    </script>

    {{-- <script>
        function getAttendanceData() {

            var branchId = $('#branchSelect').val();
            var departmentId = $('#DepartmentSelect').val();
            var designationId = $('#DesignationSelect').val();
            var selectedDate = $('#monthSelect').val();

            var splitedMonthYear = selectedDate.split("-");
            var year = splitedMonthYear[0];
            var month = splitedMonthYear[1];
            var tBody = document.getElementById('empSumData');

            // console.log(branchId,departmentId,designationId,year,month,tBody);

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
                            3
                        ] + result[1][element['emp_id']][9] + result[1][element['emp_id']][8] / 2;
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
                        document.getElementById(element['emp_id'] + "['paidleave']").innerHTML =
                            PaidLeave;
                        PaidLeave;
                        document.getElementById(element['emp_id'] + "['mispunch']").innerHTML =
                        Mispunch;
                        Mispunch;
                        document.getElementById(element['emp_id'] + "['overtime']").innerHTML =
                        Overtime;
                        Overtime;
                        document.getElementById(element['emp_id'] + "['fine']").innerHTML = Fine;
                        document.getElementById(element['emp_id'] + "['total']").innerHTML = Total;
                    });
                }
            });
        }
    </script> --}}

@endsection
@endif
