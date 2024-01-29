@extends('admin.setupLayout.master')
@section('title')
    Setup Activation | Create Shift
@endsection
@section('css')
    <style>
        .nav-link.icon {
            line-height: 0;
        }

        .modal-header,
        .modal-footer {
            /* background-color: #f8f8ff; */
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

@if (in_array('Setup Activation.View', $permissions) || in_array('Setup Activation.All', $permissions))
    @section('content')
        <style>
            .custom-switch-indicator {
                background: red;
                /* Change this to the desired red color */
            }
        </style>
        <div class="iniitial-header my-5">
            <h2 class="m-0"><b>Welcome to FixHR</b></h2>

            <p class="fs-16 text-muted">Kindly complete step by step process to register your business with us, do not skip
                setup
                process other wise it will not function</p>

            <span class="fs-16">
                <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Settings<i
                        class="fa fa-angle-right my-auto mx-2"></i></span>
                <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Business Settings<i
                        class="fa fa-angle-right my-auto mx-2"></i></span>
                <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Attendance Settings<i
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
        <div class="row">
            {{-- create Method apply --}}
            <div class="container">
                <div class="modal fade" id="additionalModals" data-bs-backdrop="static">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header p-5">
                                <h5 class="modal-title" id="exampleModalLongTitle">Create Setup
                                </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('attendance.endgameSubmit') }}" id="createMethodForm" method="post">
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
                                                        <label class="form-label">Setup Name <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="methodname"
                                                            id="" placeholder="Setup Name" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="form-label">Policy Preference <span
                                                                class="text-red">*</span></label>
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
                                                        <label class="form-label">Business Name <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" id="" name="b_id"
                                                            value="<?= session('business_id') ?>" hidden>
                                                        <input type="text" class="form-control" name="businessname"
                                                            id="" placeholder="Business Name Default"
                                                            value="<?= $BusinessDetails->business_name ?>" disabled
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" id="branchleavel">
                                                    <div class="form-group ">
                                                        <label class="form-label">Branch Level <span
                                                                class="text-red">*</span></label>
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
                                                        <label class="form-label">Shift Settings <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2 custom-select"
                                                            name="shiftsetting[]" data-placeholder="Choose Shift Policy"
                                                            multiple required>
                                                            <option label="Choose Shift Policy"></option>
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

                                                    <div class="form-group ">
                                                        <label class="form-label">Leave Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2 custom-select"
                                                            id="leavepolicy" name="leavepolicy"
                                                            data-placeholder="Choose Leave Policy" required>
                                                            <option label="Choose Leave Policy"></option>

                                                            @empty(!$LeavePolicy)
                                                                @foreach ($LeavePolicy as $item)
                                                                    <option value="<?= $item->id ?>">

                                                                        <?= $item->policy_name ?>&nbsp;
                                                                    </option>
                                                                @endforeach
                                                            @endempty
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label"> Holiday Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2" name="holidaypolicy"
                                                            data-placeholder="Choose Holiday Policy" required>
                                                            <option label="Choose Holiday Policy"></option>

                                                            @empty(!$HolidayPolicy)
                                                                @foreach ($HolidayPolicy as $item)
                                                                    <option value="<?= $item->temp_id ?>">
                                                                        <?= $item->temp_name ?>&nbsp;
                                                                    </option>
                                                                @endforeach
                                                            @endempty

                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label"> Weekly Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2" name="weeklypolicy"
                                                            data-placeholder="Choose Weekly Policy" required>
                                                            <option label="Choose Weekly Policy"></option>

                                                            @empty(!$weeklyPolicy)
                                                                @foreach ($weeklyPolicy as $item)
                                                                    <option value="<?= $item->id ?>">
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
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit" id="CreateMethod">Save &
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

                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h3 class="card-title">Final Rule Settings</h3>
                        </div>
                        <div class="d-flex">
                            @if (in_array('Setup Activation.Create', $permissions) || in_array('Setup Activation.All', $permissions))
                                <div class="btn-list d-flex">
                                    <a class="modal-effect btn btn-primary mx-3 ms-auto" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#additionalModals" id="btnOpen">Create Setup</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-0   ">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap  border-bottom ">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0 w-10">S.No.</th>
                                        <th class="border-bottom-0">Setup Name</th>
                                        <th class="border-bottom-0">Setup On/Off</th>
                                        <th class="border-bottom-0">Associated Employee</th>
                                        <th class="border-bottom-0">Policy Preference</th>
                                        <th class="border-bottom-0">Level Type</th>
                                        <th class="border-bottom-0">Shift Policy List</th>
                                        <th class="border-bottom-0">Leave Policy list</th>
                                        <th class="border-bottom-0">Holiday Policy list</th>
                                        <th class="border-bottom-0">Weekly Policy List</th>
                                        <th class="border-bottom-0">Attendance Policy List</th>
                                        <!-- <th class="border-bottom-0">Track Policy List</th> -->
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $j = 1;
                                    @endphp
                                    @if (!$FinalEndGameRule->isEmpty())
                                        @foreach ($FinalEndGameRule as $item)
                                            <tr>
                                                <td class="font-weight-semibold">{{ $j++ }}.</td>
                                                <td class="font-weight-semibold">
                                                    <?php
                                                    $method_name = $item->method_name;
                                                    $load_id = $item->id;
                                                    echo $method_name; ?>
                                                </td>
                                                <td>
                                                    <div class="col-xl-3 pe-0">
                                                        @if (in_array('Setup Activation.Update', $permissions) || in_array('Setup Activation.All', $permissions))
                                                            <label class="custom-switch">
                                                                <input type="checkbox" id="custom-switch-checkbox"
                                                                    onclick="callBack('{{ $item->business_id }}', '{{ $item->id }}','{{ $item->holiday_policy_ids_list }}','{{ $item->weekly_policy_ids_list }}')"
                                                                    name="custom-switch-checkbox"
                                                                    class="custom-switch-input custom-switch-checkbox"
                                                                    <?= $item->method_switch !== 0 ? 'checked' : '' ?>>
                                                                <span class="custom-switch-indicator"></span>
                                                                <span
                                                                    class="custom-switch-description">Enable/Disable</span>
                                                            </label>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="font-weight-semibold">
                                                    @php
                                                        $CountingAssociated = $power->AssociatedUser($item->id)[0];
                                                        print_r($CountingAssociated);
                                                    @endphp
                                                </td>

                                                <td class="font-weight-semibold">
                                                    <?= $item->policy_name ?>
                                                </td>
                                                <td class="font-weight-semibold">
                                                    <?= $item->level_name ?>
                                                </td>
                                                <td class="font-weight-semibold">
                                                    <?php
                                                    // Decode the JSON string into an array of IDs
                                                    if ($item->shift_settings_ids_list ?? false) {
                                                        $shiftlist = json_decode($item->shift_settings_ids_list);

                                                        if ($shiftlist !== null) {
                                                            // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                                            // Loop through the IDs and display the corresponding names
                                                            foreach ($shiftlist as $id) {
                                                                // Call the GetValues function to retrieve the object
                                                                $load = $power->GetValues($id)[3];

                                                                if ($load !== null) {
                                                                    // Check if the object is not null
                                                                    echo $load->name . ' | ' . $load->shift_type_name . ' ,<br>'; // Add a comma and space between names if needed
                                                                } else {
                                                                    // Handle cases where an object is not found
                                                                    echo 'Unknown'; // You can use a default value or an appropriate message here
                                                                }
                                                            }
                                                        } else {
                                                            // Handle cases where the JSON is invalid or empty
                                                            echo 'Unknown'; // You can use a default value or an appropriate message here
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td class="font-weight-semibold">
                                                    <?php
                                                    $load = $power->GetValues($item->leave_policy_ids_list)[0];
                                                    if ($load !== null) {
                                                        // Check if the object is not null
                                                        echo $load->policy_name; // Add a comma and space between names if needed
                                                    } else {
                                                        // Handle cases where an object is not found
                                                        echo 'empty'; // You can use a default value or an appropriate message here
                                                    }

                                                    ?>
                                                </td>
                                                <td class="font-weight-semibold">
                                                    <?php
                                                    $load = $power->GetValues($item->holiday_policy_ids_list)[1];
                                                    if ($load !== null) {
                                                        // Check if the object is not null
                                                        echo $load->temp_name; // Add a comma and space between names if needed
                                                    } else {
                                                        // Handle cases where an object is not found
                                                        echo 'empty'; // You can use a default value or an appropriate message here
                                                    }

                                                    ?>
                                                </td>



                                                <td class="font-weight-semibold">
                                                    <?php
                                                    $load = $power->GetValues($item->weekly_policy_ids_list)[2];
                                                    if ($load !== null) {
                                                        // Check if the object is not null
                                                        echo $load->name; // Add a comma and space between names if needed
                                                    } else {
                                                        // Handle cases where an object is not found
                                                        echo 'empty'; // You can use a default value or an appropriate message here
                                                    }

                                                    ?>
                                                </td>

                                                <td class="font-weight-semibold">
                                                    @empty(!$attendanceModePolicy)
                                                        @foreach ($attendanceModePolicy as $item)
                                                            <?php
                                                            if ($item->office_auto != null && $item->office_auto != 0) {
                                                            ?>
                                                            <span>Office&nbsp;|&nbsp;Auto</span>
                                                            <?php
                                                            }
                                                            if (($item->office_qr != null && $item->office_qr != 0) || ($item->office_face_id != null && $item->office_face_id != 0) || ($item->office_selfie     != null && $item->office_selfie     != 0)) {
                                                            ?>
                                                            <span>Office&nbsp;|&nbsp;Manual</span>
                                                            <?php  }
                                                            if ($item->outdoor_auto != null && $item->outdoor_auto != 0) { ?>
                                                            <span> Out Door&nbsp;|&nbsp;Auto</span>
                                                            <?php }
                                                            if ($item->outdoor_selfie != null && $item->outdoor_selfie != 0) {
                                                            ?>
                                                            <span>Out Door&nbsp;|&nbsp;Manual</span>

                                                            <?php }
                                                            if ($item->wfh_auto != null && $item->wfh_auto != 0) {
                                                            ?>
                                                            <span> Remote&nbsp;|&nbsp;Auto</span>
                                                            <?php
                                                            }
                                                            if ($item->wfh_selfie != null && $item->wfh_selfie != 0) {
                                                            ?>
                                                            <span> Remote&nbsp;|&nbsp;Manual</span>

                                                            <?php } ?>
                                                        @endforeach
                                                    @endempty
                                                </td>


                                                <td>
                                                    @if (in_array('Setup Activation.Update', $permissions) || in_array('Setup Activation.All', $permissions))
                                                        <a class="btn btn-primary btn-icon btn-sm"
                                                            href="javascript:void(0);"
                                                            onclick="openEditMasterPolicy(this)" data-id='<?= $load_id ?>'
                                                            data-b_id='<?= $item->business_id ?>'
                                                            data-switch='<?= $item->method_switch ?? false && $item->method_switch != 0 ? $item->method_switch : 0 ?>'
                                                            data-bs-toggle="modal" data-bs-target="#editMasterCreated">
                                                            <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                                data-original-title="View/Edit"></i>
                                                        </a>
                                                    @endif
                                                    @if (in_array('Setup Activation.Delete', $permissions) || in_array('Setup Activation.All', $permissions))
                                                        <a class="btn btn-danger btn-icon btn-sm"
                                                            href="javascript:void(0);" onclick="DeleteMasterModel(this)"
                                                            data-ids='<?= $load_id ?>'
                                                            data-b_id='<?= $item->business_id ?>'
                                                            data-loaded='<?= $method_name ?? false ? $method_name : '' ?>'
                                                            data-bs-toggle="modal" data-bs-target="#editdeleteModal">
                                                            <i class="feather feather-trash" data-bs-toggle="tooltip"
                                                                data-original-title="View/Edit"></i>
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- edit section created --}}
            <div class="container">
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="modalForm">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deactivation</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" data-bs-dismiss="modal">×</span>
                                    </button>
                                    <!-- <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</a> -->
                                </div>
                                <div class="modal-body">

                                    <p> The Associated Policy Will Not Function if You Deactivate The Setup. </p>

                                </div>
                                <div class="modal-footer">
                                    <!-- <a type="close" class="btn  btn-secondary" data-bs-dismiss="modal">Cancel</a> -->
                                    <button class="btn btn-secondary" id="cancelButton" onclick="loadedCall(this)"
                                        type="reset" value="1" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger" onclick="loadedCall(this)" value="0"
                                        type="submit">Deactivated</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="modal fade" id="editMasterCreated" data-bs-backdrop="static">
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
                                                        <label class="form-label">Setup Name <span
                                                                class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="edit_mname"
                                                            id="edit_mname" placeholder="Setup Name" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group ">
                                                        <label class="form-label">Policy Preference <span
                                                                class="text-red">*</span></label>
                                                        <select id="editpolicypreference" name="editpolicypreference"
                                                            onchange="LoadPolicyPreference(this)"
                                                            class="form-control select2 custom-select"
                                                            data-placeholder="Choose Policy Preference"
                                                            aria-readonly="true" required>
                                                            <option label="Choose Policy Preference">
                                                            </option>
                                                            <option value="1" selected>Business Level</option>
                                                            {{-- <option value="2">Employee Level</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="editbusinessleavel">
                                                    <div class="form-group ">
                                                        <label class="form-label">Business Name <span
                                                                class="text-red">*</span> </label>
                                                        <input type="text" id="b_id" name="b_id"
                                                            value="<?= session('business_id') ?>" hidden>
                                                        <input type="text" class="form-control" name="businessname"
                                                            id="" placeholder="Business Name Default"
                                                            value="<?= $BusinessDetails->business_name ?>" readonly
                                                            required>
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

                                                <h4>Edit Policy</h4>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Shift Settings <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2" id="editshiftsetting"
                                                            name="editshiftsetting[]"
                                                            data-placeholder="Choose Shift Policy" multiple required>
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
                                                    <div class="form-group ">
                                                        <label class="form-label">Leave Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2 custom-select"
                                                            id="editleavepolicy" name="editleavepolicy"
                                                            data-placeholder="Choose Leave Policy" required>
                                                            <option label="Choose Leave Policy">
                                                            </option>

                                                            @empty(!$LeavePolicy)
                                                                @foreach ($LeavePolicy as $item)
                                                                    <option value="<?= $item->id ?>">
                                                                        <?= $item->policy_name ?>&nbsp;
                                                                    </option>
                                                                @endforeach
                                                            @endempty
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Holiday Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2 custom-select"
                                                            id="editholidaypolicy" name="editholidaypolicy"
                                                            data-placeholder="Choose Holiday Policy" required>
                                                            <option label="Choose Holiday Policy">
                                                            </option>

                                                            @empty(!$HolidayPolicy)
                                                                @foreach ($HolidayPolicy as $item)
                                                                    <option value="<?= $item->temp_id ?>">
                                                                        <?= $item->temp_name ?>&nbsp;
                                                                    </option>
                                                                @endforeach
                                                            @endempty
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <label class="form-label">Weekly Policy <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control select2 custom-select"
                                                            id="editweeklypolicy" name="editweeklypolicy"
                                                            data-placeholder="Choose Weekly Policy" required>
                                                            <option label="Choose Weekly Policy">
                                                            </option>

                                                            @empty(!$weeklyPolicy)
                                                                @foreach ($weeklyPolicy as $item)
                                                                    <option value="<?= $item->id ?>">
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
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit" id="savechanges">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="editdeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form action="{{ url('admin/settings/attendance/delete_master_rule') }}" method="post">
                            @csrf
                            <input type="text" id="shiftid" name="eid" hidden>

                            <input type="text" id="bl" name="bid" hidden>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">×</span>
                                </button>
                                <!-- <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</a> -->
                            </div>
                            <div class="modal-body">

                                <p>Setup : <b><span id="load_name"></span></b> </p>

                                Are you sure you want to delete this item ?
                            </div>
                            <div class="modal-footer">
                                <!-- <a type="close" class="btn  btn-secondary" data-bs-dismiss="modal">Cancel</a> -->
                                <button class="btn btn-secondary" type="reset" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/setup/attendance-settings') }}" class="btn btn-primary">Previous</a>
            </div>

            <div class="d-flex">
                <button id="saveButton" class="btn btn-primary">Save & Continue</button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            document.getElementById('saveButton').addEventListener('click', function(event) {
                // Your condition to check
                $.ajax({
                    url: "{{ url('/setup/activepermissioncheck') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if (res.masterendgame == null) {
                            // Condition is true, show a SweetAlert alert
                            Swal.fire({
                                icon: 'error',
                                text: 'Your fields cannot be empty or on the setup!',
                            }).then(function() {
                                // Callback after the alert is closed
                                return false; // Prevent the default action (form submission)
                            });
                        } else {
                            // Condition is false, allow the form submission to proceed and potentially redirect
                            window.location.href = '{{ url('/setup/subscription') }}';
                        }
                    }
                });
            });
        </script>





        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $('#createMethodForm').on('submit', function(event) {
                $('#additionalModals').modal('hide');
                $('#CreateMethod').prop('disabled', true);
                // event.preventDefault();

            });

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
            var loadcheck = '';

            function loadedCall(context) {
                loadcheck = context.value;
                console.log(context.value);
            }

            function callBack(business_id, eid, holdiayPolicyID, weeklyPolicyID) {
                console.log("hii");
                $('.custom-switch-checkbox').on('change', function() {
                    // console.log($('.custom-switch-checkbox').val());
                    if ($(this).is(':checked')) {
                        // Checkbox is checked, show a SweetAlert2 success alert
                        Swal.fire({
                            timer: 2000,
                            text: 'Setup is Active Now',
                            timerProgressBar: true,
                            title: '',
                            icon: 'success'

                        }).then(function() {
                            values(1, business_id, eid, holdiayPolicyID, weeklyPolicyID);


                        });
                    } else {

                        // Checkbox is unchecked, show a SweetAlert2 info alert
                        $(document).ready(function() {
                            $('#myModal').modal('show');

                            $('#cancelButton').on('click', function(e) {
                                e.preventDefault(); // Prevent the default action of the button (if any)
                                console.log("Cancel button clicked");
                                values(1, business_id, eid, holdiayPolicyID, weeklyPolicyID);
                            });
                            $('#modalForm').on('submit', function(e) {
                                e.preventDefault(); // Prevent the default form submission
                                console.log(loadcheck.type);
                                console.log(holdiayPolicyID);
                                Swal.fire({
                                    timer: 2000,
                                    timerProgressBar: true,
                                    text: 'Setup has been Deactivated Successfully !',
                                    icon: 'success',
                                    showClass: {
                                        popup: 'swal2-noanimation',
                                        backdrop: 'swal2-noanimation'
                                    }
                                }).then(function() {

                                    values(0, business_id, eid, holdiayPolicyID,
                                        weeklyPolicyID);
                                    $('#myModal').modal('hide');
                                });

                                // Other actions you want to perform on modal form submission
                                return true; // Return true to submit the form
                            });
                        });


                    }

                });
            }


            function values(load, business_id, eid, holdiayPolicyID, weeklyPolicyID) {
                console.log(load, business_id, eid, holdiayPolicyID, weeklyPolicyID);
                $.ajax({
                    url: "{{ url('admin/settings/attendance/mode_master_rule') }}",
                    type: "get",
                    data: {
                        _token: '{{ csrf_token() }}',
                        b_id: business_id,
                        e_id: eid,
                        holiday_policy_id: holdiayPolicyID,
                        weekly_policy_id: weeklyPolicyID,
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
@endif
