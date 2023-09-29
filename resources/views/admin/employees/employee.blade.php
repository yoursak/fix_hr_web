@extends('admin.pagelayout.master')
{{-- @extends('admin.layout.master') --}}
<script src="{{ asset('assets/js/cities.js') }}"></script>
@section('title')
    Employee
@endsection


@section('js')
    <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
    <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.24') }}"></script>
    {{-- <script src="{{ asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script> --}}
    <script src="{{ asset('jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js') }}"></script>
@endsection

@section('content')

    @php
        // dd($data->all());
        
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
        
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        // dd($Department);
        $i = 0;
        $j = 1;
        foreach ($Department as $item) {
            $i++;
        }
        
        // $central = new App\Helpers\Central_unit();
        
        $Employee = $centralUnit->EmployeeDetails();
        // $Department = $central::DepartmentList();
        // $Designation = App\Helpers\Central_unit::DesignationList();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        // dd($Employee);
        $i = 0;
        $male = 0;
        $female = 0;
        foreach ($Employee as $key => $value) {
            // dd($value);
            $i++;
            if ($value->emp_gender == 1) {
                $male++;
            } elseif ($value->emp_gender == 2) {
                $female++;
            }
        }
    @endphp
    <!-- START ROW -->
    <div class="row pt-5">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Employees</span>
                                <h3 class="mb-0 mt-1 text-success">{{ $i }}</h3>
                            </div>
                        </div>
                        <div class="col-5 ">
                            <div class="icon1 bg-success-transparent my-auto pt-3 float-end"> <i class="las la-users"></i>
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
                                <h3 class="mb-0 mt-1 text-primary ">{{ $male }}</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-primary-transparent my-auto pt-3 float-end"> <i class="las la-male"></i>
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
                                <h3 class="mb-0 mt-1 text-secondary">{{ $female }}</h3>
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
                                <h3 class="mb-0 mt-1 text-danger">398</h3>
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

    <!-- ROW -->
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">Employees List</h4>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                @if (in_array('Employee.Create', $permissions))
                                    <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#empType">Add New Employee</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='branch_id' id="country-dd" class="form-control" required>
                                    <option value="">Select Branch Name</option>
                                    @foreach ($Branch as $data)
                                        <option value="{{ $data->branch_id }}">
                                            {{ $data->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Department</p>
                                <div class="form-group mb-3">
                                    <select id="state-dd" name="department_id" class="form-control" required>
                                        <option value="">Select Deparment Name</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3">
                                    <select id="desig-dd" name="designation_id" class="form-control" required>
                                        <option value="">Select Designation Name</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="form-group">
                                <p class="form-label">Employee</p>
                                <select id="employee-dd" name="emp_id" class="form-control" required>
                                    <option value="">Select Employee Name</option>
                                </select>

                           
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">

                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S. No.</th>
                                    <th class="border-bottom-0">Employee Name</th>
                                    <th class="border-bottom-0">Employee ID</th>
                                    <th class="border-bottom-0">Branch</th>
                                    <th class="border-bottom-0">Department</th>
                                    <th class="border-bottom-0">Joining Date</th>
                                    <th class="border-bottom-0">Phone Number</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody class="my_body"> --}}
                            <tbody class="my_body">
                                @php
                                    
                                    $count = 1;
                                @endphp
                                @foreach ($DATA as $item)
                                    @php
                                        $centralUnit = new App\Helpers\Central_unit();
                                        $branch = $centralUnit::Branchget($item->branch_id);
                                        $depart = $centralUnit::Departmentget($item->department_id);
                                        // dd($branch->branch_name);
                                        // $BranchName = $centralUnit->Branchget($item->branch_id);
                                        // dd($BranchName);
                                        // echo $BranchName;
                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3"
                                                    style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">{{ $item->emp_name }}</h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?= $nss->DesingationIdToName($item->designation_id) ?></p>

                                                </div>
                                            </div>

                                            {{-- <div class="d-flex">
                                                <span class="avatar brround avatar-md d-block"
                                                    style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                <div class="">
                                                    <h6 class="mb-0 font-weight-semibold"> {{ $item->emp_name }}</h6>
                                                    <small
                                                        class=""><?= $nss->DesingationIdToName($item->designation_id) ?></small>
                                                </div>
                                            </div> --}}

                                            {{-- Departmentget --}}
                                        </td>
                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $branch->branch_name ?? ' ' }}</td>
                                        <td>{{ $depart->depart_name }}</td>
                                        <td>{{ $item->emp_date_of_joining }}</td>
                                        <td>{{ $item->emp_mobile_number }}</td>
                                        <td>

                                            @if (in_array('Employee.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateempmodal{{ $item->emp_id }}">
                                                    <i class="feather feather-edit " data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Employee.Delete', $permissions))
                                                <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletemodal{{ $item->emp_id }}">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->


    <!-- LARGE MODAL -->
    <div class="modal fade " id="addempmodal">
        <form id="myForm" action="{{ route('add.employee') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-scrollable  modal-lg">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Add New Employee</h6>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body" style="overflow-y:auto">
                        <!-- ROW OPEN -->
                        <div id="smartwizard-3">
                            <ul>
                                <li><a href="#step-10">Personal Detail</a></li>
                                <li><a href="#step-11">Comapany Detail</a></li>

                            </ul>
                            <div>
                                <div id="step-10" class="">

                                    <h4 class="mb-2 font-weight-bold">Basic</h4>
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="file" id="image_sd" name="image" class="dropify"
                                                    data-height="180" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label mb-0 mt-2">Employee Type</label>
                                                <select class="form-select" aria-label="Type" id="employee_type"
                                                    name="employee_type" required>
                                                    <option selected value="">Employee Type</option>
                                                    <option value="1">Regular</option>
                                                    <option value="2">Contractual</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">First Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="name_sd" type="text"
                                                            class=" form-control mb-md-0 mb-5" placeholder="First Name"
                                                            name="name" required>
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Middle Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="" type="text"
                                                            class="form-control mb-md-0 mb-5" placeholder="Middle Name"
                                                            name="mName">
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label id="last_id" class="form-label mb-0 mt-2">Last Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="last_sd" type="text"
                                                            class=" form-control mb-md-0 mb-5" placeholder="Last Name"
                                                            name="lName" required>
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Contact Number</label>
                                                <input id="number_sd" type="tel" class="form-control"
                                                    placeholder="Enter 10-digit phone number" name="mobile_number"
                                                    pattern="[0-9]{10}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Email</label>
                                                <input name="email_sd" type="text" class="form-control"
                                                    placeholder="email" id="email_sd" name="email" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                <input type="date" class="form-control fc-datepicker"
                                                    placeholder="DD-MM-YYY" id="dateofbirth_sd" name="dob" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label mb-0 mt-2">Gender</label>
                                                <div class="custom-controls-stacked d-md-flex">
                                                    <label class="custom-control custom-radio me-4">
                                                        <input type="radio" class="custom-control-input" name="gender"
                                                            value="1">
                                                        <span class="custom-control-label">Male</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="gender"
                                                            value="2">
                                                        <span class="custom-control-label">Female</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="gender"
                                                            value="3">
                                                        <span class="custom-control-label">Other</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Country</label>
                                                <select class="form-select" aria-label="Type" id="country_sd"
                                                    name="country" required>
                                                    <option value="">Select Country</option>
                                                    <option value="1">India</option>
                                                    <option value="2">USA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">State</label>
                                                <select id="sts1"
                                                    onchange="print_city('state1', this.selectedIndex);" name="state"
                                                    class="form-control w-100 border rounded" required></select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">City</label>
                                                <select id="state1" name="city"
                                                    class="form-control w-100 border rounded" required></select>
                                                <script language="javascript">
                                                    print_state("sts1");
                                                </script>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Pin Code</label>
                                                <input id="pincode_sd" type="text" class="form-control"
                                                    placeholder="Postal PIN" name="pincode">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label mb-0 mt-2">Address Line 1</label>
                                                <input id="address_sd" type="text" class="form-control"
                                                    placeholder="Address" name="address">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="step-11" class="">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Employee ID</label>
                                                <input name="emp_id" id="emp_id_sd" type="text" class="form-control"
                                                    placeholder="Employee ID Like: <?= $EmpID->model_id != null ? $EmpID->model_id : 'not create module' ?>"
                                                    value="" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Select Shift Type</label>
                                                <select name="projects" id="shift_type_sd" aria-label="Type"
                                                    class="form-control custom-select" data-placeholder="Select Type">
                                                    <option value="">Select Shift Type</option>
                                                    <option value="0">Assigned</option>
                                                    <option value="1">Not Assigned</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Branch</label>
                                                <select class="form-select " aria-label="Type" id="country-1dd"
                                                    name="branch">
                                                    <option value="">Select Branch Name</option>
                                                    @if (!empty($Branch))
                                                        @foreach ($Branch as $branch)
                                                            <option value="<?= $branch->branch_id ?>">
                                                                <?= $branch->branch_name ?>
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No roles available</option>
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Department</label>

                                                <select id="state-1dd" name="department" class="form-control">
                                                    <option value="">Select Deparment Name</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Designation</label>
                                                <select id="desig-1dd" name="designation" class="form-control" required>
                                                    <option value="">Select Designation Name</option>
                                                </select>

                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                <input type="date" class="form-control fc-datepicker" id="doj_sd"
                                                    placeholder="DD-MM-YYYY" name="doj" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Attendance Mark</label>
                                                <select name="" aria-label="Type" id="attendance_sd"
                                                    class="form-control custom-select" required>
                                                    <option label="Select Type" value="">Select Attendence Mark Type
                                                    </option>
                                                    <option value="0">Office</option>
                                                    <option value="1">Outdoor</option>
                                                    <option value="2">Remote</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group mt-7">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label class="form-label">Manual Attendance with Location,
                                                    FaceId And QR Code:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                        class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Active/Inactive</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="example-checkbox1" value="option1" checked>
                                                    <span class="custom-control-label"><b>Send SMS
                                                            Employee</b></span>
                                                    <span class="fs-11">By continuing you agree to <b><a href="#"
                                                                class="text-primary">Tearm &
                                                                Conditions</a></b>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-12" class="">
                                    <div class="form-group mb-0 justify-content-end">
                                        <div class="">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="example-checkbox2" value="option2">
                                                <span class="custom-control-label">I agree terms &
                                                    Conditions</span>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>
                        </div>
                        {{-- </div> --}}
                        {{-- </div> --}}
                        {{-- </div>
                    </div> --}}
                        <!-- ROW CLOSED -->
                    </div>
                    {{-- <div class="modal-footer">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div> --}}
                </div>
            </div>
        </form>
    </div>
    <!-- END LARGE MODAL -->



    {{-- Update regular employee --}}
    @foreach ($Employee as $emp)
        <div class="modal fade" id="updateempmodal{{ $emp->emp_id }}" data-bs-backdrop="static">
            <form action="{{ route('update.employee') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <h3 class="card-title">Add Regular Employee</h3>
                                    <a aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                            aria-hidden="true">&times;</span></a>
                                    <div class="tab-menu-heading hremp-tabs p-0 ">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class="ms-4"><a href="#tab7" class="active"
                                                        data-bs-toggle="tab">Personal
                                                        Details</a></li>
                                                <li><a href="#tab8" data-bs-toggle="tab">Company Details</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body hremp-tabs1 p-0"
                                        style="height: 30rem; overflow:scroll">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab7">
                                                <div class="card-body">
                                                    <h4 class="mb-4 font-weight-bold">Basic</h4>
                                                    <div class="form-group d-flex justify-content-center">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="file" name="image" class="dropify"
                                                                    data-height="180" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Employee Type</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                @if ($emp->employee_type == 1)
                                                                    <select class="form-select" aria-label="Type"
                                                                        name="employee_type">
                                                                        <option selected>Employee Type</option>
                                                                        <option value="1" selected>Regular</option>
                                                                        <option value="2">Contractual</option>
                                                                    </select>
                                                                @else
                                                                    <select class="form-select" aria-label="Type"
                                                                        name="employee_type">
                                                                        <option selected>Employee Type</option>
                                                                        <option value="1">Regular</option>
                                                                        <option value="2" selected>Contractual
                                                                        </option>
                                                                    </select>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Employee Name</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="text"
                                                                            class="form-control mb-md-0 mb-5"
                                                                            value="{{ $emp->emp_name }}"
                                                                            placeholder="First Name" name="name">
                                                                        <span class="text-muted"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Contact Number</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $emp->emp_mobile_number }}"
                                                                    placeholder="Phone Number" name="mobile_number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Email</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    placeholder="email" value="{{ $emp->emp_email }}"
                                                                    name="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control fc-datepicker"
                                                                    value="{{ $emp->emp_date_of_birth }}"
                                                                    placeholder="DD-MM-YYY" name="dob">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Gender</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="custom-controls-stacked d-md-flex">
                                                                    @if ($emp->emp_gender == 1)
                                                                        <label class="custom-control custom-radio me-4">
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                name="gender" value="1" checked>
                                                                            <span class="custom-control-label">Male</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                name="gender" value="2">
                                                                            <span
                                                                                class="custom-control-label">Female</span>
                                                                        </label>
                                                                        <label class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                name="gender" value="3">
                                                                            <span class="custom-control-label">Other</span>
                                                                        </label>
                                                                    @else
                                                                        @if ($emp->emp_gender == 2)
                                                                            <label
                                                                                class="custom-control custom-radio me-4">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="1">
                                                                                <span
                                                                                    class="custom-control-label">Male</span>
                                                                            </label>
                                                                            <label class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="2" checked>
                                                                                <span
                                                                                    class="custom-control-label">Female</span>
                                                                            </label>
                                                                            <label class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="3">
                                                                                <span
                                                                                    class="custom-control-label">Other</span>
                                                                            </label>
                                                                        @else
                                                                            <label
                                                                                class="custom-control custom-radio me-4">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="1">
                                                                                <span
                                                                                    class="custom-control-label">Male</span>
                                                                            </label>
                                                                            <label class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="2">
                                                                                <span
                                                                                    class="custom-control-label">Female</span>
                                                                            </label>
                                                                            <label class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="gender" value="3" checked>
                                                                                <span
                                                                                    class="custom-control-label">Other</span>
                                                                            </label>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Pin Code</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Postal PIN"
                                                                    value="{{ $emp->emp_pin_code }}" name="pin">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Country</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Country" value="{{ $emp->emp_country }}"
                                                                    name="country">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">State</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    placeholder="State" value="{{ $emp->emp_state }}"
                                                                    name="state">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">City</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"
                                                                    placeholder="City" value="{{ $emp->emp_city }}"
                                                                    name="city">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Address</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <textarea rows="3" class="form-control" placeholder="Address2" name="address">{{ $emp->emp_address }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-7">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label class="form-label">Manual Attendance with Location,
                                                                    Face
                                                                    Id
                                                                    And QR Code:</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                                        class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span
                                                                        class="custom-switch-description">Active/Inactive</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab8">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Employee ID</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input name="emp_id" type="text" class="form-control"
                                                                    value="{{ $emp->emp_id }}" placeholder="Employee ID"
                                                                    disable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2 ">Branch</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select class="form-select " aria-label="Type"
                                                                    name="branch">

                                                                    @foreach ($Branch as $branch)
                                                                        <option value="{{ $branch->branch_id }}">
                                                                            {{ $branch->branch_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                {{-- @dd($branch); --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Department</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select class="form-select" aria-label="Type"
                                                                    name="department">
                                                                    @foreach ($Department as $depart)
                                                                        <option value="{{ $depart->depart_id }}" selected>
                                                                            {{ $depart->depart_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Designation</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select class="form-select" aria-label="Type"
                                                                    name="designation">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control fc-datepicker"
                                                                    value="{{ $emp->emp_date_of_joining }}"
                                                                    placeholder="DD-MM-YYYY" name="doj">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="mb-5 mt-7 font-weight-bold">Shift</h4>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-0 mt-2">Select Shift</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="projects"
                                                                    class="form-control custom-select select2"
                                                                    data-placeholder="Select Type">
                                                                    <option label="Select Type">Select Shift</option>
                                                                    <option value="0">Assigned</option>
                                                                    <option value="1">Not Assigned</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        name="example-checkbox1" value="option1" checked>
                                                                    <span class="custom-control-label"><b>Send SMS
                                                                            Employee</b></span>
                                                                    <span class="fs-11">By continuing you agree to <b><a
                                                                                href="#" class="text-primary">Tearm
                                                                                &
                                                                                Conditions</a></b></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                        <button class="btn btn-danger" type="reset"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- delete confirmation --}}
        {{-- {{ $emp->emp_id }} --}}
        <div class="modal fade" id="deletemodal{{ $emp->emp_id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to delete ?</h3>
                    </div>
                    <form method="POST" action="{{ route('delete.employee', ['id' => $emp->emp_id]) }}">
                        @csrf
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#">Delete</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        {{-- Employee Type --}}
        <div class="modal fade" id="empType">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Add New Employee</h5>

                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{-- <div class="modal-body d-flex justify-content-around"> --}}
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label mb-0 mt-2">Select Employee Type:</label>
                                <select class="form-select" onchange="changeElement()" id="selectoption"
                                    aria-label="Type" id="employee_type" name="employee_type" required>
                                    <option selected value="">Employee Type</option>
                                    <option id="regular_emp" value="1">Regular</option>
                                    <option value="2">Contractual</option>
                                </select>
                                <br>
                            </div>

                            <div class="col-xl-12 text-center d-none" id="regularEmployeeElem">

                                <div>
                                    <h3><b>Add New Employee</b></h3>
                                    <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic, HRA,
                                        PF,
                                        ESI, etc.)</p>
                                </div>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#addempmodal"><b>Add Employee</b></a>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                                <a class="btn btn-outline-primary my-2 border-0" onclick="downloadform()"
                                    data-bs-toggle="modal" data-bs-target="#"><b><i
                                            class="fa fa-file-excel-o me-1"></i>Download Sample Template</b></a>
                            </div>
                            <div class="col-xl-12 text-center d-none" id="contractEmployeeElem">
                                <div>
                                    {{-- <br> --}}
                                    <select id="employeetype" class="form-select" aria-label="Type" name=""
                                        id="">
                                        <option value="">Select Contractual Type:</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Daily</option>
                                        <option value="4">Hourly</option>
                                    </select>
                                </div>
                                <br>
                                <div class="col-xl-12 text-center ">

                                    <div>
                                        <h3><b>Add New Employee</b></h3>
                                        <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic,
                                            HRA,
                                            PF,
                                            ESI, etc.)</p>
                                    </div>
                                    <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#addempmodal"><b>Add Employee</b></a>
                                    <a class="btn btn-outline-primary my-2 border-0" id="downloadSampleTemp"
                                        data-bs-toggle="modal" data-bs-target="#"><b><i
                                                class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                                    <a class="btn btn-outline-primary my-2 border-0" type="submit" onclick="downloadTwo()"
                                        id="downloadSampTemplate" data-bs-toggle="modal" data-bs-target="#"><b><i
                                                class="fa fa-file-excel-o me-1"></i>Download Sample Template</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Employee Type --}}
     
    @endforeach
    {{-- delete confirmation --}}


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function downloadTwo() {
            //jquery selection can be achieve via vanilla JS
            let dateVal = $("[name='date']").val();
            window.open("_blank");
            window.open( "_blank");

            return false;
        }


        function downloadform() {
            // alert("Hello");
            $slecdownload = document.getElementById('downloadSampTemplate');
            alert("Hello");
        }

        function changeElement() {
            $selectoption = document.getElementById('selectoption');
            $regularEmployeeElem = document.getElementById('regularEmployeeElem');
            $contractEmployeeElem = document.getElementById('contractEmployeeElem');

            // alert( $selectoption.value);

            if ($selectoption.value == 1) {
                $regularEmployeeElem.classList.remove('d-none');
                $contractEmployeeElem.classList.add('d-none');
            } else if ($selectoption.value == 2) {
                $contractEmployeeElem.classList.remove('d-none');
                $regularEmployeeElem.classList.add('d-none');
            }

        }
        $(document).ready(function() {

            // Add event listeners to the dropdowns
            $('#country-dd, #state-dd, #desig-dd').change(function() {
                // Get selected values
                var branchId = $('#country-dd').val();
                console.log(branchId);
                var departmentId = $('#state-dd').val();
                console.log(departmentId);
                var designationId = $('#desig-dd').val();
                console.log(designationId);

                // Make an AJAX request to filter employees
                $.ajax({
                    type: "POST",
                    // url: '{{ route('filter.employees') }}',
                    url: "{{ url('admin/employee/employeefilter') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branchId,
                        department_id: departmentId,
                        designation_id: designationId
                    },
                    success: function(data) {
                        console.log(data);
                        // Update the table body with the filtered data
                        var tbody = $('.my_body');
                        tbody.empty();

                        $.each(data, function(index, employee) {
                            console.log(employee);
                            i=1;
                            employee.forEach(el => {
                                console.log(el.emp_id);
                                var newRow = '<tr>' +
                                    '<td>' + i++ + '</td>' +
                                    '<td>' + el.emp_name + '</td>' +
                                    '<td>' + el.emp_id + '</td>' +
                                    '<td>' + el.branch_id + '</td>' +
                                    '<td>' + el.department_id + '</td>' +
                                    '<td>' + el.emp_date_of_joining + '</td>' +
                                    '<td>' + el.emp_mobile_number + '</td>' +
                                    // '<td> + +</td>' + // Add your action buttons here
                                    '</tr>';
                                    // i++;
                                    tbody.append(newRow);
                            });

                        });
                    }
                });
            });
            $('#country-dd').on('change', function() {
                var branch_id = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        // console.log(result);
                        $('#state-dd').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#state-dd").append('<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });
                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                    }
                });
            });

            $('#state-dd').on('change', function() {
                var depart_id = this.value;
                $("#desig-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldesignation') }}",
                    type: "POST",
                    data: {
                        depart_id: depart_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        // console.log(res);
                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                        $.each(res.designation, function(key, value) {
                            $("#desig-dd").append('<option value="' + value
                                .desig_id + '">' + value.desig_name + '</option>');
                        });
                        // $('#employee-dd').html(
                        //     '<option value="">Select Employee Name</option>');

                    }
                });
            });
            // employee
            $('#state-dd').on('change', function() {
                var depart_id = this.value;
                $("#employee-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allemployeefilter') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        depart_id: depart_id,
                    },
                    dataType: 'json',
                    success: function(res) {
                        // console.log(res);
                        $('#employee-dd').html('<option value="">Select Employee</option>');
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + value.emp_name + '</option>');
                        });
                    }
                });
            });

        });
    </script>







@endsection
