<div>
    @php
        $centralUnit = new App\Helpers\Central_unit();
        $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement(); // Create an instance of the Central_unit class
    @endphp
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
                                <h3 class="mb-0 mt-1 text-primary" id="paidLeaveId"> {{ $Count[2] }}</h3>
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
                                <h3 class="mb-0 mt-1 text-secondary" id="unpaidLeaveId"> {{ $Count[3] }}</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-secondary-transparent my-auto  float-end"><i class="las la-female"></i>
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
                <div class="card-body pt-2  px-2">
                    <div class="row m-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <div class="form-group" x-data="{ isOpen: false }"
                                    x-on:click.away="isOpen = false">
                                    <div class="input-group">
                                        <select wire:model="branchFilter" wire:change="getDepartment"
                                            class="form-control" x-on:focus="isOpen = true"
                                            x-on:blur="isOpen = false">
                                            <option value="">All Branch</option>
                                            @foreach ($Branch as $data)
                                                <option value="{{ $data->branch_id }}">
                                                    {{ $data->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i x-show="isOpen" class="fa fa-caret-up"></i>
                                                <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3" x-data="{ isOpen: false }"
                                    x-on:click.away="isOpen = false">
                                    <div class="input-group">
                                        <select wire:model="departmentFilter" name="department_id"
                                            class="form-control" x-on:focus="isOpen = true"
                                            x-on:blur="isOpen = false">
                                            <option value="">All Department </option>
                                            @foreach ($Department as $data)
                                                <option value="{{ $data->depart_id }}">
                                                    {{ $data->depart_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i x-show="isOpen" class="fa fa-caret-up"></i>
                                                <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3" x-data="{ isOpen: false }"
                                    x-on:click.away="isOpen = false">
                                    <div class="input-group">
                                        <select wire:model="designationFilter" wire:change="getDesignation"
                                            id="designation_id" class="form-control"
                                            x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                            <option value="">All Designation</option>
                                            @foreach ($Designation as $data)
                                                <option value="{{ $data->desig_id }}">
                                                    {{ $data->desig_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i x-show="isOpen" class="fa fa-caret-up"></i>
                                                <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">From</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" class="form-control " wire:model="FromFilter"
                                        placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">To</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" class="form-control " wire:model="ToFilter"
                                        placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom">
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
                                @foreach ($DATALEAVE as $key => $item)
                                    <tr>
                                        <td hidden>{{ $key++ }}</td>
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
                                                        <?= $centralUnit->DesingationIdToName($item->designation_id) ?>
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
                                            <?=  $RuleManagement->RequestLeaveApprovalManage($checkApprovalCycleType, $item, $loadgoo, 2, $loginRoleID) ?>
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
                                                <?php if (($RoleRedCode->final_status == 1) ||  ($RoleRedCode->final_status == 2)) { ?>
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
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                                <?php } ?>


                                                <?php if ($RoleRedCode->final_status == 0) { ?>
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
                                                <?php } ?>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="perPage">Per Page:</label>

                            <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                <div class="input-group">
                                    <select wire:model.debounce.350ms="perPage" class="form-control"
                                        x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i x-show="isOpen" class="fa fa-caret-up"></i>
                                            <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>

                            {!! $DATALEAVE->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
