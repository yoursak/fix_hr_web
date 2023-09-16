@extends('admin.layout.master')
@section('title')
    Miss Punch Request
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
        .animatedBtn,
        {
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
@endsection

@section('contents')
    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Gatepass Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-2">
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
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Department:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
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
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
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

                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="card-body ant-table" style="padding:0px">
                    <div class="table-responsive" style="text-align: center;">
                        <table class="table  table-vcenter text-nowrap  border-bottom" id="example10">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 text-center">Employee Name</th>
                                    <th class="border-bottom-0 text-center">Employee ID</th>
                                    <th class="border-bottom-0 text-center">Time Type</th>
                                    <th class="border-bottom-0 text-center">In Time</th>
                                    <th class="border-bottom-0 text-center">Out Time</th>
                                    <th class="border-bottom-0 text-center">Working Hours</th>
                                    <th class="border-bottom-0 text-center">Status</th>
                                    <th class="border-bottom-0 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    @php   
                                        $DesignationName = App\Helpers\Layout::DasignationName($item->designation_id);                
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex"> <span class="avatar avatar-md brround me-3"
                                                    style="background-image: url(../assets/images/users/1.jpg)">{{ $item->profile_photo }}</span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class=" m-0 fs-14">{{ $item->emp_name }}</h6> <span
                                                        class="text-muted m-0 fs-12">{{ $DesignationName->desig_name }}</span>
                                                        {{-- class="text-muted m-0 fs-12"></span> --}}
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $item->emp_id }}</td>
                                        {{-- <td>{{ $item->emp_miss_date }}</td> --}}
                                        <td>{{ $item->emp_miss_time_type }}</td>
                                        <td>{{ $item->emp_miss_in_time }}</td>
                                        <td>{{ $item->emp_miss_out_time }}</td>
                                        <td>{{ $item->emp_working_hour }}</td>
                                        <td>{{ $item->status }}</td>
                                        {{-- <td> <a class="btn btn-primary btn-icon btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editdepartmentmodal"> <i class="feather feather-edit"
                                                    data-bs-toggle="tooltip" data-original-title="Edit"
                                                    data-bs-original-title="" title=""></i> </a> <a
                                                class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip"
                                                data-original-title="Delete" data-bs-original-title="" title=""><i
                                                    class="feather feather-trash-2"></i></a> </td> --}}
                                        <td>
                                            {{-- <form action="" method="post">  
                                            @csrf   --}}


                                            <div class="d-flex justify-content-center btn-icon ">
                                                {{-- <div id="actionBtn{{$item->id}}" class="d-none"> --}}

                                                <a href="javascript:void(0);" class="action-btns1 btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#showmodal{{ $item->id }}">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>

                                                <a href="javascript:void(0);" class="action-btns1 btn-danger"
                                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="danger"></i>
                                                </a>
                                            </div>

                                            {{-- <div class="ms-auto"><i id="{{$item->id}}" onclick="moreBtn(this.id)" class="btn si si-options-vertical ms-auto"></i> --}}
                                            {{-- </div> --}}
                                        </td>
                    </div>
                    {{-- </form>   --}}

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Row-->

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
                    <form method="POST" action="{{ route('admin.gatepassupdate', $item->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title ms-2 " id="exampleModalLongTitle">Gatepass Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body px-5 ">
                            <div class="form-row">
                                <div class="form-group  col-md-4">
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
                                        {{-- placeholder="Password" value="{{ $DesignationName->desig_name }}" readonly> --}}
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
                                        placeholder="text" value="{{ $item->emp_mobile_no }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group  col-md-3 col-sm-3">
                                    <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->emp_miss_date }}" readonly>
                                </div>
                                <div class="form-group col-md-3 col-sm-3">
                                    <label for="inputPassword4">Time Type</label>
                                    <input type="selected" class="form-control" id="inputPassword4" placeholder="time"
                                        value="{{ $item->emp_miss_time_type }}" readonly>
                                </div>

                                <div class="form-group  col-md-2 col-sm-3 ">
                                    <label for="inputPassword4">In Time</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->emp_miss_in_time}}">
                                </div>
                                <div class="form-group  col-md-2 col-sm-3 ">
                                    <label for="inputPassword4">Out Time</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->emp_miss_out_time}}">
                                </div>
                                <div class="form-group  col-md-2 col-sm-3">
                                    <label for="inputPassword4">Working Hour</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->emp_working_hour }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="inputPassword4" class="">Reason</label>
                                    {{-- <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value="{{$item->in_time}}"> --}}

                                    <textarea class="form-control" id="" rows="2" value="" readonly>{{ $item->message }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex me-auto">
                                <p class="ms-3"><span><b>Mark Misspunch Approvel</b></span></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-danger mx-2" data-bs-dismiss="modal">Decline</button>
                                <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal"
                                    data-bs-target="#">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Modal --}}


    {{-- delete confirmation --}}
    <div class="modal fade" id="deletemodal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <h3>Are you sure want to Update It ?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#">Approve</button>
                </div>
            </div>
        </div>
    </div>
    {{-- delete confirmation --}}
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
        $(document).ready(function() {
            $('#moreBtn').on('click', function() {
                $('#actionBtn1').toggleClass('d-none');
                $('#actionBtn1').toggleClass('animatedBtn');

            });
        });
    </script>
@endsection
