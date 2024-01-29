@extends('admin.pagelayout.master')

@section('title')
    Monthly Attendance Detail
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

        tr {
            line-height: 1.5;
        }
    </style>
@endsection

@section('js')
    <!-- CIRCLE-PROGRESS JS -->

    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>

    <!-- INTERNAL INDEX JS -->
@endsection
@if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.View', $permissions))
    @section('content')
        @php
            $root = new App\Helpers\Central_unit();
            $ruleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
            $byAttendanceCalculation = $root->attendanceByEmpDetails($emp->emp_id, date('Y'), date('m'));
            $monthlyCount = $root->getMonthlyCountFromDB($emp->emp_id, date('Y'), date('m'), Session::get('business_id'));
            $allStatusCount = $root->attendanceCount($emp->emp_id, date('Y'), date('m'));
            $getLeave = $root->getEmpAttSumm(['emp_id' => $emp->emp_id, 'punch_date' => date('Y-m-d')]);
            $root->MyCountForMonth($emp->emp_id, date('Y-m-d'), Session::get('business_id'));
            $rotate = $root->MyCountForMonth('IT009', date('Y-m-d'), Session::get('business_id'));
        @endphp

        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/attendance/month-summary') }}">Attendance Summary</a></li>
                <li class="active"><span><b>Attendance By</b></span></li>
            </ol>
        </div>

        <!-- PAGE HEADER -->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <div class="page-title">Attendance By <span
                        class="text-primary">{{ $emp->emp_name . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname }}
                        ({{ $emp->emp_id }})</span>
                </div>
            </div>
            <div class="page-rightheader ms-md-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="row">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <input type="month" class="form-control" onchange="getData(this)" id="monthYearFilter"
                                    name="leave_periodfrom" value="{{ now()->format('Y-m') }}"
                                    data-empid="{{ $emp->emp_id }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->
        <!-- ROW -->

        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="row mb-0 pb-0">

                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                        <span class="avatar avatar-md bradius fs-20 present-status-badge"
                                            id="getPresentCount">{{ $monthlyCount['present'] }}</span>
                                        <h5 class="mb-0 mt-3">Present Days</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 absent-status-badge"
                                            id="getAbsentCount">{{ $monthlyCount['absent'] }}</span>
                                        <h5 class="mb-0 mt-3">Absent Days</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 halfday-status-badge"
                                            id="getHalfDayCount">{{ $monthlyCount['halfday'] }}</span>
                                        <h5 class="mb-0 mt-3">Half Days</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 holiday-status-badge"
                                            id="getHolidayCount">{{ $monthlyCount['holiday'] }}</span>
                                        <h5 class="mb-0 mt-3">Holidays</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                        <span class="avatar avatar-md bradius fs-20 late-status-badge"
                                            id="getLateCount">{{ $monthlyCount['late'] }}</span>
                                        <h5 class="mb-0 mt-3">Late Days</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 bg-danger-transparent"
                                            id="getEarlyCount">{{ $monthlyCount['early'] }}</span>
                                        <h5 class="mb-0 mt-3">Early Exit</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 mispunch-status-badge"
                                            id="getMisPunchCount">{{ $monthlyCount['mispunch'] }}</span>
                                        <h5 class="mb-0 mt-3">Mis-punch</h5>
                                    </div>
                                    <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                        <span class="avatar avatar-md bradius fs-20 leave-status-badge"
                                            id="getLeaveRemainCount">{{ $monthlyCount['leave'] }}</span>
                                        <h5 class="mb-0 mt-3">Leave</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="">
                                    <h4 class="my-5">Statistics</h4>
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="d-flex justify-content-between">
                                        <h6>This Month</h6>
                                        <h6><b><span
                                                    id="getcwhCount">{{ number_format($byAttendanceCalculation[1]) }}</span>
                                                hr / <span
                                                    id="gettwhCount">{{ number_format($byAttendanceCalculation[0]) }}</span>
                                                hr</b></h6>
                                    </div>
                                    <div class="progress progress-md mb-3" style="border-radius:0px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="progress1"
                                            style="width: {{ number_format($byAttendanceCalculation[2]) }}%; border-radius:0px; background-color:#1877f2">
                                            {{ number_format($byAttendanceCalculation[2], 1) }}%</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6>Remaining</h6>
                                        <h6><b><span
                                                    id="getrwhCount">{{ number_format($byAttendanceCalculation[6]) }}</span>
                                                hr /<span
                                                    id="gettrwhCount">{{ number_format($byAttendanceCalculation[0]) }}</span>
                                                hr</b></h6>
                                    </div>
                                    <div class="progress progress-md mb-3" style="border-radius:0px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="progress2"
                                            style="width: {{ $byAttendanceCalculation[7] }}%;border-radius:0px;background-color:#A52A2A">
                                            {{ number_format($byAttendanceCalculation[7], 1) }}%</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6>Overtime</h6>
                                        <h6><b><span
                                                    id="getotwhCount">{{ number_format($byAttendanceCalculation[4]) }}</span>
                                                hr/<span
                                                    id="gettotwhCount">{{ number_format($byAttendanceCalculation[3]) }}</span>
                                                hr</b></h6>
                                    </div>
                                    <div class="progress progress-md" style="border-radius:0px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                            id="progress3"
                                            style="width: {{ $byAttendanceCalculation[5] }}%;border-radius:0px">
                                            {{ number_format($byAttendanceCalculation[5], 1) }}%
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-body">
                    <div id="leavesoverview" class="mx-auto pt-2"></div>
                    <div class="row mx-auto text-center">
                        <div class="col-12 mx-auto d-flex">
                            @foreach ($getLeave[20] as $leave)
                                <div class="d-flex font-weight-semibold mx-2">
                                    @if ($allStatusCount[10] ?? 0 != 0)
                                        <span
                                            class="dot-label bg-success me-2 my-auto"></span>{{ $leave['name'] }}({{ $leave['remaining'] }})
                                    @endif
                                </div>
                            @endforeach
                            <div class="d-flex font-weight-semibold mx-2">
                                @if ($allStatusCount[11] ?? 0 != 0)
                                    <span class="dot-label badge-danger me-2 my-auto"></span>Unpaid
                                    Leaves({{ $allStatusCount[11] }})
                                @endif
                            </div>
                        </div>
                    </div>
                </div> --}}
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table table-vcenter text-center border-bottum" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0 text-center">S.No.</th>
                                        <th class="border-bottom-0 text-center">Date</th>
                                        <th class="border-bottom-0 text-center">Day</th>
                                        <th class="border-bottom-0 text-center">Status</th>
                                        <th class="border-bottom-0 text-center">Punch In</th>
                                        <th class="border-bottom-0 text-center">Punch Out</th>
                                        <th class="border-bottom-0 text-center">Working Hour</th>
                                        <th class="border-bottom-0 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceBody">
                                    @php

                                        $sno = 0;
                                        $totalTwhMin = 0;
                                        $totalOTMin = 0;
                                        $totalLateTime = 0;
                                        $totalEarlyExitTime = 0;
                                        $day = 1;
                                        $statusCounts = [
                                            1 => 0, // Present
                                            2 => 0, // Absent
                                            3 => 0, // Late
                                            4 => 0, // Mispunch
                                            5 => 0, // working
                                            6 => 0, // Holiday
                                            7 => 0, // Week Off
                                            8 => 0, // Half Day
                                            9 => 0, // Overtime
                                            10 => 0, // Paid Leave
                                            11 => 0, // Unpaid Leave
                                            12 => 0, // earlyexit
                                        ];
                                    @endphp

                                    @while ($day <= date('d'))
                                        {{-- @dd($day); --}}
                                        @php
                                            $punchDate = date('Y-m-' . $day);
                                            $TimeLog = $root->getTimeLog($emp->emp_id, date('Y-m-' . $day));
                                            // dd($TimeLog);
                                            $resCode = $root->getEmpAttSumm(['emp_id' => $emp->emp_id, 'punch_date' => date('Y-m-' . $day)]);
                                            // dd($resCode);
                                            $status = $resCode[0];
                                            $inTime = $resCode[1] != 0 ? date('h:i A', strtotime($resCode[1])) : '--';
                                            $outTime = $resCode[2] != 0 ? date('h:i A', strtotime($resCode[2])) : '--';
                                            $workingHour = $resCode[1] && $resCode[2] ? $resCode[3] : '--';
                                            $punchInLoc = $resCode[4];
                                            $punchOutLoc = $resCode[5];
                                            $shiftName = $resCode[6];
                                            $breakTime = $resCode[7];
                                            $overTime = $resCode[8];
                                            $shiftWH = $resCode[9];
                                            $twhMin = $resCode[10];
                                            $MaxOvertime = $resCode[11];
                                            $lateby = $resCode[12];
                                            $earlyExitBy = $resCode[13];
                                            $occurance = $resCode[14];
                                            $entryGrace = $resCode[15];
                                            $exitGrace = $resCode[16];
                                            $inSelfie = $resCode[17];
                                            $outSelfie = $resCode[18];
                                            $remLeave = $resCode[19];
                                            $leaveDetails = $resCode[20];
                                            $shiftStartTime = isset($resCode[21]) ? date('h:i A', strtotime($resCode[21])) : 'N/A';
                                            $shiftEndTime = isset($resCode[22]) ? date('h:i A', strtotime($resCode[22])) : 'N/A';
                                            // dd($shiftStartTime,$shiftEndTime);
                                            $totalTwhMin += $twhMin;
                                            $totalOTMin += $overTime;
                                            if ($status == 3) {
                                                $totalEarlyExitTime += $earlyExitBy;
                                                $totalLateTime += $lateby;
                                                // dd($totalLateTime);
                                            }
                                            $totalDayinMonth = date('t');

                                            $employeeOtherDetails = $root->getIndivisualEmployeeDetails($emp->emp_id);

                                            // dd($employeeOtherDetails);
                                            $EmpName = $employeeOtherDetails->emp_name ?? '';
                                            $EmpMName = $employeeOtherDetails->emp_mname ?? '';
                                            $EmpLName = $employeeOtherDetails->emp_lname ?? '';
                                            $EmpID = $employeeOtherDetails->emp_id ?? '';
                                            $EmpShiftName = $employeeOtherDetails->attendance_shift_name ?? '';
                                            $EmpShiftStart = $ruleManagement->Convert24To12($employeeOtherDetails->shift_start ?? '');
                                            $EmpShiftEnd = $ruleManagement->Convert24To12($employeeOtherDetails->shift_end ?? '');

                                            // dd($EmpShiftStart);

                                            // Employee's Leave Details
                                            $leave = $root->getEmpLeaveDetails($EmpID, $punchDate);

                                        @endphp
                                        <tr>
                                            <td>{{ ++$sno }}</td>
                                            <td>{{ date($day . '-M-Y') }}</td>
                                            <td>{{ date('l', strtotime(date($day . '-M-Y'))) }}</td>

                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        1 => 'Present', //success
                                                        2 => 'Absent', //danger
                                                        3 => 'Present', //danger
                                                        4 => 'Mispunch', //orange
                                                        5 => 'Working', //secondary
                                                        6 => 'Holiday', //yellow
                                                        7 => 'Week Off', //gray
                                                        8 => 'Halfday', //yellow
                                                        9 => 'Present', //primary
                                                        10 => 'Leave', //brown
                                                        11 => 'Leave', //brown
                                                        12 => 'Present', // EarlyExit
                                                    ];
                                                    $badgeColors = [
                                                        1 => 'present-status-badge',
                                                        2 => 'absent-status-badge',
                                                        3 => 'present-status-badge',
                                                        4 => 'mispunch-status-badge',
                                                        5 => 'present-status-badge',
                                                        6 => 'holiday-status-badge',
                                                        7 => 'weekoff-status-badge',
                                                        8 => 'halfday-status-badge',
                                                        9 => 'present-status-badge',
                                                        10 => 'leave-status-badge',
                                                        11 => 'leave-status-badge',
                                                        12 => 'present-status-badge',
                                                    ];
                                                @endphp

                                                @php
                                                    //Early Exit Rule
                                                    $earlyOccurrenceIs = $occurance[0];
                                                    $earlyOccurrence = $occurance[1];
                                                    $earlyOccurrencePenalty = $occurance[2];
                                                    //Late Rule
                                                    $lateOccurrenceIs = $occurance[3];
                                                    $lateOccurrence = $occurance[4];
                                                    $lateOccurrencePenalty = $occurance[5];
                                                    //status print indicator
                                                    $statusPrinted = false;

                                                    $load = implode(
                                                        ', ',
                                                        $TimeLog
                                                            ->map(function ($log) {
                                                                return $log->changer_name . '(' . $log->changer_role . ')';
                                                            })
                                                            ->toArray(),
                                                    );
                                                    $loadArray = explode(', ', $load);
                                                    $CorrectedBy = end($loadArray);

                                                @endphp

                                                @if ($status == 3 || $status == 12)
                                                    @if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 0)
                                                        @if ($lateOccurrenceIs == 1)
                                                            @if ($allStatusCount[3] >= $lateOccurrence)
                                                                @if ($lateOccurrencePenalty == 1)
                                                                    <span id="statusLabelView"
                                                                        class="halfday-status-badge">Halfday</span>
                                                                @else
                                                                    <span id="statusLabelView"
                                                                        class="absent-status-badge">Absent</span>
                                                                @endif
                                                                @php $statusPrinted = true; @endphp
                                                            @endif
                                                        @elseif ($lateOccurrenceIs == 2)
                                                            @if ($totalLateTime >= $lateOccurrence)
                                                                @if ($lateOccurrencePenalty == 1)
                                                                    <span id="statusLabelView"
                                                                        class="halfday-status-badge">Halfday</span>
                                                                @else
                                                                    <span id="statusLabelView"
                                                                        class="absent-status-badge">Absent</span>
                                                                @endif
                                                                @php $statusPrinted = true; @endphp
                                                            @endif
                                                        @endif
                                                        @if ($earlyOccurrenceIs == 1 && !$statusPrinted)
                                                            @if ($allStatusCount[12] >= $earlyOccurrence)
                                                                @if ($earlyOccurrencePenalty == 1)
                                                                    <span id="statusLabelView"
                                                                        class="halfday-status-badge">Halfday</span>
                                                                @else
                                                                    <span id="statusLabelView"
                                                                        class="absent-status-badge">Absent</span>
                                                                @endif
                                                                @php $statusPrinted = true; @endphp
                                                            @endif
                                                        @elseif ($earlyOccurrenceIs == 2 && !$statusPrinted)
                                                            @if ($totalEarlyExitTime >= $earlyOccurrence && !$statusPrinted)
                                                                @if ($earlyOccurrencePenalty == 1)
                                                                    <span id="statusLabelView"
                                                                        class="halfday-status-badge">Halfday</span>
                                                                @else
                                                                    <span id="statusLabelView"
                                                                        class="absent-status-badge">Absent</span>
                                                                @endif
                                                                @php $statusPrinted = true; @endphp
                                                            @endif
                                                        @endif
                                                    @elseif($status == 12)
                                                        <span id="statusLabelView"
                                                            class="{{ $badgeColors[12] }}">{{ $statusLabels[12] }}</span>
                                                        @php $statusPrinted = true; @endphp
                                                    @else
                                                        <span id="statusLabelView"
                                                            class="{{ $badgeColors[3] }}">{{ $statusLabels[3] }}</span>
                                                        @php $statusPrinted = true; @endphp
                                                    @endif
                                                @endif

                                                @if (!$statusPrinted)
                                                    @if ($status == 10)
                                                        <span id="statusLabelView"
                                                            class="{{ $badgeColors[$status] }}">{{ $leave->sort_name }}</span>
                                                    @else
                                                        <span id="statusLabelView"
                                                            class="{{ $badgeColors[$status] }}">{{ $statusLabels[$status] }}</span>
                                                    @endif
                                                @endif

                                                <?php $statusCounts[$status]++; ?>
                                            </td>

                                            <td>{{ $inTime }}
                                                @if ($lateby > 0)
                                                    <br><span class="late-status fs-10 fw-bolder">
                                                        {{ $lateby > 0 ? 'Late By: ' . (intval($lateby / 60) ? intval($lateby / 60) . ' Hr ' : '') . (intval($lateby % 60) ? intval($lateby % 60) . ' Min' : '') : '' }}
                                                    </span>
                                                @endif
                                                <small
                                                    class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                    data-bs-trigger="hover" style="background-color:transparent;"
                                                    data-bs-container="body"
                                                    data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return $log->prev_in_time . ' to ' . $log->changed_in_time . '<br/> By ' . '<b>' . $log->changer_name . ' </b>' . '(' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                    data-bs-placement="right" data-bs-popover-color="primary"
                                                    data-bs-toggle="popover" data-bs-html="true" title=""
                                                    data-bs-original-title="Attendance Log">
                                                    <i class="fa fa-info-circle"></i>
                                                </small>

                                            </td>
                                            <td>{{ $outTime }}
                                                @if ($earlyExitBy > 0)
                                                    <br><span class="late-status fs-10 fw-bolder">
                                                        {{ $earlyExitBy > 0 ? 'Early Exit By: ' . (intval($earlyExitBy / 60) ? intval($earlyExitBy / 60) . ' Hr ' : '') . (intval($earlyExitBy % 60) ? intval($earlyExitBy % 60) . ' Min' : '') : '' }}
                                                    </span>
                                                @endif

                                                <small
                                                    class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                    data-bs-trigger="hover" style="background-color:transparent;"
                                                    data-bs-container="body"
                                                    data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return $log->prev_out_time . ' to ' . $log->changed_out_time . '<br/> By ' . '<b>' . $log->changer_name . ' </b>' . '(' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                    data-bs-placement="right" data-bs-popover-color="primary"
                                                    data-bs-toggle="popover" data-bs-html="true" title=""
                                                    data-bs-original-title="Attendance Log">
                                                    <i class="fa fa-info-circle"></i>
                                                </small>
                                            </td>
                                            <td>{{ $workingHour ?? '--' }}
                                                @if ($overTime)
                                                    <br><span class="overtime-status fs-10 fw-bolder">
                                                        {{ $overTime > 0 ? 'OT: ' . (intval($overTime / 60) ? intval($overTime / 60) . ' Hr ' : '') . (intval($overTime % 60) ? intval($overTime % 60) . ' Min' : '') : '' }}
                                                    </span>
                                                @endif

                                                <small
                                                    class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                    data-bs-trigger="hover" style="background-color:transparent;"
                                                    data-bs-container="body"
                                                    data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return $log->prev_total_work . ' Hrs. to ' . $log->changed_total_work . ' Hrs. <br/> By ' . '<b>' . $log->changer_name . '</b>' . ' (' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                    data-bs-placement="right" data-bs-popover-color="primary"
                                                    data-bs-toggle="popover" data-bs-html="true" title=""
                                                    data-bs-original-title="Attendance Log">
                                                    <i class="fa fa-info-circle"></i>
                                                </small>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                @if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.Update', $permissions))
                                                    <button class="btn btn-light btn-icon btn-sm m-1"
                                                        data-name="{{ $emp->emp_name . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname }}"
                                                        data-empid="{{ $emp->emp_id }}" data-in="{{ $inTime }}"
                                                        data-out="{{ $outTime }}" data-twh="{{ $workingHour }}"
                                                        data-inloc="{{ $punchInLoc }}"
                                                        data-outloc="{{ $punchOutLoc }}"
                                                        data-shiftname="{{ $EmpShiftName }}"
                                                        data-shiftstart="{{ $EmpShiftStart }}"
                                                        data-shiftend="{{ $EmpShiftEnd }}"
                                                        data-breakmin="{{ $breakTime }}"
                                                        data-overtime="{{ $overTime }}"
                                                        data-inselfie="{{ $inSelfie }}"
                                                        data-outselfie="{{ $outSelfie }}"
                                                        data-punchdate="{{ date('d-M-Y', strtotime(date($day . '-M-Y'))) }}"
                                                        onclick="correctionModalJs(this)">
                                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </button>
                                                @endif
                                                <a class="btn btn-light btn-icon btn-sm m-1"
                                                    data-in="{{ $inTime }}" data-out="{{ $outTime }}"
                                                    data-twh="{{ $workingHour }}" data-inloc="{{ $punchInLoc }}"
                                                    data-outloc="{{ $punchOutLoc }}"
                                                    data-shiftname="{{ $EmpShiftName }}"
                                                    data-breakmin="{{ $breakTime }}"
                                                    data-overtime="{{ $overTime }}"
                                                    data-inselfie="{{ $inSelfie }}"
                                                    data-outselfie="{{ $outSelfie }}"
                                                    data-corrected_by="{{ $CorrectedBy }}"
                                                    data-date="{{ date('Y-m-d', strtotime($punchDate)) }}"
                                                    data-shiftstart="{{ $EmpShiftStart }}"
                                                    data-shiftend="{{ $EmpShiftEnd }}"
                                                    data-emp_id="{{ $emp->emp_id }}" data-status="{{ $status }}"
                                                    data-leavename="{{ $leave->name ?? '' }}"
                                                    onclick="showPresentModal(this)">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $day++; ?>
                                    @endwhile
                                </tbody>
                            </table>

                            <script>
                                function getData(e) {
                                    let dateString = e.value;
                                    let parts = dateString.split('-');
                                    var year = parts[0];
                                    var month = parts[1];
                                    var tBody = document.getElementById('attendanceBody');
                                    var empId = e.getAttribute('data-empid');

                                    var earlyCount = document.getElementById('getEarlyCount');
                                    var presentCount = document.getElementById('getPresentCount');
                                    var absentCount = document.getElementById('getAbsentCount');
                                    var halfDayCount = document.getElementById('getHalfDayCount');
                                    var lateCount = document.getElementById('getLateCount');
                                    var holidayCount = document.getElementById('getHolidayCount');
                                    var misPunchCount = document.getElementById('getMisPunchCount');
                                    var leaveRemainCount = document.getElementById('getLeaveRemainCount');

                                    // work hour
                                    var cwhCount = document.getElementById('getcwhCount');
                                    var twhCount = document.getElementById('gettwhCount');
                                    // remaining hour
                                    var rwhCount = document.getElementById('getrwhCount');
                                    var trwhCount = document.getElementById('gettrwhCount');
                                    // overtime hour
                                    var otwhCount = document.getElementById('getotwhCount');
                                    var totwhCount = document.getElementById('gettotwhCount');
                                    // ptogress bar
                                    var progress1 = document.getElementById('progress1');
                                    var progress2 = document.getElementById('progress2');
                                    var progress3 = document.getElementById('progress3');


                                    $.ajax({
                                        url: "{{ url('/admin/attendance/attendance_by_calculation') }}",
                                        type: "POST",
                                        data: {
                                            month: month,
                                            year: year,
                                            emp_id: empId,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        dataType: 'json',
                                        success: function(result) {

                                            var hourCount = result[0];
                                            var counts = result[3];

                                            presentCount.innerHTML = counts['present'];
                                            absentCount.innerHTML = counts['absent'];
                                            lateCount.innerHTML = counts['late'];
                                            misPunchCount.innerHTML = counts['mispunch'];
                                            holidayCount.innerHTML = counts['holiday'];
                                            halfDayCount.innerHTML = counts['halfday'];
                                            leaveRemainCount.innerHTML = counts['leave'];
                                            earlyCount.innerHTML = counts['early'];

                                            cwhCount.innerHTML = parseFloat(hourCount[1]).toFixed(2);
                                            twhCount.innerHTML = hourCount[0];
                                            progress1.innerHTML = parseFloat(hourCount[2]).toFixed(2) + '%';
                                            progress1.style.width = hourCount[2] + '%';

                                            rwhCount.innerHTML = parseFloat(hourCount[6]).toFixed(2);
                                            trwhCount.innerHTML = hourCount[0];
                                            progress2.innerHTML = parseFloat(hourCount[7]).toFixed(2) + '%';
                                            progress2.style.width = hourCount[7] + '%';

                                            otwhCount.innerHTML = parseFloat(hourCount[4]).toFixed(2);
                                            totwhCount.innerHTML = hourCount[3];
                                            progress3.innerHTML = parseFloat(hourCount[5]).toFixed(2) + '%';
                                            progress3.style.width = hourCount[5] + '%';


                                            // elements.sort((a, b) => a.date - b.date);
                                            var employeeElements = result[1].sort((a, b) => new Date(a.date) - new Date(b.date));

                                            tBody.innerHTML = ''; // Clear the existing content
                                            var key = 0;
                                            const uniqueDatesSet = new Set();

                                            var statusLabels = {
                                                0: 'Present',
                                                1: 'Present',
                                                2: 'Absent',
                                                3: 'Present',
                                                4: 'Mispunch',
                                                5: 'Working',
                                                6: 'Holiday',
                                                7: 'Week Off',
                                                8: 'Halfday',
                                                9: 'Present',
                                                10: 'Paid Leave',
                                                11: 'Unpaid Leave',
                                                12: 'Present',
                                            };

                                            var badgeColors = {
                                                0: 'present-status-badge',
                                                1: 'present-status-badge',
                                                2: 'absent-status-badge',
                                                3: 'present-status-badge',
                                                4: 'mispunch-status-badge',
                                                5: 'present-status-badge',
                                                6: 'holiday-status-badge',
                                                7: 'weekoff-status-badge',
                                                8: 'halfday-status-badge',
                                                9: 'present-status-badge',
                                                10: 'present-status-badge',
                                                11: 'leave-status-badge',
                                                12: 'present-status-badge',
                                            };

                                            employeeElements.forEach(element => {

                                                const currentDate = new Date(element.date);
                                                const currentDateStr = currentDate.toISOString();

                                                if (!uniqueDatesSet.has(currentDateStr)) {
                                                    uniqueDatesSet.add(currentDateStr);
                                                    var date = element.date;

                                                    var newElement = '<tr>' +
                                                        '<td>' + (++key) + '</td>' +
                                                        '<td>' + date + '</td>' +
                                                        '<td>' + element.dayName + '</td>' +
                                                        '<td>' +
                                                        '<span id="statusLabelView" class="' + badgeColors[element
                                                            .status] + '">' +
                                                        statusLabels[element.status] +
                                                        '</span>' +
                                                        '</td>' +
                                                        '<td>' + element.in + `<small id="inTime` + date + `" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                            data-bs-container="body"
                                                            data-bs-content="Content."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html=true title="Title"><i
                                                                class="fa fa-info-circle"></i></small>` +
                                                        (element.late > 0 ?
                                                            `<br><span class="late-status fs-11 fw-bolder">
                                                    Late By: ${element.late > 0 ?
                                                        `${Math.floor(element.late / 60)} Hr ${element.late % 60} Min` :
                                                        ''}
                                                </span>` :
                                                            '') +
                                                        '</td>' +
                                                        '<td>' + element.out + `<small id="outTime` + date + `" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                            data-bs-container="body"
                                                            data-bs-content="Content."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html=true title="Title"><i
                                                                class="fa fa-info-circle"></i></small>` +
                                                        (element.early > 0 ?
                                                            `<br><span class="late-status fs-11 fw-bolder">
                                                        Early Exit By: ${element.early > 0 ?
                                                            `${Math.floor(element.early / 60)} Hr ${element.early % 60} Min` :
                                                            ''}
                                                    </span>` :
                                                            '') +
                                                        '</td>' +
                                                        '<td>' +
                                                        (element.workingHour || '--') + `<small id="workingHour` + date + `" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                            data-bs-container="body"
                                                            data-bs-content="Content."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html=true title="Title"><i
                                                                class="fa fa-info-circle"></i></small>` + (element
                                                            .overtime > 0 ?
                                                            `<br><span class="overtime-status fs-11 fw-bolder"> OT: ${element.overtime > 0 ? `${Math.floor(element.overtime / 60)} Hr ${element.overtime % 60} Min` : ''}</span>` :
                                                            '') +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<a class="btn btn-light btn-icon btn-sm" data-name="{{ $emp->emp_name . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname }}"' +
                                                        'data-empid="' + empId + '" data-in="' + element.in + '"' +
                                                        'data-out="' + element.out + '" data-twh="' + element.workingHour +
                                                        '"' +
                                                        'data-inloc="{{ $punchInLoc }}" data-outloc="{{ $punchOutLoc }}"' +
                                                        'data-shiftname="{{ $shiftName }}"' +
                                                        'data-shiftstart="{{ $shiftStartTime }}"' +
                                                        'data-shiftend="{{ $shiftEndTime }}" data-breakmin="{{ $breakTime }}"' +
                                                        'data-overtime="{{ $overTime }}" data-inselfie="{{ $inSelfie }}"' +
                                                        'data-outselfie="{{ $outSelfie }}"' +
                                                        'data-punchdate="' + date + '"' +
                                                        'onclick="correctionModalJs(this)">' +
                                                        '<i class="feather feather-edit" data-bs-toggle="tooltip"' +
                                                        ' data-original-title="View"></i>' +
                                                        ' </a>' +
                                                        '<a class="btn btn-light btn-icon btn-sm" data-in="{{ $inTime }}" ' +
                                                        'data-out="{{ $outTime }}" data-twh="{{ $workingHour }}" ' +
                                                        'data-inloc="{{ $punchInLoc }}" data-outloc="{{ $punchOutLoc }}" ' +
                                                        'data-shiftname="{{ $shiftName }}" data-breakmin="{{ $breakTime }}" ' +
                                                        'data-overtime="{{ $overTime }}" data-inselfie="{{ $inSelfie }}" ' +
                                                        'data-outselfie="{{ $outSelfie }}" onclick="showPresentModal(this)">' +
                                                        '<i class="feather feather-eye" data-bs-toggle="tooltip" ' +
                                                        'data-original-title="View"></i>' +
                                                        '</a>' +
                                                        '</td>' +
                                                        '</tr>';

                                                    tBody.innerHTML += newElement;

                                                }

                                                $('[data-bs-toggle="popover"]').popover({
                                                    trigger: 'hover'
                                                });

                                            });
                                            setTimeLog(result[2]);
                                        }
                                    });

                                }

                                function updatePopover(idPrefix, element, prevValue, changedValue) {
                                    var pop = document.getElementById(idPrefix + element.punch_date);
                                    pop.classList.remove('d-none');
                                    pop.setAttribute('data-bs-original-title', 'Attendance Log of ' + element.punch_date);
                                    pop.setAttribute('data-bs-content',
                                        `From ${prevValue} to ${changedValue}<br/> By <b>${element.changer_name}</b> (${element.changer_role})<br/>at ${element.change_date}<br><b>${element.reason}</b>`
                                    );

                                    var popoverInstance = new bootstrap.Popover(pop);
                                    popoverInstance.update();
                                }

                                function setTimeLog(Log) {

                                    Log.forEach(element => {
                                        updatePopover('workingHour', element, element.prev_total_work, element.changed_total_work);
                                        updatePopover('outTime', element, element.prev_out_time, element.changed_out_time);
                                        updatePopover('inTime', element, element.prev_in_time, element.changed_in_time);
                                    });

                                    // Log.forEach(element => {
                                    //     var workinPop = document.getElementById('workingHour' + element.punch_date);

                                    //     workinPop.classList.remove('d-none');
                                    //     workinPop.setAttribute('data-bs-original-title', 'Attendance Log of ' + element
                                    //         .punch_date); // title content
                                    //     workinPop.setAttribute('data-bs-content', 'From ' + element.prev_total_work + ' to ' + element
                                    //         .changed_total_work + '<br/> By ' + '<b>' + element.changer_name + '</b>' + '(' + element
                                    //         .changer_role +
                                    //         ')' + '<br/>at ' + element.change_date + '<br>' + '<b>' + element.reason + '</b>' +
                                    //         ); // title content
                                    //     var popoverInstance = new bootstrap.Popover(workinPop);
                                    //     popoverInstance.update();

                                    //     var outPop = document.getElementById('outTime' + element.punch_date);
                                    //     outPop.classList.remove('d-none');
                                    //     outPop.setAttribute('data-bs-original-title', 'Attendance Log of ' + element
                                    //         .punch_date); // title content
                                    //     outPop.setAttribute('data-bs-content', 'From ' + element.prev_out_time + ' to ' + element
                                    //         .changed_out_time + '<br/> By ' + '<b>' + element.changer_name + '</b>' + '(' + element
                                    //         .changer_role + ')' +
                                    //         '<br/>at ' + element.change_date + '<br>' + '<b>' + element.reason + '</b>' +
                                    //         ); // title content
                                    //     var popoverInstance1 = new bootstrap.Popover(outPop);
                                    //     popoverInstance1.update();


                                    //     var inPop = document.getElementById('inTime' + element.punch_date);
                                    //     inPop.classList.remove('d-none');
                                    //     inPop.setAttribute('data-bs-original-title', 'Attendance Log of ' + element
                                    //         .punch_date); // title content
                                    //     inPop.setAttribute('data-bs-content', 'From ' + element.prev_in_time + ' to ' + element
                                    //         .changed_in_time + '<br/> By ' + '<b>' + element.changer_name + '</b>' + '(' + element
                                    //         .changer_role + ')' +
                                    //         '<br/>at ' + element.change_date + '<br>' + '<b>' + element.reason + '</b>' +
                                    //         ); // title content
                                    //     var popoverInstance2 = new bootstrap.Popover(inPop);
                                    //     popoverInstance2.update();
                                    // });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->
        <!-- EDIT MODAL -->
        <div class="modal fade" id="correctAttendance">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="correctionEmpID">EIDXXX</span> - <span
                                id="correctionEmpName">Aman
                                Sahu</span> (<span id="correctionDate"> 05-Jul-2023 </span>) </h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('correctPunchTime') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-5">
                                    <span class="my-5"><span class="fw-bold fs-14">Shift Name : </span><span
                                            id="shiftName">N/A</span></span><br>
                                    <span class="my-5"><span class="fw-bold fs-14">Start : </span><span
                                            id="ShiftStart">N/A</span><br><span class="fw-bold fs-14">End : </span><span
                                            id="ShiftEnd"> N/A</span></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Punch In</label>
                                        <div class="input-group">
                                            <input type="text" id="punchInTime" name="in_time"
                                                class="form-control timepicker" value="9:30 AM">
                                            <div class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Punch Out</label>
                                        <div class="input-group">
                                            <input type="text" id="punchOutTime" name="out_time"
                                                class="form-control timepicker" value="06:30 PM">
                                            <div class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Reason</label>
                                        <div class="input-group">
                                            <textarea rows="3" class="form-control" name="reason" placeholder="Enter Reason" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input id="empID" name="emp_id" type="text" hidden>
                            {{-- <input id="inTime" name="in_time" type="text" hidden>
                        <input id="outTime" name="out_time" type="text" hidden> --}}
                            <input id="punchDate" name="punch_date" type="text" hidden>
                        </div>
                        <div class="modal-footer d-flex">
                            <div class="ms-auto">
                                @if (in_array('Attendance Summary.Update', $permissions) || in_array('Attendance Summary.All', $permissions))
                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function correctionModalJs(e) {
                var Name = $(e).data('name');
                var EmpId = $(e).data('empid');
                var inTime = $(e).data('in');
                var outTime = $(e).data('out');
                var shiftName = $(e).data('shiftname');
                var shiftStart = $(e).data('shiftstart');
                var shiftEnd = $(e).data('shiftend');
                var punchDate = $(e).data('punchdate');



                $('#correctAttendance').modal('show');
                $('#correctionEmpID').html(EmpId);
                $('#correctionEmpName').html(Name);
                $('#correctionDate').html(punchDate);
                $('#shiftName').html(shiftName);
                $('#ShiftStart').html(shiftStart);
                $('#ShiftEnd').html(shiftEnd);
                $('#punchInTime').val(inTime);
                $('#punchOutTime').val(outTime);

                $('#inTime').val(inTime);
                $('#outTime').val(outTime);
                $('#empID').val(EmpId);
                $('#punchDate').val(punchDate);
            }
        </script>
        <!-- END EDIT MODAL  -->
        <!-- PRESENT MODAL -->
        <div class="modal fade" id="presentmodal">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                                <div class="card-header border-bottom-0 d-block">
                                    <h5 class="">Timesheet: <span class="fs-14 mx-3 text-muted"
                                            id="punchDateTime"></span></h5>
                                    <h6 class=""><span class="fs-14 text-dark" id="attendanceShiftName">Fixed
                                            Shift</span><span class="fs-14 mx-3 text-muted"
                                            id="attendanceShiftStart">09:00 AM</span><span
                                            class="fs-14 text-muted">To</span><span class="fs-14 mx-3 text-muted"
                                            id="attendanceShiftEnd">06:00
                                            PM</span></h6>
                                </div>

                                <div class="col-sm-12 my-auto" style="height: 260px">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="p-3 text-center border border-muted">
                                                <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchIn">12:00</h6>
                                                <small class="text-muted fs-14">Punch In</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="chart-circle chart-circle-md" data-value="100" data-thickness="8"
                                                data-color="#0dcd94" style="border:solid 5px #1877f2; border-radius:50px">
                                                <div class="chart-circle-value text-muted" id="modalWorkingHr">09:05 hrs
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-3 text-center border border-muted">
                                                <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchOut">12:00</h6>
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
                                                                class="text-muted fs-12" id="inLocField"><i
                                                                    class="fa fa-map-marker mx-1"></i><span
                                                                    id="inLocation"></span></span>
                                                            <br /><span class="tl-title" id="inCorrectionHead"></span>
                                                        <p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="#" data-imgin='' id="showInSelfie"
                                                            onclick="showSelfie(this)" class="my-auto">
                                                            <span class="avatar avatar-sm brround" id="showInSelfieBg"
                                                                style="border : solid 1px #1877f2"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-header d-none" id="tapList">
                                                <div class="row">
                                                    <p>
                                                    <div class="col-10" style="overflow: scroll; height:7rem">
                                                        <p class="tl-title" id="TapListItem">

                                                        <p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-header d-none" id="timeline2">
                                                <span class="tl-marker"></span>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="tl-title">Punch Out at <span id="punchOutAt"></span>
                                                            |<span class="shiftName"></span> <br><span
                                                                class="text-muted fs-12" id="outLocField"><i
                                                                    class="fa fa-map-marker mx-1"></i><span
                                                                    id="punchOutLocation"></span></span>
                                                            <br /><span class="tl-title" id="outCorrectionHead"></span>
                                                        <p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="#" data-imgout='' id="showOutSelfie"
                                                            onclick="showSelfie(this)" class="my-auto">
                                                            <span class="avatar avatar-sm brround" id="showOutSelfieBg"
                                                                style="border : solid 1px #1877f2"></span>
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
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">close</a>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PRESENT MODAL -->

        {{-- Punch Image --}}
        <div class="modal fade" id="PunchIn">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <img id="inSelfie" src="" alt="">
                </div>
            </div>
        </div>
        <div class="modal fade" id="PunchOut">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <img id="outSelfie" src="" alt="">
                </div>
            </div>
        </div>

        <div class="modal fade" id="holidayModal">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Details</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-header border-bottom-0 d-block">
                                    <h5 class="">Timesheet: <span class="fs-14 mx-3 text-muted"
                                            id="punchDateTime2">{{ date('d-M-y h:i a') }}</span></h5>
                                    <h6 class=""><span class="fs-14 text-dark" id="holidayShiftName">Fixed
                                            Shift</span><span class="fs-14 mx-3 text-muted" id="holidayShiftStart">09:00
                                            AM</span><span class="fs-14 text-muted">To</span><span
                                            class="fs-14 mx-3 text-muted" id="holidayShiftEnd">06:00
                                            PM</span></h6>
                                </div>
                                <div class="col-sm-12 my-auto" style="height: 200px">
                                    <div class="row">
                                        <div class="col-xl-12 my-3 text-center">
                                            <h4 class="mt-5 fw-bold py-3" style="color:#1877f2; border:solid 1px #d0d6df;"
                                                id="HolidayOrWeekOff">Holiday
                                            </h4>
                                        </div>
                                        <div class="col-xl-12 text-center">
                                            <span class="fs-16" id="holidayLine">Due to the <span
                                                    id="HolidayName">N/A</span>, Office is not Functioning.</span>
                                            <span class="fs-16" id="leaveLine">The Employee has applied for <span
                                                    id="LeaveName">N/A</span>.</span>
                                        </div>

                                        {{-- <p class="mt-5" id="leaveRemark"><b>Remark:- </b> <span
                                                id="RemarkComment"></span></p> --}}
                                        {{-- <div class="form-group col" id="leaveRemark">
                                            <label for="inputPassword4" class=""><b>Reason</b></label>
                                            <textarea class="form-control text-muted" id="RemarkComment" rows="2" value="" readonly></textarea>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">close</a>
                        {{-- <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showPresentModal(context) {

                var empID = $(context).data('emp_id');
                var date = $(context).data('date');
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
                var corrected_by = $(context).data('corrected_by');
                var shiftStart = $(context).data('shiftstart');
                var shiftEnd = $(context).data('shiftend');
                var leaveName = $(context).data('leavename');


                $.ajax({
                    type: "POST",
                    url: "{{ route('employeeHoliday') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        date: date,
                        emp_id: empID,
                    },
                    success: function(result) {
                        TapListPrint(result[2]);
                        if (Status == 10 || Status == 11) {
                            $('#holidayLine').addClass('d-none');
                            $('#leaveRemark').removeClass('d-none');
                            $('#leaveLine').removeClass('d-none');
                            $('#LeaveName').html(result[1].name || leaveName);
                            $('#RemarkComment').html(result[1].reason || '');
                        } else {
                            $('#leaveLine').addClass('d-none');
                            $('#holidayLine').removeClass('d-none');
                            if (Status == 7) {
                                $('#HolidayName').html(result[0].day + ' ' + result[0].name);
                            } else {
                                $('#HolidayName').html(result[0].name + ' celebration');
                            }
                            $('#leaveRemark').addClass('d-none');
                        }
                    }
                });

                $('#LeaveName').html(leaveName);

                if (!inLoc) {
                    $('#inLocField').addClass('d-none');
                }

                if (!outLoc) {
                    $('#outLocField').addClass('d-none');
                }

                if (!outTime) {
                    $('#timeline2').addClass('d-none');
                }

                if (!inTime) {
                    $('#timeline1').addClass('d-none');
                }
                $('#punchDateTime').html(date);
                $('#punchDateTime2').html(date);

                var Status = $(context).data('status');
                if (Status == 6 || Status == 7 || Status == 10 || Status == 11) {
                    $('#holidayModal').modal('show');
                    if (Status == 6) {
                        $('#HolidayOrWeekOff').html('Holiday');
                    } else if (Status == 7) {
                        $('#HolidayOrWeekOff').html('WeekOff');
                    } else if (Status == 10 || Status == 11) {
                        $('#HolidayOrWeekOff').html('Leave');
                    }


                    $('#holidayShiftName').html(shiftName);
                    $('#holidayShiftStart').html(shiftStart);
                    $('#holidayShiftEnd').html(shiftEnd);
                } else if (Status == 2 || Status == 0) {
                    Swal.fire({
                        // title: 'No Data Found',
                        timer: 3000,
                        timerProgressBar: true,
                        text: 'No Data Found.',
                        icon: 'error',
                    });
                } else {
                    $('#presentmodal').modal('show');
                    $('#attendanceShiftName').html(shiftName);
                    $('#attendanceShiftStart').html(shiftStart);
                    $('#attendanceShiftEnd').html(shiftEnd);
                }


                $('#inCorrectionHead').html(corrected_by ? 'Corrected By: <span class="text-primary" id="inCorrectionLine">' +
                    corrected_by + '</span>' : '');
                $('#outCorrectionHead').html(corrected_by ? 'Corrected By: <span class="text-primary" id="outCorrectionLine">' +
                    corrected_by + '</span>' : '');

                if (inTime != '--') {
                    $('#timeline1').removeClass('d-none');
                }
                if (outTime != '--') {
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
            }

            function TapListPrint(e) {
                var section = document.getElementById('tapList');
                var tapItemList = document.getElementById('TapListItem');

                if (e === null || e.length === 0) {
                    section.classList.add('d-none');
                } else {
                    section.classList.remove('d-none');
                    var key = 0;
                    $(tapItemList).html('');
                    e.forEach(element => {
                        $(tapItemList).append('<span class="text-dark fs-11 my-1" id="">Tap ' + (++key) +
                            ' : </span><span class="text-primary fs-11" id=""><i class="fa fa-map-marker mx-1"></i><span class="fw-thin" id="">' +
                            element.address + '</span></span><br/>');
                    });
                }
            }


            function showSelfie(context) {

                if (context.id === 'showInSelfie') {
                    var inSelfie = context.getAttribute('data-imgin');
                    var inSelfieURL = "{{ asset('/upload_image/') }}" + "/" + inSelfie;
                    $("#inSelfie").attr("src", inSelfieURL);
                    $('#PunchIn').modal('show');

                }

                if (context.id === 'showOutSelfie') {
                    var outSelfie = context.getAttribute('data-imgout');
                    var outSelfieURL = "{{ asset('/upload_image/') }}" + "/" + outSelfie;
                    $("#outSelfie").attr("src", outSelfieURL);
                    $('#PunchOut').modal('show');

                }

            }
        </script>

    @endsection
@endif
