    @extends('admin.pagelayout.master')

    @section('title')
        Employee
    @endsection

    @section('css')
        <style>
            th {
                text-align: center;
            }

            /* Aman Sir */
            .animatedBtn,
            #moreBtn {
                position: relative;
                animation-name: example;
                animation-duration: 200ms;
            }

            @keyframes example {
                0% {
                    left: 30px;
                    top: 0px;
                }

                100% {
                    left: 0px;
                    top: 0px;
                }
            }
        </style>
    @endsection
    @section('js')
        <!-- INTERNAL FORM-WIZARD JS -->
        <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js') }}"></script>
        <script src="{{ asset('assets/plugins/formwizard/fromwizard.js') }}"></script>
        <!-- INTERNAl JQUERY STEPS JS -->
        <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

        <!-- INTERNAL FORM-WIZARD JS -->
        <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js') }}"></script>
        <script src="{{ asset('assets/plugins/formwizard/fromwizard.js') }}"></script>

        <!-- INTERNAL ACCORDION-WIZARD JS -->
        <script src="{{ asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
        <script src="{{ asset('assets/js/form-wizard.js') }}"></script>

        {{-- <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables.js') }}"></script>
        <script src="{{ asset('assets/js/select2.js') }}"></script>
        <script src="{{ asset('assets/js/hr/hr-emp.js') }}"></script>


        {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    @endsection
    @section('content')
        @foreach ($data as $item)
            @php
                $centralUnit = new App\Helpers\Central_unit();
                $loaded = new App\Helpers\Layout(); // Create an instance of the Central_unit class
                $BranchName = $loaded->BranchName($item->branch_id);
                // dd($BranchName);
                $DepartmentName = $loaded->DepartmentName($item->department_id);
                // dd($DepartmentName);
                $DesignationName = $loaded->DasignationName($item->designation_id);
                // dd($DesignationName);
                $BranchList = $centralUnit->BranchList();
                // dd($BrachList);
                $DepartmentList = $centralUnit->DepartmentList();
                // dd($DepartmentList);
                $DesignationList = $centralUnit->DesignationList();
                // dd($DesignationList);
                // DesignationList
            @endphp
        @endforeach
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
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                {{-- <li><a href="{{ url('/admin/requests/gatepass') }}">Request</a></li>    --}}
                {{-- <li><a href="javascript:void(0);">Elements</a></li> --}}
                <li class="active"><span><b>Leave</b></span></li>
            </ol>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Employees</span>
                                    <h3 class="mb-0 mt-1 text-success">12/60</h3>
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
                                    <h3 class="mb-0 mt-1 text-primary">8</h3>
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
                                <div class="mt-0 text-start"> <span class="font-weight-semibold">Female Employees</span>
                                    <h3 class="mb-0 mt-1 text-secondary">0</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i
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
                                    <h3 class="mb-0 mt-1 text-danger">12</h3>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="icon1 bg-danger-transparent my-auto  float-end"> <i
                                        class="las la-user-friends"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->


        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <div class="container-fluid">
            {{-- <!-- ROW -->
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <div class="mt-0 text-start"> <span class="font-weight-semibold">Total Employees</span>
                                        <h3 class="mb-0 mt-1 text-success">5,678</h3>
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
                                        <h3 class="mb-0 mt-1 text-primary">3,876</h3>
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
                                        <h3 class="mb-0 mt-1 text-secondary">1,396</h3>
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
            <!-- END ROW --> --}}

            <!-- ROW -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Employees List</h3>
                            <div class="page-rightheader ms-auto">
                                {{-- <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right"> --}}
                                {{-- <div class="btn-list d-flex"> --}}
                                <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                    data-bs-toggle="modal" href="#empType">Add New Employee</a>
                                {{-- </div> --}}
                                {{-- </div> --}}
                            </div>
                        </div>

                        <div class="card-body ">
                            <div class="row">

                                <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Branch</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Branch">
                                            <option label="Select Branch"></option>
                                            @foreach ($BranchList as $item)
                                                <option value="{{ $item }}">{{ $item->branch_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Department</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Department">
                                            <option label="Select Department"></option>
                                            @foreach ($DepartmentList as $item)
                                                <option value="1">{{ $item->depart_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Designation</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Designation">
                                            <option label="Select Designation"></option>
                                            @foreach ($DesignationList as $item)
                                                <option value="1">{{ $item->desig_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Employee Type</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Employee Type">
                                            <option label="Select Employee Type"></option>
                                            <option value="1">Regular Employee</option>
                                            <option value="2">Contractual Employee</option>

                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">From Date</label>
                                        <input type="date" class="form-control custom-select">
        
                                    </div>
                                </div>
        
                                <div class="col-sm-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">To Date</label>
                                        <input type="date" class="form-control custom-select">
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- ROW -->

                        <!-- END ROW -->
                        <div class="card-body p-2   ">
                            <div class="table-responsive">
                                <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                                    {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">S.No.</th>
                                            <th class="border-bottom-0">Employee Name</th>
                                            <th class="border-bottom-0">Employee Id</th>
                                            <th class="border-bottom-0">Department</th>
                                            <th class="border-bottom-0">Designation</th>
                                            <th class="border-bottom-0">Joining Date</th>
                                            <th class="border-bottom-0">Phone Number</th>
                                            {{-- <th class="border-bottom-0">Reason</th>
                                            <th class="border-bottom-0">Status</th> --}}
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>

                                </table>
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
                                            <option label="Select Branch"></option>
                                            <option value="1">Raipur</option>
                                            <option value="2">Gudgaon</option>
                                            <option value="3">Ludhiana</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Department:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Department">
                                            <option label="Select Department"></option>
                                            <option value="1">Faith Harris</option>
                                            <option value="2">Austin Bell</option>
                                            <option value="3">Maria Bower</option>
                                            <option value="4">Peter Hill</option>
                                            <option value="5">Victoria Lyman</option>
                                            <option value="6">Adam Quinn</option>
                                            <option value="7">Melanie Coleman</option>
                                            <option value="8">Max Wilson</option>
                                            <option value="9">Amelia Russell</option>
                                            <option value="10">Justin Metcalfe</option>
                                            <option value="11">Ryan Young</option>
                                            <option value="12">Jennifer Hardacre</option>
                                            <option value="13">Justin Parr</option>
                                            <option value="14">Julia Hodges</option>
                                            <option value="15">Michael Sutherland</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Designation:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Designation">
                                            <option label="Select Designation"></option>
                                            <option value="1">Faith Harris</option>
                                            <option value="2">Austin Bell</option>
                                            <option value="3">Maria Bower</option>
                                            <option value="4">Peter Hill</option>
                                            <option value="5">Victoria Lyman</option>
                                            <option value="6">Adam Quinn</option>
                                            <option value="7">Melanie Coleman</option>
                                            <option value="8">Max Wilson</option>
                                            <option value="9">Amelia Russell</option>
                                            <option value="10">Justin Metcalfe</option>
                                            <option value="11">Ryan Young</option>
                                            <option value="12">Jennifer Hardacre</option>
                                            <option value="13">Justin Parr</option>
                                            <option value="14">Julia Hodges</option>
                                            <option value="15">Michael Sutherland</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2">
                                    <div class="form-group">
                                        <label class="form-label">Employee:</label>
                                        <input type="search" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2 m-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-primary btn-sm">Copy</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">CSV</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">Excel</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">PDF</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm">Print</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                            </div>
                        </div>
                        <div class="card-body ant-table" style="padding:0px">
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%"
                                    data-order="[[ 1, &quot;asc&quot; ]]">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0 text-center">Employee Name</th>
                                            <th class="border-bottom-0 text-center">Employee ID</th>
                                            <th class="border-bottom-0 text-center">Department</th>
                                            <th class="border-bottom-0 text-center">Designation</th>
                                            <th class="border-bottom-0 text-center">Joining Date</th>
                                            <th class="border-bottom-0 text-center">Phone Number</th>
                                            <th class="border-bottom-0 text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody style="padding: 0px;">
                                        <tr>
                                            <td style="text-align: center">
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3"
                                                        style="background-image: url()"></span>
                                                    <div class="my-auto">
                                                        <h6 class="mb-1 fs-14 my-auto"><a
                                                                href="{{ url('/emprofile') }}">Aman
                                                                Sahu</a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>FD2987</td>
                                            <td>Designing Department</td>
                                            <td>Web Designer</td>
                                            <td>05-05-2017</td>
                                            <td>+9685321475</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div id="actionBtn1" class="d-none">
                                                        <a href="javascript:void(0);" class="action-btns1 "
                                                            data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                            <i class="feather feather-edit secondary text-secondary"
                                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="action-btns1"
                                                            data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                            <i class="feather feather-trash danger text-danger"
                                                                data-bs-toggle="tooltip" data-original-title="View"></i>
                                                        </a>
                                                    </div>

                                                    <div class="toggle-effect ms-auto" data-bs-toggle="modal"
                                                        data-bs-traget=""> <a class="open-toggle" href="#"> <i
                                                                id="moreBtn" class="si si-options-vertical"></i></a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

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
    <div class="modal fade" id="addCotractEmp" data-bs-backdrop="static">
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
                                                        {{-- <div class="col-md-12">
                                                            <label class="form-label mb-0 mt-2">Employee Type</label>
                                                            <select class="form-select" aria-label="Type"
                                                                name="employee_type" required>
                                                                <option selected>Employee Type</option>
                                                                <option value="1">Regular</option>
                                                                <option value="2">Contractual</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-md-12 text-center">
                                                            <label for="inputPassword4" class="form-label">Upload Empoyee Image</label>
                                                            
                                                            {{-- <input type="dropy"> --}}
                                                            <img class="avatar avatar-xxl brround rounded-circle border" id="output" height="30px" width="40px"/>
                                                            <br/>
        
                                                            <input type="file" accept="image/*" onchange="loadFile(event)">
                                                            {{-- <input type="form-check-input" type="checkbox" class="form-control" id=""> --}}
                                                        </div>
        
                                                        <script>
                                                            var loadFile = function(event) {
                                                                var output = document.getElementById('output');
                                                                output.src = URL.createObjectURL(event.target.files[0]);
                                                                output.onload = function() {
                                                                    URL.revokeObjectURL(output.src) // free memory
                                                                }
                                                            };
                                                        </script>
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
                                                            <input type="text" class="form-control"
                                                                placeholder="Address" name="address">
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
                                                            <label class="form-label">Manual Attendance with Location,
                                                                FaceId And QR Code:</label>
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

        {{-- add contractual Emp --}}
        <div class="modal fade" id="addCotractEmp" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    {{-- <div class="modal-header border-0">
                        <div>
                            <h4>Add Contractual Employee</h4>
                        </div>
                    </div> --}}

                    <div class="modal-header">
                        <h5>Add Contractual Employee</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" style="5rem">
                        {{-- <!-- ROW OPEN -->
                      <div class="row ">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <div class="card-title">
                                        Basic Wizard With Validation
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="wizard2">
                                        <h3>Personal Information</h3>
                                        <section>
                                            <div class="row ">
                                                <div class="col-md-5 col-lg-4">
                                                    <label class="form-control-label">Firstname: <span
                                                            class="tx-danger">*</span></label> <input
                                                        class="form-control" id="firstname" name="firstname"
                                                        placeholder="Enter firstname" required=""
                                                        type="text">
                                                </div>
                                                <div class="col-md-5 col-lg-4 mg-t-20 mg-md-t-0">
                                                    <label class="form-control-label">Lastname: <span
                                                            class="tx-danger">*</span></label> <input
                                                        class="form-control" id="lastname" name="lastname"
                                                        placeholder="Enter lastname" required=""
                                                        type="text">
                                                </div>
                                            </div>
                                        </section>
                                        <h3>Billing Information</h3>
                                        <section>
                                            <p>Wonderful transition effects.</p>
                                            <div class="form-group wd-xs-300">
                                                <label class="form-control-label">Email: <span
                                                        class="tx-danger">*</span></label> <input
                                                    class="form-control" id="email" name="email"
                                                    placeholder="Enter email address" required=""
                                                    type="email">
                                            </div>
                                        </section>
                                        <h3>Payment Details</h3>
                                        <section>
                                            <div class="form-group">
                                                <label class="form-label">CardHolder Name</label>
                                                <input type="text" class="form-control" id="name11"
                                                    placeholder="First Name">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Card number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Search for...">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-info"><i
                                                                class="fa fa-cc-visa"></i> &nbsp; <i
                                                                class="fa fa-cc-amex"></i> &nbsp;
                                                            <i class="fa fa-cc-mastercard"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group mb-sm-0">
                                                        <label class="form-label">Expiration</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                placeholder="MM" name="expiremonth">
                                                            <input type="number" class="form-control"
                                                                placeholder="YY" name="expireyear">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 ">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">CVV <i
                                                                class="fa fa-question-circle"></i></label>
                                                        <input type="number" class="form-control"
                                                            required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ROW CLOSED --> --}}

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <h3 class="card-title">Add New Employee</h3>
                                <div class="tab-menu-heading hremp-tabs p-0 ">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="ms-4"><a href="#tab5" class="active"
                                                    data-bs-toggle="tab">Personal
                                                    Details</a></li>
                                            <li><a href="#tab6" data-bs-target="tab6" data-bs-toggle="tab">Company
                                                    Details</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body hremp-tabs1 p-0"
                                    style="height: 30rem; overflow:scroll">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="card-body">
                                                <h4 class="mb-4 font-weight-bold">Basic</h4>
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="file" class="dropify" data-height="180" />
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
                                                                        placeholder="First Name">
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
                                                                placeholder="Phone Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Alternative Contact
                                                                Number</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Contact Number01">
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
                                                                placeholder="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control fc-datepicker"
                                                                placeholder="DD-MM-YYY">
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
                                                                <label class="custom-control custom-radio me-4">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="example-radios4" value="option1">
                                                                    <span class="custom-control-label">Male</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="example-radios4" value="option2">
                                                                    <span class="custom-control-label">Female</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="example-radios4" value="option2">
                                                                    <span class="custom-control-label">Other</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Address</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea rows="3" class="form-control" placeholder="Address2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-7">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label class="form-label">Manual Attendance with Location, Face
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
                                        <div class="tab-pane" id="tab6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Employee ID</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="#ID">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Branch</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">IT</option>
                                                                <option value="2">Management</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Department</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">Software Developer</option>
                                                                <option value="2">Web Developer</option>
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
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">Software Developer</option>
                                                                <option value="2">Web Developer</option>
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
                                                            <input type="text" class="form-control fc-datepicker"
                                                                placeholder="DD-MM-YYYY">
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="mb-5 mt-7 font-weight-bold">Salary</h4>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Type</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select Type">
                                                                <option label="Select Type"></option>
                                                                <option value="0">Full-Time</option>
                                                                <option value="1">Part-Time</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Salary</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="$Salary">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Salary Cycle:</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="date" class="form-control"
                                                                placeholder="$Salary">
                                                        </div>
                                                    </div>
                                                </div>
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
                                    <a href="javascript:void(0);" class="btn btn-primary"
                                        data-bs-dismiss="modal">Save</a>
                                    <a href="javascript:void(0);" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- add contractual Emp --}}


        {{-- add regular employee --}}
        <div class="modal fade" id="addempmodal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body" style="5rem">
                        <div class="row">
                            <div class="modal-header">
                                <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Add Regular Employee</h5>
                                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                        </button> --}}
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            {{-- <div class="col-xl-12 col-md-12 col-lg-12">
                                <h3 class="card-title">Add Regular Employee</h3>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">&times;</span></button>
                            </div> --}}
                            <div class="tab-menu-heading hremp-tabs p-0 ">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class="ms-4"><a href="#tab5" class="active"
                                                data-bs-toggle="tab">Personal
                                                Details</a></li>
                                        <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body hremp-tabs1 p-0" style="height: 30rem; overflow:scroll">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab5">
                                        <div class="card-body">
                                            <form class="row g-3">
                                                <div class="col-md-12 text-center">
                                                    <label for="inputPassword4" class="form-label">Upload Empoyee Image</label>
                                                    
                                                    {{-- <input type="dropy"> --}}
                                                    <img class="avatar avatar-xxl brround rounded-circle border" id="output" height="30px" width="40px"/>
                                                    <br/>

                                                    <input type="file" accept="image/*" onchange="loadFile(event)">
                                                    {{-- <input type="form-check-input" type="checkbox" class="form-control" id=""> --}}
                                                </div>

                                                <script>
                                                    var loadFile = function(event) {
                                                        var output = document.getElementById('output');
                                                        output.src = URL.createObjectURL(event.target.files[0]);
                                                        output.onload = function() {
                                                            URL.revokeObjectURL(output.src) // free memory
                                                        }
                                                    };
                                                </script>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="inputEmail4">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Middile Name</label>
                                                    <input type="text" class="form-control" id="inputPassword4">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="inputPassword4">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Contact Number</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Alternative Contact
                                                        Number</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="inputPassword4">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" id="">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Gender</label>
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Male
                                                    </label>
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Female
                                                    </label>
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Other
                                                    </label>
                                                    {{-- <input type="form-check-input" type="checkbox" class="form-control" id=""> --}}
                                                </div>
                                               
                                                <div class="col-12">
                                                    <label for="inputAddress" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="inputAddress"
                                                        placeholder="1234 Main St">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="inputCity" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="inputCity">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputState" class="form-label">State</label>
                                                    <select id="inputState" class="form-select">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="inputZip" class="form-label">Zip</label>
                                                    <input type="text" class="form-control" id="inputZip">
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="gridCheck">
                                                        <label class="form-check-label" for="gridCheck">
                                                            Check me out
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- <div class="card-body">
                                            <h4 class="mb-4 font-weight-bold">Basic</h4>
                                            <div class="form-group d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="file" class="dropify" data-height="180" />
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
                                                                <input type="text" class="form-control mb-md-0 mb-5"
                                                                    placeholder="First Name">
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
                                                            placeholder="Phone Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Alternative Contact
                                                            Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Contact Number01">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control fc-datepicker"
                                                            placeholder="DD-MM-YYY">
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
                                                            <label class="custom-control custom-radio me-4">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="example-radios4" value="option1">
                                                                <span class="custom-control-label">Male</span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="example-radios4" value="option2">
                                                                <span class="custom-control-label">Female</span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="example-radios4" value="option2">
                                                                <span class="custom-control-label">Other</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Address</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea rows="3" class="form-control" placeholder="Address2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-7">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label class="form-label">Manual Attendance with Location, Face Id
                                                            And QR Code:</label>
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
                                        </div> --}}
                                    </div>
                                    <div class="tab-pane" id="tab6">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Employee ID</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="#ID">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Branch</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select">
                                                            <option label="Select"></option>
                                                            <option value="1">IT</option>
                                                            <option value="2">Management</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Department</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select">
                                                            <option label="Select"></option>
                                                            <option value="1">Software Developer</option>
                                                            <option value="2">Web Developer</option>
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
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select">
                                                            <option label="Select"></option>
                                                            <option value="1">Software Developer</option>
                                                            <option value="2">Web Developer</option>
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
                                                        <input type="text" class="form-control fc-datepicker"
                                                            placeholder="DD-MM-YYYY">
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="mb-5 mt-7 font-weight-bold">Salary</h4>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Type</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
                                                            data-placeholder="Select Type">
                                                            <option label="Select Type"></option>
                                                            <option value="0">Full-Time</option>
                                                            <option value="1">Part-Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Salary</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="$Salary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Salary Cycle:</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" class="form-control" placeholder="$Salary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-0 mt-2">Select Shift</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="projects" class="form-control custom-select select2"
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
                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-dismiss="modal">Save</a>
                                <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {{-- add employee --}}

        {{-- delete confirmation --}}
        <div class="modal fade" id="deletemodal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to delete ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button> <button
                            class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- delete confirmation --}}

        {{-- Employee Type --}}
        <div class="modal fade" id="empType" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h5>Add Employee</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{-- <div class="modal-header">
                        <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Leave Request</h5>
                    
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div> --}}
                    <div class="modal-body d-flex justify-content-around">

                        <div class="row">
                            <div class="col-xl-6 text-center">
                                <div>
                                    <h3><b style="color: rgb(22, 109, 83)">Regular Employee</b></h3>
                                    <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic, HRA,
                                        PF,
                                        ESI, etc.)</p>
                                </div>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#addempmodal"><b>Add Employee</b></a>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                            </div>
                            <div class="col-xl-6 text-center">
                                <div>
                                    <h3><b style="color: rgb(22, 109, 83)">Contractual Employee</b></h3>
                                    <p class="fs-11" style="color: rgb(29, 112, 64)">With Salary Components (Basic, HRA,
                                        PF,
                                        ESI, etc.)</p>
                                </div>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#addCotractEmp"><b>Add Employee</b></a>
                                <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Employee Type --}}

        {{-- online pay --}}
        <div class="modal fade" id="bulkOnlinePay">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body" style="5rem">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <h3 class="card-title">Add New Employee</h3>
                                <div class="tab-menu-heading hremp-tabs p-0 ">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class="ms-4"><a href="#tab5" class="active"
                                                    data-bs-toggle="tab">Personal
                                                    Details</a></li>
                                            <li><a href="#tab6" data-bs-toggle="tab">Company Details</a></li>
                                            <li><a href="#tab7" data-bs-toggle="tab">Bank Details</a></li>
                                            <li><a href="#tab8" data-bs-toggle="tab">Upload Documents</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body hremp-tabs1 p-0"
                                    style="height: 30rem; overflow:scroll">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="card-body">
                                                <h4 class="mb-4 font-weight-bold">Basic</h4>
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="file" class="dropify" data-height="180" />
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
                                                                <div class="col-md-6">
                                                                    <input type="text"
                                                                        class="form-control mb-md-0 mb-5" name="emp_name"
                                                                        placeholder="First Name">
                                                                    <span class="text-muted"></span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Last Name">
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
                                                            <input type="text" class="form-control" name="emp_number"
                                                                placeholder="Phone Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Alternative Contact
                                                                Number</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="emp_anumber"
                                                                placeholder="Contact Number01">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Email</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="emp_email"
                                                                placeholder="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control fc-datepicker"
                                                                name="dob" placeholder="DD-MM-YYY">
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
                                                                <label class="custom-control custom-radio me-4">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="example-radios4" value="option1">
                                                                    <span class="custom-control-label">Male</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        name="example-radios4" value="option2">
                                                                    <span class="custom-control-label">Female</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Address</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea rows="3" class="form-control" name="emp_address" placeholder="Address2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-7">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label class="form-label">Manual Attendance with Location, Face
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
                                        <div class="tab-pane" id="tab6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Employee ID</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="#ID">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Branch</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">IT</option>
                                                                <option value="2">Management</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Department</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">Software Developer</option>
                                                                <option value="2">Web Developer</option>
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
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select">
                                                                <option label="Select"></option>
                                                                <option value="1">Software Developer</option>
                                                                <option value="2">Web Developer</option>
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
                                                            <input type="text" class="form-control fc-datepicker"
                                                                placeholder="DD-MM-YYYY">
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="mb-5 mt-7 font-weight-bold">Salary</h4>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Type</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select Type">
                                                                <option label="Select Type"></option>
                                                                <option value="0">Full-Time</option>
                                                                <option value="1">Part-Time</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Salary</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="$Salary">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Salary Cycle:</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="date" class="form-control"
                                                                placeholder="$Salary">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Opening Balance:</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="projects"
                                                                class="form-control custom-select select2"
                                                                data-placeholder="Select Type">
                                                                <option label="Select Type"></option>
                                                                <option value="0">Advance</option>
                                                                <option value="1">Pending</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <div class="form-group mt-7">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Allow Current Salary Cycle
                                                                Access:</label>
                                                        </div>
                                                        <div class="col-md-9">
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
                                                <div class="form-group mt-7">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Salary Detail Access:</label>
                                                        </div>
                                                        <div class="col-md-9">
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
                                        <div class="tab-pane" id="tab7">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Account Holder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Account Number</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Bank Name</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Branch Location</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Location">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Bank Code (IFSC)
                                                                <span class="form-help" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="Bank Identify Number in your Country">?</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="Code">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label mb-0 mt-2">Tax Payer ID (PAN)
                                                                <span class="form-help" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="Taxpayer Identification Number Used in your Country">?</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                placeholder="ID No">
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
                                                            <div class="form-label mb-0 mt-2">Resume</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-label mb-0 mt-2">ID Proof</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-label mb-0 mt-2">Offer Letter</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-label mb-0 mt-2">Joining Letter</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-label mb-0 mt-2">Agreement Letter</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-label mb-0 mt-2">Experience Letter</div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-label"></label>
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="javascript:void(0);" class="btn btn-primary"
                                        data-bs-dismiss="modal">Save</a>
                                    <a href="javascript:void(0);" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <body class="app sidebar-mini ltr">
                    <div class="app-content main-content">
                        <div class="side-app main-container">

                            <!-- PAGE HEADER -->
                            <div class="page-header d-lg-flex d-block">
                                <div class="page-leftheader">
                                    <div class="page-title">Form-Wizard</div>
                                </div>
                                <div class="page-rightheader ms-md-auto">
                                    <div class=" btn-list">
                                        <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="E-mail"> <i class="feather feather-mail"></i> </button>
                                        <button class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip"
                                            title="Contact"> <i class="feather feather-phone-call"></i> </button>
                                        <button class="btn btn-primary" data-bs-placement="top"
                                            data-bs-toggle="tooltip" title="Info"> <i
                                                class="feather feather-info"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE HEADER -->

                            <!-- ROW OPEN -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <h3 class="card-title">Form Wizard</h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="smartwizard-3">
                                                <ul>
                                                    <li><a href="#step-10">Login</a></li>
                                                    <li><a href="#step-11">New User</a></li>
                                                    <li><a href="#step-12">End</a></li>
                                                </ul>
                                                <div>
                                                    <div id="step-10" class="">
                                                        <form>
                                                            <div class="form-group">
                                                                <label>Email address</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleInputEmail6"
                                                                    placeholder="Enter email address">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="exampleInputPassword7" placeholder="Password">
                                                            </div>
                                                            <div class="form-group mb-0 justify-content-end">
                                                                <div class="">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            name="example-checkbox2" value="option2">
                                                                        <span class="custom-control-label">Check me
                                                                            Out</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="step-11" class="">
                                                        <form>
                                                            <div class="form-group">
                                                                <label>User Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="inputtext" placeholder="Enter User Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email address</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleInputEmail8"
                                                                    placeholder="Enter email address">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="exampleInputPassword9" placeholder="Password">
                                                            </div>
                                                            <div class="form-group mb-0 justify-content-end">
                                                                <div class="">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            name="example-checkbox2" value="option2">
                                                                        <span class="custom-control-label">Check me
                                                                            Out</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </form>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW CLOSED -->

                            <!-- ROW OPEN -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <h3 class="card-title">Accordion-Wizard-Form</h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form">
                                                <div class="list-group">
                                                    <div class="list-group-item" data-acc-step>
                                                        <h5 class="mb-0 d-flex" data-acc-title><span
                                                                class="form-wizard-title">Name &amp; Email</span></h5>
                                                        <div data-acc-content>
                                                            <div class="my-3">
                                                                <div class="form-group">
                                                                    <label>Name:</label>
                                                                    <input type="text" name="name"
                                                                        class="form-control" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email:</label>
                                                                    <input type="text" name="email"
                                                                        class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item" data-acc-step>
                                                        <h5 class="mb-0 d-flex" data-acc-title><span
                                                                class="form-wizard-title">Contact</span></h5>
                                                        <div data-acc-content>
                                                            <div class="my-3">
                                                                <div class="form-group">
                                                                    <label>Telephone:</label>
                                                                    <input type="text" name="telephone"
                                                                        class="form-control" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Mobile:</label>
                                                                    <input type="text" name="mobile"
                                                                        class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item" data-acc-step>
                                                        <h5 class="mb-0 d-flex" data-acc-title><span
                                                                class="form-wizard-title">Payment</span></h5>
                                                        <div data-acc-content>
                                                            <div class="my-3">
                                                                <div class="form-group">
                                                                    <label>Credit card:</label>
                                                                    <input type="text" name="card"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group form-row">
                                                                    <div class="col-sm-4">
                                                                        <label>Expiry:</label>
                                                                        <input type="text" name="expiry"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <label>CVV:</label>
                                                                        <input type="text" name="cvv"
                                                                            class="form-control">
                                                                    </div>
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
                            <!-- ROW CLOSED -->

                            <!-- ROW OPEN -->
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <div class="card-title">
                                                Basic Content Wizard
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="wizard1">
                                                <h3>Personal Information</h3>
                                                <section>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control required"
                                                            placeholder="Name">
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control required"
                                                            placeholder="Email Address">
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="number" class="form-control required"
                                                            placeholder="Number">
                                                    </div>
                                                    <div class="control-group form-group mb-0">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" class="form-control required"
                                                            placeholder="Address">
                                                    </div>
                                                </section>
                                                <h3>Billing Information</h3>
                                                <section>
                                                    <div class="table-responsive mg-t-20">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cart Subtotal</td>
                                                                    <td class="text-end">$792.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span>Totals</span></td>
                                                                    <td class="text-end text-muted"><span>$792.00</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span>Order Total</span></td>
                                                                    <td>
                                                                        <h2 class="price text-end mb-0">$792.00</h2>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                                <h3>Payment Details</h3>
                                                <section>
                                                    <div class="form-group">
                                                        <label class="form-label">CardHolder Name</label>
                                                        <input type="text" class="form-control" id="name1"
                                                            placeholder="First Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Card number</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Search for...">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-info"><i
                                                                        class="fa fa-cc-visa"></i> &nbsp; <i
                                                                        class="fa fa-cc-amex"></i> &nbsp;
                                                                    <i class="fa fa-cc-mastercard"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group mb-sm-0">
                                                                <label class="form-label">Expiration</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="MM" name="expiremonth">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="YY" name="expireyear">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                            <div class="form-group mb-0">
                                                                <label class="form-label">CVV <i
                                                                        class="fa fa-question-circle"></i></label>
                                                                <input type="number" class="form-control"
                                                                    required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW CLOSED -->

                            <!-- ROW OPEN -->
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <div class="card-title">
                                                Basic Wizard With Validation
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="wizard2">
                                                <h3>Personal Information</h3>
                                                <section>
                                                    <div class="row ">
                                                        <div class="col-md-5 col-lg-4">
                                                            <label class="form-control-label">Firstname: <span
                                                                    class="tx-danger">*</span></label> <input
                                                                class="form-control" id="firstname" name="firstname"
                                                                placeholder="Enter firstname" required=""
                                                                type="text">
                                                        </div>
                                                        <div class="col-md-5 col-lg-4 mg-t-20 mg-md-t-0">
                                                            <label class="form-control-label">Lastname: <span
                                                                    class="tx-danger">*</span></label> <input
                                                                class="form-control" id="lastname" name="lastname"
                                                                placeholder="Enter lastname" required=""
                                                                type="text">
                                                        </div>
                                                    </div>
                                                </section>
                                                <h3>Billing Information</h3>
                                                <section>
                                                    <p>Wonderful transition effects.</p>
                                                    <div class="form-group wd-xs-300">
                                                        <label class="form-control-label">Email: <span
                                                                class="tx-danger">*</span></label> <input
                                                            class="form-control" id="email" name="email"
                                                            placeholder="Enter email address" required=""
                                                            type="email">
                                                    </div>
                                                </section>
                                                <h3>Payment Details</h3>
                                                <section>
                                                    <div class="form-group">
                                                        <label class="form-label">CardHolder Name</label>
                                                        <input type="text" class="form-control" id="name11"
                                                            placeholder="First Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Card number</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Search for...">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-info"><i
                                                                        class="fa fa-cc-visa"></i> &nbsp; <i
                                                                        class="fa fa-cc-amex"></i> &nbsp;
                                                                    <i class="fa fa-cc-mastercard"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group mb-sm-0">
                                                                <label class="form-label">Expiration</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="MM" name="expiremonth">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="YY" name="expireyear">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                            <div class="form-group mb-0">
                                                                <label class="form-label">CVV <i
                                                                        class="fa fa-question-circle"></i></label>
                                                                <input type="number" class="form-control"
                                                                    required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW CLOSED -->

                            <!-- ROW OPEN -->
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header border-bottom-0">
                                            <div class="card-title">
                                                Vertical Orientation Wizard
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="wizard3">
                                                <h3>Personal Information</h3>
                                                <section>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control required"
                                                            placeholder="Name">
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control required"
                                                            placeholder="Email Address">
                                                    </div>
                                                    <div class="control-group form-group">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="number" class="form-control required"
                                                            placeholder="Number">
                                                    </div>
                                                    <div class="control-group form-group mb-0">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" class="form-control required"
                                                            placeholder="Address">
                                                    </div>
                                                </section>
                                                <h3>Billing Information</h3>
                                                <section>
                                                    <div class="table-responsive mg-t-20">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cart Subtotal</td>
                                                                    <td class="text-end">$792.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span>Totals</span></td>
                                                                    <td class="text-end text-muted"><span>$792.00</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span>Order Total</span></td>
                                                                    <td>
                                                                        <h2 class="price text-end mb-0">$792.00</h2>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                                <h3>Payment Details</h3>
                                                <section>
                                                    <div class="form-group">
                                                        <label class="form-label">CardHolder Name</label>
                                                        <input type="text" class="form-control" id="name12"
                                                            placeholder="First Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Card number</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Search for...">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-info"><i
                                                                        class="fa fa-cc-visa"></i> &nbsp; <i
                                                                        class="fa fa-cc-amex"></i> &nbsp;
                                                                    <i class="fa fa-cc-mastercard"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group mb-sm-0">
                                                                <label class="form-label">Expiration</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="MM" name="expiremonth">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="YY" name="expireyear">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                            <div class="form-group mb-0">
                                                                <label class="form-label">CVV <i
                                                                        class="fa fa-question-circle"></i></label>
                                                                <input type="number" class="form-control"
                                                                    required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW CLOSED -->

                        </div>
                    </div><!-- end app-content-->
                </div>

              




            </div>

            <!-- BACK TO TOP -->
            <a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

            <!-- JQUERY JS -->
            <script src="assets/plugins/jquery/jquery.min.js"></script>

            <!-- BOOTSTRAP JS -->
            <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
            <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

            <!-- MOMENT JS -->
            <script src="assets/plugins/moment/moment.js"></script>

            <!-- CIRCLE-PROGRESS JS -->
            <script src="assets/plugins/circle-progress/circle-progress.min.js"></script>

            <!--SIDEMENU JS -->
            <script src="assets/plugins/sidemenu/sidemenu.js"></script>

            <!-- P-SCROLL JS -->
            <script src="assets/plugins/p-scrollbar/p-scrollbar.js"></script>
            <script src="assets/plugins/p-scrollbar/p-scroll1.js"></script>

            <!--SIDEBAR JS -->
            <script src="assets/plugins/sidebar/sidebar.js"></script>

            <!-- SELECT2 JS -->
            <script src="assets/plugins/select2/select2.full.min.js"></script>

            <!-- INTERNAl JQUERY STEPS JS -->
            <script src="assets/plugins/jquery-steps/jquery.steps.min.js"></script>
            <script src="assets/plugins/parsleyjs/parsley.min.js"></script>

            <!-- INTERNAL FORM-WIZARD JS -->
            <script src="assets/plugins/formwizard/jquery.smartWizard.js"></script>
            <script src="assets/plugins/formwizard/fromwizard.js"></script>

            <!-- INTERNAL ACCORDION-WIZARD JS -->
            <script src="assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js"></script>
            <script src="assets/js/form-wizard.js"></script>

            <!-- STICKY JS -->
            <script src="assets/js/sticky.js"></script>

            <!-- COLOR THEME JS  -->
            <script src="assets/js/themeColors.js"></script>

            <!-- CUSTOM JS -->
            <script src="assets/js/custom.js"></script>

            <!-- SWITCHER JS -->
            <script src="assets/switcher/js/switcher.js"></script>

        </body> --}}
        {{-- online pay --}}
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script></script>
    @endsection

    @section('script')
        {{-- AmanSir --}}
        {{-- <script>
            $(document).ready(function() {
                // $('.feather-trash').on('click', function() {
                //     alert('hello');
                // });

                $('#moreBtn').on('click', function() {
                    $('#actionBtn1').toggleClass('d-none');
                    $('#actionBtn1').toggleClass('animatedBtn');

                });
            });
        </script> --}}

        {{-- <script>
            new DataTable('#example', {
                scrollX: true,
                responsive: true,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            let column = this;

                            // Create select element
                            let select = document.createElement('select');
                            select.add(new Option(''));
                            column.footer().replaceChildren(select);

                            // Apply listener for user change in value
                            select.addEventListener('change', function() {
                                var val = DataTable.util.escapeRegex(select.value);

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                            // Add list of options
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.add(new Option(d));
                                });
                        });
                }
            });
        </script> --}}
    @endsection
