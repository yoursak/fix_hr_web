@extends('admin.pagelayout.master')
@section('title', 'Leave')

@section('css')
    <style>

    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
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

@section('content')
    <style>
        .complete_class {
            color: green;
        }

        .incomplete_class {
            color: red;
        }

        #file-datatable_length {
            padding: 5px;
        }
    </style>
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
            // dd($BranchList);
            $DepartmentList = $centralUnit->DepartmentList();
            // dd($DepartmentList);
            $DesignationList = $centralUnit->DesignationList();
            // dd($DesignationList);
            // DesignationList
        @endphp
    @endforeach
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/requests/gatepass') }}">Request</a></li>
            <li class="active"><span><b>Leave</b></span></li>
        </ol>
    </div>
    {{-- <li><a href="javascript:void(0);">Elements</a></li> --}}

    <!-- Row -->
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Today Presents</span>
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
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Planned Leaves</span>
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
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Unplanned Leaves</span>
                                <h3 class="mb-0 mt-1 text-secondary">0</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i class="las la-female"></i>
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
                            <div class="mt-0 text-start"> <span class="font-weight-semibold">Pending Requests</span>
                                <h3 class="mb-0 mt-1 text-danger">12</h3>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="icon1 bg-danger-transparent my-auto  float-end"> <i class="las la-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Summary</h3>
                </div>

                <div class="card-body ">
                    <div class="row">


                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Branch</label>

                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Branch">
                                    <option label="Select Branch"></option>
                                    @if (!empty($BranchList))
                                        @foreach ($BranchList as $item)
                                            <option value="{{ $item->id }}">{{ $item->branch_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Department">
                                    <option label="Select Department"></option>
                                    @if (!empty($DepartmentList))

                                        @foreach ($DepartmentList as $item)
                                            <option value="1">{{ $item->depart_name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Designation</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Designation">
                                    <option label="Select Designation"></option>
                                    @if (!empty($DesignationList))

                                        @foreach ($DesignationList as $item)
                                            <option value="1">{{ $item->desig_name }}</option>
                                        @endforeach
                                    @endif

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

                        <div class="col-sm-12 col-xl-2">
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
                        </div>
                    </div>
                </div>
                <!-- ROW -->

                <!-- END ROW -->
                <div class="card-body pt-2  ">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
                                    <th class="border-bottom-0">Employee Name</th>
                                    <th class="border-bottom-0">Employee Id</th>
                                    <th class="border-bottom-0">Leave Type</th>
                                    <th class="border-bottom-0">From</th>
                                    <th class="border-bottom-0">To</th>
                                    <th class="border-bottom-0">Days</th>
                                    <th class="border-bottom-0">Reason</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    
                                @endphp
                                @foreach ($data as $item)
                                    @php
                                        $DesignationName = App\Helpers\Layout::DasignationName($item->designation_id);
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <div class="d-flex"> <span
                                                    class="avatar avatar-md brround me-3">{{ $item->profile_photo }}</span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class=" m-0 fs-14">{{ $item->emp_name }}</h6> <span
                                                        {{-- class="text-muted m-0 fs-12">{{ $DesignationName->desig_name? '$DesignationName->desig_name' : '' }}</span> --}} </div>
                                                </div>
                                        </td>
                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $item->leave_type }}</td>
                                        <td>{{ $item->from_date }}</td>
                                        <td>{{ $item->to_date }}</td>
                                        <td>{{ $item->days }}</td>
                                        <td>{{ $item->reason }}</td>
                                        {{-- <td>{{$item->status==1?'Approve'}}</td> --}}
                                        {{-- a ? b: c ? d : e ? f : g ? h : i    --}}
                                        {{-- <td>{{  $item->status == 1 ? 'Approve' : $item->status == 2 ? 'Rejected    ':'Approve'}}</td> --}}
                                        <td><span
                                                class="badge badge-complete {{ $item->status ? 'complete_class' : 'incomplete_class' }}">
                                                {{ $item->status == 1 ? 'Approve' : 'Decline' }}</span></td>
                                        {{-- <td>{{ $item->profile_photo }}</td> --}}

                                        {{-- <td><span class="badge badge-success">{{ $item->status }}</span></td> --}}
                                        <td>
                                            @if (in_array('Leave.Update', $permissions))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#showmodal{{ $item->id }}">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Leave.Delete', $permissions))
                                                <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletemodal{{ $item->id }}">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
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

    {{-- Modal --}}
    @foreach ($data as $item)
        <div class="modal fade" id="showmodal{{ $item->id }}">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">

                    <div class="modal-header">
                        <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Leave Request</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button> --}}
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>

                    <form action="{{ route('admin.leaveapprove', $item->id) }}" method="post">
                        @csrf
                        <div class="modal-body px-5 ">
                            <div class="form-row">
                                <div class="form-group  col-md-4">
                                    <input type="text" name="editLeaveId" value="{{ $item->id }}" hidden>
                                    <label for="inputEmail4">Branch</label>
                                    <input type="email" class="form-control" style="background-color:F1F4FB "
                                        id="inputEmail4" placeholder="Email" value="{{ $BranchName->branch_name }}"
                                        readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Depratment</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $DepartmentName->depart_name }}" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Designation</label>
                                    {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                                    value="{{ $DesignationName->desig_name? '$DesignationName->desig_name' : '' }}" readonly> --}}
                                    {{-- placeholder="Password" value="{{$item->designation_id}}" readonly> --}}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Employee Name</label>
                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email"
                                        value="{{ $item->emp_name }}" readonly>
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Employee Id</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->emp_id }}" readonly>
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="inputPassword4">Mobile No.</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Mobile No." value="{{ $item->emp_mobile_no }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group  col-md-3 col-sm-3">
                                    <label for="inputPassword4">Leave Type </label>
                                    <select name="leave_type" class="form-control custom-select select2"
                                        data-placeholder="{{ $item->leave_type }}" value="{{ $item->leave_type }}">
                                        <option label="Select Leave Type" value="{{ $item->leave_type }}">
                                            {{ $item->leave_type }}</option>
                                        <option value="1">Casual Leave</option>
                                        <option value="2">Sick Leave</option>
                                        {{-- <option value="3"> Employee</option> --}}
                                    </select>
                                </div>
                                <div class="form-group    col-md-3 col-sm-3">
                                    <label for="inputPassword4">From <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control" id="inputPassword4" name="from_date"
                                        placeholder="time" value="{{ $item->from_date }}">
                                </div>

                                <div class="form-group  col-md-3 col-sm-3 ">
                                    <label for="inputPassword4">To <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="date" class="form-control" name="to_date" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->to_date }}">
                                </div>
                                <div class="form-group  col-md-3 col-sm-3 ">
                                    <label for="inputPassword4">Days</label>
                                    <input type="text" class="form-control" id="inputPassword4" name="days"
                                        value="{{ $item->days }}" {{--
                                placeholder="Password" value="{{ $item->in_time }}"> --}} placeholder="Password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputPassword4" class="">Reason</label>
                                    {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                                value="{{$item->in_time}}"> --}}

                                    <textarea class="form-control" id="" rows="2" value="{{ $item->in_time }}" readonly>{{ $item->reason }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex me-auto ">
                                <p class="align-middle my-2"><span><b>Mark Leave Approvel</b></span></p>
                            </div>
                            <div class="d-flex m-0">
                                <button class="btn btn-danger mx-2" data-bs-dismiss="modal" type="cancel "
                                    name="status" value="2">Decline</button>

                                <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal"
                                    data-bs-target="#" name="status" value="1">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- delete confirmation --}}
        <div class="modal fade" id="deletemodal{{ $item->id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to Update It ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>

                        <a href="{{ route('admin.leavedelete', $item->id) }}" class="btn btn-primary"
                            type="submit">Approve</a>


                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- delete confirmation --}}
    {{-- @endforeach --}}



@endsection
