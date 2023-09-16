@extends('admin.pagelayout.master')
@section('title', 'GetePass')

@section('css')
    <style>
        /* button.dt-button, div.dt-button, a.dt-button, input.dt-button {
        border-radius: 2px;
        color: white;
        background-color: blue;
    } */

        /* .button.dt-button:hover:not(.disabled), div.dt-button:hover:not(.disabled), a.dt-button:hover:not(.disabled), input.dt-button:hover:not(.disabled) {
        border: 1px solid #666;
        background-color: black;
    } */
        .button {
            background-color: yellowgreen;
        }

        /* dt-button buttons-copy buttons-html */
        .form-control[readonly] {
            background-color: #F1F4FB;
            opacity: 1;
        }

        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: center;

        }

        .modal-header,
        .modal-footer {
            background-color: #f8f8ff;
            /* color: #fff; */
        }

        .top {
            padding: 10px;
        }

        th {
            text-align: center;
        }

        /* Aman Sir */
    </style>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
    {{--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6m n/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> --}}
@endsection

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script> --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
     <!-- INTERNAL  DATEPICKER JS -->
     <script src="https://laravelui.spruko.com/dayone/assets/plugins/date-picker/jquery-ui.js"></script>    

        <!-- INTERNAL INDEX JS -->
        <script src="https://laravelui.spruko.com/dayone/assets/js/hr/hr-award.js"></script>
        <script src="https://laravelui.spruko.com/dayone/assets/plugins/daterangepicker/moment.min.js"></script>
		<script src="https://laravelui.spruko.com/dayone/assets/plugins/daterangepicker/daterangepicker.js"></script>

    <script>
        new DataTable('#example10', {
            dom: '<"top"lfB>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],

        });
    </script>
@endsection
@section('content')
    <!-- PAGE HEADER -->
    <div class="page-header d-lg-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Data Table</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class=" btn-list">
                <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="E-mail"> <i
                        class="feather feather-mail"></i> </button>
                <button class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip" title="Contact"> <i
                        class="feather feather-phone-call"></i> </button>
                <button class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip" title="Info"> <i
                        class="feather feather-info"></i> </button>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="hr-award_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="hr-award_length"><label>Show <select name="hr-award_length" aria-controls="hr-award" class="form-select form-select-sm select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 61.4125px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-hr-award_length-xs-container"><span class="select2-selection__rendered" id="select2-hr-award_length-xs-container" title="10">10</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="hr-award_filter" class="dataTables_filter"><label><input type="search" class="form-control form-control" placeholder="Search..." aria-controls="hr-award"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table table-vcenter text-nowrap table-bordered border-bottom dataTable no-footer" id="hr-award" role="grid" aria-describedby="hr-award_info">
                            <thead>
                                <tr role="row"><th class="border-bottom-0 w-5 sorting_disabled" rowspan="1" colspan="1" aria-label="No" style="width: 17.8125px;">No</th><th class="border-bottom-0 w-5 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="#Emp ID: activate to sort column ascending" style="width: 52.8875px;">#Emp ID</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Emp Name: activate to sort column ascending" style="width: 173.388px;">Emp Name</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Designation: activate to sort column ascending" style="width: 113.662px;">Designation</th><th class="border-bottom-0 text-center sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Attendance: activate to sort column ascending" style="width: 72.288px;">Attendance</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Award Type: activate to sort column ascending" style="width: 188.212px;">Award Type</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Gift Type: activate to sort column ascending" style="width: 58.75px;">Gift Type</th><th class="border-bottom-0 sorting_disabled" rowspan="1" colspan="1" aria-label="Date" style="width: 70.625px;">Date</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="hr-award" rowspan="1" colspan="1" aria-label="Award Information: activate to sort column ascending" style="width: 117.138px;">Award Information</th><th class="border-bottom-0 sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 69.825px;">Actions</th></tr>
                            </thead>
                            <tbody>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            <tr class="odd">
                                    <td>01</td>
                                    <td>#2987</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/1.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Faith Harris</h6>
                                                <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Web Designer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.85" data-thickness="3" data-color="#0dcd94"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-success fs-12">85%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Employee of the Month Award</td>
                                    <td><span class="badge badge-primary-light">Cash</span></td>
                                    <td>01-02-2021</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="even">
                                    <td>02</td>
                                    <td>#4987</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/9.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Austin Bell</h6>
                                                <p class="text-muted mb-0 fs-12">austin@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Angular Developer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.58" data-thickness="3" data-color="#f34932"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-orange fs-12">58%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Best Team Player Award</td>
                                    <td><span class="badge badge-orange-light">Trophy</span></td>
                                    <td>15-01-2021</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="odd">
                                    <td>03</td>
                                    <td>#6729</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/2.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Maria Bower</h6>
                                                <p class="text-muted mb-0 fs-12">maria@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Marketing analyst</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.90" data-thickness="3" data-color="#0dcd94"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-success fs-12">90%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Best Attendance Award</td>
                                    <td><span class="badge badge-success-light">Momento</span></td>
                                    <td>13-12-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="even">
                                    <td>04</td>
                                    <td>#2098</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/10.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Peter Hill</h6>
                                                <p class="text-muted mb-0 fs-12">peter@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Testor</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.78" data-thickness="3" data-color="#f34932 "><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-orange fs-12">78%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Most Improved Performer</td>
                                    <td><span class="badge badge-orange-light">Trophy</span></td>
                                    <td>05-11-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="odd">
                                    <td>05</td>
                                    <td>#1025</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/3.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Victoria Lyman</h6>
                                                <p class="text-muted mb-0 fs-12">victoria@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>General Manager</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.48" data-thickness="3" data-color="#45aaf2"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-info fs-12">48%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">The Motivator</td>
                                    <td><span class="badge badge-success-light">Momento</span></td>
                                    <td>21-09-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="even">
                                    <td>06</td>
                                    <td>#3262</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/11.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Adam Quinn</h6>
                                                <p class="text-muted mb-0 fs-12">adam@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Accountant</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.32" data-thickness="3" data-color="#f11541"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-danger fs-12">32%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Stand out Performer</td>
                                    <td><span class="badge badge-primary-light">Cash</span></td>
                                    <td>18-08-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="odd">
                                    <td>07</td>
                                    <td>#3489</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/4.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Melanie Coleman</h6>
                                                <p class="text-muted mb-0 fs-12">melanie@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>App Designer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.82" data-thickness="3" data-color="#0dcd94"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-success fs-12">82%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Work Anniversary Award</td>
                                    <td><span class="badge badge-orange-light">Trophy</span></td>
                                    <td>15-07-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="even">
                                    <td>08</td>
                                    <td>#3698</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/12.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Max Wilson</h6>
                                                <p class="text-muted mb-0 fs-12">max@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PHP Developer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.78" data-thickness="3" data-color="#0dcd94"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-success fs-12">78%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Most Creative Award</td>
                                    <td><span class="badge badge-success-light">Momento</span></td>
                                    <td>12-05-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="odd">
                                    <td>09</td>
                                    <td>#5612</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/5.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Amelia Russell</h6>
                                                <p class="text-muted mb-0 fs-12">amelia@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>UX Designer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.49" data-thickness="3" data-color="#45aaf2"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-info fs-12">49%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Character Award</td>
                                    <td><span class="badge badge-orange-light">Trophy</span></td>
                                    <td>22-04-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr><tr class="even">
                                    <td>10</td>
                                    <td>#0245</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3" style="background-image: url(https://laravelui.spruko.com/dayone/assets/images/users/13.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">Justin Metcalfe</h6>
                                                <p class="text-muted mb-0 fs-12">justin@gmail.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Web Designer</td>
                                    <td>
                                        <div class="chart-circle chart-circle-xs" data-value="0.66" data-thickness="3" data-color="#f34932"><canvas width="50" height="50" style="height: 40px; width: 40px;"></canvas>
                                            <div class="chart-circle-value text-orange fs-12">66%</div>
                                        </div>
                                    </td>
                                    <td class="font-weight-semibold">Sales Award</td>
                                    <td><span class="badge badge-primary-light">Cash</span></td>
                                    <td>05-03-2020</td>
                                    <td>Congratulations</td>
                                    <td>
                                        <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editawardmodal">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit" data-bs-original-title="" title=""></i>
                                        </a>
                                        <a class="btn btn-danger btn-icon btn-sm" data-bs-toggle="tooltip" data-original-title="Delete" data-bs-original-title="" title=""><i class="feather feather-trash-2"></i></a>
                                    </td>
                                </tr></tbody>
                        </table></div></div><div class="row"><div class="col-sm-12 col-md-12"><div class="dataTables_info" id="hr-award_info" role="status" aria-live="polite">Showing 1 to 10 of 11 entries</div></div><div class="col-sm-12 col-md-12"><div class="dataTables_paginate paging_simple_numbers" id="hr-award_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="hr-award_previous"><a href="#" aria-controls="hr-award" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="hr-award" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="hr-award" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="hr-award_next"><a href="#" aria-controls="hr-award" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <!-- ROW -->
    <div class="row row-sm">

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
                                    <th class="border-bottom-0 text-center">Date</th>
                                    <th class="border-bottom-0 text-center">Going Through</th>
                                    <th class="border-bottom-0 text-center">Out Time</th>
                                    <th class="border-bottom-0 text-center">In Time</th>
                                    <th class="border-bottom-0 text-center">Reason</th>
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
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->emp_id }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->going_through }}</td>
                                        <td>{{ $item->out_time }}</td>
                                        <td>{{ $item->in_time }}</td>
                                        <td>{{ $item->reason }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center btn-icon ">
                                                <a href="javascript:void(0);" class="action-btns1 btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#showmodal{{ $item->id }}">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-btns1 btn-danger"
                                                    data-bs-toggle="modal" type="submit" data-bs-target="#deletemodal">
                                                    <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                        data-original-title="danger"></i>
                                                </a>
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
                                    <label for="inputPassword4">Date <i class="fa fa-calendar" data-bs-toggle="tooltip"
                                            title="" data-bs-original-title="fa fa-calendar"
                                            aria-label="fa fa-calendar"></i></label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->date }}" readonly>
                                </div>
                                <div class="form-group    col-md-3 col-sm-3">
                                    <label for="inputPassword4">Going Through</label>
                                    <input type="selected" class="form-control" id="inputPassword4" placeholder="time"
                                        value="{{ $item->going_through }}" readonly>
                                </div>

                                <div class="form-group  col-md-3 col-sm-3 ">
                                    <label for="inputPassword4">Out Time</label>
                                    <input type="text" class="form-control" id="inputPassword4"
                                        placeholder="Password" value="{{ $item->out_time }}" readonly>
                                </div>
                                <div class="form-group  col-md-3 col-sm-3 ">
                                    <label for="inputPassword4">In Time</label>
                                    <input type="time" class="form-control" id="inputPassword4" name="in_time"
                                        {{-- placeholder="Password" value="{{ $item->in_time }}"> --}} placeholder="Password" value="{{ $item->in_time }}">
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
                            <div class="d-flex me-auto">
                                <p class="ms-3"><span><b>Mark Gatepass Approvel</b></span></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-danger mx-2" data-bs-dismiss="modal">Decline</button>
                                <form action="{{ route('admin.gatepassapprove', $item->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success mx-2" type="submit" data-bs-toggle="modal"
                                        data-bs-target="#">Approve</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- delete confirmation --}}
            <div class="modal fade" id="deletemodal" data-bs-backdrop="static">
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
                            <a href="{{ route('admin.gatepassdelete', $item->id) }}" class="btn btn-primary"
                                type="submit">Approve</a>
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
                        <tbody>
                            <tr>
                                <td>Bella</td>
                                <td>Chloe</td>
                                <td>System Developer</td>
                                <td>2018/03/12</td>
                                <td>$654,765</td>
                                <td>b.Chloe@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Donna</td>
                                <td>Bond</td>
                                <td>Account Manager</td>
                                <td>2012/02/21</td>
                                <td>$543,654</td>
                                <td>d.bond@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Harry</td>
                                <td>Carr</td>
                                <td>Technical Manager</td>
                                <td>20011/02/87</td>
                                <td>$86,000</td>
                                <td>h.carr@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Lucas</td>
                                <td>Dyer</td>
                                <td>Javascript Developer</td>
                                <td>2014/08/23</td>
                                <td>$456,123</td>
                                <td>l.dyer@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Karen</td>
                                <td>Hill</td>
                                <td>Sales Manager</td>
                                <td>2010/7/14</td>
                                <td>$432,230</td>
                                <td>k.hill@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Dominic</td>
                                <td>Hudson</td>
                                <td>Sales Assistant</td>
                                <td>2015/10/16</td>
                                <td>$654,300</td>
                                <td>d.hudson@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Herrod</td>
                                <td>Chandler</td>
                                <td>Integration Specialist</td>
                                <td>2012/08/06</td>
                                <td>$137,500</td>
                                <td>h.chandler@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jonathan</td>
                                <td>Ince</td>
                                <td>junior Manager</td>
                                <td>2012/11/23</td>
                                <td>$345,789</td>
                                <td>j.ince@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Leonard</td>
                                <td>Ellison</td>
                                <td>Junior Javascript Developer</td>
                                <td>2010/03/19</td>
                                <td>$205,500</td>
                                <td>l.ellison@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Madeleine</td>
                                <td>Lee</td>
                                <td>Software Developer</td>
                                <td>20015/8/23</td>
                                <td>$456,890</td>
                                <td>m.lee@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Karen</td>
                                <td>Miller</td>
                                <td>Office Director</td>
                                <td>2012/9/25</td>
                                <td>$87,654</td>
                                <td>k.miller@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Lisa</td>
                                <td>Smith</td>
                                <td>Support Lead</td>
                                <td>2011/05/21</td>
                                <td>$342,000</td>
                                <td>l.simth@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Morgan</td>
                                <td>Keith</td>
                                <td>Accountant</td>
                                <td>2012/11/27</td>
                                <td>$675,245</td>
                                <td>m.keith@datatables.net</td>
                            </tr>
                              <tr>
                                <td>Finn</td>
                                <td>Camacho</td>
                                <td>Support Engineer</td>
                                <td>2016/07/07</td>
                                <td>$87,500</td>
                                <td>f.camacho@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Serge</td>
                                <td>Baldwin</td>
                                <td>Data Coordinator</td>
                                <td>2017/04/09</td>
                                <td>$138,575</td>
                                <td>s.baldwin@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zenaida</td>
                                <td>Frank</td>
                                <td>Software Engineer</td>
                                <td>2018/01/04</td>
                                <td>$125,250</td>
                                <td>z.frank@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zorita</td>
                                <td>Serrano</td>
                                <td>Software Engineer</td>
                                <td>2017/06/01</td>
                                <td>$115,000</td>
                                <td>z.serrano@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jennifer</td>
                                <td>Acosta</td>
                                <td>Junior Javascript Developer</td>
                                <td>2017/02/01</td>
                                <td>$75,650</td>
                                <td>j.acosta@datatables.net</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW --> --}}

        <!-- ROW -->
        {{-- <div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Responsive DataTable</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">
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
                        <tbody>
                            <tr>
                                <td>Bella</td>
                                <td>Chloe</td>
                                <td>System Developer</td>
                                <td>2018/03/12</td>
                                <td>$654,765</td>
                                <td>b.Chloe@datatables.net</td>
                            </tr>
                      
                            <tr>
                                <td>Martena</td>
                                <td>Mccray</td>
                                <td>Post-Sales support</td>
                                <td>2011/03/09</td>
                                <td>$324,050</td>
                                <td>m.mccray@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Unity</td>
                                <td>Butler</td>
                                <td>Marketing Designer</td>
                                <td>2014/7/28</td>
                                <td>$34,983</td>
                                <td>u.butler@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Howard</td>
                                <td>Hatfield</td>
                                <td>Office Manager</td>
                                <td>2013/8/19</td>
                                <td>$98,000</td>
                                <td>h.hatfield@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Hope</td>
                                <td>Fuentes</td>
                                <td>Secretary</td>
                                <td>2015/07/28</td>
                                <td>$78,879</td>
                                <td>h.fuentes@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Vivian</td>
                                <td>Harrell</td>
                                <td>Financial Controller</td>
                                <td>2010/02/14</td>
                                <td>$452,500</td>
                                <td>v.harrell@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Timothy</td>
                                <td>Mooney</td>
                                <td>Office Manager</td>
                                <td>20016/12/11</td>
                                <td>$136,200</td>
                                <td>t.mooney@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jackson</td>
                                <td>Bradshaw</td>
                                <td>Director</td>
                                <td>2011/09/26</td>
                                <td>$645,750</td>
                                <td>j.bradshaw@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Olivia</td>
                                <td>Liang</td>
                                <td>Support Engineer</td>
                                <td>2014/02/03</td>
                                <td>$234,500</td>
                                <td>o.liang@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Bruno</td>
                                <td>Nash</td>
                                <td>Software Engineer</td>
                                <td>2015/05/03</td>
                                <td>$163,500</td>
                                <td>b.nash@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Sakura</td>
                                <td>Yamamoto</td>
                                <td>Support Engineer</td>
                                <td>2010/08/19</td>
                                <td>$139,575</td>
                                <td>s.yamamoto@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Thor</td>
                                <td>Walton</td>
                                <td>Developer</td>
                                <td>2012/08/11</td>
                                <td>$98,540</td>
                                <td>t.walton@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Finn</td>
                                <td>Camacho</td>
                                <td>Support Engineer</td>
                                <td>2016/07/07</td>
                                <td>$87,500</td>
                                <td>f.camacho@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Serge</td>
                                <td>Baldwin</td>
                                <td>Data Coordinator</td>
                                <td>2017/04/09</td>
                                <td>$138,575</td>
                                <td>s.baldwin@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zenaida</td>
                                <td>Frank</td>
                                <td>Software Engineer</td>
                                <td>2018/01/04</td>
                                <td>$125,250</td>
                                <td>z.frank@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Zorita</td>
                                <td>Serrano</td>
                                <td>Software Engineer</td>
                                <td>2017/06/01</td>
                                <td>$115,000</td>
                                <td>z.serrano@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Jennifer</td>
                                <td>Acosta</td>
                                <td>Junior Javascript Developer</td>
                                <td>2017/02/01</td>
                                <td>$75,650</td>
                                <td>j.acosta@datatables.net</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
        <!-- END ROW -->

        <!-- ROW -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">File Export</h3>
                    </div>
                    
                    <div class="card-body ">
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
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            {{-- <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                                <table id="file-datatable" class="table card-table table-vcenter key-buttons text-nowrap border-bottom mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Employee Id</th>
                                        <th>Date</th>
                                        <th>Going Through</th>
                                        <th>Out Time</th>
                                        <th>In Time</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex"> <span class="avatar avatar-md brround me-3"
                                                        style="background-image: url(../assets/images/users/1.jpg)">{{ $item->profile_photo }}</span>
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class=" m-0 fs-14">{{ $item->emp_name }}</h6> <span
                                                            class="text-muted m-0 fs-12">{{ $DesignationName->desig_name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->emp_id }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->going_through }}</td>
                                            <td>{{ $item->out_time }}</td>
                                            <td>{{ $item->in_time }}</td>
                                            <td>{{ $item->reason }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td></td>
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
        {{-- <div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Deleted Row DataTable</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <button id="button" class="btn btn-primary mb-4 data-table-btn">Delete selected
                        row</button>
                    <table id="delete-datatable" class="table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Position</th>
                                <th class="border-bottom-0">Office</th>
                                <th class="border-bottom-0">Age</th>
                                <th class="border-bottom-0">Start date</th>
                                <th class="border-bottom-0">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009/01/12</td>
                                <td>$86,000</td>
                            </tr>
                          
                            <tr>
                                <td>Jackson Bradshaw</td>
                                <td>Director</td>
                                <td>New York</td>
                                <td>65</td>
                                <td>2008/09/26</td>
                                <td>$645,750</td>
                            </tr>
                            <tr>
                                <td>Olivia Liang</td>
                                <td>Support Engineer</td>
                                <td>Singapore</td>
                                <td>64</td>
                                <td>2011/02/03</td>
                                <td>$234,500</td>
                            </tr>
                            <tr>
                                <td>Bruno Nash</td>
                                <td>Software Engineer</td>
                                <td>London</td>
                                <td>38</td>
                                <td>2011/05/03</td>
                                <td>$163,500</td>
                            </tr>
                            <tr>
                                <td>Sakura Yamamoto</td>
                                <td>Support Engineer</td>
                                <td>Tokyo</td>
                                <td>37</td>
                                <td>2009/08/19</td>
                                <td>$139,575</td>
                            </tr>
                            <tr>
                                <td>Thor Walton</td>
                                <td>Developer</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>2013/08/11</td>
                                <td>$98,540</td>
                            </tr>
                            <tr>
                                <td>Finn Camacho</td>
                                <td>Support Engineer</td>
                                <td>San Francisco</td>
                                <td>47</td>
                                <td>2009/07/07</td>
                                <td>$87,500</td>
                            </tr>
                            <tr>
                                <td>Serge Baldwin</td>
                                <td>Data Coordinator</td>
                                <td>Singapore</td>
                                <td>64</td>
                                <td>2012/04/09</td>
                                <td>$138,575</td>
                            </tr>
                            <tr>
                                <td>Zenaida Frank</td>
                                <td>Software Engineer</td>
                                <td>New York</td>
                                <td>63</td>
                                <td>2010/01/04</td>
                                <td>$125,250</td>
                            </tr>
                            <tr>
                                <td>Zorita Serrano</td>
                                <td>Software Engineer</td>
                                <td>San Francisco</td>
                                <td>56</td>
                                <td>2012/06/01</td>
                                <td>$115,000</td>
                            </tr>
                            <tr>
                                <td>Jennifer Acosta</td>
                                <td>Junior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>43</td>
                                <td>2013/02/01</td>
                                <td>$75,650</td>
                            </tr>
                            <tr>
                                <td>Cara Stevens</td>
                                <td>Sales Assistant</td>
                                <td>New York</td>
                                <td>46</td>
                                <td>2011/12/06</td>
                                <td>$145,600</td>
                            </tr>
                            <tr>
                                <td>Hermione Butler</td>
                                <td>Regional Director</td>
                                <td>London</td>
                                <td>47</td>
                                <td>2011/03/21</td>
                                <td>$356,250</td>
                            </tr>
                            <tr>
                                <td>Lael Greer</td>
                                <td>Systems Administrator</td>
                                <td>London</td>
                                <td>21</td>
                                <td>2009/02/27</td>
                                <td>$103,500</td>
                            </tr>
                            <tr>
                                <td>Jonas Alexander</td>
                                <td>Developer</td>
                                <td>San Francisco</td>
                                <td>30</td>
                                <td>2010/07/14</td>
                                <td>$86,500</td>
                            </tr>
                            <tr>
                                <td>Shad Decker</td>
                                <td>Regional Director</td>
                                <td>Edinburgh</td>
                                <td>51</td>
                                <td>2008/11/13</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Michael Bruce</td>
                                <td>Javascript Developer</td>
                                <td>Singapore</td>
                                <td>29</td>
                                <td>2011/06/27</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Donna Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27</td>
                                <td>2011/01/25</td>
                                <td>$112,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
        <!-- END ROW -->

        {{-- <!-- ROW -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Responsive Modal DataTable</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Position</th>
                                <th class="border-bottom-0">Office</th>
                                <th class="border-bottom-0">Age</th>
                                <th class="border-bottom-0">Start date</th>
                                <th class="border-bottom-0">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                         
                            <tr>
                                <td>Hermione Butler</td>
                                <td>Regional Director</td>
                                <td>London</td>
                                <td>47</td>
                                <td>2011/03/21</td>
                                <td>$356,250</td>
                            </tr>
                            <tr>
                                <td>Lael Greer</td>
                                <td>Systems Administrator</td>
                                <td>London</td>
                                <td>21</td>
                                <td>2009/02/27</td>
                                <td>$103,500</td>
                            </tr>
                            <tr>
                                <td>Jonas Alexander</td>
                                <td>Developer</td>
                                <td>San Francisco</td>
                                <td>30</td>
                                <td>2010/07/14</td>
                                <td>$86,500</td>
                            </tr>
                            <tr>
                                <td>Shad Decker</td>
                                <td>Regional Director</td>
                                <td>Edinburgh</td>
                                <td>51</td>
                                <td>2008/11/13</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Michael Bruce</td>
                                <td>Javascript Developer</td>
                                <td>Singapore</td>
                                <td>29</td>
                                <td>2011/06/27</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Donna Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27</td>
                                <td>2011/01/25</td>
                                <td>$112,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
        <!-- END ROW -->

        <!-- ROW -->
        {{-- <div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Responsive DataTable</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Position</th>
                                <th class="border-bottom-0">Office</th>
                                <th class="border-bottom-0">Age</th>
                                <th class="border-bottom-0">Start date</th>
                                <th class="border-bottom-0">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            <tr>
                                <td>Shad Decker</td>
                                <td>Regional Director</td>
                                <td>Edinburgh</td>
                                <td>51</td>
                                <td>2008/11/13</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Michael Bruce</td>
                                <td>Javascript Developer</td>
                                <td>Singapore</td>
                                <td>29</td>
                                <td>2011/06/27</td>
                                <td>$183,000</td>
                            </tr>
                            <tr>
                                <td>Donna Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27 </td>
                                <td>2011/01/25</td>
                                <td>$112,000</td>
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
