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
    <div class="d-flex my-2">
        <div class="me-3">
            <label class="form-label">Note:</label>
        </div>
        <div>
            <span class="present-status-badge me-2">P ---&gt; Present</span>
            <span class="absent-status-badge me-2">A
                ---&gt; Absent</span>

            <span class="halfday-status-badge me-2">HD---&gt;
                Half Day</span>
            <span class="weekoff-status-badge me-2">WO
                ---&gt;
                Week Off</span>
            <span class="holiday-status-badge me-2">HO ---&gt;
                Holiday</span>
            <span class="leave-status-badge me-2">L
                ---&gt;
                Leave</span>
            <span class="mispunch-status-badge me-2">MSP ---&gt;
                Mis-punch</span>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table  table-vcenter text-nowrap border-bottom ">
            <thead>
                <tr role="row">
                    <th class="border-bottom-0 reorder sorting sorting_asc" tabindex="0" aria-controls="hr-attendance"
                        rowspan="1" colspan="1" aria-sort="ascending"
                        aria-label="Employee Name: activate to sort column descending" style="width: 165.031px;">
                        Employee Name</th>
                    {{-- <th class="border-bottom-0 reorder sorting sorting_asc" tabindex="0" aria-controls="hr-attendance"
                        rowspan="1" colspan="1" aria-sort="ascending"
                        aria-label="Employee Name: activate to sort column descending" style="width: 165.031px;">
                        Employee ID</th> --}}
                    <?php $day = 0; ?>
                    @while (++$day <= $totalDays)
                        <th class="border-bottom-0 w-5 sorting_disabled" rowspan="1" colspan="1"
                            aria-label="1" style="width: 14.5px;">
                            {{ $day }}</th>
                    @endwhile
                </tr>
            </thead>
            <tbody class="">
                @foreach ($Emp as $emp)
                    <?php $Day = 0; ?>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                    style="background-image: url('/storage/livewire_employee_profile/{{ $emp->profile_photo }}')"></span>
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-1 fs-14">
                                        <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                            {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}({{$emp->emp_id}})
                                        </a>
                                    </h6>
                                    <p class="text-muted mb-0 fs-12">
                                        <?= $root->DesingationIdToName($emp->designation_id) ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        {{-- <td>{{$emp->emp_id}}</td> --}}
                        @while (++$Day <= $totalDays)
                            <td>
                                @php
                                    $status = $root->getAttendanceSummaryDetaisl(['emp_id' => $emp->emp_id, 'punch_date' => date($monthFilter . '-' . $Day)])[0];
                                    if ($today < $Day) {
                                        $status = 5;
                                    }
                                    $leave = $root->getEmpLeaveDetails($emp->emp_id, date($monthFilter . '-' . $Day));
                                @endphp
                                <div class="hr-listd">
                                    @if ($status == 1 || $status == 3 || $status == 9 || $status == 12)
                                        <h6 class="mb-1 fs-14">
                                            <span class="present-status">P</span>
                                        </h6>
                                    @elseif ($status == 2)
                                        <h6 class="mb-1 fs-14">
                                            <span class="absent-status">A</span>
                                        </h6>
                                    @elseif ($status == 6)
                                        <h6 class="mb-1 fs-14">
                                            <span class="holiday-status">HO</span>
                                        </h6>
                                    @elseif ($status == 4)
                                        <h6 class="mb-1 fs-14">
                                            <span class="mispunch-status">MSP</span>
                                        </h6>
                                    @elseif ($status == 7)
                                        <h6 class="mb-1 fs-14">
                                            <span class="weekoff-status">WO</span>
                                        </h6>
                                    @elseif ($status == 10 || $status == 11)
                                        <h6 class="mb-1 fs-14">
                                            <span class="leave-status">{{ $leave->sort_name }}</span>
                                        </h6>
                                    @elseif ($status == 8)
                                        <h6 class="mb-1 fs-14">
                                            <span class="halfday-status">HD</span>
                                        </h6>
                                    @else
                                        <span class="">-</span>
                                    @endif
                                </div>
                            </td>
                        @endwhile
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
