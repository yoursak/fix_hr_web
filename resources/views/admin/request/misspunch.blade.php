@extends('admin.pagelayout.master')
@section('title', 'Misspunch')

@section('css')
    <style>

    </style>

@endsection

@section('js')


@endsection
@section('content')



    @php
        // dd($data->all());
        
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
        
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        // dd($Department);
        // dd($Branch);
        $i = 0;
        $j = 1;
        foreach ($Department as $item) {
            $i++;
        }
        // dd($Branch);
        // $central = new App\Helpers\Central_unit();
        
        $Employee = $centralUnit->EmployeeDetails();
        // dd($Employee[0]->emp_id);
        // $Department = $central::DepartmentList();
        // $Designation = App\Helpers\Central_unit::DesignationList();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        
    @endphp

    <div class="">
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/misspunch') }}">Request</a></li>

                <li class="active"><span><b>Misspunch</b></span></li>
            </ol>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Misspunch Summary</h3>
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

                   
                        {{-- <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Employee</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
                                    <option value="1">Regular Employee</option>
                                    <option value="2">Contractual Employee</option>

                                </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body p-2 ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>

                                    <th class="border-bottom-0">Employee Name</th>
                                    <th class="border-bottom-0">Employee Id</th>
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0">Time Type</th>
                                    <th class="border-bottom-0">In Time</th>
                                    <th class="border-bottom-0">Out Time</th>
                                    <th class="border-bottom-0">Working Hours</th>
                                    <th class="border-bottom-0">Reason</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    
                                @endphp
                                @foreach ($datas as $item)
                                    @php
                                        $DesignationName = App\Helpers\Layout::DasignationName($item->designation_id);
                                        
                                    @endphp
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
                                        <td>{{ $item->emp_miss_date }}</td>
                                        <td>{{ $item->emp_miss_time_type }}</td>
                                        <td>{{ $item->emp_miss_in_time }}</td>
                                        <td>{{ $item->emp_miss_out_time }}</td>
                                        <td>{{ $item->emp_working_hour }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td><span class="badge badge-success">{{ $item->status }}</span></td>
                                        <td>
                                            {{-- class="action-btns1 btn-primary" --}}
                                            @if (in_array('Miss Punch.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal" data-bs-target="#showmodal{{ $item->id }}">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Miss Punch.Delete', $permissions))
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

    <!-- ROW -->
    <div class="row row-sm">



        {{-- Modal --}}
        @foreach ($datas as $item)
            @php
                $BranchName = App\Helpers\Layout::BranchName($item->branch_id);
                // dd($BranchName);
                $DepartmentName = App\Helpers\Layout::DepartmentName($item->department_id);
                // dd($DepartmentName);
                $DesignationName = App\Helpers\Layout::DasignationName($item->designation_id);
                // dd($DesignationName);
            @endphp
            <div class="modal fade" id="showmodal{{ $item->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-content-demo">

                        <div class="modal-header">
                            <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Misspunch Request</h5>
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button> --}}
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <form action="{{ route('admin.misspunchapprove', $item->id) }}" method="post">
                            @csrf
                            <div class="modal-body px-5 ">
                                <div class="form-row">
                                    <div class="form-group  col-md-4">
                                        <input type="text" name="editMisspunchId" value="{{ $item->id }}" hidden>
                                        <label for="inputEmail4">Branch</label>
                                        <input type="email" class="form-control" style="background-color:F1F4FB "
                                            id="inputEmail4" placeholder="Email" value="{{ $BranchName->branch_name }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Depratment</label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $DepartmentName->depart_name }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Designation</label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $DesignationName->desig_name }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">Employee Name</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email"
                                            value="{{ $item->emp_name }}" readonly>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label for="inputPassword4">Employee Id</label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $item->emp_id }}" readonly>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label for="inputPassword4">Mobile No.</label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $item->emp_mobile_no }}" readonly>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group  col-md-3 col-sm-3">
                                        <label for="inputPassword4">Date <i class="fa fa-calendar"
                                                data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="fa fa-calendar"
                                                aria-label="fa fa-calendar"></i></label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $item->emp_miss_date }}">
                                    </div>
                                    <div class="form-group    col-md-3 col-sm-3">
                                        <label for="inputPassword4">Time Type</label>
                                        <select name="" class="form-control" onchange="check(event)"
                                            value="{{ $item->emp_miss_time_type }}">
                                            <option label="{{ $item->emp_miss_time_type }}" value=""></option>
                                            {{-- <option value="All">All</option> --}}
                                            <option value="">Select Time Type</option>
                                            <option value="AM">In Time</option>
                                            <option value="PM">Out Time</option>
                                        </select>
                                        {{-- <input type="selected" class="form-control" id="inputPassword4"
                                            placeholder="time" value="{{ $item->going_through }}" readonly> --}}
                                    </div>


                                    <div class="form-group  col-md-3 col-sm-3 ">
                                        <label for="inputPassword4">In Time</label>
                                        <input type="time" class="form-control" name="in_time" id="in_time"
                                            placeholder="time" value="{{ $item->emp_miss_in_time }}">
                                    </div>
                                    <div class="form-group  col-md-3 col-sm-3 ">
                                        <label for="inputPassword4">Out Time</label>
                                        <input type="time" class="form-control" id="out_time" name="out_time"
                                            value="{{ $item->emp_miss_out_time }}" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputPassword4" class="">Reason</label>
                                        {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                                value="{{$item->in_time}}"> --}}

                                        {{-- <textarea class="form-control" id="" rows="2" value="{{ $item->in_time }}" readonly>{{ $item->message }}</textarea> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex me-auto ">
                                    <p class="align-middle my-2"><span><b>Mark Misspunch Approvel</b></span></p>
                                </div>
                                <div class="d-flex m-0">
                                    <button class="btn btn-danger mx-2" data-bs-dismiss="modal" type="cancel "
                                        name="" value="Pending">Decline</button>

                                    <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal"
                                        data-bs-target="#" name="approve" value="Approve">Approve</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- delete confirmation --}}
            <div class="modal fade" id="deletemodal{{ $item->id }}" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-body">
                            <h3>Are you sure want to Update It ?</h3>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>

                            <a href="{{ route('admin.misspunchdelete', $item->id) }}" class="btn btn-primary"
                                type="submit">Approve</a>

                        </div>
                    </div>
                </div>
            </div>
            {{-- delete confirmation --}}
        @endforeach
        {{-- Modal --}}
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
