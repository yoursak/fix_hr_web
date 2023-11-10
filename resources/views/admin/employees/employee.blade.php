@extends('admin.pagelayout.master')
<script src="{{ asset('assets/js/cities.js?v=2.34') }}">
</script>
@section('title')
    Employee
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
    <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.76') }}"></script>
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>
    {{-- <script src=""></script> --}}
    <script>
        LoaderPackageDropify('load', 'Employee Bulk Upload Select Excel File');
    </script>
@endsection
<style>
    .emp-id-exists {
        border-color: red;
        color: red;
    }

    .message-exists {
        color: red;
    }

    #btnXyz:hover {
        color: #fff
    }
</style>
@section('content')
    @php
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
                                <h3 class="mb-0 mt-1 text-primary "> {{ $ITEM[1] }}</h3>
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
    <livewire:employee-joining-form />

    {{-- Employee Type --}}
    <div class="modal fade" id="empType" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>Add Employee</h5>
                    <a aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{-- d-flex justify-content-around --}}
                <div class="modal-body  justify-content-around">
                    <div class="row justify-content-center  ">
                        <div class="col-sm-10 justify-content-center">
                            <p class="form-label">Select Employee Type</p>
                            <div class="form-group ">
                                <select id="openAddNewEmployeeMod" name="openAddNe" class="form-control" required>
                                    <<option value="" selected>Select Employee Type</option>
                                        <option value="1">Regular Employee</option>
                                        <option value="2">Contractual Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-sm-12 text-center d-none" id="regularEmployeeAdddd">
                        <div>
                            <h3><b style="color:#1877f2">Regular Employee</b></h3>
                        </div>
                        <div>
                            <a class="modal-effect btn btn-outline-primary my-2 border-0" id="btnXyz"
                                data-effect="effect-scale" data-bs-toggle="modal" href="#addempmodal"><b> Add
                                    Employee</b></a>
                            <a href="{{ url('admin/employee/export_file') }}" class="btn btn-outline-primary my-2 border-0"
                                data-bs-toggle="modal" data-bs-target="{{ url('admin/employee/export_file') }}"><b><i
                                        class="fa fa-file-excel-o me-1"></i>Download
                                    Sample Template</b>
                            </a>
                            <form action="{{ url('admin/employee/import_file') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="csv_file" class="load" data-height="90"
                                    data-allowed-file-extensions="xlsx" required>
                                <button type="submit" class="btn btn-outline-primary my-2 border-0"> <b>Upload
                                        Employees</b></button>
                            </form>

                        </div>
                    </div>

                    <div class="col-sm-12 justify-content-center  d-none" id="contractualEmployeeAdd">
                        <div class="row justify-content-center  ">
                            <div class="col-sm-10 justify-content-center">
                                <p class="form-label">Select Contractual Type</p>
                                <div class="form-group ">
                                    <select id="ContractType" name="contractualtype" class="form-control" required>
                                        <option value="" selected>Select Contractual Type</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Daily</option>
                                        <option value="4">Hourly</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-center"><b style="color: rgb(22, 109, 83)">Contractual Employee</b></h3>
                        <div class="text-center">
                            <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="#addempmodal"><b>Add Employee</b></a>
                            <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b>
                            </a>
                            <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Download Sample Template</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Employee Type --}}

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
                                <select name="country-dd" id="filter-branch" class="form-control" required>
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
                                    <select id="filter-department" name="department_id" class="form-control" required>
                                        <option value="">Select Deparment Name</option>
                                        @foreach ($Department as $data)
                                            <option value="{{ $data->depart_id }}">
                                                {{ $data->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <p class="form-label">Designation</p>
                                <div class="form-group mb-3">
                                    <select id="filter-designation" name="designation_id" class="form-control" required>
                                        <option value="">Select Designation Name</option>
                                        @foreach ($Designation as $data)
                                            <option value="{{ $data->desig_id }}">
                                                {{ $data->desig_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
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
                            <tbody class="my_body">
                                @php

                                    $count = 1;
                                @endphp
                                {{-- @empty(!$DATA) --}}
                                @foreach ($DATA as $item)
                                    @php
                                        $branch = $centralUnit->Branchget($item->branch_id);
                                        $depart = $centralUnit->Departmentget($item->department_id);

                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
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
                                        <td><span class="mb-1 fs-14">{{ $item->emp_id }}</span></td>
                                        <td><span class="mb-1 fs-14">{{ $branch->branch_name ?? ' ' }}</span></td>
                                        <td><span class="mb-1 fs-14">{{ $depart->depart_name ?? '' }}</span></td>
                                        <td><span class="mb-1 fs-14">{{ $item->emp_date_of_joining }}</span></td>
                                        <td><span class="mb-1 fs-14">{{ $item->emp_mobile_number }}</span></td>
                                        <td>
                                            @if (in_array('Employee.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    id="edit_btn_modal" onclick="openEditModel(this)"
                                                    data-id='<?= $item->emp_id ?>' data-bs-toggle="modal" data
                                                    data-bs-target="#updateempmodal">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
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

    <!-- LARGE MODAL -->
    <div class="modal fade " id="updateempmodal">
        <form id="modalForm" action="{{ route('update.employee') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-scrollable  modal-lg">
                <div class="modal-content modal-content-demo">

                    <div class="modal-header">
                        <h6 class="modal-title">Update Employee Details</h6>
                        <a aria-label="Close" class="btn-close" id="closeModalButton" onclick="windowreload()"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <input type="text" id="setId" hidden>
                    <div class="card-body" style="overflow-y:auto" id="">
                        <!-- ROW OPEN -->
                        <div class="smartwizard-4">
                            <ul class="d-none">
                                <li><a href="#step-10">Personal Details</a></li>
                                <li><a href="#step-11">Communcation Details</a></li>
                                <li><a href="#step-12">Comapany Details</a></li>
                            </ul>
                            <div>
                                <div id="step-10" class="">
                                    <h4 class="mb-2 font-weight-bold">Personal Details</h4>
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="file" id="image_sd" name="image" class="image_sdd "
                                                    data-default-file="" data-height="60" data-width="100"
                                                    data-min-width="100" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">First Name</label>
                                                <input id="name_sd" type="text"
                                                    class="update_name_sd form-control mb-md-0 mb-5"
                                                    placeholder="First Name" name="update_name" required>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Middle Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="" type="text"
                                                            class="update_mname_sddd form-control mb-md-0 mb-5"
                                                            placeholder="Middle Name" name="update_mName">
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label id="last_id" class="form-label mb-0 mt-2">Last
                                                    Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="last_sd" type="text"
                                                            class="update_lname_sddd  form-control mb-md-0 mb-5"
                                                            placeholder="Last Name" name="update_lName" required>
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Contact Number</label>
                                                <input id="number_sd" type="tel"
                                                    class="update_cnumber_sddd form-control"
                                                    placeholder="Enter 10-digit phone number" name="update_mobile_number"
                                                    maxlength="10" pattern="[0-9]{10}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Email</label>
                                                <input name="udpate_email" type="email"
                                                    class="update_email_sddd form-control" placeholder="email"
                                                    id="email_sd" name="update_email" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                <input type="date" class="update_dob_sddd form-control fc-datepicker"
                                                    placeholder="DD-MM-YYY" id="dateofbirth_sd" name="update_dob"
                                                    required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Gender</label>
                                                <select class="form-control update_gender_sddd" aria-label="Type"
                                                    id="" name="update_gender" required>
                                                    <option value="">Select Gender</option>
                                                    @foreach ($staticGender as $gender)
                                                        <option value="{{ $gender->id }}">{{ $gender->gender_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <div class="custom-controls-stacked d-md-flex">
                                                    <label class="custom-control custom-radio me-4">
                                                        <input type="radio" class="custom-control-input"
                                                            name="update_gender" value="1">
                                                        <span class="custom-control-label">Male</span>
                                                    </label>
                                                    <label class="custom-control custom-radio me-4">
                                                        <input type="radio" class="custom-control-input"
                                                            name="update_gender" value="2">
                                                        <span class="custom-control-label">Female</span>
                                                    </label>
                                                    <label class="custom-control custom-radio me-4">
                                                        <input type="radio" class="custom-control-input"
                                                            name="update_gender" value="3">
                                                        <span class="custom-control-label">Other</span>
                                                    </label>
                                                </div> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Marital Status</label>
                                                <select class="form-control marital_satatu_sddd" aria-label="Type"
                                                    id="marital_status_dd" name="update_marital" required>
                                                    <option value="">Select Marital Status</option>
                                                    @foreach ($staticMarital as $martial)
                                                        <option value="{{ $martial->id }}">{{ $martial->marital_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Category</label>
                                                <select class="form-control update_caste_sddd" aria-label="Type"
                                                    id="caste_dd" name="update_category" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($statciCategory as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->caste_category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Blood Group</label>
                                                <select class="form-control updateblood_group_sddd" aria-label="Type"
                                                    id="blood_group_dd" name="update_blood" required>
                                                    <option value="">Select Blood Group</option>
                                                    @foreach ($staticbloodGroup as $bloodgroup)
                                                        <option value="{{ $bloodgroup->id }}">
                                                            {{ $bloodgroup->blood_group }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Select Id</label>
                                                <select class="form-control update_gov_id_sddd" aria-label="Type"
                                                    id="select_id_dd" name="update_gov_id" required>
                                                    <option value="">Select Any Goverment Id</option>
                                                    @foreach ($staticGovId as $govId)
                                                        <option value="{{ $govId->id }}">{{ $govId->govt_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Id Number</label>
                                                <input type="text" class="form-control  update_id_no_sddd"
                                                    id="id_number_dd" name="update_id_no" required>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="step-11" class="" style="height: 448px">
                                    <div class="form-group">
                                        <h4 class="mb-2 font-weight-bold">Communication Details</h4>
                                        <div class="row pt-5">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Nationality</label>
                                                <input type="text" class="form-control update-nationality_sddd"
                                                    name="update_nationality" id="nationality_dd">
                                                {{-- <select class="form-control update_nationality_sddd" name="nationality_dd" aria-label="Type"
                                                    id="nationality_dd" name="nationality_dd" required>
                                                    <option value="">Select Nationality</option>
                                                    <option value="1">India</option>
                                                    <option value="2">USA</option>
                                                </select> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Country</label>
                                                <select class="update_country_sddd form-select" aria-label="Type"
                                                    id="country_sd" name="update_country" required>
                                                    <option value="">Select Country</option>
                                                    <option value="1" selected>India</option>
                                                    {{-- <option value="2">USA</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">State</label>
                                                <select id="sts2" onchange="print_city('state2', selectedIndex);"
                                                    name="update_state" class="sts2 form-control w-100 border rounded"
                                                    required></select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">City</label>
                                                <select id="state24" name="update_city"
                                                    class="state2 updatecity form-control w-100 border rounded"
                                                    required></select>
                                                <script language="javascript">
                                                    print_state("sts2");
                                                </script>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Pin Code</label>
                                                <input id="pincode_sd" type="text"
                                                    class="update_pcode_sddd form-control" placeholder="Postal PIN"
                                                    name="update_pincode">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label mb-0 mt-2">Address Line 1</label>
                                                <textarea iid="address_sd" type="text" class="update_address_sddd form-control" placeholder="Address"
                                                    name="update_address" cols="30" rows="2" required></textarea>
                                                {{-- <input id="address_sd" type="text"
                                                    class="update_address_sddd form-control" placeholder="Address"
                                                    name="address"> --}}
                                            </div>

                                        </div>
                                    </div>


                                </div>

                                <div id="step-12" class="" style="height: 448px">
                                    <div class="form-group mb-0 justify-content-end">
                                        <h4 class="mb-2 font-weight-bold">Comapany Details</h4>
                                        <div class="row pt-5">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                <input type="date" class="form-control fc-datepicker update_doj_dd"
                                                    id="doj_sd" placeholder="DD-MM-YYYY" name="update_doj" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Employee ID</label>
                                                <input name="update_emp_id" id="emp_id_sd" type="text"
                                                    class="update_empid_sddd form-control"
                                                    placeholder="Employee ID Like: <?= $EmpID->model_id != null ? $EmpID->model_id : 'not create module' ?>"
                                                    value="" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Select Shift Type</label>
                                                <select name="update_shift_type" id="shift_type_sd" aria-label="Type"
                                                    class="update_shifttype_sddd form-control custom-select"
                                                    data-placeholder="Select Type">
                                                    <option value="">Select Shift Type</option>
                                                    @foreach ($shiftAttendance as $shiftset)
                                                        <option value="{{ $shiftset->attendance_id }}">
                                                            {{ $shiftset->shift_type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Select Rotational Type</label>
                                                <select name="update_shift_type" id="shift_type_sd" aria-label="Type"
                                                    class="update_shifttype_sddd form-control custom-select"
                                                    data-placeholder="Select Type">
                                                    <option value="">Select Shift Type</option>
                                                    @foreach ($shiftAttendance as $shiftset)
                                                        <option value="{{ $shiftset->attendance_id }}">
                                                            {{ $shiftset->shift_type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <p class="form-label">Branch</p>
                                                    <select name="update_branch" id="country-dd2"
                                                        class="update_branchname_sddd form-control" required>
                                                        <option value="" class="">Select
                                                            Branch Name</option>
                                                        @foreach ($Branch as $data)
                                                            <option value="{{ $data->branch_id }}">
                                                                {{ $data->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <p class="form-label">Department</p>
                                                    <div class="form-group mb-3">
                                                        <select id="state-dd2" name="update_department"
                                                            class="update_department_sddd form-control" required>
                                                            <option value="" class="">
                                                                Select Deparment Name</option>
                                                            @foreach ($Department as $data)
                                                                <option value="{{ $data->depart_id }}">
                                                                    {{ $data->depart_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <p class="form-label">Designation</p>
                                                    <div class="form-group mb-3">
                                                        <select id="desig-dd" name="update_designation"
                                                            class="update_designationname_sddd form-control" required>
                                                            <option value="">Select Designation Name</option>
                                                            @foreach ($Designation as $data)
                                                                <option value="{{ $data->desig_id }}">
                                                                    {{ $data->desig_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Assign Attendance Mathod</label>
                                                <select name="update_attendance_method" aria-label="Type"
                                                    id="attendance_sd"
                                                    class="update_attendance_method form-control custom-select" required>
                                                    <option label="Select Type" value="">Select Attendence Mark Type
                                                    </option>
                                                    @foreach ($attendanceMethod as $assign_attendance)
                                                        <option value="{{ $assign_attendance->id }}">
                                                            {{ $assign_attendance->method_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Reporting Manager</label>
                                                <input type="text" name="update_reporting_manager"
                                                    id="update_reporting_manager_dd"
                                                    class="form-control update_reporting_manager_dd" required>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="custom-control mt-5 custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="example-checkbox1" value="option1">
                                                    <span class="custom-control-label"><b>Send SMS
                                                            Employee</b></span>
                                                    <span class="fs-11">By continuing you agree to <b><a href="#"
                                                                class="text-primary">Tearm &
                                                                Conditions</a></b>
                                                    </span>
                                                </label>

                                                </select>
                                            </div>
                                            {{-- <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="example-checkbox2" value="option2">
                                                <span class="custom-control-label">I agree terms &
                                                    Conditions</span>
                                            </label> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW CLOSED -->
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END LARGE MODAL -->

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

    <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <script>
        function windowreload() {
            window.location.reload();
        }

        // $(document).ready(function() {
        //     $('#country-dd').change(function() {
        //         var selectedValue = $(this).val();
        //         console.log("ja raha hai");
        //         console.log(selectedValue);
        //     });
        // });
    </script>


    <script>
        $(document).ready(function() {
            // Trigger the AJAX request when a button is clicked
            $('#fetchEmpId-data-button').click(function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/admin/employee/emp_id') }}", // The URL defined in your route
                    dataType: 'json',
                    success: function(data) {
                        var numericPart = parseInt(data.get.max_emp_id.slice(2));
                        numericPart += 1;
                        $('#emp_id_sd').val(load() + numericPart);
                    },
                });
            });
        });

        // Employee Type select
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
                    // console.log(result);
                    // console.log("Edit modal" + result.get[0].profile_photo);
                    if (result.get[0].emp_id) {
                        $("input[name='update_gender']").filter("[value='" + result.get[0]
                            .emp_gender + "']").prop(
                            'checked', true);
                        // console.log("city: " + result.get[0].emp_city);
                        $('#sts2').val(result.get[0].emp_state);
                        $('#sts2').trigger('change');
                        var dataat = $('#sts2').val();
                        // console.log("Dad: ", dataat[0]);
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

        // $('#state-dd').on('change', function() {
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

        $(document).ready(function() {
            $('#filter-branch, #filter-department, #filter-designation').change(function() {
                var branchId = $('#filter-branch').val();
                // console.log(branchId);
                var departmentId = $('#filter-department').val();
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
                                console.log("employee aa", el);
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

                                newRow += `<a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                        data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-id="${el.emp_id}" 
                        data-bs-target="#deletemodal">
                        <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                            data-original-title="View"></i>
                    </a>`;
                                newRow += '</td></tr>';
                                tbody.append(newRow);
                            });
                        });

                    }
                });
            });
        });

        $(document).ready(function() {
            $('#filter-branch').on('change', function() {
                var branch_id = this.value;
                $("#filter-department").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allfilterdepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log(result);
                        $('#filter-department').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#filter-department").append('<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });




                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                    }
                });
            });
            $('#filter-department').on('change', function() {
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
                        console.log(res);
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
            $('#filter-department').on('change', function() {
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
                        console.log(res);
                        $('#employee-dd').html('<option value="">Select Employee</option>');
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + value.emp_name + '</option>');
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

        // $('#country-dd').on('change', function() {
        //     var branch_id = this.value;
        //     console.log("sahi ja raha hai");
        //     $("#state-dd").html('');
        //     $.ajax({
        //         url: "{{ url('admin/settings/business/allrotationalshift') }}",
        //         type: "POST",
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             brand_id: branch_id
        //         },
        //         dataType: 'json',
        //         success: function(result) {

        //             console.log("Result", result);
        //             $('#state-dd').html(
        //                 '<option value="" name="department">Select Department Name</option>'
        //             );
        //             // console.log(result.department.shift_type);
        //             $.each(result.department, function(key, value) {
        //                 // value.shift_type == 2
        //                 $("#state-dd").append('<option name="department" value="' +
        //                     value
        //                     .id + '">' + value.shift_name +
        //                     '</option>');
        //             });
        //             $('#desig-dd').html(
        //                 '<option value="">Select Designation Name</option>');
        //         }
        //     });
        // });
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
@endsection
