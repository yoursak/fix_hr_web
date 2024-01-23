@extends('admin.pagelayout.master')
@section('title')
    Setup Activation | Create Shift
@endsection
@section('css')
@endsection

@section('content')
    <style>
        .custom-switch-indicator {
            background: red;
            /* Change this to the desired red color */
        }
    </style>
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
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/attendance') }}">Settings</a></li> --}}
            {{-- <li><a href="{{ url('admin/settings/attendance') }}">Attendace Setting</a></li> --}}
            {{-- <li><a href="{{ url('/admin/requests/misspunch') }}">Request</a></li> --}}

            <li class="active"><span><b>Setup Activation</b></span></li>
        </ol>
    </div>
    <div class="row">


        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="page-header d-md-flex d-block">
                <div class="page-leftheader">
                    {{-- <div class="page-title">Create Started Templates</div> --}}
                    <p class="text-muted">Create and activate all your business and policy settings</p>
                </div>
                <div class="page-rightheader ms-auto">
                    {{-- <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="d-lg-flex d-block"> --}}
                    <div class="btn-list d-flex">
                        <a class="modal-effect btn btn-primary mx-3 ms-auto" data-effect="effect-scale"
                            data-bs-toggle="modal" href="#additionalModals" id="btnOpen">Create Active Method</a>
                    </div>

                    {{-- </div>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- create Method apply --}}
        <div class="container">
            <div class="modal fade" id="additionalModals">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle">Create Method
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
                                                    <label class="form-label">Business Name </label>
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
                                                        data-placeholder="Choose Shift Policy" multiple required>
                                                        <option label="Choose Shift Policy">
                                                        </option>
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
                                                    <label class="form-label">Leave Policy List</label>
                                                    <select class="form-control select2 custom-select" id="leavepolicy"
                                                        name="leavepolicy" data-placeholder="Choose Leave Policy" required>
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
                                                {{-- <div class="form-group">
                                                <label class="form-label"> Leave Policy List</label>
                                                <select class="form-control select2" name="leavepolicy[]" data-placeholder="Choose Leave Policy" multiple required>
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
                                            </div> --}}
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Holiday Policy List</label>
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
                                                {{-- <div class="form-group">
                                                <label class="form-label"> Holiday Policy List</label>
                                                <select class="form-control select2" name="holidaypolicy[]" data-placeholder="Choose Holiday Policy" multiple required>
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
                                            </div> --}}
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label"> Choose Weekly Policy</label>
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
                                                {{-- <div class="form-group">
                                                <label class="form-label"> Weekly Policy List</label>
                                                <select class="form-control select2" name="weeklypolicy[]" data-placeholder="Choose Weekly Policy" multiple required>
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
                                            </div> --}}
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

        {{-- table view --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Final Rule Method Settings</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-10">S.No.</th>
                                    <th class="border-bottom-0">Method Name</th>
                                    <th class="border-bottom-0">Setup On/Off</th>
                                    <th class="border-bottom-0">Associated Employee</th>
                                    <th class="border-bottom-0">Policy Preference</th>
                                    <th class="border-bottom-0">Level Type</th>
                                    <th class="border-bottom-0">Shift Policy List</th>
                                    <th class="border-bottom-0">Leave Policy list</th>
                                    <th class="border-bottom-0">Holiday Policy list</th>
                                    <th class="border-bottom-0">Weekly Policy List</th>
                                    <th class="border-bottom-0">Attendace Policy List</th>
                                    <th class="border-bottom-0">Track Policy List</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $j = 1;
                                    // dd($FinalEndGameRule);
                                @endphp
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
                                                <label class="custom-switch">
                                                    <input type="checkbox" id="custom-switch-checkbox"
                                                        onclick="callBack('{{ $item->business_id }}', '{{ $item->id }}')"
                                                        name="custom-switch-checkbox"
                                                        class="custom-switch-input custom-switch-checkbox"
                                                        <?= $item->method_switch !== 0 ? 'checked' : '' ?>>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Enable/Disable</span>
                                                </label>
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
                                            
                                            // if ($item->leave_policy_ids_list ?? false) {
                                            //     // Decode the JSON string into an array of IDs
                                            //     $holidayPolicyIds = json_decode($item->leave_policy_ids_list);
                                            
                                            //     if ($holidayPolicyIds !== null) {
                                            //         // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                            //         // Loop through the IDs and display the corresponding names
                                            //         foreach ($holidayPolicyIds as $id) {
                                            //             // Call the GetValues function to retrieve the object
                                            //             $load = $power->GetValues($id)[0];
                                            
                                            //             if ($load !== null) {
                                            //                 // Check if the object is not null
                                            //                 echo $load->policy_name . ', '; // Add a comma and space between names if needed
                                            //             } else {
                                            //                 // Handle cases where an object is not found
                                            //                 echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //             }
                                            //         }
                                            //     } else {
                                            //         // Handle cases where the JSON is invalid or empty
                                            //         echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //     }
                                            // }
                                            
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
                                            // if ($item->holiday_policy_ids_list ?? false) {
                                            //     // Decode the JSON string into an array of IDs
                                            //     $holidayPolicyIds = json_decode($item->holiday_policy_ids_list);
                                            
                                            //     if ($holidayPolicyIds !== null) {
                                            //         // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                            //         // Loop through the IDs and display the corresponding names
                                            //         foreach ($holidayPolicyIds as $id) {
                                            //             // Call the GetValues function to retrieve the object
                                            //             $load = $power->GetValues($id)[1];
                                            
                                            //             if ($load !== null) {
                                            //                 // Check if the object is not null
                                            //                 echo $load->temp_name . ', '; // Add a comma and space between names if needed
                                            //             } else {
                                            //                 // Handle cases where an object is not found
                                            //                 echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //             }
                                            //         }
                                            //     } else {
                                            //         // Handle cases where the JSON is invalid or empty
                                            //         echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //     }
                                            // }
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
                                            // if ($item->weekly_policy_ids_list ?? false) {
                                            //     // Decode the JSON string into an array of IDs
                                            //     $holidayPolicyIds = json_decode($item->weekly_policy_ids_list);
                                            
                                            //     if ($holidayPolicyIds !== null) {
                                            //         // Check if the decoded JSON is not null (i.e., it's valid JSON)
                                            //         // Loop through the IDs and display the corresponding names
                                            //         foreach ($holidayPolicyIds as $id) {
                                            //             // Call the GetValues function to retrieve the object
                                            //             $load = $power->GetValues($id)[2];
                                            
                                            //             if ($load !== null) {
                                            //                 // Check if the object is not null
                                            //                 echo $load->name . ', '; // Add a comma and space between names if needed
                                            //             } else {
                                            //                 // Handle cases where an object is not found
                                            //                 echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //             }
                                            //         }
                                            //     } else {
                                            //         // Handle cases where the JSON is invalid or empty
                                            //         echo 'Unknown'; // You can use a default value or an appropriate message here
                                            //     }
                                            // }
                                            ?>
                                        </td>

                                        <td class="font-weight-semibold">
                                            @empty(!$attendanceModePolicy)
                                                @foreach ($attendanceModePolicy as $item)
                                                    <?php
                                    if ($item->office_auto != null && $item->office_auto != 0) {
                                    ?>
                                                    <small>Office&nbsp;|&nbsp;Auto</small>
                                                    <?php
                                    }
                                    if (($item->office_qr != null && $item->office_qr != 0) || ($item->office_face_id != null && $item->office_face_id != 0) || ($item->office_selfie     != null && $item->office_selfie     != 0)) {
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
                                            @empty(!($attendanceTrackInOut->id ?? 0))
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

                                            <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="openEditMasterPolicy(this)" data-id='<?= $load_id ?>'
                                                data-b_id='<?= $item->business_id ?>'
                                                data-switch='<?= $item->method_switch ?? false && $item->method_switch != 0 ? $item->method_switch : 0 ?>'
                                                data-bs-toggle="modal" data-bs-target="#editMasterCreated">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                onclick="DeleteMasterModel(this)" data-ids='<?= $load_id ?>'
                                                data-b_id='<?= $item->business_id ?>'
                                                data-loaded='<?= $method_name ?? false ? $method_name : '' ?>'
                                                data-bs-toggle="modal" data-bs-target="#editdeleteModal">
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

                                <p> The associated policy will not function if you deactivate the setup. </p>

                            </div>
                            <div class="modal-footer">
                                <!-- <a type="close" class="btn  btn-secondary" data-bs-dismiss="modal">Cancel</a> -->
                                <button class="btn btn-light" id="cancelButton" onclick="loadedCall(this)"
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
                                                    <label class="form-label">Business Name </label>
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
                                                <div class="form-group ">
                                                    <label class="form-label">Leave Policy List</label>
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
                                                <!-- <div class="form-group">
                                                                    <label class="form-label"> Leave Policy List</label>
                                                                    <select class="form-control select2" id="editleavepolicy" name="editleavepolicy[]" data-placeholder="Choose Leave Policy" multiple required>
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
                                                                </div> -->
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-label">Holiday Policy List</label>
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
                                                {{-- <div class="form-group">
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
                                                </div> --}}
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-label">Weekly Policy List</label>
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
                                                {{-- <div class="form-group">
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
                                                </div> --}}
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


        <div class="modal fade" id="editdeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
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
                            <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Cancel</button>
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
        var loadcheck = '';

        function loadedCall(context) {
            loadcheck = context.value;
            console.log(context.value);
        }

        function callBack(business_id, eid) {

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
                        values(1, business_id, eid);


                    });
                } else {

                    // Checkbox is unchecked, show a SweetAlert2 info alert
                    $(document).ready(function() {
                        $('#myModal').modal('show');

                        $('#cancelButton').on('click', function(e) {
                            e.preventDefault(); // Prevent the default action of the button (if any)
                            console.log("Cancel button clicked");
                            values(1, business_id, eid);
                        });
                        $('#modalForm').on('submit', function(e) {
                            e.preventDefault(); // Prevent the default form submission
                            console.log(loadcheck.type);

                            Swal.fire({
                                timer: 2000,
                                timerProgressBar: true,
                                text: 'Setup has been Deactivated Successfully !',
                                icon: 'info',
                                showClass: {
                                    popup: 'swal2-noanimation',
                                    backdrop: 'swal2-noanimation'
                                }
                            }).then(function() {

                                values(0, business_id, eid);
                            });

                            // Other actions you want to perform on modal form submission
                            return true; // Return true to submit the form
                        });
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
                    window.location.reload(true);
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
