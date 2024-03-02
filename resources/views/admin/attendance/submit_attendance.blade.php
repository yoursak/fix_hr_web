@extends('admin.pagelayout.master')
@section('title', 'Submit-Attendance')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <style>
        .table-container {
            overflow-x: auto;
        }

        .table thead th:first-child,
        .table tbody td:first-child {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 2;
        }

        .table thead th {
            z-index: 1;
        }
    </style>

@endsection

@section('js')
@endsection

@if (in_array('Submit Attendance.View', $permissions))

    @section('content')
        @php
            $root = new App\Helpers\Central_unit();
            // $Department = $root->DepartmentList();
            $Branch = $root->BranchList();
            $Employee = $root->EmployeeDetails();

        @endphp
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Submit Attendance</b></span></li>
            </ol>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Submit Attendance
                        </div>
                        <div class="page-rightheader ms-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="row">
                                    <div class="col-6 d-flex" id="addSubmitBtn">
                                        @if (!empty($Employee->first()))
                                            <button id="UploadBioMetric" class="btn btn-md btn-primary mx-3 d-none d-md-block"
                                                data-effect="effect-scale" data-bs-toggle="modal" href="#UploadBiomatric">Biometric Upload</button>
                                        @endif
                                        @if (in_array('Submit Attendance.Update', $permissions) && !empty($Employee->first()))
                                            <button id="ArCorrectionBtn" class="btn btn-md btn-primary mx-3 d-none d-md-block" data-effect="effect-scale" data-bs-toggle="modal" href="#ArCorrection">AR
                                                Correction</button>
                                        @endif
                                        @if (in_array('Submit Attendance.Create', $permissions) && !empty($Employee->first()))
                                            <button id="addAttendanceBtn" class="btn btn-md btn-primary mx-3 d-none d-md-block"
                                                data-effect="effect-scale" data-bs-toggle="modal" href="#selectdate">Add
                                                Attendance</button>
                                        @endif

                                        <div class="btn btn-sm d-md-none" id="" data-bs-toggle="tooltip"
                                            data-original-title="View">
                                            <a data-bs-toggle="dropdown" style="border-radius: 8px;"
                                                class="option-dots border">
                                                <span class="feather feather-more-vertical"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-start">
                                                <li>
                                                    <a data-effect="effect-scale" data-bs-toggle="modal" href="#ArCorrection">AR Correction</a>
                                                </li>
                                                <li>
                                                    <a data-effect="effect-scale" data-bs-toggle="modal" href="#UploadBiomatric">Upload Biometric</a>
                                                </li>
                                                <li>
                                                    <a data-effect="effect-scale" data-bs-toggle="modal" href="#selectdate">Add Attendance</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <livewire:attendance.attendance-submit-list-livewire>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->

        <div class="modal fade" id="UploadBiomatric" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Submit Monthly Attendance</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('importBiometricExcel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="ml-5 mr-5">
                                <div class="text-center mt-5 mb-5">
                                    <h4><b style="color:#1877f2">Biomatric Attendance</b></h4>
                                    <p class="text-muted fs-12">Choose the month which you want to Evaluate and Submit
                                        Attendance
                                    </p>
                                </div>
                                <div class="row text-start">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Month</p>
                                            <div class="form-group mb-3">
                                                <select name="month" id="biomonthFilter" class="form-control "
                                                    required>
                                                    <option value="">Select Month</option>
                                                    @for ($month = 1; $month <= 12; $month++)
                                                        <option value="{{ $month }}"
                                                            {{ $month == date('m') ? 'Selected' : '' }}>
                                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p class="form-label">Year</p>
                                            <div class="form-group mb-3">
                                                <select name="year" id="bioyearFilter" class="form-control " required>
                                                    <option value="">Select Year</option>
                                                    @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                        <option value="{{ $year }}"
                                                            {{ $year == date('Y') ? 'Selected' : '' }}>
                                                            {{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-center" id="uploadBiomatrics">
                                        <div class="text-center">
                                            <a type="button" class="modal-effect my-2 border-0">
                                                <b>Dowanload Attendance Sheet</b></a>

                                            <a class="btn btn-primary btn-sm my-2 ml-2" data-bs-toggle="modal"
                                                data-bs-target="#selectdateForBimetric">
                                                <b><i class="fa fa-file-excel-o me-1"></i> Sample Template</b>
                                            </a>

                                            <input type="file" name="bioExcelSheet" id="BioSheetInput"
                                                class="biometricInput mt-3" data-height="120" />
                                            <a class="my-2 border-0"> <b>Upload Biomatric Attendance Excel Sheet</b></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="finalSubmitAttendance" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Final Submit Attendance</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('finallySubmitAttendance') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6>Are you sure want to Submit Attendance Permanently</h6>
                        </div>
                        <input type="text" id="yearInputHidden" name="year" hidden>
                        <input type="text" id="monthInputHidden" name="month" hidden>
                        {{-- <input type="text" id="businessInputHidden" name="businessId" hidden> --}}
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="selectdateForBimetric" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Download Biometric Template</h6><button aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('BiometricExcelTemplate') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6 class="mb-5 mt-3">Choose the month which you want to downlod biometric template</h6>
                            <div class="row text-start mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="form-label">Month</p>
                                        <div class="form-group mb-3">
                                            <select name="month" id="monthFilter" class="form-control " required>
                                                <option value="">Select Month</option>
                                                @for ($month = 1; $month <= 12; $month++)
                                                    <option value="{{ $month }}"
                                                        {{ $month == date('m') ? 'Selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <p class="form-label">Year</p>
                                        <div class="form-group mb-3">
                                            <select name="year" id="yearFilter" class="form-control " required>
                                                <option value="">Select Year</option>
                                                @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                    <option value="{{ $year }}"
                                                        {{ $year == date('Y') ? 'Selected' : '' }}>
                                                        {{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="selectdate" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Submit Monthly Attendance</h6><button aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('createSubmitAttendance') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6 class="mb-5 mt-3">Choose the month which you want to evaluate and submit attendance</h6>
                            <div class="row text-start mx-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p class="form-label">Month</p>
                                        <div class="form-group mb-3">
                                            <select name="month" id="monthFilter" class="form-control " required>
                                                <option value="">Select Month</option>
                                                @for ($month = 1; $month <= 12; $month++)
                                                    <option value="{{ $month }}"
                                                        {{ $month == date('m') ? 'Selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <p class="form-label">Year</p>
                                        <div class="form-group mb-3">
                                            <select name="year" id="yearFilter" class="form-control " required>
                                                <option value="">Select Year</option>
                                                @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                    <option value="{{ $year }}"
                                                        {{ $year == date('Y') ? 'Selected' : '' }}>
                                                        {{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                        <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">close</a>
                        {{-- <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a> --}}
                    </div>
                </div>
            </div>
        </div>

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

        <div class="modal fade" id="ArCorrection" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendance Correction</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('forceAttendanceCorrection') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="ml-5 mr-5">
                                <div class=" mt-5 mb-5">
                                    <h4><b style="color:#1877f2">Update Employee Attendance</b></h4>
                                    <p class="text-muted fs-12">Fill the all fields and choose the employee, which you want
                                        update attendance.</p>
                                </div>
                                <div class="row px-3">
                                    <div class="col-md-6">
                                        <div class="mb-5">
                                            <span class="my-5"><span class="fw-bold fs-14">Shift Name : </span><span
                                                    id="shiftName">N/A</span></span><br>
                                            <span class="my-5"><span class="fw-bold fs-14">Shift Start : </span><span
                                                    id="shiftStart">N/A</span><br>
                                                <span class="fw-bold fs-14">Shift End : </span><span id="shiftEnd">
                                                    N/A</span></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Select Date*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input type="date" class="form-control fc-datepicker"
                                                    id="punchDateSelect" name="date_select" placeholder="DD-MM-YYYY"
                                                    type="text" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row p-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <p class="form-label">Branch*</p>
                                            <select name='branch_id' id="branchSelect" class="form-control" required>
                                                <option value="">Select Branch Name</option>
                                                @foreach ($Branch as $data)
                                                    <option value="{{ $data->branch_id }}">
                                                        {{ $data->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <p class="form-label">Department*</p>
                                            <div class="form-group mb-3">
                                                <select id="departmentSelect" name="department_id" class="form-control"
                                                    required>
                                                    <option value="">Select Department Name</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <p class="form-label">Employee*</p>
                                            <select id="employeeSelect" name="emp_id" class="form-control" required>
                                                <option value="">Select Employee Name</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Punch In*</label>
                                            <div class="input-group">
                                                <input type="text" id="punchInTime" name="in_time"
                                                    class="form-control timepicker" value="" required>
                                                <div class="input-group-text">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Punch Out*</label>
                                            <div class="input-group">
                                                <input type="text" id="punchOutTime" name="out_time"
                                                    class="form-control timepicker" value="" required>
                                                <div class="input-group-text">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Working Hours</label>
                                            <div class="input-group">
                                                <input type="text" id="totalWorkingHour" name="total_working"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Reason</label>
                                                <div class="input-group">
                                                    <textarea rows="3" class="form-control" name="reason" placeholder="Enter Reason" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
        <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $('.biometricInput').dropify({
                messages: {
                    'default': 'Drag and drop an Excel file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Oops! Something went wrong.'
                }
            });


            var fileInput = document.getElementById('BioSheetInput');

            fileInput.addEventListener('change', function() {
                var file = fileInput.files[0];

                if (file) {
                    var reader = new FileReader();

                    reader.onloadend = function() {
                        // The result is a Data URL representing the file content
                        // The Data URL starts with "data:<mime_type>;base64,"
                        var dataUrl = reader.result;

                        // Extract the MIME type
                        var mimeType = dataUrl.split(';')[0].split(':')[1];

                        console.log('File MIME type:', mimeType);
                    };

                    // Read the file as a Data URL
                    reader.readAsDataURL(file);
                }
            });


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



                if (inTime != '00:00') {
                    $('#timeline1').removeClass('d-none');
                }
                if (outTime != '00:00') {
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
@endif
