@extends('admin.pagelayout.master')
@section('title', 'Mispunch')

@section('css')
    <style>
    </style>

@endsection

@section('js')
@endsection
@section('content')
    @php
        $centralUnit = new App\Helpers\Central_unit();
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

    @endphp
    <div class="">
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/mispunch') }}">Request</a></li>
                <li class="active"><span><b>Mispunch</b></span></li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mispunch Summary</h3>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='branch_id' id="country-dd" class="form-control" required>
                                    <option value="">--- Select Branch ---</option>
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
                                        <option value="">--- Select Deparment---</option>
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
                <div class="card-body p-2 ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
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
                                    {{-- <th class="border-bottom-0">Reason</th> --}}
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody class="my_body">
                                @php
                                    $count = 1;
                                @endphp
                                {{-- @empty($DATA) --}}

                                @foreach ($DATA as $item)
                                    @php
                                        $ruleMange = new App\Helpers\MasterRulesManagement\RulesManagement();
                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3"
                                                    style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">
                                                        <a href="{{ route('employeeProfile', [$item->emp_id]) }}">
                                                            {{ $item->emp_name }}&nbsp;{{ $item->emp_mname }}&nbsp;{{ $item->emp_lname }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?= $nss->DesingationIdToName($item->designation_id) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $item->emp_miss_date }}</td>
                                        <td>{{ $item->time_type }}</td>
                                        <td> <?= $ruleMange->Convert24To12($item->emp_miss_in_time) ?></td>
                                        <td> <?= $ruleMange->Convert24To12($item->emp_miss_out_time) ?></td>
                                        <td>{{ $item->emp_working_hour }}</td>
                                        {{-- <td>{{ $item->message }}</td> --}}
                                        <td>
                                            @if ($item->status == null || $item->status == 0)
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
                                            {{-- class="action-btns1 btn-primary" --}}
                                            @if (in_array('Miss Punch.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->id ?>' data-status='<?= $item->status ?>'
                                                    data-bs-target="#opendEditModelId">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            {{-- @if (in_array('Miss Punch.Delete', $permissions))
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

    <!-- ROW -->


    <div class="modal fade" id="opendEditModelId" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Mispunch Request</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.mispunchapprove') }}" method="post">
                    @csrf
                    <div class="modal-body px-5 ">
                        <input type="text" name="id" id="editmispunchId">
                        <input type="text" name="" id="stttttt">
                        
                        <div class="form-row">
                            <div class="form-group  col-md-4">
                                {{-- <input type="text" name="editmispunchId" value="" hidden> --}}
                                <label for="inputEmail4">Branch</label>
                                <input type="email" class="form-control" id="editBranch"
                                    style="background-color:F1F4FB " placeholder="Email" value="" readonly>
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
                                <input type="email" class="form-control" id="editEmpName" placeholder="Email"
                                    value="" readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Employee Id</label>
                                <input type="text" class="form-control" id="editEmpId" name="emp_id" placeholder="" value=""
                                    readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Mobile No.</label>
                                <input type="text" class="form-control" id="editMobileNo" placeholder=""
                                    value="" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  col-md-3 col-sm-3">
                                <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" name="date" class="form-control" id="editDate" placeholder="Password"
                                    value="" readonly>
                            </div>
                            <div class="form-group    col-md-3 col-sm-3">
                                <label for="inputPassword4">Time Type</label>
                                <select name="time_type" class="form-control" onchange="check(event)" value=""
                                    id="editTimeType">
                                    <option value="">Select Time Type</option>
                                    @foreach ($StaticMisspunchTimeType as $timetype)
                                        <option value="{{ $timetype->id }}">
                                            {{ $timetype->time_type }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <input type="selected" class="form-control" id="inputPassword4"
                                        placeholder="time" value="{{ $item->going_through }}" readonly> --}}
                            </div>


                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">In Time</label>
                                <input type="time" class="form-control" name="in_time" id="editInTime"
                                    placeholder="" value="">
                            </div>
                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">Out Time</label>
                                <input type="time" class="form-control" name="out_time" id="editOutTime"
                                    value="" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputPassword4" class="">Reason</label>
                                <textarea class="form-control" id="" rows="2" value="" id="editReason" readonly></textarea>
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
                            <p class="align-middle my-2"><span><b>Mark Mispunch Approvel</b></span></p>
                        </div>
                        <div class="d-flex m-0 ">
                            <a class="btn btn-danger mx-2" id="CancelBtn_MGA" data-bs-dismiss="" type="cancel "
                                name="" onclick="remark()" value="">Decline</a>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        function openEditModel(context) {

            $("#opendEditModelId").modal("show");
            var id = $(context).data('id');
            console.log(id);
            var status = $(context).data('status');

            $('#editmispunchId').val(id);
            $('#stttttt').val(status);
            console.log("status" + status);
            if (status == 2) {
                $('#remarks').removeClass('d-none');
                $('#editModalFooter').addClass('d-none');
                $('#RemarkTextarea').attr('readonly', true);
                $('#editTimeType').attr('readonly', true);
                $('#editInTime').attr('readonly', true);
                $('#editOutTime').attr('readonly', true);
            }
            if (status == 1) {
                $('#editModalFooter').addClass('d-none');
                $('#remarks').addClass('d-none');
                $('#RemarkTextarea').attr('readonly', true);
                $('#editInTime').attr('readonly', true);
                $('#editOutTime').attr('readonly', true);
                $('#editTimeType').attr('readonly', true);


            }

            if (status == 0 || status == null) {
                $('#editModalFooter').removeClass('d-none');
                $('#remarks').addClass('d-none');
                $('#editTimeType').attr('readonly', false);
                $('#RemarkTextarea').attr('readonly', false);
                $('#editInTime').attr('readonly', false);
                $('#editOutTime').attr('readonly', false);

            }
            $.ajax({
                url: "{{ url('/admin/requests/mispunch/detail') }}",
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

                        var timestamp = result.get.emp_miss_in_time;
                        var formattedTime = (timestamp);
                        console.log("formattedTime " + formattedTime);
                        $('#editBranch').val(result.get.branch_name);
                        $('#editDepratment').val(result.get.depart_name);
                        $('#editDesignation').val(result.get.desig_name);
                        $('#editEmpName').val(result.get.emp_name + ' ' + (result.get.emp_mname != null ? result
                            .get.emp_mname : '') + ' ' + result.get.emp_lname);
                        $('#editEmpId').val(result.get.emp_id);
                        $('#editMobileNo').val(result.get.emp_mobile_no);
                        $('#editDate').val(result.get.emp_miss_date);
                        console.log(result.get.emp_miss_time_type);
                        $('#editMobileNo').val(result.get.emp_mobile_number);
                        $('#editOutTime').val(result.get.emp_miss_out_time);
                        $('#editInTime').val(result.get.emp_miss_in_time);
                        $('#editTimeType').val(result.get.time_type);
                        console.log(result.get.message);
                        $('#editReason').val(result.get.message);
                        $('#RemarkTextarea').val(result.get.remark);

                    } else {

                    }
                },
            });
        }


        $(document).ready(function() {

            // Add event listeners to the dropdowns
            $('#country-dd, #state-dd, #desig-dd').change(function() {
                // Get selected values
                var branchId = $('#country-dd').val();
                var departmentId = $('#state-dd').val();
                // console.log(departmentId);
                var designationId = $('#desig-dd').val();
                // console.log(designationId);

                // Make an AJAX request to filter employees
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/requests/mispunchemployeefilter') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId
                    },
                    success: function(data) {
                        console.log("data " + data);
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
                                    '<td>' + `<div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                    style="background-image: url('/employee_profile/` + el
                                    .profile_photo + `')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">` + el.emp_name + `&nbsp;` + (el
                                        .emp_mname != null ? 'el.emp_mname' : ''
                                    ) +
                                    `&nbsp;` + el.emp_lname + `</h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        ` + el.desig_name + `</p>
                                                </div>
                                            </div>` + '</td>' +
                                    '<td>' + el.emp_id + '</td>' +
                                    '<td>' + el.emp_miss_date + '</td>' +
                                    '<td>' + el.emp_miss_time_type + '</td>' +
                                    '<td>' + convert24To12(el
                                        .emp_miss_in_time) + '</td>' +
                                    '<td>' + convert24To12(el
                                        .emp_miss_out_time) + '</td>' +
                                    '<td>' + el.emp_working_hour + '</td>' +
                                    // '<td>' + el.message + '</td>' +
                                    '<td>' + (el.status == 0 ?
                                        `<span class="badge badge-primary-light">Requested</span>` :
                                        (el.status == 1 ?
                                            '<span class="badge badge-success-light">Approved</span>' :
                                            (el.status == 2 ?
                                                `<span class="badge badge-warning-light">Declined</span>` :
                                                ' <span class="badge badge-primary-light">Requested</span>'
                                            ))) + '</td>' +
                                    '<td>'
                                newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                            onclick="openEditModel(this)" data-id="${el.id}"  data-status="${el.status}"
                            data-bs-toggle="modal" data-bs-target="#opendEditModelId">
                            <i class="feather feather-edit" data-bs-toggle="tooltip"
                                data-original-title="View"></i>
                           </a>`;

                                //         newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                            //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.id}" 
                            //     data-bs-target="#deletemodal">
                            //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                            //         data-original-title="View"></i>
                            // </a>`;
                                newRow += '</td></tr>';
                                // Add your action buttons here
                                // '</tr>';
                                // i++;
                                tbody.append(newRow);
                            });

                        });
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
@endsection
