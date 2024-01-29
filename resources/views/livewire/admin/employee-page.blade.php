@if (in_array('Employee.All', $permissions) || in_array('Employee.View', $permissions))
    <div> @php
        $centralUnit = new App\Helpers\Central_unit();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $ITEM = $LOADED->SectionEmployeeCounters();
        $Designation = $centralUnit->DesignationList();
    @endphp


        <div class=" p-0 pb-4">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Employee</b></span></li>
            </ol>
        </div>

        <!-- START ROW -->
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-start"> <span class="font-weight-semibold">Total Employees</span>
                                    <h3 class="mb-0 mt-1 text-success">{{ $ITEM[0] }}</h3>
                                </div>
                            </div>
                            <div class="col-5 ">
                                <div class="icon1 bg-success-transparent my-auto pt-3 float-end"> <i
                                        class="las la-users"></i>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Male Employees</span>
                                    <h3 class="mb-0 mt-1 text-primary "> {{ $ITEM[1] }}</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-primary-transparent my-auto pt-3 float-end"> <i
                                        class="las la-male"></i>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Female
                                        Employees</span>
                                    <h3 class="mb-0 mt-1 text-secondary"> {{ $ITEM[2] }}</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-secondary-transparent my-auto float-end pt-3"> <i
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">New Employees</span>
                                    <h3 class="mb-0 mt-1 text-danger"> {{ $ITEM[4] }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-danger-transparent my-auto pt-3 float-end"> <i
                                        class="las la-user-friends"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->

        {{-- call by live-wire --}}

        {{-- <div>
        <div class="row">

            <input wire:model="priceFilter" type="text" model:keyup="filterProducts" placeholder="Filter by Price">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card p-4">
                    Include the Node Livewire component inside Livewire directive
                    <livewire:power-grid.node />

                </div>
            </div>
        </div>
    </div> --}}
        <style>
            /* .container {
            height: 400px;
            position: relative;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            }

        .pagination {
            text-align: left;
        } */
        </style>

        @include('livewire.student-model')

        <!-- ROW -->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title">Employee List

                        </h4>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <div class="form-group pt-2" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                            {{-- <select wire:model.debounce.350ms="sortBy" id="" class="form-control ">
                            <option value="aes">Asc</option>
                            <option value="desc">Desc</option>
                        </select> --}}
                            {{-- <div> --}}
                            <div class="input-group">
                                <select wire:model.debounce.350ms="sortBy" class="form-control"
                                    x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                    <option value="aes">Asc</option>
                                    <option value="desc">Desc</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i x-show="isOpen" class="fa fa-caret-up"></i>
                                        <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="page-rightheader ms-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="btn-list d-flex">
                                    @if (in_array('Employee.Create', $permissions))
                                        <a class="modal-effect btn btn-primary border-0 my-auto"
                                            data-effect="effect-scale" data-bs-toggle="modal"
                                            href="#empTypeComponent">Add New
                                            Employee</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="row">


                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>

                                    <div class="form-group" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <select wire:model="branchFilter" class="form-control"
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

                                    {{-- <div class="form-group mb-3">
                                    <select wire:model="departmentFilter" name="department_id" class="form-control ">
                                        <option value="">All Department </option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Designation</p>
                                    <div class="form-group mb-3" x-data="{ isOpen: false }"
                                        x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <select wire:model="designationFilter" name="designation_id"
                                                class="form-control" x-on:focus="isOpen = true"
                                                x-on:blur="isOpen = false">
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
                                    {{-- <div class="form-group mb-3">
                                    <select wire:model="designationFilter" name="designation_id"
                                        class="form-control ">
                                        <option value="">All Designation</option>
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Employee Status</p>
                                    <div class="form-group mb-3" x-data="{ isOpen: false }"
                                        x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <select wire:model="activeFilter" class="form-control"
                                                x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                                <option value="">All </option>
                                                @foreach ($employeeActive as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->name }}
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
                                    {{-- <div class="form-group mb-3">
                                    <select wire:model="activeFilter" name="" class="form-control ">
                                        <option value="">All </option>
                                        @foreach ($employeeActive as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div> --}}
                                </div>
                            </div>
                            <div class="col-md-2 nav-pills">
                                <div class="form-group">
                                    <p class="form-label">Download</p>

                                    <div class="nav-item dropdown ">
                                        <a class="nav-link dropdown-toggle px-4 py-2" id="dropdownMenuLink"
                                            data-bs-toggle="dropdown" href="javascript:void(0);" role="button"
                                            aria-haspopup="true" aria-expanded="false">
                                            Export
                                        </a>
                                        {{-- {{ route('employee.page.print', ['id' => 4]) }} --}}
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                                            <a class="dropdown-item" wire:click="download(1)">CSV</a>
                                            <a class="dropdown-item" wire:click="download(2)">Excel</a>
                                            <a class="dropdown-item" wire:click="download(3)">PDF</a>
                                            {{-- <a href="#" class="dropdown-item" wire:click="download(4)">Print</a> --}}
                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <p class="form-label">Search</p>
                                    <div class="form-group mb-3">
                                        <input type="text" wire:model="searchFilter" placeholder="Search"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- @if ($errors->any())
                        <h5 style="color:red">Following errors exists in your excel file</h5>
                        <ol>
                            @foreach ($errors->all() as $error)
                                <li style="color:red">{{ $error }}</li>
                            @endforeach
                        </ol>
                    @endif   --}}
                        <div class="table-responsive">
                            @php
                                $count = 1;
                            @endphp
                            <table id="" class="table  display table-vcenter text-nowrap  border-bottom ">
                                <thead>
                                    <tr>
                                        {{-- <th class="border-bottom-0">S. No.</th> --}}
                                        <th class="border-bottom-0">Employee Name</th>
                                        <th class="border-bottom-0">Employee ID</th>
                                        <th class="border-bottom-0">Employee Type</th>
                                        <th class="border-bottom-0">Branch</th>
                                        <th class="border-bottom-0">Department</th>
                                        <th class="border-bottom-0">Joining Date</th>
                                        <th class="border-bottom-0">Phone Number</th>
                                        <th class="border-bottom-0">Attendance Method</th>
                                        <th class="border-bottom-0">Shift Type</th>
                                        <th class="border-bottom-0">Active</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="my_body">
                                    @foreach ($DATA as $item)
                                        @php
                                            $branch = $centralUnit->Branchget($item->branch_id);
                                            $depart = $centralUnit->Departmentget($item->department_id);
                                            $attendanceMethod = $LOADED->StaticModelActive($item->emp_attendance_method, 0, $item->assign_shift_type);
                                        @endphp
                                        <tr>
                                            {{-- <td>{{ $count++ }}</td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3 rounded-circle"
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
                                            <td>{{ $item->emp_id }}
                                            </td>
                                            <td>{{ $item->employee_type }}</td>
                                            <td><span class="mb-1 fs-14">{{ $branch->branch_name ?? ' ' }}</span></td>
                                            <td><span class="mb-1 fs-14">{{ $depart->depart_name ?? '' }}</span></td>
                                            <td><span
                                                    class="mb-1 fs-14">{{ \Carbon\Carbon::parse($item->emp_date_of_joining)->format('d-m-Y') }}</span>
                                            </td>
                                            <td><span class="mb-1 fs-14">{{ $item->emp_mobile_number }}</span></td>
                                            <td>{{ $item->attendance_method ?? '' }}</td>
                                            <td>{{ $item->assign_shift ?? '' }}</td>
                                            <td>
                                                @php
                                                    $status = $item->active_emp
                                                        ? '<svg xmlns="http://www.w3.org/2000/svg" style="width:1.2em;height:1.2em;"
                                            class="d-inline-block text-success" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>'
                                                        : '<svg xmlns="http://www.w3.org/2000/svg" style="width:1.2em;height:1.2em;"
                                            class="d-inline-block text-danger" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>';
                                                @endphp
                                                {!! $status !!}
                                            </td>
                                            <td>
                                                <?php $sendData = [$item->id, $item->emp_id, $item->business_id];
                                                ?>
                                                @if (in_array('Employee.Update', $permissions))
                                                    <a type="button" data-bs-toggle="modal"
                                                        data-bs-target="#updateStudentModal"
                                                        wire:click="editStudent('<?php echo htmlentities(json_encode($sendData)); ?>')"
                                                        class="btn btn-primary btn-icon btn-sm">
                                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                            data-original-title="View"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
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
                                    {{-- <select wire:model.debounce.350ms="perPage" id=""
                                    class="form-control   custom-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select> --}}

                                </div>

                                <div>
                                    {!! $DATA->links() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- @if (in_array('Employee.Update', $permissions))
    @endif --}}


        {{-- delete confirmation --}}
        <div class="modal fade" id="deletemodal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <form action="{{ route('delete.employee') }}" method="POST">
                        @csrf
                        {{-- <input type="text" id="weekly_policy_id" name="weekly_policy_id"> --}}
                        <div class="modal-body">
                            <h3>Are you sure want to Update It ?</h3>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" data-bs-dismiss="modal">Decline</a>

                            <button class="btn btn-primary" type="submit">Approve</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- delete confirmation --}}

        {{-- <div class="form-group">
        <label class="form-label">Country</label>
        <select name="country" class="form-control custom-select select2" data-placeholder="Select Country">

            <option label="Select Country"></option>
            <option value="br">Brazil</option>
            <option value="cz">Czech Republic</option>
            <option value="de">Germany</option>
            <option value="pl">Poland</option>
        </select>
    </div> --}}

        <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#empCountryId').change(function() {
                    var countryID = $('#empCountryId').val();
                    console.log(countryID);
                    $.ajax({
                        type: 'POST',
                        data: {
                            country: countryID,
                            _token: '{{ csrf_token() }}'
                        }, // Add a comma here
                        url: "{{ url('/admin/employee/country-state') }}",
                        dataType: 'json',
                        success: function(result) {

                            $('#empStateId').empty();
                            result.forEach(element => {

                                $('#empStateId').append('<option value="' + element.id +
                                    '">' + element.name + '</option>');
                            });

                        },
                    });
                });

                $('#empStateId').change(function() {
                    var stateID = $('#empStateId').val();
                    console.log(stateID);
                    $.ajax({
                        type: 'POST',
                        data: {
                            state: stateID,
                            _token: '{{ csrf_token() }}'
                        }, // Add a comma here
                        url: "{{ url('/admin/employee/country-city') }}",
                        dataType: 'json',
                        success: function(result) {

                            $('#empCityID').empty();
                            result.forEach(element => {

                                $('#empCityID').append('<option value="' + element.id +
                                    '">' + element.name + '</option>');
                            });

                        },
                    });
                });

            });
        </script>
        <script>
            function selectGovId(context) {
                console.log(context.value);
                var selectGovId = context.value;

            }

            function windowreload() {
                window.location.reload();
            }
        </script>

        <script>
            // $(document).ready(function() {
            //     // Trigger the AJAX request when a button is clicked
            //     $('#fetchEmpId-data-button').click(function() {
            //         $.ajax({
            //             type: 'GET',
            //             url: "{{ url('/admin/employee/emp_id') }}", // The URL defined in your route
            //             dataType: 'json',
            //             success: function(data) {
            //                 var numericPart = parseInt(data.get.max_emp_id.slice(2));
            //                 numericPart += 1;
            //                 $('#emp_id_sd').val(load() + numericPart);
            //             },
            //         });
            //     });
            // });

            // Employee Type select
            $('#contractualEmployeeAdd').addClass('d-none');
            $('#regularEmployeeAdddd').addClass('d-none');
            $('#openAddNewEmployeeMod').on('change', function() {
                //  alert( this.value ); // or $(this).val()
                // console.log(this.value);
                if (this.value == 1) {
                    // console.log("1jsr")
                    $('#regularEmployeeAdddd').removeClass('d-none');
                    $('#contractualEmployeeAdd').addClass('d-none');
                    $('#ContractType').val('0');
                } else if (this.value == 2) {
                    // console.log("2jsr");
                    $('#regularEmployeeAdddd').addClass('d-none');
                    $('#contractualEmployeeAdd').removeClass('d-none');
                } else {
                    $('#regularEmployeeAdddd').addClass('d-none');
                    $('#contractualEmployeeAdd').addClass('d-none');
                }
            });

            function ItemDeleteModel(context) {
                var id = $(context).data('id');
                $('#weekly_policy_id').val(id);
            }

            function openEditModel(context) {
                $("#updateempmodal").modal("show");
                var id = $(context).data('id');
                $('#setId').val(id);
                $.ajax({
                    url: "{{ url('/admin/employee/all_employee') }}",
                    type: "POST",
                    async: true,
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: id
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        console.log(result);
                        // check shift type rotational or not
                        if (result.get[0].shift_type == 2) {
                            $('#select_rotational_div').removeClass('d-none');
                            var rotaCheck = result.get[0].emp_rotational_shift_type_item;
                            $('#shift_type_sd').trigger('change');
                            roatationalItem(result.get[0].emp_shift_type, result.get[0]
                                .emp_rotational_shift_type_item);
                            $('.update_roatational_type_sddd').val(result.get[0].emp_rotational_shift_type_item);
                        } else {
                            $('#select_rotational_div').addClass('d-none');
                        }
                        // set the values
                        if (result.get[0].emp_id) {
                            $("input[name='update_gender']").filter("[value='" + result.get[0]
                                .emp_gender + "']").prop(
                                'checked', true);
                            $('#sts2').val(result.get[0].emp_state);
                            $('#sts2').trigger('change');
                            var dataat = $('#sts2').val();
                            $('#state24').val(result.get[0].emp_city);
                            $('.update_name_sd').val(result.get[0].emp_name);
                            $('.update_mname_sddd').val(result.get[0].emp_mname);
                            $('.update_lname_sddd').val(result.get[0].emp_lname);
                            $('.update_cnumber_sddd').val(result.get[0].emp_mobile_number);
                            $('.update_email_sddd').val(result.get[0].emp_email);
                            $('.update_dob_sddd').val(result.get[0].emp_date_of_birth);
                            $('.update_country_sddd').val(result.get[0].emp_country);
                            $('.update_reporting_manager_dd').val(result.get[0].emp_reporting_manager);
                            $('.update_city_sddd').val(result.get[0].emp_city);
                            $('.update_pcode_sddd').val(result.get[0].emp_pin_code);
                            $('.update_address_sddd').val(result.get[0].emp_address);
                            $('.update_shifttype_sddd').val(result.get[0].emp_shift_type).change();
                            $('.update_attendance_method').val(result.get[0].emp_attendance_method).change();
                            $('.update_empid_sddd').val(result.get[0].emp_id);
                            $('.update_branchname_sddd').val(result.get[0].branch_id);
                            $('.update_department_sddd').val(result.get[0].department_id);
                            $('.update_gender_sddd').val(result.get[0].emp_gender);
                            $('.marital_satatu_sddd').val(result.get[0].emp_marital_status);
                            $('.update_caste_sddd').val(result.get[0].emp_category);
                            $('.updateblood_group_sddd').val(result.get[0].emp_blood_group);
                            $('.update_gov_id_sddd').val(result.get[0].emp_gov_select_id);
                            $('.update_id_no_sddd').val(result.get[0].emp_gov_select_id_number);
                            $('.update-nationality_sddd').val(result.get[0].emp_nationality);
                            $('.update_designationname_sddd').val(result.get[0].designation_id);
                            $('.update_nationality_sddd').val(result.get[0].emp_nationality);
                            $('.update_doj_dd').val(result.get[0].emp_date_of_joining);
                            $('.update_reporting_manager_dd').val(result.get[0].emp_reporting_manager);
                            $('.update_edit_assign_setup').val(result.get[0].master_endgame_id);
                            const imageUrl = `{{ asset('employee_profile/${result.get[0].profile_photo}') }}`;
                            // $('.image_sdd').attr("data-default-file", '');
                            $('.image_sdd').attr("data-default-file", imageUrl);
                            // $('.dropify-infos')('d-none');
                            // Remove the text content of the element
                            // $('.image_sdd').text('');

                            // If you want to destroy the dropify plugin, you can do it after removing the image and name
                            // $('.image_sdd').dropify('destroy');
                            // $('.image_sdd').dropify('destroy');
                            $('.image_sdd').dropify();
                            // change(result.get[0].branch_id, result.get[0].department_id, result.get[0]
                            //     .designation_id);

                        } else {}
                    },
                });

            }

            function drofiyimage(id) {
                console.log("gaya image function make");
                $.ajax({
                    url: "{{ url('/admin/employee/all_employee') }}",
                    type: "POST",

                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: id
                    },
                    dataType: 'json',
                    success: function(result) {
                        // console.log(result);
                        if (result.get[0].emp_id) {
                            const imageUrl = `{{ asset('employee_profile/${result.get[0].profile_photo}') }}`;
                            $('#image_sd').attr("data-default-file", imageUrl);
                            $('#image_sd').dropify();
                        } else {}
                    },
                });
            }

            $(document).ready(function() {
                $('#filter-branch').on('change', function() {
                    var branch_id = this.value;
                    // console.log(branch_id);
                    $("#filter-department").html('');
                    $("#filter-designation").html('');

                    $.ajax({
                        url: "{{ url('admin/settings/business/allfilterdepartment') }}",
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
                        url: "{{ url('admin/settings/business/allfilterdesignation') }}",
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
                // // employee
                // $('#filter-department').on('change', function() {
                //     var depart_id = this.value;
                //     $("#employee-dd").html('');
                //     $.ajax({
                //         url: "{{ url('admin/settings/business/allemployeefilter') }}",
                //         type: "POST",
                //         data: {
                //             _token: '{{ csrf_token() }}',
                //             depart_id: depart_id,
                //         },
                //         dataType: 'json',
                //         success: function(res) {
                //             console.log(res);
                //             $('#employee-dd').html('<option value="">Select Employee</option>');
                //             $.each(res.employee, function(key, value) {
                //                 $("#employee-dd").append('<option value="' + value.emp_id +
                //                     '">' + value.emp_name + '</option>');
                //             });
                //         }
                //     });
                // });
            });

            $(document).ready(function() {
                $('#filter-branch, #filter-department, #filter-designation').change(function() {
                    var branchId = $('#filter-branch').val();
                    var departmentId = $('#filter-department').val();
                    console.log("depart_id1 " + departmentId);
                    var designationId = $('#filter-designation').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/employee/employeefilter') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            branch_id: branchId,
                            department_id: departmentId,
                            designation_id: designationId
                        },
                        success: function(data) {
                            // console.log(data);
                            var tbody = $('.my_body');
                            tbody.empty();

                            $.each(data, function(index, employee) {
                                // console.log(employee);
                                let i = 1;
                                employee.forEach(el => {
                                    // console.log("employee aa", el);
                                    var newRow = '<tr>' +
                                        '<td>' + i++ + '</td>' +

                                        '<td>' + `<div class="d-flex">
                                            <span class="avatar avatar-md brround me-3 rounded-circle"
                                                style="background-image: url('/employee_profile/` + el
                                        .profile_photo + `')"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">` + el.emp_name + `</h6>
                                                <p class="text-muted mb-0 fs-12">
                                                    ` + el.desig_name + `</p>
                                            </div>
                                        </div>` + '</td>' +
                                        '<td>' + el.emp_id + '</td>' +
                                        '<td>' + el.branch_name + '</td>' +
                                        '<td>' + el.depart_name + '</td>' +
                                        '<td>' + el.emp_date_of_joining + '</td>' +
                                        '<td>' + el.emp_mobile_number + '</td>' +
                                        '<td>'
                                    newRow += `<a class="btn btn-primary m-1 btn-icon btn-sm" href="javascript:void(0);"
                        onclick="openEditModel(this)" data-id="${el.emp_id}"
                        data-bs-toggle="modal" data-bs-target="#updateempmodal">
                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                            data-original-title="View"></i>
                       </a>`;

                                    //             newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                            //     data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.emp_id}"
                            //     data-bs-target="#deletemodal">
                            //     <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                            //         data-original-title="View"></i>
                            // </a>`;
                                    newRow += '</td></tr>';
                                    tbody.append(newRow);
                                });
                            });

                        }
                    });
                });
            });


            $(document).ready(function() {
                // Bind the "keyup" event to the input field
                $('#emp_id_sd').keyup(function() {
                    var searchValue = $(this).val();
                    console.log("SearchValue--->" + searchValue);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/employee/emp_id_check') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            emp_id: searchValue,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data.get);
                            var call =
                                load();
                            var pattern = new RegExp("^" + call.replace(/\s/g, '') +
                                "\\d+$");
                            console.log("pattern=>" + pattern);
                            if ((pattern.test(searchValue))) {
                                console.log("Valid format: " + searchValue);
                                $('.emp_id_dd').css("border-color", "green");
                                $('#empIdAlready').text("Valid format").css("color",
                                    "green");
                                if (data.get && data.get.emp_id !== undefined && data
                                    .get.emp_id ==
                                    searchValue) {
                                    $('#empIdAlready').text(
                                        "Employee ID already exists: " + data
                                        .get
                                        .emp_id);
                                    $('.emp_id_dd').css("border-color", "red");
                                    $('#empIdAlready').css("color", "red");
                                    console.log("empIdAlready");
                                }
                            } else if (searchValue.replace(/\s+/g, '')) {
                                $('.emp_id_dd').css("border-color", "red");

                                $('#empIdAlready').text(
                                    "Invalid format. Employee ID should start with " +
                                    call +
                                    " followed by numbers.").css("color", "red");
                            } else {
                                $('.emp_id_dd').css("border-color", "red");

                                $('#empIdAlready').text(
                                    "Invalid format. Employee ID should start with " +
                                    call +
                                    " followed by numbers.").css("color", "red");
                            }
                        },
                    });
                });
            });

            function roatationalItem(e, rotational) {
                // console.log(e);
                $("#roatational_type_id").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allrotationalshift') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: e
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log("choter ", result);
                        if (result.department[0].shift_type == 2) {
                            $('#select_rotational_div').removeClass('d-none');
                            console.log("shifttype2");
                            $('#roatational_type_id').html(
                                '<option value="" name="update">Select Rotational Type</option>'
                            );
                            $.each(result.department, function(key, value) {
                                // value.shift_type == 2
                                $("#roatational_type_id").append('<option name="department" value="' +
                                    value
                                    .id + '">' + value.shift_name +
                                    '</option>');
                            });
                            $('#roatational_type_id').val(rotational);
                        }
                    }
                });
            }

            $('#shift_type_sd').on('change', function() {
                var branch_id = this.value;
                console.log("sahi ja raha hai ", branch_id);
                $("#roatational_type_id").html('');
                if (branch_id) {
                    $.ajax({
                        url: "{{ url('admin/settings/business/allrotationalshift') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            brand_id: branch_id
                        },
                        dataType: 'json',
                        success: function(result) {
                            // console.log(result);
                            if (result.department[0].shift_type == 2) {
                                $('#select_rotational_div').removeClass('d-none');
                                $('#roatational_type_id').html(
                                    '<option value="" name="department">Select Rotational Type</option>'
                                );
                                console.log(result.department[0].shift_type);
                                $.each(result.department, function(key, value) {
                                    // value.shift_type == 2
                                    $("#roatational_type_id").append(
                                        '<option name="department" value="' +
                                        value
                                        .id + '">' + value.shift_name +
                                        '</option>');
                                });
                            } else {
                                $('#select_rotational_div').addClass('d-none');
                            }
                        }
                    });
                } else {
                    $('#select_rotational_div').addClass('d-none');
                }
            });

            $('#shift_type_sd').on('change', function() {
                var branch_id = this.value;
                $("#rotational_type_id").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allrotationalshift') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log("Result", result);
                        console.log("Result2", result.department[0]);
                        if (result.department[0].shift_type == 2) {
                            console.log("shifttype2");
                            $('#checkRotationalTypeItem').removeClass('d-none');
                            $('#rotational_type_id').html(
                                '<option value="" name="department">Select Rotational Type</option>'
                            );
                            console.log(result.department[0].shift_type);
                            $.each(result.department, function(key, value) {
                                // value.shift_type == 2
                                $("#rotational_type_id").append(
                                    '<option name="department" value="' +
                                    value
                                    .id + '">' + value.shift_name +
                                    '</option>');
                            });
                        } else {
                            $('#checkRotationalTypeItem').addClass('d-none');

                            console.log("shifttypeother");
                        }
                        // $('#desig-dd').html(
                        //     '<option value="">Select Designation Name</option>');
                    }
                });
            });
        </script>
        <script>
            function load() {

                var nonNumericPart = ("{{ $EmpID->model_id != null ? $EmpID->model_id : 'not create module' }}").match(
                    /([^0-9]+)/);
                return nonNumericPart ? nonNumericPart[0].trim() : '';
            }
        </script>

        <script>
            function selectShiftType(context) {
                // console.log("hii "+context);
                var id = context;
                console.log(id);
                $.ajax({
                    url: "{{ url('/admin/employee/shift_check') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        shift_id: id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log("result ", result.get.shift_type)
                    }
                });
            };
        </script>
    </div>
@endif
