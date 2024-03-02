@extends('admin.pagelayout.master')
@section('title', 'Outdoor')

@section('content')
<?php
$nss = new App\Helpers\Central_unit();
?>
<div class=" p-0 py-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/requests/outdoor') }}">Requests</a></li>
        <li class="active"><span><b>Outdoor</b></span></li>
    </ol>
</div>
<!-- Row -->

<!-- END ROW -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Outdoor Summary</h3>
            </div>
            <livewire:request.out-door-list-livewire>
            {{-- <div class="card-body">
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
            </div> --}}
            <!-- ROW -->
            <!-- END ROW -->
            {{-- <div class="card-body pt-2  px-2">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0" hidden>S.No.</th>
                                <th class="border-bottom-0">Employee Name</th>
                                <th class="border-bottom-0">Employee Id</th>
                                <th class="border-bottom-0">Apply Date</th>
                                <th class="border-bottom-0">Out Time</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody class="my_body ">
                            @foreach ($DATA as $key => $item)
                            <tr>
                                <td hidden>{{ ++$key }}</td>
                                <td>
                                    <div class="d-flex">
                                        <span class="avatar avatar-md brround me-3" style="background-image: url('/storage/livewire_employee_profile/{{ $item->profile_photo }}')"></span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class="mb-1 fs-14">
                                                <a href="{{ route('employeeProfile', [$item->emp_id]) }}">
                                                    {{ $item->emp_name }}&nbsp;{{ $item->emp_mname }}&nbsp;{{ $item->emp_lname }}
                                                </a>
                                            </h6>
                                            <p class="text-muted mb-0 fs-12">
                                                {{ $item->desig_name}}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $item->emp_id }}
                                </td>
                                <td>
                                    {{ $item->formatted_apply_date }}
                                </td>
                                <td>
                                    {{ $item->formatted_out_time }}
                                </td>
                                <td>
                                    <small class="badge badge-success-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Auto Approval" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved" data-bs-original-title="Declined Approved"><i class="ion-checkmark-circled"></i> Approved</small>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);" id="view_btn_modal" onclick="openEditModel(this)" data-id='<?= $item->id ?>' data-branchname='<?= $item->branch_name ?>' data-departname='<?= $item->depart_name ?>' data-designame='<?= $item->desig_name ?>' data-empname='<?= $item->emp_name ?>' data-empmname='<?= $item->emp_mname ?>' data-empid='<?= $item->emp_id ?>' data-emplname='<?= $item->emp_lname ?>' data-outtime='<?= $item->formatted_out_time ?>' data-applydate='<?= $item->apply_date ?>' data-reason='<?= $item->reason ?>' data-empmobilenumber='<?= $item->emp_mobile_number ?>'> <i class="feather feather-eye" data-bs-toggle="tooltip" data-original-title="View"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- END ROW -->

{{-- Edit Modal --}}
<div class="modal fade" id="opendEditModelId" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">

            <div class="modal-header " style="background: #1877f2; color:white;">
                <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Outdoor Request</h5>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true" style="color: white;">&times;</span></button>
            </div>
            <input type="text" id="editGatepassId" name="id" hidden>
            <div class="modal-body px-5 ">
                <div class="form-row">
                    <div class="form-group  col-md-4">
                        <label for="inputEmail4">Branch</label>
                        <input type="email" class="form-control" style="background-color:F1F4FB " id="editBranch" placeholder="Branch" value="" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Department</label>
                        <input type="text" class="form-control" id="editDepratment" placeholder="Department" value="" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Designation</label>
                        <input type="text" class="form-control" id="editDesignation" placeholder="Designation" value="" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Employee Name</label>
                        <input type="text" class="form-control" id="editEmpName" placeholder="" value="" readonly>
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="inputPassword4">Employee Id</label>
                        <input type="text" class="form-control" id="editEmpId" placeholder="" value="" readonly>
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="inputPassword4">Mobile No.</label>
                        <input type="text" class="form-control" id="editMobileNo" placeholder="" value="" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group  col-md-4">
                        <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip" title="" data-bs-original-title="fa fa-calendar" aria-label="fa fa-calendar"></i></label>
                        <input type="text" class="form-control" id="editDate" placeholder="" value="" readonly>
                    </div>

                    <div class="form-group  col-md-4">
                        <label for="inputPassword4">Out Time</label>
                        <input type="time" name="out_time" class="form-control" id="editOutTime" placeholder="" value="" disabled>
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

                {{-- <div class="form-row">
                        <div class="form-group col-md-12">

                            <details>
                                <summary style="color:red;">Note: Let's take a look at how the Fix HR approval
                                    process
                                    works. </summary>
                                <p style="color:black; text-align: justify;text-justify: inter-word; ">1) In the
                                    case
                                    of approval, all status will be changed to
                                    approved,
                                    and the name of the final action performer will be displayed after the
                                    evaluation.
                                    <br>
                                    2) In the case of a decline, all status will be changed to declined, and the
                                    name
                                    of
                                    the last action performer will be displayed with end remark after the
                                    evaluation.
                                    (Whether the action is accepted or
                                    rejected, the result will be declined)
                                </p>
                            </details>
                        </div>
                    </div> --}}
            </div>

            {{-- <div class="modal-footer" id="editModalFooter">
                    <div class="d-flex me-auto ">
                        <p class="align-middle my-2"><span><b>Mark Gatepass Approvel</b></span></p>
                    </div>
                    <div class="d-flex m-0 ">
                        <span class="btn btn-danger mx-2" id="CancelBtn_MGA" data-bs-dismiss="" type="cancel "
                            name="" onclick="remark()" value="">Decline</span>
                        <button class="btn btn-primary mx-2" id="ApproveBtn_MGA" type="submit" data-bs-toggle="modal"
                            data-bs-target="#" name="approve" value="1">Approve</button>
                        <a class="btn btn-danger mx-2 d-none" id="BackBtn_MGA" type="" onclick="back()">Back</a>
                        <button class="btn btn-primary mx-2 d-none" id="SubmitBtn_MGA" type="submit" name="decline"
                            value="2">Submit</button>
                        <?php //}
                        ?>

                    </div>

                </div> --}}

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
    function openEditModel(context) {
        var id = $(context).data('id');
        var branch_name = $(context).data('branchname');
        var depart_name = $(context).data('departname');
        var desig_name = $(context).data('designame');
        var emp_name = $(context).data('empname');
        var emp_mname = $(context).data('empmname');
        var emp_lname = $(context).data('emplname');
        var apply_date = $(context).data('applydate');
        var apply_date = $(context).data('applydate');
        var emp_mobile_number = $(context).data('empmobilenumber');
        var out_time = $(context).data('outtime');
        var full_name = (emp_name ? emp_name + ' ' : '') +
            (emp_mname ? emp_mname + ' ' : '') +
            (emp_lname ? emp_lname : '');
        var reason = $(context).data('reason');
        var emp_id = $(context).data('empid');
        $('#editBranch').val(branch_name);
        $('#editDepratment').val(depart_name);
        $('#editDesignation').val(desig_name);
        $('#editEmpName').val(full_name);
        $('#editDate').val(apply_date)
        $('#editReason').val(reason)
        $('#editEmpId').val(emp_id)
        $('#editOutTime').val(out_time)
        $('#editMobileNo').val(emp_mobile_number)
        $('#opendEditModelId').modal('show');
    }
</script>
<script>
    $(document).ready(function() {
        $('#filter-branch').on('change', function() {
            var branch_id = this.value;
            $("#filter-department").html('');
            $("#filter-designation").html('');

            $.ajax({
                url: "{{ url('admin/requests/outdoordepartmentfilter') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    brand_id: branch_id
                },
                dataType: 'json',
                success: function(result) {
                    $('#filter-department').html(
                        '<option value="" name="department">All Department</option>'
                    );
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
            $("#filter-designation").html('');
            $.ajax({
                url: "{{ url('admin/requests/outdoordesignationfilter') }}",
                type: "POST",
                data: {
                    branch_id: branch_id,
                    depart_id: depart_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
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
                $('.my_body').html('<tr><td colspan="7" class="text-center">Fetching data...</td></tr>');
                // Make an AJAX request to filter employees
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/requests/outdooremployeefilter') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId,
                        from_date: fromDate,
                        to_date: toDate
                    },
                    success: function(data) {
                        var tbody = $('.my_body');
                        tbody.empty();
                        let i = 1;
                        if (data.get.length === 0) {
                            // If no records are found, display a message in the table
                            var noDataMessage =
                                '<tr><td colspan="7" class="text-center">No data available</td></tr>';
                            tbody.append(noDataMessage);
                        } else {
                            $.each(data.get, function(index, employee) {
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
                                    </div></div>` + '</td>' +
                                    '<td>' + employee.emp_id + '</td>' +
                                    '<td>' + employee.formatted_apply_date + '</td>' +
                                    '<td>' + (employee.formatted_out_time != null ? employee.formatted_out_time : '') + '</td>' +
                                    '<td>' + ` <small class="badge badge-success-light" data-bs-trigger="hover"
                                                data-bs-container="body" data-bs-content="Auto Approval"
                                                data-bs-placement="top" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html=true title="Approved"
                                                data-bs-original-title="Declined Approved"><i
                                                    class="ion-checkmark-circled"></i> Approved</small>` + '</td>' +
                                    '<td>'
                                newRow += `<a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                id="view_btn_modal" onclick="openEditModel(this)" data-id='${employee.id}'
                                                data-branchname='${employee.branch_name}'
                                                data-departname='${employee.depart_name}'
                                                data-designame='${employee.desig_name}'
                                                data-empname='${employee.emp_name}'
                                                data-empmname='${employee.emp_mname}' data-empid='${employee.emp_id}'
                                                data-emplname='${employee.emp_lname}'
                                                data-outtime='${employee.out_time}'
                                                data-applydate='${employee.apply_date}' data-reason='${employee.reason}'
                                                data-empmobilenumber='${employee.emp_mobile_number}'> <i
                                                    class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                        </a>`
                                newRow += '</td></tr>';
                                i++;
                                tbody.append(newRow);

                            });
                            $('[data-bs-toggle="popover"]').popover({
                                trigger: 'hover'
                            });
                        }

                        console.log(data);
                    }
                });
            });
    });
</script>


@endsection
