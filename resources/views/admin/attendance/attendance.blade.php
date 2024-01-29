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
            use App\Models\PolicySettingRoleAssignPermission;
            use App\Models\PolicySettingRoleCreate;
            use App\Models\StaticStatusAttendance;
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

            $root = new App\Helpers\Central_unit();
            $AttList = $root->GetAttDetails();
            $DailyCount = $root->getDailyCountForDashboardAndDailyList(Session::get('business_id'), date('Y-m-d'));
            $nss = new App\Helpers\Central_unit();
            $EmpID = $nss->EmpPlaceHolder();
            $LeaveCount = $nss->LeaveSectionCount();
            $somthing = $nss->MyCountForDaily(date('Y-m-d'), Session::get('business_id'));
            $so = $nss->misPunchRuleFunction(Session::get('business_id'), date('Y-m-d'));

        @endphp
        @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.View', $permissions))
            <div class=" p-0 pb-4">
                <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                    <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="active"><span><b>Attendance</b></span></li>
                </ol>
            </div>
            <div class="row">
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
                                        id="leaveEmployeeCount">{{ $DailyCount['leave'] }}</span>
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

                                    @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                        <button type="submit"
                                            class="btn ripple btn-primary {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}"
                                            name="pendingAll"
                                            {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}>Approve</button>
                                    @endif
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
                                                    <select id="state-dd" name="department_id" class="form-control">
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
                                                    <select id="desig-dd" name="designation_id" class="form-control">
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
                                                    </div><input class="form-control fc-datepicker" id="dateselect-dd"
                                                        name="date_select_name" placeholder="DD-MM-YYYY" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                    <div
                                        class="hr-checkallcol-md-12 col-lg-2  {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}  ">
                                        <div class="d-flex float-end ">
                                            <label class="custom-control custom-checkbox-md me-5 p-0">
                                                <input type="checkbox" class="custom-control-input-success"
                                                    {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}
                                                    onclick="checkbox_dd(this)" name="example-checkbox1" value="option1">
                                                <span class="custom-control-label-md success"></span>
                                            </label>
                                            <p class="pt-2"><b>Mark All</b></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <form action="{{ url('admin/attendance/attendance_mark') }}" method="POST">
                            @csrf
                            <div class="card-body  p-2 px-2">
                                <div class="table-responsive">
                                    <table class="table  table-vcenter text-nowrap border-bottom " id="basic-datatable">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0" hidden>S.No.</th>
                                                <th class="border-bottom-0">Employee</th>
                                                <th class="border-bottom-0">Emp ID</th>
                                                <th class="border-bottom-0">Status</th>
                                                <th class="border-bottom-0">Date</th>
                                                <th class="border-bottom-0">Punch In</th>
                                                <th class="border-bottom-0">Punch Out</th>
                                                <th class="border-bottom-0">Working Hour</th>
                                                <th class="border-bottom-0">Working From</th>
                                                <th class="border-bottom-0">Attendance</th>
                                                <th class="border-bottom-0 text-center">Action</th>
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
                                            @foreach ($DATA as $key => $item)
                                                @php
                                                    // dd($item);
                                                    $approval_type_id_static = 1;
                                                    $centralUnit = new App\Helpers\Central_unit();
                                                    $ruleMange = new App\Helpers\MasterRulesManagement\RulesManagement();
                                                    $TimeLog = $centralUnit->getTimeLog($item->emp_id, date('Y-m-d'));
                                                    $resCode = $centralUnit->getEmpAttSumm(['emp_id' => $item->emp_id, 'punch_date' => date('Y-m-d')]);
                                                    $attendanceDetails = $centralUnit->getEmpAttendanceDetails($item->emp_id, date('Y-m-d'));
                                                    $inTime = $attendanceDetails->punch_in_time ?? 0;
                                                    $outTime = $attendanceDetails->punch_out_time ?? 0;
                                                    $timeDifference = $centralUnit->CalculateTimeDifference($inTime, $outTime);
                                                    $hours = str_pad($timeDifference->h, 2, '0', STR_PAD_LEFT);
                                                    $minutes = str_pad($timeDifference->i, 2, '0', STR_PAD_LEFT);
                                                    $seconds = str_pad($timeDifference->s, 2, '0', STR_PAD_LEFT);
                                                    $status = $resCode[0];
                                                    $lateby = $resCode[12];
                                                    $earlyExitBy = $resCode[13];
                                                    $occurance = $resCode[14];

                                                    $employeeOtherDetails = $centralUnit->getIndivisualEmployeeDetails($item->emp_id);

                                                    $EmpName = $employeeOtherDetails->emp_name ?? '';
                                                    $EmpMName = $employeeOtherDetails->emp_mname ?? '';
                                                    $EmpLName = $employeeOtherDetails->emp_lname ?? '';
                                                    $EmpID = $employeeOtherDetails->emp_id ?? '';
                                                    $EmpShiftName = $employeeOtherDetails->attendance_shift_name ?? '';
                                                    $EmpShiftStart = $ruleMange->Convert24To12($employeeOtherDetails->shift_start ?? '');
                                                    $EmpShiftEnd = $ruleMange->Convert24To12($employeeOtherDetails->shift_end ?? '');
                                                    $PunchDate = date('d-m-Y');
                                                    $InTime = $inTime == null ? null : $inTime;
                                                    $OutTime = $outTime == null ? null : $outTime;

                                                    // dd($EmpName, $EmpMName, $EmpLName, $EmpID, $EmpShiftName, $EmpShiftStart, $EmpShiftEnd, $PunchDate, $InTime, $OutTime);

                                                @endphp
                                                <tr>

                                                    <td hidden>{{ $key++ }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                                style="background-image: url('/storage/livewire_employee_profile/{{ $item->profile_photo }}')"></span>
                                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                                <h6 class="mb-1 fs-14">
                                                                    <a
                                                                        href="{{ route('employeeProfile', [$item->emp_id]) }}">
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
                                                                10 => 'Leave',
                                                                11 => 'Leave',
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
                                                            // dd($occurance);
                                                        @endphp

                                                        @if (!$statusPrinted)
                                                            <span id="statusLabelView"
                                                                class="{{ $badgeColors[$status] }}">{{ $statusLabels[$status] }}</span>
                                                            <? //$statusCounts[$status]++; ?>
                                                        @endif

                                                        <?php //$statusCounts[$status]++;
                                                        ?>
                                                    </td>

                                                    <td>{{ $inTime == 0 ? date('d-m-Y') : \Carbon\Carbon::parse($inTime)->format('d-m-Y') }}

                                                    </td>

                                                    <td><?= ($attendanceDetails->emp_today_current_status ?? 0) >= 1 ? $ruleMange->Convert24To12($inTime) : '-' ?>
                                                        @if ($lateby > 0)
                                                            {{-- @dd($lateby); --}}
                                                            <br><span class="late-status fs-10 fw-bolder">
                                                                {{ $lateby > 0 ? 'Late By: ' . (intval($lateby / 60) ? intval($lateby / 60) . ' Hr ' : '') . (intval($lateby % 60) ? intval($lateby % 60) . ' Min' : '') : '' }}
                                                            </span>
                                                        @endif

                                                        <small
                                                            class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                            data-bs-trigger="hover" style="background-color:transparent;"
                                                            data-bs-container="body"
                                                            data-bs-content="{{ count($TimeLog) != 0? implode(', ',$TimeLog->map(function ($log) {return $log->prev_in_time . ' to ' . $log->changed_in_time . '<br/> By <b>' . $log->changer_name . '</b>(' . $log->changer_role . ')' . '<br> at ' . date('d-M-y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html="true" title=""
                                                            data-bs-original-title="Attendance Log">
                                                            <i class="fa fa-info-circle"></i>
                                                        </small>
                                                    </td>

                                                    <td>
                                                        {{-- @dd($outTime); --}}
                                                        {{ ($attendanceDetails->emp_today_current_status ?? 0) == 2 ? $ruleMange->Convert24To12($outTime) : '-' }}
                                                        @if ($earlyExitBy > 0)
                                                            <br><span class="late-status fs-10 fw-bolder">
                                                                {{ $earlyExitBy > 0 ? 'Early Exit By: ' . (intval($earlyExitBy / 60) ? intval($earlyExitBy / 60) . ' Hr ' : '') . (intval($earlyExitBy % 60) ? intval($earlyExitBy % 60) . ' Min' : '') : '' }}
                                                            </span>
                                                        @endif
                                                        <small
                                                            class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                            data-bs-trigger="hover" style="background-color:transparent;"
                                                            data-bs-container="body"
                                                            data-bs-content="{{ count($TimeLog) != 0? implode(', ',$TimeLog->map(function ($log) {return $log->prev_out_time . ' to ' . $log->changed_out_time . '<br/> By <b>' . $log->changer_name . '</b>(' . $log->changer_role . ')' . '<br> at ' . date('d-M-y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><hr/>';})->toArray()): '' }}."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html="true" title=""
                                                            data-bs-original-title="Attendance Log">
                                                            <i class="fa fa-info-circle"></i>
                                                        </small>
                                                    </td>
                                                    <td>{{ isset($attendanceDetails->total_working_hour) && $attendanceDetails->total_working_hour > 0 ? $attendanceDetails->total_working_hour : '-' }}
                                                        <small
                                                            class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                            data-bs-trigger="hover" style="background-color:transparent;"
                                                            data-bs-container="body"
                                                            data-bs-content="{{ count($TimeLog) != 0? implode(', ',$TimeLog->map(function ($log) {return $log->prev_total_work . ' to ' . $log->changed_total_work . ' <br/>By <b>' . $log->changer_name . '</b>(' . $log->changer_role . ')' . '<br> at ' . date('d-M-y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                            data-bs-placement="right" data-bs-popover-color="primary"
                                                            data-bs-toggle="popover" data-bs-html="true" title=""
                                                            data-bs-original-title="Attendance Log">
                                                            <i class="fa fa-info-circle"></i>
                                                        </small>
                                                    </td>
                                                    <td>{{ $attendanceDetails->method_name ?? ($item->method_name ?? '-') }}
                                                    </td>
                                                    <td> <?php
                                                    $loadgoo = $attendanceDetails->id ?? 0;
                                                    ?>
                                                        <?= $RuleManagement->AttendanceApprovalManage($checkApprovalCycleType, $attendanceDetails, $loadgoo, 1, $loginRoleID) ?>
                                                    </td>

                                                    <td>
                                                        <input type="text" name="id[]" id="id"
                                                            value="{{ $item->id }}" hidden>

                                                        <div class="d-flex justify-content-end">
                                                            {{-- @if ($checkApprovalCycleType == 1 ? $attendanceDetails->final_status ?? '0' == 0 && $attendanceDetails->forward_by_role_id == $loginRoleID : ($checkApprovalCycleType == 2 ? $attendanceDetails->final_status ?? '' == 0 : '')) --}}
                                                            @if (
                                                                ($checkApprovalCycleType == 1 &&
                                                                    ($attendanceDetails
                                                                        ? $attendanceDetails->final_status == 0 && $attendanceDetails->emp_today_current_status == 2
                                                                        : '')) ||
                                                                    ($checkApprovalCycleType == 2 &&
                                                                        ($attendanceDetails
                                                                            ? $attendanceDetails->final_status == 0 && $attendanceDetails->emp_today_current_status == 2
                                                                            : '')))
                                                                <label class="custom-control custom-checkbox-md me-5 p-0 ">
                                                                    <input
                                                                        id="check_my_data{{ $attendanceDetails->id ?? '' }}"
                                                                        data-my_id='<?= $attendanceDetails->id ?? '' ?>'
                                                                    onclick="checkboxcheck(this, {{ $attendanceDetails->id ?? '' }})"
                                                                    type="checkbox"
                                                                    class="checkbox-checkbox custom-control-input-success p-0"
                                                                    name="checkbox[]"
                                                                    value="{{ $attendanceDetails->id ?? '' }}">
                                                                    <span
                                                                        class="custom-control-label-md success p-0"></span>
                                                                </label>
                                                            @endif

                                                            {{-- /date('H:i A',  --}}
                                                            {{-- dd($EmpName, $EmpMName, $EmpLName, $EmpID, $EmpShiftName, $EmpShiftStart, $EmpShiftEnd, $PunchDate, $InTime, $OutTime); --}}
                                                            @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                                                <a class="btn btn-sm"
                                                                    data-name="{{ $EmpName . ' ' . $EmpMName . ' ' . $EmpLName }}"
                                                                    data-empid="{{ $EmpID }}"
                                                                    data-in="{{ $InTime != null ? $InTime : ' ' }}"
                                                                    data-out="{{ $OutTime != null ? $OutTime : ' ' }}"
                                                                    data-shiftname="{{ $EmpShiftName }}"
                                                                    data-shiftstart="{{ $employeeOtherDetails->shift_start ? date('g:i A', strtotime($employeeOtherDetails->shift_start)) : '' }}"
                                                                    data-shiftend="{{ $employeeOtherDetails->shift_end ? date('g:i A', strtotime($employeeOtherDetails->shift_end)) : '' }}"
                                                                    data-punchdate="{{ $PunchDate }}"
                                                                    onclick="correctionModalJs(this)">
                                                                    <i class="feather feather-edit btn-light p-1 "
                                                                        data-bs-toggle="tooltip"
                                                                        data-original-title="View"></i>
                                                                </a>
                                                            @endif

                                                            {{-- @dd($EmpID,$OutTime); --}}

                                                            <a class="btn   btn-sm" data-bs-target="#presentmodal"
                                                                data-id='<?= $attendanceDetails->id ?? '' ?>'
                                                                data-today_status ='<?= $attendanceDetails->today_status ?? ''
                                                                ?>'
                                                                data-viewbtn='<?= $attendanceDetails->final_status ?? ''
                                                                ?>'
                                                                data-ownerid='<?= $owner_call_back_id->call_back_id ?? ''
                                                                ?>'
                                                                data-processcomplete='<?= $attendanceDetails->process_complete ?? ''
                                                                ?>'
                                                                data-forwardbystatus='<?= $attendanceDetails->forward_by_status ?? ''
                                                                ?>'
                                                                data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? (0 ?? '')
                                                                ?>'
                                                                data-forwardroleid='<?= $attendanceDetails->forward_by_role_id ?? ''
                                                                ?>'
                                                                data-in='<?= $inTime ?? '' ?>'
                                                                data-out='<?= $outTime ?? 'null' ?>'
                                                                data-attendance_shift_type_items_break_min='<?= $attendanceDetails->brack_time ?? ''
                                                                ?>'
                                                                data-twh='<?= $attendanceDetails->total_working_hour ?? ''
                                                                ?>''
                                                                data-inloc='<?= $attendanceDetails->punch_in_address ?? null ?>'
                                                                data-outloc='<?= $attendanceDetails->punch_out_address ?? null ?>'
                                                                data-shiftname='<?= $attendanceDetails->applied_shift_type_name ?? ''
                                                                ?>'
                                                                data-breakhr='<?= $attendanceDetails->break_extra_hr ?? ''
                                                                ?>'
                                                                data-breakmin='<?= $attendanceDetails->break_extra_min ?? ''
                                                                ?>'
                                                                data-overtime='<?= $attendanceDetails->overtime ?? '' ?>'
                                                                data-punchinselfie='<?= $attendanceDetails->punch_in_selfie ?? ''
                                                                ?>'
                                                                data-punchoutselfie='<?= $attendanceDetails->punch_out_selfie ?? ''
                                                                ?>'
                                                                data-worFroMeth='<?= $attendanceDetails->working_from_method ?? ''
                                                                ?>'
                                                                data-punchselfimode='<?= $attendanceDetails->active_selfie_mode ?? ''
                                                                ?>'
                                                                data-punchqrmode='<?= $attendanceDetails->active_qr_mode ?? ''
                                                                ?>'
                                                                data-shiftstart='<?= $EmpShiftStart ?? ''
                                                                ?>'
                                                                data-shiftend='<?= $EmpShiftEnd ?? '' ?>'
                                                                data-brack_time='<?= $attendanceDetails->brack_time ?? ''
                                                                ?>'
                                                                data-final_status='<?= $attendanceDetails->final_status ?? ''
                                                                ?>'
                                                                data-emp_today_current_status='<?= $attendanceDetails->emp_today_current_status ?? ''
                                                                ?>'
                                                                data-punch-date='<?= date('Y-m-d', strtotime($PunchDate))
                                                                ?? '' ?>'
                                                                data-corrected_by='<?= count($TimeLog) != 0 ? $TimeLog[count($TimeLog) - 1]->changer_name . '('
                                                                . $TimeLog[count($TimeLog) - 1]->changer_role . ')' : null
                                                                ?>'
                                                                onclick="showPresentModal(this)">
                                                                <i class="feather feather-eye btn-light p-1"
                                                                    data-bs-toggle="tooltip"
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

                            @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                <div class="card-footer">
                                    <button
                                        class="btn btn-primary float-end {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'd-none' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'd-none' : '') : '') }}"
                                        name="approveAll" value="1" id="approveAll" type="submit">Approve
                                        All</button>
                                </div>
                            @endif
                        </form>
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
                                                id="ShiftStart">N/A</span><br><span class="fw-bold fs-14">End :
                                            </span><span id="ShiftEnd"> N/A</span></span>
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
                                <input id="punchDate" name="punch_date" type="text" hidden>
                            </div>
                            <div class="modal-footer d-flex">
                                <div class="ms-auto">
                                    @if (in_array('Attendance Summary.Update', $permissions) || in_array('Attendance Summary.All', $permissions))
                                        <button type="reset" class="btn btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
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

                        <form id="modalForm" action="{{ url('admin/attendance/attendance_mark') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card-header border-bottom-0 d-block">
                                            <h5 class="">Timesheet: <span class="fs-14 mx-3 text-muted"
                                                    id="punchDateTime"></span></h5>
                                            <h6 class=""><span class="fs-14 text-dark"
                                                    id="attendanceShiftName">Fixed
                                                    Shift</span><span class="fs-14 mx-3 text-muted"
                                                    id="attendanceShiftStart">09:00 AM</span><span
                                                    class="fs-14 text-muted">To</span><span class="fs-14 mx-3 text-muted"
                                                    id="attendanceShiftEnd">06:00
                                                    PM</span></h6>
                                        </div>
                                        <input type="text" id="Updateid" name="Updateid" hidden>

                                        <div class="col-sm-12 my-auto" style="height: 260px">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="p-3 text-center border border-muted">
                                                        <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchIn">
                                                            12:00
                                                        </h6>
                                                        <small class="text-muted fs-14">Punch In</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="chart-circle chart-circle-md" data-value="100"
                                                        data-thickness="8" data-color="#0dcd94"
                                                        style="border:solid 5px #1877f2; border-radius:50px">
                                                        <div class="chart-circle-value text-muted" class="font-size:10px">
                                                            <h5 id="modalWorkingHr" class="my-auto"
                                                                style="color:#1877f2">
                                                                09:05 hrs </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="p-3 text-center border border-muted">
                                                        <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchOut">
                                                            12:00
                                                        </h6>
                                                        <small class="text-muted fs-14">Punch Out</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-5">
                                                <div class="row">
                                                    <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                        <small class="text-muted fs-13">Break Time</small>
                                                        <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">
                                                            09:30
                                                            AM
                                                        </p>
                                                    </div>
                                                    <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                                        <small class="text-muted fs-13">Overtime</small>
                                                        <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">
                                                            09:30 AM
                                                        </p>
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
                                                    <div class="tl-header" id="inLocationSection">
                                                        <span class="tl-marker"></span>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <p class="tl-title">Punch In at <span
                                                                        id="puchInAt"></span>
                                                                    <span class="shiftName"></span><br>
                                                                    <span class="text-muted fs-12" id="inLocationSec">
                                                                        <i class="fa fa-map-marker mx-1"></i>
                                                                        <span id="inLocation"></span>
                                                                    </span>
                                                                    <br /><span class="tl-title"
                                                                        id="inCorrectionHead"></span>
                                                                <p>
                                                            </div>
                                                            <div class="col-2">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#PunchIn" class="my-auto">
                                                                    <span
                                                                        class="avatar avatar-md brround me-3 rounded-circle border border-primary"
                                                                        id="punchInSelfieId" style=""></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-header" id="outLocationSection">
                                                        <span class="tl-marker"></span>
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <p class="tl-title">Punch Out at <span
                                                                        id="punchOutAt"></span>
                                                                    <span class="shiftName"></span>
                                                                    <br><span class="text-muted fs-12"
                                                                        id="outLocationSec">
                                                                        <i class="fa fa-map-marker mx-1"></i><span
                                                                            id="punchOutLocation"></span></span>
                                                                    <br /><span class="tl-title"
                                                                        id="outCorrectionHead"></span>
                                                                <p>
                                                            </div>
                                                            <div class="col-2">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#PunchOut" class="my-auto">
                                                                    <span
                                                                        class="avatar avatar-md brround me-3 rounded-circle border border-primary"
                                                                        id="punchOutSelfieId" style="">
                                                                    </span>
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
                            @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                <div class="modal-footer PresentModalFooter text-end justify-content-end"
                                    id="PresentModalFooter">
                                    <a href="javascript:void(0);" class="btn btn-danger"
                                        data-bs-dismiss="modal">Close</a>
                                    <button href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                        name="status" value="1" data-bs-dismiss="modal"
                                        type="submit">Approve</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <!-- END PRESENT MODAL -->
            <!-- NO DATA MODAL -->
            <div class="modal fade" id="nodatamodal">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Attendance Details</h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row text-center py-5">
                                <span class="text-muted fs-18">No Data Found</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NO DATA MODAL -->

            <!-- PUNCH IN IMAGE MODAL -->
            <div class="modal fade" id="PunchIn">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <a href="javascript:void(0);" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#presentmodal" data-bs-dismiss="modal"><span aria-hidden="true">×</span></a>
                        <img class="align-center" id="fullInTimeImage" height="200" style="max-height:35rem"></span>
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#presentmodal" data-bs-dismiss="modal"><i
                                class="feather feather-arrow-left me-1"></i>Back</a>
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

            <!-- INTERNAL APEXCHARTS JS -->
            <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}"></script>
            {{-- <script src="{{ asset('assets/js/apexchart-custom.js') }}"></script> --}}
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

            <script>
                $(document).ready(function() {
                    $('#country-dd, #state-dd, #desig-dd, #dateselect-dd').change(function() {
                        var branchId = $('#country-dd').val();

                        var departmentId = $('#state-dd').val();
                        var designationId = $('#desig-dd').val();
                        // var dateSelectValue =;
                        var formattedDate = moment($('#dateselect-dd').val(), "DD MMMM YYYY").format("YYYY-MM-DD");
                        var formattedDate2 = moment($('#dateselect-dd').val(), "DD MMMM YYYY").format("YYYY-MM-DD");

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
                                console.log(data);
                                setCount(data['allStatusCount']);
                                var tbody = $('.my_body');
                                var empData = data['resData'];
                                var employeeCount = data['empCount'];
                                var emptyArray = [employeeCount, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                                tbody.empty();
                                $.each(data, function(index, employee) {

                                    var currentstatus = data['currentstatupartdb'];
                                    var status = data['status'];
                                    if (employee !== null && Array.isArray(employee) && employee
                                        .length != []) {
                                        let i = 1;
                                        employee.forEach(el => {
                                            var dateObject = new Date(formattedDate2);

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



                                            statusLabelView = (
                                                empData[el.emp_id][0] === 8 ?
                                                '<span id="statusLabelView" class="halfday-status-badge">Halfday</span>' :
                                                (empData[el.emp_id][0] === 2 ?
                                                    '<span id="statusLabelView" class="absent-status-badge">Absent</span>' :
                                                    (empData[el.emp_id][0] === 4 ?
                                                        '<span id="statusLabelView" class="mispunch-status-badge">Mispunch</span>' :
                                                        (empData[el.emp_id][0] ===
                                                            1 || empData[el.emp_id][
                                                                0
                                                            ] === 9 || empData[el
                                                                .emp_id][0] === 3 ||
                                                            empData[el.emp_id][
                                                                0
                                                            ] === 12 ?
                                                            '<span id="statusLabelView" class="present-status-badge">Present</span>' :
                                                            ((empData[el.emp_id][
                                                                    0
                                                                ] === 6) ?
                                                                '<span id="statusLabelView" class="holiday-status-badge">Holiday</span>' :
                                                                ((empData[el.emp_id]
                                                                        [0] === 7) ?
                                                                    '<span id="statusLabelView" class="weekoff-status-badge">Week Off</span>' :
                                                                    '<span id="statusLabelView" class="absent-status-badge">Absent</span>'
                                                                )))))
                                            );
                                            emptyArray[empData[el.emp_id][0]]++;
                                            var number = 0;
                                            var newRow = '<tr>' +
                                                '<td>' + `<div class="d-flex">
                                        <span class="avatar avatar-md brround me-3 rounded-circle"
                                            style="background-image: url('/storage/livewire_employee_profile/` + el
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
                                                '<td>' + (el.emp_today_current_status >=
                                                    '1' ? el
                                                    .punch_in_time : '-') +
                                                `<small id="inTime${el.emp_id}" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                data-bs-container="body"
                                                data-bs-content="Content."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html=true title="Title"><i class="fa fa-info-circle"></i></small>` +
                                                (empData[el.emp_id][12] > 0 ?
                                                    '<br><span class="late-status fs-9 fw-bolder">Late By:' +
                                                    parseInt(empData[el.emp_id][12] /
                                                        60) + 'Hr ' + parseInt(empData[
                                                        el.emp_id][12] % 60) +
                                                    'Min</span>' : '') +
                                                '</td>' +

                                                '<td>' + (el.emp_today_current_status ==
                                                    '2' ? el
                                                    .punch_out_time : '-') +
                                                `<small id="outTime${el.emp_id}" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                data-bs-container="body"
                                                data-bs-content="Content."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html=true title="Title"><i class="fa fa-info-circle"></i></small>` +
                                                (
                                                    empData[el.emp_id][13] > 0 ?
                                                    '<br><span class="late-status fs-9 fw-bolder">Early Exit By:' +
                                                    parseInt(empData[el.emp_id][13] /
                                                        60) + 'Hr ' + parseInt(empData[
                                                        el.emp_id][13] % 60) +
                                                    'Min</span>' : '') + '</td>' +
                                                '</td>' +

                                                '<td>' + ((el.total_working_hour !==
                                                        null && el.total_working_hour !=
                                                        undefined) ? (el
                                                        .total_working_hour.split(":")
                                                        .slice(0, 2).join(":")) + ' ' +
                                                    'Min.' : '') +
                                                `<small id="workingHour${el.emp_id}" style="background-color:transparent;" class="m-0 badge badge-info-light d-none" data-bs-trigger="hover"
                                                data-bs-container="body"
                                                data-bs-content="Content."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html=true title="Title"><i class="fa fa-info-circle"></i></small>` +
                                                (empData[el.emp_id][8] > 0 ?
                                                    '<br><span class="overtime-status fs-9 fw-bolder">OT By:' +
                                                    parseInt(empData[el.emp_id][8] /
                                                        60) + 'Hr ' + parseInt(empData[
                                                        el
                                                        .emp_id][8] % 60) +
                                                    'Min</span>' : '') +
                                                '</td>' +

                                                '<td>' + (el.method_name == undefined ?
                                                    '-' : el.method_name) + '</td>' +

                                                '<td>' +
                                                (status[el.id] == undefined ? '-' :
                                                    status[el.id]) +
                                                '</td>' +

                                                '<td><div class="d-flex justify-content-end">'
                                            if ((((data.checkapprovaltype == 1) && (el
                                                    .forward_by_role_id == data
                                                    .loginroleid)) || (data
                                                    .checkapprovaltype == 2)) && ((el
                                                    .final_status == 0) && (data
                                                    .loginroleid != undefined) && (
                                                    el.forward_by_role_id !=
                                                    undefined) && (el
                                                    .emp_today_current_status == 2))) {
                                                newRow += `
                                                        <label class="custom-control custom-checkbox-md me-5 p-0">
                                                            <input id="check_my_data${el.id}"
                                                                data-my_id="${el.id}"
                                                                onclick="checkboxcheck(this, ${el.id})"
                                                                type="checkbox"
                                                                class="checkbox-checkbox checkbox-sm custom-control-input-success"
                                                                name="checkbox[]"
                                                                value="${el.id}">
                                                            <span class="custom-control-label-md success"></span>
                                                        </label>
                                                    `;
                                            }

                                            newRow += `
                                        <?php if(in_array('Daily Attendance.Update', $permissions)){ ?>
                                        <a class="btn btn-sm"
                                                            data-name="` + el.emp_name + ' ' + (el.emp_mname != null ?
                                                    el.emp_mname : '') + ' ' + el
                                                .emp_lname + `"
                                                            data-empid="${el.emp_id}"
                                                            data-in="${el.punch_in_time || '00:00'}" data-out="${el.punch_out_time || '00:00'}"
                                                            data-shiftname="${el.punch_in_shift_name}"
                                                            data-shiftstart="${el.shift_start}"
                                                            data-shiftend="${el.shift_end}"
                                                            data-punchdate="${formattedDate}"
                                                            onclick="correctionModalJs(this)">
                                                            <i class="feather feather-edit btn-light p-1 " data-bs-toggle="tooltip"
                                                                data-original-title="View"></i>
                                                        </a>


                                        <a id="actionBtn${el.emp_id}" class="btn  btn-icon btn-sm"
                                                data-bs-target="#presentmodal"
                                                data-today_status="${el.today_status || 0}"
                                                data-id="${el.id}"
                                                data-processcomplete="${el.process_complete}"
                                                data-viewbtn="${el.final_status}"
                                                data-forwardbystatus="${el.forward_by_status}"
                                                data-currentstatusparticulartb="${currentstatus[el.id] ?? 0}"
                                                data-forwardroleid=' ${el.forward_by_role_id}'
                                                data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                                                data-in="${el.punch_in_time}"
                                                data-corrected_by=""
                                                data-out="${el.punch_out_time}"
                                                data-attendance_shift_type_items_break_min="${el.brack_time}"
                                                data-twh="${el.total_working_hour}"
                                                data-inloc="${el.punch_in_address}"
                                                data-outloc="${el.punch_out_address}"
                                                data-shiftname="${el.applied_shift_type_name}"
                                                data-breakhr="${el.break_extra_hr}"
                                                data-breakmin="${el.brack_time}"
                                                data-brack_time="${el.brack_time}"
                                                data-overtime="${el.overtime}"
                                                data-punchinselfie="${el.punch_in_selfie}"
                                                data-punchoutselfie="${el.punch_out_selfie}"
                                                data-worFroMeth="${el.working_from_method}"
                                                data-punchselfimode="${el.active_selfie_mode}"
                                                data-punchqrmode="${el.active_qr_mode}"
                                                data-shiftstart="${el.shift_start}"
                                                data-shiftend="${el.shift_end}"
                                                data-emp_today_current_status="${el.emp_today_current_status}"
                                                data-corrected_by="${el.emp_today_current_status}"
                                                data-punch-date="${formattedDate2}"
                                                onclick="showPresentModal(this)">
                                                <i class="feather feather-eye btn-light p-1" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a><?php  } ?>`;

                                            newRow += '</div></td></tr>';
                                            tbody.append(newRow);
                                        });
                                        $('[data-bs-toggle="popover"]').popover({
                                            trigger: 'hover'
                                        });

                                        setTimeLog(data['timeLog']);
                                        // $('#approveAll').prop('disabled', false);
                                    } else {
                                        // $('#approveAll').prop('disabled', true);
                                    }

                                });


                            }
                        });
                    });
                });

                function setTimeLog(Log) {
                    Log.forEach(log => {
                        log.forEach(element => {
                            var workinPop = document.getElementById('workingHour' + element.emp_id);
                            var outPop = document.getElementById('outTime' + element.emp_id);
                            var inPop = document.getElementById('inTime' + element.emp_id);

                            var actionBtn = document.getElementById('actionBtn' + element.emp_id);

                            if (element.changer_name) {
                                actionBtn.setAttribute('data-corrected_by',
                                    '<span class="text-primary" id="inCorrectionLine">' +
                                    element.changer_name + '(' + element.changer_role + ')' + '</span>');
                            } else {
                                actionBtn.setAttribute('data-corrected_by', '');
                            }



                            workinPop.classList.remove('d-none');
                            workinPop.setAttribute('data-bs-original-title', 'Attendance Log '); // title content
                            workinPop.setAttribute('data-bs-content', 'From ' + element.prev_total_work +
                                ' Hrs. to ' +
                                element
                                .changed_total_work + ' Hrs. <br/> By <b>' + element.changer_name + '</b> (' +
                                element
                                .changer_role + ')' + '<br/>Created at ' + element.change_date + ' <b><br/>' +
                                element
                                .reason + '</b>'); // title content
                            var popoverInstance = new bootstrap.Popover(workinPop);
                            popoverInstance.update();


                            outPop.classList.remove('d-none');
                            outPop.setAttribute('data-bs-original-title', 'Attendance Log '); // title content
                            outPop.setAttribute('data-bs-content', 'From ' + element.prev_out_time + ' to ' +
                                element
                                .changed_out_time + '<br/> By <b>' + element.changer_name + '</b> (' + element
                                .changer_role + ')' + '<br/>Created at ' + element.change_date + ' <b><br/>' +
                                element
                                .reason + '</b>'); // title content
                            var popoverInstance1 = new bootstrap.Popover(outPop);
                            popoverInstance1.update();



                            inPop.classList.remove('d-none');
                            inPop.setAttribute('data-bs-original-title', 'Attendance Log '); // title content
                            inPop.setAttribute('data-bs-content', 'From ' + element.prev_in_time + ' to ' + element
                                .changed_in_time + '<br/> By <b>' + element.changer_name + '</b> (' + element
                                .changer_role + ')' + '<br/>Created at ' + element.change_date + ' <b><br/>' +
                                element
                                .reason + '</b>'); // title content
                            var popoverInstance2 = new bootstrap.Popover(inPop);
                            popoverInstance2.update();



                        });
                    });
                }

                function setCount(allStatusCount) {

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
                    var parallerApprovalRolecheck = '<?= $parallerCaseApprovalListRoleIdCheck ?>';
                    var status = $(context).data('today_status');
                    var punchDate = $(context).data('punch-date');
                    $('#punchDateTime').html(punchDate);

                    if (status == 2 || status == 0) {
                        Swal.fire({
                            // title: 'No Data Found',
                            timer: 3000,
                            timerProgressBar: true,
                            text: 'No Data Found.',
                            icon: 'error',
                        });
                    } else {
                        $('#presentmodal').modal('show');
                    }
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
                    var inTime = (inTime ?? '');
                    var outTime = (outTime ?? '');
                    var shiftStartTime = $(context).data('shiftstart');
                    var shiftEndTime = $(context).data('shiftend');
                    var shiftName = $(context).data('shiftname');

                    $('#attendanceShiftStart').html(shiftStartTime);
                    $('#attendanceShiftEnd').html(shiftEndTime);
                    $('#attendanceShiftName').html(shiftName);

                    var empTodayCurrentStatus = $(context).data('emp_today_current_status');
                    var twh = $(context).data('twh');
                    var addtimes = calculateWorkingHours(shiftStartTime, shiftEndTime);
                    var addtimesSecond = calculateWorkingHours(addtimes, twh);
                    var inLoc = $(context).data('inloc');
                    var outLoc = $(context).data('outloc');

                    var correctedBy = $(context).data('corrected_by');
                    if (!outLoc) {
                        $('#outLocationSec').addClass('d-none');
                    } else {
                        $('#outLocationSec').removeClass('d-none');
                    }

                    if (!inLoc) {
                        $('#inLocationSec').addClass('d-none');
                    } else {
                        $('#inLocationSec').removeClass('d-none');
                    }

                    $('#inCorrectionHead').html(correctedBy ? 'Corrected By: <span class="text-primary" id="inCorrectionLine">' +
                        correctedBy + '</span>' : '');
                    $('#outCorrectionHead').html(correctedBy ? 'Corrected By: <span class="text-primary" id="outCorrectionLine">' +
                        correctedBy + '</span>' : '');


                    if (empTodayCurrentStatus == 1) {
                        $('#inLocationSection').removeClass('d-none');
                        $('#PresentModalFooter').addClass('d-none');

                        $('#outLocationSection').addClass('d-none');
                    } else if (empTodayCurrentStatus == 2) {
                        $('#inLocationSection').removeClass('d-none');
                        $('#outLocationSection').removeClass('d-none');
                        $('#PresentModalFooter').removeClass('d-none');

                    } else {
                        $('#PresentModalFooter').addClass('d-none');
                        $('#inLocationSection').addClass('d-none');
                        $('#outLocationSection').addClass('d-none');
                    }

                    $('#inLocation').html(inLoc);
                    $('#punchOutLocation').html(outLoc);

                    var breakHr = $(context).data('breakhr');
                    var breakMin = $(context).data('breakmin');
                    var attendanceShiftBreakMin = $(context).data('attendance_shift_type_items_break_min');
                    var totalBreakHrMin = (breakHr * 60) + breakMin + attendanceShiftBreakMin;
                    var actualBreakTime = parseInt(totalBreakHrMin / 60).toString().padStart(2, '0') + ':' + (totalBreakHrMin % 60)
                        .toString().padStart(2, '0');

                    var overTimeInMinutes = $(context).data('overtime');
                    var punchQrMode = $(context).data('punchqrmode');
                    var punchSelfiMode = $(context).data('punchselfimode');
                    // var attendance_shift_type_items_break_min
                    var punchInSelfieV = $(context).data('punchinselfie');
                    var punchOutSelfieV = $(context).data('punchoutselfie');
                    var attendancestatus = $(context).data('final_status');


                    var hours = Math.floor(overTimeInMinutes / 60);
                    var minutes = overTimeInMinutes % 60;
                    var formattedHours = ('0' + hours).slice(-2);
                    var formattedMinutes = ('0' + minutes).slice(-2);
                    var brackTime = $(context).data('brack_time');
                    // Format the result
                    var formattedTime = formattedHours + ":" + formattedMinutes;
                    $('#editShiftStart').val(shiftStartTime);
                    $('#editShiftEnd').val(shiftEndTime);


                    $('#modalPunchIn').html(inTime);
                    $('#modalPunchOut').html(outTime);
                    $('#modalWorkingHr').html(twh);
                    $('#modalBreakTime').html(attendanceShiftBreakMin);
                    $('#modalOverTime').html(formattedTime);
                    $('#puchInAt').html(inTime);
                    $('#punchOutAt').html(outTime);

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
                        if (parseInt(forwardRoleid) == parseInt(loginRoleID)) {
                            $('#PresentModalFooter').show();
                        }
                        if (parseInt(process_complete) != 0) {
                            $('#PresentModalFooter').hide();
                        } else if (parseInt(forwardRoleid) != parseInt(loginRoleID)) {
                            $('#PresentModalFooter').hide();
                        }
                    }
                    if (parseInt(checkApprovalCycleType) == 2) {

                        if (parseInt(current_status_particulartb) != 0) {
                            $('#PresentModalFooter').hide();
                        }
                        if (parseInt(process_complete) != 0) {
                            $('#PresentModalFooter').hide();
                        } else {
                            console.log("parallerApprovalRolecheck ", parallerApprovalRolecheck);
                            if (parallerApprovalRolecheck) {
                                $('#PresentModalFooter').show();
                            } else {
                                $('#PresentModalFooter').hide();
                            }
                        }
                    }

                    var intimeWithoutSeconds = (inTime != '0' && inTime != null) ? inTime.split(":").slice(0, 2).join(":") :
                        ''; // Remove the seconds
                    var outtimeWithoutSeconds = (outTime != '0' && outTime != null) ? outTime.split(":").slice(0, 2).join(":") :
                        ''; // Remove the seconds
                    var overtimeWithoutSeconds = addtimesSecond ? addtimesSecond.split(":").slice(0, 2).join(":") : '';
                    var punchInAtModel = inTime ?? '';
                    var punchOutAtModel = outTime ?? '';

                    $('#modalPunchIn').val(intimeWithoutSeconds);
                    empTodayCurrentStatus == 2 ? $('#modalPunchOut').val(outtimeWithoutSeconds) : $('#modalPunchOut').val('');

                    empTodayCurrentStatus == 2 ? $('#modalWorkingHr').html(twh) : '';
                    var formatted_bracktime = `00:${String(brackTime).padStart(2, '0')}`;
                    // $('#modalWorkingHr').html(twh);
                    $('#modalBreakTime').html(breakMin);
                    $('.shiftName').html(shiftName);
                    $('#inputPunchInInputEditModel').val(inTime);
                    $('#inputPunchOutInputEditModel').val(outTime);
                    $('#modalBreakTime').html(formatted_bracktime);
                    $('#modalOverTime').html(formattedTime);
                }

                function calculateWorkingHours(punchInTime, punchOutTime) {
                    // Split the time values into hours, minutes, and seconds

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

                function checkboxcheck(checked, id) {
                    var new_data = $(checked).data('my_id');


                    var elm = document.getElementById('check_my_data' + id);

                    if (elm) {
                        if (elm.checked) {
                            // $('#hdkfh' + id).val(1);
                            $('#myAttendanceCheck' + id).val("1");


                        } else {

                            $('#myAttendanceCheck' + id).val("0");

                        }
                    } else {

                    }
                }

                function checkbox_dd(context) {
                    if ($('.custom-control-input-success').prop('checked')) {
                        $('.checkbox-checkbox').prop('checked', true); // Check the checkboxes

                    } else {
                        $('.checkbox-checkbox').prop('checked', false); // Uncheck the checkboxes

                    }
                }
            </script>
        @endif
    @endsection
