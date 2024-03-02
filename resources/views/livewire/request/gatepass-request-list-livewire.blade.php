<div>
    @php
        $centralUnit = new App\Helpers\Central_unit();
        $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement(); // Create an instance of the Central_unit class
    @endphp
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
                        <th class="border-bottom-0">Date</th>
                        <th class="border-bottom-0">Out Time</th>
                        <th class="border-bottom-0">In Time</th>
                        <th class="border-bottom-0">Status</th>
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
                                            <?= $centralUnit->DesingationIdToName($item->designation_id) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->emp_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
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

                                $RoleRedCode = DB::table('request_gatepass_list')->join('static_status_request', 'request_gatepass_list.final_status', '=', 'static_status_request.id')->where('request_gatepass_list.business_id', $loginRoleBID)->where('request_gatepass_list.id', $loadgoo)->select('request_gatepass_list.*', 'static_status_request.request_response', 'static_status_request.request_color', 'static_status_request.btn_color', 'static_status_request.tooltip_color')->first();
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

                {!! $DATA->links() !!}
            </div>
        </div>
    </div>
</div>
