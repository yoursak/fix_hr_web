@php
    $root = new App\Helpers\Central_unit();
@endphp
<div class="card-body  p-2 px-2">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <p class="form-label">Branch</p>
                <div class="form-group" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model="branchFilter" wire:change="getDepartment" class="form-control"
                            x-on:focus="isOpen = true" x-on:blur="isOpen = false">
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
                <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model="departmentFilter" name="department_id" class="form-control"
                            x-on:focus="isOpen = true" x-on:blur="isOpen = false">
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
                <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model="designationFilter" wire:change="getDesignation" id="designation_id"
                            class="form-control" x-on:focus="isOpen = true" x-on:blur="isOpen = false">
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
                <label class="form-label">Month</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="feather feather-calendar"></i>
                        </div>
                    </div>
                    <input type="month" class="form-control" value="{{ now()->format('Y-m') }}" wire:ignore
                        wire:change="MonthFilter($event.target.value)">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <p class="form-label">Search</p>
                <div class="form-group mb-3">
                    <input type="text" wire:model="searchFilter" placeholder="Search" class="form-control" />
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table  table-vcenter text-nowrap border-bottom ">
            <thead>
                <tr role="row">

                    <th class="border-bottom-0">Employee</th>
                    <th class="text-center border-bottom-0 ">Emp ID</th>
                    <th class="text-center border-bottom-0 ">Present</th>
                    <th class="text-center border-bottom-0 ">Absent</th>
                    <th class="text-center border-bottom-0 ">Half Days</th>
                    <th class="text-center border-bottom-0 ">Leave</th>
                    <th class="text-center border-bottom-0 ">WeekOff</th>
                    <th class="text-center border-bottom-0 ">Holiday</th>
                    <th class="text-center border-bottom-0 ">Mis-Punch</th>
                    <th class="text-center border-bottom-0 ">Overtime</th>
                    <th class="text-center border-bottom-0 ">Late</th>
                    <th class="text-center border-bottom-0 ">Early Exit</th>
                    <th class="text-center border-bottom-0 ">Total Attendance</th>
                    <th class="text-center border-bottom-0">Action</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($Emp as $emp)
                    @php
                        $monthlyCount = $root->getMonthlyCountFromDB($emp->emp_id, date('Y', strtotime($monthFilter . '-' . $totalDays)), date('m', strtotime($monthFilter . '-' . $totalDays)), Session::get('business_id'), $emp->branch_id);
                        $root->MyCountForMonth($emp->emp_id, date('Y-m-d', strtotime($monthFilter . '-' . $totalDays)), Session::get('business_id'), $emp->branch_id);
                    @endphp
                    <tr>
                        <td class="reorder sorting_01">
                            <div class="d-flex">
                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                    style="background-image: url('/storage/livewire_employee_profile/{{ $emp->profile_photo }}')"></span>
                                <div class="me-3 mt-0 mt-sm-2 d-block">
                                    <h6 class="mb-1 fs-14">
                                        <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                            {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-0 fs-12">
                                        <?= $root->DesingationIdToName($emp->designation_id) ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{ $emp->emp_id }}</td>

                        <td class="text-center">{{ $monthlyCount['present'] }}</td>
                        <td class="text-center">{{ $monthlyCount['absent'] }}</td>
                        <td class="text-center">{{ $monthlyCount['halfday'] }}</td>
                        <td class="text-center">{{ $monthlyCount['leave'] }}</td>
                        <td class="text-center">{{ $monthlyCount['weekoff'] }}</td>
                        <td class="text-center">{{ $monthlyCount['holiday'] }}</td>
                        <td class="text-center">{{ $monthlyCount['mispunch'] }}</td>
                        <td class="text-center">{{ $monthlyCount['overtime'] }}</td>
                        <td class="text-center">{{ $monthlyCount['late'] }}</td>
                        <td class="text-center">{{ $monthlyCount['early'] }}</td>
                        <td class="text-center">{{ $monthlyCount['total'] }}</td>
                        <td class="text-center">
                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn" data-bs-toggle="tooltip"
                                data-original-title="View">

                                <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                    <i class="feather feather-eye"></i>
                                </a>

                            </div>
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
                    <select wire:model.debounce.350ms="perPage" class="form-control" x-on:focus="isOpen = true"
                        x-on:blur="isOpen = false">
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
