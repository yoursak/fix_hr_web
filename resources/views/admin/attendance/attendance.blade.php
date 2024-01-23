@extends('admin.pagelayout.master')

@section('title')
    Daily Attendance
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

@section('css')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- INTERNAl BOOTATRAP-TIMEPICKER JS -->
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>

    <!-- INTERNAL  DATEPICKER JS -->
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>

    {{-- <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>
@endsection
@section('content')
    @php
        // dd($DATA);
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $i = 0;
        $j = 1;
        $Designation = $centralUnit->DesignationList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $Count = $centralUnit->AttendanceGetCount();
        $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement(); // Create an instance of the Central_unit class

    @endphp
    <!-- ROW -->

    <div class=" p-0 pb-4">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="active"><span><b>Attendance</b></span></li>
        </ol>
    </div>
    <div class="row">
        @php
            use App\Models\PolicySettingRoleAssignPermission;
            use App\Models\PolicySettingRoleCreate;
            use App\Models\StaticStatusAttendance;

            $root = new App\Helpers\Central_unit();
            $AttList = $root->GetAttDetails();
            $DailyCount = $root->getDailyCountForDashboardAndDailyList(Session::get('business_id'), date('Y-m-d'));
            $nss = new App\Helpers\Central_unit();
            $EmpID = $nss->EmpPlaceHolder();
            $LeaveCount = $nss->LeaveSectionCount();
            // dd($DailyCount);
        @endphp
        <div class="col-xl-9 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Days Overview</h4>
                </div>
                <div class="card-body pt-0 pb-3">
                    <div class="row mb-0 pb-0">
                        <div class="col-6 col-md-4 col-xl-2 text-center py-5">
                            <span class="avatar avatar-md bradius fs-20 bg-primary-transparent"
                                id="totalEmployeeCount">{{ $DailyCount['totalEmp'] }}</span>
                            <h5 class="mb-0 mt-3">Total Employee</h5>
                        </div>
                        <div class=" col-6 col-md-4 col-xl-2 text-center py-5 ">
                            <span class="avatar avatar-md bradius fs-20 bg-success-transparent"
                                id="presentEmployeeCount">{{ $DailyCount['present'] }}</span>
                            <h5 class="mb-0 mt-3">Present</h5>
                        </div>
                        <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                            <span class="avatar avatar-md bradius fs-20 bg-danger-transparent"
                                id="absentEmployeeCount">{{ $DailyCount['absent'] }}</span>
                            <h5 class="mb-0 mt-3">Absent</h5>
                        </div>
                        <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                            <span class="avatar avatar-md bradius fs-20 bg-warning-transparent"
                                id="halfdayEmployeeCount">{{ $DailyCount['halfday'] }}</span>
                            <h5 class="mb-0 mt-3">Half Days</h5>
                        </div>
                        <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5 ">
                            <span class="avatar avatar-md bradius fs-20 bg-orange-transparent"
                                id="lateEmployeeCount">{{ $DailyCount['late'] }}</span>
                            <h5 class="mb-0 mt-3">Late</h5>
                        </div>
                        <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                            <span class="avatar avatar-md bradius fs-20 bg-pink-transparent"
                                id="leaveEmployeeCount">{{ $DailyCount['overtime'] }}</span>
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
                        <label class="form-label">Pending Approvals for {{ $approvalPendingCount }} days</label>
                    </div>
                    <form action="{{ route('attendanceMark.checkboxUpdate') }}" method="POST">
                        @csrf
                        <div class="btn-list text-center mt-5 mb-5">
                            <button type="submit" class="btn ripple btn-primary" name="pendingAll"
                                value="{{ $approvalPendingCount }}">Approve</button>
                            {{-- <a href="javascript:void(0);" class="btn ripple btn-primary disabled">Punch Out</a> --}}
                        </div>
                    </form>
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
                                        <p class="form-label">Branch</p>
                                        <select name='branch_id' id="country-dd" class="form-control">
                                            <option value="">Select Branch Name</option>
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
                                            <select id="state-dd" name="department_id" class="form-control">
                                                <option value="">Select Deparment Name</option>
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
                                            <select id="desig-dd" name="designation_id" class="form-control">
                                                <option value="">Select Designation Name</option>
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
                                        <label class="form-label">Select Date:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" id="dateselect-dd"
                                                name="date_select_name" placeholder="DD-MM-YYYY" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-checkallcol-md-12 col-lg-2 ">
                            <div class="d-flex float-end ">
                                <label class="custom-control custom-checkbox-md me-5 p-0">
                                    <input type="checkbox" class="custom-control-input-success"
                                        onclick="checkbox_dd(this)" name="example-checkbox1" value="option1">
                                    <span class="custom-control-label-md success"></span>
                                </label>
                                <p class="pt-2"><b>Mark All</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ url('admin/attendance/attendance_mark') }}" method="POST">
                    @csrf
                    <div class="card-body  p-2 px-2">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap border-bottom " id="file-datatable">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">S.No.</th>
                                        <th class="border-bottom-0">Employee Name</th>
                                        <th class="border-bottom-0">Emp ID</th>
                                        <th class="border-bottom-0">Status</th>
                                        <th class="border-bottom-0">Date</th>
                                        <th class="border-bottom-0">Punch In</th>
                                        {{-- <th class="border-bottom-0">Atten-Mode</th> --}}
                                        <th class="border-bottom-0">Punch Out</th>
                                        <th class="border-bottom-0">Working Hour</th>
                                        {{-- <th class="border-bottom-0">Late By</th> --}}
                                        <th class="border-bottom-0">Working From</th>
                                        <th class="border-bottom-0">Attendance</th>
                                        <th class="border-bottom-0">PID</th>
                                        {{-- <th class="border-bottom-0">Approval </th> --}}
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="my_body">
                                    @php
                                        $count = 1;
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
                                            12 => 0, // Early Exit
                                        ];
                                    @endphp
                                    @foreach ($DATA as $item)
                                        @php
                                            $approval_type_id_static = 1;
                                            $centralUnit = new App\Helpers\Central_unit();
                                            $ruleMange = new App\Helpers\MasterRulesManagement\RulesManagement();
                                            $resCode = $centralUnit->getEmpAttSumm(['emp_id' => $item->emp_id, 'punch_date' => date('Y-m-d')]);
                                            $attendanceDetails = $centralUnit->getEmpAttendanceDetails($item->emp_id, date('Y-m-d'));
                                            // dd($DATA);
                                            $inTime = $attendanceDetails->punch_in_time ?? 0;
                                            $outTime = $attendanceDetails->punch_out_time ?? 0;
                                            // dd($attendanceDetails->punch_out_time);
                                            $timeDifference = $centralUnit->CalculateTimeDifference($inTime, $outTime);
                                            // dd($resCode);
                                            // $lateBy = $ruleMange->CalculateLateBy($shiftStart, $inTime, $grachTimeHr, $grachTimeMin);
                                            $hours = str_pad($timeDifference->h, 2, '0', STR_PAD_LEFT);
                                            $minutes = str_pad($timeDifference->i, 2, '0', STR_PAD_LEFT);
                                            $seconds = str_pad($timeDifference->s, 2, '0', STR_PAD_LEFT);
                                            $status = $resCode[0];
                                            $lateby = $resCode[12];
                                            $earlyExitBy = $resCode[13];
                                            $occurance = $resCode[14];
                                            // print_r($status);
                                            // print_r($outTime);
                                        @endphp
                                        <tr>

                                            <input type="text" name="emp_id[]" id="id"
                                                value="{{ $item->emp_id }}" hidden>

                                            @if ($item->final_status == 0)
                                                <input type="text" name="myAttendanceCheck[]"
                                                    id="myAttendanceCheck{{ $item->id }}" class="myAttendanceCheck"
                                                    value="<?= $item->final_status != 0 ? '1' : '0' ?>" hidden>
                                            @else
                                                <input type="text" name="myAttendanceCheck[]"
                                                    id="myAttendanceCheck{{ $item->id }}" class=""
                                                    value="<?= $item->final_status != 0 ? '1' : '0' ?>" hidden>
                                            @endif
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3 rounded-circle"
                                                        style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1 fs-14">
                                                            <a href="{{ route('employeeProfile', [$item->emp_id]) }}">
                                                                {{ $item->emp_name }}&nbsp;{{ $item->emp_mname }}&nbsp;{{ $item->emp_lname }}
                                                            </a>
                                                        </h6>
                                                        <p class="text-muted mb-0 fs-12">
                                                            <?= $nss->DesingationIdToName($item->designation_id) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->emp_id }}</td>
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
                                                        12 => 'Present',
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
                                                        10 => 'present-status-badge',
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
                                                    // dd($occurance);
                                                @endphp

                                                @if (!$statusPrinted)
                                                    <span id="statusLabelView"
                                                        class="{{ $badgeColors[$status] }}">{{ $statusLabels[$status] }}</span>
                                                    <? //$statusCounts[$status]++; ?>
                                                @endif

                                                <?php //$statusCounts[$status]++;
                                                ?>

                                                {{-- <span id="statusLabelView"
                                                    class="present-status-badge">Present</span> --}}
                                            </td>

                                            <td>{{ $inTime == 0 ? '' : \Carbon\Carbon::parse($inTime)->format('d-m-Y') }}
                                            </td>

                                            <td><?= $ruleMange->Convert24To12($inTime) ?>
                                                @if ($lateby > 0)
                                                    <br><span class="late-status fs-11 fw-bolder">
                                                        {{ $lateby > 0 ? 'Late By: ' . (intval($lateby / 60) ? intval($lateby / 60) . ' Hr ' : '') . (intval($lateby % 60) ? intval($lateby % 60) . ' Min' : '') : '' }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                {{-- @dd($outTime); --}}
                                                {{($attendanceDetails->emp_today_current_status ?? 0) == 2 ? $ruleMange->Convert24To12($outTime) : ''}}
                                                @if ($earlyExitBy > 0)
                                                    <br><span class="late-status fs-11 fw-bolder">
                                                        {{ $earlyExitBy > 0 ? 'Early Exit By: ' . (intval($earlyExitBy / 60) ? intval($earlyExitBy / 60) . ' Hr ' : '') . (intval($earlyExitBy % 60) ? intval($earlyExitBy % 60) . ' Min' : '') : '' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ isset($attendanceDetails->total_working_hour) && $attendanceDetails->total_working_hour > 0 ? $attendanceDetails->total_working_hour : '' }}
                                            </td>
                                            <td></td>
                                            <td> <?php
                                            $loadgoo = ($attendanceDetails->id ?? 0);
                                            ?>
                                                <?= $RuleManagement->AttendanceApprovalManage($checkApprovalCycleType, $attendanceDetails, $loadgoo, 1, $loginRoleID) ?>
                                            </td>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <input type="text" name="id[]" id="id"
                                                    value="{{ $item->id }}" hidden>

                                                {{-- <input type="text" name="leBhaiId" value="{{ $item->id }}" hidden> --}}
                                                <div class="d-flex justify-content-end">
                                                    {{-- @if ($item->final_status == 0) --}}

                                                    @if (
                                                        $checkApprovalCycleType == 1
                                                            ? $item->final_status == 0 && $item->forward_by_role_id == $loginRoleID
                                                            : $item->final_status == 0)
                                                        <label class="custom-control custom-checkbox-md me-5 p-0 ">
                                                            <input id="check_my_data{{ $item->id }}"
                                                                data-my_id='<?= $item->id ?>'
                                                                onclick="checkboxcheck(this, {{ $item->id }})"
                                                                type="checkbox"
                                                                class="checkbox-checkbox custom-control-input-success"
                                                                name="checkbox[]" value="{{ $item->id }}">
                                                            <span class="custom-control-label-md success"></span>
                                                        </label>
                                                    @endif
                                                    @php
                                                        // dd($item->process_complete);
                                                    @endphp
                                                    <a class="btn btn-light btn-icon btn-sm"
                                                        data-bs-target="#presentmodal" data-id='<?= $item->id ?>'
                                                        data-viewbtn='<?= $item->final_status ?>'
                                                        data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                                                        data-processcomplete='<?= $item->process_complete ?>'
                                                        data-forwardbystatus="<?= $item->forward_by_status ?>"
                                                        data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                        data-forwardroleid='<?= $item->forward_by_role_id ?>'
                                                        data-in='<?= $inTime ?>' data-out='<?= $outTime ?>'
                                                        data-attendance_shift_type_items_break_min='<?= $item->break_min ?>'
                                                        data-twh='<?= $item->total_working_hour ?>''
                                                        data-inloc='<?= $item->punch_in_address ?>'
                                                        data-outloc='<?= $item->punch_out_address ?>'
                                                        data-shiftname='<?= $item->emp_id ?>'
                                                        data-breakhr='<?= $item->break_extra_hr ?>'
                                                        data-breakmin='<?= $item->break_extra_min ?>'
                                                        data-overtime='<?= $item->overtime ?>'
                                                        data-punchinselfie='<?= $item->punch_in_selfie ?>'
                                                        data-punchoutselfie='<?= $item->punch_out_selfie ?>'
                                                        data-worFroMeth='<?= $item->working_from_method ?>'
                                                        data-punchselfimode='<?= $item->active_selfie_mode ?>'
                                                        data-punchqrmode='<?= $item->active_qr_mode ?>'
                                                        data-shiftstart='<?= $item->applied_shift_comp_start_time ?>'
                                                        data-shiftend='<?= $item->applied_shift_comp_end_time ?>'
                                                        data-brack_time='<?= $item->brack_time ?>'
                                                        data-final_status='<?= $item->final_status ?>'
                                                        data-emp_today_current_status='<?= $item->emp_today_current_status ?>'
                                                        onclick="showPresentModal(this)">
                                                        <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- @dd($statusCounts); --}}
                    <div class="card-footer">
                        <button class="btn btn-primary float-end" name="approveAll" value="1" id="approveAll"
                            type="submit">Approve All</button>
                    </div>

                </form>
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

                <form id="modalForm" action="{{ url('admin/attendance/attendance_mark') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card-header border-bottom-0">
                                    <h4 class="">Timesheet<span
                                            class="fs-14 mx-3 text-muted">{{ date('d-M-y h:i a') }}</span></h4>
                                </div>
                                <input type="text" id="Updateid" name="Updateid" hidden>
                                {{-- style="height: 260px" --}}
                                <div class="col-sm-12 my-auto">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="pt-5 text-center"> <input type="time"
                                                    class="form-control fs-14" id="modalPunchIn" name="editPunchInTime"
                                                    value="">
                                                {{-- <h6 class="mb-1 fs-16 font-weight-semibold" id="">12:00</h6> --}}
                                                <small class="text-muted fs-14">Punch In ↑</small><br>
                                                <small class="text-muted fs-14">Shift Start ↓</small>
                                                <input type="time" class="form-control fs-14" name=""
                                                    id="editShiftStart" disabled>
                                            </div>
                                        </div>

                                        <div class="col-2 mt-5 pt-5 p-0 align-middle">

                                            <div class="mx-0 px-0 pt-5 text-center rounded-circle" data-value="100"
                                                data-thickness="6" data-color="#0dcd94">
                                                <div class="text-muted" id="modalWorkingHr"">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="pt-5 text-center">
                                                <input type="time" class="form-control fs-14" id="modalPunchOut"
                                                    name="editPunchOutTime" value="">

                                                {{-- <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchOut">12:00</h6> --}}
                                                <small class="text-muted fs-14">Punch Out ↑</small><br>
                                                <small class="text-muted fs-14">Shift End ↓</small>
                                                <input type="time" class="form-control fs-14" name=""
                                                    id="editShiftEnd" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-5">
                                        <div class="row">
                                            <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                <small class="text-muted fs-13">Break Time</small>
                                                <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">
                                                </p>
                                            </div>
                                            <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                <small class="text-muted fs-13">Overtime</small>
                                                <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="d-flex">
                                    <a class="btn btn-green btn-block text-white mt-5">Approve</a>
                                </div> --}}
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
                                                        <p class="tl-title">Punch In at <span id="puchInAt"></span> |
                                                            <span class="shiftName"></span><br><span
                                                                class="text-muted fs-12"><i
                                                                    class="fa fa-map-marker mx-1"></i><span
                                                                    id="inLocation"></span></span>
                                                        <p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#PunchIn" class="my-auto">

                                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                                id="punchInSelfieId" style=""></span>
                                                            {{-- <span class="avatar avatar-sm brround"
                                                            style="background-image: url(assets/images/users/1.jpg)"></span> --}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-header">
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
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#PunchOut" class="my-auto">
                                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                                id="punchOutSelfieId" style=""></span>
                                                            {{-- <span class="avatar avatar-md brround me-3 rounded-circle"
                                                            style=""></span> --}}
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
                    <div class="modal-footer PresentModalFooter" id="PresentModalFooter">
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">Close</a>
                        <button href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" name="status"
                            value="1" data-bs-dismiss="modal" type="submit">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END PRESENT MODAL -->

    <!-- PUNCH IN IMAGE MODAL -->
    <div class="modal fade" id="PunchIn">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>

                    <a href="javascript:void(0);" class="btn-close" data-bs-toggle="modal"
                        data-bs-target="#presentmodal" data-bs-dismiss="modal"><span aria-hidden="true">×</span></a>
                </div>
                <div class="modal-body text-center">
                    <img class="" id="fullInTimeImage" height="290"></span>
                </div>
                <div class="modal-footer d-flex">
                    <div>
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#presentmodal" data-bs-dismiss="modal"><i
                                class="feather feather-arrow-left me-1"></i>Back</a>
                    </div>
                    <div class="ms-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PUNCH IN IMAGE EDIT MODAL -->

    <!-- PUNCH OUT IMAGE MODAL -->
    <div class="modal fade" id="PunchOut">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>
                    <a class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body text-center">
                    <img class="" id="fullOutTimeImage" height="240"></span>
                </div>
                <div class="modal-footer d-flex">
                    <div>
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#presentmodal" data-bs-dismiss="modal"><i
                                class="feather feather-arrow-left me-1"></i>Back</a>
                    </div>
                    <div class="ms-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myAttendacneFun() {
            alert('Hello from my JavaScript function!');
            console.log("heelo");
        }
    </script>
    <!-- PUNCH OUT IMAGE EDIT MODAL -->
    <!-- INTERNAL APEXCHART JS -->
    <!-- INTERNAL APEXCHARTS JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/apexchart-custom.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#country-dd, #state-dd, #desig-dd, #dateselect-dd').change(function() {
                var branchId = $('#country-dd').val();
                // console.log(branchId);
                var departmentId = $('#state-dd').val();
                var designationId = $('#desig-dd').val();
                // var dateSelectValue =;
                var formattedDate = moment($('#dateselect-dd').val(), "DD MMMM YYYY").format("YYYY-MM-DD");
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/attendance/attendance_list_filter') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId,
                        date_select_value: formattedDate
                    },
                    success: function(data) {
                        // console.log(data);
                        setCount(data['allStatusCount']);
                        var tbody = $('.my_body');
                        var empData = data['resData'];
                        var employeeCount = data['empCount'];
                        var emptyArray = [employeeCount, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        tbody.empty();
                        $.each(data, function(index, employee) {
                            // console.log("employee ", data.checkapprovaltype);
                            var currentstatus = data['currentstatupartdb'];
                            // console.log('currentstatus ', currentstatus);
                            var status = data['status'];
                            if (employee !== null && Array.isArray(employee) && employee
                                .length != []) {
                                let i = 1;
                                employee.forEach(el => {
                                    var dateObject = new Date(el.punch_date);

                                    // Extract the components of the date
                                    var day = dateObject.getDate();
                                    var month = dateObject.getMonth() +
                                        1; // Months are zero-based
                                    var year = dateObject.getFullYear();

                                    // Format the date as "DD-MM-YYYY"
                                    var formattedDate = (day < 10 ? '0' : '') +
                                        day + '-' + (
                                            month < 10 ? '0' : '') + month +
                                        '-' + year;
                                    // console.log("final_status ",final_status);
                                    var occurance = empData[el.emp_id][14];
                                    //Early Exit Rule
                                    var earlyOccurrenceIs = occurance[0];
                                    var earlyOccurrence = occurance[1];
                                    var earlyOccurrencePenalty = occurance[2];
                                    //Late Rule
                                    var lateOccurrenceIs = occurance[3];
                                    var lateOccurrence = occurance[4];
                                    var lateOccurrencePenalty = occurance[5];
                                    var totalLateTime = empData[el.emp_id][12];
                                    var totalEarlyExitTime = empData[el.emp_id][
                                        13
                                    ];
                                    var statusPrinted = false;

                                    if (empData[el.emp_id][0] === 3 || empData[
                                            el.emp_id][0] === 12) {
                                        if (lateOccurrenceIs !== 0 &&
                                            earlyOccurrenceIs !== 0) {
                                            if (lateOccurrenceIs === 1) {
                                                if (allStatusCount[el.emp_id][
                                                        3
                                                    ] >= lateOccurrence) {
                                                    if (lateOccurrencePenalty ===
                                                        1) {
                                                        emptyArray[8]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>';
                                                    } else {
                                                        emptyArray[2]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="absent-status-badge">Absent</span>';
                                                    }
                                                    statusPrinted = true;
                                                }
                                            } else if (lateOccurrenceIs === 2) {
                                                if (totalLateTime >=
                                                    lateOccurrence) {
                                                    if (lateOccurrencePenalty ===
                                                        1) {
                                                        emptyArray[8]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>';
                                                    } else {
                                                        emptyArray[2]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="absent-status-badge">Absent</span>';
                                                    }
                                                    statusPrinted = true;
                                                }
                                            }

                                            if (earlyOccurrenceIs === 1 && !
                                                statusPrinted) {
                                                if (allStatusCount[el.emp_id][
                                                        12
                                                    ] >=
                                                    earlyOccurrence) {
                                                    if (earlyOccurrencePenalty ===
                                                        1) {
                                                        emptyArray[8]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>';
                                                    } else {
                                                        emptyArray[2]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="absent-status-badge">Absent</span>';
                                                    }
                                                    statusPrinted = true;
                                                }
                                            } else if (earlyOccurrenceIs ===
                                                2 && !statusPrinted) {
                                                if (totalEarlyExitTime >=
                                                    earlyOccurrence) {
                                                    if (earlyOccurrencePenalty ===
                                                        1) {
                                                        emptyArray[8]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>';
                                                    } else {
                                                        emptyArray[2]++;
                                                        statusLabelView =
                                                            '<span id="statusLabelView" class="absent-status-badge">Absent</span>';
                                                    }
                                                    statusPrinted = true;
                                                }
                                            }
                                        } else if (empData[el.emp_id][0] ===
                                            12) {
                                            emptyArray[12]++;
                                            statusLabelView =
                                                '<span id="statusLabelView" class="present-status-badge">Present</span>';
                                        } else if (empData[el.emp_id][0] ===
                                            8) {
                                            emptyArray[8]++;
                                            statusLabelView =
                                                '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>';
                                        } else {
                                            emptyArray[3]++;
                                            statusLabelView =
                                                '<span id="statusLabelView" class="present-status-badge">Present</span>';
                                        }
                                    }

                                    // Additional condition based on the new requirement
                                    if (!statusPrinted) {
                                        statusLabelView = (
                                            empData[el.emp_id][0] === 8 ?
                                            '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>' :
                                            (empData[el.emp_id][0] === 2 ?
                                                '<span id="statusLabelView" class="absent-status-badge">Absent</span>' :
                                                (empData[el.emp_id][0] ===
                                                    4 ?
                                                    '<span id="statusLabelView" class="mispunch-status-badge">Mispunch</span>' :
                                                    '<span id="statusLabelView" class="present-status-badge">Present</span>'
                                                ))
                                        );
                                        emptyArray[empData[el.emp_id][0]]++;
                                    }

                                    $('#myAttendanceCheck' + el.id).val(el
                                        .final_status);

                                    var newRow = '<tr>' +
                                        '<td>' + i++ + '</td>' +

                                        '<td>' + `<div class="d-flex">
                                        <span class="avatar avatar-md brround me-3 rounded-circle"
                                            style="background-image: url('/employee_profile/` + el
                                        .profile_photo + `')"></span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1 fs-14">` + el.emp_name + ' ' + (el.emp_mname != null ?
                                            el.emp_mname : '') + ' ' + el
                                        .emp_lname + `</h6>
                                            <p class="text-muted mb-0 fs-12">
                                                ` + el.desig_name + `</p>
                                        </div>
                                    </div>` + '</td>' +
                                        '<td>' + el.emp_id + '</td>' +
                                        '<td>' +
                                        statusLabelView +
                                        '</td>' +
                                        '<td>' + formattedDate + '</td>' +
                                        '<td>' + convert24To12(el
                                            .punch_in_time) + (empData[el
                                                .emp_id][
                                                12
                                            ] > 0 ?
                                            '<br><span class="late-status fs-11 fw-bolder">Late By:' +
                                            parseInt(empData[el.emp_id][12] /
                                                60) + 'Hr ' + parseInt(empData[
                                                el.emp_id][12] % 60) +
                                            'Min</span>' : '') + '</td>' +
                                        '<td>' + (el.emp_today_current_status ==
                                            '2' ? convert24To12(el
                                                .punch_out_time) : '') + (
                                            empData[el.emp_id][13] > 0 ?
                                            '<br><span class="late-status fs-11 fw-bolder">Early Exit By:' +
                                            parseInt(empData[el.emp_id][13] /
                                                60) + 'Hr ' + parseInt(empData[
                                                el.emp_id][13] % 60) +
                                            'Min</span>' : '') + '</td>' +
                                        '</td>' +
                                        '<td>' + ((el.total_working_hour !==
                                                null &&
                                                el
                                                .total_working_hour != undefined
                                            ) ?
                                            (el.total_working_hour.split(":")
                                                .slice(
                                                    0, 2).join(":")) + ' ' +
                                            'Min.' : ''
                                        ) + '</td>' +
                                        '<td>' + el.method_name + '</td>' +
                                        '<td>' +
                                        status[el.id] +
                                        '</td>' +
                                        '<td>' + el.id + '</td>' +
                                        '<td><div class="d-flex justify-content-end">'
                                    if ((data.checkapprovaltype == 1) ? (el
                                            .forward_by_role_id == data
                                            .loginRoleID) : (data.loginRoleID !=
                                            '$owner_call_back_id->call_back_id'
                                        )) {
                                        newRow +=
                                            `<label class="custom-control custom-checkbox-md me-5 p-0 ">
                                        <input id="check_my_data${el.id}"
                                             data-my_id="${el.id}" 
                                            onclick="checkboxcheck(this, ${el.id})"
                                            type="checkbox"
                                            class="checkbox-checkbox custom-control-input-success"
                                            name="checkbox[]" value="${el.id}">
                                        <span class="custom-control-label-md success"></span>
                                    </label>
                                    `;
                                    }
                                    newRow += `<a class="btn btn-light btn-icon btn-sm"
                                                data-bs-target="#presentmodal" 
                                                data-id="${el.id}" 
                                                data-processcomplete="${el.process_complete}" 
                                                data-viewbtn="${el.final_status}" 
                                                data-forwardbystatus="${el.forward_by_status}" 
                                                data-currentstatusparticulartb="${currentstatus[el.id] ?? 0}" 
                                                data-forwardroleid=' ${el.forward_by_role_id}'
                                                data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                                                data-in="${el.punch_in_time}"
                                                data-out="${el.punch_out_time}"
                                                data-attendance_shift_type_items_break_min="${el.break_min}"
                                                data-twh="${el.total_working_hour}"
                                                data-inloc="${el.punch_in_address}"
                                                data-outloc="${el.punch_out_address}"
                                                data-shiftname="${el.emp_id}" 
                                                data-breakhr="${el.break_extra_hr}"
                                                data-breakmin="${el.break_extra_min}"
                                                data-overtime="${el.overtime}"
                                                data-punchinselfie="${el.punch_in_selfie}"
                                                data-punchoutselfie="${el.punch_out_selfie}"
                                                data-worFroMeth="${el.working_from_method}"
                                                data-punchselfimode="${el.active_selfie_mode}"
                                                data-punchqrmode="${el.active_qr_mode}"
                                                data-shiftstart="${el.applied_shift_comp_start_time}"
                                                data-shiftend="${el.applied_shift_comp_end_time}"
                                                data-emp_today_current_status="${el.emp_today_current_status}"
                                                onclick="showPresentModal(this)">
                                                <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>`;

                                    newRow += '</div></td></tr>';
                                    tbody.append(newRow);
                                });
                                $('[data-bs-toggle="popover"]').popover({
                                    trigger: 'hover'
                                });

                                // $('#approveAll').prop('disabled', false);
                            } else {
                                // $('#approveAll').prop('disabled', true);
                            }

                        });

                    }
                });
            });
        });

        function setCount(allStatusCount) {
            console.log(allStatusCount);
            var totalEmployee = document.getElementById('totalEmployeeCount');
            var presentEmployee = document.getElementById('presentEmployeeCount');
            var absentEmployee = document.getElementById('absentEmployeeCount');
            var halfdayEmployee = document.getElementById('halfdayEmployeeCount');
            var lateEmployee = document.getElementById('lateEmployeeCount');
            var leaveEmployee = document.getElementById('leaveEmployeeCount');

            totalEmployee.innerHTML = allStatusCount.totalEmp || 0;
            presentEmployee.innerHTML = allStatusCount.present || 0;
            absentEmployee.innerHTML = allStatusCount.absent || 0;
            halfdayEmployee.innerHTML = allStatusCount.halfday || 0;
            lateEmployee.innerHTML = allStatusCount.late || 0;
            leaveEmployee.innerHTML = allStatusCount.leave || 0;
        }
    </script>
    <script>
        function showPresentModal(context) {
            console.log("context ", context);
            $('#presentmodal').modal('show');
            var id = $(context).data('id');
            var loginRoleID = '<?= $loginRoleID ?>';
            var checkApprovalCycleType = '<?= $checkApprovalCycleType ?>';
            var forwardRoleid = $(context).data('forwardroleid');
            var current_status_particulartb = $(context).data('currentstatusparticulartb');
            var forward_by_status = $(context).data('forwardbystatus');
            var process_complete = $(context).data('processcomplete');
            var viewBtn = $(context).data('viewbtn');
            var ownerId = $(context).data('ownerid');
            $('#Updateid').val(id);
            var inTime = $(context).data('in');
            var outTime = $(context).data('out');
            var shiftStartTime = $(context).data('shiftstart');
            var shiftEndTime = $(context).data('shiftend');
            var twh = $(context).data('twh');
            var addtimes = calculateWorkingHours(shiftStartTime, shiftEndTime);
            var addtimesSecond = calculateWorkingHours(addtimes, twh);
            var inLoc = $(context).data('inloc');
            var outLoc = $(context).data('outloc');
            var breakHr = $(context).data('breakhr');
            var breakMin = $(context).data('breakmin');
            var attendanceShiftBreakMin = $(context).data('attendance_shift_type_items_break_min');
            var totalBreakHrMin = (breakHr * 60) + breakMin + attendanceShiftBreakMin;
            var actualBreakTime = parseInt(totalBreakHrMin / 60).toString().padStart(2, '0') + ':' + (totalBreakHrMin % 60)
                .toString().padStart(2, '0');
            var shiftName = $(context).data('shiftname');
            var overTimeInMinutes = $(context).data('overtime');
            var punchQrMode = $(context).data('punchqrmode');
            var punchSelfiMode = $(context).data('punchselfimode');
            // var attendance_shift_type_items_break_min
            var punchInSelfieV = $(context).data('punchinselfie');
            var punchOutSelfieV = $(context).data('punchoutselfie');
            var attendancestatus = $(context).data('final_status');
            var empTodayCurrentStatus = $(context).data('emp_today_current_status');
            console.log("empTodayCurrentStatus " + empTodayCurrentStatus)
            var hours = Math.floor(overTimeInMinutes / 60);
            var minutes = overTimeInMinutes % 60;
            var formattedHours = ('0' + hours).slice(-2);
            var formattedMinutes = ('0' + minutes).slice(-2);
            var brackTime = $(context).data('brack_time');
            // Format the result
            var formattedTime = formattedHours + ":" + formattedMinutes;
            $('#editShiftStart').val(shiftStartTime);
            $('#editShiftEnd').val(shiftEndTime);
            if (punchQrMode == 0) {
                var imageOutUrl = '/upload_image/' + punchOutSelfieV;
                var imageInUrl = '/upload_image/' + punchInSelfieV;
                $('#punchInSelfieId').css('background-image', 'url(' + imageInUrl + ')');
                $('#punchOutSelfieId').css('background-image', 'url(' + imageOutUrl + ')');
                $('#fullInTimeImage').css('background-image', 'url(' + imageInUrl + ')');
            }
            if (punchSelfiMode == 1) {
                if (punchInSelfieV != '' || punchInSelfieV != null) {
                    var imageInUrl = '/upload_image/' + punchInSelfieV;
                    $('#punchInSelfieId').css('background-image', 'url(' + imageInUrl + ')');
                    $('#fullInTimeImage').attr('src', imageInUrl);
                }
                if (punchOutSelfieV != '' || punchInSelfieV != null) {
                    var imageOutUrl = '/upload_image/' + punchOutSelfieV;
                    $('#punchOutSelfieId').css('background-image', 'url(' + imageOutUrl + ')');
                    $('#fullOutTimeImage').attr('src', imageOutUrl);
                }

            }


            if (parseInt(checkApprovalCycleType) == 1) {
                console.log('case Sequencial');
                console.log(forwardRoleid);
                console.log(loginRoleID);


                if (parseInt(forwardRoleid) == parseInt(loginRoleID)) {

                    console.log(' level 1 ');

                    $('#PresentModalFooter').show();
                    console.log('case 1');

                }
                if (parseInt(process_complete) != 0) {
                    console.log("second");
                    $('#PresentModalFooter').hide();

                    console.log('case 2');

                } else if (parseInt(forwardRoleid) != parseInt(loginRoleID)) {
                    console.log('third');
                    $('#PresentModalFooter').hide();
                }
            }
            if (parseInt(checkApprovalCycleType) == 2) {
                console.log("Cycle 2 aagayahy");
                if (parseInt(current_status_particulartb) != 0) {
                    $('#PresentModalFooter').hide();
                }

                if ((parseInt(loginRoleID)) == (parseInt(ownerId))) {
                    $('#PresentModalFooter').hide();
                } else if (parseInt(process_complete) != 0) {
                    $('#PresentModalFooter').hide();

                    console.log('procee complete');

                } else {
                    $('#PresentModalFooter').show();
                }
            }


            var intimeWithoutSeconds = inTime.split(":").slice(0, 2).join(":"); // Remove the seconds
            var outtimeWithoutSeconds = outTime.split(":").slice(0, 2).join(":"); // Remove the seconds
            var overtimeWithoutSeconds = addtimesSecond ? addtimesSecond.split(":").slice(0, 2).join(":") : '';
            var punchInAtModel = convert24To12(inTime);
            var punchOutAtModel = convert24To12(outTime);
            $('#puchInAt').html(punchInAtModel);
            $('#modalPunchIn').val(intimeWithoutSeconds);
            $('#punchOutAt').html(punchOutAtModel);
            empTodayCurrentStatus == 2 ? $('#modalPunchOut').val(outtimeWithoutSeconds) : '';
            empTodayCurrentStatus == 2 ? $('#modalWorkingHr').html(twh) : '';
            var formatted_bracktime = `00:${String(brackTime).padStart(2, '0')}`;
            // $('#modalWorkingHr').html(twh);
            $('#inLocation').html(inLoc);
            $('#punchOutLocation').html(outLoc);
            $('#modalBreakTime').html(breakMin);
            $('.shiftName').html(shiftName);
            $('#inputPunchInInputEditModel').val(inTime);
            $('#inputPunchOutInputEditModel').val(outTime);
            $('#modalBreakTime').html(formatted_bracktime);
            $('#modalOverTime').html(formattedTime);
        }

        function calculateWorkingHours(punchInTime, punchOutTime) {
            // Split the time values into hours, minutes, and seconds
            console.log("function punhIN " + punchInTime);
            console.log("function punchOut " + punchOutTime);
            if (punchInTime === null || punchOutTime == null || punchOutTime == '' || punchInTime === '') {
                return null; // If either parameter is null, return null
            }
            var punchInParts = punchInTime.split(":");
            var punchOutParts = punchOutTime.split(":");

            // Parse hours, minutes, and seconds
            var punchInHours = parseInt(punchInParts[0]);
            var punchInMinutes = parseInt(punchInParts[1]);
            var punchInSeconds = parseInt(punchInParts[2]);

            var punchOutHours = parseInt(punchOutParts[0]);
            var punchOutMinutes = parseInt(punchOutParts[1]);
            var punchOutSeconds = parseInt(punchOutParts[2]);

            // Calculate the time difference
            var totalHours = punchOutHours - punchInHours;
            var totalMinutes = punchOutMinutes - punchInMinutes;
            var totalSeconds = punchOutSeconds - punchInSeconds;

            // Handle carryovers and negative values
            if (totalSeconds < 0) {
                totalSeconds += 60;
                totalMinutes--;
            }
            if (totalMinutes < 0) {
                totalMinutes += 60;
                totalHours--;
            }

            // Check if the result is negative
            if (totalHours < 0) {
                return null; // Return null for negative time values
            }

            // Format the result as "HH:MM:SS"
            var workingHours = totalHours.toString().padStart(2, '0') + ":" +
                totalMinutes.toString().padStart(2, '0') + ":" +
                totalSeconds.toString().padStart(2, '0');

            return workingHours;
        }

        function convert24To12(time24) {
            // Check if time24 is null or undefined
            if (time24 == null || time24 == '') {
                return ''; // Return an empty string or handle the null case as needed
            }

            // Split the input time into hours, minutes, and seconds
            const [hours, minutes, seconds] = time24.split(':');

            // Determine the period (AM or PM)
            const period = hours >= 12 ? 'PM' : 'AM';

            // Convert hours to 12-hour format
            let hours12 = hours % 12;
            hours12 = hours12 === 0 ? 12 : hours12; // Handle 0 as 12 in 12-hour format

            // Use padStart to ensure double digits for hours, minutes, and seconds
            const hours12Str = hours12.toString().padStart(2, '0');
            const minutesStr = minutes.toString().padStart(2, '0');
            const secondsStr = seconds.toString().padStart(2, '0');

            // Create the 12-hour time string with double digits
            const time12 = `${hours12Str}:${minutesStr} ${period}`;

            return time12;
        }

        function checkboxcheck(checked, id) {
            var new_data = $(checked).data('my_id');
            console.log(new_data);
            console.log('Item ID: ' + id);

            var elm = document.getElementById('check_my_data' + id);

            if (elm) {
                if (elm.checked) {
                    // $('#hdkfh' + id).val(1);
                    $('#myAttendanceCheck' + id).val("1");

                    console.log('check hai');
                } else {
                    console.log('check nhi hai');
                    $('#myAttendanceCheck' + id).val("0");

                }
            } else {
                console.log('Checkbox with ID ' + 'check_my_data' + id + ' does not exist.');
            }
        }

        function checkbox_dd(context) {
            if ($('.custom-control-input-success').prop('checked')) {
                $('.checkbox-checkbox').prop('checked', true); // Check the checkboxes
                // $('.checkbox-checkbox').val("1");
                // $('.myAttendanceCheck').val("1");
                console.log("Universal Check");
            } else {
                $('.checkbox-checkbox').prop('checked', false); // Uncheck the checkboxes
                // $('.checkbox-checkbox').val("0");
                // $('.myAttendanceCheck').val("0");

            }
        }
    </script>
@endsection
