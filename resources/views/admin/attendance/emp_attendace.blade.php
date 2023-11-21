@extends('admin.pagelayout.master')

@section('title')
    Employee Attendance Detail
@endsection

@section('js')
    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>
@endsection

@section('css')
    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        time {
            line-height: 1;
        }

        .timeline {
            padding: 3rem 2rem;
            max-width: 460px;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 4px 25px -20px rgba(0, 0, 0.2);
        }

        .tl-content .tl-header,
        .tl-content .tl-body {
            padding-left: 25.6px;
            border-left: 3px solid gainsboro;
        }

        .tl-body {
            padding-bottom: 10px;
        }

        .tl-content:last-child .tl-body {
            border-left: 3px solid transparent;
        }

        .tl-header {
            position: relative;
            display: grid;
            padding-bottom: 5px;
        }

        .tl-title {
            font-weight: 650;
            font-size: 12px;
        }

        .tl-time {
            font-size: 5px;
        }

        .tl-marker {
            display: block;
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50% / 50%;
            background: gainsboro;
            left: -1.1rem;
            transform: translate(50%, -50%);
        }

        .tl-content-active .tl-marker {
            padding: 1.6px;
            margin-top: 10px;
            left: -1.25rem;
            width: 18px;
            border: 2px solid #8c8c96;
            background-color: #8c8c96;
            background-clip: content-box;
            box-shadow: 0 0 15px -2px #8c8c96;
        }

        /* .halfday-status {
                color: #8fb31d;
            }

            .halfday-status-badge {
                color: #8fb31d;
                font-size: 11px;
                font-weight: bolder;
                padding: 2px;
                background-color: #8fb31d30;
            }

            .holiday-status {
                color: purple;
            }

            .holiday-status-badge {
                color: purple;
                font-size: 11px;
                font-weight: bolder;
                padding: 2px;
                background-color: rgba(128, 0, 128, 0.105);
            }

            .mispunch-status {
                color: orange;
            }

            .mispunch-status-badge {
                color: orange;
                font-size: 11px;
                font-weight: bolder;
                padding: 2px;
                background-color: rgba(255, 166, 0, 0.121);
            }

            .weekoff-status {
                color: gray;
            }

            .weekoff-status-badge {
                color: gray;
                font-size: 11px;
                font-weight: bolder;
                padding: 2px;
                background-color: rgba(128, 128, 128, 0.099);
            }

            .leave-status {
                color: brown;
            }

            .leave-status-badge {
                color: brown;
                font-size: 11px;
                font-weight: bolder;
                padding: 2px;
                background-color: rgba(165, 42, 42, 0.155);
            } */
        /* @media print{@page {size: landscape}} */
        .abc {
            color: #0e501f3e;
        }
    </style>
@endsection

@section('content')
    @php
        $root = new App\Helpers\Central_unit();
        $Department = $root->DepartmentList();
        $Branch = $root->BranchList();
        $Employee = $root->EmployeeDetails();
        $EmpID = $root->EmpPlaceHolder();
        $Designation = $root->DesignationList();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $ITEM = $LOADED->SectionEmployeeCounters();

    @endphp

    <div class=" p-0 py-2 mb-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('/admin/requests/leaves') }}">Attendance</a></li> --}}
            <li class="active"><span><b>Monthly Attendance</b></span></li>
        </ol>
    </div>
    <!-- PAGE HEADER -->
    

    <!-- ROW -->

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='country-dd' id="country-dd" class="form-control"
                                    data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                    data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}' required>
                                    <option value="">Select Branch </option>
                                    @foreach ($Branch as $data)
                                        <option value="{{ $data->branch_id }}"> 
                                            {{ $data->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3">
                                    <select id="state-dd" name="department_id" class="form-control" required>
                                        <option value="">Select Department </option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3">
                                    <select id="desig-dd" name="designation_id" class="form-control " required>
                                        <option value="">Select Designation </option>
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <p class="form-label">Year</p>
                                        <div class="form-group mb-3">
                                            <select name="year" id="yearFilter" class="form-control " required>
                                                <option value="">Select Year</option>
                                                @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <p class="form-label">Month</p>
                                        <div class="form-group mb-3">
                                            <select name="month" id="monthFilter" class="form-control " required>
                                                <option value="">Select Month</option>
                                                @for ($month = 1; $month <= 12; $month++)
                                                    <option value="{{ $month }}">
                                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex my-2">
                        <div class="me-3">
                            <label class="form-label">Note:</label>
                        </div>
                        <div>
                            <span class="present-status-badge me-2"><i
                                    class="feather feather-check-circle present-status"></i> ---&gt; Present</span>
                            <span class="absent-status-badge me-2"><i class="feather feather-x-circle absent-status"></i>
                                ---&gt; Absent</span>

                            <span class="halfday-status-badge me-2"><i class="fa fa-adjust halfday-status"></i> ---&gt;
                                Half Day</span>
                            <span class="weekoff-status-badge me-2"><i class="fa fa-calendar-check-o weekoff-status"></i>
                                ---&gt;
                                Week Off</span>
                            <span class="holiday-status-badge me-2"><i class="fa fa-star holiday-status"></i> ---&gt;
                                Holiday</span>
                            <span class="leave-status-badge me-2"><i class="fa fa-certificate leave-status"></i>
                                ---&gt;
                                Leave</span>
                            <span class="mispunch-status-badge me-2"><i class="fa fa-history mispunch-status"></i> ---&gt;
                                Mis-punch</span>

                        </div>
                    </div>
                    <div class="table-responsive hr-attlist">
                        <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap border-bottum" id="basic-datatable">
                                            <thead>
                                                <tr role="row">
                                                    <th class="border-bottom-0 reorder sorting sorting_asc" tabindex="0"
                                                        aria-controls="hr-attendance" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee Name: activate to sort column descending"
                                                        style="width: 165.031px;">Employee Name</th>
                                                    <?php $day = 0; ?>
                                                    @while (++$day <= date('t'))
                                                        <th class="border-bottom-0 w-5 sorting_disabled" rowspan="1"
                                                            colspan="1" aria-label="1" style="width: 14.5px;">
                                                            {{ $day }}</th>
                                                    @endwhile
                                                    <th class="border-bottom-0 sorting_disabled" rowspan="1"
                                                        colspan="1" aria-label="Total" style="width: 44.625px;">Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="resBody" class="my_body">
                                                @foreach ($Emp as $key => $emp)
                                                    {{-- @dd($root->getEmpAttSumm(['emp_id'=>'IT009','punch_date'=>date('Y-m-13')])); --}}
                                                    <tr class="odd border border-bottum">
                                                        <td class="reorder sorting_1">
                                                            <div class="d-flex">
                                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                                    style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                                <div class="me-3 mt-0 mt-sm-2 d-block">
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
                                                        @php
                                                            $day = 0;
                                                            $present = 0;
                                                            $halfday = 0;
                                                            $totalTwhMin = 0;
                                                            $totalOTMin = 0;
                                                        @endphp

                                                        @while ($day++ < date('t'))
                                                            <td>
                                                                <div class="hr-listd">
                                                                    @php
                                                                        if ($day <= date('d')) {
                                                                            $resCode = $root->getEmpAttSumm(['emp_id' => $emp->emp_id, 'punch_date' => date('Y-m-' . $day)]);
                                                                            $status = $resCode[0];
                                                                            $inTime = $resCode[1] != 0 ? date('h:i A', strtotime($resCode[1])) : '00:00';
                                                                            $outTime = $resCode[2] != 0 ? date('h:i A', strtotime($resCode[2])) : '00:00';
                                                                            $workingHour = $resCode[1] && $resCode[2] ? $resCode[3] : '00:00';
                                                                            $punchInLoc = $resCode[4];
                                                                            $punchOutLoc = $resCode[5];
                                                                            $shiftName = $resCode[6];
                                                                            $breakTime = $resCode[7];
                                                                            $overTime = $resCode[8];
                                                                            $shiftWH = $resCode[9];
                                                                            $twhMin = $resCode[10];
                                                                            $MaxOvertime = $resCode[11];
                                                                            $inSelfie = $resCode[17];
                                                                            $outSelfie = $resCode[18];
                                                                            $totalTwhMin += $twhMin;
                                                                            $totalOTMin += $overTime;
                                                                            $totalDayinMonth = date('t');
                                                                        } else {
                                                                            $resCode[0] = 5;
                                                                        }
                                                                    @endphp
                                                                    <a onclick="showPresentModal(this)"
                                                                        data-in="{{ $inTime }}"
                                                                        data-out="{{ $outTime }}"
                                                                        data-twh="{{ $workingHour }}"
                                                                        data-inloc="{{ $punchInLoc }}"
                                                                        data-outloc="{{ $punchOutLoc }}"
                                                                        data-shiftname="{{ $shiftName }}"
                                                                        data-breakmin="{{ $breakTime }}"
                                                                        data-overtime="{{ $overTime }}"
                                                                        data-inselfie="{{ $inSelfie }}"
                                                                        data-outselfie="{{ $outSelfie }}"
                                                                        class="hr-listmodal"></a>

                                                                    @if ($resCode[0] == 1 || $resCode[0] == 3 || $resCode[0] == 9)
                                                                        <?php $present++; ?>
                                                                        <span
                                                                            class="feather feather-check-circle present-status"></span>
                                                                    @elseif ($resCode[0] == 2)
                                                                        <span
                                                                            class="feather feather-x-circle absent-status"></span>
                                                                    @elseif ($resCode[0] == 6)
                                                                        <i class="fa fa-star holiday-status"></i>
                                                                    @elseif ($resCode[0] == 4)
                                                                        <i class="fa fa-history mispunch-status"></i>
                                                                    @elseif ($resCode[0] == 7)
                                                                        <i
                                                                            class="fa fa-calendar-check-o weekoff-status"></i>
                                                                    @elseif ($resCode[0] == 10 || $resCode[0] == 11)
                                                                        <i class="fa fa-certificate leave-status"></i>
                                                                    @elseif ($resCode[0] == 8)
                                                                        <?php $halfday++; ?>
                                                                        <span class=""><i
                                                                                class="fa fa-adjust halfday-status"></i></span>
                                                                    @else
                                                                        <span class=""> </span>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endwhile

                                                        <td>
                                                            <h6 class="mb-0">
                                                                <span
                                                                    class="text-primary">{{ $present + $halfday }}</span>
                                                                <span
                                                                    class="my-auto fs-8 font-weight-normal text-muted">/</span>
                                                                <span class="">{{ $day - 1 }}</span>
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->
        <!-- PRESENT MODAL -->
        <div class="modal fade" id="presentModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Details</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card-header border-bottom-0">
                                    <h4 class="">Timesheet<span
                                            class="fs-14 mx-3 text-muted">{{ date('d-M-y h:i a') }}</span></h4>
                                </div>

                                <div class="col-sm-12 my-auto" style="height: 260px">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="pt-5 text-center">
                                                <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchIn">12:00</h6>
                                                <small class="text-muted fs-14">Punch In</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="chart-circle chart-circle-md" data-value="100" data-thickness="8"
                                                data-color="#0dcd94">
                                                <div class="chart-circle-value text-muted" id="modalWorkingHr">09:05 hrs
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="pt-5 text-center">
                                                <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchOut">12:00</h6>
                                                <small class="text-muted fs-14">Punch Out</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-5">
                                        <div class="row">
                                            <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                <small class="text-muted fs-13">Break Time</small>
                                                <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">09:30 AM
                                                </p>
                                            </div>
                                            <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                <small class="text-muted fs-13">Overtime</small>
                                                <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">09:30 AM</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-6">

                                <div class="col-sm-12">
                                    <div class="">
                                        <h4 class="my-5">Timeline</h4>
                                    </div>
                                    <div class="col-sm-12 mt-5">
                                        <div class="tl-content tl-content-active">

                                            <div class="tl-header d-none" id="timeline1">
                                                <span class="tl-marker"></span>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="tl-title">Punch In at <span id="puchInAt"></span> |
                                                            <span class="shiftName"></span><br><span
                                                                class="text-muted fs-12"><i
                                                                    class="fa fa-map-marker mx-1"></i><span
                                                                    id="inLocation"></span></span>
                                                        <p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a id="showInSelfie" onclick="showSelfie(this)" data-imgin=''
                                                            class="my-auto">
                                                            <span id="showInSelfieBg" class="avatar avatar-sm brround"
                                                                style="background-image: url(assets/images/users/1.jpg)"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-header d-none" id="timeline2">
                                                <span class="tl-marker"></span>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="tl-title">Punch Out at <span id="punchOutAt"></span>
                                                            |<span class="shiftName"></span> <br><span
                                                                class="text-muted fs-12"><i
                                                                    class="fa fa-map-marker mx-1"></i><span
                                                                    id="punchOutLocation"></span></span>
                                                        <p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a id="showOutSelfie" onclick="showSelfie(this)" data-imgout=''
                                                            class="my-auto">
                                                            <span id="showOutSelfieBg" class="avatar avatar-sm brround"
                                                                style="background-image: url(assets/images/users/1.jpg)"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-outline-primary" data-bs-dismiss="modal">close</a>
                        {{-- <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- END PRESENT MODAL -->

        <!-- END HALFDAY EDIT MODAL -->
        {{-- Punch Image --}}
        <div class="modal fade" id="PunchIn">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h5 class="modal-title">PunchIn Selfie</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="inselfieID" src="" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="PunchOut">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h5 class="modal-title">PunchOut Selfie</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="outselfieID" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script>
            $(document).ready(function() {
                $('#country-dd, #state-dd, #desig-dd, #yearFilter, #monthFilter').change(function() {
                    var branchId = $('#country-dd').val();
                    var departmentId = $('#state-dd').val();
                    var designationId = $('#desig-dd').val();
                    var month = $('#monthFilter').val();
                    var year = $('#yearFilter').val();
                    var days = $('#country-dd').data('nodays'); // number of days in month
                    var mdays = $('#country-dd').data('modays'); //till today
                    var currentYear = $('#country-dd').data('currentYear'); //current year
                    var currentMonth = $('#country-dd').data('currentMonth'); //current month
                    var resBody = document.getElementById("resBody");
                    var tillCount = year == currentYear && month == currentMonth ? mdays : days;


                    resBody.innerHTML = '';
                    resBody.innerHTML = '<div class="text-center"><h4>Fetching Data....</h4></div>';

                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/attendance/monthly_attendance_calculation') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            branch_id: branchId,
                            department_id: departmentId,
                            designation_id: designationId,
                            'month': month,
                            'year': year
                        },
                        success: function(result) {
                            console.log(result);


                            resBody.innerHTML = '';
                            result[0].forEach(element => {
                                var empID = element.emp_id;
                                var present = 0;
                                var halfday = 0;
                                var day = 0;
                                // Check if the employee ID exists in result[1]
                                var newRow =
                                    '<tr>' +
                                    '<td>' +
                                    `<div class="d-flex">
                                            <span class="avatar avatar-md brround me-3 rounded-circle" style="background-image: url('/employee_profile/` +
                                    element.profile_photo + `')"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">` + element.emp_name + ' ' + (element
                                        .emp_mname !=
                                        null ? element.emp_mname : '') + ' ' + element
                                    .emp_lname + `</h6>
                                                    <p class="text-muted mb-0 fs-12">` + element.desig_name + `</p>
                                                    </div>
                                                    </div>` +
                                    '</td>';

                                if (result[1][empID]) {
                                    result[1][empID].forEach(status => {

                                        if (++day <= tillCount) {
                                            if (status === 1 || status === 3 ||
                                                status === 9) {
                                                present++;
                                                newRow +=
                                                    '<td><div class="hr-listd"><span class="feather feather-check-circle text-success"></span></div></td>';
                                            } else if (status === 2) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><span class="feather feather-x-circle text-danger"></span></div></td>';
                                            } else if (status === 6) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><span class="fa fa-star holiday-status"></span></div></td>';
                                            } else if (status === 4) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><i class="fa fa-history mispunch-status"></i></div></td>';
                                            } else if (status === 7) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><i class="fa fa-calendar-check-o weekoff-status"></i></div></td>';
                                            } else if (status === 10 || status ===
                                                11) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><i class="fa fa-certificate leave-status"></i></div></td>';
                                            } else if (status === 8) {
                                                newRow +=
                                                    '<td><div class="hr-listd"><i class="fa fa-adjust halfday-status"></i></div></td>';
                                                halfday++;
                                            } else {
                                                newRow +=
                                                    '<td><div class="hr-listd"><i></i></div></td>';
                                            }
                                        } else {
                                            newRow +=
                                                '<td><div class="hr-listd"><i></i></div></td>';
                                        }
                                    });
                                }

                                newRow += `
                                <td>
                                    <h6 class="mb-0">
                                        <span class="text-primary">` + (present + (halfday / 2)) + `</span>
                                        <span class="my-auto fs-8 font-weight-normal text-muted">/</span>
                                        <span>` + days + `</span>
                                    </h6>
                                </td>
                            </tr>`;

                                resBody.insertAdjacentHTML('beforeend', newRow);


                            });
                        }
                    });
                });
            });
        </script>

        <script>
            function showPresentModal(context) {
                $('#presentModal').modal('show');
                var inTime = $(context).data('in');
                var outTime = $(context).data('out');
                var twh = $(context).data('twh');
                var inLoc = $(context).data('inloc');
                var outLoc = $(context).data('outloc');
                var breakMin = $(context).data('breakmin');
                var shiftName = $(context).data('shiftname');
                var overTime = $(context).data('overtime');
                var inSelfie = $(context).data('inselfie');
                var outSelfie = $(context).data('outselfie');

                console.log(outTime == '00:00');

                if(inTime != '00:00'){
                    $('#timeline1').removeClass('d-none');
                }
                if(outTime != '00:00'){
                    $('#timeline2').removeClass('d-none');
                }

                $('#modalPunchIn').html(inTime);
                $('#puchInAt').html(inTime);
                $('#modalPunchOut').html(outTime);
                $('#punchOutAt').html(outTime);
                $('#modalWorkingHr').html(twh);
                $('#inLocation').html(inLoc);
                $('#punchOutLocation').html(outLoc);
                $('#modalBreakTime').html(breakMin);
                $('#modalOverTime').html(overTime);
                $('.shiftName').html(shiftName);
                $("#showInSelfie").attr("data-imgin", inSelfie);
                $("#showOutSelfie").attr("data-imgout", outSelfie);
                $("#showInSelfieBg").css("background-image", "url('/upload_image/" + inSelfie + "')");
                $("#showOutSelfieBg").css("background-image", "url('/upload_image/" + outSelfie + "')");
                // console.log(document.getElementById('showInSelfie'));
            }

            function showSelfie(context) {
                if (context.id === 'showInSelfie') {
                    var inSelfie = context.getAttribute('data-imgin');
                    var inSelfieURL = "{{ asset('/upload_image/') }}" + "/" + inSelfie;
                    console.log(inSelfieURL);
                    $('#PunchIn').modal('show');
                    $("#inselfieID").attr("src", inSelfieURL);
                }

                if (context.id === 'showOutSelfie') {
                    var outSelfie = context.getAttribute('data-imgout');
                    var outSelfieURL = "{{ asset('/upload_image/') }}" + "/" + outSelfie;
                    $('#PunchOut').modal('show');
                    $("#outselfieID").attr("src", outSelfieURL);
                }

            }
        </script>
    @endsection
