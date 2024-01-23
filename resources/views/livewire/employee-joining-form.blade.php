{{-- <div> --}}
{{-- hello sir --}}
@php

    $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
    $Department = $centralUnit->DepartmentList();
    $Branch = $centralUnit->BranchList();
    $Employee = $centralUnit->EmployeeDetails();
    $nss = new App\Helpers\Central_unit();
    $EmpID = $nss->EmpPlaceHolder();
    $Designation = $centralUnit->DesignationList();
    // dd($shiftAttendance);
@endphp
{{-- Employee Type --}}

<style>
    .form-control[aria-label="Type"]:not(:focus) option[value=""][disabled] {
        color: #000000;
        /* Set your desired muted color */
    }

    .custom-width {
        width: 100px;
        /* Set the desired width here */
    }
</style>
<div>
    <div class="modal fade" id="empType" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 style="color: #fff!important">Add Employee</h5>
                    <a aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{-- d-flex justify-content-around --}}
                <div class="modal-body  justify-content-around">
                    <div class="row justify-content-center  ">
                        <div class="col-sm-10 justify-content-center">
                            <p class="form-label">Select Employee Type</p>
                            <div class="form-group ">
                                <select id="openAddNewEmployeeMod" name="employee_type" class="form-control" required>
                                    <option value="" selected>Select Employee Type</option>
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
                            <a href="{{ url('admin/employee/export_file') }}"
                                class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="{{ url('admin/employee/export_file') }}"><b><i
                                        class="fa fa-file-excel-o me-1"></i>Download
                                    Sample Template</b>
                            </a>
                            <form action="{{ url('admin/employee/import_file') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- data-allowed-file-extensions="xlsx" required --}}
                                <input type="file" name="csv_file" class="load" data-height="90">
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
                                        <option value="3">Hourly</option>

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
                                data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Download Sample
                                    Template</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Employee Type --}}

    <!-- LARGE MODAL -->
    <div class="modal fade " id="addempmodal">
        <div class="modal-dialog modal-dialog-scrollable  modal-lg">
            <div class="modal-content modal-content-demo">
                <form id="myForm" action="{{ route('add.employee') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h6 class="modal-title">Add New Employee</h6>
                        <a aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="card-body" style="overflow-y:auto">
                        <!-- ROW OPEN -->
                        <div class="smartwizard-3">
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
                                                <input type="file" id="image_sd" name="image"
                                                    class="dropify image_sdd" data-height="60" data-width="100"
                                                    data-min-width="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">First Name</label>
                                                <input id="name_sd" type="text" class=" form-control"
                                                    placeholder="First Name" name="name" required>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Middle Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="" type="text" class="form-control"
                                                            placeholder="Middle Name" name="mName">
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label id="last_id" class="form-label mb-0 mt-2">Last Name</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input id="last_sd" type="text" class=" form-control"
                                                            placeholder="Last Name" name="lName" required>
                                                        <span class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Contact Number</label>
                                                <input id="number_sd" type="tel" class="form-control"
                                                    placeholder="Enter 10-digit phone number" name="mobile_number"
                                                    maxlength="10" pattern="[0-9]{10}" required>

                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Email</label>
                                                <input name="email_sd" type="text" class="form-control"
                                                    placeholder="Email" id="email_sd" name="email" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                <input type="date" class="form-control fc-datepicker text-muted"
                                                    placeholder="DD-MM-YYY" id="dateofbirth_sd" name="dob_dd"
                                                    required>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label class="form-label mb-0 mt-2">Gender</label>
                                                <select class="form-control update_gender_sddd " aria-label="Type"
                                                    id="gender_sd" name="gender" data-placeholder="Select Gender"
                                                    required>
                                                    <option disabled selected class="text-muted">Select Gender</option>
                                                    @foreach ($staticGender as $gender)
                                                        <option value="{{ $gender->id }}">{{ $gender->gender_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- <div class="custom-controls-stacked d-md-flex">
                                                        <label class="custom-control custom-radio me-4">
                                                            <input type="radio" class="custom-control-input"
                                                                name="gender" value="1" required>
                                                            <span class="custom-control-label">Male</span>
                                                        </label>
                                                        <label class="custom-control custom-radio me-4">
                                                            <input type="radio" class="custom-control-input"
                                                                name="gender" value="2" required>
                                                            <span class="custom-control-label">Female</span>
                                                        </label>
                                                        <label class="custom-control custom-radio me-4">
                                                            <input type="radio" class="custom-control-input"
                                                                name="gender" value="3" required>
                                                            <span class="custom-control-label">Other</span>
                                                        </label>
                                                    </div> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Marital Status</label>
                                                <select class="form-control" aria-label="Type" id="marital_status_dd"
                                                    name="marital_satatus_dd" required>
                                                    <option class="text-muted" label="Select Marital Status"></option>
                                                    {{-- class="form-control custom-select select2" data-placeholder="Select Country" --}}
                                                    {{-- <option value="">Select Marital Status</option> --}}
                                                    @foreach ($staticMarital as $martial)
                                                        <option value="{{ $martial->id }}">
                                                            {{ $martial->marital_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Category</label>
                                                <select class="form-control" aria-label="Type" name="caste_dd"
                                                    id="caste_dd" name="country" required>
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
                                                <select class="form-control" name="blood_group_dd" aria-label="Type"
                                                    id="blood_group_dd" name="country" required>
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
                                                <select class="form-control" aria-label="Type" id="select_id_dd"
                                                    onchange="selectGovId(this)" name="select_id_dd" name="country"
                                                    required>
                                                    <option value="">Select Any Goverment Id</option>
                                                    @foreach ($staticGovId as $govId)
                                                        <option value="{{ $govId->id }}">{{ $govId->govt_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Id Number</label>
                                                <input type="text" class="form-control" id="id_number_dd"
                                                    name="id_number_dd" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="step-11" class="" style="height: 448px">
                                    <h4 class="mb-2 font-weight-bold">Communication Details</h4>
                                    <div class="form-group">
                                        <div class="row pt-5">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Nationality</label>
                                                <input type="text" class="form-control" id="nationality_dd"
                                                    name="nationality_dd" required>
                                                {{-- <select class="form-control" name="nationality_dd"
                                                        aria-label="Type" id="nationality_dd" required>
                                                        <option value="">Select Nationality</option>
                                                        <option value="1">India</option>
                                                        <option value="2">USA</option>
                                                    </select> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Country</label>
                                                <select class="form-control" aria-label="Type" id="empCountryId"
                                                    name="country_dd" required>
                                                    <option value="">Select Country</option>
                                                    @foreach ($getCountry as $country)
                                                        <option value="{{ $country->id }}" selected>
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                    {{-- <option value="2">USA</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">State</label>
                                                <select id="empStateId" name="state_dd"
                                                    class="form-control w-100 border rounded" required></select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">City</label>
                                                <select id="empCityID" name="city_dd"
                                                    class="state1 form-control w-100 border rounded" required></select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Pin Code</label>
                                                <input id="pincode_dd" type="text" class="form-control"
                                                    placeholder="Postal PIN" name="pincode_dd">
                                            </div>
                                            <div class="col-md-12 col-xl-12">
                                                <label class="form-label mb-0 mt-2">Address Line 1</label>
                                                <textarea id="address_dd" type="text" class="form-control" placeholder="Address" name="address_dd"
                                                    cols="30" rows="2" required></textarea>
                                                {{-- <input id="address_sd" type="text" class="form-control"
                                                        placeholder="Address" name="address"> --}}
                                            </div>

                                        </div>
                                    </div>
                                    {{-- <div class="form-group mt-7">
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
                                        </div> --}}

                                </div>
                                <div id="step-12" class="" style="height: 448px">
                                    <h4 class="mb-2 font-weight-bold">Comapany Details</h4>
                                    <div class="form-group mb-0 justify-content-end">
                                        <div class="row pt-5">
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                <input type="date" class="form-control fc-datepicker"
                                                    id="doj_dd" placeholder="DD-MM-YYYY" name="doj" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Employee ID <a
                                                        id="fetchEmpId-data-button"
                                                        class="p-0 btn btn-primary btn-sm">EmpId
                                                        A.I.</a></label>
                                                <input name="emp_id" id="emp_id_sd" type="text"
                                                    class="emp_id_dd form-control"
                                                    placeholder="Employee ID Like: <?= $EmpID->model_id != null ? $EmpID->model_id : 'not create module' ?>"
                                                    value="" required>
                                                <p id="empIdAlready"></p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Select Shift Type</label>
                                                <select name="shift_type_name" id="shift_type_sd"
                                                    class="form-control" required>
                                                    <option value="">Select Shift Type</option>
                                                    {{-- @foreach ($shiftAttendance as $shiftset)
                                                        <option value="{{ $shiftset->attendance_id }}">
                                                            {{ $shiftset->shift_type_name }} |
                                                            {{ $shiftset->static_attendance_shift_type_name }}</option>
                                                    @endforeach --}}

                                                </select>

                                            </div>

                                            <div class="col-md-4 d-none" id="checkRotationalTypeItem">
                                                <label class="form-label mb-0 mt-2">Select Rotational Type</label>
                                                <select id="rotational_type_id" name="rotational_type_name"
                                                    class="form-control" required>
                                                    <option value="">Select Rotational Type</option>
                                                    {{-- @foreach ($Department as $data)
                                                        <option value="{{ $data->depart_id }}">
                                                            {{ $data->depart_name }}
                                                        </option>
                                                        @endforeach --}}
                                                </select>

                                                {{-- <select name="update_shift_type" id="shift_type_sd"
                                                        aria-label="Type"
                                                        class="update_shifttype_sddd form-control custom-select"
                                                        data-placeholder="Select Type">
                                                        <option value="">Select Rotational Type</option>
                                                        @foreach ($shiftAttendance as $shiftset)
                                                        <option value="{{ $shiftset->attendance_id }}">
                                                            {{ $shiftset->shift_type_name }}</option>
                                                        @endforeach
                                                    </select> --}}
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <p class="form-label">Branch</p>
                                                    <select name='branch_id1' id="country-dd1" class="form-control"
                                                        required>
                                                        <option value="">Select Branch Name</option>
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
                                                        <select id="state-dd1" name="department_id1"
                                                            class="form-control" required>
                                                            <option value="">Select Department Name</option>
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
                                                        <select id="desig-dd1" name="designation_id1"
                                                            class="form-control" required>
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
                                                <select name="attendance_method" aria-label="Type" id="attendance_sd"
                                                    class="form-control custom-select" required>
                                                    <option label="Select Type" value="">Select Attendence Mark
                                                        Type
                                                    </option>
                                                    @foreach ($attendanceMethod as $assign_attendance)
                                                        <option value="{{ $assign_attendance->id }}">
                                                            {{ $assign_attendance->method_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Reporting Manager</label>
                                                <input type="text" name="reporting_manager_dd"
                                                    id="reporting_manager_dd" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label mb-0 mt-2">Assign Setup</label>
                                                <select name="assign_setup" aria-label="Type" id="assign_setup"
                                                    class="form-control custom-select" required>
                                                    <option label="Select Type" value="">Select Assign Setup
                                                    </option>
                                                    @foreach ($setupAssociated as $assign_setup)
                                                        <option value="{{ $assign_setup->id }}">
                                                            {{ $assign_setup->method_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="custom-control mt-5 custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="example-checkbox1" value="option1">
                                                    <span class="custom-control-label"><b>Send SMS
                                                            Employee</b></span>
                                                    <span class="fs-11">By continuing you agree to <b><a
                                                                href="#" class="text-primary">Tearm &
                                                                Conditions</a></b>
                                                    </span>
                                                </label>

                                                </select>
                                            </div>

                                            {{-- <div class="col-sm-12">
                                                </div> --}}
                                        </div>
                                        {{-- <div class="form-group"> --}}
                                        {{-- <div class="row"> --}}
                                        {{-- <div class="col-md-9">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="example-checkbox1" value="option1">
                                                            <span class="custom-control-label"><b>Send SMS
                                                                    Employee</b></span>
                                                            <span class="fs-11">By continuing you agree to <b><a
                                                                        href="#" class="text-primary">Tearm &
                                                                        Conditions</a></b>
                                                            </span>
                                                        </label>
                                                    </div> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- END LARGE MODAL -->

{{--
</div> --}}
