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

        /* @media print{@page {size: landscape}} */
        
    </style>
@endsection

@section('content')
    @php
        $root = new App\Helpers\Central_unit();
        $centralUnit = new App\Helpers\Central_unit();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $ITEM = $LOADED->SectionEmployeeCounters();
        $Designation = $centralUnit->DesignationList();

    @endphp

<div class=" p-0 py-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        {{-- <li><a href="{{ url('/admin/requests/leaves') }}">Attendance</a></li> --}}
        <li class="active"><span><b>Attendance</b></span></li>
    </ol>
</div>
    <!-- PAGE HEADER -->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Attendance</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="btn-list">
                    <a onclick="window.print()" class="btn btn-primary me-3">Print Page</a>
                    <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                        data-bs-original-title="E-mail"> <i class="feather feather-mail"></i> </button>
                    <button class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip" title=""
                        data-bs-original-title="Contact"> <i class="feather feather-phone-call"></i> </button>
                    <button class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip" title=""
                        data-bs-original-title="Info"> <i class="feather feather-info"></i> </button>
                </div>
            </div>
        </div>
    </div>
    <!--END PAGE HEADER -->

    <!-- ROW -->

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='country-dd' id="country-dd" class="form-control" required>
                                    <option value="">--- Select Branch ---</option>
                                    @foreach ($Branch as $data)
                                        <option value="{{ $data->branch_id }}">
                                            {{ $data->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3">
                                    <select id="state-dd" name="department_id" class="form-control" required>
                                        <option value="">--- Select Deparment ---</option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3">
                                    <select id="desig-dd" name="designation_id" class="form-control" required>
                                        <option value="">--- Select Designation ---</option>
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-6 mt-5">
                        <div class="me-3">
                            <label class="form-label">Note:</label>
                        </div>
                        <div>
                            <span class="badge badge-success-light me-2"><i
                                    class="feather feather-check-circle text-success"></i> ---&gt; Present</span>
                            <span class="badge badge-danger-light me-2"><i class="feather feather-x-circle text-danger"></i>
                                ---&gt; Absent</span>
                            <span class="badge badge-warning-light me-2"><i class="fa fa-star text-warning"></i> ---&gt;
                                Holiday</span>
                            <span class="badge badge-orange-light me-2"><i class="fa fa-adjust text-orange"></i> ---&gt;
                                Half Day</span>
                            <span class="badge badge-orange-light me-2"><i class="fa fa-history text-orange"></i> ---&gt;
                                Mis-punch</span>
                            <span class="badge badge-primary-light me-2"><i class="fa fa-calendar-minus-o text-primary"></i>
                                ---&gt;
                                Week Off</span>
                        </div>
                    </div>
                    <div class="table-responsive hr-attlist">
                        <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap border" id="basic-datatable">
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
                                            <tbody>
                                                @foreach ($Emp as $key => $emp)
                                                    {{-- @dd($root->getEmpAttSumm(['emp_id'=>'IT009','punch_date'=>date('Y-m-13')])); --}}
                                                    <tr class="odd border border-bottum">
                                                        <td class="reorder sorting_1">
                                                            <div class="d-flex">
                                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                            style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                                <div class="me-3 mt-0 mt-sm-2 d-block">
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
                                                                        class="hr-listmodal"></a>

                                                                    @if ($resCode[0] == 1 || $resCode[0] == 3 || $resCode[0] == 9)
                                                                        <?php $present++; ?>
                                                                        <span
                                                                            class="feather feather-check-circle text-success "></span>
                                                                    @elseif ($resCode[0] == 2)
                                                                        <span
                                                                            class="feather feather-x-circle text-danger"></span>
                                                                    @elseif ($resCode[0] == 6)
                                                                        <span class="fa fa-star text-warning"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="holiday" data-bs-original-title="Sunday"
                                                                            aria-label="Sunday"></span>
                                                                    @elseif ($resCode[0] == 4)
                                                                    <i class="fa fa-history text-orange"></i>
                                                                    @elseif ($resCode[0] == 7)
                                                                        <i class="fa fa-calendar-minus-o text-primary"></i>
                                                                    @elseif ($resCode[0] == 8)
                                                                    <?php $halfday++; ?>
                                                                        <span class=""><i
                                                                                class="fa fa-adjust text-orange"></i></span>
                                                                    @else
                                                                        <span class=""> </span>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endwhile

                                                        <td>
                                                            <h6 class="mb-0">
                                                                <span class="text-primary">{{ $present + $halfday }}</span>
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
                                                            <span class="avatar avatar-sm brround"
                                                                style="background-image: url(assets/images/users/1.jpg)"></span>
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
                                                            data-bs-target="#PunchIn" class="my-auto">
                                                            <span class="avatar avatar-sm brround"
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

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Details</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Clock In</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" value="9:30 AM">
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-switch mt-md-6">
                                    <input type="checkbox" name="custom-switch-checkbox"
                                        class="custom-switch-input orange">
                                    <span class="custom-switch-indicator "></span>
                                    <span class="custom-switch-description text-dark">Late</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Clock Out</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" value="06: 30 PM">
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-switch mt-md-6">
                                    <input type="checkbox" name="custom-switch-checkbox"
                                        class="custom-switch-input  orange">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-dark">half Day</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">IP Address</label>
                            <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Working Form</label>
                            <select name="projects" class="form-control custom-select select2" disabled
                                data-placeholder="Select">
                                <option label="Select"></option>
                                <option value="1" selected>Office</option>
                                <option value="2">Home</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <div>
                            <a href="javascript:void(0);" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#presentmodal" data-bs-dismiss="modal"><i
                                    class="feather feather-arrow-left me-1"></i>Back</a>
                        </div>
                        <div class="ms-auto">
                            <a href="javascript:void(0);" class="btn btn-outline-primary"
                                data-bs-dismiss="modal">close</a>
                            <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EDIT MODAL -->

        <!--HALFPRESENT MODAL -->
        <div class="modal fade" id="halfpresentmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Details <span class="badge badge-orange">Half Day</span></h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-5 mt-4">
                            <div class="col-md-4">
                                <div class="pt-5 text-center">
                                    <h6 class="mb-1 fs-16 font-weight-semibold">09:30 AM</h6>
                                    <small class="text-muted fs-14">Clock In</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-circle chart-circle-md" data-value=".50" data-thickness="6"
                                    data-color="#0dcd94">
                                    <div class="chart-circle-value text-muted">04:30 hrs</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="pt-5 text-center">
                                    <h6 class="mb-1 fs-16 font-weight-semibold"> 01:30 PM</h6>
                                    <small class="text-muted fs-14">Clock Out</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">IP Address</label>
                            <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Working Form</label>
                            <select name="projects" class="form-control custom-select select2" disabled
                                data-placeholder="Select">
                                <option label="Select"></option>
                                <option value="1" selected>Office</option>
                                <option value="2">Home</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-outline-primary" data-bs-dismiss="modal">close</a>
                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#halfdayeditmodal" data-bs-dismiss="modal">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HALFPRESENT MODAL  -->

        <!--HALFDAY EDIT MODAL -->
        <div class="modal fade" id="halfdayeditmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Details <span class="badge badge-orange">Half Day</span></h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Clock In</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" value="9:30 AM">
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-switch mt-md-6">
                                    <input type="checkbox" name="custom-switch-checkbox"
                                        class="custom-switch-input  orange">
                                    <span class="custom-switch-indicator "></span>
                                    <span class="custom-switch-description text-dark">Late</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Clock Out</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" value="01: 30 PM">
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="custom-switch mt-md-6">
                                    <input type="checkbox" name="custom-switch-checkbox"
                                        class="custom-switch-input  orange" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-dark">half Day</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">IP Address</label>
                            <input type="text" class="form-control" placeholder="225.192.145.1" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Working Form</label>
                            <select name="projects" class="form-control custom-select select2" disabled
                                data-placeholder="Select">
                                <option label="Select"></option>
                                <option value="1" selected>Office</option>
                                <option value="2">Home</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <div>
                            <a href="javascript:void(0);" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#halfpresentmodal" data-bs-dismiss="modal"><i
                                    class="feather feather-arrow-left me-1"></i>Back</a>
                        </div>
                        <div class="ms-auto">
                            <a href="javascript:void(0);" class="btn btn-outline-primary"
                                data-bs-dismiss="modal">close</a>
                            <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HALFDAY EDIT MODAL -->
        {{-- Punch Image --}}
        <div class="modal fade" id="PunchIn">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <img src="{{ asset('imgs/selfie.jpg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="modal fade" id="PunchOut">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <img src="{{ asset('imgs/selfie.jpg') }}" alt="">
                </div>
            </div>
        </div>

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
            }
        </script>
        <script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Trigger the AJAX request when a button is clicked
                $('#fetchEmpId-data-button').click(function() {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/admin/employee/emp_id') }}", // The URL defined in your route
                        dataType: 'json',
                        success: function(data) {
                            var numericPart = parseInt(data.get.max_emp_id.slice(2));
                            numericPart += 1;
                            $('#emp_id_sd').val(load() + numericPart);
                        },
                    });
                });
            });
    
            // Employee Type select
            $('#openAddNewEmployeeMod').on('change', function() {
                //  alert( this.value ); // or $(this).val()
                // console.log(this.value);
                if (this.value == 1) {
                    // console.log("1jsr")
                    $('#regularEmployeeAdddd').removeClass('d-none');
                    $('#contractualEmployeeAdd').addClass('d-none');
                } else if (this.value == 2) {
                    // console.log("2jsr");
                    $('#regularEmployeeAdddd').addClass('d-none');
                    $('#contractualEmployeeAdd').removeClass('d-none');
                } else {
                    $('#regularEmployeeAdddd').addClass('d-none');
                    $('#contractualEmployeeAdd').addClass('d-none');
                }
            });
    
            function ItemDeleteModel(context) {
                var id = $(context).data('id');
                $('#weekly_policy_id').val(id);
            }
    
            function openEditModel(context) {
                $("#updateempmodal").modal("show");
    
                var id = $(context).data('id');
                $('#setId').val(id);
                $.ajax({
                    url: "{{ url('/admin/employee/all_employee') }}",
                    type: "POST",
                    async: true,
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: id
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        console.log("Edit modal" + result.get[0].profile_photo);
                        if (result.get[0].emp_id) {
                            $("input[name='update_gender']").filter("[value='" + result.get[0]
                                .emp_gender + "']").prop(
                                'checked', true);
                            console.log("city: " + result.get[0].emp_city);
                            $('#sts2').val(result.get[0].emp_state);
                            $('#sts2').trigger('change');
                            var dataat = $('#sts2').val();
                            console.log("Dad: ", dataat[0]);
                            $('#state24').val(result.get[0].emp_city);
                            $('.update_name_sd').val(result.get[0].emp_name);
                            $('.update_mname_sddd').val(result.get[0].emp_mname);
                            $('.update_lname_sddd').val(result.get[0].emp_lname);
                            $('.update_cnumber_sddd').val(result.get[0].emp_mobile_number);
                            $('.update_email_sddd').val(result.get[0].emp_email);
                            $('.update_dob_sddd').val(result.get[0].emp_date_of_birth);
                            $('.update_country_sddd').val(result.get[0].emp_country);
                            $('.update_city_sddd').val(result.get[0].emp_city);
                            $('.update_pcode_sddd').val(result.get[0].emp_pin_code);
                            $('.update_address_sddd').val(result.get[0].emp_address);
                            $('.update_shifttype_sddd').val(result.get[0].emp_shift_type).change();
                            $('.update_attendance_method').val(result.get[0].emp_attendance_method).change();
                            $('.update_empid_sddd').val(result.get[0].emp_id);
                            $('.update_branchname_sddd').val(result.get[0].branch_id);
                            $('.update_department_sddd').val(result.get[0].department_id);
                            $('.update_designationname_sddd').val(result.get[0].designation_id);
                            $('.update_doj_dd').val(result.get[0].emp_date_of_joining);
                            const imageUrl = `{{ asset('employee_profile/${result.get[0].profile_photo}') }}`;
                            $('.image_sdd').attr("data-default-file", imageUrl);
                            $('.image_sdd').dropify('destroy');
                            $('.image_sdd').dropify();
                            change(result.get[0].branch_id, result.get[0].department_id, result.get[0]
                                .designation_id);
    
                        } else {}
                    },
                });
            }
    
            function drofiyimage(id) {
                console.log("gaya image function make");
                $.ajax({
                    url: "{{ url('/admin/employee/all_employee') }}",
                    type: "POST",
    
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: id
                    },
                    dataType: 'json',
                    success: function(result) {
                        // console.log(result);
                        if (result.get[0].emp_id) {
                            const imageUrl = `{{ asset('employee_profile/${result.get[0].profile_photo}') }}`;
                            $('#image_sd').attr("data-default-file", imageUrl);
                            $('#image_sd').dropify();
                        } else {}
                    },
                });
            }
    
            $('#state-dd').on('change', function() {
                var depart_id = this.value;
                $("#employee-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allemployeefilter') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        depart_id: depart_id,
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $('#employee-dd').html('<option value="">Select Employee</option>');
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + value.emp_name + '</option>');
                        });
                    }
                });
            });
    
            $(document).ready(function() {
                $('#country-dd, #state-dd, #desig-dd').change(function() {
                    var branchId = $('#country-dd').val();
                    var departmentId = $('#state-dd').val();
                    var designationId = $('#desig-dd').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/employee/employeefilter') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            branch_id: branchId,
                            department_id: departmentId,
                            designation_id: designationId
                        },
                        success: function(data) {
                            var tbody = $('.my_body');
                            tbody.empty();
    
                            $.each(data, function(index, employee) {
                                // console.log(employee);
                                let i = 1;
                                employee.forEach(el => {
                                    console.log("employee aa" + el);
                                    var newRow = '<tr>' +
                                        '<td>' + i++ + '</td>' +
    
                                        '<td>' + `<div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                    style="background-image: url('/employee_profile/` + el
                                        .profile_photo + `')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">` + el.emp_name + `</h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        ` + el.desig_name + `</p>
                                                </div>
                                            </div>` + '</td>' +
                                        '<td>' + el.emp_id + '</td>' +
                                        '<td>' + el.branch_name + '</td>' +
                                        '<td>' + el.depart_name + '</td>' +
                                        '<td>' + el.emp_date_of_joining + '</td>' +
                                        '<td>' + el.emp_mobile_number + '</td>' +
                                        '<td>'
                                    newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                            onclick="openEditModel(this)" data-id="${el.emp_id}" 
                            data-bs-toggle="modal" data-bs-target="#updateempmodal">
                            <i class="feather feather-edit" data-bs-toggle="tooltip"
                                data-original-title="View"></i>
                           </a>`;
    
                                    newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                            data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.emp_id}" 
                            data-bs-target="#deletemodal">
                            <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                data-original-title="View"></i>
                        </a>`;
                                    newRow += '</td></tr>';
                                    tbody.append(newRow);
                                });
                            });
    
                        }
                    });
                });
            });
    
            $(document).ready(function() {
                // Bind the "keyup" event to the input field
                $('#emp_id_sd').keyup(function() {
                    var searchValue = $(this).val();
                    console.log("SearchValue--->" + searchValue);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/employee/emp_id_check') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            emp_id: searchValue,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data.get);
                            var call =
                                load();
                            var pattern = new RegExp("^" + call.replace(/\s/g, '') +
                                "\\d+$");
                            console.log("pattern=>" + pattern);
                            if ((pattern.test(searchValue))) {
                                console.log("Valid format: " + searchValue);
                                $('.emp_id_dd').css("border-color", "green");
                                $('#empIdAlready').text("Valid format").css("color",
                                    "green");
                                if (data.get && data.get.emp_id !== undefined && data
                                    .get.emp_id ==
                                    searchValue) {
                                    $('#empIdAlready').text(
                                        "Employee ID already exists: " + data
                                        .get
                                        .emp_id);
                                    $('.emp_id_dd').css("border-color", "red");
                                    $('#empIdAlready').css("color", "red");
                                    console.log("empIdAlready");
                                }
                            } else if (searchValue.replace(/\s+/g, '')) {
                                $('.emp_id_dd').css("border-color", "red");
    
                                $('#empIdAlready').text(
                                    "Invalid format. Employee ID should start with " +
                                    call +
                                    " followed by numbers.").css("color", "red");
                            } else {
                                $('.emp_id_dd').css("border-color", "red");
    
                                $('#empIdAlready').text(
                                    "Invalid format. Employee ID should start with " +
                                    call +
                                    " followed by numbers.").css("color", "red");
                            }
                        },
                    });
                });
            });
    
                $('#country-dd').on('change', function() {
                    var branch_id = this.value;
                    $("#state-dd").html('');
                    $.ajax({
                        url: "{{ url('admin/settings/business/alldepartment') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            brand_id: branch_id
                        },
                        dataType: 'json',
                        success: function(result) {
    
                            console.log("Result",result);
                            $('#state-dd').html(
                                '<option value="" name="department">Select Department Name</option>'
                            );
                            $.each(result.department, function(key, value) {
                                $("#state-dd").append('<option name="department" value="' +
                                    value
                                    .depart_id + '">' + value.depart_name +
                                    '</option>');
                            });
                            $('#desig-dd').html(
                                '<option value="">Select Designation Name</option>');
                        }
                    });
                });
        </script>
    @endsection
