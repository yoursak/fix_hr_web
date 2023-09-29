@extends('admin.pagelayout.master')
@section('title', 'GetePass')

@section('css')
<style>

</style>

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
<script src="{{ asset('assets/js/hr/hr-emp.js') }}"></script>

@endsection
@section('content')




<div class=" p-0 py-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/requests/gatepass') }}">Request</a></li>
        {{-- <li><a href="javascript:void(0);">Elements</a></li> --}}
        <li class="active"><span><b>Gatepass</b></span></li>
    </ol>
</div>


<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gatepass Summary</h3>
            </div>
            <div class="card-body ">
                <div class="row">

                    <div class="col-sm-12 col-xl-2">
                        <div class="form-group">
                            <label class="form-label">Branch</label>
                            <select name="attendance" class="form-control custom-select select2" data-placeholder="Select Branch">
                                <option label="Select Branch"></option>
                                <option value="1">High</option>
                                <option value="2">Medium</option>
                                <option value="3">Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-2">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select name="attendance" class="form-control custom-select select2" data-placeholder="Select Department">
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
                    <div class="col-sm-12 col-xl-2">
                        <div class="form-group">
                            <label class="form-label">Designation</label>
                            <select name="attendance" class="form-control custom-select select2" data-placeholder="Select Designation">
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
                    <div class="col-sm-12 col-xl-2">
                        <div class="form-group">
                            <label class="form-label">Employee Type</label>
                            <select name="attendance" class="form-control custom-select select2" data-placeholder="Select Employee Type">
                                <option label="Select Employee Type"></option>
                                <option value="1">Regular Employee</option>
                                <option value="2">Contractual Employee</option>

                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body p-2 ">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                        {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                        <thead>
                            <tr>
                                <th class="border-bottom-0">S.No.</th>

                                <th class="border-bottom-0">Employee Name</th>
                                <th class="border-bottom-0">Employee Id</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0">Going Through</th>
                                <th class="border-bottom-0">Out Time</th>
                                <th class="border-bottom-0">In Time</th>
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
                            $Layout = new App\Helpers\Layout();

                            $DesigName=$Layout::DasignationName($item->designation_id);

                            @endphp
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>
                                    <div class="d-flex"> <span class="avatar avatar-md brround me-3">{{ $item->profile_photo }}</span>
                                        <div class="me-3 mt-0 mt-sm-1 d-block">
                                            <h6 class=" m-0 fs-14">{{ $item->emp_name }}</h6> <span class="text-muted m-0 fs-12">{{ $DesigName->desig_name }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $item->emp_id }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->going_through }}</td>
                                <td>{{ $item->out_time }}</td>
                                <td>{{ $item->in_time }}</td>
                                <td>{{ $item->reason }}</td>
                                <td><span class="badge badge-success">{{ $item->status }}</span></td>


                                <td>
                                    @if (in_array('Gate Pass.Update', $permissions))

                                    <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#showmodal{{ $item->id }}">
                                        <i class="feather feather-eye" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                    </a>
                                    @endif
                                    @if (in_array('Gate Pass.Delete', $permissions))

                                    <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deletemodal{{ $item->id }}">
                                        <i class="feather feather-trash-2" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
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

<!-- ROW -->
<div class="row row-sm">



    {{-- Modal --}}
    @foreach ($data as $item)
    @php
    $BranchName = App\Helpers\Layout::BranchName($item->branch_id);
    // dd($BranchName);
    $DepartmentName = App\Helpers\Layout::DepartmentName($item->department_id);
    // dd($DepartmentName);
    $DesignationName = App\Helpers\Layout::DasignationName($item->designation_id);
    // dd($DesignationName);
    @endphp
    <div class="modal fade" id="showmodal{{ $item->id }}">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">

                <div class="modal-header">
                    <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Gatepass Request</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button> --}}
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>

                <form action="{{ route('admin.gatepassapprove', $item->id) }}" method="post">
                    @csrf
                    <div class="modal-body px-5 ">
                        <div class="form-row">
                            <div class="form-group  col-md-4">
                                <input type="text" name="editGatepassId" value="{{ $item->id }}" hidden>
                                <label for="inputEmail4">Branch</label>
                                <input type="email" class="form-control" style="background-color:F1F4FB " id="inputEmail4" placeholder="Email" value="{{ $BranchName->branch_name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Depratment</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $DepartmentName->depart_name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Designation</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $DesignationName->desig_name }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Employee Name</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" value="{{ $item->emp_name }}" readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Employee Id</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $item->emp_id }}" readonly>
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputPassword4">Mobile No.</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $item->emp_mobile_no }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  col-md-3 col-sm-3">
                                <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip" title="" data-bs-original-title="fa fa-calendar" aria-label="fa fa-calendar"></i></label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $item->date }}" readonly>
                            </div>
                            <div class="form-group    col-md-3 col-sm-3">
                                <label for="inputPassword4">Going Through</label>
                                <input type="selected" class="form-control" id="inputPassword4" placeholder="time" value="{{ $item->going_through }}" readonly>
                            </div>

                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">Out Time</label>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{ $item->out_time }}" readonly>
                            </div>
                            <div class="form-group  col-md-3 col-sm-3 ">
                                <label for="inputPassword4">In Time</label>
                                <input type="time" class="form-control" id="inputPassword4" name="in_time" value="{{ $item->in_time }}" {{--
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
                            <p class="align-middle my-2"><span><b>Mark Gatepass Approvel</b></span></p>
                        </div>
                        <div class="d-flex m-0">
                            <button class="btn btn-danger mx-2" data-bs-dismiss="modal" type="cancel " name="approve" value="Pending">Decline</button>

                            <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal" data-bs-target="#" name="approve" value="Approve">Approve</button>
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
                    {{-- <form action="{{ route('admin.gatepassdelete', $item->id) }}" method="post">
                    @csrf
                    @method('DELETE') --}}
                    <a href="{{ route('admin.gatepassdelete', $item->id) }}" class="btn btn-primary" type="submit">Approve</a>
                    {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#">Approve</button>
                        --}}
                    {{--
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- delete confirmation --}}
    @endforeach
    {{-- Modal --}}



    {{-- <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Datatable</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">First name</th>
                                <th class="wd-15p border-bottom-0">Last name</th>
                                <th class="wd-20p border-bottom-0">Position</th>
                                <th class="wd-15p border-bottom-0">Start date</th>
                                <th class="wd-10p border-bottom-0">Salary</th>
                                <th class="wd-25p border-bottom-0">E-mail</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW --> --}}
    <!-- ROW -->
    {{-- <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Employees List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-table">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">No</th>
                                    <th class="border-bottom-0">Emp Name</th>
                                    <th class="border-bottom-0 w-10">#Emp ID</th>
                                    <th class="border-bottom-0">Department</th>
                                    <th class="border-bottom-0">Designation</th>
                                    <th class="border-bottom-0">Phone Number</th>
                                    <th class="border-bottom-0">Join Date</th>
                                    <th class="border-bottom-0">At work</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/1.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Faith Harris</h6>
                                                <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#2987</td>
                                    <td>Designing Department</td>
                                    <td>Web Designer</td>
                                    <td>+9685321475</td>
                                    <td>05-05-2017</td>
                                    <td>3 yrs 1 mons 13 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/9.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Austin Bell</h6>
                                                <p class="text-muted mb-0 fs-12">austin@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#4987</td>
                                    <td>Development Department</td>
                                    <td>Angular Developer</td>
                                    <td>+8653217950</td>
                                    <td>02-01-2018</td>
                                    <td>3 yrs 0 mons 25 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/2.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Maria Bower</h6>
                                                <p class="text-muted mb-0 fs-12">maria@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#6729</td>
                                    <td>Marketing Department</td>
                                    <td>Marketing analyst</td>
                                    <td>+9563258417</td>
                                    <td>02-08-2019</td>
                                    <td>2 yrs 3 mons 23 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/10.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Peter Hill</h6>
                                                <p class="text-muted mb-0 fs-12">peter@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#2098</td>
                                    <td>IT Department</td>
                                    <td>Testor</td>
                                    <td>+8563249751</td>
                                    <td>01-01-2020</td>
                                    <td>1 yrs 0 mons 25 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/3.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Victoria	Lyman</h6>
                                                <p class="text-muted mb-0 fs-12">victoria@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#1025</td>
                                    <td>Managers Department</td>
                                    <td>General Manager</td>
                                    <td>+9635826432</td>
                                    <td>05-05-2021</td>
                                    <td>0 yrs 0 mons 20 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/11.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Adam	Quinn</h6>
                                                <p class="text-muted mb-0 fs-12">adam@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#3262</td>
                                    <td>Accounts Department</td>
                                    <td>Accountant</td>
                                    <td>+9685231572</td>
                                    <td>05-05-2020</td>
                                    <td>0 yrs 8 mons 20 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>07</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/4.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Melanie Coleman</h6>
                                                <p class="text-muted mb-0 fs-12">melanie@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#3489</td>
                                    <td>Application Department</td>
                                    <td>App Designer</td>
                                    <td>+8635291470</td>
                                    <td>15-02-2019</td>
                                    <td>1 yrs 11 mons 10 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>08</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/12.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Max	Wilson</h6>
                                                <p class="text-muted mb-0 fs-12">max@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#3698</td>
                                    <td>Development Department</td>
                                    <td>PHP Developer</td>
                                    <td>+9986357240</td>
                                    <td>05-05-2020</td>
                                    <td>0 yrs 9 mons 20 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>09</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/5.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Amelia Russell</h6>
                                                <p class="text-muted mb-0 fs-12">amelia@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#5612</td>
                                    <td>Designing Department</td>
                                    <td>UX Designer</td>
                                    <td>+9356982472</td>
                                    <td>01-05-2018</td>
                                    <td>2 yrs 9 mons 25 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/13.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Justin Metcalfe</h6>
                                                <p class="text-muted mb-0 fs-12">justin@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#0245</td>
                                    <td>Designing Department</td>
                                    <td>Web Designer</td>
                                    <td>+9685321475</td>
                                    <td>05-05-2017</td>
                                    <td>3 yrs 1 mons 13 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/6.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Sophie Anderson</h6>
                                                <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#3467</td>
                                    <td>Development Department</td>
                                    <td>Java Developer</td>
                                    <td>+8674231566</td>
                                    <td>025-08-2020</td>
                                    <td>0 yrs 4 mons 0 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/14.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Ryan	Young</h6>
                                                <p class="text-muted mb-0 fs-12">ryan@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#2987</td>
                                    <td>Designing Department</td>
                                    <td>Ui Designer</td>
                                    <td>+9685321475</td>
                                    <td>05-05-2017</td>
                                    <td>3 yrs 1 mons 13 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/7.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Jennifer	Hardacre</h6>
                                                <p class="text-muted mb-0 fs-12">jennifer@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#9365</td>
                                    <td>Technical Department</td>
                                    <td>Supporter</td>
                                    <td>+9685321475</td>
                                    <td>03-09-2019</td>
                                    <td>1 yrs 2 mons 25 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/15.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Justin Parr</h6>
                                                <p class="text-muted mb-0 fs-12">justin@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#3109</td>
                                    <td>Application Department</td>
                                    <td>App Developer</td>
                                    <td>+9685321475</td>
                                    <td>12-12-2020</td>
                                    <td>0 yrs 01 mons 13 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/8.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Julia Hodges</h6>
                                                <p class="text-muted mb-0 fs-12">julia@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#2987</td>
                                    <td>Development Department</td>
                                    <td>Java Developer</td>
                                    <td>+8659357241</td>
                                    <td>04-04-2020</td>
                                    <td>0 yrs 9 mons 21 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>16</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(assets/images/users/16.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Michael Sutherland</h6>
                                                <p class="text-muted mb-0 fs-12">michael@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#2987</td>
                                    <td>Accounts Department</td>
                                    <td>Accountant</td>
                                    <td>+8866449975</td>
                                    <td>15-10-2018</td>
                                    <td>2 yrs 2 mons 10 days</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm"  href="hr-empview.html">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete"><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- END ROW -->
    @endsection