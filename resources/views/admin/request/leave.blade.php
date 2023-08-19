@extends('admin.layout.master')
@section('title')
Leave Requests
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
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> --}}

@endsection

@section('contents')
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
                        <div class="icon1 bg-secondary-transparent my-auto  float-end"> <i class="las la-female"></i> </div>
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
                        <div class="icon1 bg-danger-transparent my-auto  float-end"> <i class="las la-user-friends"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Leaves Summary</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
                            <label class="form-label">Branch</label>
                            <select name="attendance" class="form-control custom-select select2" data-placeholder="Select Branch">
                                <option label="Select Branch"></option>
                                <option value="1">Raipur</option>
                                <option value="2">Bilashpur</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
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
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
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
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
                            <label class="form-label">Employee</label>
                            <input type="search" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
                            <label class="form-label">From</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-2">
                        <div class="form-group" style="width:80%;">
                            <label class="form-label">To</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xl-2">
                    <div class="form-group">
                        <label>Show <select name="">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> entries</label>
                </div>
                </div>
                <div class="col-md-12 col-xl-2">
                    {{-- <div class="form-group"> --}}
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary btn-sm">Copy</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">CSV</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Excel</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">PDF</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Print</button>
                        </div>
                    {{-- </div> --}}
                </div>
                <div class="col-md-12 col-xl-2">
                    <div class="form-group">
                        <label>Search:<input type="search" class="" placeholder=""></label>
                    </div>
                </div>
                {{--<div class="col-md-12 col-xl-2">
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
            </div> --}}
            {{-- <div class="row">
                <div class="col-sm"><label>Show <select name="">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries</label></div>
                <div class="col-md-12 col-xl-2 m-auto">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-primary btn-sm">Copy</button>
                        <button type="button" class="btn btn-outline-primary btn-sm">CSV</button>
                        <button type="button" class="btn btn-outline-primary btn-sm">Excel</button>
                        <button type="button" class="btn btn-outline-primary btn-sm">PDF</button>
                        <button type="button" class="btn btn-outline-primary btn-sm">Print</button>
                    </div>
                </div>
                <div class="col-md-12 col-xl-2 m-auto">
                    <div class=""><label>Search:<input type="search" class="" placeholder=""></label></div>
                </div>
            </div> --}}
            <!-- Row -->
            <div class="card-body ant-table" style="padding:0px">
                {{-- <div class="">Showing 1 to 1 of 1 entries</div> --}}
                <div class="table-responsive" style="text-align: center;">
                    <table class="table  table-vcenter text-nowrap  border-bottom" id="example">
                        {{-- <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom display nowrap" id="example"> --}}
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-5 text-center">Eemployee Name</th>
                                <th class="border-bottom-0 w-5 text-center">Employee ID</th>
                                <th class="border-bottom-0 text-center">Leave Type</th>
                                <th class="border-bottom-0 w-5 text-center">From</th>
                                <th class="border-bottom-0 text-center">To</th>
                                <th class="border-bottom-0 text-center">Days</th>
                                <th class="border-bottom-0 text-center">Reason</th>
                                <th class="border-bottom-0 text-center">Status</th>
                                <th class="border-bottom-0 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <span class="avatar avatar brround me-3" style="background-image: url(assets/images/users/1.jpg)"></span>
                                        <div class="me-3 mt-0 mt-sm-2 d-block">
                                            <h6 class="mb-1 fs-14">Faith Harris</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>FD2987</td>
                                <td>Casual Leave</td>
                                <td>16-01-2021</td>
                                <td>16-01-2021</td>
                                <td class="font-weight-semibold">1 Day</td>
                                <td>Personal</td>
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn1" class="d-none">
                                            <a href="javascript:void(0);" class="action-btns1 " data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                <i class="feather feather-edit secondary text-secondary" data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                <i class="feather feather-trash danger text-danger" data-bs-toggle="tooltip" data-original-title="View"></i>
                                            </a>
                                        </div>

                                        <div class="toggle-effect ms-auto" data-bs-toggle="modal" data-bs-traget=""> <a class="open-toggle" href="#"> <i id="moreBtn" class="si si-options-vertical"></i></a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div>
                    <div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><a class="paginate_button previous disabled" aria-controls="example" aria-disabled="true" role="link" data-dt-idx="previous" tabindex="-1" id="example_previous">Previous</a><span><a class="paginate_button current" aria-controls="example" role="link" aria-current="page" data-dt-idx="0" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="example" aria-disabled="true" role="link" data-dt-idx="next" tabindex="-1" id="example_next">Next</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row-->

{{-- delete confirmation --}}
<div class="modal fade" id="deletemodal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <h3>Are you sure want to delete ?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- delete confirmation --}}


{{-- delete confirmation --}}
<div class="modal fade" id="editmodal" data-bs-backdrop="static">
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

{{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>  --}}
<script>
    // new DataTable('#exampl', {
    //     dom: 'lBfrtip',
    //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    // }); 

    $(document).ready(function() {
        // $('.feather-trash').on('click', function() {
        //     alert('hello');
        // });

        $('#moreBtn').on('click', function() {
            $('#actionBtn1').toggleClass('d-none');
            $('#actionBtn1').toggleClass('animatedBtn');

        });
    });

</script>
@endsection
