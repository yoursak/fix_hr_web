@extends('admin.setting.setting')
@section('subtitle')
    Attendance Access
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

        .activeBtn {
            background: #fff;
            color:
        }
    </style>
@endsection
@section('settings')
    @php
        $Branch = new App\Helpers\Central_unit();
        $BranchList = $Branch->BranchList();
        // $Department = App\Helpers\Central_unit::DepartmentList();
        // dd($BranchList);
    @endphp
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Attendance Access</div>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <a type="button" class="modal-effect btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createAccess">Create Access</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap border-bottom" id="file-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">S.No.</th>
                                <th class="border-bottom-0">Template Name</th>
                                <th class="border-bottom-0">Mode</th>
                                <th class="border-bottom-0">Department</th>
                                <th class="border-bottom-0">Branch</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Temp as $key => $temp)
                                <tr>
                                    <th class="border-bottom-0">{{ $key }}</th>
                                    <th class="border-bottom-0">{{ $temp->temp_name }}</th>
                                    <?php if($temp->attendance_mode == 0){ ?>
                                    <th class="border-bottom-0">Office</th>
                                    <?php }else if($temp->attendance_mode == 1){ ?>
                                    <th class="border-bottom-0">Out Door</th>
                                    <?php }else{ ?>
                                    <th class="border-bottom-0">Work From Office</th>
                                    <?php }?>
                                    <th class="border-bottom-0">{{ $temp->department_id }}</th>
                                    <th class="border-bottom-0">{{ $temp->branch_id }}</th>
                                    <th class="border-bottom-0">
                                        <div class="d-flex">
                                            <a class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#updateAccess">Edit</a>
                                            <a class="btn btn-sm btn-danger mx-1">Delete</a>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                            <!-- Add more table rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- attendance mode modal --}}
    


    {{-- create attendance mode modal --}}
    <div class="container">
        <div class="modal fade" id="createAccess">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Attendance Access</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Template Name</label>
                                        <input class="form-control mb-4" value="" id="accessTempName"
                                            placeholder="Enter Template Name" type="text" name="accessTempName" required>

                                    </div>
                                    <div class="col-12 d-flex my-2">
                                        <label class="form-label">Attendance Mode :</label>
                                        <div class="row mx-2">
                                            {{-- @dd($AttMode) --}}

                                            <?php if($AttMode->in_premises_auto == 1 || $AttMode->in_premises_qr == 1 || $AttMode->in_premises_face_id == 1 || $AttMode->in_premises_selfie == 1){ ?>
                                            <label class="custom-control custom-radio mx-2">
                                                <input type="radio" class="custom-control-input" name="tempMode"
                                                    id="inPremises" value="0">
                                                <span class="custom-control-label"><b>Office</b></span>
                                            </label>

                                            <?php } if($AttMode->outdoor_auto == 1 || $AttMode->outdoor_selfie == 1){ ?>
                                            <label class="custom-control custom-radio mx-2">
                                                <input type="radio" class="custom-control-input" name="tempMode"
                                                    id="outDoor" value="1">
                                                <span class="custom-control-label"><b>Out Door</b></span>
                                            </label>
                                            <?php } if($AttMode->wfh_auto == 1 || $AttMode->wfh_selfie == 1){ ?>
                                            <label class="custom-control custom-radio mx-2">
                                                <input type="radio" class="custom-control-input" name="tempMode"
                                                    id="wfh" value="2">
                                                <span class="custom-control-label"><b>Work From Home</b></span>
                                            </label>
                                            <?php } ?>

                                            <?php if($AttMode->in_premises_auto != 1 && $AttMode->in_premises_qr != 1 && $AttMode->in_premises_face_id != 1 && $AttMode->in_premises_selfie != 1){ ?>
                                                <span class="text-primary">Attendance Mode is Not Seted Yet. <br><span class="text-muted fs-12">Attendance Setting > Attendance Mode</span></span>
                                                <?php }else{ ?>''<?php } ?>

                                            
                                        </div>
                                    </div>
                                    <div class="col-12 my-2 rounded">
                                        <div class="d-flex sm-d-block justify-content-between">
                                            <label class="form-label my-auto">Attendance Preference :</label>
                                            <div class="d-flex bg-primary p-1 rounded">
                                                <button class="btn btn-sm activeBtn text-primary" id="businessBtn"
                                                    onclick="businessBtn()"><b>Business</b></button>
                                                <button class="btn btn-sm text-light" id="employeeBtn"
                                                    onclick="employeeBtn()"><b>Employee</b></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 d-none" id="empElem">
                                        <label class="form-label">Applied to your Business : <span
                                                class="text-primary">{{ $BusinessDetails->business_name }}</span></label>
                                        <input type="text" name="businessName"
                                            value="{{ $BusinessDetails->business_id }}" hidden />
                                        <div class="text-end">
                                            <a type="submit" class="btn btn-sm btn-primary" onclick="submitBusiness()">
                                                save
                                                & continoue</a>
                                        </div>
                                        <script>
                                            function submitBusiness() {
                                                var accessTempName = document.getElementById('accessTempName').value;

                                                var inPremises = document.getElementById('inPremises');
                                                var outDoor = document.getElementById('outDoor');
                                                var wfh = document.getElementById('wfh');

                                                if (inPremises.checked == true) {
                                                    var mode = 0;
                                                } else if (outDoor.checked == true) {
                                                    var mode = 1;
                                                } else {
                                                    var mode = 2;
                                                }

                                                $.ajax({
                                                    url: "{{ url('add/attendance-access') }}",
                                                    type: "POST",
                                                    data: {
                                                        _token: '{{ csrf_token() }}',
                                                        accessTempName,
                                                        mode,
                                                        'branchId': 'all',
                                                        'departmentId': 'all'
                                                    },
                                                    dataType: 'json',
                                                    success: function(result) {

                                                        location.reload();
                                                        console.log(result);

                                                    }
                                                });
                                            }
                                        </script>
                                    </div>

                                    <div class="row my-2 d-none" id="busiElem">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <p class="form-label">Branch</p>
                                                <select name='branch_id' onchange="getDepartment(this)" id="country-dd"
                                                    class="form-control" required>
                                                    <option value="">Select Branch Name</option>
                                                    @foreach ($BranchList as $data)
                                                        <option value="{{ $data->branch_id }}">
                                                            {{ $data->branch_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <p class="form-label">Department</p>
                                                <div class="form-group mb-3">
                                                    <select id="state-dd" onchange="printDepartment(this)"
                                                        name="department_id" class="form-control" required>
                                                        <option value="">Select Deparment Name</option>
                                                        <option value="">Select All Department Name</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Applied to : <span class="text-primary"
                                                    id="DepartmentName"></span></label>
                                        </div>
                                        <div class="text-end">
                                            <a type="submit" class="btn btn-sm btn-primary" onclick="submitEmployee()">
                                                save
                                                & continoue</a>
                                        </div>
                                        <script>
                                            function submitEmployee() {
                                                var accessTempName = document.getElementById('accessTempName').value;
                                                var branchId = document.getElementById('country-dd').value;
                                                var departmentId = document.getElementById('state-dd').value;

                                                var inPremises = document.getElementById('inPremises');
                                                var outDoor = document.getElementById('outDoor');
                                                var wfh = document.getElementById('wfh');

                                                if (inPremises.checked == true) {
                                                    var mode = 0;
                                                } else if (outDoor.checked == true) {
                                                    var mode = 1;
                                                } else {
                                                    var mode = 2;
                                                }

                                                $.ajax({
                                                    url: "{{ url('add/attendance-access') }}",
                                                    type: "POST",
                                                    data: {
                                                        _token: '{{ csrf_token() }}',
                                                        accessTempName,
                                                        branchId,
                                                        departmentId,
                                                        mode
                                                    },
                                                    dataType: 'json',
                                                    success: function(result) {

                                                        location.reload();
                                                        console.log(result);

                                                    }
                                                });
                                            }


                                            function printDepartment(e) {
                                                var printElem = document.getElementById('DepartmentName');
                                                console.log(e);
                                                printElem.innerHTML = '';
                                                printElem.innerHTML = e.options[e.selectedIndex].text;

                                            }

                                            function getDepartment(e) {
                                                var branch_id = e.value;
                                                // alert(branch_id);
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

                                                        console.log(result.department[0].branch_id);
                                                        $('#state-dd').html(
                                                            '<option value="all" name="department">All Department</option>'
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
                                            }
                                        </script>
                                    </div>

                                    <script>
                                        function businessBtn() {
                                            var businessBtn = document.getElementById('businessBtn');
                                            var employeeBtn = document.getElementById('employeeBtn');
                                            businessBtn.classList.add('activeBtn', 'text-primary');
                                            businessBtn.classList.remove('text-light');
                                            employeeBtn.classList.add('text-light');
                                            employeeBtn.classList.remove('activeBtn', 'text-primary');

                                            var empElem = document.getElementById('empElem').classList.remove('d-none');
                                            var busiElem = document.getElementById('busiElem').classList.add('d-none');


                                        }

                                        function employeeBtn() {
                                            var businessBtn = document.getElementById('businessBtn');
                                            var employeeBtn = document.getElementById('employeeBtn');


                                            employeeBtn.classList.add('activeBtn', 'text-primary');
                                            employeeBtn.classList.remove('text-light');
                                            businessBtn.classList.remove('activeBtn', 'text-primary');
                                            businessBtn.classList.add('text-light');

                                            var empElem = document.getElementById('empElem').classList.add('d-none');
                                            var busiElem = document.getElementById('busiElem').classList.remove('d-none');
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </div>


@endsection
