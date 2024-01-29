@extends('admin.pagelayout.master')
@section('title', 'Gatepass')

@section('content')
    @if (in_array('Gate Pass.All', $permissions) || in_array('Gate Pass.View', $permissions))

        <style>
            .custom-tooltip .tooltip-inner {
                color: #000;
                /* Set your desired text color for the tooltip title */
            }
        </style>
        <?php
        // dd($DATA);
        $centralUnit = new App\Helpers\Central_unit();
        $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement(); // Create an instance of the Central_unit class
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Designation = $centralUnit->DesignationList();
        $i = 0;
        $j = 1;
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        
        // $root = new App\Helpers\Central_unit();
        $Count = $centralUnit->LeaveSectionCount();
        // $empCount = GetEmpCount();
        ?>
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/leaves') }}">Request</a></li>
                <li class="active"><span><b>Gatepass</b></span></li>
            </ol>
        </div>
        <!-- Row -->

        <!-- END ROW -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gatepass Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name="country-dd" id="filter-branch" class="form-control" required>
                                        <option value="">All Branch</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Department</p>
                                    <div class="form-group mb-3">
                                        <select id="filter-department" name="department_id" class="form-control" required>
                                            <option value="">All Department</option>
                                            {{-- @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach --}}
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Designation</p>
                                    <div class="form-group mb-3">
                                        <select id="filter-designation" name="designation_id" class="form-control" required>
                                            <option value="">All Designation</option>
                                            {{-- @foreach ($Designation as $data)
                                                <option value="{{ $data->desig_id }}">
                                                    {{ $data->desig_name }}
                                                </option>
                                            @endforeach --}}
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-label">From Date</label>
                                    <input type="date" id="from_date_dd" class="form-control custom-select">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-label">To Date</label>
                                    <input type="date" id="to_date_dd" class="form-control custom-select">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ROW -->

                    <!-- END ROW -->
                    <div class="card-body pt-2  px-2">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" hidden>S.No.</th>
                                        <th class="border-bottom-0">Employee Name</th>
                                        <th class="border-bottom-0">Employee Id</th>
                                        <th class="border-bottom-0">Date</th>
                                        <th class="border-bottom-0">Out Time</th>
                                        <th class="border-bottom-0">In Time</th>
                                        <th class="border-bottom-0">Status</th>
                                        {{-- <th class="border-bottom-0">PID</th> --}}
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="my_body ">
                                    @php
                                        $count = 1;
                                        $ruleMange = new App\Helpers\MasterRulesManagement\RulesManagement();
                                    @endphp
                                    @foreach ($DATA as $key => $item)
                                        <?php
                                        $approval_type_id_static = 4;
                                        if ($checkApprovalCycleType == 1) {
                                            $current_status_particular_tb = DB::table('approval_status_list')
                                                ->where('approval_type_id', $approval_type_id_static)
                                                ->where('applied_cycle_type', 1)
                                                ->where('emp_id', $loginEmpID)
                                                ->where('role_id', $loginRoleID)
                                                ->where('all_request_id', $item->id)
                                                ->first();
                                        }
                                        if ($checkApprovalCycleType == 2) {
                                            $current_status_particular_tb = DB::table('approval_status_list')
                                                ->where('approval_type_id', $approval_type_id_static)
                                                ->where('applied_cycle_type', 2)
                                                ->where('all_request_id', $item->id)
                                                ->first();
                                        }
                                        $prevRoleID = $RuleManagement::RoleName($item->forward_by_role_id ?? 0)[0];
                                        $runtimeStatus = $prevRoleID->roles_name ?? 0;
                                        ?>
                                        <tr>
                                            <td hidden>{{ ++$key }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3"
                                                        style="background-image: url('/storage/livewire_employee_profile/{{ $item->profile_photo }}')"></span>
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
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                            {{-- <td>{{  }}</td> --}}
                                            <td><?= $ruleMange->Convert24To12($item->out_time) ?></td>
                                            <td><?= $ruleMange->Convert24To12($item->in_time) ?></td>
                                            <td>

                                                <?php
                                                $loadgoo = $item->id;
                                                ?>
                                                <?= $ruleMange->RequestGatePassApprovalManage($checkApprovalCycleType, $item, $loadgoo, 4, $loginRoleID) ?>     
                                            </td>
                                            <td>
                                                <?php
                                                
                                                $RoleRedCode = DB::table('request_gatepass_list')
                                                    ->join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')
                                                    ->where('request_gatepass_list.business_id', $loginRoleBID)
                                                    ->where('request_gatepass_list.id', $loadgoo)
                                                    ->select('request_gatepass_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                    ->first();
                                                ?>
                                                @if (in_array('Gate Pass.Update', $permissions))
                                                    <?php  if(($RoleRedCode->final_status==1) ||  ($RoleRedCode->final_status==2)){ ?>
                                                    <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                        id="view_btn_modal" onclick="openEditModel(this)"
                                                        data-id='<?= $item->id ?>'
                                                        data-processcomplete='<?= $item->process_complete ?>'
                                                        data-viewbtn='<?= $item->final_status ?>'
                                                        data-forwardbystatus="<?= $item->forward_by_status ?>"
                                                        data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                        data-forwardroleid='<?= $item->forward_by_role_id ?>'
                                                        data-leavetype='<?= $item->leave_type ?>' data-bs-toggle="modal"
                                                        data data-bs-target="#opendEditModelId">
                                                        <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </a>
                                                    <?php }?>
                                                @endif

                                                @if (in_array('Gate Pass.Update', $permissions))
                                                    <?php  if($RoleRedCode->final_status==0){ ?>
                                                    <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                        id="edit_btn_modal" onclick="openEditModel(this)"
                                                        data-id='<?= $item->id ?>'
                                                        data-processcomplete='<?= $item->process_complete ?>'
                                                        data-forwardbystatus="<?= $item->forward_by_status ?>"
                                                        data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                        data-forwardroleid='<?= $item->forward_by_role_id ?>'
                                                        data-leavetype='<?= $item->leave_type ?>' data-bs-toggle="modal"
                                                        data data-bs-target="#opendEditModelId">
                                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </a>
                                                    <?php }?>
                                                @endif
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

                    <div class="modal-header " style="background: #1877f2; color:white;">
                        <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Gatepass Request</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                                style="color: white;">&times;</span></button>
                    </div>

                    <form action="{{ route('admin.gatepassapprove') }}" method="post">
                        @csrf
                        <input type="text" id="editGatepassId" name="id" hidden>
                        <div class="modal-body px-5 ">
                            <div class="form-row">
                                <div class="form-group  col-md-4">
                                    <label for="inputEmail4">Branch</label>
                                    <input type="email" class="form-control" style="background-color:F1F4FB "
                                        id="editBranch" placeholder="Email" value="" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Department</label>
                                    <input type="text" class="form-control" id="editDepratment"
                                        placeholder="Password" value="" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Designation</label>
                                    <input type="text" class="form-control" id="editDesignation"
                                        placeholder="Password" value="" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Employee Name</label>
                                    <input type="text" class="form-control" id="editEmpName" placeholder=""
                                        value="" readonly>
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Employee Id</label>
                                    <input type="text" class="form-control" id="editEmpId" placeholder=""
                                        value="" readonly>
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Mobile No.</label>
                                    <input type="text" class="form-control" id="editMobileNo" placeholder=""
                                        value="" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="text" class="form-control" id="editDate" placeholder=""
                                        value="" readonly>
                                </div>

                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Out Time</label>
                                    <input type="time" name="out_time" class="form-control" id="editOutTime"
                                        placeholder="" value="">
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">In Time</label>
                                    <input type="time" class="form-control" id="editInTime" name="in_time"
                                        value="" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Going Through</label>
                                    <select name="time_type" class="form-control" value="" id="editGoingThrough">
                                        <option value="">Select Type</option>
                                        @foreach ($going_through as $goingthrough)
                                            <option value="{{ $goingthrough->id }}">
                                                {{ $goingthrough->going_through }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Source </label>
                                    <input type="text" class="form-control" id="editSource" placeholder=""
                                        value="" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Destination </label>
                                    <input type="text" class="form-control" id="editDestination" placeholder=""
                                        value="" readonly>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputPassword4" class="">Reason</label>
                                    <textarea class="form-control" id="editReason" rows="2" value="" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-row d-none" id="remarks">
                                <div class="form-group col">
                                    <label for="inputPassword4" class="">Remark</label>
                                    <textarea class="form-control required" id="RemarkTextarea" name="remark" rows="2" value=""></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">

                                    <details>
                                        <summary style="color:red;">Note: Let's take a look at how the Fix HR approval
                                            process
                                            works. </summary>
                                        <p style="color:black; text-align: justify;text-justify: inter-word; ">1) In the
                                            case
                                            of approval, all statuses will be changed to
                                            approved,
                                            and the name of the final action performer will be displayed after the
                                            evaluation.
                                            <br>
                                            2) In the case of a decline, all statuses will be changed to declined, and the
                                            name
                                            of
                                            the most recent action performer will be displayed with end remark after the
                                            evaluation.
                                            (Whether the action is accepted or
                                            rejected, the result will be declined)
                                        </p>
                                    </details>
                                </div>
                            </div>
                        </div>
                        @if (in_array('Gate Pass.All', $permissions) || in_array('Gate Pass.Update', $permissions))
                            <div class="modal-footer" id="editModalFooter">
                                <div class="d-flex me-auto ">
                                    <p class="align-middle my-2"><span><b>Mark Gatepass Approvel</b></span></p>
                                </div>
                                <div class="d-flex m-0 ">
                                    <span class="btn btn-danger mx-2" id="CancelBtn_MGA" data-bs-dismiss=""
                                        type="cancel " name="" onclick="remark()" value="">Decline</span>
                                    <button class="btn btn-primary mx-2" id="ApproveBtn_MGA" type="submit"
                                        data-bs-toggle="modal" data-bs-target="#" name="approve"
                                        value="1">Approve</button>
                                    <a class="btn btn-danger mx-2 d-none" id="BackBtn_MGA" type=""
                                        onclick="back()">Back</a>
                                    <button class="btn btn-primary mx-2 d-none" id="SubmitBtn_MGA" type="submit"
                                        name="decline" value="2">Submit</button>
                                    <?php //}
                                    ?>

                                </div>

                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            // Wait for the DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                // Get the current date
                var currentDate = new Date();

                // Set the default values for From Date and To Date
                var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                var lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

                // Format the date in the 'YYYY-MM-DD' format
                var formattedFirstDay = formatDate(firstDayOfMonth);
                var formattedLastDay = formatDate(lastDayOfMonth);

                // Set the default values to the input fields
                document.getElementById('from_date_dd').value = formattedFirstDay;
                document.getElementById('to_date_dd').value = formattedLastDay;
            });

            // Function to format date in 'YYYY-MM-DD' format
            function formatDate(date) {
                var year = date.getFullYear();
                var month = ('0' + (date.getMonth() + 1)).slice(-2); // Adding 1 because months are zero-based
                var day = ('0' + date.getDate()).slice(-2);
                return year + '-' + month + '-' + day;
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#filter-branch').on('change', function() {
                    var branch_id = this.value;
                    $("#filter-department").html('');
                    $("#filter-designation").html('');

                    $.ajax({
                        url: "{{ url('admin/requests/gatepassdepartmentfilter') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            brand_id: branch_id
                        },
                        dataType: 'json',
                        success: function(result) {

                            // console.log(result);
                            $('#filter-department').html(
                                '<option value="" name="department">All Department</option>'
                            );
                            console.log(result.department);
                            $.each(result.department, function(key, value) {
                                $("#filter-department").append(
                                    '<option name="department" value="' +
                                    value
                                    .depart_id + '">' + value.depart_name +
                                    '</option>');
                            });

                            $('#filter-designation').html(
                                '<option value="">All Designation</option>');
                        }
                    });
                });
                $('#filter-department').on('change', function() {
                    var depart_id = this.value;
                    var branch_id = $('#filter-branch').val();
                    console.log("aaaaaa ", branch_id);
                    console.log("depart_id " + depart_id);
                    $("#filter-designation").html('');
                    $.ajax({
                        url: "{{ url('admin/requests/gatepassdesignationfilter') }}",
                        type: "POST",
                        data: {
                            branch_id: branch_id,
                            depart_id: depart_id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(res) {
                            console.log("res ", res);
                            $('#filter-designation').html(
                                '<option value="">All Designation</option>');
                            $.each(res.designation, function(key, value) {
                                $("#filter-designation").append('<option value="' + value
                                    .desig_id + '">' + value.desig_name + '</option>');
                            });
                            $('#employee-dd').html(
                                '<option value="">All Employee</option>')
                        }
                    });
                });
                // // employee
                // $('#filter-department').on('change', function() {
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
                //             console.log(res);
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
        <script>
            $(document).ready(function() {
                // Add event listeners to the dropdowns
                $('#filter-branch, #filter-department, #filter-designation, #from_date_dd, #to_date_dd').change(
                    function() {
                        // Get selected values
                        var branchId = $('#filter-branch').val();
                        var departmentId = $('#filter-department').val();
                        var designationId = $('#filter-designation').val();
                        var fromDate = $('#from_date_dd').val();
                        var toDate = $('#to_date_dd').val();
                        // Make an AJAX request to filter employees
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/requests/gatepassemployeefilter') }}",

                            // gatepassdepartmentfilter
                            // gatepassdesignationfilter
                            data: {
                                _token: '{{ csrf_token() }}',
                                branch_id: branchId,
                                department_id: departmentId,
                                designation_id: designationId,
                                from_date: fromDate,
                                to_date: toDate
                            },
                            success: function(data) {
                                // Update the table body with the filtered data
                                var tbody = $('.my_body');
                                tbody.empty();
                                var currentstatus = data['currentstatupartdb'];
                                var status = data['status'];
                                let i = 1;

                                $.each(data.get, function(index, employee) {
                                    var out_time = convertTo12HourFormat(employee.out_time);
                                    var sd = employee.emp_id;
                                    var newRow = '<tr>' +
                                        '<td>' + `<div class="d-flex">
                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                style="background-image: url('/storage/livewire_employee_profile/` +
                                        employee
                                        .profile_photo +
                                        `')"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14"><a href="<?= url('admin/employee/profile/${sd}') ?>">` +
                                        employee.emp_name + ' ' + ((employee
                                                .emp_mname != null) ? employee.emp_mname :
                                            '') + ' ' + employee.emp_lname + `</a></h6>
                                                <p class="text-muted mb-0 fs-12">
                                                    ` + employee.desig_name + `</p>
                                            </div>
                                        </div>` + '</td>' +
                                        '<td>' + employee.emp_id + '</td>' +
                                        '<td>' + formatDate(employee.date) + '</td>' +
                                        '<td>' + out_time + '</td>' +
                                        '<td>' + convertTo12HourFormat(employee.in_time) +
                                        '</td>' +
                                        '<td>' +
                                        status[employee.id] +
                                        '</td>' +
                                        // '<td>' + employee.id + '</td>' +
                                        '<td>'

                                    '<?php if(in_array('Gate Pass.Update', $permissions)){ ?>'

                                    if (employee.final_status == 1 || employee.final_status ==
                                        2) {
                                        newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditModel(this)" 
                                                data-id="${employee.id}" 
                                                data-processcomplete="${employee.process_complete}" 
                                                data-viewbtn="${employee.final_status}" 
                                                data-forwardbystatus="${employee.forward_by_status}" 
                                                data-currentstatusparticulartb="${currentstatus[employee.id] ?? 0}" 
                                                data-forwardroleid=' ${employee.forward_by_role_id}'
                                                data-bs-toggle="modal" data-bs-target="#updateempmodal">
                                                <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>`;
                                    } else if (employee.final_status == 0) {
                                        newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditModel(this)" 
                                                data-id="${employee.id}" 
                                                data-processcomplete="${employee.process_complete}" 
                                                data-viewbtn="${employee.final_status}" 
                                                data-forwardbystatus="${employee.forward_by_status}" 
                                                data-currentstatusparticulartb="${currentstatus[employee.id] ?? 0}" 
                                                data-forwardroleid=' ${employee.forward_by_role_id}'
                                                data-bs-toggle="modal" data-bs-target="#updateempmodal">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>`;
                                    }
                                    '<?php  } ?>'


                                    newRow += '</td></tr>';
                                    i++;
                                    tbody.append(newRow);
                                    // });
                                });
                                $('[data-bs-toggle="popover"]').popover({
                                    trigger: 'hover'
                                });


                            }
                        });
                    });

                function convertTo12HourFormat(time24) {
                    var timeTokens = time24.split(':');
                    var hours = parseInt(timeTokens[0]);
                    var minutes = parseInt(timeTokens[1]);

                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // Handle midnight (00:00) as 12 AM

                    // Pad single-digit hours with a leading zero
                    hours = hours < 10 ? '0' + hours : hours;

                    return hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
                }

                function formatDate(inputDate) {
                    var dateTokens = inputDate.split('-');
                    var formattedDate = dateTokens[2] + '-' + dateTokens[1] + '-' + dateTokens[0];
                    return formattedDate;
                }


            });
        </script>


        <script>
            document.getElementById('editFrom').addEventListener('change', calculateDateDifference);
            document.getElementById('editTo').addEventListener('change', calculateDateDifference);

            document.getElementById('editFromT').addEventListener('change', calculateDateDifferenceHalf);
            document.getElementById('editToT').addEventListener('change', calculateDateDifferenceHalf);

            function calculateDateDifference() {
                var fromDate = document.getElementById('editFrom').value;
                var toDate = document.getElementById('editTo').value;

                if (fromDate && toDate) {
                    var from = new Date(fromDate);
                    var to = new Date(toDate);

                    if (from > to) {
                        alert("Please select a 'from' date that is earlier than the 'to' date.");
                        return;
                    }

                    var differenceInTime = to - from;
                    var differenceInDays = Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1;
                    $('#editDays').val(differenceInDays);
                    console.log(differenceInDays);
                    // Display the results
                    // document.getElementById('result').textContent = 'Difference: ' + differenceInDays + ' days';
                }
            }

            function calculateDateDifferenceHalf() {
                var fromDate = document.getElementById('editFromT').value;
                var toDate = document.getElementById('editToT').value;

                if (fromDate && toDate) {
                    var from = new Date(fromDate);
                    var to = new Date(toDate);

                    if (from > to || from < to) {
                        alert("You can't select different date.");
                        return;
                    }

                    var differenceInTime = to - from;
                    var differenceInDays = (Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1) / 2;
                    $('#editDaysSecond').val(differenceInDays);
                    console.log(differenceInDays);
                    // Display the results
                    // document.getElementById('result').textContent = 'Difference: ' + differenceInDays + ' days';
                }
            }

            function checkLeaveType(context) {
                var selectedValue = context.value;

                if (selectedValue == 1) {
                    $('#leaveTypeOneShow').removeClass('d-none');
                    $('#leaveTypeTwoShow').addClass('d-none');
                } else if (selectedValue == 2) {
                    $('#leaveTypeOneShow').addClass('d-none');
                    $('#leaveTypeTwoShow').removeClass('d-none');
                }

                // If you want to set the selected value for other dropdowns, you can use val() method
                $('#editLeaveTypeFirst').val(selectedValue);
                $('#editLeaveTypeSecond').val(selectedValue);

                console.log("Selected Value: " + selectedValue);
            }
        </script>

        <script>
            function openEditModel(context) {
                var loginRoleID = '<?= $loginRoleID ?>';
                var checkApprovalCycleType = '<?= $checkApprovalCycleType ?>';
                $("#opendEditModelId").modal("show");
                var id = $(context).data('id');
                var status = $(context).data('status');
                var leavetype = $(context).data('leavetype');
                var forwardRoleid = $(context).data('forwardroleid');
                var current_status_particulartb = $(context).data('currentstatusparticulartb');
                var forward_by_status = $(context).data('forwardbystatus');
                var process_complete = $(context).data('processcomplete');
                var viewBtn = $(context).data('viewbtn');
                var parallerApprovalRolecheck = '<?= $parallerCaseApprovalListRoleIdCheck ?>';

                $('#editGatepassId').val(id);
                $('#editLeaveId').val(id);
                var status = $(context).data('status');
                if ((parseInt(viewBtn) == 1) || (parseInt(viewBtn) == 2)) {
                    $('#editModalFooter').hide();
                }
                // $('#status').val(status);

                if (leavetype == 1) {
                    $('#leaveTypeOneShow').removeClass('d-none');
                    $('#leaveTypeTwoShow').addClass('d-none');

                } else if (leavetype == 2) {
                    $('#leaveTypeOneShow').addClass('d-none');
                    $('#leaveTypeTwoShow').removeClass('d-none');
                }
                if (parseInt(checkApprovalCycleType) == 1) {

                    if (parseInt(forwardRoleid) == parseInt(loginRoleID)) {

                        console.log(' level 1 ');

                        $('#editModalFooter').show();
                        console.log('case 1');

                    }
                    if (parseInt(process_complete) != 0) {
                        $('#editModalFooter').hide();

                        console.log('case 2');

                    } else if (parseInt(forwardRoleid) != parseInt(loginRoleID)) {
                        $('#editModalFooter').hide();
                    }


                }
                if (parseInt(checkApprovalCycleType) == 2) {
                    console.log("Cycle 2 aagayahy", parseInt(loginRoleID));
                    if (parseInt(current_status_particulartb) != 0) {
                        $('#editModalFooter').hide();
                    }
                    if (parseInt(process_complete) != 0) {
                        $('#editModalFooter').hide();
                        console.log('procee complete');
                    } else {
                        if (parallerApprovalRolecheck) {
                            $('#editModalFooter').show();
                        } else {
                            $('#editModalFooter').hide();
                        }
                    }
                }
                // if(parseInt(forwardRoleid)==parseInt(loginRoleID) ){

                //     $('#editModalFooter').show();
                // //      console.log("2 id match ");

                // }else{
                //     $('#editModalFooter').hide();

                // }
                // else{
                //        $('#editModalFooter').addClass('d-none');

                //     console.log("3 aagya nih asdf");

                // }
                // leavetype
                // if (status == 1) {
                //     $('#editModalFooter').addClass('d-none');
                //     $('#remarks').addClass('d-none');
                //     $('#RemarkTextarea').attr('readonly', true);
                //     $('#editFrom').attr('readonly', true);
                //     $('#editTo').attr('readonly', true);
                // } else if (status == 2) {
                //     $('#remarks').removeClass('d-none');
                //     $('#editModalFooter').addClass('d-none');
                //     $('#RemarkTextarea').attr('readonly', true);
                //     // $('#editInTime').attr('readonly', true);
                //     $('#editFrom').attr('readonly', true);
                //     $('#editTo').attr('readonly', true);
                // } else {
                //     $('#editModalFooter').removeClass('d-none');
                //     $('#remarks').addClass('d-none');
                //     $('#RemarkTextarea').attr('readonly', false);
                //     $('#editFrom').attr('readonly', false);
                //     $('#editTo').attr('readonly', false);
                //     // $('#editInTime').attr('readonly', false);
                // }
                $.ajax({
                    url: "{{ url('/admin/requests/gatepass/detail') }}",
                    type: "POST",
                    async: true,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        console.log(result);
                        if (result.get.id) {
                            var FullName =
                                $('#editBranch').val(result.get.branch_name);
                            $('#editDepratment').val(result.get.depart_name);
                            $('#editDesignation').val(result.get.desig_name);
                            $('#editEmpName').val(result.get.emp_name + ' ' + (result.get.emp_mname != null ? result
                                .get.emp_mname : '') + ' ' + result.get.emp_lname);
                            $('#editEmpId').val(result.get.emp_id);
                            $('#editMobileNo').val(result.get.emp_mobile_no);
                            $('#editDate').val(result.get.date);
                            $('#editGoingThrough').val(result.get.going_through);
                            $('#editMobileNo').val(result.get.emp_mobile_number);
                            $('#editSource').val(result.get.source);
                            $('#editDestination').val(result.get.destination);
                            // editMobileNo
                            $('#editOutTime').val(result.get.out_time);
                            $('#editInTime').val(result.get.in_time);
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
        </script>
    @endif
@endsection
