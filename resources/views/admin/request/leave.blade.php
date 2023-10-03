@extends('admin.pagelayout.master')
@section('title', 'Leave')

@section('css')
    <style>

    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
@endsection

@section('js')

@endsection

@section('content')
    <style>
        .complete_class {
            color: green;
        }

        .incomplete_class {
            color: red;
        }

        #file-datatable_length {
            padding: 5px;
        }
    </style>
        @php
            // dd($data);
            
            $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
            
            $Department = $centralUnit->DepartmentList();
            // $BranchList = $centralUnit->BranchList();
            $Branch = $centralUnit->BranchList();
            // dd($Branch);
            // dd($Department);
            $i = 0;
            $j = 1;
            foreach ($Department as $item) {
                $i++;
            }
            
            // $central = new App\Helpers\Central_unit();
            
            $Employee = $centralUnit->EmployeeDetails();
            // dd($Employee[0]->emp_id);
            // $Department = $central::DepartmentList();
            // $Designation = App\Helpers\Central_unit::DesignationList();
            $nss = new App\Helpers\Central_unit();
            $EmpID = $nss->EmpPlaceHolder();
        @endphp
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/gatepass') }}">Request</a></li>
            <li class="active"><span><b>Leave</b></span></li>
        </ol>
    </div>
    {{-- <li><a href="javascript:void(0);">Elements</a></li> --}}

    <!-- Row -->
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Today Presents</span>
                                <h3 class="mb-0 mt-1 text-success">12/60</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-success-transparent my-auto  float-end"> <i class="las la-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Planned Leaves</span>
                                <h3 class="mb-0 mt-1 text-primary">8</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-primary-transparent my-auto  float-end"> <i class="las la-male"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Unplanned Leaves</span>
                                <h3 class="mb-0 mt-1 text-secondary">0</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i class="las la-female"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Pending Requests</span>
                                <h3 class="mb-0 mt-1 text-danger">12</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-danger-transparent my-auto  float-end"> <i class="las la-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Summary</h3>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='branch_id' id="country-dd" class="form-control" required>
                                    <option value="">Select Branch Name</option>
                                    @empty(!$Branch)
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    @endempty
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3">
                                    <select id="state-dd" name="department_id" class="form-control" required>
                                        <option value="">Select Deparment Name</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3">
                                    <select id="desig-dd" name="designation_id" class="form-control" required>
                                        <option value="">Select Designation Name</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control custom-select">

                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control custom-select">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW -->

                <!-- END ROW -->
                <div class="card-body pt-2  ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
                                    <th class="border-bottom-0">Employee Name</th>
                                    <th class="border-bottom-0">Employee Id</th>
                                    <th class="border-bottom-0">Leave Type</th>
                                    <th class="border-bottom-0">From</th>
                                    <th class="border-bottom-0">To</th>
                                    <th class="border-bottom-0">Days</th>
                                    <th class="border-bottom-0">Reason</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    
                                    // dd($data);
                                    
                                @endphp
                                @foreach ($datas as $item)
                                    {{-- @php
                                        $DesignationName = $central::DasignationName($item->designation_id);
                                        
                                    @endphp --}}
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3"
                                                    style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">{{ $item->emp_name }}</h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?= $nss->DesingationIdToName($item->designation_id) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $item->leave_type }}</td>
                                        <td>{{ $item->from_date }}</td>
                                        <td>{{ $item->to_date }}</td>
                                        <td>{{ $item->days }}</td>
                                        <td>{{ $item->reason }}</td>
                                        <td><span
                                                class="badge badge-complete {{ $item->status ? 'complete_class' : 'incomplete_class' }}">
                                                {{ $item->status == 1 ? 'Approve' : 'Decline' }}</span>
                                        </td>
                                        <td>
                                            @if (in_array('Leave.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#showmodal{{ $item->id }}">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Leave.Delete', $permissions))
                                                <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletemodal{{ $item->id }}">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
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
    <!-- END ROW -->
    {{-- {{dd($data);}} --}}
    {{-- {{ dd($item) }} --}}
    {{-- @foreach ($datas as $item)
    @endforeach --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // Add event listeners to the dropdowns
            $('#country-dd, #state-dd, #desig-dd').change(function() {
                // Get selected values
                var branchId = $('#country-dd').val();
                console.log(branchId);
                var departmentId = $('#state-dd').val();
                console.log(departmentId);
                var designationId = $('#desig-dd').val();
                console.log(designationId);

                // Make an AJAX request to filter employees
                $.ajax({
                    type: "POST",
                    // url: '{{ route('filter.employees') }}',
                    url: "{{ url('admin/employee/employeefilter') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId
                    },
                    success: function(data) {
                        console.log(data);
                        // Update the table body with the filtered data
                        var tbody = $('.my_body');
                        tbody.empty();

                        $.each(data, function(index, employee) {
                            console.log(employee);
                            i = 1;
                            employee.forEach(el => {
                                console.log(el.emp_id);
                                var newRow = '<tr>' +
                                    '<td>' + i++ + '</td>' +
                                    '<td>' + el.emp_name + '</td>' +
                                    '<td>' + el.emp_id + '</td>' +
                                    '<td>' + el.branch_id + '</td>' +
                                    '<td>' + el.department_id + '</td>' +
                                    '<td>' + el.emp_date_of_joining + '</td>' +
                                    '<td>' + el.emp_mobile_number + '</td>' +
                                    `<td>  </td>`
                                // Add your action buttons here
                                '</tr>';
                                // i++;
                                tbody.append(newRow);
                            });

                        });
                    }
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

                        // console.log(result);
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

            $('#state-dd').on('change', function() {
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
                        // console.log(res);
                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                        $.each(res.designation, function(key, value) {
                            $("#desig-dd").append('<option value="' + value
                                .desig_id + '">' + value.desig_name + '</option>');
                        });
                        // $('#employee-dd').html(
                        //     '<option value="">Select Employee Name</option>');

                    }
                });
            });
            // employee
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
                        // console.log(res);
                        $('#employee-dd').html('<option value="">Select Employee</option>');
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + value.emp_name + '</option>');
                        });
                    }
                });
            });

        });
    </script>
@endsection
