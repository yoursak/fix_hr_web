@extends('admin.setupLayout.master')
@section('title')
    Attendance | Create Shift
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

    <div class="iniitial-header m-5">
        <h2><b>FixingDots Pvt.Ltd</b></h2>
        <span class="fs-16">
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Business Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Attendance Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Setup Activation<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Subscription<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Add Employee<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Finish<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
        </span>
    </div>

    <?php
    
    $power = new App\Helpers\MasterRulesManagement\RulesManagement();
    
    ?>
    <div class="row m-5">

        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="page-header d-md-flex d-block">
                <div class="page-leftheader">
                    <div class="page-title">Create Started Templates</div>
                    <p class="text-muted">Create want Started all method working Mode</p>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="d-lg-flex d-block">
                            <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                                    data-bs-toggle="modal" href="#additionalModals" id="btnOpen">Add New Active Method</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- create Method apply --}}
        <div class="container" style="height: 40vh">
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Method Name <span
                                                            class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="methodname"
                                                        id="" placeholder="Method Name" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group ">
                                                    <label class="form-label">Policy Preference</label>
                                                    <select id="policypreference" name="policypreference"
                                                        onchange="LoadPolicyPreference(this)"
                                                        class="form-control select2 custom-select"
                                                        data-placeholder="Choose Policy Preference" required>
                                                        <option label="Choose Policy Preference">
                                                        </option>
                                                        <option value="1" selected>Business Level</option>
                                                        {{-- <option value="2">Employee Level</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="businessleavel">
                                                <div class="form-group ">
                                                    <label class="form-label">Business Level </label>
                                                    <input type="text" id="" name="b_id"
                                                        value="<?= session('business_id') ?>" hidden>
                                                    <input type="text" class="form-control" name="businessname"
                                                        id="" placeholder="Business Name Default"
                                                        value="<?= $BusinessDetails->business_name ?>" disabled required>
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="branchleavel">
                                                <div class="form-group ">
                                                    <label class="form-label">Branch Level </label>
                                                    <select class="form-control select2" name="branhcid[]"
                                                        data-placeholder="Choose Leave Policy" multiple>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$BranchList)
                                                            @foreach ($BranchList as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->branch_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>

                                            <h4>Created Policy</h4>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Shift Settings List</label>
                                                    <select class="form-control select2" name="shiftsetting[]"
                                                        data-placeholder="Choose Weekly Policy" multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$attendanceShiftPolicy)
                                                            @foreach ($attendanceShiftPolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->shift_type_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Leave Policy List</label>
                                                    <select class="form-control select2" name="leavepolicy[]"
                                                        data-placeholder="Choose Leave Policy" multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$LeavePolicy)
                                                            @foreach ($LeavePolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->policy_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Holiday Policy List</label>
                                                    <select class="form-control select2" name="holidaypolicy[]"
                                                        data-placeholder="Choose Holiday Policy" multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$HolidayPolicy)
                                                            @foreach ($HolidayPolicy as $item)
                                                                <option value="<?= $item->temp_id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->temp_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Weekly Policy List</label>
                                                    <select class="form-control select2" name="weeklypolicy[]"
                                                        data-placeholder="Choose Weekly Policy" multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$weeklyPolicy)
                                                            @foreach ($weeklyPolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>

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
        <div class="d-flex justify-content-between me-auto" >
            <div>
                <a href="{{ url('setup/attendance-settings') }}" class="btn btn-primary">Previous</a>
            </div>
        
            <div class="d-flex">
                <a href="{{url('setup/subscription')}}" class="btn btn-primary">Save & Continue</a>
            </div>
        </div>

        {{-- edit section created --}}

        <div class="container">
            <div class="modal fade" id="editMasterCreated">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Method
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{ url('admin/settings/attendance/edit_master_rule') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Active Mode</h3>
                                    </div>

                                    <div class="card-body">
                                        <input type="text" name="edit_id" id="edit_id" hidden>

                                        <input type="text" name="edit_bid" id="edit_bid" hidden>
                                        <div class="row justify-content-center align-items-center g-2">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Method Name <span
                                                            class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="edit_mname"
                                                        id="edit_mname" placeholder="Method Name" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group ">
                                                    <label class="form-label">Policy Preference</label>
                                                    <select id="editpolicypreference" name="editpolicypreference"
                                                        onchange="LoadPolicyPreference(this)"
                                                        class="form-control select2 custom-select"
                                                        data-placeholder="Choose Policy Preference" aria-readonly="true"
                                                        required>
                                                        <option label="Choose Policy Preference">
                                                        </option>
                                                        <option value="1" selected>Business Level</option>
                                                        {{-- <option value="2">Employee Level</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="editbusinessleavel">
                                                <div class="form-group ">
                                                    <label class="form-label">Business Level </label>
                                                    <input type="text" id="b_id" name="b_id"
                                                        value="<?= session('business_id') ?>" hidden>
                                                    <input type="text" class="form-control" name="businessname"
                                                        id="" placeholder="Business Name Default"
                                                        value="<?= $BusinessDetails->business_name ?>" readonly required>
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="editbranchleavel">
                                                <div class="form-group ">
                                                    <label class="form-label">Branch Level </label>
                                                    <select class="form-control select2" name="editbranhcid[]"
                                                        data-placeholder="Choose Leave Policy" multiple>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$BranchList)
                                                            @foreach ($BranchList as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->branch_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>

                                            <h4>Created Policy</h4>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Shift Settings List</label>
                                                    <select class="form-control select2" id="editshiftsetting"
                                                        name="editshiftsetting[]" data-placeholder="Choose Shift Policy"
                                                        multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$attendanceShiftPolicy)
                                                            @foreach ($attendanceShiftPolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->shift_type_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Leave Policy List</label>
                                                    <select class="form-control select2" id="editleavepolicy"
                                                        name="editleavepolicy[]" data-placeholder="Choose Leave Policy"
                                                        multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$LeavePolicy)
                                                            @foreach ($LeavePolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->policy_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Holiday Policy List</label>
                                                    <select class="form-control select2" id="editholidaypolicy"
                                                        name="editholidaypolicy[]"
                                                        data-placeholder="Choose Holiday Policy" multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$HolidayPolicy)
                                                            @foreach ($HolidayPolicy as $item)
                                                                <option value="<?= $item->temp_id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->temp_name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Weekly Policy List</label>
                                                    <select class="form-control select2" id="editweeklypolicy"
                                                        name="editweeklypolicy[]" data-placeholder="Choose Weekly Policy"
                                                        multiple required>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @empty(!$weeklyPolicy)
                                                            @foreach ($weeklyPolicy as $item)
                                                                <option value="<?= $item->id ?>">
                                                                    <?= $no++ ?>&nbsp;|&nbsp;
                                                                    <?= $item->name ?>&nbsp;
                                                                </option>
                                                            @endforeach
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Update Method
                                    Apply</button>
                            </div>
                        </form>

                    </div>
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
        function callBack(business_id, eid) {

            $('.custom-switch-checkbox').on('change', function() {
                // console.log($('.custom-switch-checkbox').val());
                if ($(this).is(':checked')) {
                    // Checkbox is checked, show a SweetAlert2 success alert
                    Swal.fire({
                        timer: 2000,
                        timerProgressBar: true,
                        title: 'Method is Active Mode!',
                        icon: 'success'
                    }).then(function() {
                        values(1, business_id, eid);
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
                        values(0, business_id, eid);
                        window.location.reload(true);

                        // window.location.reload(true);
                    });
                }

            });
        }

        function values(load, business_id, eid) {
            console.log(load, business_id, eid);
            $.ajax({
                url: "{{ url('admin/settings/attendance/mode_master_rule') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    b_id: business_id,
                    e_id: eid,
                    checked: load
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                }
            });

        }

        function openEditMasterPolicy(context) {
            var id = $(context).data('id');
            var bID = $(context).data('b_id');
            var switchload = $(context).data('switch');
            console.log(id);
            $('#edit_id').val(id);
            $('#edit_bid').val(bID);
            $.ajax({
                url: "{{ url('admin/settings/attendance/get_master_rule') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    e_id: id,
                    b_id: bID,
                    switch: switchload
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);

                    // loader UPDATED
                    // if (result[0] != null) {
                    $('#edit_mname').val(result.method_name);
                    $('#b_id').val(result.business_id);
                    // Parse JSON-encoded strings into JavaScript arrays for multiple selects
                    var selectedLeavePolicies = JSON.parse(result.leave_policy_ids_list);
                    var selectedHolidayPolicies = JSON.parse(result.holiday_policy_ids_list);
                    var selectedWeeklyPolicies = JSON.parse(result.weekly_policy_ids_list);
                    var selectedShiftSettings = JSON.parse(result.shift_settings_ids_list);

                    $('#editleavepolicy').val(selectedLeavePolicies);
                    $('#editholidaypolicy').val(selectedHolidayPolicies);
                    $('#editweeklypolicy').val(selectedWeeklyPolicies);
                    $('#editshiftsetting').val(selectedShiftSettings);
                    $('#editleavepolicy,#editholidaypolicy, #editweeklypolicy, #editshiftsetting').trigger(
                        'change');
                    // }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                }
            });
        }
    </script>
@endsection
