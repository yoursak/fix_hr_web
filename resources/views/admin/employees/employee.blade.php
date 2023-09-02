@extends('admin.layout.master')
@section('title')
    Employee
@endsection

@section('css')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: center;
        }

        .top {
            padding: 10px;
        }

        th {
            text-align: center;
        }

        /* Aman Sir */
        .animatedBtn {
            position: relative;
            animation-name: example;
            animation-duration: 200ms;
        }

        @keyframes example {
            0% {
                left: 10px;
            }

            100% {
                left: 0px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

@section('contents')

    <div class="container-fluid">
        <!-- ROW -->
        @php
            $Employee = App\Helpers\Central_unit::EmployeeDetails();
            $Branch = App\Helpers\Central_unit::BranchList();
            $Department = App\Helpers\Central_unit::DepartmentList();
            $Designation = App\Helpers\Central_unit::DesignationList();
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
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Employees</span>
                                    <h3 class="mb-0 mt-1 text-success">{{ $i }}</h3>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Male Employees</span>
                                    <h3 class="mb-0 mt-1 text-primary">{{ $male }}</h3>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Female
                                        Employees</span>
                                    <h3 class="mb-0 mt-1 text-secondary">{{ $female }}</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i
                                        class="las la-female"></i> </div>
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
                                <div class="icon1 bg-danger-transparent my-auto  float-end"> <i
                                        class="las la-user-friends"></i> </div>
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
                                    <a class="modal-effect btn btn-outline-primary border-0 my-auto"
                                        data-effect="effect-scale" data-bs-toggle="modal" href="#empType">Add New
                                        Employee</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Branch:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Select Branch">
                                        @foreach ($Branch as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Department:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Select Department">
                                        @foreach ($Department as $depart)
                                            <option value="{{ $depart->depart_id }}">
                                                {{ $depart->depart_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Designation:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Select Designation">
                                        @foreach ($Designation as $designation)
                                            <option value="{{ $designation->desig_id }}">
                                                {{ $designation->desig_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Employee:</label>
                                    <input type="search" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                        </div>
                    </div>

                    <div class="card-body ant-table" style="padding:0px">
                        <div class="table-responsive" style="text-align: center;">
                            <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Employee Name</th>
                                        <th class="border-bottom-0">Employee ID</th>
                                        <th class="border-bottom-0">Department</th>
                                        <th class="border-bottom-0">Designation</th>
                                        <th class="border-bottom-0">Joining Date</th>
                                        <th class="border-bottom-0">Phone Number</th>
                                        <th class="border-bottom-0">Action</th>

                                    </tr>
                                </thead>
                                <tbody style="padding: 0px;">
                                    @foreach ($Employee as $item)
                                        <tr>
                                            <td style="text-align: center">
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3"
                                                        style="background-image: url()"></span>
                                                    <div class="my-auto">
                                                        <h6 class="mb-1 fs-14 my-auto"><a
                                                                href="{{ route('employeeProfile', ['id' => $item->emp_id]) }}">{{ $item->emp_name }}</a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->emp_id }}</td>
                                            <td>{{ $item->desig_name }}</td>
                                            <td>{{ $item->depart_name }}</td>
                                            <td>{{ $item->emp_date_of_joining }}</td>
                                            <td>{{ $item->emp_mobile_number }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div id="actionBtn{{ $item->emp_id }}" class="d-none">
                                                        <a href="javascript:void(0);" class="action-btns1 "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateempmodal{{ $item->emp_id }}">
                                                            <i class="feather feather-edit secondary text-secondary"
                                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="action-btns"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletemodal{{ $item->emp_id }}">
                                                            <i class="feather feather-trash danger text-danger"
                                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                                        </a>
                                                    </div>

                                                    <div class="ms-auto"><i id="{{ $item->emp_id }}"
                                                            onclick="moreFunc(this.id)"
                                                            class="btn si si-options-vertical ms-auto"></i>
                                                    </div>
                                                </div>

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
    </div>

    {{-- add regular employee --}}
    <div class="modal fade" id="addempmodal" data-bs-backdrop="static">
        <form action="{{ route('add.employee') }}" method="post">
            @csrf
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <h3 class="card-title">Add Regular Employee</h3>
                                <div class="tab-menu-heading hremp-tabs p-0 ">
                                    <div class="tabs-menu1">
                                        <ul class="nav panel-tabs">
                                            <li class="ms-4"><a href="#tab5" class="active"
                                                    data-bs-toggle="tab">Personal
                                                    Details</a></li>
                                            <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body hremp-tabs1 p-0"
                                    style="height: 32rem; overflow:scroll">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="card-body">
                                                <h4 class="mb-2 font-weight-bold">Basic</h4>
                                                {{-- <div class="form-group d-flex justify-content-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="file" name="image" class="dropify"
                                                                data-height="180" />
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="form-label mb-0 mt-2">Employee Type</label>
                                                            <select class="form-select" aria-label="Type"
                                                                name="employee_type" required>
                                                                <option selected>Employee Type</option>
                                                                <option value="1">Regular</option>
                                                                <option value="2">Contractual</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">First Name</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="text"
                                                                        class="form-control mb-md-0 mb-5"
                                                                        placeholder="First Name" name="name" required>
                                                                    <span class="text-muted"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Middle Name</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="text"
                                                                        class="form-control mb-md-0 mb-5"
                                                                        placeholder="Middle Name" name="mName">
                                                                    <span class="text-muted"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Last Name</label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="text"
                                                                        class="form-control mb-md-0 mb-5"
                                                                        placeholder="Last Name" name="lName">
                                                                    <span class="text-muted"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Contact Number</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Phone Number" name="mobile_number" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Email</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="email" name="email" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                            <input type="date" class="form-control fc-datepicker"
                                                                placeholder="DD-MM-YYY" name="dob" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Gender</label>
                                                            <div class="custom-controls-stacked d-md-flex">
                                                                <label class="custom-control custom-radio me-4">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="gender" value="1">
                                                                    <span class="custom-control-label">Male</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="gender" value="2">
                                                                    <span class="custom-control-label">Female</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="gender" value="3">
                                                                    <span class="custom-control-label">Other</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Pin Code</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Postal PIN" name="pincode" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Country</label>
                                                            <select class="form-select" aria-label="Type" name="country"
                                                                required>
                                                                <option selected>Select Country</option>
                                                                <option value="1">India</option>
                                                                <option value="2">USA</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">State</label>
                                                            <select onchange="print_city('state1', this.selectedIndex);"
                                                                id="sts1" name="state" style="height:50px"
                                                                name="stt" class="form-control w-100 border rounded"
                                                                required></select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">City</label>
                                                            <select id="state1" name="city"
                                                                class="form-control w-100 border rounded"
                                                                style="height:50px" required></select>
                                                            <script language="javascript">
                                                                print_state("sts1");
                                                            </script>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="form-label mb-0 mt-2">Address Line 1</label>
                                                            <input type="text" class="form-control" placeholder="Address" name="address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label mb-0 mt-2">Employee ID</label>
                                                            <input name="emp_id" type="text" class="form-control"
                                                                placeholder="Employee ID" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label mb-0 mt-2">Select Shift</label>
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select Type">
                                                                <option label="Select Type"></option>
                                                                <option value="0">Assigned</option>
                                                                <option value="1">Not Assigned</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Branch</label>
                                                            <select class="form-select" aria-label="Type" name="branch"
                                                                required>
                                                                @foreach ($Branch as $branch)
                                                                    <option value="{{ $branch->branch_id }}">
                                                                        {{ $branch->branch_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Department</label>
                                                            <select class="form-select" aria-label="Type"
                                                            name="department" required>
                                                            <label class="form-label mb-0 mt-2">Department</label>
                                                                @foreach ($Department as $depart)
                                                                    <option value="{{ $depart->depart_id }}">
                                                                        {{ $depart->depart_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Designation</label>
                                                            <select class="form-select" aria-label="Type"
                                                                name="designation" required>
                                                                @foreach ($Designation as $designation)
                                                                    <option value="{{ $designation->desig_id }}">
                                                                        {{ $designation->desig_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label mb-0 mt-2">Date Of Joining</label>
                                                            <input type="date" class="form-control fc-datepicker"
                                                                placeholder="DD-MM-YYYY" name="doj" required>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group mt-7">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label class="form-label">Manual Attendance with Location, FaceId And QR Code:</label>
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
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="example-checkbox1" value="option1" checked>
                                                                <span class="custom-control-label"><b>Send SMS
                                                                        Employee</b></span>
                                                                <span class="fs-11">By continuing you agree to <b><a
                                                                            href="#" class="text-primary">Tearm &
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
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    {{-- add employee --}}

    {{-- Update regular employee --}}
    @foreach ($Employee as $emp)
        <div class="modal fade" id="updateempmodal{{ $emp->emp_id }}" data-bs-backdrop="static">
            <form action="{{ route('update.employee') }}" method="POST">
                @csrf
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-body" style="5rem">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <h3 class="card-title">Add Regular Employee</h3>
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
                                                                        placeholder="Country"
                                                                        value="{{ $emp->emp_country }}" name="country">
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
                                                                    placeholder="State"
                                                                    value="{{ $emp->emp_state }}" name="state">
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
                                                                    placeholder="City"
                                                                    value="{{ $emp->emp_city }}" name="city">
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
                                                                    value="{{ $emp->emp_id }}"
                                                                    placeholder="Employee ID" disable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Branch</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select class="form-select" aria-label="Type"
                                                                    name="branch">
                                                                    @foreach ($Branch as $branch)
                                                                        <option value="{{ $branch->branch_id }}" selected>{{ $branch->branch_name }}</option>
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
                                                                    @foreach ($Designation as $designation)
                                                                        <option value="{{ $designation->desig_id }}" selected>
                                                                            {{ $designation->desig_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                {{-- @dd($Designation); --}}
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
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-0 mt-2">Select Shift</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <select name="projects"
                                                                    class="form-control custom-select select2"
                                                                    data-placeholder="Select Type">
                                                                    <option label="Select Type"></option>
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
    @endforeach
    {{-- delete confirmation --}}

    {{-- Employee Type --}}
    <div class="modal fade" id="empType">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5>Add Employee</h5>
                </div>
                <div class="modal-body d-flex justify-content-around">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <div>
                                <h3><b style="color: rgb(22, 109, 83)">Add New Employee</b></h3>
                                <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic, HRA, PF,
                                    ESI, etc.)</p>
                            </div>
                            <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="#addempmodal"><b>Add Employee</b></a>
                            <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Employee Type --}}

    <script></script>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        new DataTable('#example10', {
            dom: '<"top"lfB>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        });
    </script>
    {{-- AmanSir --}}
    <script>
        function moreFunc(e) {
            console.log(e);
            document.getElementById('actionBtn' + e).classList.toggle("d-none");
            document.getElementById('actionBtn' + e).classList.toggle("animatedBtn");
        }
    </script>
@endsection
