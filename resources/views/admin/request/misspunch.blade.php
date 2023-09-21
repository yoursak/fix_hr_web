@extends('admin.pagelayout.master')
@section('title', 'GetePass')

@section('css')
    <style>

    </style>

@endsection

@section('js')
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
    <script>
        new DataTable('#example10', {
        dom: '<"top"lfB>rtip'
        , buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
     });

     function check(event) {
      var selectElement = event.target;
      var value = selectElement.value;
      const get_out_time = document.getElementById('out_time');
      const get_in_time = document.getElementById('in_time');
      if (value=='All') {
          get_out_time.removeAttribute('disabled');
          get_in_time.removeAttribute('disabled');
      }if (value=='AM') {
          get_out_time.setAttribute('disabled', '');
          get_in_time.removeAttribute('disabled');
      }if (value=='PM') {
          get_in_time.setAttribute('disabled', '');
          get_out_time.removeAttribute('disabled');
      }
      }
    </script>

@endsection
@section('content')

   

    <div class="">
      
        <div class=" p-0 py-2">
            

            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/requests/misspunch') }}">Request</a></li>
                
                <li class="active"><span><b>Misspunch</b></span></li>
            </ol>
        </div>
    </div>
   

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Misspunch Summary</h3>
                </div>
                <div class="card-body ">
                    <div class="row">

                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Branch</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Branch">
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
                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Designation</label>
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
                        <div class="col-sm-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Employee</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
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
                                    <th class="border-bottom-0">Time Type</th>
                                    <th class="border-bottom-0">In Time</th>
                                    <th class="border-bottom-0">Out Time</th>
                                    <th class="border-bottom-0">Working Hours</th>
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
                                            <div class="d-flex"> <span class="avatar avatar-md brround me-3"
                                                    {{--
                                                style="background-image: url(../assets/images/users/1.jpg)">{{
                                                $item->profile_photo }}</span> --}}>{{ $item->profile_photo }}</span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class=" m-0 fs-14">{{ $item->emp_name }}</h6> <span
                                                        class="text-muted m-0 fs-12">{{ $DesignationName->desig_name }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $item->emp_miss_date }}</td>
                                        <td>{{ $item->emp_miss_time_type }}</td>
                                        <td>{{ $item->emp_miss_in_time}}</td>
                                        <td>{{ $item->emp_miss_out_time }}</td>
                                        <td>{{ $item->emp_working_hour }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td><span class="badge badge-success">{{ $item->status }}</span></td>
                                        <td>
                                            {{-- class="action-btns1 btn-primary" --}}
                                            <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                data-bs-toggle="modal" data-bs-target="#showmodal{{ $item->id }}">
                                                <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                data-bs-toggle="modal" data-bs-target="#deletemodal{{ $item->id }}">
                                                <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
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
                            <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Misspunch Request</h5>
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button> --}}
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <form action="{{ route('admin.misspunchapprove', $item->id) }}" method="post">
                            @csrf
                            <div class="modal-body px-5 ">
                                <div class="form-row">
                                    <div class="form-group  col-md-4">
                                        <input type="text" name="editMisspunchId" value="{{ $item->id }}" hidden>
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
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $DesignationName->desig_name }}" readonly>
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
                                            placeholder="Password" value="{{ $item->emp_mobile_no }}" readonly>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group  col-md-3 col-sm-3">
                                        <label for="inputPassword4">Date <i class="fa fa-calendar"
                                                data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="fa fa-calendar"
                                                aria-label="fa fa-calendar"></i></label>
                                        <input type="text" class="form-control" id="inputPassword4"
                                            placeholder="Password" value="{{ $item->emp_miss_date }}" >
                                    </div>
                                    <div class="form-group    col-md-3 col-sm-3">
                                        <label for="inputPassword4">Time Type</label>
                                        <select name="" class="form-control" onchange="check(event)" value="{{ $item->emp_miss_time_type}}">
                                    <option label="{{ $item->emp_miss_time_type}}" value=""></option>
                                            {{-- <option value="All">All</option> --}}
                                            <option value="">Select Time Type</option>
                                            <option value="AM">In Time</option>
                                            <option value="PM">Out Time</option>
                                        </select>
                                        {{-- <input type="selected" class="form-control" id="inputPassword4"
                                            placeholder="time" value="{{ $item->going_through }}" readonly> --}}
                                    </div>
                                    
                                        
                                    <div class="form-group  col-md-3 col-sm-3 ">
                                        <label for="inputPassword4">In Time</label>
                                        <input type="time" class="form-control" name="in_time" id="in_time" placeholder="time" value="{{ $item->emp_miss_in_time }}" >
                                    </div>
                                    <div class="form-group  col-md-3 col-sm-3 ">
                                        <label for="inputPassword4">Out Time</label>
                                        <input type="time" class="form-control" id="out_time" name="out_time"
                                            value="{{ $item->emp_miss_out_time }}" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="inputPassword4" class="">Reason</label>
                                        {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password"
                                value="{{$item->in_time}}"> --}}

                                        <textarea class="form-control" id="" rows="2" value="{{ $item->in_time }}" readonly>{{ $item->message }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex me-auto ">
                                    <p class="align-middle my-2"><span><b>Mark Misspunch Approvel</b></span></p>
                                </div>
                                <div class="d-flex m-0">
                                    <button class="btn btn-danger mx-2" data-bs-dismiss="modal" type="cancel "
                                        name="" value="Pending">Decline</button>

                                    <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal"
                                        data-bs-target="#" name="approve" value="Approve">Approve</button>
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
                           
                            <a href="{{ route('admin.misspunchdelete', $item->id) }}" class="btn btn-primary"
                                type="submit">Approve</a>
                           
                        </div>
                    </div>
                </div>
            </div>
            {{-- delete confirmation --}}
        @endforeach
        {{-- Modal --}}

    @endsection
