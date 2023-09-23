@extends('admin.pagelayout.master')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
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
@endsection


@section('css')
@endsection
@section('content')
    <style>
        .nav-link.icon {
            line-height: 0;
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f8ff;
            /* color: #fff; */
        }

        .modal-open {
            overflow: hidden
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: .5rem;
            pointer-events: none
        }

        .modal.fade .modal-dialog {
            transition: -webkit-transform .3s ease-out;
            transition: transform .3s ease-out;
            transition: transform .3s ease-out, -webkit-transform .3s ease-out;
            -webkit-transform: translate(0, -50px);
            transform: translate(0, -50px)
        }

        @media (prefers-reduced-motion:reduce) {
            .modal.fade .modal-dialog {
                transition: none
            }
        }

        .modal.show .modal-dialog {
            -webkit-transform: none;
            transform: none
        }

        .modal.modal-static .modal-dialog {
            -webkit-transform: scale(1.02);
            transform: scale(1.02)
        }

        .modal-dialog-scrollable {
            display: -ms-flexbox;
            display: flex;
            max-height: calc(100% - 1rem)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 1rem);
            overflow: hidden
        }

        .modal-dialog-scrollable .modal-footer,
        .modal-dialog-scrollable .modal-header {
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto
        }

        .modal-dialog-centered {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            min-height: calc(100% - 1rem)
        }

        .modal-dialog-centered::before {
            display: block;
            height: calc(100vh - 1rem);
            height: -webkit-min-content;
            height: -moz-min-content;
            height: min-content;
            content: ""
        }

        .modal-dialog-centered.modal-dialog-scrollable {
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            height: 100%
        }

        .modal-dialog-centered.modal-dialog-scrollable .modal-content {
            max-height: none
        }

        .modal-dialog-centered.modal-dialog-scrollable::before {
            content: none
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: #000
        }

        .modal-backdrop.fade {
            opacity: 0
        }

        .modal-backdrop.show {
            opacity: .5
        }

        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: calc(.3rem - 1px);
            border-top-right-radius: calc(.3rem - 1px)
        }

        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem -1rem -1rem auto
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1rem
        }

        .modal-footer {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding: .75rem;
            border-top: 1px solid #dee2e6;
            border-bottom-right-radius: calc(.3rem - 1px);
            border-bottom-left-radius: calc(.3rem - 1px)
        }

        .modal-footer>* {
            margin: .25rem
        }

        .modal-scrollbar-measure {
            position: absolute;
            top: -9999px;
            width: 50px;
            height: 50px;
            overflow: scroll
        }

        @media (min-width:576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto
            }

            .modal-dialog-scrollable {
                max-height: calc(100% - 3.5rem)
            }

            .modal-dialog-scrollable .modal-content {
                max-height: calc(100vh - 3.5rem)
            }

            .modal-dialog-centered {
                min-height: calc(100% - 3.5rem)
            }

            .modal-dialog-centered::before {
                height: calc(100vh - 3.5rem);
                height: -webkit-min-content;
                height: -moz-min-content;
                height: min-content
            }

            .modal-sm {
                max-width: 300px
            }
        }

        @media (min-width:992px) {

            .modal-lg,
            .modal-xl {
                max-width: 800px
            }
        }

        @media (min-width:1200px) {
            .modal-xl {
                max-width: 1140px
            }
        }
    </style>

    @php
        
        // $Employee = App\Helpers\Central_unit::EmployeeDetails();
        $Central = new App\Helpers\Central_unit();
        
        $Employee = $Central::EmployeeDetails();
        $Department = $Central->DepartmentList();
        $Designation = $Central::DesignationList();
        // dd($Designation);
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
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Leave Policy Templates</div>
            <p class="text-muted">Create Template to give leaves to staff on month if they want</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#myModal">
                            Create Templates
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    {{-- <form action="{{ route('leave.policy') }}" method="post">   --}}
                    <form action="{{ route('admin.leavepolicySubmit') }}" method="POST">
                        <div class="modal-body  m-5">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Setting</span></h4>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                    <div class="col">
                                        <input type="text" class="form-control bg-muted form-label" id="inputName"
                                            placeholder="Enter Template Name" name="policyname" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Leave Policy Cycle</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth"
                                                value="1" checked="">
                                            <label class="btn btn-outline-dark" for="btnradiomonth">Monthly</label>
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradioyear"
                                                value="2">
                                            <label class="btn btn-outline-dark" for="btnradioyear">Yearly</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                    <div class="form-row col-xl-5">
                                        <input type="date" class="form-control col-xl-4" name="leave_periodfrom"
                                            required>
                                        <label class="col-xl-1" for="">To</label>
                                        <input type="date" class="form-control col-xl-4 " name="leave_periodto" required>
                                    </div>
                                </div>
                            </div>

                            <hr style="background: black" />
                            <div class="row ">
                                <div class="d-flex col-sm-10">
                                    <h4 class="card-title"><span>Leave Category</span></h4>
                                    
                                </div>
                                <div class="col-sm-2 text-end">
                                    <button type="button" class="btn btn-outline-primary add_item_btn"><i
                                        class="fe fe-plus bold"></i>
                                    </button>
                                </div>
                                
                                
                                <span id="show_item">

                                </span>

                            </div>
                            <hr style="background: black" />
                            <div class="row">
                                <div class="d-flex col-md-9">
                                    <h4 class="card-title"><span>Leave Policy Preference</span></h4>
                                </div>
                                <div class="col-md-3 d-flex text-end">

                                    {{-- <div class="mb-3"> --}}
                                    <a class="btn btn-primary mb-1" data-bs-toggle="collapse" href="#collapseExample"
                                        role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Business
                                    </a>
                                    <button class="btn btn-success mb-1" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    Employee
                                    </button>
                                    {{-- </div> --}}
                                </div>

                            </div>
                            <div class="row">
                                <div class="collapse" id="collapseExample">
                                    <div class="border p-3">
                                        In Case of Employee
                                        <div class="row">
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p class="form-label">Branch</p>
                                                    <select name='branch_id' id="country-dd" class="form-control"
                                                    required>
                                                    <option value="">Select Branch Name</option>
                                                    @foreach ($BranchList as $data)
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
                                                        <select id="state-dd" name="department_id" class="form-control"
                                                        required>
                                                        <option value="">Select Deparment Name</option>
                                                            <option value="">Select All Department Name</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="row">
                                                <table name="gg">
                                                    <thead>
                                                        <th>S.No.</th>
                                                        <th>Employee ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Select All <input type="checkbox" name=""
                                                                id=""> </th>
                                                    </thead>
                                                    <tbody class="mycard">

                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                        {{-- Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? --}}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <div class="text-center">
                                <button class="btn btn-success" type="submit" name="submit" id="submit"
                                    data-bs-target="">Apply</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}


    <div class="row">
        <div class="card">
            <div class="card-body ">
                {{-- border-bottum-0 p-2 --}}
                <div class="row">
                    <div class="col-6 col-xl-3 my-auto">
                        <h5 class="my-auto">FD Leave Template</h5>
                    </div>
                    <div class="col-6 col-xl-2 my-auto">
                        <p class="my-auto text-muted">2 Leaves Per Month</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto text-muted">Applied to 14 Employees</p>
                    </div>
                    <div class="col-8 col-xl-2">
                        <p class="my-auto text-muted">
                            <a class="btn text-primary" id="manageemp1" href="#"><b>Manage Employee List</b></a>
                            <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                    <div class="col-4 col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a class="btn text-primary" id="editTempBtn" href="#"><b>Edit Template</b></a>
                            <a class="btn btn-outline-success d-none" id="applyTempBtn" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 d-none" style="height: 20rem; overflow:scroll" id="emplist1">
                <table class="table mb-0 text-nowrap">

                    <tbody>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <label class="custom-switch">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-0">Faith Harris</h6>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-13">+91 1234567890</td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">File Export</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S. No.</th>

                                    <th class="border-bottom-0">Policy Name</th>
                                    <th class="border-bottom-0">Leave</th>
                                    <th class="border-bottom-0">Applied To</th>
                                    <th class="border-bottom-0">Policy Preference</th>
                                    <th class="border-bottom-0">Action</th>
                                    {{-- <th class="border-bottom-0">Salary</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    
                                @endphp
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    {{-- <td>$320,800</td> --}}
                                </tr>
                                <tr>
                                    <td>Donna Snider</td>
                                    <td>Customer Support</td>
                                    <td>New York</td>
                                    <td>27</td>
                                    <td>2011/01/25</td>
                                    {{-- <td>$112,000</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Apply Changes</a>
    </div>

    {{-- Set Multilavel Approval Modal --}}
    <div class="modal fade" id="SetMultilavelApprovalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0 ">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Set Multilavel Approval</h6>
                        </div>
                        <div class="card-body border-0">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="form-label">Choose Type of Approval:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Type of Approval" id='lavelofapproval'>
                                            <option label="Select Employee"></option>
                                            <option value="1">Lavel One</option>
                                            <option value="2">Lavel Two</option>
                                            <option value="3">Lavel Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                            <div class="form-group d-none" id="firstlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="secondlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="thirdlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Multilavel Approval Modal --}}
    <div class="modal fade" id="EditMultilavelApprovalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Edit Multilavel Approval</h6>
                        </div>
                        <div class="card-body border-0">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="form-label">Choose Type of Approval:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Type of Approval" id='Editlavelofapproval'>
                                            <option label="Select Employee"></option>
                                            <option value="1">Lavel One</option>
                                            <option value="2">Lavel Two</option>
                                            <option value="3">Lavel Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                            <div class="form-group d-none" id="Editfirstlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="Editsecondlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="Editthirdlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        var leave_id = 1;
        $(document).ready(function() {
            var postURL = "<?php echo url('policy_sumbit'); ?>";
            $(".add_item_btn").click(function(e) {
                // e.preventDefault();
                let categoryname = $('#categoryname').val();
                let days = $('#days').val();
                let leaverule = $('#leaverule').val();
                let cfl = $('#cfl').val();
                let applicable = $('#applicable').val();
                // leave_id = document.getElementById('cfl').value;
                console.log(categoryname, days, leaverule, cfl, applicable);
                $("#show_item").append(
                    `<div class="row">
                        
                        <div class="card-body col-xl-3 pt-3" name="leave_id" id="' + leave_id +'" > 
                            <label for="inputCity" class="form-label">Category Name</label> 
                            <input type="text" name="category_name[]" value="" class="form-control" id="inputCity" placeholder="Category Name" required> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label ">Days</label> 
                        <input type="number" name="days[]" value="" class="form-control bg-muted" placeholder="Count" required> 
                    </div> 
                        <div class="col-xl-2 pt-3 bg-muted"> 
                            <label for="inputState" class="form-label">Unused Leave Rule</label> 
                            <select class="form-control select2" name="unused_leave_rule[]" id="leaverules" data-placeholder="Leave Rule" required> 
                                <option label=""></option> 
                                <option>Lapse</option> <option>Carry Forward</option> <option>Encash</option> 
                            </select> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label">Carry Forward Limit</label> 
                        <input name="carry_forward_limit[]" type="number" value="" class="form-control" id="inputCity" placeholder="Days" required> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputState" class="form-label">Applicable To</label> 
                        <select class="form-control select2" name="applicable_to[]" data-placeholder="Applicable To" required> 
                            <option  label=""></option> <option>All</option> 
                            <option>Male</option> <option>Female</option>
                        </select> 
                        </div> <div class="col-xl-1 pt-3 text-end"> 
                            <label for="inputCity" class="form-label ">&nbsp;</label> 
                            <button type="button" class="btn btn-outline-danger remove_item_btn"><i class="feather feather-trash"></i></button>  
                        </div> 
                    </div> `
                );
                leave_id++;
                // leave_id = document.getElementById('categoryname').value;    

            });

            $(document).on('click', '.remove_item_btn', function(e) {
                // e.preventDefault();
                let row_item = $(this).parent().parent();
                console.log(row_item);
                $(row_item).remove();
            })
            $('#submit').click(function() {
                $.ajax({
                    url: postURL,
                    method: "POST",
                    data: $('#add_item_btn').serialize(),
                    type: 'json',
                    // dd(data);
                    success: function(data) {
                        if (data.error) {
                            return Hello;
                            printErrorMsg(data.error);
                        } else {
                            i = 1;
                            $('.dynamic-added').remove();
                            $('#remove_item_btn')[0].reset();
                            // dd(i);
                            // $(".print-success-msg").find("ul").html('');
                            // $(".print-success-msg").css('display','block');
                            // $(".print-error-msg").css('display','none');
                            // $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Create Method
        $(document).ready(function() {
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

                        console.log(result);
                        $('#state-dd').html(
                            '<option value="" name="department">Select Department Name</option>',
                            '<option value="" name="department">Select All Department Name</option>'
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
    <script>
        $('#state-dd').on('change', function() {
            var check_value = this.value;
            $("#desig-dd").html('');
            $.ajax({
                url: "{{ url('admin/settings/business/check') }}",
                type: "POST",
                data: {
                    check_value: check_value,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    // console.log(res);
                    $('.mycard').html(res);

                }
            });
        });
    </script>
@endsection
