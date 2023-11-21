@extends('admin.pagelayout.master')
@section('title', 'Leave')

@section('content')
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
    // foreach ($Department as $item) {
    //     $i++;
    // }
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
                        <div class="col-lg-2">
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
                        <div class="col-lg-2">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3">
                                    <select id="state-dd" name="department_id" class="form-control" required>
                                        <option value="">--- Select Deparment ---</option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
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
                <div class="card-body pt-2  ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable"
                            class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
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
                                {{-- @empty($DATA) --}}

                                @foreach ($DATA as $key => $item)
                                    <?php
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
                                    // $nextRoleID= $RuleManagement::RoleName($current_status_particular_tb->role_id??0)[0];
                                    
                                    // echo ($goRoleID->roles_name??0);
                                    ?>
                                    {{-- @php
                                $DesignationName = $central::DasignationName($item->designation_id);

                                @endphp --}}
                                    <tr>
                                        <td>{{ ++$key }}</td>
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
                                            $checkingCover = DB::table('approval_status_list')
                                                ->where('business_id', $loginRoleBID)
                                                ->where('all_request_id', $item->id)
                                                ->first();
                                            $RoleRedCode = DB::table('request_leave_list')
                                                ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                                ->where('request_leave_list.business_id', $loginRoleBID)
                                                ->where('request_leave_list.id', $item->id)
                                                ->first();
                                            if ($checkApprovalCycleType == 1) {
                                                // Check for Pending Status
                                                if ($checkingCover != null) {
                                                    $checkingCoversLoad = DB::table('approval_status_list')
                                                        ->where('business_id', $loginRoleBID)
                                                        ->where('role_id', $loginRoleID)
                                                        ->where('all_request_id', $item->id)
                                                        ->first();
                                            
                                                    if ($checkingCoversLoad) {
                                                        $CheckCurrentStaticStatus = DB::table('approval_status_list')
                                                            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                            ->where('approval_status_list.business_id', $loginRoleBID)
                                                            ->where('approval_status_list.role_id', $loginRoleID)
                                                            ->where('approval_status_list.all_request_id', $item->id)
                                                            ->first();
                                            
                                                        if ($CheckCurrentStaticStatus != null) {
                                                            $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatus->next_role_id)[0];
                                                            $ForwardName = $CheckingRole->roles_name ?? 0;
                                            
                                                            if ($item->process_complete == 1) {
                                                                $SD = DB::table('request_leave_list')
                                                                    ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                                                    ->where('request_leave_list.business_id', $loginRoleBID)
                                                                    ->where('request_leave_list.id', $item->id)
                                                                    ->first();
                                            
                                                                $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i>' : '<i class="ion-close-circled"></i>';
                                                                $statusColor = $SD->request_color;
                                                                $statusResponse = $SD->request_response;
                                            
                                                                echo '<small><span class="' . $statusColor . '">' . $statusIcon . ' ' . $statusResponse . '</span></small>';
                                                            } else {
                                                                // $forwared = true;
                                            
                                                                if ($CheckCurrentStaticStatus->status == 1) {
                                                                    echo '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $CheckCurrentStaticStatus->request_response . '</small>';
                                                                }
                                                                if ($CheckCurrentStaticStatus->status == 2) {
                                                                    echo '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                                                }
                                            
                                                                $checkingLoad = DB::table('approval_management_cycle')
                                                                    ->where('business_id', Session::get('business_id'))
                                                                    ->where('approval_type_id', 2)
                                                                    ->whereJsonContains('role_id', (string) $loginRoleID)
                                                                    ->select('role_id')
                                                                    ->first();
                                            
                                                                $roleIds = json_decode($checkingLoad->role_id, true);
                                                                $currentIndex = array_search($loginRoleID, $roleIds);
                                                                $nextIndex = $currentIndex + 1;
                                                                $nextRoleId = isset($roleIds[$nextIndex]) ? $roleIds[$nextIndex] : -1;
                                            
                                                                $ApprovedName = DB::table('approval_status_list')
                                                                    ->where('all_request_id', $item->id)
                                                                    ->where('approval_status_list.business_id', $loginRoleBID)
                                                                    ->where('approval_status_list.role_id', $loginRoleID)
                                                                    ->where('approval_type_id', 2)
                                                                    ->first();
                                                                $CheckingLoad = DB::table('approval_status_list')
                                                                    ->where('all_request_id', $item->id)
                                                                    ->where('approval_type_id', 2)
                                                                    ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                                                    ->first();
                                                                // ->where('role_id', $nextRoleId)
                                            
                                                                $gotopow = $RuleManagement::RoleName($CheckingLoad->role_id ?? 0)[0];
                                                                $ApprovedName2 = $gotopow->roles_name ?? 0;
                                            
                                                                if ($ApprovedName2 != 0) {
                                                                    // dd($CheckingLoad);
                                                                    if (isset($CheckingLoad)) {
                                                                        if ($CheckingLoad->status == 1) {
                                                                            echo '<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                                                        }
                                                                        if ($CheckingLoad->status == 2) {
                                                                            echo '<br><small>Decliend To ' . $ApprovedName2 . '</small>';
                                                                        }
                                                                    } else {
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $requestGet = DB::table('approval_status_list')
                                                            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                            ->where('approval_status_list.all_request_id', $item->id)
                                                            ->where('approval_status_list.next_role_id', $loginRoleID)
                                                            ->where('approval_status_list.applied_cycle_type', 1)
                                                            ->first();
                                            
                                                        if ($requestGet ?? false) {
                                                            $CheckingRole = $RuleManagement::RoleName($requestGet->current_role_id ?? 0)[0];
                                                            $ForwardName = $CheckingRole->roles_name ?? 0;
                                            
                                                            // $ApprovedName = $CheckingRole->roles_name ?? 0;
                                                            // dd($requestGet->current_role_id);
                                                            echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '<b><br> Remark : ' . nl2br($requestGet->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Padding</small>';
                                                        } else {
                                                            $CheckCurrentStaticStatusSecond = DB::table('request_leave_list')
                                                                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
                                                                ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                                                ->where('approval_status_list.approval_type_id', 2)
                                                                ->where('request_leave_list.id', $item->id)
                                                                ->where('request_leave_list.business_id', $loginRoleBID)
                                                                ->first();
                                            
                                                            $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                                            
                                                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                                                            if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                                                echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                            } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                                                echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                            } else {
                                                                echo '<span class="badge badge-warning-light"><i class="ion-wand"></i> Padding</span>';
                                                            }
                                            
                                                            // echo '<span class="badge badge-warning-light"><i class="ion-wand"></i> Padding</span>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<span class="badge badge-primary-light">Requested</span>';
                                                }
                                            }
                                            
                                            if ($checkApprovalCycleType == 2) {
                                                $CheckCurrentStaticStatusSecond = DB::table('request_leave_list')
                                                    ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_leave_list.id')
                                                    ->join('static_status_request', 'request_leave_list.final_status', '=', 'static_status_request.id')
                                                    ->where('approval_status_list.approval_type_id', 2)
                                                    ->where('request_leave_list.id', $item->id)
                                                    ->where('request_leave_list.business_id', $loginRoleBID)
                                                    ->first();
                                            
                                                // DB::table('approval_status_list')
                                                //     ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                //     ->where('approval_status_list.approval_type_id', 2)
                                                //     ->where('approval_status_list.business_id', $loginRoleBID)
                                                //     ->where('approval_status_list.all_request_id', $item->id)
                                                //     ->first();
                                            
                                                if (!empty($CheckCurrentStaticStatusSecond)) {
                                                    $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                                                    $check = DB::table('business_details_list')
                                                        ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                                        ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                                        ->first();
                                                    $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);
                                                    if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                                        echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                    } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                                        echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                    } else {
                                                        echo '<span class="badge badge-warning-light"><i class="ion-wand"></i> Padding</span>';
                                                    }
                                                } else {
                                                    echo '<span class="badge badge-primary-light">Requested</span>';
                                                }
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            @if (in_array('Leave.Update', $permissions))
                                                <?php  if($RoleRedCode->final_status==0){ ?>
                                                <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                    id="edit_btn_modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->id ?>'
                                                    data-process_complete='<?= $item->process_complete ?>'
                                                    data-forward_by_status="<?= $item->forward_by_status ?>"
                                                    data-current_status_particulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                    data-forward_role_id='<?= $item->forward_by_role_id ?>'
                                                    data-leavetype='<?= $item->leave_type ?>' data-bs-toggle="modal" data
                                                    data-bs-target="#opendEditModelId">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                                <?php }?>
                                            @endif
                                            {{-- @if (in_array('Leave.Delete', $permissions))
                                        <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#deletemodal{{ $item->id }}">
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

                        <div class="form-row" id="leaveTypeOneShow">
                            <div class="form-group  col-lg-2 col-md-4">
                                <label for="inputPassword4">Leave Type</label>
                                <select name="leave_type" class="form-control" onchange="checkLeaveType(this)"
                                    value="" id="editLeaveTypeFirst">
                                    <option value="">Select Type</option>
                                    @foreach ($leaveType as $leavetypes)
                                        <option value="{{ $leavetypes->id }}">
                                            {{ $leavetypes->leave_day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group  col-lg-2 col-md-4">
                                <label for="inputPassword4">Leave Category</label>
                                <select name="time_type" class="form-control" value=""
                                    id="editLeaveCategoryFirst">
                                    <option value="">Select Category</option>
                                    @foreach ($leaveCategory as $leavcat)
                                        <option value="{{ $leavcat->id }}">
                                            {{ $leavcat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group  col-lg-3 col-md-4">
                                <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control" id="editFrom" name="from_date"
                                    placeholder="time" value="">
                            </div>

                            <div class="form-group  col-lg-3 col-md-4">
                                <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control" name="to_date" id="editTo"
                                    placeholder="Password" value="">
                            </div>
                            {{-- <div class="form-group col-md-2">
                            <label for="inputPassword4">Leave Value</label>
                            <select name="time_type" class="form-control" value="" id="edit_shift_type">
                                <option value="">Select Shift Type</option>
                                @foreach ($shiftType as $shifttype)
                                <option value="{{ $shifttype->id }}">
                                    {{ $shifttype->leave_shift_type }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}
                            <div class="form-group  col-lg-2 col-md-4">
                                <label for="inputPassword4">Days</label>
                                <input type="text" class="form-control" id="editDays" name="days" value=""
                                    placeholder="days">
                            </div>
                        </div>
                        <div class="form-row" id="leaveTypeTwoShow">
                            <div class="form-group  col-lg-2 col-md-4">
                                <label for="inputPassword4">Leave Type</label>
                                <select name="time_type" class="form-control" value=""
                                    onchange="checkLeaveType(this)" id="editLeaveTypeSecond">
                                    <option value="">Select Type</option>
                                    @foreach ($leaveType as $leavetypes)
                                        <option value="{{ $leavetypes->id }}">
                                            {{ $leavetypes->leave_day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-4">
                                <label for="inputPassword4">Leave Category</label>
                                <select name="time_type" class="form-control" value=""
                                    id="editLeaveCategorySecond">
                                    <option value="">Select Category</option>
                                    @foreach ($leaveCategory as $leavcat)
                                        <option value="{{ $leavcat->id }}">
                                            {{ $leavcat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-4">
                                <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control px-2" id="editFromT" name="from_date"
                                    placeholder="time" value="">
                            </div>

                            <div class="form-group col-lg-2 col-md-4">
                                <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" class="form-control px-2" name="to_date" id="editToT"
                                    placeholder="Password" value="">
                            </div>

                            <div class="form-group col-lg-2 col-md-4">
                                <label for="inputPassword4">Leave Value</label>
                                <select name="time_type" class="form-control" value="" id="edit_shift_type">
                                    <option value="">Select Shift Type</option>
                                    @foreach ($shiftType as $shifttype)
                                        <option value="{{ $shifttype->id }}">
                                            {{ $shifttype->leave_shift_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-md-4">
                                <label for="inputPassword4">Days</label>
                                <input type="text" class="form-control" id="editDaysSecond" name="days1"
                                    placeholder="days">
                            </div>
                        </div>
                        {{-- <div class="form-row">
                            <div class="form-group col">
                                Remaining Leaves:
                                @foreach ($leaveCategory as $leavcat)
                                    <span>{{ $leavcat->category_name }}</span>-><span>{{ $leavcat->days }}</span> ||
                                @endforeach
                            </div>
                        </div> --}}
                        {{-- <div class="form-row">
                            <div class="form-group col">
                                <span style="color:red">Disclamer:</span>
                                @foreach ($leaveCategory as $leavcat)
                                    <span>{{ $leavcat->category_name }}</span>-><span>{{ $leavcat->days }}</span> ||
                                @endforeach
                            </div>
                        </div> --}}

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
                            <a class="btn btn-danger mx-2 d-none" id="BackBtn_MGA" type=""
                                onclick="back()">Back</a>
                            <button class="btn btn-primary mx-2 d-none" id="SubmitBtn_MGA" type="submit" name="decline"
                                value="2">Submit</button>
                            <?php //}
                            ?>

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
        $(document).ready(function() {

            //     // Add event listeners to the dropdowns
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
                        console.log("data", data);
                        // Update the table body with the filtered data
                        var tbody = $('.my_body');
                        // tbody.empty();

                        $.each(data, function(index, employee) {
                            // console.log(employee);
                            let i = 1;
                            // if (Array.isArray(employee)) {
                            //     // Use forEach on the array
                            //     employee.forEach(employee => {
                            //         // Your logic here
                            //     });
                            // } else {
                            //     console.error('employee is not an array');
                            // }
                            // employee.forEach(emp => {
                            //     console.log(emp);
                            // });

                            // employee.forEach(el => {
                            //     console.log("Employee:", el);
                            // });
                            //     employee.forEach(el => {
                            // //    console.log("employee aa", el);
                            // console.log("chal bhai");

                            //     });

                            // employee.forEach(el => {
                            //     console.log(el.emp_id);
                            //     var newRow = '<tr>' +
                            //         '<td>' + i++ + '</td>' +
                            //         '<td>' + el.id + '</td></tr>';
                            // '<td>' + `<div class="d-flex">
                        //         <span class="avatar avatar-md brround me-3 rounded-circle"
                        //             style="background-image: url('/employee_profile/` + el
                            // .profile_photo + `')"></span>
                        //         <div class="me-3 mt-0 mt-sm-1 d-block">
                        //             <h6 class="mb-1 fs-14">` + el.emp_name + `&nbsp;` + (el
                            //     .emp_mname != null ? 'el.emp_mname' : ''
                            // ) +
                            // `&nbsp;` + el.emp_lname + `</h6>
                        //             <p class="text-muted mb-0 fs-12">
                        //                 ` + el.desig_name + `</p>
                        //         </div>
                        //     </div>` + '</td>' +
                            // '<td>' + el.emp_id + '</td>' +
                            // '<td>' + el.leave_type + '</td>' +
                            // '<td>' + el.from_date + '</td>' +
                            // '<td>' + el.to_date + '</td>' +
                            // '<td>' + el.days + '</td>' +
                            // '<td>' '</td>' +

                            // '<td>' + (el.status == 0 ?
                            //     `<span class="badge badge-primary-light">Requested</span>` :
                            //     (el.status == 1 ?
                            //         '<span class="badge badge-success-light">Approved</span>' :
                            //         (el.status == 2 ?
                            //             `<span class="badge badge-warning-light">Declined</span>` :
                            //             ' <span class="badge badge-primary-light">Requested</span>'
                            //         ))) + '</td>' +

                            //                 '<td>'
                            //             newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                        //     onclick="openEditModel(this)" data-id="${el.id}"  data-status="${el.status}"
                        //     data-bs-toggle="modal" data-bs-target="#opendEditModelId">
                        //     <i class="feather feather-edit" data-bs-toggle="tooltip"
                        //         data-original-title="View"></i>
                        //    </a>`;

                            //         newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                        //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.id}" 
                        //     data-bs-target="#deletemodal">
                        //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                        //         data-original-title="View"></i>
                        // </a>`;
                            //     // newRow += '</td></tr>';
                            //     i++;
                            //     tbody.append(newRow);
                            // });

                        });
                    }
                });
            });
            //     // $('#country-dd').on('change', function() {
            //     //     var branch_id = this.value;
            //     //     $("#state-dd").html('');
            //     //     $.ajax({
            //     //         url: "{{ url('admin/settings/business/alldepartment') }}",
            //     //         type: "POST",
            //     //         data: {
            //     //             _token: '{{ csrf_token() }}',
            //     //             brand_id: branch_id
            //     //         },
            //     //         dataType: 'json',
            //     //         success: function(result) {

            //     //             // console.log(result);
            //     //             $('#state-dd').html(
            //     //                 '<option value="" name="department">Select Department Name</option>'
            //     //             );
            //     //             $.each(result.department, function(key, value) {
            //     //                 $("#state-dd").append('<option name="department" value="' +
            //     //                     value
            //     //                     .depart_id + '">' + value.depart_name +
            //     //                     '</option>');
            //     //             });
            //     //             $('#desig-dd').html(
            //     //                 '<option value="">Select Designation Name</option>');
            //     //         }
            //     //     });
            //     // });

            //     // $('#state-dd').on('change', function() {
            //     //     var depart_id = this.value;
            //     //     $("#desig-dd").html('');
            //     //     $.ajax({
            //     //         url: "{{ url('admin/settings/business/alldesignation') }}",
            //     //         type: "POST",
            //     //         data: {
            //     //             depart_id: depart_id,
            //     //             _token: '{{ csrf_token() }}'
            //     //         },
            //     //         dataType: 'json',
            //     //         success: function(res) {
            //     //             // console.log(res);
            //     //             $('#desig-dd').html(
            //     //                 '<option value="">Select Designation Name</option>');
            //     //             $.each(res.designation, function(key, value) {
            //     //                 $("#desig-dd").append('<option value="' + value
            //     //                     .desig_id + '">' + value.desig_name + '</option>');
            //     //             });
            //     //             // $('#employee-dd').html(
            //     //             //     '<option value="">Select Employee Name</option>');

            //     //         }
            //     //     });
            //     // });
            //     // // employee
            //     // $('#state-dd').on('change', function() {
            //     //     var depart_id = this.value;
            //     //     $("#employee-dd").html('');
            //     //     $.ajax({
            //     //         url: "{{ url('admin/settings/business/allemployeefilter') }}",
            //     //         type: "POST",
            //     //         data: {
            //     //             _token: '{{ csrf_token() }}',
            //     //             depart_id: depart_id,
            //     //         },
            //     //         dataType: 'json',
            //     //         success: function(res) {
            //     //             // console.log(res);
            //     //             $('#employee-dd').html('<option value="">Select Employee</option>');
            //     //             $.each(res.employee, function(key, value) {
            //     //                 $("#employee-dd").append('<option value="' + value.emp_id +
            //     //                     '">' + value.emp_name + '</option>');
            //     //             });
            //     //         }
            //     //     });
            //     // });

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
        // function checkLeaveType(context) {
        //     var selectedValue = context.value;
        //     if (selectedValue == 1) {
        //         $('#leaveTypeOneShow').removeClass('d-none');
        //         $('#leaveTypeTwoShow').addClass('d-none');
        //         $('#editLeaveTypeSecond').selectedValue;
        //         $('#editLeaveTypeFirst').selectedValue;
        //     } else if (selectedValue == 2) {
        //         $('#leaveTypeOneShow').addClass('d-none');
        //         $('#leaveTypeTwoShow').removeClass('d-none');
        //         $('#editLeaveTypeSecond').selectedValue;
        //         $('#editLeaveTypeFirst').selectedValue;
        //     }
        //     console.log("Selected Value: " + selectedValue);
        // }

        function openEditModel(context) {
            var loginRoleID = '<?= $loginRoleID ?>';
            var checkApprovalCycleType = '<?= $checkApprovalCycleType ?>';
            $("#opendEditModelId").modal("show");
            var id = $(context).data('id');
            var status = $(context).data('status');
            var leavetype = $(context).data('leavetype');
            var forwardRoleid = $(context).data('forward_role_id');
            var current_status_particulartb = $(context).data('current_status_particulartb');
            var forward_by_status = $(context).data('forward_by_status');
            var process_complete = $(context).data('process_complete');
            console.log("leavetype " + leavetype);
            $('#editLeaveId').val(id);
            // $('#status').val(status);

            if (leavetype == 1) {
                $('#leaveTypeOneShow').removeClass('d-none');
                $('#leaveTypeTwoShow').addClass('d-none');

            } else if (leavetype == 2) {
                $('#leaveTypeOneShow').addClass('d-none');
                $('#leaveTypeTwoShow').removeClass('d-none');
            }
            console.log("id : " + id);
            console.log("Cycle Type : " + parseInt(checkApprovalCycleType));
            console.log("current status : " + parseInt(current_status_particulartb));
            console.log("forwared status: " + parseInt(forward_by_status));
            // if(parseInt(current_status_particulartb)!=1)
            // {  
            //         $('#editModalFooter').removeClass('d-none');

            // console.log("1 status check aagya");
            // }else 

            if (parseInt(checkApprovalCycleType) == 1) {
                console.log('case Sequencial');
                // if(parseInt(forward_by_status)!=0)
                // {
                //     console.log(' level bhai log 1 ');

                //     $('#editModalFooter').hide();
                // else if(parseInt(forwardRoleid)!=parseInt(loginRoleID))
                //     {
                //         console.log(' level 2');
                //         $('#editModalFooter').hide();

                //     }
                // }else{
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


                // }
                // if(parseInt(current_status_particulartb)!=0)
                // {


                // }else{

                // }
                // else{ 
                //     $('#editModalFooter').hide();
                // }
                // else{

                //     if(parseInt(forwardRoleid)==parseInt(loginRoleID) ){

                //     $('#editModalFooter').show();
                // //     //      console.log("2 id match ");

                //     }
                // //     // else{
                //     $('#editModalFooter').hide();

                //     // }
                // }

                // $('#editModalFooter').hide();
            }
            if (parseInt(checkApprovalCycleType) == 2) {
                console.log("Cycle 2 aagayahy");
                if (parseInt(current_status_particulartb) != 0) {
                    $('#editModalFooter').hide();
                }
                if (parseInt(process_complete) != 0) {
                    $('#editModalFooter').hide();

                    console.log('procee complete');

                } else {
                    $('#editModalFooter').show();
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
                        $('#editMobileNo').val(result.get.emp_mobile_no);
                        $('#editDate').val(result.get.date);
                        $('#editFrom').val(result.get.from_date);
                        $('#editFromT').val(result.get.from_date);
                        $('#editTo').val(result.get.to_date);
                        $('#editToT').val(result.get.to_date);
                        $('#editLeaveTypeFirst').val(result.get.leave_type);
                        $('#editLeaveTypeSecond').val(result.get.leave_type);
                        $('#edit_shift_type').val(result.get.shift_type);
                        $('#editLeaveCategoryFirst').val(result.get.leave_category);
                        $('#editLeaveCategorySecond').val(result.get.leave_category);
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
