@extends('admin.pagelayout.master')
@section('title', 'Mispunch')

@section('css')
    <style>
    </style>

@endsection

@section('js')
{{-- <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script> --}}

@endsection

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
    // dd($checkmfirstRoleId);
    ?>
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/mispunch') }}">Request</a></li>
            <li class="active"><span><b>Mispunch</b></span></li>
        </ol>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mispunch Summary</h3>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='branch_id' id="filter-branch" class="form-control" required>
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
                                    <select id="filter-department" name="department_id" class="form-control" required>
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
                                    <select id="filter-designation" name="designation_id" class="form-control" required>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Select Date:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" id="dateselect-dd"
                                        name="date_select_name" placeholder="DD-MM-YYYY" type="text">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ROW -->

                <!-- END ROW -->
                <div class="card-body pt-2  px-2">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable"
                            class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
                                    <th class="border-bottom-0">Employee Name</th>
                                    <th class="border-bottom-0">Employee Id</th>
                                    {{-- <th class="border-bottom-0">Applied Date</th> --}}
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0">Time Type</th>
                                    <th class="border-bottom-0">In Time</th>
                                    <th class="border-bottom-0">Out Time</th>
                                    <th class="border-bottom-0">Working Hour</th>
                                    {{-- <th class="border-bottom-0">Days</th> --}}
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
                                    $approval_type_id_static = 3;
                                    
                                    if ($checkApprovalCycleType == 1) {
                                        $current_status_particular_tb = DB::table('approval_status_list')
                                            ->where('approval_type_id', $approval_type_id_static)
                                            ->where('applied_cycle_type', 1)
                                            ->where('emp_id', $loginEmpID)
                                            ->where('role_id', $loginRoleID)
                                            ->where('all_request_id', $item->id)
                                            ->first();
                                        // echo '1';
                                    }
                                    if ($checkApprovalCycleType == 2) {
                                        $current_status_particular_tb = DB::table('approval_status_list')
                                            ->where('approval_type_id', $approval_type_id_static)
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
                                        {{-- <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($item->emp_miss_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->time_type }}</td>
                                        <td> <?= $RuleManagement->Convert24To12($item->emp_miss_in_time) ?></td>
                                        <td> <?= $RuleManagement->Convert24To12($item->emp_miss_out_time) ?></td>
                                        <td>{{ $item->emp_working_hour }}</td>
                                        {{-- <td>{{ $item->id }}</td> --}}
                                        {{-- <td>
                                            <?php
                                            $checkingCover = DB::table('approval_status_list')
                                                ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                ->where('business_id', $loginRoleBID)
                                                ->where('approval_type_id', $approval_type_id_static)
                                                ->where('all_request_id', $item->id)
                                                ->orderBy('approval_status_list.created_at', 'desc')
                                                ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                ->first();
                                            $LatestRemark = $checkingCover != null ? $checkingCover->remarks : ''; // lateset remark according to approvaltypeid = 4 and last entry with the primary id
                                            $LatestStatusName = $checkingCover != null ? $checkingCover->request_response : '';
                                            $LatestStatusValue = $checkingCover->status ?? 0;
                                            $LatestRequestColor = $checkingCover->request_color ?? 0;
                                            $LatestRequestBtnColor = $checkingCover->btn_color ?? 0;
                                            $LatestTooltipColor = $checkingCover->tooltip_color ?? 0;
                                            // dd($item->id);
                                            // dd($checkingCover);
                                            $LastDeclineStatusRemark = DB::table('approval_status_list')
                                                ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                ->where('business_id', $loginRoleBID)
                                                ->where('approval_type_id', $approval_type_id_static)
                                                ->where('all_request_id', $item->id)
                                                ->where('status', 2)
                                                ->orderBy('approval_status_list.created_at', 'desc')
                                                ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                ->first();
                                            $RoleRedCode = DB::table('request_mispunch_list')
                                                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                                ->where('request_mispunch_list.business_id', $loginRoleBID)
                                                ->where('request_mispunch_list.id', $item->id)
                                                ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                ->first();
                                            if ($checkApprovalCycleType == 1) {
                                                // Check for Pending Status
                                                if ($checkingCover != null) {
                                                    $checkingCoversLoad = DB::table('approval_status_list')
                                                        ->where('business_id', $loginRoleBID)
                                                        ->where('role_id', $loginRoleID)
                                                        ->where('approval_type_id', $approval_type_id_static)
                                                        ->where('all_request_id', $item->id)
                                                        ->orderBy('approval_status_list.created_at', 'desc')
                                                        ->first();
                                                    // dd($checkingCoversLoad);
                                            
                                                    if ($checkingCoversLoad) {
                                                        $CheckCurrentStaticStatus = DB::table('approval_status_list')
                                                            ->join('static_status_request', 'approval_status_list.status', '=', 'static_status_request.id')
                                                            ->where('approval_status_list.business_id', $loginRoleBID)
                                                            ->where('approval_status_list.role_id', $loginRoleID)
                                                            ->where('approval_status_list.approval_type_id', $approval_type_id_static)
                                                            ->where('approval_status_list.all_request_id', $item->id)
                                                            ->orderBy('approval_status_list.created_at', 'desc')
                                                            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                            ->first();
                                            
                                                        if ($CheckCurrentStaticStatus != null) {
                                                            $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatus->next_role_id)[0];
                                                            $ForwardName = $CheckingRole->roles_name ?? 0;
                                                            // dd($item->process_complete);
                                            
                                                            if ($item->process_complete == 1) {
                                                                $SD = DB::table('request_mispunch_list')
                                                                    ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                                                    ->where('request_mispunch_list.business_id', $loginRoleBID)
                                                                    ->where('request_mispunch_list.id', $item->id)
                                                                    ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                                    ->first();
                                                                $ForwardStaticName = $RuleManagement::RoleName($checkingCover->role_id)[0]->roles_name;
                                            
                                                                $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i> ' : '<i class="ion-close-circled"></i> ';
                                            
                                                                // $statusIcon = $SD->final_status == 1 ? '<i class="ion-checkmark-circled"></i>' : '<i class="ion-close-circled"></i>';
                                                                $statusColor = $SD->request_color;
                                                                $statusResponse = $SD->request_response;
                                                                if ($SD->final_status == 2 && $LatestStatusValue == 1) {
                                                                    // dd("kya chal raha");
                                                                    $DeclinedName = $RuleManagement::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                            
                                                                    echo '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                                            
                                                                    // echo '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                                                                    // dd($LatestStatusValue);
                                                                } elseif ($SD->final_status == 1) {
                                                                    echo '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $statusResponse . '  By ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '" data-bs-original-title="Declined ' . $ForwardName . '">' . $statusIcon . ' ' . $statusResponse . '</small>';
                                                                } else {
                                                                    // dd($SD->final_status);
                                                                    echo '<small class="' . $statusColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $statusResponse . '"><i class="ion-clock"></i> ' . nl2br($statusResponse) . '</small>';
                                                                }
                                                            } else {
                                                                $ForwardStaticName = $RuleManagement::RoleName($item->forward_by_role_id)[0]->roles_name;
                                            
                                                                if ($LatestStatusValue == 1) {
                                                                    // dd($CheckingRole);
                                                                    // dd($CheckCurrentStaticStatus->request_response);
                                                                    // dd($ForwardName);
                                                                    // echo '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $CheckCurrentStaticStatus->request_response . '</small>';
                                                                    echo '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '" data-bs-original-title="Forward To ' . $ForwardName . '">' . $LatestStatusName . '</small>';
                                                                }
                                                                if ($LatestStatusValue == 2) {
                                                                    // dd($CheckCurrentStaticStatus);
                                            
                                                                    // echo '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                                                    // echo '<small class="' . $CheckCurrentStaticStatus->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatus->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatus->request_response . '"><i class="ion-clock"></i>' . nl2br($CheckCurrentStaticStatus->request_response) . '</small>';
                                                                    echo '<small class="' . $LatestRequestColor . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Forward To ' . $ForwardStaticName . ' <b><br> Remark : ' . nl2br($LatestRemark) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> ' . nl2br($LatestStatusName) . '</small>';
                                                                }
                                            
                                                                $checkingLoad = DB::table('approval_management_cycle')
                                                                    ->where('business_id', Session::get('business_id'))
                                                                    ->where('approval_type_id', $approval_type_id_static)
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
                                                                    ->where('approval_type_id', 3)
                                                                    ->first();
                                                                $CheckingLoad = DB::table('approval_status_list')
                                                                    ->where('all_request_id', $item->id)
                                                                    ->where('approval_type_id', $approval_type_id_static)
                                                                    ->where('role_id', $ApprovedName->next_role_id ?? 0)
                                                                    ->first();
                                                                // ->where('role_id', $nextRoleId)
                                            
                                                                $gotopow = $RuleManagement::RoleName($CheckingLoad->role_id ?? 0)[0];
                                                                $ApprovedName2 = $gotopow->roles_name ?? 0;
                                            
                                                                if ($ApprovedName2 != 0) {
                                                                    // dd($CheckingLoad);
                                                                    if (isset($CheckingLoad)) {
                                                                        if ($CheckingLoad->status == 1) {
                                                                            // echo '<br><small>Approved To ' . $ApprovedName2 . '</small>';
                                                                        }
                                                                        if ($CheckingLoad->status == 2) {
                                                                            // echo '<br><small>Decliend To ' . $ApprovedName2 . '</small>';
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
                                                            ->where('approval_status_list.approval_type_id', '=', $approval_type_id_static)
                                                            ->select('approval_status_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                            ->first();
                                                        // dd($requestGet);
                                                        if ($requestGet ?? false) {
                                                            $CheckingRole = $RuleManagement::RoleName($requestGet->current_role_id ?? 0)[0];
                                                            $ForwardName = $CheckingRole->roles_name ?? 0;
                                                            $HoverStatus = $requestGet->status == 1 ? 'Approved By ' : 'Declined By ';
                                                            if ($requestGet->status == 1 && $LastDeclineStatusRemark) {
                                                                // dd($requestGet);
                                                                $DeclinedName = $RuleManagement::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                                                echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>' . $DeclinedName . '  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                                                            } elseif ($requestGet->status == 1) {
                                                                echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                                                            } else {
                                                                echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardName . '<b><br>  Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $requestGet->request_response . '"><i class="ion-clock"></i> Pending</small>';
                                                            }
                                                        } else {
                                                            // dd($CheckCurrentStaticStatusSecond);} else {
                                                            $CheckCurrentStaticStatusSecond = DB::table('request_mispunch_list')
                                                                ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
                                                                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                                                ->where('approval_status_list.approval_type_id', $approval_type_id_static)
                                                                ->where('request_mispunch_list.id', $item->id)
                                                                ->where('request_mispunch_list.business_id', $loginRoleBID)
                                                                ->orderBy('approval_status_list.created_at', 'desc')
                                                                ->select('request_mispunch_list.*', 'approval_status_list.id as approval_id', 'approval_status_list.applied_cycle_type', 'approval_status_list.business_id', 'approval_status_list.approval_type_id', 'approval_status_list.all_request_id', 'approval_status_list.role_id', 'approval_status_list.emp_id as approval_emp_id', 'approval_status_list.remarks', 'approval_status_list.status', 'approval_status_list.applied_cycle_type', 'approval_status_list.prev_role_id', 'approval_status_list.current_role_id', 'approval_status_list.next_role_id', 'approval_status_list.clicked', 'static_status_request.id as status_request_id', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                                ->first();
                                            
                                                            $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                                                            $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                                                            // dd($CheckCurrentStaticStatusSecond);
                                                            if ($CheckCurrentStaticStatusSecond) {
                                                                $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                                                                // dd($CheckCurrentStaticStatusSecond->status);
                                                                $HoverStatus = $CheckCurrentStaticStatusSecond->status == 1 ? 'Approved By ' : 'Declined By ';
                                                                $ForwardNameGET = $CheckingRole->roles_name ?? 0;
                                                                if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                                                    // dd("chc");
                                                                    echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                                    // dd($CheckCurrentStaticStatusSecond);
                                                                    // echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body"  data-bs-placement="top" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                                                    // dd($CheckCurrentStaticStatusSecond->final_status);
                                                                    $DeclinedName = $RuleManagement::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                                                    echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $DeclinedName . '<b><br> Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                            
                                                                    // echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br>'.$DeclinedName .' Remark :' . $LastDeclineStatusRemark->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                            
                                                                    // echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                                } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                                                    // dd('hi');
                                                                    // echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $LatestStatusName . '</small>';
                                                                    echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                            
                                                                    // echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                                } else {
                                                                    if ($CheckCurrentStaticStatusSecond->status == 1 && $LastDeclineStatusRemark) {
                                                                        $DeclinedName = $RuleManagement::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                            
                                                                        echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>' . $DeclinedName . ' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Approved"><i class="ion-close-circled"></i> Pending</small>';
                                                                    } elseif ($CheckCurrentStaticStatusSecond->status == 1) {
                                                                        // dd($CheckCurrentStaticStatusSecond);
                                            
                                                                        echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="' . $HoverStatus . $ForwardNameGET . '<b>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $LatestStatusName . '"><i class="ion-clock"></i> Pending</small>';
                                                                        // echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved By ' . $ForwardNameGET . ' <b><br>'. $DeclinedName .' Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';
                                            
                                                                        // echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-placement="top" data-bs-content="' . $HoverStatus . $ForwardNameGET . '" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-checkmark-circled"></i> Pending</small>';
                                                                        // echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                                    } elseif ($CheckCurrentStaticStatusSecond->status == 2) {
                                                                        // dd('hii');
                                                                        // dd($CheckCurrentStaticStatusSecond->request_response);
                                                                        // dd($ForwardNameGET);
                                                                        // echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i>  Pending</small>';
                                                                        echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Declined"><i class="ion-close-circled"></i> Pending</small>';
                                            
                                                                        // echo '<small class="badge badge-warning-light" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By  ' . $ForwardNameGET . ' <b><br> Remark :' . $CheckCurrentStaticStatusSecond->remarks . ' </br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title=""><i class="ion-close-circled"></i> Pending</small>';
                                                                    }
                                                                    // echo '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                                                                }
                                                            } else {
                                                                echo '<span class="badge badge-primary-light">Requested</span>';
                                            
                                                                // echo '<span class="badge badge-warning-light"><i class="ion-wand"></i>Requested</span>';
                                                            }
                                            
                                                            // echo '<span class="badge badge-warning-light"><i class="ion-wand"></i> Pending</span>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<span class="badge badge-primary-light">Requested</span>';
                                                }
                                            }
                                            
                                            if ($checkApprovalCycleType == 2) {
                                                $CheckCurrentStaticStatusSecond = DB::table('request_mispunch_list')
                                                    ->join('approval_status_list', 'approval_status_list.all_request_id', '=', 'request_mispunch_list.id')
                                                    ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                                    ->where('approval_status_list.approval_type_id', $approval_type_id_static)
                                                    ->where('request_mispunch_list.id', $item->id)
                                                    ->where('request_mispunch_list.business_id', $loginRoleBID)
                                                    ->orderBy('approval_status_list.created_at', 'desc')
                                                    ->first();
                                            
                                                if (!empty($CheckCurrentStaticStatusSecond)) {
                                                    $CheckingRole = $RuleManagement::RoleName($CheckCurrentStaticStatusSecond->role_id)[0];
                                                    // dd($CheckingRole);
                                                    $check = DB::table('business_details_list')
                                                        ->where('business_id', $CheckCurrentStaticStatusSecond->business_id)
                                                        ->where('call_back_id', $CheckCurrentStaticStatusSecond->role_id)
                                                        ->first();
                                                    $ForwardNameGET = $CheckingRole !== null && $CheckingRole !== 0 ? $CheckingRole->roles_name : ($check !== null ? 'Owner' : 0);
                                            
                                                    if ($CheckCurrentStaticStatusSecond->final_status == 1) {
                                                        echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Approved by ' . $ForwardNameGET . '" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-checkmark-circled"></i> ' . $CheckCurrentStaticStatusSecond->request_response . '</small>';
                                                    } elseif ($CheckCurrentStaticStatusSecond->final_status == 2 && $LatestStatusValue == 1) {
                                                        $DeclinedName = $RuleManagement::RoleName($LastDeclineStatusRemark->role_id)[0]->roles_name;
                                                        echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $DeclinedName . ' <b><br> Remark : ' . nl2br($LastDeclineStatusRemark->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '" data-bs-original-title="Declined ' . $ForwardNameGET . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                                                    } elseif ($CheckCurrentStaticStatusSecond->final_status == 2) {
                                                        echo '<small class="' . $CheckCurrentStaticStatusSecond->request_color . '" data-bs-trigger="hover" data-bs-container="body" data-bs-content="Declined By ' . $ForwardNameGET . ' <b><br> Remark : ' . nl2br($CheckCurrentStaticStatusSecond->remarks) . '</br>" data-bs-placement="top" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="' . $CheckCurrentStaticStatusSecond->request_response . '"><i class="ion-clock"></i> ' . nl2br($CheckCurrentStaticStatusSecond->request_response) . '</small>';
                                                    } else {
                                                        echo '<span class="badge badge-primary-light">Requested</span>';
                                                    }
                                                } else {
                                                    echo '<span class="badge badge-primary-light">Requested</span>';
                                                }
                                            }
                                            ?>

                                        </td> --}}

                                        <td>
                                            <?php
                                            $loadgoo = $item->id;
                                            ?>
                                            <?= $RuleManagement->RequestMispunchApprovalManage($checkApprovalCycleType, $item, $loadgoo, 3, $loginRoleID) ?>
                                        </td>
                                        <td>
                                            <?php
                                            $RoleRedCode = DB::table('request_mispunch_list')
                                                ->join('static_status_request', 'request_mispunch_list.final_status', '=', 'static_status_request.id')
                                                ->where('request_mispunch_list.business_id', $loginRoleBID)
                                                ->where('request_mispunch_list.id', $item->id)
                                                ->select('request_mispunch_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')
                                                ->first();
                                            ?>
                                            @if (in_array('Mis Punch.Update', $permissions))
                                                <?php  if(($RoleRedCode->final_status==1) ||  ($RoleRedCode->final_status==2)){ ?>
                                                <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                    id="edit_btn_modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->id ?>'
                                                    data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                                                    data-viewbtn='<?= $item->final_status ?>'
                                                    data-processcomplete='<?= $item->process_complete ?>'
                                                    data-forwardbystatus='<?= $item->forward_by_status ?>'
                                                    data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                    data-forwardroleid='<?= $item->forward_by_role_id ?>'
                                                    data-checkm_first_role_id='<?= $checkmfirstRoleId ?>'
                                                    data-bs-toggle="modal" data data-bs-target="#opendEditModelId">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View">
                                                    </i>
                                                </a>
                                                <?php }?>
                                            @endif


                                            @if (in_array('Mis Punch.Update', $permissions))
                                                <?php  if($RoleRedCode->final_status==0){ ?>
                                                <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);"
                                                    id="edit_btn_modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->id ?>'
                                                    data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                                                    data-processcomplete='<?= $item->process_complete ?>'
                                                    data-viewbtn='<?= $item->final_status ?>'
                                                    data-forwardbystatus='<?= $item->forward_by_status ?>'
                                                    data-currentstatusparticulartb='<?= $current_status_particular_tb->status ?? 0 ?>'
                                                    data-forwardroleid='<?= $item->forward_by_role_id ?>'
                                                    data-checkm_first_role_id='<?= $checkmfirstRoleId ?>'
                                                    data-bs-toggle="modal" data data-bs-target="#opendEditModelId">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View">
                                                    </i>
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
                    <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Mispunch Request</h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true"
                            style="color: white;">&times;</span></button>
                </div>

                {{-- <form action="{{ route('admin.leaveapprove') }}" method="post"> --}}
                <form action="{{ route('admin.mispunchapprove') }}" method="post">

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
                                <input type="text" name="emp_id" class="form-control" id="editEmpId" placeholder=""
                                    value="" readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Mobile No.</label>
                                <input type="text" class="form-control" id="editMobileNo" placeholder="Mobile No."
                                    value="" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group  col-md-3 col-sm-3">
                                <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title="fa fa-calendar"
                                        aria-label="fa fa-calendar"></i></label>
                                <input type="date" name="date" class="form-control" id="editDate"
                                    placeholder="Password" value="" readonly>
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
                                {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                                value="{{$item->in_time}}"> --}}

                                <textarea class="form-control" id="editReasonData" rows="2" value="" readonly></textarea>
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
                                    <summary style="color:red;">Note: Let's take a look at how the Fix HR approval process
                                        works. </summary>
                                    <p style="text-align: justify;text-justify: inter-word; ">1) In the case
                                        of approval, all statuses will be changed to
                                        approved,
                                        and the name of the final action performer will be displayed after the evaluation.
                                        <br>
                                        2) In the case of a decline, all statuses will be changed to declined, and the name
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
                            <p class="align-middle my-2"><span><b>Mark Mispunch Approvel</b></span></p>
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
            $('#filter-branch').on('change', function() {
                var branch_id = this.value;
                // console.log(branch_id);
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
                            '<option value="" name="department">Select Department Name</option>'
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
                            '<option value="">Select Designation Name</option>');
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
                            '<option value="">Select Designation Name</option>');
                        $.each(res.designation, function(key, value) {
                            $("#filter-designation").append('<option value="' + value
                                .desig_id + '">' + value.desig_name + '</option>');
                        });
                        $('#employee-dd').html(
                            '<option value="">Select Employee Name</option>')
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#filter-branch, #filter-department, #filter-designation').change(function() {
                var branchId = $('#filter-branch').val();
                var departmentId = $('#filter-department').val();
                var designationId = $('#filter-designation').val();

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
                        var tbody = $('.my_body');

                        tbody.empty();
                        console.log("data" + data);
                        var currentstatus = data['currentstatupartdb'];
                        // console.log('currentstatus ', currentstatus);
                        var status = data['status'];
                        let i = 1;
                        // $.each(data.get, function(index, employee) {
                        //     console.log(employee.out_time);
                        //     var newRow = '<tr>' +
                        //         '<td>' + i + '</td>' +
                        //         '<td>' + `<div class="d-flex">
                        //                     <span class="avatar avatar-md brround me-3 rounded-circle"
                        //                         style="background-image: url('/employee_profile/` + employee
                        //         .profile_photo + `')"></span>
                        //                     <div class="me-3 mt-0 mt-sm-1 d-block">
                        //                         <h6 class="mb-1 fs-14">` + employee.emp_name + ' ' + ((employee
                        //                 .emp_mname != null) ? employee.emp_mname :
                        //             '') + ' ' + employee.emp_lname + `</h6>
                        //                         <p class="text-muted mb-0 fs-12">
                        //                             ` + employee.desig_name + `</p>
                        //                     </div>
                        //                 </div>` + '</td>' +
                        //         '<td>' + employee.emp_id + '</td>' +
                        //         '<td>' + formatDate(employee.emp_miss_date) + '</td>' +
                        //         '<td>' + employee.time_type + '</td>' +
                        //         '<td>' + convertTo12HourFormat(employee
                        //             .emp_miss_in_time) + '</td>' +
                        //         '<td>' + convertTo12HourFormat(employee
                        //             .emp_miss_out_time) + '</td>' +
                        //         '<td>' + employee.emp_working_hour + '</td>' +
                        //         '<td>' +
                        //         status[employee.id] +
                        //         '</td>' +
                        //         // '<td>' + employee.id + '</td>' +
                        //         '<td>'
                        //     if (employee.final_status == 1 || employee.final_status ==
                        //         2) {
                        //         newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                        //                         onclick="openEditModel(this)" 
                        //                         data-id="${employee.id}" 
                        //                         data-processcomplete="${employee.process_complete}" 
                        //                         data-viewbtn="${employee.final_status}" 
                        //                         data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                        //                         data-forwardbystatus="${employee.forward_by_status}" 
                        //                         data-currentstatusparticulartb="${currentstatus[employee.id] ?? 0}" 
                        //                         data-forwardroleid=' ${employee.forward_by_role_id}'
                        //                         data-bs-toggle="modal" data-bs-target="#updateempmodal">
                        //                         <i class="feather feather-eye" data-bs-toggle="tooltip"
                        //                             data-original-title="View"></i>
                        //                     </a>`;
                        //     } else if (employee.final_status == 0) {
                        //         newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                        //                         onclick="openEditModel(this)" 
                        //                         data-id="${employee.id}" 
                        //                         data-processcomplete="${employee.process_complete}" 
                        //                         data-viewbtn="${employee.final_status}" 
                        //                         data-forwardbystatus="${employee.forward_by_status}" 
                        //                         data-currentstatusparticulartb="${currentstatus[employee.id] ?? 0}" 
                        //                         data-forwardroleid=' ${employee.forward_by_role_id}'
                        //                         data-ownerid='<?= $owner_call_back_id->call_back_id ?>'
                        //                         data-bs-toggle="modal" data-bs-target="#updateempmodal">
                        //                         <i class="feather feather-edit" data-bs-toggle="tooltip"
                        //                             data-original-title="View"></i>
                        //                     </a>`;
                        //     }

                        //     newRow += '</td></tr>';
                        //     i++;
                        //     tbody.append(newRow);
                        //     // });
                        // });
                        // $('[data-bs-toggle="popover"]').popover({
                        //     trigger: 'hover'
                        // });
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
        // document.getElementById('editFrom').addEventListener('change', calculateDateDifference);
        // document.getElementById('editTo').addEventListener('change', calculateDateDifference);

        // document.getElementById('editFromT').addEventListener('change', calculateDateDifferenceHalf);
        // document.getElementById('editToT').addEventListener('change', calculateDateDifferenceHalf);

        // function calculateDateDifference() {
        //     var fromDate = document.getElementById('editFrom').value;
        //     var toDate = document.getElementById('editTo').value;

        //     if (fromDate && toDate) {
        //         var from = new Date(fromDate);
        //         var to = new Date(toDate);

        //         if (from > to) {
        //             alert("Please select a 'from' date that is earlier than the 'to' date.");
        //             return;
        //         }

        //         var differenceInTime = to - from;
        //         var differenceInDays = Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1;
        //         $('#editDays').val(differenceInDays);
        //         console.log(differenceInDays);
        //         // Display the results
        //         // document.getElementById('result').textContent = 'Difference: ' + differenceInDays + ' days';
        //     }
        // }

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
            console.log("context ", context);
            var loginRoleID = '<?= $loginRoleID ?>';
            var checkApprovalCycleType = '<?= $checkApprovalCycleType ?>';
            $("#opendEditModelId").modal("show");
            var id = $(context).data('id');
            var status = $(context).data('status');
            var leavetype = $(context).data('leavetype');
            var forwardRoleid = $(context).data('forwardroleid');
            console.log(forwardRoleid);
            var current_status_particulartb = $(context).data('currentstatusparticulartb');
            var forward_by_status = $(context).data('forwardbystatus');
            var process_complete = $(context).data('processcomplete');
            var checkmfirstRoleId = $(context).data('checkmfirstroleid');
            var ownerId = $(context).data('ownerid');
            var viewBtn = $(context).data('viewbtn');

            // var checkmfirstRoleId = $(context).data('checkm_first_role_id');
            console.log("checkmfirstRoleId ", checkmfirstRoleId);
            $('#editLeaveId').val(id);
            console.log("id : " + id);
            console.log("Cycle Type : " + parseInt(checkApprovalCycleType));
            console.log("current status : " + parseInt(current_status_particulartb));
            console.log("forwared status: " + parseInt(forward_by_status));
            if ((parseInt(viewBtn) == 1) || (parseInt(viewBtn) == 2)) {
                $('#editModalFooter').hide();
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
                console.log("Cycle 2 aagayahy");
                if (parseInt(current_status_particulartb) != 0) {
                    $('#editModalFooter').hide();
                }
                console.log(loginRoleID);
                console.log(ownerId);
                if ((parseInt(loginRoleID)) == (parseInt(ownerId))) {
                    $('#editModalFooter').hide();
                } else if (parseInt(process_complete) != 0) {
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
                        console.log("result", result);

                        $('#editBranch').val(result.get.branch_name);
                        $('#editDepratment').val(result.get.depart_name);
                        $('#editDesignation').val(result.get.desig_name);
                        $('#editEmpName').val(result.get.emp_name + ' ' + (result.get.emp_mname != null ? result
                            .get.emp_mname : '') + ' ' + result.get.emp_lname);
                        $('#editEmpId').val(result.get.emp_id);
                        $('#editMobileNo').val(result.get.emp_mobile_no);
                        $('#editDate').val(result.get.emp_miss_date);
                        $('#editMobileNo').val(result.get.emp_mobile_number);
                        $('#editOutTime').val(result.get.emp_miss_out_time);
                        $('#editInTime').val(result.get.emp_miss_in_time);
                        $('#editTimeType').val(result.get.time_type);
                        // console.log(result.get.reason);
                        $('#editReasonData').val(result.get.reason);
                        $('#RemarkTextarea').val(result.get.remark);
                    } else {

                    }
                },
            });
        }

        // function remark() {
        //     $('#remarks').removeClass('d-none');
        //     $('#CancelBtn_MGA').addClass('d-none');
        //     $('#ApproveBtn_MGA').addClass('d-none');
        //     $('#BackBtn_MGA').removeClass('d-none');
        //     $('#SubmitBtn_MGA').removeClass('d-none');
        //     $('#RemarkTextarea').attr('required', true);
        // }

        // function back() {
        //     $('#remarks').addClass('d-none');
        //     $('#CancelBtn_MGA').removeClass('d-none');
        //     $('#ApproveBtn_MGA').removeClass('d-none');
        //     $('#BackBtn_MGA').addClass('d-none');
        //     $('#SubmitBtn_MGA').addClass('d-none');
        //     $('#RemarkTextarea').attr('required', false);
        // }
        // $(document).ready(function() {

        //     // Add event listeners to the dropdowns
        //     $('#country-dd, #state-dd, #desig-dd, #from_date_dd, #to_date_dd').change(function() {
        //         // Get selected values
        //         var branchId = $('#country-dd').val();
        //         console.log("branchId" + branchId);
        //         var departmentId = $('#state-dd').val();
        //         // console.log(departmentId);
        //         var designationId = $('#desig-dd').val();
        //         // console.log(designationId);
        //         var fromDate = $('#from_date_dd').val();
        //         // console.log(fromDate);
        //         var toDate = $('#to_date_dd').val();
        //         // console.log("toidate" + toDate);

        //         // Make an AJAX request to filter employees
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ url('admin/requests/mispunchemployeefilter') }}",

        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 branch_id: branchId,
        //                 department_id: departmentId,
        //                 designation_id: designationId,
        //                 from_date: fromDate,
        //                 to_date: toDate
        //             },
        //             success: function(data) {
        //                 console.log("data" + data);
        //                 // Update the table body with the filtered data
        //                 var tbody = $('.my_body');
        //                 tbody.empty();`

    //                 // $.each(data, function(index, employee) {
    //                 //     console.log(employee);
    //                 //     i = 1;
    //                 //     employee.forEach(el => {
    //                 //         console.log(el.emp_id);
    //                 //         var newRow = '<tr>' +
    //                 //             '<td>' + i++ + '</td>' +
    //                 //             '<td>' + `<div class="d-flex">
        //             //                         <span class="avatar avatar-md brround me-3 rounded-circle"
        //             //                             style="background-image: url('/employee_profile/` + el
    //                 //             .profile_photo + `')"></span>
        //             //                         <div class="me-3 mt-0 mt-sm-1 d-block">
        //             //                             <h6 class="mb-1 fs-14">` + el.emp_name + `&nbsp;` + (el
    //                 //                 .emp_mname != null ? 'el.emp_mname' : ''
    //                 //             ) +
    //                 //             `&nbsp;` + el.emp_lname + `</h6>
        //             //                             <p class="text-muted mb-0 fs-12">
        //             //                                 ` + el.desig_name + `</p>
        //             //                         </div>
        //             //                     </div>` + '</td>' +
    //                 //             '<td>' + el.emp_id + '</td>' +
    //                 //             '<td>' + el.leave_type + '</td>' +
    //                 //             '<td>' + el.from_date + '</td>' +
    //                 //             '<td>' + el.to_date + '</td>' +
    //                 //             '<td>' + el.days + '</td>' +

    //                 //             '<td>' + (el.status == 0 ?
    //                 //                 `<span class="badge badge-primary-light">Requested</span>` :
    //                 //                 (el.status == 1 ?
    //                 //                     '<span class="badge badge-success-light">Approved</span>' :
    //                 //                     (el.status == 2 ?
    //                 //                         `<span class="badge badge-warning-light">Declined</span>` :
    //                 //                         ' <span class="badge badge-primary-light">Requested</span>'
    //                 //                     ))) + '</td>' +

    //                 //             '<td>'
    //                 //         newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
        //             //     onclick="openEditModel(this)" data-id="${el.id}"  data-status="${el.status}"
        //             //     data-bs-toggle="modal" data-bs-target="#opendEditModelId">
        //             //     <i class="feather feather-edit" data-bs-toggle="tooltip"
        //             //         data-original-title="View"></i>
        //             //    </a>`;

    //                 //         //         newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
        //             //     //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.id}" 
        //             //     //     data-bs-target="#deletemodal">
        //             //     //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
        //             //     //         data-original-title="View"></i>
        //             //     // </a>`;
        //                 //         newRow += '</td></tr>';
        //                 //         // i++;
        //                 //         tbody.append(newRow);
        //                 //     });

        //                 // });
        //             }
        //         });
        //     });
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

        // });
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
