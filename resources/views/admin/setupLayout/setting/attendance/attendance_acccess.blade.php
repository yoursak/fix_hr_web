{{-- @extends('admin.setting.setting')
--}}
@extends('admin.setupLayout.master')
@section('title')
    Attendance Access
@endsection
@section('js')
@endsection
@section('css')
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
@endsection

@section('content')

<div class=" p-0 pt-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/attendance')}}">Settings</a></li>
        <li><a href="{{ url('admin/settings/attendance')}}">Attendace Setting</a></li>

        <li class="active"><span><b>Attendance Access</b></span></li>
    </ol>
</div>
    {{--



    {{-- @endsection
@section('settings') --}}
    <?php
    
    $power = new App\Helpers\MasterRulesManagement\RulesManagement();
    
    ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="page-header d-md-flex d-block">
                <div class="page-leftheader">
                    <div class="page-title"> Attendance Access</div>
                    <p class="text-muted">Create want Started all method working Mode</p>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="d-lg-flex d-block">
                            {{-- <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                                    data-bs-toggle="modal" href="#additionalModals" id="btnOpen">Add New Active Method</a>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- create Method apply --}}
        <div class="container">
            <div class="modal fade" id="additionalModals">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Create Method
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('attendance.endgameSubmit') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Create Active Mode</h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="row justify-content-center align-items-center g-2">


                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Create Method
                                    Apply</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- table view --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Access</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-10">S.No.</th>
                                    <th class="border-bottom-0">Emp ID</th>
                                    <th class="border-bottom-0">Emp Name</th>
                                    <th class="border-bottom-0">Mode Name</th>
                                    <th class="border-bottom-0">Shift Name</th>

                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $j = 1;
                                    // dd($EmployeeInfomation);
                                @endphp
                                @foreach ($EmployeeInfomation as $item)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                                        <td class="font-weight-semibold">{{ $item->emp_id }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                    style="background-image: url('/employee_profile/{{ $item->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">{{ $item->emp_name }}</h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?=$item->depart_name ?> |<?= $item->desig_name ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td class="font-weight-semibold">{{$item->emp_name}}
                                        </td> --}}
                                        <td class="font-weight-semibold">{{ $item->method_name }}
                                        </td>
                                        <td class="font-weight-semibold">{{ $item->name }}
                                        </td>

                                        <td>
                                            <?php $ID = $item->emp_id; ?>

                                            <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditMasterPolicy(this)" data-id='<?= $ID ?>'
                                                data-b_id='<?= $item->business_id ?>'
                                                data-switch='<?= $item->method_switch ?? false && $item->method_switch != 0 ? $item->method_switch : 0 ?>'
                                                data-bs-toggle="modal" data-bs-target="#editMasterCreated">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="DeleteMasterModel(this)" data-ids='<?= $ID ?>'
                                                data-b_id='<?= $item->business_id ?>'
                                                data-loaded='<?= $method_name ?? false ? $method_name : '' ?>'
                                                data-bs-toggle="modal"
                                                data-bs-target="#editdeleteModal">
                                                <i class="feather feather-trash" data-bs-toggle="tooltip"
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

        {{-- edit section created --}}



        <div class="modal fade" id="editdeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form action="{{ url('admin/settings/attendance/delete_master_rule') }}" method="post">
                        @csrf
                        <input type="text" id="shiftid" name="id" hidden>

                        <input type="text" id="bl" name="bid" hidden>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</a>
                        </div>
                        <div class="modal-body">

                            <p>Method Name <b>
                                </b></p>
                            <h4 id="load_name"></h4><b>
                            </b>
                            <p></p>

                            Are you sure you want to delete this item?
                        </div>
                        <div class="modal-footer">
                            <a type="close" class="btn  btn-secondary" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function DeleteMasterModel(context) {
            var idss = $(context).data('ids');
            var b_id = $(context).data('b_id');
            var asdd = $(context).data('loaded');
            // console.log(asdd);
            $('#shiftid').val(idss);
            $('#bl').val(b_id);
            $('#load_name').text(asdd);
        }
    </script>
    <script>
        document.getElementById("branchleavel").style.display = "none";

        function LoadPolicyPreference() {
            document.getElementById("businessleavel").style.display = "none";
            var selectedValue = document.getElementById("policypreference").value;

            if (selectedValue === "1") {
                document.getElementById("businessleavel").style.display = "block";
                document.getElementById("branchleavel").style.display = "none";
            }
            if (selectedValue === "2") {
                document.getElementById("businessleavel").style.display = "none";
                document.getElementById("branchleavel").style.display = "block";
            }
        }
    </script>

    <script>
        document.getElementById("editbranchleavel").style.display = "none";

        function LoadPolicyPreference() {
            document.getElementById("editbusinessleavel").style.display = "none";
            var selectedValue = document.getElementById("editpolicypreference").value;

            if (selectedValue === "1") {
                document.getElementById("editbusinessleavel").style.display = "block";
                document.getElementById("editbranchleavel").style.display = "none";
            }
            if (selectedValue === "2") {
                document.getElementById("editbusinessleavel").style.display = "none";
                document.getElementById("editbranchleavel").style.display = "block";
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#custom-switch-checkbox').on('change', function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked, show a SweetAlert2 success alert
                    Swal.fire({
                        timer: 2000,
                        timerProgressBar: true,
                        title: 'Method is Active Mode!',
                        icon: 'success'
                    }).then(function() {
                        callBack(1);
                        // Reload the page
                        window.location.reload(true);
                    });
                } else {
                    // Checkbox is unchecked, show a SweetAlert2 info alert
                    Swal.fire({
                        timer: 2000,
                        timerProgressBar: true,
                        title: 'Method is Deactive Mode!',
                        icon: 'info'
                    }).then(function() {
                        callBack(0);
                        window.location.reload(true);

                        // Reload the page
                    });
                }

            });


        });

        function openEditMasterPolicy(context) {
            var id = $(context).data('id');
            var bID = $(context).data('b_id');
            var switchload = $(context).data('switch');
            console.log(bID);

            $.ajax({
                url: "{{ url('admin/settings/attendance/get_master_rule') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    b_id: bID,
                    switch: switchload
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);

                    if (result[0] != null) {
                        $('#edit_mname').val(result[0].method_name);
                        $('#b_id').val(result[0].business_id);
                        // Parse JSON-encoded strings into JavaScript arrays for multiple selects
                        var selectedLeavePolicies = JSON.parse(result[0].leave_policy_ids_list);
                        var selectedHolidayPolicies = JSON.parse(result[0].holiday_policy_ids_list);
                        var selectedWeeklyPolicies = JSON.parse(result[0].weekly_policy_ids_list);
                        var selectedShiftSettings = JSON.parse(result[0].shift_settings_ids_list);

                        $('#editleavepolicy').val(selectedLeavePolicies);
                        $('#editholidaypolicy').val(selectedHolidayPolicies);
                        $('#editweeklypolicy').val(selectedWeeklyPolicies);
                        $('#editshiftsetting').val(selectedShiftSettings);
                        $('#editleavepolicy,#editholidaypolicy, #editweeklypolicy, #editshiftsetting').trigger(
                            'change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                }
            });
        }

        function callBack(load) {

            $.ajax({
                url: "{{ url('admin/settings/attendance/mode_master_rule') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    checked: load
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                }
            });
        }
    </script>
@endsection
