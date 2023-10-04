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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Method Name <span
                                                        class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="methodname" id=""
                                                    placeholder="Method Name" required>
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
                                                <input type="text" class="form-control" name="businessname" id=""
                                                    placeholder="Business Name Default"
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


                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="savechanges">Create Method Apply</button>
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
                <h3 class="card-title">Final Rule Method Setting</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                        <thead>
                            <tr>

                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Method Name</th>
                                <th class="border-bottom-0">Method On/Off</th>
                                <th class="border-bottom-0">Policy Preference</th>
                                <th class="border-bottom-0">Level Type</th>
                                <th class="border-bottom-0">Leave Policy list</th>
                                <th class="border-bottom-0">Holiday Policy list</th>
                                <th class="border-bottom-0">Weekly Policy List</th>
                                <th class="border-bottom-0">Shift Policy List</th>
                                <th class="border-bottom-0">Attendace Policy List</th>
                                <th class="border-bottom-0">Track Policy List</th>
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
                                <td class="font-weight-semibold">
                                    <?php  
                                      $method_name=  $item->method_name;
                                       echo $method_name; ?>
                                </td>
                                <td>
                                    <div class="col-xl-3 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" id="custom-switch-checkbox"
                                                name="custom-switch-checkbox" class="custom-switch-input"
                                                @if($item->method_switch!=0 && $item->method_switch??false)
                                            @checked(true)
                                            @endif>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Enable/Disable</span>
                                        </label>
                                    </div>
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
                                        $holidayPolicyIds = json_decode($item->leave_policy_ids_list);
                                        
                                        if ($holidayPolicyIds !== null) {
                                            // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                            // Loop through the IDs and display the corresponding names
                                            foreach ($holidayPolicyIds as $id) {
                                                // Call the GetValues function to retrieve the object
                                                $load = $power->GetValues($id)[0];
                                        
                                                if ($load !== null) {
                                                    // Check if the object is not null
                                                    echo $load->policy_name . ', '; // Add a comma and space between names if needed
                                                } else {
                                                    // Handle cases where an object is not found
                                                    echo 'Unknown'; // You can use a default value or an appropriate message here
                                                }
                                            }
                                        } else {
                                            // Handle cases where the JSON is invalid or empty
                                            echo 'Unknown'; // You can use a default value or an appropriate message here
                                        }
                                        ?>
                                </td>
                                <td class="font-weight-semibold">
                                    <?php
                                            if ($item->holiday_policy_ids_list ?? false) {
                                                // Decode the JSON string into an array of IDs
                                                $holidayPolicyIds = json_decode($item->holiday_policy_ids_list);
                                            
                                                if ($holidayPolicyIds !== null) {
                                                    // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                                    // Loop through the IDs and display the corresponding names
                                                    foreach ($holidayPolicyIds as $id) {
                                                        // Call the GetValues function to retrieve the object
                                                        $load = $power->GetValues($id)[1];
                                            
                                                        if ($load !== null) {
                                                            // Check if the object is not null
                                                            echo $load->temp_name . ', '; // Add a comma and space between names if needed
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
                                        if ($item->weekly_policy_ids_list ?? false) {
                                            // Decode the JSON string into an array of IDs
                                            $holidayPolicyIds = json_decode($item->weekly_policy_ids_list);
                                        
                                            if ($holidayPolicyIds !== null) {
                                                // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                                // Loop through the IDs and display the corresponding names
                                                foreach ($holidayPolicyIds as $id) {
                                                    // Call the GetValues function to retrieve the object
                                                    $load = $power->GetValues($id)[2];
                                        
                                                    if ($load !== null) {
                                                        // Check if the object is not null
                                                        echo $load->name . ', '; // Add a comma and space between names if needed
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
                                        // Decode the JSON string into an array of IDs
                                        if ($item->shift_settings_ids_list ?? false) {
                                            $holidayPolicyIds = json_decode($item->shift_settings_ids_list);
                                        
                                            if ($holidayPolicyIds !== null) {
                                                // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                                // Loop through the IDs and display the corresponding names
                                                foreach ($holidayPolicyIds as $id) {
                                                    // Call the GetValues function to retrieve the object
                                                    $load = $power->GetValues($id)[3];
                                        
                                                    if ($load !== null) {
                                                        // Check if the object is not null
                                                        echo $load->shift_type_name . ', '; // Add a comma and space between names if needed
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
                                    @empty(!$attendanceModePolicy)
                                    @foreach ($attendanceModePolicy as $item)
                                    <?php
                                                    if ($item->in_premises_auto != null && $item->in_premises_auto != 0) {
                                                    ?>
                                    <small>Office&nbsp;|&nbsp;Auto</small>
                                    <?php
                                                    }
                                                    if (($item->in_premises_qr != null && $item->in_premises_qr != 0) || ($item->in_premises_face_id != null && $item->in_premises_face_id != 0) || ($item->in_premises_selfie != null && $item->in_premises_selfie != 0)) {
                                                    ?>
                                    <small>Office&nbsp;|&nbsp;Manual</small>
                                    <?php  }
                                                    if ($item->outdoor_auto != null && $item->outdoor_auto != 0) { ?>
                                    <small> Out Door&nbsp;|&nbsp;Auto</small>
                                    <?php }
                                                    if ($item->outdoor_selfie != null && $item->outdoor_selfie != 0) {
                                                    ?>
                                    <small>Out Door&nbsp;|&nbsp;Manual</small>

                                    <?php }
                                                    if ($item->wfh_auto != null && $item->wfh_auto != 0) {
                                                    ?>
                                    <small> Remote&nbsp;|&nbsp;Auto</small>
                                    <?php
                                                    }
                                                    if ($item->wfh_selfie != null && $item->wfh_selfie != 0) {
                                                    ?>
                                    <small> Remote&nbsp;|&nbsp;Manual</small>

                                    <?php } ?>
                                    @endforeach
                                    @endempty
                                </td>
                                <td class="font-weight-semibold">
                                    @empty(!$attendanceTrackInOut->id)
                                    <option value="1">
                                        <?php if ($attendanceTrackInOut->track_in_out != null && $attendanceTrackInOut->track_in_out != 0) { ?>
                                        <?= 'Track In & Out Time' ?>&nbsp;
                                        <?php } ?>
                                    </option>
                                    <option value="2">
                                        <?php if ($attendanceTrackInOut->no_attendace_without_punch != null && $attendanceTrackInOut->no_attendace_without_punch != 0) { ?>
                                        <?= 'No Attendance without punch' ?>&nbsp;
                                        <?php } ?>
                                    </option>
                                    @endempty
                                </td>

                                <td>
                                    <?php  $ID=$item->id; ?>

                                    <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="openEditMasterPolicy(this)" data-id='<?= $ID ?>'
                                        data-b_id='<?=$item->business_id?>'
                                        data-switch='<?=($item->method_switch??false && $item->method_switch!=0)?$item->method_switch:0?>'
                                        data-bs-toggle="modal" data-bs-target="#editMasterCreated">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>
                                    <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="DeleteMasterModel(this)" data-ids='<?= $ID ?>'
                                        data-b_id='<?=$item->business_id?>'
                                        data-loaded='<?=($method_name??false)?$method_name:''?>' data-bs-toggle="modal"
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
                                                <input type="text" class="form-control" name="businessname" id=""
                                                    placeholder="Business Name Default"
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
                                                    name="editholidaypolicy[]" data-placeholder="Choose Holiday Policy"
                                                    multiple required>
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

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Shift Settings List</label>
                                                <select class="form-control select2" id="editshiftsetting"
                                                    name="editshiftsetting[]" data-placeholder="Choose Weekly Policy"
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


                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="savechanges">Update Method Apply</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


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
                        <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
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
                        <a type="close" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
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
            var b_id=$(context).data('b_id');
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
    $(document).ready(function () {
        $('#custom-switch-checkbox').on('change', function () {
            if ($(this).is(':checked')) {
            // Checkbox is checked, show a SweetAlert2 success alert
            Swal.fire({
                timer: 2000,
                timerProgressBar: true,
                title: 'Method is Active Mode!',
                icon: 'success'
            }).then(function () {
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
            }).then(function () {
                callBack(0);
                window.location.reload(true);

                // Reload the page
            });
        }
        
    });
   

    });
    
    function openEditMasterPolicy(context)
    {
            var id = $(context).data('id');
            var bID=$(context).data('b_id');
            var switchload=$(context).data('switch');
            console.log(bID);
            
            $.ajax({
                    url: "{{url('admin/settings/attendance/get_master_rule')}}",
                    type: "get",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        b_id:bID,
                        switch:switchload
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
             
                        if(result[0]!=null)
                        {
                        $('#edit_mname').val(result[0].method_name);
                        $('#b_id').val(result[0].business_id);
                        // Parse JSON-encoded strings into JavaScript arrays for multiple selects
                        var selectedLeavePolicies=JSON.parse(result[0].leave_policy_ids_list);
                        var selectedHolidayPolicies = JSON.parse(result[0].holiday_policy_ids_list);
                        var selectedWeeklyPolicies = JSON.parse(result[0].weekly_policy_ids_list);
                        var selectedShiftSettings = JSON.parse(result[0].shift_settings_ids_list);

                        $('#editleavepolicy').val(selectedLeavePolicies);
                        $('#editholidaypolicy').val(selectedHolidayPolicies);
                        $('#editweeklypolicy').val(selectedWeeklyPolicies);
                        $('#editshiftsetting').val(selectedShiftSettings);
                        $('#editleavepolicy,#editholidaypolicy, #editweeklypolicy, #editshiftsetting').trigger('change');
                        }
                    },error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                    }
                });
    }
    function callBack(load){
        
        $.ajax({
                    url: "{{url('admin/settings/attendance/mode_master_rule')}}",
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