{{-- @extends('admin.setting.setting')
--}}
@extends('admin.pagelayout.master')
@section('title')
Attendance | Create Shift
@endsection
@section('css')


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
@if (in_array('Approval Setup.All', $permissions) || in_array('Approval Setup.View', $permissions))

<?php
    
    $power = new App\Helpers\MasterRulesManagement\RulesManagement();
    
    ?>

<div class="row">
    <div class=" p-0 m-1">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/attendance') }}">Role-permission</a></li>
            <li class="active"><span><b>Approval Settings</b></span></li>
        </ol>
    </div>
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">Approval Settings</h3>
        </div>
        <div class="card-body p-6">
            <div class="panel panel-primary">
                <div class="tab-menu-heading border">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab1" class="active" data-bs-toggle="tab">Attendance Approval
                                </a></li>
                            <li><a href="#tab2" data-bs-toggle="tab">Leave Approval</a></li>
                            <li><a href="#tab3" data-bs-toggle="tab">Mispunch Approval</a></li>
                            <li><a href="#tab4" data-bs-toggle="tab">Gatepass Approval</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body border-0">
                    <div class="tab-content">
                        <div class="tab-pane active " id="tab1">
                        
                            <x-approval-management.attendance-approval></x-approval-management.attendance-approval>
                        </div>

                        <div class="tab-pane " id="tab2">
                            <x-approval-management.leave-approval></x-approval-management.leave-approval>

                        </div>

                        <div class="tab-pane " id="tab3">
                            <x-approval-management.misspunch-approval></x-approval-management.mispunch-approval>

                        </div>
                        <div class="tab-pane  " id="tab4">
                            {{-- <x-approval-management.misspunch-approval></x-approval-management.mispunch-approval> --}}
                                <x-approval-management.gatepass-approval></x-approval-management.gatepass-approval>

                        </div>
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
                <form action="{{ url('') }}" method="post">
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
                                            <input type="text" id="" name="b_id" value="<?= session('business_id') ?>"
                                                hidden>
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

{{-- table view --}}
{{-- <div class="col-lg-12">
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
                        @endphp
                        @foreach ($FinalEndGameRule as $item)
                        <tr>
                            <td class="font-weight-semibold">{{ $j++ }}.</td>
                            <td class="font-weight-semibold">
                                <?php
                                            $method_name = $item->method_name;
                                            echo $method_name; ?>
                            </td>
                            <td>
                                <div class="col-xl-3 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" id="custom-switch-checkbox" name="custom-switch-checkbox"
                                            class="custom-switch-input" @if ($item->method_switch != 0 &&
                                        $item->method_switch ?? false) @checked(true) @endif>
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
                                            if ($item->shift_settings_ids_list ?? false) {
                                                $shiftlist = json_decode($item->shift_settings_ids_list);
                                            
                                                if ($shiftlist !== null) {
                                                    foreach ($shiftlist as $id) {
                                                        $load = $power->GetValues($id)[3];
                                            
                                                        if ($load !== null) {
                                                            echo $load->name . ' | ' . $load->shift_type_name . ' ,<br>';
                                                        } else {
                                                            echo 'Unknown';
                                                        }
                                                    }
                                                } else {
                                                    echo 'Unknown';
                                                }
                                            }
                                            ?>
                            </td>
                            <td class="font-weight-semibold">
                                <?php
                                            if ($item->leave_policy_ids_list ?? false) {
                                                $holidayPolicyIds = json_decode($item->leave_policy_ids_list);
                                            
                                                if ($holidayPolicyIds !== null) {
                                                    foreach ($holidayPolicyIds as $id) {
                                                        $load = $power->GetValues($id)[0];
                                            
                                                        if ($load !== null) {
                                                            echo $load->policy_name . ', ';
                                                        } else {
                                                            echo 'Unknown';
                                                        }
                                                    }
                                                } else {
                                                    echo 'Unknown';
                                                }
                                            }
                                            ?>
                            </td>
                            <td class="font-weight-semibold">
                                <?php
                                            if ($item->holiday_policy_ids_list ?? false) {
                                                $holidayPolicyIds = json_decode($item->holiday_policy_ids_list);
                                            
                                                if ($holidayPolicyIds !== null) {
                                                    foreach ($holidayPolicyIds as $id) {
                                                        $load = $power->GetValues($id)[1];
                                            
                                                        if ($load !== null) {
                                                            echo $load->temp_name . ', ';
                                                        } else {
                                                            echo 'Unknown';
                                                        }
                                                    }
                                                } else {
                                                    echo 'Unknown';
                                                }
                                            }
                                            ?>
                            </td>



                            <td class="font-weight-semibold">
                                <?php
                                            if ($item->weekly_policy_ids_list ?? false) {
                                                $holidayPolicyIds = json_decode($item->weekly_policy_ids_list);
                                            
                                                if ($holidayPolicyIds !== null) {
                                                    foreach ($holidayPolicyIds as $id) {
                                                        $load = $power->GetValues($id)[2];
                                            
                                                        if ($load !== null) {
                                                            echo $load->name . ', ';
                                                        } else {
                                                            echo 'Unknown';
                                                        }
                                                    }
                                                } else {
                                                    echo 'Unknown';
                                                }
                                            }
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
                                <?php $ID = $item->id; ?>

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
</div> --}}

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
                                            <input type="text" class="form-control" name="edit_mname" id="edit_mname"
                                                placeholder="Method Name" required>
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
                                                name="editleavepolicy[]" data-placeholder="Choose Leave Policy" multiple
                                                required>
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
@endif
@endsection