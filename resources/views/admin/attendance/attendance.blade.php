    @extends('admin.pagelayout.master')

    @section('title')
        Attendance
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
            // dd($Count);
        @endphp
        <!-- ROW -->

        <div class=" p-0 pb-4">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
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
                $nss = new App\Helpers\Central_unit();
                $EmpID = $nss->EmpPlaceHolder();
                $LeaveCount = $nss->LeaveSectionCount();
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
                                    id="totalEmployeeCount">0</span>
                                <h5 class="mb-0 mt-3">Total Employee</h5>
                            </div>
                            <div class=" col-6 col-md-4 col-xl-2 text-center py-5 ">
                                <span class="avatar avatar-md bradius fs-20 bg-success-transparent"
                                    id="presentEmployeeCount">0</span>
                                <h5 class="mb-0 mt-3">Present</h5>
                            </div>
                            <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                                <span class="avatar avatar-md bradius fs-20 bg-danger-transparent"
                                    id="absentEmployeeCount">0</span>
                                <h5 class="mb-0 mt-3">Absent</h5>
                            </div>
                            <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                                <span class="avatar avatar-md bradius fs-20 bg-warning-transparent"
                                    id="halfdayEmployeeCount">0</span>
                                <h5 class="mb-0 mt-3">Half Days</h5>
                            </div>
                            <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5 ">
                                <span class="avatar avatar-md bradius fs-20 bg-orange-transparent"
                                    id="lateEmployeeCount">0</span>
                                <h5 class="mb-0 mt-3">Late</h5>
                            </div>
                            <div class="col-6 col-md-4 col-sm-6 col-xl-2 text-center py-5">
                                <span class="avatar avatar-md bradius fs-20 bg-pink-transparent"
                                    id="leaveEmployeeCount">0</span>
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
                        <div class="card-body ">
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
                                            <th class="border-bottom-0">Late By</th>
                                            <th class="border-bottom-0">Working From</th>
                                            <th class="border-bottom-0">Attendance</th>
                                            <th class="border-bottom-0">Action
                                            </th>
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
                                                10 => 0, // Overtime
                                                11 => 0, // Overtime
                                            ];
                                        @endphp
                                        @foreach ($DATA as $item)
                                            @php
                                                $centralUnit = new App\Helpers\Central_unit();
                                                $ruleMange = new App\Helpers\MasterRulesManagement\RulesManagement();
                                                $inTime = $item->punch_in_time;
                                                // dd($item);
                                                $outTime = $item->punch_out_time;
                                                $grachTimeHr = $item->grace_time_hr;
                                                $grachTimeMin = $item->grace_time_min;
                                                $shiftStart = $item->shift_start;
                                                $timeDifference = $centralUnit->CalculateTimeDifference($inTime, $outTime);
                                                $resCode = $centralUnit->getEmpAttSumm(['emp_id' => $item->emp_id, 'punch_date' => date('Y-m-d', strtotime($item->punch_date))]);
                                                // dd($resCode);
                                                $lateBy = $ruleMange->CalculateLateBy($shiftStart, $inTime, $grachTimeHr, $grachTimeMin);
                                                $hours = str_pad($timeDifference->h, 2, '0', STR_PAD_LEFT);
                                                $minutes = str_pad($timeDifference->i, 2, '0', STR_PAD_LEFT);
                                                $seconds = str_pad($timeDifference->s, 2, '0', STR_PAD_LEFT);
                                                $status = $resCode[0];
                                                $occurance = $resCode[14];
                                                // dd($resCode);
                                            @endphp
                                            <tr>

                                                <input type="text" name="emp_id[]" id="id"
                                                    value="{{ $item->emp_id }}" hidden>

                                                @if ($item->attendance_status == 0)
                                                    <input type="text" name="myAttendanceCheck[]"
                                                        id="myAttendanceCheck{{ $item->id }}"
                                                        class="myAttendanceCheck"
                                                        value="<?= $item->attendance_status != 0 ? '1' : '0' ?>" hidden>
                                                @else
                                                    <input type="text" name="myAttendanceCheck[]"
                                                        id="myAttendanceCheck{{ $item->id }}" class=""
                                                        value="<?= $item->attendance_status != 0 ? '1' : '0' ?>">
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

                                                    @if ($status == 3)
                                                        @if ($lateOccurrenceIs != 0 && $earlyOccurrenceIs != 0)
                                                            @if ($lateOccurrenceIs == 1)
                                                                @if ($statusCounts[3] >= $lateOccurrence)
                                                                    @if ($lateOccurrencePenalty == 1)
                                                                        $statusCounts[8]++;
                                                                    @else
                                                                        $statusCounts[2]++;
                                                                    @endif
                                                                    @php $statusPrinted = true; @endphp
                                                                @endif
                                                            @elseif ($lateOccurrenceIs == 2)
                                                                @if ($totalLateTime >= $lateOccurrence)
                                                                    @if ($lateOccurrencePenalty == 1)
                                                                        $statusCounts[8]++;
                                                                    @else
                                                                        $statusCounts[2]++;
                                                                    @endif
                                                                    @php $statusPrinted = true; @endphp
                                                                @endif
                                                            @endif

                                                            @if ($earlyOccurrenceIs == 1 && !$statusPrinted)
                                                                @if ($statusCounts[3] >= $earlyOccurrence)
                                                                    @if ($earlyOccurrencePenalty == 1)
                                                                        <?php $statusCounts[8]++; ?>
                                                                    @else
                                                                        <?php $statusCounts[2]++; ?>
                                                                    @endif
                                                                    @php $statusPrinted = true; @endphp
                                                                @endif
                                                            @elseif ($earlyOccurrenceIs == 2 && !$statusPrinted)
                                                                @if ($totalEarlyExitTime >= $earlyOccurrence && !$statusPrinted)
                                                                    @if ($earlyOccurrencePenalty == 1)
                                                                        <?php $statusCounts[8]++; ?>
                                                                    @else
                                                                        <?php $statusCounts[2]++; ?>
                                                                    @endif
                                                                    @php $statusPrinted = true; @endphp
                                                                @endif
                                                            @endif
                                                        @else
                                                            <span id="statusLabelView"
                                                                class="{{ $badgeColors[3] }}">{{ $statusLabels[3] }}</span>
                                                            @php $statusPrinted = true; @endphp
                                                        @endif
                                                    @endif

                                                    @if (!$statusPrinted)
                                                        <span id="statusLabelView"
                                                            class="{{ $badgeColors[$status] }}">{{ $statusLabels[$status] }}</span>
                                                        <? $statusCounts[$status]++; ?>
                                                    @endif

                                                    <?php $statusCounts[$status]++; ?>

                                                    {{-- <span id="statusLabelView"
                                                        class="badge badge-{{ $badgeColors[$status] }}-light">{{ $statusLabels[$status] }}</span> --}}
                                                </td>
                                                <td>{{ $item->punch_date }}</td>
                                                <td><?= $ruleMange->Convert24To12($item->punch_in_time) ?> </td>
                                                {{-- <td>
                                                    @if ($item->marked_in_mode == 1)
                                                        <span class="">QR Code</span>
                                                    @endif
                                                    @if ($item->marked_in_mode == 2)
                                                        <span class="">Face ID </span>
                                                    @endif
                                                    @if ($item->marked_in_mode == 3)
                                                        <span class="">Selfie </span>
                                                    @endif
                                                    @if ($item->marked_out_mode == 1)
                                                        <span class=""> | QR Code</span>
                                                    @endif
                                                    @if ($item->marked_out_mode == 2)
                                                        <span class=""> | Face ID</span>
                                                    @endif
                                                    @if ($item->marked_out_mode == 3)
                                                        <span class=""> | Selfie</span>
                                                    @endif
                                                </td> --}}
                                                <td><?= $item->emp_today_current_status == '2' ? $ruleMange->Convert24To12($item->punch_out_time) : '' ?>
                                                </td>
                                                <td><?= $item->emp_today_current_status == '2' ? ($item->total_working_hour !== null && $item->total_working_hour != 'undefined' ? date('H:i', strtotime($item->total_working_hour)) . ' Min.' : '') : '' ?>
                                                </td>

                                                <td>{{ $lateBy }}</td>
                                                <td>{{ $item->method_name }}</td>
                                                <td>
                                                    @if ($item->attendance_status == 0)
                                                        <span class="badge badge-danger">Pending</span>
                                                    @endif
                                                    @if ($item->attendance_status == 1)
                                                        <span class="badge badge-success">Approved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" name="id[]" id="id"
                                                        value="{{ $item->id }}" hidden>

                                                    {{-- <input type="text" name="leBhaiId" value="{{ $item->id }}" hidden> --}}
                                                    <div class="d-flex justify-content-end">
                                                        @if ($item->attendance_status == 0)
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
                                                        <a class="btn btn-light btn-icon btn-sm"
                                                            data-bs-target="#presentmodal" data-id='<?= $item->id ?>'
                                                            data-in='<?= $inTime ?>' data-out='<?= $outTime ?>'
                                                            data-attendance_shift_type_items_break_min='<?= $item->break_min ?>'
                                                            data-twh='<?= $item->total_working_hour ?>''
                                                            data-inloc='<?= $item->punch_in_address ?>'
                                                            data-outloc='<?= $item->punch_out_address ?>'
                                                            data-shiftname='<?= $item->emp_id ?>'
                                                            data-breakhr='<?= $item->break_extra_hr ?>'
                                                            data-breakmin='<?= $item->break_extra_min ?>'
                                                            data-overtime='<?= $item->emp_id ?>'
                                                            data-punchinselfie='<?= $item->punch_in_selfie ?>'
                                                            data-punchoutselfie='<?= $item->punch_out_selfie ?>'
                                                            data-worFroMeth='<?= $item->working_from_method ?>'
                                                            data-punchselfimode='<?= $item->active_selfie_mode ?>'
                                                            data-punchqrmode='<?= $item->active_qr_mode ?>'
                                                            data-shiftstart='<?= $item->shift_start ?>'
                                                            data-shiftend='<?= $item->shift_end ?>'
                                                            data-attendance_status='<?= $item->attendance_status ?>'
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

                        <input type="text" id="dailyAttendanceCount" data-totalEmployee="{{ $Count[0] }}"
                            data-pesent="{{ $statusCounts[1] }}" data-absent="{{ $statusCounts[2] }}"
                            data-halfday="{{ $statusCounts[8] }}" data-late="{{ $statusCounts[3] }}"
                            data-leave="{{ $statusCounts[10] + $statusCounts[11] }}" hidden>
                    </form>
                </div>
            </div>
        </div>
        <!-- END ROW -->

        <script>
            // Get count element and log it to the console
            var countElement = document.getElementById('dailyAttendanceCount');
            // console.log(countElement);

            // Get employee elements by ID
            var totalEmployee = document.getElementById('totalEmployeeCount');
            var presentEmployee = document.getElementById('presentEmployeeCount');
            var absentEmployee = document.getElementById('absentEmployeeCount');
            var halfdayEmployee = document.getElementById('halfdayEmployeeCount');
            var lateEmployee = document.getElementById('lateEmployeeCount');
            var leaveEmployee = document.getElementById('leaveEmployeeCount');

            // Get values from data attributes
            var totalEmployeeValue = countElement.getAttribute('data-totalEmployee');
            var presentValue = countElement.getAttribute('data-pesent');
            var absentValue = countElement.getAttribute('data-absent');
            var halfdayValue = countElement.getAttribute('data-halfday');
            var lateValue = countElement.getAttribute('data-late');
            var leaveValue = countElement.getAttribute('data-leave');

            // Update innerHTML of presentEmployee element with presentValue
            totalEmployee.innerHTML = totalEmployeeValue;
            presentEmployee.innerHTML = presentValue;
            absentEmployee.innerHTML = totalEmployeeValue - presentValue - halfdayValue - lateValue - leaveValue;
            halfdayEmployee.innerHTML = halfdayValue;
            lateEmployee.innerHTML = lateValue;
            leaveEmployee.innerHTML = leaveValue;
        </script>

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
                    <form id="modalForm" action="{{ route('attendance.update') }}" method="POST"
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
                                            <div class="col-4">
                                                <div class="pt-5 text-center"> <input type="time"
                                                        class="form-control fs-14 p-0" id="modalPunchIn"
                                                        name="editPunchInTime" value="">
                                                    {{-- <h6 class="mb-1 fs-16 font-weight-semibold" id="">12:00</h6> --}}
                                                    <small class="text-muted fs-14">Punch In</small>
                                                </div>
                                            </div>
                                            {{-- <canvas id="myChart" style="width:10%;max-width:200px"></canvas> --}}
                                            {{-- <div class="col-md-4">
                                                <div class="chart-circle chart-circle-md" data-value="100"
                                                    data-thickness="8" data-color="#0dcd94">
                                                    <div class="chart-circle-value text-muted" id="modalWorkingHr">09:05
                                                        hrs</div>
                                                </div>
                                            </div> --}}

                                            <div class="col-4">
                                                <div class="chart-circle chart-circle-md rounded-circle" data-value="100"
                                                    data-thickness="6" data-color="#0dcd94">
                                                    <div class="chart-circle-value text-muted" id="modalWorkingHr"
                                                        style="border:5px solid #0DCD94; border-radius: 50px;                                                     ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="pt-5 text-center">
                                                    <input type="time" class="form-control fs-14 p-0"
                                                        id="modalPunchOut" name="editPunchOutTime" value="">

                                                    {{-- <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchOut">12:00</h6> --}}
                                                    <small class="text-muted fs-14">Punch Out</small>
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
                        <div class="modal-footer PresentModalFooter">
                            <a href="javascript:void(0);" class="btn btn-danger"
                                data-bs-dismiss="modal">close</a>
                            <button href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-dismiss="modal" type="submit">Approve</button>
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
                            {{-- <a href="javascript:void(0);" class="btn btn-outline-dark" data-bs-dismiss="modal">close</a>
                                            <a href="javascript:void(0);" class="btn btn-primary">Save</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header border-bottom-0">
                <div class="card-title">Radial Bar circle Chart</div>
            </div>
            <div class="card-body">
                <div class="chartjs-wrapper-demo">
                    <div id="chart88" class="h-300 mh-300"></div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card chart-donut1">
                <div class="card-header  border-0">
                    <h4 class="card-title">Gender by Employees</h4>
                </div>
                <div class="card-body">
                    <div id="attendance" onclick="myAttendacneFun()" class="mx-auto apex-dount"></div>
                    <div class="sales-chart pt-5 pb-3 d-flex mx-auto text-center justify-content-center ">
                        <div class="d-flex me-5"><span class="dot-label bg-primary me-2 my-auto"></span>Male</div>
                        <div class="d-flex"><span class="dot-label bg-secondary  me-2 my-auto"></span>Female</div>
                    </div>
                </div>
            </div>
        </div> --}}
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
                    console.log(branchId);
                    var departmentId = $('#state-dd').val();
                    var designationId = $('#desig-dd').val();
                    // var dateSelectValue =;
                    var formattedDate = moment($('#dateselect-dd').val(), "DD MMMM YYYY").format(
                        "YYYY-MM-DD");

                    // console.log(formattedDate);

                    // console.log(formattedDate);

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
                            var tbody = $('.my_body');
                            tbody.empty();
                            console.log(data);
                            $.each(data, function(index, employee) {
                                console.log("employee ", employee);

                                if (employee !== null && Array.isArray(employee) && employee
                                    .length != []) {
                                    console.log("ja raha hai");
                                    let i = 1;

                                    employee.forEach(el => {
                                        // console.log("employee aa", el);
                                        $('#myAttendanceCheck' + el.id).val(el
                                            .attendance_status);
                                        var lateTime = calculateLateBy(el
                                            .shift_start,
                                            el.punch_in_time, el.grace_time_hr,
                                            el
                                            .grace_time_min);
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
                                            '<td>' + '' + '</td>' +
                                            '<td>' + el.punch_date + '</td>' +
                                            '<td>' + convert24To12(el
                                                .punch_in_time) +
                                            '</td>' +
                                            '<td>' + (el.emp_today_current_status ==
                                                '2' ?
                                                convert24To12(el.punch_out_time) :
                                                '') +
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
                                            '<td>' + lateTime + '</td>' +
                                            // '<td>' + el.shift_start + el.shift_end + el.grace_time_hr + el.grace_time_min+ '</td>' +
                                            '<td>' + el.method_name + '</td>' +
                                            '<td>' + (el.attendance_status == 0 ?
                                                `<span class="badge badge-danger">Pending</span>` :
                                                (el.attendance_status == 1 ?
                                                    `<span class="badge badge-success">Approved</span>` :
                                                    '')) + '</td>' +

                                            '<td><div class="d-flex justify-content-end">'
                                        newRow += el.attendance_status != 1 ?

                                            `<label class="custom-control custom-checkbox-md me-5 p-0 ">
                                            <input id="check_my_data${el.id}"
                                                 data-my_id="${el.id}" 
                                                onclick="checkboxcheck(this, ${el.id})"
                                                type="checkbox"
                                                class="checkbox-checkbox custom-control-input-success"
                                                name="checkbox[]" value="${el.id}">
                                            <span class="custom-control-label-md success"></span>
                                        </label>
                                        ` : '';
                                        newRow += `<a class="btn btn-light btn-icon btn-sm"
                                                    data-bs-target="#presentmodal" data-id="${el.id}" 
                                                    data-in="${el.punch_in_time}" data-out="${el.punch_out_time}"
                                                    data-attendance_shift_type_items_break_min="${el.break_min}"
                                                    data-twh="${el.total_working_hour}"
                                                    data-inloc="${el.punch_in_address}"
                                                    data-outloc="${el.punch_out_address}"
                                                    data-shiftname="${el.emp_id}"
                                                    data-breakhr="${el.break_extra_hr}"
                                                    data-breakmin="${el.break_extra_min}"
                                                    // data-overtime="${el.emp_id}"
                                                    data-punchinselfie="${el.punch_in_selfie}"
                                                    data-punchoutselfie="${el.punch_out_selfie}"
                                                    data-worFroMeth="${el.working_from_method}"
                                                    data-punchselfimode="${el.active_selfie_mode}"
                                                    data-punchqrmode="${el.active_qr_mode}"
                                                    data-shiftstart="${el.shift_start}"
                                                    data-shiftend="${el.shift_end}"
                                                    onclick="showPresentModal(this)">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>`;

                                        //                 newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                                //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.emp_id}" 
                                //     data-bs-target="#deletemodal">
                                //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                //         data-original-title="View"></i>
                                // </a>`;
                                        newRow += '</div></td></tr>';
                                        tbody.append(newRow);
                                    });
                                    $('#approveAll').prop('disabled', false);
                                } else {
                                    console.log("kY");
                                    $('#approveAll').prop('disabled', true);
                                }
                                // $(document).ready(function() {
                                // });
                            });

                        }
                    });
                });
            });

            function calculateLateBy(officeShiftStart, punchinTime, graceTimeHr, graceTimeMin) {
                // Actual grace minutes
                var actualGraceMin = graceTimeHr * 60 + graceTimeMin;
                // Split the time strings into hours, minutes, and seconds
                var officeShiftStartParts = officeShiftStart.split(":");
                var punchinTimeParts = punchinTime.split(":");
                var officeShiftStartTime = new Date();
                officeShiftStartTime.setHours(parseInt(officeShiftStartParts[0], 10));
                officeShiftStartTime.setMinutes(parseInt(officeShiftStartParts[1], 10));
                officeShiftStartTime.setSeconds(parseInt(officeShiftStartParts[2], 10));
                var punchinTimeObj = new Date();
                punchinTimeObj.setHours(parseInt(punchinTimeParts[0], 10));
                punchinTimeObj.setMinutes(parseInt(punchinTimeParts[1], 10));
                punchinTimeObj.setSeconds(parseInt(punchinTimeParts[2], 10));
                if (punchinTimeObj >= officeShiftStartTime) {
                    var lateTimeMilliseconds = punchinTimeObj - officeShiftStartTime;
                    var lateTime = new Date(lateTimeMilliseconds);

                    var hours = lateTime.getUTCHours();
                    var minutes = lateTime.getUTCMinutes();
                    var seconds = lateTime.getUTCSeconds();

                    return '-' + hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ' ' + 'Min.';
                }

                return '';
            }
        </script>
        <script>
            function showPresentModal(context) {
                $('#presentmodal').modal('show');
                var id = $(context).data('id');
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
                var overTime = $(context).data('overtime');
                var punchQrMode = $(context).data('punchqrmode');
                var punchSelfiMode = $(context).data('punchselfimode');
                // var attendance_shift_type_items_break_min
                var punchInSelfieV = $(context).data('punchinselfie');
                var punchOutSelfieV = $(context).data('punchoutselfie');
                var attendancestatus = $(context).data('attendance_status');
                var empTodayCurrentStatus = $(context).data('emp_today_current_status');
                console.log("empTodayCurrentStatus " + empTodayCurrentStatus)
                if (attendancestatus == 0) {
                    $('.PresentModalFooter').removeClass('d-none');

                } else {
                    $('.PresentModalFooter').addClass('d-none');

                }
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

                // $('#modalWorkingHr').html(twh);
                $('#inLocation').html(inLoc);
                $('#punchOutLocation').html(outLoc);
                $('#modalBreakTime').html(breakMin);
                $('.shiftName').html(shiftName);
                $('#inputPunchInInputEditModel').val(inTime);
                $('#inputPunchOutInputEditModel').val(outTime);
                $('#modalBreakTime').html(actualBreakTime);
                $('#modalOverTime').html(overtimeWithoutSeconds);
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
