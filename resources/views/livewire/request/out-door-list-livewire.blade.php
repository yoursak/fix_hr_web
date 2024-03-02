<div>
    <div class="card-body pt-2  px-2">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <p class="form-label">Branch</p>
                    <div class="form-group" >
                        <div class="input-group">
                            <select wire:model="branchFilter" wire:change="getDepartment" class="form-control" >
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
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <select class="form-control" wire:model="departmentFilter">
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
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <select wire:model="designationFilter" wire:change="getDesignation"  class="form-control">
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
                        <input type="date" class="form-control " wire:model="fromFilter"
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
                        <input type="date" class="form-control " wire:model="toFilter"
                            placeholder="DD-MM-YYYY">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom ">
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
                            <a class="btn btn-primary btn-icon btn-sm " href="javascript:void(0);" id="view_btn_modal" onclick="openEditModel(this)" data-id='<?= $item->id ?>' data-branchname='<?= $item->branch_name ?>' data-departname='<?= $item->depart_name ?>' data-designame='<?= $item->desig_name ?>' data-empname='<?= $item->emp_name ?>' data-empmname='<?= $item->emp_mname ?>' data-empid='<?= $item->emp_id ?>' data-emplname='<?= $item->emp_lname ?>' data-outtime='<?= $item->out_time ?>' data-applydate='<?= $item->apply_date ?>' data-reason='<?= $item->reason ?>' data-empmobilenumber='<?= $item->emp_mobile_number ?>'> <i class="feather feather-eye" data-bs-toggle="tooltip" data-original-title="View"></i>
                            </a>
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
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>
