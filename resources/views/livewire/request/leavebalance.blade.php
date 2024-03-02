<div>
    <div class="p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/leave/balance') }}">Requests</a></li>
            <li class="active"><span><b>Leave Balance</b></span></li>
        </ol>
    </div>
    <!-- ROW -->
    <div>
        <div>
            <div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Leave Balance Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <p class="form-label">Department</p>
                                            <div class="form-group mb-3" x-data="{ isOpen: false }"
                                                x-on:click.away="isOpen = false">
                                                <div class="input-group">
                                                    <select wire:model="departmentFilter" :wire:change="getDesignation"
                                                        class="form-control" x-on:focus="isOpen = true"
                                                        x-on:blur="isOpen = false">
                                                        <option value="">All Department </option>
                                                        @foreach ($Department as $item)
                                                            <option value="{{ $item->depart_id }}">
                                                                {{ $item->depart_name }}</option>
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
                                            <p class="form-label">Designation</p>
                                            <div class="form-group mb-3" x-data="{ isOpen: false }"
                                                x-on:click.away="isOpen = false">
                                                <div class="input-group">
                                                    <select wire:model="designationFilter" wire:change="getDesignation"
                                                        id="designation_id" class="form-control"
                                                        x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                                        <option value="">All Designation</option>
                                                        @foreach ($Designation as $item)
                                                            <option value="{{ $item->desig_id }}">
                                                                {{ $item->desig_name }}</option>
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
                                            <p class="form-label">Search</p>
                                            <div class="form-group mb-3">
                                                <input type="text" wire:model="searchFilter" placeholder="Search"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table  table-vcenter text-nowrap table-bordered border-bottom table-striped">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="w-5 border-bottom-0 ">Emp ID</th>
                                                <th rowspan="2" class="border-bottom-0 ">Emp Name</th>
                                                <th colspan="9" class="text-center">Leaves</th>
                                            </tr>
                                            <tr>
                                                @foreach ($StaticLeavesCategory as $item)
                                                    <th class="w-5 text-center border-bottom-0 ">
                                                        {{ $item->name }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Emp as $key => $item)
                                                <tr>
                                                    <td>{{ $item['emp_id'] }}</td>

                                                    <td>

                                                        <div class="d-flex">
                                                            <span class="avatar avatar-md brround me-3"
                                                                style="background-image: url('/storage/livewire_employee_profile/{{ $item['profile_photo'] }}')"></span>
                                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                                <h6 class="mb-1 fs-14">
                                                                    <a
                                                                        href="{{ route('employeeProfile', [$item['emp_id']]) }}">
                                                                        {{ $item['full_name'] }}
                                                                    </a>
                                                                </h6>
                                                                <p class="text-muted mb-0 fs-12">
                                                                    {{  $item['desig_name'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @foreach ($StaticLeavesCategory as $staticLeveCheck)
                                                        @php
                                                            $matched = false;
                                                        @endphp
                                                        @foreach ($item['leave_status_list'] as $keyItem => $resultItem)
                                                            @if ((int) $resultItem['policy_type_id'] == $staticLeveCheck->id)
                                                                <td>{{ $resultItem['leave_remaining'] }}</td>
                                                                @php
                                                                    $matched = true;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if (!$matched)
                                                            <td>-</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label for="perPage">Per Page:</label>
                                        <div class="form-group mb-3" x-data="{ isOpen: false }"
                                            x-on:click.away="isOpen = false">
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
                                        {!! $Emp->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ROW -->

            </div>
        </div><!-- end app-content-->
    </div>
</div>
