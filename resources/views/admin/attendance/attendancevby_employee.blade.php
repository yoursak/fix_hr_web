@extends('admin.pagelayout.master')

@section('title')
    Employee Attendance Detail
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
    </style>
@endsection

@section('js')
    <!-- CIRCLE-PROGRESS JS -->

    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>

    <!-- INTERNAL INDEX JS -->
@endsection

@section('css')
@endsection

@section('content')

    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/leaves') }}">Attendance</a></li>
            <li class="active"><span><b>Attendance By</b></span></li>
        </ol>
    </div>
    @php
        $root = new App\Helpers\Central_unit();
        $byAttendanceCalculation = $root->attendanceByEmpDetails($emp->emp_id, date('Y'), date('m'));
        $allStatusCount = $root->attendanceCount($emp->emp_id, date('Y'), date('m'));

        // dd($allStatusCount);
    @endphp

    <!-- PAGE HEADER -->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Attendance By <span class="text-primary">{{ $emp->emp_name }} ({{ $emp->emp_id }})</span>
            </div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="btn-list">
                    <a href="hr-attmark.html" class="btn btn-primary me-3">Mark Attendance</a>
                    <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="E-mail"> <i
                            class="feather feather-mail"></i> </button>
                    <button class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip" title="Contact"> <i
                            class="feather feather-phone-call"></i> </button>
                    <button class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip" title="Info"> <i
                            class="feather feather-info"></i> </button>
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
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-primary-transparent"
                                        id="gettwdCount">{{ $byAttendanceCalculation[0] }}</span>
                                    <h5 class="mb-0 mt-3">Total Working Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                    <span class="avatar avatar-md bradius fs-20 bg-success-transparent"
                                        id="getPresentCount">{{ $byAttendanceCalculation[1] }}</span>
                                    <h5 class="mb-0 mt-3">Present Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-danger-transparent"
                                        id="getAbsentCount">{{ $byAttendanceCalculation[2] }}</span>
                                    <h5 class="mb-0 mt-3">Absent Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-warning-transparent"
                                        id="getHalfDayCount">{{ $byAttendanceCalculation[7] }}</span>
                                    <h5 class="mb-0 mt-3">Half Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                    <span class="avatar avatar-md bradius fs-20 bg-orange-transparent"
                                        id="getLateCount">{{ $byAttendanceCalculation[3] }}</span>
                                    <h5 class="mb-0 mt-3">Late Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-pink-transparent"
                                        id="getHolidayCount">{{ $byAttendanceCalculation[5] }}</span>
                                    <h5 class="mb-0 mt-3">Holidays</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-pink-transparent"
                                        id="getMisPunchCount">{{ $byAttendanceCalculation[4] }}</span>
                                    <h5 class="mb-0 mt-3">Mis-punch</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-pink-transparent"
                                        id="getLeaveRemainCount">{{ $byAttendanceCalculation[9] }}</span>
                                    <h5 class="mb-0 mt-3">Remaining Leave</h5>
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
                                    <h6><b><span id="getcwhCount">{{ number_format($byAttendanceCalculation[10]) }}</span> hr / <span
                                                id="gettwhCount">{{ number_format($byAttendanceCalculation[11]) }}</span> hr</b></h6>
                                </div>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-yellow"
                                        id="progress1" style="width: {{ number_format($byAttendanceCalculation[12]) }}%">
                                        {{ number_format($byAttendanceCalculation[12]) }}%</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6>Remaining</h6>
                                    <h6><b><span id="getrwhCount">{{ number_format($byAttendanceCalculation[13]) }}</span> hr /<span
                                                id="gettrwhCount">{{ number_format($byAttendanceCalculation[14]) }}</span> hr</b></h6>
                                </div>
                                <div class="progress progress-md mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                        id="progress2" style="width: {{ $byAttendanceCalculation[15] }}%">
                                        {{ number_format($byAttendanceCalculation[15], 1) }}%</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6>Overtime</h6>
                                    <h6><b><span id="getotwhCount">{{ number_format($byAttendanceCalculation[16]) }}</span> hr/<span
                                                id="gettotwhCount">{{ number_format($byAttendanceCalculation[17]) }}</span> hr</b></h6>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                        id="progress3" style="width: {{ $byAttendanceCalculation[18] }}%">
                                        {{ number_format($byAttendanceCalculation[18]) }}%
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="leavesoverview" class="mx-auto pt-2"></div>
                    <div class="row mx-auto text-center">
                        <div class="col-12 mx-auto d-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex font-weight-semibold">
                                        <span class="dot-label bg-success me-2 my-auto"></span>Paid Leaves ({{$allStatusCount[10]}})
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex font-weight-semibold">
                                        <span class="dot-label badge-danger me-2 my-auto"></span>Unpaid Leaves ({{$allStatusCount[11]}})
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap border-bottum" id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0">Day</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Punch In</th>
                                    <th class="border-bottom-0">Punch Out</th>
                                    <th class="border-bottom-0">Working Hour</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    
                                    $sno = 0;
                                    $totalTwhMin = 0;
                                    $totalOTMin = 0;
                                    $totalLateTime = 0;
                                    $totalEarlyExitTime = 0;
                                    $day = date('d');
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
                                        10 => 0, // Overtime
                                        11 => 0, // Overtime
                                    ];
                                @endphp

                                @while ($day > 0)
                                    {{-- @dd($day); --}}
                                    @php

                                        $resCode = $root->getEmpAttSumm(['emp_id' => $emp->emp_id, 'punch_date' => date('Y-m-' . $day)]);
                                        // dd($resCode[2]);
                                        $status = $resCode[0];
                                        $inTime = $resCode[1] != 0 ? date('h:i A', strtotime($resCode[1])) : 'Not Mark';
                                        $outTime = $resCode[2] != 0 ? date('h:i A', strtotime($resCode[2])) : 'Not Mark';
                                        $workingHour = $resCode[1] && $resCode[2] ? $resCode[3] : '00:00';
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
                                        $totalTwhMin += $twhMin;
                                        $totalOTMin += $overTime;
                                        $totalEarlyExitTime += $earlyExitBy;
                                        $totalLateTime += $lateby;
                                        $totalDayinMonth = date('t');
                                        // dd($leaveDetails);
                                    @endphp
                                    <tr>
                                        <td>{{ ++$sno }}</td>
                                        <td>{{ date($day . '-M-Y') }}</td>
                                        <td>{{ date('l', strtotime(date($day . '-M-Y'))) }}</td>

                                        <td>
                                            @php
                                                $statusLabels = [
                                                    1 => 'Present',
                                                    2 => 'Absent',
                                                    3 => 'Present',
                                                    4 => 'Mispunch',
                                                    5 => 'Working',
                                                    6 => 'Holiday',
                                                    7 => 'Week Off',
                                                    8 => 'Halfday',
                                                    9 => 'Present',
                                                    10 => 'Paid Leave',
                                                    11 => 'Unpaid Leave',
                                                ];
                                                $badgeColors = [
                                                    1 => 'success',
                                                    2 => 'danger',
                                                    3 => 'success',
                                                    4 => 'secondary',
                                                    5 => 'secondary',
                                                    6 => 'primary',
                                                    7 => 'primary',
                                                    8 => 'danger',
                                                    9 => 'success',
                                                    10 => 'success',
                                                    11 => 'danger',
                                                ];
                                            @endphp

                                            @php
                                                $earlyOccurrenceIs = $occurance[0];
                                                $earlyOccurrence = $occurance[1];
                                                $earlyOccurrencePenalty = $occurance[2];

                                                $lateOccurrenceIs = $occurance[3];
                                                $lateOccurrence = $occurance[4];
                                                $lateOccurrencePenalty = $occurance[5];

                                                $statusPrinted = false;
                                            @endphp

                                            @if ($status == 3)
                                                @if ($lateOccurrenceIs == 1)
                                                    @if ($allStatusCount[3] >= $lateOccurrence)
                                                        @if ($lateOccurrencePenalty == 1)
                                                            <span id="statusLabelView"
                                                                class="badge badge-danger-light">Halfday</span>
                                                        @else
                                                            <span id="statusLabelView"
                                                                class="badge badge-danger-light">Absent</span>
                                                        @endif
                                                        @php $statusPrinted = true; @endphp
                                                    @endif
                                                @elseif ($totalLateTime >= $lateOccurrence)
                                                    @if ($lateOccurrencePenalty == 1)
                                                        <span id="statusLabelView"
                                                            class="badge badge-danger-light">Halfday</span>
                                                    @else
                                                        <span id="statusLabelView"
                                                            class="badge badge-danger-light">Absent</span>
                                                    @endif
                                                    @php $statusPrinted = true; @endphp
                                                @endif

                                                @if ($earlyOccurrenceIs == 1 && !$statusPrinted)
                                                    @if ($allStatusCount[3] >= $earlyOccurrence)
                                                        @if ($earlyOccurrencePenalty == 1)
                                                            <span id="statusLabelView"
                                                                class="badge badge-danger-light">Halfday</span>
                                                        @else
                                                            <span id="statusLabelView"
                                                                class="badge badge-danger-light">Absent</span>
                                                        @endif
                                                        @php $statusPrinted = true; @endphp
                                                    @endif
                                                @elseif ($totalEarlyExitTime >= $earlyOccurrence && !$statusPrinted)
                                                    @if ($earlyOccurrencePenalty == 1)
                                                        <span id="statusLabelView"
                                                            class="badge badge-danger-light">Halfday</span>
                                                    @else
                                                        <span id="statusLabelView"
                                                            class="badge badge-danger-light">Absent</span>
                                                    @endif
                                                    @php $statusPrinted = true; @endphp
                                                @endif
                                            @endif

                                            @if (!$statusPrinted)
                                                <span id="statusLabelView"
                                                    class="badge badge-{{ $badgeColors[$status] }}-light">{{ $statusLabels[$status] }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $inTime }}
                                            @if ($lateby > 0)
                                                <br><span class="badge badge-danger-light">
                                                    {{ $lateby > 0 ? 'Late By: ' . (intval($lateby / 60) ? intval($lateby / 60) . ' Hr ' : '') . (intval($lateby % 60) ? intval($lateby % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif

                                        </td>
                                        <td>{{ $outTime }}
                                            @if ($earlyExitBy > 0)
                                                <br><span class="badge badge-danger-light">
                                                    {{ $earlyExitBy > 0 ? 'Early Exit By: ' . (intval($earlyExitBy / 60) ? intval($earlyExitBy / 60) . ' Hr ' : '') . (intval($earlyExitBy % 60) ? intval($earlyExitBy % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $workingHour ?? '00:00' }}
                                            @if ($overTime)
                                                <br><span class="badge badge-secondary-light">
                                                    {{ $overTime > 0 ? 'Overtime: ' . (intval($overTime / 60) ? intval($overTime / 60) . ' Hr ' : '') . (intval($overTime % 60) ? intval($overTime % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif

                                        </td>
                                        <td>
                                            <a class="btn btn-light btn-icon btn-sm" data-in="{{ $inTime }}"
                                                data-out="{{ $outTime }}" data-twh="{{ $workingHour }}"
                                                data-inloc="{{ $punchInLoc }}" data-outloc="{{ $punchOutLoc }}"
                                                data-shiftname="{{ $shiftName }}" data-breakmin="{{ $breakTime }}"
                                                data-overtime="{{ $overTime }}" data-inselfie="{{ $inSelfie }}"
                                                data-outselfie="{{ $outSelfie }}" onclick="showPresentModal(this)">
                                                <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $day--; ?>
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
    <!-- PRESENT MODAL -->
    <div class="modal fade" id="presentmodal">
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
                                            <div class="chart-circle-value text-muted" id="modalWorkingHr">09:05 hrs</div>
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
                                            <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">09:30 AM</p>
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

                                        <div class="tl-header">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch In at <span id="puchInAt"></span> | <span
                                                            class="shiftName"></span><br><span class="text-muted fs-12"><i
                                                                class="fa fa-map-marker mx-1"></i><span
                                                                id="inLocation"></span></span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <a href="#" data-imgin='' id="showInSelfie"
                                                        onclick="showSelfie(this)" class="my-auto">
                                                        <span class="avatar avatar-sm brround" id="showInSelfieBg"
                                                            style="background-image: url(assets/images/users/1.jpg)"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tl-header">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch Out at <span id="punchOutAt"></span> |<span
                                                            class="shiftName"></span> <br><span
                                                            class="text-muted fs-12"><i
                                                                class="fa fa-map-marker mx-1"></i><span
                                                                id="punchOutLocation"></span></span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <a href="#" data-imgout='' id="showOutSelfie"
                                                        onclick="showSelfie(this)" class="my-auto">
                                                        <span class="avatar avatar-sm brround" id="showOutSelfieBg"
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
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a>
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
    <script>
        function showPresentModal(context) {
            $('#presentmodal').modal('show');
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

        function showSelfie(context) {            

            if (context.id === 'showInSelfie') {
                var inSelfie = context.getAttribute('data-imgin');
                var inSelfieURL = "{{ asset('/upload_image/') }}" + "/" + inSelfie;
                $("#inSelfie").attr("src", inSelfieURL);
                $('#PunchIn').modal('show');
                // console.log(inSelfie);
            }

            if (context.id === 'showOutSelfie') {
                var outSelfie = context.getAttribute('data-imgout');
                var outSelfieURL = "{{ asset('/upload_image/') }}" + "/" + outSelfie;
                $("#outSelfie").attr("src", outSelfieURL);
                $('#PunchOut').modal('show');
                // console.log(outSelfie);
            }

        }
    </script>
    <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chart/chart.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/chart/utils.js') }}"></script>
		<script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}"></script>
@endsection
