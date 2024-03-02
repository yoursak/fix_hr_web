@extends('admin.pagelayout.master')
@section('title', 'Update-Attendance')
@section('css')

@endsection

@section('content')

    @php
        $centralUnit = new App\Helpers\Central_unit();
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Designation = $centralUnit->DesignationList();
        $Employee = $centralUnit->EmployeeDetails();
    @endphp
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li class="active"><span><b>Update Attendance</b></span></li>
        </ol>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Update Attendance
                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="row">
                                <div class="col-6 d-flex" id="addSubmitBtn">
                                    <button id="ArCorrectionBtn" class="btn btn-md btn-primary mx-3"
                                        data-effect="effect-scale" data-bs-toggle="modal" href="#ArCorrection">Update
                                        Attendance</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive hr-attlist">
                        <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap border border-bottom">
                                            <thead>
                                                <tr role="row" class="border-bottom">
                                                    <th class="border-bottom-0 ">S.No.</th>
                                                    <th class="border-bottom-0 ">Month</th>
                                                    <th class="border-bottom-0 ">Created Date</th>
                                                    <th class=" text-center border-bottom-0 ">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-bottom">

                                                </tr>
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
    </div>
    <!-- END ROW -->

    <div class="modal fade" id="ArCorrection" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Correction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('createSubmitAttendance') }}" method="POST">
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
                                                id="ShiftStart">N/A</span><br><span class="fw-bold fs-14"> Shift End : </span><span
                                                id="ShiftEnd"> N/A</span></span>
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
                                            </div><input class="form-control fc-datepicker" id="punchDateSelect"
                                                name="date_select_name" placeholder="DD-MM-YYYY" type="text">
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
                                                <option value="">Select Deparment Name</option>
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
                                        <label class="form-label">Punch In</label>
                                        <div class="input-group">
                                            <input type="text" id="punchInTime" name="in_time"
                                                class="form-control timepicker" value="---" required>
                                            <div class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Punch Out</label>
                                        <div class="input-group">
                                            <input type="text" id="punchOutTime" name="out_time"
                                                class="form-control timepicker" value="---" required>
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script>
        // Create Method
        $(document).ready(function() {
            $('#branchSelect').on('change', function() {
                var branch_id = this.value;
                $("#departmentSelect").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#departmentSelect').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#departmentSelect").append(
                                '<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });

                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                    }
                });
            });
            $('#departmentSelect').on('change', function() {
                var depart_id = this.value;
                $("#desig-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldesignation') }}",
                    type: "POST",
                    data: {
                        depart_id: depart_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {

                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                        $.each(res.designation, function(key, value) {
                            $("#desig-dd").append('<option value="' + value
                                .desig_id + '">' + value.desig_name + '</option>');
                        });

                    }
                });
            });
            // employee
            $('#departmentSelect').on('change', function() {
                var depart_id = this.value;
                $("#employeeSelect").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allemployeefilter') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        depart_id: depart_id,
                    },
                    dataType: 'json',
                    success: function(res) {

                        $('#employeeSelect').html(
                            '<option value="" disabled selected>Select Employee Name</option>'
                        );
                        $.each(res.employee, function(key, value) {
                            $("#employeeSelect").append('<option value="' + value
                                .emp_id + '">' + ((value.emp_name ? value.emp_name :
                                        '') + ' ' + (value.emp_mname ? value
                                        .emp_mname : '') + ' ' + (value.emp_lname ?
                                        value.emp_lname : '') + ' (' + value
                                    .emp_id + ')') + '</option>');
                        });
                    }
                });
            });


            $('#employeeSelect').on('change', function() {
                var emp_id = this.value;
                var punchDate = $('#punchDateSelect').val();
                $.ajax({
                    url: "{{ route('EmployeeShiftDetails') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        emp_id: emp_id,
                        date: punchDate
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                    }
                });
            });
        });
    </script>
@endsection
