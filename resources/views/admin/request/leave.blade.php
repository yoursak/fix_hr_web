@extends('admin.pagelayout.master')
@section('title', 'Leave')

@if (in_array('Leave.View', $permissions) || in_array('Leave.All', $permissions))
    @section('content')
        <style>
            .custom-tooltip .tooltip-inner {
                color: #000;
            }
        </style>
        <?php
        $centralUnit = new App\Helpers\Central_unit();
        $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement(); // Create an instance of the Central_unit class
        $Department = $centralUnit->DepartmentList();
        
        $Designation = $centralUnit->DesignationList();
        $i = 0;
        $j = 1;
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $Count = $centralUnit->LeaveSectionCount();
        $DailyCount = $centralUnit->getDashboardCount(Session::get('business_id'), date('Y-m-d'));

        // dd($DATALEAVE);
        ?>
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
                                    <h3 class="mb-0 mt-1 text-success">{{ $Count[1] }}/{{ $Count[0] }}</h3>
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
                                    <h3 class="mb-0 mt-1 text-primary" id="paidLeaveId" > {{ $Count[2] }}</h3>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold" >Unpaid Leaves</span>
                                    <h3 class="mb-0 mt-1 text-secondary" id="unpaidLeaveId"> {{ $Count[3] }}</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-secondary-transparent my-auto  float-end"><i
                                        class="las la-female"></i>
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
                                    <h3 class="mb-0 mt-1 text-danger" id="pendingRequestId">{{ $Count[4] }}</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-danger-transparent my-auto  float-end"> <i
                                        class="las la-user-friends"></i>
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
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="filter-branch" class="form-control" required>
                                        <option value="">All Branch</option>
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
                            <div class="col-lg-2">
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
                            <div class="col-lg-2">
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
                            <table class="table  table-vcenter text-nowrap  border-bottom" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0" hidden>S.No.</th>
                                        <th class="border-bottom-0">Employee Name</th>
                                        <th class="border-bottom-0">Employee Id</th>
                                        <th class="border-bottom-0">Applied Date</th>
                                        <th class="border-bottom-0">Leave Category</th>
                                        <th class="border-bottom-0">Leave Type</th>
                                        <th class="border-bottom-0">From</th>
                                        <th class="border-bottom-0">To</th>
                                        <th class="border-bottom-0">Days</th>
                                        <th class="border-bottom-0">Status</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="my_body">
                                    @php
                                        $count = 1;

                                    @endphp
                                    @foreach ($DATALEAVE as $key=> $item)
                                        <tr>
                                            <td hidden>{{$key++ }}</td>
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
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ $item->leave_day }}</td>
                                            <td>{{ $item->from_date ? \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') : '' }}
                                            </td>
                                            <td>{{ $item->to_date ? \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') : '' }}
                                            </td>
                                            <td>{{ $item->days }}</td>
                                            <td>
                                                <?php
                                                $loadgoo = $item->id;
                                                ?>
                                                <?= $RuleManagement->RequestLeaveApprovalManage($checkApprovalCycleType, $item, $loadgoo, 2, $loginRoleID) ?>   
                                            </td>
                                            <td>
                                                <?php
                                                $RoleRedCode = DB::table('request_leave_list')
                                                    ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                                    ->where('request_leave_list.business_id', $loginRoleBID)
                                                    ->where('request_leave_list.id', $item->id)
                                                    ->select('request_leave_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                    ->first();
                                                ?>
                                                <?php
                                                $approval_type_id_static = 2;
                                                if ($checkApprovalCycleType == 1) {
                                                    $current_status_particular_tb = DB::table('approval_status_list')
                                                        ->where('approval_type_id', 2)
                                                        ->where('applied_cycle_type', 1)
                                                        ->where('emp_id', $loginEmpID)
                                                        ->where('role_id', $loginRoleID)
                                                        ->where('all_request_id', $item->id)
                                                        ->first();
                                                    // echo '1';
                                                }
                                                if ($checkApprovalCycleType == 2) {
                                                    $current_status_particular_tb = DB::table('approval_status_list')
                                                        ->where('approval_type_id', 2)
                                                        ->where('applied_cycle_type', 2)
                                                        ->where('all_request_id', $item->id)
                                                        ->first();
                                                    // echo '2';
                                                }
                                                $prevRoleID = $RuleManagement::RoleName($item->forward_by_role_id ?? 0)[0];
                                                $runtimeStatus = $prevRoleID->roles_name ?? 0;
                                                ?>
                                                @if (in_array('Leave.Update', $permissions) || in_array('Leave.All', $permissions))
                                                    <?php  if(($RoleRedCode->final_status==1) ||  ($RoleRedCode->final_status==2)){ ?>
                                                    <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                        id="edit_btn_modal" onclick="openEditModel(this)"
                                                        data-id='<?= $item->id ?>'
                                                        data-viewbtn='<?= $item->final_status ?>'
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


                                                    <?php  if($RoleRedCode->final_status==0){ ?>
                                                    <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                        id="edit_btn_modal" onclick="openEditModel(this)"
                                                        data-id='<?= $item->id ?>'
                                                        data-viewbtn='<?= $item->final_status ?>'
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
                                                {{-- @if (in_array('Leave.Delete', $permissions) || in_array('Leave.All', $permissions))
                                                    <a class="btn btn-danger btn-icon btn-sm " href="javascript:void(0);"
                                                        id="edit_btn_modal" onclick="ItemDeleteModel(this)"
                                                        data-id='<?= $item->id ?>' data-bs-toggle="modal" data
                                                        data-bs-target="#LeaveDeleteModal">
                                                        <i class="feather feather-trash" data-bs-toggle="tooltip"
                                                            data-original-title="Delete"></i>
                                                    </a>
                                                @endif --}}

                                                {{-- <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                onclick="ItemDeleteModel(this)" data-branch_id='<?= $item->branch_id ?>'
                                                data-branch_name='<?= $item->branch_name ?>'
                                                data-bs-target="#branchDeletebtn" id="BranchEditbtn" title="Edit">
                                                <i class="feather feather-trash "></i>
                                            </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <div id="pagination-container" class="float-right row">
                                {{ $DATALEAVE->links() }}
                            </div> --}}
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
                                    <select name="time_type" class="form-control" value="" id="edit_shift_type" disabled>
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
            document.addEventListener('DOMContentLoaded', function () {
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
            $(document).ready(function() {
                $('#filter-branch').on('change', function() {
                    var branch_id = this.value;
                    // console.log(branch_id);
                    $("#filter-department").html('');
                    $("#filter-designation").html('');

                    $.ajax({
                        url: "{{ url('admin/requests/leavedepartmentfilter') }}",
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
                                '<option value="">All Designation</</option>');
                        }
                    });
                });
                $('#filter-department').on('change', function() {
                    var depart_id = this.value;
                    var branch_id = $('#filter-branch').val();
                    console.log("depart_id " + depart_id);
                    $("#filter-designation").html('');
                    $.ajax({
                        url: "{{ url('admin/requests/leavedesignationfilter') }}",
                        type: "POST",
                        data: {
                            branch_id: branch_id,
                            depart_id: depart_id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(res) {
                            $('#filter-designation').html(
                                '<option value="">All Designation</</option>');
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
                //     // Add event listeners to the dropdowns
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
                                console.log("leave branchdepartdesgifilter ", data);
                                // Update the table body with the filtered data
                                var tbody = $('.my_body');
                                tbody.empty();
                                var currentstatus = data['currentstatupartdb'];
                                var status = data['status'];
                                console.log("pendingLeave ", data.PendingLeave);
                                $('#pendingRequestId').text(data.PendingLeave);
                                $('#unpaidLeaveId').text(data.UnpaidLeave);
                                $('#paidLeaveId').text(data.PaidLeave);
                                let i = 1;
                                $.each(data.get, function(index, employee) {
                                    var dateObject = new Date(employee.created_at);

                                    // Extract the components of the date
                                    var day = dateObject.getDate();
                                    var month = dateObject.getMonth() +
                                        1; // Months are zero-based
                                    var year = dateObject.getFullYear();

                                    // Format the date as "DD-MM-YYYY"
                                    var formattedDate = (day < 10 ? '0' : '') + day + '-' + (
                                        month < 10 ? '0' : '') + month + '-' + year;
                                    var sd = employee.emp_id;
                                    var newRow = '<tr>' +
                                        '<td>' + `<div class="d-flex">
                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                style="background-image: url('/storage/livewire_employee_profile/` + employee
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
                                        '<td>' + formattedDate + '</td>' +
                                        '<td>' + employee.category_name + '</td>' +
                                        '<td>' + employee.leave_day + '</td>' +
                                        '<td>' + formatDate(employee.from_date) + '</td>' +
                                        '<td>' + formatDate(employee.to_date) + '</td>' +
                                        '<td>' + employee.days + '</td>' +
                                        '<td>' +
                                        status[employee.id] +
                                        '</td>' +
                                        // '<td>' + employee.id + '</td>' +
                                        '<td>'
                                    '<?php if(in_array('Leave.Update', $permissions)){ ?>'
                                    if (employee.final_status == 1 || employee
                                        .final_status ==
                                        2) {
                                        newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditModel(this)" 
                                                data-id="${employee.id}" 
                                                data-leave_shift_type="${employee.leave_shift_type}" 
                                                data-processcomplete="${employee.process_complete}" 
                                                data-viewbtn="${employee.final_status}"                                                 
                                                data-leavetype='${employee.leave_type}'
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
                                                data-leave_shift_type="${employee.leave_shift_type}" 
                                                data-leavetype='${employee.leave_type}'
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

                                function formatDate(inputDate) {
                                    var dateTokens = inputDate.split('-');
                                    var formattedDate = dateTokens[2] + '-' + dateTokens[1] + '-' +
                                        dateTokens[0];
                                    return formattedDate;
                                }


                            }
                        });
                    });


            });
        </script>


        <script>
            function fromDateChange1(context) {
                var fromDate = context.value;
                var toDateInput = document.getElementById('editToT'); // Get the 'toDate' input field
                toDateInput.value = fromDate; // Set the 'value' property of 'toDate' to the selected 'fromDate'
            }




            document.getElementById('editFrom').addEventListener('change', calculateDateDifference);
            document.getElementById('editTo').addEventListener('change', calculateDateDifference);

            // document.getElementById('editFromT').addEventListener('change', calculateDateDifferenceHalf);
            // document.getElementById('editToT').addEventListener('change', calculateDateDifferenceHalf);

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
                    $('#editToT').attr('readonly', false);

                } else if (selectedValue == 2) {
                    $('#editToT').attr('readonly', true);
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
                    console.log('case Sequencial');
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
                        if(parallerApprovalRolecheck){
                            $('#editModalFooter').show();
                        }else{
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
                        console.log(result);
                        if (result.get.id) {
                            console.log("result", result);
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
