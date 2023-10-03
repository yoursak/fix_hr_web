{{-- @extends('admin.setting.setting')
--}}
@extends('admin.pagelayout.master')
@section('title')
    Attendance | Create Shift
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

    {{--

<head>
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" />

</head> --}}

    {{-- @endsection
@section('settings') --}}
    <?php
    
    $power = new App\Helpers\MasterRulesManagement\RulesManagement();
    
    ?>
    <div class="row">
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

                                            <h4>Created Leave Policy</h4>
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
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

                                            <div class="col-md-4">
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

                                            <h4>Created Attendance Policy</h4>
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <div class="form-group ">
                                                    <label class="form-label">Attendance Mode</label>
                                                    <select class="form-control select2" name="attendancemode[]"
                                                        data-placeholder="Choose Attendance Mode" multiple required>
                                                        <option label="Choose Attendance Mode">
                                                        </option>
                                                        @empty(!$attendanceModePolicy)
                                                            @foreach ($attendanceModePolicy as $item)
                                                                <?php  
                                                                    if($item->in_premises_auto!=null && $item->in_premises_auto!=0){
                                                                    ?>
                                                                <option value="1">Office&nbsp;|&nbsp;Auto</option>
                                                                <?php  
                                                                    } if(($item->in_premises_qr!=null && $item->in_premises_qr!=0) || ($item->in_premises_face_id!=null && $item->in_premises_face_id!=0) || ($item->in_premises_selfie!=null && $item->in_premises_selfie!=0)){
                                                                    ?>
                                                                <option value="1">Office|Manual</option>
                                                                <?php  }
                                                                    if($item->outdoor_auto!=null && $item->outdoor_auto!=0){?>
                                                                <option value="2">Out Door&nbsp;|&nbsp;Auto</option>
                                                                <?php }if($item->outdoor_selfie!=null && $item->outdoor_selfie!=0){
                                                                    ?>
                                                                <option value="2">Out Door&nbsp;|&nbsp;Manual</option>

                                                                <?php }if($item->wfh_auto!=null && $item->wfh_auto!=0){
                                                                        ?>
                                                                <option value="3">Remote&nbsp;|&nbsp;Auto</option>
                                                                <?php  
                                                                    }if($item->wfh_auto!=null && $item->wfh_auto!=0){
                                                                    ?>
                                                                <option value="3">Remote&nbsp;|&nbsp;Manual</option>

                                                                <?php }?>
                                                            @endforeach
                                                        @endempty

                                                    </select>
                                                </div>
                                                {{-- <div class="form-group">
                                                <label class="form-label">Attendance Mode</label>
                                                <select class="form-control select2" name="weeklypolicy[]"
                                                    data-placeholder="Choose Weekly Policy" multiple>
                                                    @php
                                                    $no=1;
                                                    @endphp
                                                    @empty(!$attendanceModePolicy)
                                                    @foreach ($attendanceModePolicy as $item)
                                                    <option value="<?= $item->id ?>">
                                                        <?= $no++ ?>&nbsp;|&nbsp;
                                                        <?= $item->in_premises_auto ?>&nbsp;
                                                        <?= $item->in_premises_qr ?>&nbsp;
                                                        <?= $item->in_premises_face_id ?>&nbsp;
                                                        <?= $item->in_premises_selfie ?>&nbsp;
                                                        <?= $item->outdoor_auto ?>&nbsp;
                                                        <?= $item->outdoor_selfie ?>&nbsp;
                                                        <?= $item->wfh_auto ?>&nbsp;
                                                        <?= $item->wfh_selfie ?>&nbsp;
                                                    </option>
                                                    @endforeach
                                                    @endempty
                                                </select>
                                            </div> --}}
                                            </div>

                                            {{-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Automation Rules List</label>
                                                <select class="form-control select2" name="automationrules[]"
                                                    data-placeholder="Choose Weekly Policy" multiple>
                                                    @php
                                                    $no=1;
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
                                        </div> --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Track PunchIn/Out List</label>
                                                    <select class="form-control select2" name="trackpunch[]"
                                                        data-placeholder="Choose Weekly Policy" multiple required>
                                                        @empty(!$attendanceTrackInOut->id)
                                                            <option value="1">
                                                                <?php if($attendanceTrackInOut->track_in_out!=null && $attendanceTrackInOut->track_in_out!=0){?>
                                                                <?= 'Track In & Out Time' ?>&nbsp;
                                                                <?php }?>
                                                            </option>
                                                            <option value="2">
                                                                <?php if($attendanceTrackInOut->no_attendace_without_punch!=null && $attendanceTrackInOut->no_attendace_without_punch!=0){?>
                                                                <?= 'No Attendance without punch' ?>&nbsp;
                                                                <?php }?>
                                                            </option>
                                                        @endempty
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Attendance Access List</label>
                                                <select class="form-control select2" name="weeklypolicy[]"
                                                    data-placeholder="Choose Weekly Policy" multiple>
                                                    @php
                                                    $no=1;
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
                                        </div> --}}
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Create Method</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
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

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Final Rule Method Setting</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-10">S.No.</th>
                                    <th class="border-bottom-0">Method Name</th>
                                    <th class="border-bottom-0">Policy Preference</th>
                                    <th class="border-bottom-0">Level Type</th>
                                    <th class="border-bottom-0">Leave Policy list</th>
                                    <th class="border-bottom-0">Holiday Policy list</th>
                                    <th class="border-bottom-0">Weekly Policy List</th>
                                    <th class="border-bottom-0">Shift Policy List</th>
                                    <th class="border-bottom-0">Attendace Policy List</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $j = 1;
                                @endphp
                                @foreach ($FinalEndGameRule as $item)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                                        <td class="font-weight-semibold"><?= $item->method_name ?></td>
                                        <td class="font-weight-semibold"><?= $item->policy_name ?></td>
                                        <td class="font-weight-semibold"><?= $item->level_name ?></td>
                                        <td class="font-weight-semibold"><?= $item->leave_policy_ids_list ?></td>
                                        <td class="font-weight-semibold"><?= $item->holiday_policy_ids_list ?></td>
                                        <td class="font-weight-semibold"><?= $item->weekly_policy_ids_list ?></td>
                                        <td class="font-weight-semibold"><?= $item->shift_settings_ids_list ?></td>
                                        <td class="font-weight-semibold"><?= $item->attendance_mode_list ?></td>

                                        <td>

                                            <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditFixedShiftModel(this)" data-id='<?= $item->id ?>'
                                                data-bs-toggle="modal" data-bs-target="#fixiedshift">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                data-bs-toggle="modal" data-id='<?= $item->id ?>'
                                                data-bs-target="#deleteModal">
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

        <div class="container">
            <div class="modal fade" id="openEditRotationalModel">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Rotational Edit
                                Shift</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" id="setId" name="setId" value="" hidden>
                                        <label class="form-label">Shift Type</label>
                                        <select onchange="" name="shiftType"
                                            class="form-control custom-select select2" data-placeholder="Select Country"
                                            id="shifttype" aria-readonly="true" required>
                                            <option value="2">Rotational Shift</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="UpdateRotationalShift">
                                        <div class="row">
                                            <div class="col-xl-11">
                                                <label class="form-label"> Rotational Shift Name</label>
                                                <input class="form-control mb-4" id="updatedRotationalName"
                                                    value="" placeholder="Enter Shift Name" type="text"
                                                    name="rotationName" required>
                                            </div>
                                            <div class="col-xl-1 text-end mt-5">
                                                <button type="button"
                                                    class="btn btn-outline-primary  add_item_btn_edit"><i
                                                        class="fe fe-plus bold"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <span id="show_item_edit">

                                        </span>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="updateButton">Save
                                changes</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form action="{{ route('delete.shift') }}" method="post">
                        @csrf
                        <input type="text" id="shift_id" name="shift_id" hidden>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Type Name <b>
                                </b></p>
                            <h4 id="load_type_name"></h4><b>
                            </b>

                            <p>Policy Name <b>
                                </b></p>
                            <h4 id="load_name"></h4><b>
                            </b>
                            <p></p>

                            Are you sure you want to delete this item?
                        </div>
                        <div class="modal-footer">
                            <button type="close" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <script>
        function DeleteModel(context) {
            var id = $(context).data('id');
            var shift_ttype = $(context).data('shift_type');
            var shift_type_name = $(context).data('shift_type_name');
            $('#shift_id').val(id);

            // $('#load_type_name').text(shift_ttype);
            // console.log(shift_type_name);
            $('#load_name').text(shift_type_name);

            if (shift_ttype === 1) {
                $('#load_type_name').text('Fixing Type');
            } else if (shift_ttype === 2) {
                $('#load_type_name').text('Rotational Type');
            } else if (shift_ttype === 3) {
                $('#load_type_name').text('Open Type');
            } else {
                // Handle other cases or provide a default
                $('#load_type_name').text('Unknown Type');
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize a counter for unique row IDs

        function openEditRotationalModel(context) {
            let id = $(context).data('id');
            let shift_name = $(context).data('shift_name');
            let shift_ftype = $(context).data('shift_type');

            // Set values for the input fields
            $('#setId').val(id);
            $('#updatedRotationalName').val(shift_name);
            $('#shifttype').val(shift_ftype);


            $.ajax({
                url: "{{ url('/admin/settings/attendance/get_datails') }}",
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',
                success: function(result) {

                    // Clear existing items
                    $('#show_item_edit').empty();
                    console.log(result);
                    $.each(result.get, function(index, item) {
                        appendEditFormItem(item, index);
                        updateRotateFunction(item.id);
                    });
                }
            });
        }
    </script>
@endsection
