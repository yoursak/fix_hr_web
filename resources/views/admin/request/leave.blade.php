@extends('admin.pagelayout.master')
@section('title', 'Leave')

@if (in_array('Leave.View', $permissions) || in_array('Leave.All', $permissions))
    @section('content')
        <style>
            .custom-tooltip .tooltip-inner {
                color: #000;
            }
        </style>
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/leaves') }}">Requests</a></li>
                <li class="active"><span><b>Leave</b></span></li>
            </ol>
        </div>
        <livewire:request.leave-list-request-livewire>
        {{-- Edit Modal --}}
        <div class="modal fade" id="opendEditModelId" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header " style="background: #1877f2; color:white;">
                        <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Leave Request</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                                style="color: white;">&times;</span></button>
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
                                    <label for="inputPassword4">Department</label>
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
                                    <input type="text" class="form-control" id="editEmpId" placeholder=""
                                        value="" readonly>
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Mobile No.</label>
                                    <input type="text" class="form-control" id="editMobileNo"
                                        placeholder="Mobile No." value="" readonly>
                                </div>
                            </div>

                            <div class="form-row" id="leaveTypeOneShow">
                                <div class="form-group  col-lg-2 col-md-4">
                                    <label for="inputPassword4">Leave Type</label>
                                    <input type="text" class="form-control" value="" id="editLeaveTypeFirst"
                                        readonly>

                                </div>
                                <div class="form-group  col-lg-3 col-md-5">
                                    <label for="inputPassword4">Leave Category</label>
                                    <input type="text" name="time_type" class="form-control" value=""
                                        id="editLeaveCategoryFirst" readonly>
                                </div>
                                <div class="form-group  col-lg-3 col-md-4">
                                    <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control" id="editFrom" name="from_date"
                                        placeholder="time" value="" readonly>
                                </div>

                                <div class="form-group  col-lg-3 col-md-4">
                                    <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control" name="to_date" id="editTo"
                                        placeholder="Password" value="" readonly>
                                </div>

                                <div class="form-group  col-lg-1 col-md-4">
                                    <label for="inputPassword4">Days</label>
                                    <input type="text" class="form-control" id="editDays" name="days"
                                        value="" placeholder="days" readonly>
                                </div>
                            </div>
                            <div class="form-row" id="leaveTypeTwoShow">
                                <div class="form-group  col-lg-2 col-md-4">
                                    <label for="inputPassword4">Leave Type</label>
                                    <input name="time_type" class="form-control" value="" id="editLeaveTypeSecond"
                                        readonly>

                                </div>
                                <div class="form-group col-lg-3 col-md-4">
                                    <label for="inputPassword4">Leave Category</label>
                                    <input type="text" name="time_type" class="form-control" value=""
                                        id="editLeaveCategorySecond" readonly>

                                </div>
                                <div class="form-group col-lg-2 col-md-4">
                                    <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control px-2" id="editFromT" name="from_date"
                                        onchange="fromDateChange1(this)" placeholder="time" value="" readonly>
                                </div>

                                <div class="form-group col-lg-2 col-md-4">
                                    <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control px-2" name="to_date" id="editToT"
                                        placeholder="Password" value="" readonly>
                                </div>

                                <div class="form-group col-lg-2 col-md-4">
                                    <label for="inputPassword4">Leave Value</label>
                                    {{-- <input type="text" name="time_type" class="form-control" value=""
                                        id="edit_shift_type" readonly> --}}
                                    <select name="time_type" class="form-control" value="" id="edit_shift_type"
                                        disabled>
                                        <option value="" disabled>Select Shift Type</option>
                                        @foreach ($shiftType as $shifttype)
                                            <option value="{{ $shifttype->id }}">
                                                {{ $shifttype->leave_shift_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-1 col-md-4">
                                    <label for="inputPassword4">Days</label>
                                    <input type="text" class="form-control" id="editDaysSecond" name="days1"
                                        placeholder="days" readonly>
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <label for="inputPassword4" class="">Upload Document &nbsp;&nbsp;&nbsp;</label>
                                <div class="file-manger-icon" id="file-manger-icon">
                                    <a href=""><span class=" text-primary">View file</span></a>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-xl-12">
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

                        <div class="modal-footer" id="editModalFooter">
                            <div class="d-flex me-auto ">
                                <p class="align-middle my-2"><span><b>Mark Leave Approvel</b></span></p>
                            </div>
                            @if (in_array('Leave.Update', $permissions) || in_array('Leave.All', $permissions))
                                <div class="d-flex m-0 ">
                                    <a class="btn btn-danger mx-2" id="CancelBtn_MGA" data-bs-dismiss="" type="cancel"
                                        name="" onclick="remark()" value="">Decline</a>
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
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->

        {{-- modal for delete confirmation --}}
        <div>
            <div class="modal fade" id="LeaveDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('leavedelete') }}" method="POST">
                            @csrf
                            <input type="text" id="leave_delete_id" name="leave_delete_name" hidden>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <h4 class="mt-5">Are you sure want to Delete ?</h4>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger" id="">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
            function ItemDeleteModel(context) {
                var id = $(context).data('id');
                $('#leave_delete_id').val(id);
                $("#LeaveDeleteModal").modal("show");
            }
        </script>


        <script>
            function fromDateChange1(context) {
                var fromDate = context.value;
                var toDateInput = document.getElementById('editToT'); // Get the 'toDate' input field
                toDateInput.value = fromDate; // Set the 'value' property of 'toDate' to the selected 'fromDate'
            }

            document.getElementById('editFrom').addEventListener('change', calculateDateDifference);
            document.getElementById('editTo').addEventListener('change', calculateDateDifference);

            function calculateDateDifference() {
                var fromDate = document.getElementById('editFrom').value;
                var toDate = document.getElementById('editTo').value;
                var submitBtn = document.getElementById('ApproveBtn_MGA');
                var cancelBtn = document.getElementById('SubmitBtn_MGA');
                var toDateInput = document.getElementById('editDays'); // Get the 'toDate' input field



                if (fromDate && toDate) {
                    var from = new Date(fromDate);
                    var to = new Date(toDate);

                    if (from > to) {
                        // Disable both buttons if the condition is met
                        cancelBtn.disabled = true;
                        submitBtn.disabled = true;

                        alert("Please select a 'from' date that is earlier than the 'to' date.");

                    } else {
                        // Enable both buttons if the condition is not met
                        submitBtn.disabled = false;
                        cancelBtn.disabled = false;
                        toDateInput.value = differenceInDays; // Set the 'value' property of 'toDate' to the selected 'fromDate'

                    }

                    var differenceInTime = to - from;
                    var differenceInDays = Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1;
                    $('#editDays').val(differenceInDays);
                    toDateInput.value = differenceInDays; // Set the 'value' property of 'toDate' to the selected 'fromDate'
                }
            }

        </script>

        <script>
            function openEditModel(context) {
                var parallerApprovalRolecheck = '<?= $parallerCaseApprovalListRoleIdCheck ?>';

                var loginRoleID = '<?= $loginRoleID ?>';
                var checkApprovalCycleType = '<?= $checkApprovalCycleType ?>';
                $("#opendEditModelId").modal("show");
                var id = $(context).data('id');
                var leave_shift_type = $(context).data('leave_shift_type');
                var status = $(context).data('status');
                var leavetype = $(context).data('leavetype');
                var forwardRoleid = $(context).data('forwardroleid');
                var current_status_particulartb = $(context).data('currentstatusparticulartb');
                var forward_by_status = $(context).data('forwardbystatus');
                var process_complete = $(context).data('processcomplete');
                var viewBtn = $(context).data('viewbtn');
                if ((parseInt(viewBtn) == 1) || (parseInt(viewBtn) == 2)) {
                    $('#editModalFooter').hide();
                }
                $('#edit_shift_type').val(leave_shift_type);
                $('#editLeaveId').val(id);

                if (leavetype == 1) {
                    $('#leaveTypeOneShow').removeClass('d-none');
                    $('#leaveTypeTwoShow').addClass('d-none');
                    // $('#editToT').attr('readonly', false);


                } else if (leavetype == 2) {
                    $('#leaveTypeOneShow').addClass('d-none');
                    $('#leaveTypeTwoShow').removeClass('d-none');
                    // $('#editToT').attr('readonly', true);

                }
                if (parseInt(checkApprovalCycleType) == 1) {
                    if (parseInt(forwardRoleid) == parseInt(loginRoleID)) {
                        $('#editModalFooter').show();
                    }
                    if (parseInt(process_complete) != 0) {
                        $('#editModalFooter').hide();
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
                    } else {
                        if (parallerApprovalRolecheck) {
                            $('#editModalFooter').show();
                        } else {
                            $('#editModalFooter').hide();
                        }
                    }
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
                        if (result.get.id) {
                            var document = result.get.documents;
                            var fileUrl = ((document !=null) ? "{{ url('') }}" + '/' +
                                document : ''); // Adjust this based on the actual structure of 'document'
                                var $anchor = $('#file-manger-icon a');

                            // Function to handle document availability and set anchor attributes
                            function handleDocumentAvailability() {
                                if (document != null) {
                                    $anchor.attr('href', fileUrl);
                                    $anchor.text('View Document'); // Assuming this is the appropriate text
                                } else {
                                    $anchor.attr('href', 'javascript:void(0);');
                                    $anchor.text('No document available');
                                }
                            }

                            // Set initial document availability
                            handleDocumentAvailability();

                            // Add click event listener
                            $anchor.on('click', function(event) {
                                // Refresh document availability
                                document = result.get.documents;
                                // Handle document availability
                                handleDocumentAvailability();
                                // You can add any additional logic here as needed
                            });
                            // Select the anchor tag and set its href attribute
                            // $('#file-manger-icon a').attr('href', fileUrl);
                            $('#editBranch').val(result.get.branch_name);
                            $('#editDepratment').val(result.get.depart_name);
                            $('#editDesignation').val(result.get.desig_name);
                            $('#editEmpName').val(result.get.emp_name + ' ' + (result.get.emp_mname != null ? result
                                .get.emp_mname : '') + ' ' + result.get.emp_lname);
                            $('#editEmpId').val(result.get.emp_id);
                            $('#editMobileNo').val(result.get.emp_mobile_number);
                            $('#editDate').val(result.get.date);
                            $('#editFrom').val(result.get.from_date);
                            $('#editFromT').val(result.get.from_date);
                            $('#editTo').val(result.get.to_date);
                            $('#editToT').val(result.get.to_date);
                            $('#editLeaveTypeFirst').val(result.get.leave_day);
                            $('#editLeaveTypeSecond').val(result.get.leave_day);
                            $('#edit_shift_type').val(result.get.shift_type);
                            $('#editLeaveCategoryFirst').val(result.get.static_category_name);
                            $('#editLeaveCategorySecond').val(result.get.static_category_name);
                            $('#only_date').val(result.get.from_date);
                            $('#editDays').val(result.get.days);
                            $('#editDaysSecond').val(result.get.days);
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
    @endsection
@endif
