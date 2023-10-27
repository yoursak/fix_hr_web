@extends('admin.pagelayout.master')
@section('title', 'Leave')

@section('js')

@endsection
@section('css')
    <style>

    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
@endsection

@section('content')
    @php
        // dd($DATA);
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Designation = $centralUnit->DesignationList();

        $i = 0;
        $j = 1;
        foreach ($Department as $item) {
            $i++;
        }
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();

        // $root = new App\Helpers\Central_unit();
        $Count = $centralUnit->LeaveSectionCount();
        // $empCount = GetEmpCount();
    @endphp
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/leaves') }}">Request</a></li>
            <li class="active"><span><b>Leave</b></span></li>
        </ol>
    </div>
    <!-- Row -->
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Today Presents</span>
                                <h3 class="mb-0 mt-1 text-success"> {{ $Count[1] }}/{{ $Count[0] }}</h3>
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
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Paid Leaves</span>
                                <h3 class="mb-0 mt-1 text-primary">{{ $Count[3] }}</h3>
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
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Unpaid Leaves</span>
                                <h3 class="mb-0 mt-1 text-secondary">{{ $Count[4] }}</h3>
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
                                <h3 class="mb-0 mt-1 text-danger">{{ $Count[2] }}</h3>
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
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
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
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label class="form-label">From Date</label>
                                <input type="date" id="from_date_dd" class="form-control custom-select">

                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label class="form-label">To Date</label>
                                <input type="date" id="to_date_dd" class="form-control custom-select">
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
                                    {{-- <th class="border-bottom-0">Reason</th> --}}
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody class="my_body">
                                @php
                                    $count = 1;

                                    // dd($data);

                                @endphp
                                {{-- @empty($DATA) --}}

                                @foreach ($DATA as $item)
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
                                                    <h6 class="mb-1 fs-14"><a
                                                            href="{{ route('employeeProfile', [$item->emp_id]) }}">{{ $item->emp_name }}</a>
                                                    </h6>
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
                                        {{-- <td>{{ $item->reason }}</td> --}}
                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge badge-primary-light">Requested</span>
                                            @endif
                                            @if ($item->status == 1)
                                                <span class="badge badge-success-light">Approved</span>
                                            @endif
                                            @if ($item->status == 2)
                                                <span class="badge badge-warning-light">Declined</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('Leave.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                    id="edit_btn_modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->id ?>' data-status='<?= $item->status ?>'
                                                    data-bs-toggle="modal" data data-bs-target="#updateempmodal">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                            @endif
                                            {{-- @if (in_array('Leave.Delete', $permissions))
                                                <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletemodal{{ $item->id }}">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- @endempty --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    {{-- Edit Modal --}}
    <div class="modal fade" id="opendEditModelId" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">

                <div class="modal-header">
                    <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Leave Request</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <form action="{{ route('admin.leaveapprove') }}" method="post">
                    @csrf
                    <input type="text" name="id" id="editLeaveId" value="" hidden>

                    <div class="modal-body px-5 ">
                        <div class="form-row">
                            <div class="form-group  col-md-4">
                                <label for="inputEmail4">Branch</label>
                                <input type="email" class="form-control" style="background-color:F1F4FB "
                                    id="editBranch" placeholder="" value="" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Depratment</label>
                                <input type="text" class="form-control" id="editDepratment" placeholder=""
                                    value="" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Designation</label>
                                <input type="text" class="form-control" id="editDesignation" placeholder=""
                                    value="" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Employee Name</label>
                                <input type="text" class="form-control" id="editEmpName" placeholder=""
                                    value="" readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Employee Id</label>
                                <input type="text" class="form-control" id="editEmpId" placeholder="" value=""
                                    readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Mobile No.</label>
                                <input type="text" class="form-control" id="editMobileNo" placeholder="Mobile No."
                                    value="" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  col-md-3 col-sm-3">
                                <label for="inputPassword4">Leave Type </label>
                                <input type="text" class="form-control" id="editLeaveType" name="leave_type"
                                    placeholder="time" value="" readonly>
                                {{-- <select name="leave_type" class="form-control custom-select select2" id="editLeaveType"
                                    data-placeholder="" value="">
                                    </option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                </select> --}}
                            </div>
                            <div class="form-group    col-md-3 col-sm-3">
                                <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control" id="editFrom" name="from_date"
                                    placeholder="time" value="">
                            </div>

                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control" name="to_date" id="editTo"
                                    placeholder="Password" value="">
                            </div>
                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">Days</label>
                                <input type="text" class="form-control" id="editDays" name="days" value=""
                                    placeholder="days" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputPassword4" class="">Reason</label>
                                {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                            value="{{$item->in_time}}"> --}}

                                <textarea class="form-control" id="editReason" rows="2" value="" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-row d-none" id="remarks">
                            <div class="form-group col">
                                <label for="inputPassword4" class="">Remark</label>
                                <textarea class="form-control required" id="RemarkTextarea" name="remark" rows="2" value=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="editModalFooter">
                        <div class="d-flex me-auto ">
                            <p class="align-middle my-2"><span><b>Mark Leave Approvel</b></span></p>
                        </div>
                        <div class="d-flex m-0 ">
                            <span class="btn btn-danger mx-2" id="CancelBtn_MGA" data-bs-dismiss="" type="cancel "
                                name="" onclick="remark()" value="">Decline</span>
                            <button class="btn btn-primary mx-2" id="ApproveBtn_MGA" type="submit"
                                data-bs-toggle="modal" data-bs-target="#" name="approve" value="1">Approve</button>
                            <a class="btn btn-danger mx-2 d-none" id="BackBtn_MGA" type="" onclick="back()"
                                name="submit" value="2">Back</a>
                            <button class="btn btn-primary mx-2 d-none" id="SubmitBtn_MGA" type="submit" name="submit"
                                value="2">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    {{-- {{dd($data);}} --}}
    {{-- {{ dd($item) }} --}}
    {{-- @foreach ($datas as $item)
    @endforeach --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        function openEditModel(context) {
            $("#opendEditModelId").modal("show");
            var id = $(context).data('id');
            var status = $(context).data('status');
            console.log("result " + id);
            $('#editLeaveId').val(id);
            // $('#status').val(status);


            if (status == 1) {
                $('#editModalFooter').addClass('d-none');
                $('#remarks').addClass('d-none');
                $('#RemarkTextarea').attr('readonly', true);
                $('#editFrom').attr('readonly', true);
                $('#editTo').attr('readonly', true);
            } else if (status == 2) {
                $('#remarks').removeClass('d-none');
                $('#editModalFooter').addClass('d-none');
                $('#RemarkTextarea').attr('readonly', true);
                // $('#editInTime').attr('readonly', true);
                $('#editFrom').attr('readonly', true);
                $('#editTo').attr('readonly', true);
            } else {
                $('#editModalFooter').removeClass('d-none');
                $('#remarks').addClass('d-none');
                $('#RemarkTextarea').attr('readonly', false);
                $('#editFrom').attr('readonly', false);
                $('#editTo').attr('readonly', false);
                // $('#editInTime').attr('readonly', false);
            }
            $.ajax({
                url: "{{ url('/admin/requests/leave/detail') }}",
                type: "POST",
                async: true,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    console.log("result" + result);
                    if (result.get.id) {

                        $('#editBranch').val(result.get.branch_name);
                        $('#editDepratment').val(result.get.depart_name);
                        $('#editDesignation').val(result.get.desig_name);
                        $('#editEmpName').val(result.get.emp_name + ' ' + (result.get.emp_mname != null ? result
                            .get.emp_mname : '') + ' ' + result.get.emp_lname);
                        $('#editEmpId').val(result.get.emp_id);
                        $('#editMobileNo').val(result.get.emp_mobile_no);
                        $('#editDate').val(result.get.date);
                        $('#editFrom').val(result.get.from_date);
                        $('#editTo').val(result.get.to_date);
                        $('#editLeaveType').val(result.get.leave_type);

                        $('#editDays').val(result.get.days);
                        $('#editReason').val(result.get.reason);
                        $('#RemarkTextarea').val(result.get.remark);
                    } else {

                    }
                },
            });
        }

        function remark() {
            $('#remarks').removeClass('d-none');
            $('#CancelBtn_MGA').addClass('d-none');
            $('#ApproveBtn_MGA').addClass('d-none');
            $('#BackBtn_MGA').removeClass('d-none');
            $('#SubmitBtn_MGA').removeClass('d-none');
            $('#RemarkTextarea').attr('required', true);
        }

        function back() {
            $('#remarks').addClass('d-none');
            $('#CancelBtn_MGA').removeClass('d-none');
            $('#ApproveBtn_MGA').removeClass('d-none');
            $('#BackBtn_MGA').addClass('d-none');
            $('#SubmitBtn_MGA').addClass('d-none');
            $('#RemarkTextarea').attr('required', false);
        }
        $(document).ready(function() {

            // Add event listeners to the dropdowns
            $('#country-dd, #state-dd, #desig-dd, #from_date_dd, #to_date_dd').change(function() {
                // Get selected values
                var branchId = $('#country-dd').val();
                console.log("branchId" + branchId);
                var departmentId = $('#state-dd').val();
                // console.log(departmentId);
                var designationId = $('#desig-dd').val();
                // console.log(designationId);
                var fromDate = $('#from_date_dd').val();
                // console.log(fromDate);
                var toDate = $('#to_date_dd').val();
                // console.log("toidate" + toDate);

                // Make an AJAX request to filter employees
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/requests/leaveemployeefilter') }}",

                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId,
                        from_date: fromDate,
                        to_date: toDate
                    },
                    success: function(data) {
                        console.log("data" + data);
                        // Update the table body with the filtered data
                        var tbody = $('.my_body');
                        tbody.empty();

                        // $.each(data, function(index, employee) {
                        //     console.log(employee);
                        //     i = 1;
                        //     employee.forEach(el => {
                        //         console.log(el.emp_id);
                        //         var newRow = '<tr>' +
                        //             '<td>' + i++ + '</td>' +
                        //             '<td>' + `<div class="d-flex">
                    //                         <span class="avatar avatar-md brround me-3 rounded-circle"
                    //                             style="background-image: url('/employee_profile/` + el
                        //             .profile_photo + `')"></span>
                    //                         <div class="me-3 mt-0 mt-sm-1 d-block">
                    //                             <h6 class="mb-1 fs-14">` + el.emp_name + `&nbsp;` + (el
                        //                 .emp_mname != null ? 'el.emp_mname' : ''
                        //             ) +
                        //             `&nbsp;` + el.emp_lname + `</h6>
                    //                             <p class="text-muted mb-0 fs-12">
                    //                                 ` + el.desig_name + `</p>
                    //                         </div>
                    //                     </div>` + '</td>' +
                        //             '<td>' + el.emp_id + '</td>' +
                        //             '<td>' + el.leave_type + '</td>' +
                        //             '<td>' + el.from_date + '</td>' +
                        //             '<td>' + el.to_date + '</td>' +
                        //             '<td>' + el.days + '</td>' +

                        //             '<td>' + (el.status == 0 ?
                        //                 `<span class="badge badge-primary-light">Requested</span>` :
                        //                 (el.status == 1 ?
                        //                     '<span class="badge badge-success-light">Approved</span>' :
                        //                     (el.status == 2 ?
                        //                         `<span class="badge badge-warning-light">Declined</span>` :
                        //                         ' <span class="badge badge-primary-light">Requested</span>'
                        //                     ))) + '</td>' +

                        //             '<td>'
                        //         newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                    //     onclick="openEditModel(this)" data-id="${el.id}"  data-status="${el.status}"
                    //     data-bs-toggle="modal" data-bs-target="#updateempmodal">
                    //     <i class="feather feather-edit" data-bs-toggle="tooltip"
                    //         data-original-title="View"></i>
                    //    </a>`;

                        //         //         newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                    //     //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.id}" 
                    //     //     data-bs-target="#deletemodal">
                    //     //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                    //     //         data-original-title="View"></i>
                    //     // </a>`;
                        //         newRow += '</td></tr>';
                        //         // i++;
                        //         tbody.append(newRow);
                        //     });

                        // });
                    }
                });
            });
            // $('#country-dd').on('change', function() {
            //     var branch_id = this.value;
            //     $("#state-dd").html('');
            //     $.ajax({
            //         url: "{{ url('admin/settings/business/alldepartment') }}",
            //         type: "POST",
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             brand_id: branch_id
            //         },
            //         dataType: 'json',
            //         success: function(result) {

            //             // console.log(result);
            //             $('#state-dd').html(
            //                 '<option value="" name="department">Select Department Name</option>'
            //             );
            //             $.each(result.department, function(key, value) {
            //                 $("#state-dd").append('<option name="department" value="' +
            //                     value
            //                     .depart_id + '">' + value.depart_name +
            //                     '</option>');
            //             });
            //             $('#desig-dd').html(
            //                 '<option value="">Select Designation Name</option>');
            //         }
            //     });
            // });

            // $('#state-dd').on('change', function() {
            //     var depart_id = this.value;
            //     $("#desig-dd").html('');
            //     $.ajax({
            //         url: "{{ url('admin/settings/business/alldesignation') }}",
            //         type: "POST",
            //         data: {
            //             depart_id: depart_id,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             // console.log(res);
            //             $('#desig-dd').html(
            //                 '<option value="">Select Designation Name</option>');
            //             $.each(res.designation, function(key, value) {
            //                 $("#desig-dd").append('<option value="' + value
            //                     .desig_id + '">' + value.desig_name + '</option>');
            //             });
            //             // $('#employee-dd').html(
            //             //     '<option value="">Select Employee Name</option>');

            //         }
            //     });
            // });
            // // employee
            // $('#state-dd').on('change', function() {
            //     var depart_id = this.value;
            //     $("#employee-dd").html('');
            //     $.ajax({
            //         url: "{{ url('admin/settings/business/allemployeefilter') }}",
            //         type: "POST",
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             depart_id: depart_id,
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             // console.log(res);
            //             $('#employee-dd').html('<option value="">Select Employee</option>');
            //             $.each(res.employee, function(key, value) {
            //                 $("#employee-dd").append('<option value="' + value.emp_id +
            //                     '">' + value.emp_name + '</option>');
            //             });
            //         }
            //     });
            // });

        });
    </script>
@endsection
