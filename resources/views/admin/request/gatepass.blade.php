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
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/leaves') }}">Requests</a></li>
                <li class="active"><span><b>Gatepass</b></span></li>
            </ol>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gatepass Summary</h3>
                    </div>
                    <livewire:request.gatepass-request-list-livewire>
                </div>
            </div>
        </div>


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
