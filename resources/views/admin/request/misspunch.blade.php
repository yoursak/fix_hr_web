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
                <h4 class="card-title">Leaves Summary</h4>
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
                    <div class="col-md-12 col-xl-2">
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

                </div>
                <div class="row">

                </div>
            </div>
            <div class="card-body ant-table" style="padding:0px">
                <div class="table-responsive" style="text-align: center;">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                        <thead>
                            <tr>
                                <th class="border-bottom-0  text-center">Employee Name</th>
                                {{-- <th class="border-bottom-0 w-5 text-center">Employee ID</th> --}}
                                <th class="border-bottom-0 w-10 text-center">Date</th>
                                <th class="border-bottom-0 text-center">Time Type</th>
                                <th class="border-bottom-0  text-center">In Time</th>
                                <th class="border-bottom-0  text-center">Out Time</th>
                                <th class="border-bottom-0  text-center">Working Hours</th>
                                {{-- <th class="border-bottom-0  text-center">Remark</th> --}}
                                <th class="border-bottom-0  text-center">Status</th>
                                <th class="border-bottom-0 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="avatar avatar brround me-3"
                                        style="background-image: url(assets/images/users/1.jpg)"></span>Faith Harris
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                {{-- <td>Personal</td> --}}
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal"
                                                data-bs-target="#deletemodalview">
                                                <i class="feather feather-eye secondary text-primary"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger"
                                                    data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="moreBtn"
                                                class="btn si si-options-vertical ms-auto"></i>
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
<!-- End Row-->

{{-- delete confirmation --}}
<div class="modal fade" id="deletemodalview">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Misspunch Request</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    --}}
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group px-5 col-md-4">
                            <label for="inputEmail4">Branch</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group px-5 col-md-4">
                            <label for="inputPassword4">Depratment</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group px-5 col-md-4">
                            <label for="inputPassword4">Designation</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group px-5 col-md-4">
                            <label for="inputEmail4">Employee Name</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group px-5 col-md-4">
                            <label for="inputPassword4">Employee Id</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group px-5 col-md-4">
                            <label for="inputPassword4">Mobile No.</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>

                    </div>
                    <div class="row p-3">
                        <div class="form-group  col-md-3 col-sm-3">
                            <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="fa fa-calendar" aria-label="fa fa-calendar"></i></label>
                            <input type="text" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group    col-md-3 col-sm-3">
                            <label for="inputPassword4">Time Type</label>

                            <input type="selected" class="form-control" id="inputPassword4" placeholder="time">
                        </div>

                        <div class="form-group  col-md-2 col-sm-3 ">
                            <label for="inputPassword4">In Time</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group  col-md-2 col-sm-3 ">
                            <label for="inputPassword4">Out Time</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                        <div class="form-group  col-md-2 col-sm-3 ">
                            <label for="inputPassword4">Working Hours</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group px-5">
                            <label for="inputPassword4" class="">Reason</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex me-auto">
                    <p class="ms-3"><span><b>Mark Misspunch Approvel</b></span></p>
                </div>

                <div class="d-flex">
                    <button class="btn btn-danger mx-2" data-bs-dismiss="modal">Decline</button>
                    <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#">Approve</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- delete confirmation --}}


{{-- delete confirmation --}}
<div class="modal fade" id="deletemodal" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
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
        dom: '<"top"lfB>rtip'
        , buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
    , });

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