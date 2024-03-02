@php
    $centralUnit = new App\Helpers\Central_unit();
    $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
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
<div>
    <livewire:attendance.attendance-modal-livewire />
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
                                <button type="submit" class="btn ripple btn-primary " name="pendingAll"
                                    {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkSeqId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}>Approve</button>
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
                <div class="row m-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <p class="form-label">Branch</p>
                            <div class="form-group" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                <div class="input-group">
                                    <select wire:model="branchFilter" wire:change="getDepartment" class="form-control"
                                        x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                        <option value="">All Branch</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i x-show="isOpen" class="fa fa-caret-up"></i>
                                            <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <p class="form-label">Department</p>
                            <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                <div class="input-group">
                                    <select wire:model="departmentFilter" name="department_id" class="form-control"
                                        x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                        <option value="">All Department </option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i x-show="isOpen" class="fa fa-caret-up"></i>
                                            <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <p class="form-label">Designation</p>
                            <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                <div class="input-group">
                                    <select wire:model="designationFilter" wire:change="getDesignation"
                                        id="designation_id" class="form-control" x-on:focus="isOpen = true"
                                        x-on:blur="isOpen = false">
                                        <option value="">All Designation</option>
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i x-show="isOpen" class="fa fa-caret-up"></i>
                                            <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="feather feather-calendar"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control " wire:model="dateFilter"
                                    placeholder="DD-MM-YYYY">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p class="form-label">Search</p>
                            <div class="form-group mb-3">
                                <input type="text" wire:model="searchFilter" placeholder="Search"
                                    class="form-control" />
                            </div>
                        </div>
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
                                        <th class="border-bottom-0 justify-content-center text-center d-flex">
                                            @php
                                                // dd($checkApprovalCycleType , $checkApprovalPermission , $checkApprovalforwardId , $approvalPendingCount);
                                            @endphp

                                            @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                                                <div
                                                    class="hr-checkall col-md-12 col-lg-2 {{ $checkApprovalCycleType == 1 ? ($checkApprovalPermission == null || $checkApprovalforwardId == null || $approvalPendingCount == 0 ? 'disabled' : '') : ($checkApprovalCycleType == 2 ? ($checkApprovalPermission == null || $approvalPendingCount == 0 ? 'disabled' : '') : '') }}">
                                                    <div class="d-flex float-end align-items-center">
                                                        <label class="custom-control custom-checkbox-md me-5 p-0">
                                                            <input type="checkbox"
                                                                class="custom-control-input-success"
                                                                {{ $valueForCheckBox == 0 ? 'disabled' : '' }}
                                                                onclick="checkbox_dd(this)" name="example-checkbox1"
                                                                value="option1">
                                                            <span class="custom-control-label-md success"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                            <span class="mt-3">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($DATA as $key => $item)
                                        @php
                                            $centralUnit->MyCountForDaily(
                                                $item->punch_date,
                                                $item->business_id,
                                                $item->branch_id,
                                                Session::get('login_role'),
                                                Session::get('login_emp_id'),
                                            );
                                            $Status = $centralUnit->getAttendanceSummaryDetaisl([
                                                'emp_id' => $item->emp_id,
                                                'punch_date' => $item->punch_date,
                                            ])[0];
                                            $EmpName = $item->emp_name ?? '';
                                            $EmpMName = $item->emp_mname ?? '';
                                            $EmpLName = $item->emp_lname ?? '';
                                            $EmpID = $item->emp_id ?? '';
                                            $EmpShiftName = $item->applied_shift_type_name ?? '';
                                            $EmpShiftStart = $RuleManagement->Convert24To12(
                                                $item->applied_shift_comp_start_time ?? '',
                                            );
                                            $EmpShiftEnd = $RuleManagement->Convert24To12(
                                                $item->applied_shift_comp_end_time ?? '',
                                            );
                                            $InTime = $item->punch_in_time;
                                            $OutTime = $item->punch_out_time;
                                            $PunchDate = $item->punch_date;
                                            $TotalWorking = $item->total_working_hour;
                                            $WorkFrom = $item->method_name;
                                            $lateby = $item->late_by;
                                            $earlyExitBy = $item->early_exit;
                                            $overTime = $item->overtime;
                                            $TimeLog = $centralUnit->getTimeLog($EmpID, $PunchDate);

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
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3 rounded-circle"
                                                        style="background-image: url('/storage/livewire_employee_profile/{{ $item->profile_photo }}')"></span>
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1 fs-14">
                                                            <a href="{{ route('employeeProfile', [$item->emp_id]) }}">
                                                                {{ $item->emp_name }}&nbsp;{{ $item->emp_mname }}&nbsp;{{ $item->emp_lname }}
                                                            </a>
                                                        </h6>
                                                        <p class="text-muted mb-0 fs-12">
                                                            <?= $centralUnit->DesingationIdToName($item->designation_id) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->emp_id }}</td>
                                            <td><span id="statusLabelView"
                                                    class="{{ $badgeColors[$Status] }}">{{ $statusLabels[$Status] }}</span>
                                            </td>
                                            <td>{{ date('d-M-Y', strtotime($PunchDate)) }}</td>
                                            <td>
                                                <div wire:key="{{ $key }}">
                                                    {{ $InTime ?? '--' }}

                                                    <small id="popoverPunchIn{{ $item->id }}"
                                                        style="background-color:transparent;"
                                                        class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                        title="Attendance Log"><i
                                                            class="fa fa-info-circle"></i></small>
                                                    <script>
                                                        // Top popover is not working only
                                                        $(document).ready(function() {
                                                            $('#popoverPunchIn{{ $item->id }}').popover({
                                                                placement: 'right',
                                                                trigger: 'hover',
                                                                html: true,
                                                                content: `{!! count($TimeLog) != 0
                                                                    ? implode(
                                                                        ', ',
                                                                        $TimeLog->map(function ($log) {
                                                                                return $log->prev_in_time .
                                                                                    ' to ' .
                                                                                    $log->changed_in_time .
                                                                                    '<br/> By <b>' .
                                                                                    $log->changer_name .
                                                                                    '</b>(' .
                                                                                    $log->changer_role .
                                                                                    ')' .
                                                                                    '<br> at ' .
                                                                                    date('d-M-y', strtotime($log->change_date)) .
                                                                                    '<br><b>' .
                                                                                    $log->reason .
                                                                                    '</b><br/><hr/>';
                                                                            })->toArray(),
                                                                    )
                                                                    : '' !!}`
                                                            });
                                                        });
                                                    </script>
                                                    @if ($lateby > 0)
                                                        <br><span class="late-status fs-10 fw-bolder">
                                                            {{ $lateby > 0 ? 'Late By: ' . (intval($lateby / 60) ? intval($lateby / 60) . ' Hr ' : '') . (intval($lateby % 60) ? intval($lateby % 60) . ' Min' : '') : '' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>

                                                <div wire:key="{{ $key }}">
                                                    {{ $OutTime ?? '--' }}

                                                    <small id="popoverPunchOut{{ $item->id }}"
                                                        style="background-color:transparent;"
                                                        class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                        title="Attendance Log"><i
                                                            class="fa fa-info-circle"></i></small>
                                                    <script>
                                                        // Top popover is not working only
                                                        $(document).ready(function() {
                                                            $('#popoverPunchOut{{ $item->id }}').popover({
                                                                placement: 'right',
                                                                trigger: 'hover',
                                                                html: true,
                                                                content: `{!! count($TimeLog) != 0
                                                                    ? implode(
                                                                        ', ',
                                                                        $TimeLog->map(function ($log) {
                                                                                return $log->prev_out_time .
                                                                                    ' to ' .
                                                                                    $log->changed_out_time .
                                                                                    '<br/> By <b>' .
                                                                                    $log->changer_name .
                                                                                    '</b>(' .
                                                                                    $log->changer_role .
                                                                                    ')' .
                                                                                    '<br> at ' .
                                                                                    date('d-M-y', strtotime($log->change_date)) .
                                                                                    '<br><b>' .
                                                                                    $log->reason .
                                                                                    '</b><hr/>';
                                                                            })->toArray(),
                                                                    )
                                                                    : '' !!}`
                                                            });
                                                        });
                                                    </script>
                                                    @if ($earlyExitBy > 0)
                                                        <br><span class="late-status fs-10 fw-bolder">
                                                            {{ $earlyExitBy > 0 ? 'Early Exit By: ' . (intval($earlyExitBy / 60) ? intval($earlyExitBy / 60) . ' Hr ' : '') . (intval($earlyExitBy % 60) ? intval($earlyExitBy % 60) . ' Min' : '') : '' }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </td>
                                            <td>
                                                <div wire:key="{{ $key }}">
                                                    {{ $TotalWorking ?? '--' }}
                                                    <small id="popoverTotalWorking{{ $item->id }}"
                                                        style="background-color:transparent;"
                                                        class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                        title="Attendance Log"><i
                                                            class="fa fa-info-circle"></i></small>

                                                    <script>
                                                        // Top popover is not working only
                                                        $(document).ready(function() {
                                                            $('#popoverTotalWorking{{ $item->id }}').popover({
                                                                placement: 'right',
                                                                trigger: 'hover',
                                                                html: true,
                                                                content: `{!! count($TimeLog) != 0
                                                                    ? implode(
                                                                        ', ',
                                                                        $TimeLog->map(function ($log) {
                                                                                return $log->prev_total_work .
                                                                                    ' to ' .
                                                                                    $log->changed_total_work .
                                                                                    ' <br/>By <b>' .
                                                                                    $log->changer_name .
                                                                                    '</b>(' .
                                                                                    $log->changer_role .
                                                                                    ')' .
                                                                                    '<br> at ' .
                                                                                    date('d-M-y', strtotime($log->change_date)) .
                                                                                    '<br><b>' .
                                                                                    $log->reason .
                                                                                    '</b><br/><hr/>';
                                                                            })->toArray(),
                                                                    )
                                                                    : '' !!}`
                                                            });
                                                        });
                                                    </script>
                                                    @if ($overTime > 0)
                                                        <br><span class="overtime-status fs-10 fw-bolder">
                                                            {{ $overTime > 0 ? 'Overtime: ' . (intval($overTime / 60) ? intval($overTime / 60) . ' Hr ' : '') . (intval($overTime % 60) ? intval($overTime % 60) . ' Min' : '') : '' }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </td>

                                            <td>{{ $WorkFrom ?? '--' }}</td>
                                            <td> <?php $loadgoo = $item->id ?? 0; ?>
                                                <?= $RuleManagement->AttendanceApprovalManage($checkApprovalCycleType, $item, $loadgoo, 1, $loginRoleID) ?>
                                            </td>

                                            <td>
                                                <input type="text" name="id[]" id="id"
                                                    value="{{ $item->id }}" hidden>

                                                <div class="d-flex justify-content-end">
                                                    @if (
                                                        ($checkApprovalCycleType == 1 &&
                                                            ($item
                                                                ? $item->final_status == 0 &&
                                                                    $item->emp_today_current_status == 2 &&
                                                                    $loginRoleID == $item->forward_by_role_id
                                                                : '')) ||
                                                            ($checkApprovalCycleType == 2 &&
                                                                ($item ? $item->final_status == 0 && $item->emp_today_current_status == 2 : '')))
                                                        <label class="custom-control custom-checkbox-md me-5 p-0 ">
                                                            <input id="check_my_data{{ $item->id ?? '' }}"
                                                                data-my_id='<?= $item->id ?? '' ?>'
                                                            onclick="checkboxcheck(this, {{ $item->id ?? '' }})"
                                                            type="checkbox"
                                                            class="checkbox-checkbox custom-control-input-success p-0"
                                                            name="checkbox[]"
                                                            value="{{ $item->id ?? '' }}">
                                                            <span class="custom-control-label-md success p-0"></span>
                                                        </label>
                                                    @endif
                                                    <?php $sendData = [$InTime, $OutTime, $TotalWorking, $item->punch_in_address, $item->punch_out_address, $EmpShiftName, $item->brack_time, $item->overtime, $item->punch_in_selfie, $item->punch_out_selfie, $CorrectedBy, date('Y-m-d', strtotime($PunchDate)), $EmpShiftStart, $EmpShiftEnd, $EmpID, $Status, $statusLabels[$Status], 1, 0]; ?>

                                                    @if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.Update', $permissions))
                                                        <a type="button" class="btn btn-light btn-icon btn-sm m-1"
                                                            data-bs-toggle="modal" data-bs-target="#CorrectionModal"
                                                            wire:click="showPresentModel('<?php echo htmlentities(json_encode($sendData)); ?>')">
                                                            <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                                data-original-title="View"></i>
                                                        </a>
                                                    @endif
                                                    <a type="button" class="btn btn-light btn-icon btn-sm m-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#{{ in_array($Status, [1, 3, 4, 8, 9, 12]) ? 'livewire-present-modal' : (in_array($Status, [6, 7, 10, 11]) ? 'holidayModal' : 'absentModal') }}"
                                                        wire:click="showPresentModel('<?php echo htmlentities(json_encode($sendData)); ?>')">
                                                        <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label for="perPage">Per Page:</label>

                                    <div class="form-group mb-3" x-data="{ isOpen: false }"
                                        x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <select wire:model.debounce.350ms="perPage" class="form-control"
                                                x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i x-show="isOpen" class="fa fa-caret-up"></i>
                                                    <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    {!! $DATA->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (in_array('Daily Attendance.All', $permissions) || in_array('Daily Attendance.Update', $permissions))
                        <div class="card-footer">
                            <button id="approveAll" class="btn btn-primary float-end" name="approveAll"
                                {{ $valueForCheckBox == 0 ? 'disabled' : '' }} value="1" type="submit">Approve
                                All</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
