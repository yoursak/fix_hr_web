@extends('admin.pagelayout.master')
@section('title')
    Attendance | Create Shift
@endsection

@if (in_array('Attendance Setting.All', $permissions) ||
        in_array('Attendance Setting.View', $permissions) ||
        in_array('Shift Settings.All', $permissions) ||
        in_array('Shift Settings.View', $permissions))
    @section('content')
        <?php
        $power = new App\Helpers\MasterRulesManagement\RulesManagement();
        ?>
        <div class="p-0 mt-3">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('admin/settings/attendance') }}">Attendace Settings</a></li>
                <li class="active"><span><b>Shift Settings</b></span></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="page-header d-md-flex d-block">
                    <div class="page-leftheader">
                        <div class="page-title">Create Shift Policy</div>
                        <p class="text-muted">Create Template to Give Shift to Staff on Month if They Want</p>
                    </div>
                    <div class="page-rightheader">
                        <div class="d-flex align-items-end flex-wrap my-auto breadcrumb-end">
                            <div class="d-flex ms-auto">
                                @if (in_array('Shift Settings.All', $permissions) || in_array('Shift Settings.Create', $permissions))
                                    <div class="btn-list d-flex">
                                        <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                                            data-bs-toggle="modal" id="btnOpen">Create shift</a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shift List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0 w-10">S.No.</th>
                                        <th class="border-bottom-0">Shift Name</th>
                                        <th class="border-bottom-0">Shift Type</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @empty(!$attendaceShift)
                                        @php

                                            $j = 1;
                                        @endphp
                                        @foreach ($attendaceShift as $item)
                                            <tr>
                                                <td class="font-weight-semibold">{{ $j++ }}.</td>
                                                <td class="font-weight-semibold">
                                                    <?= $item->shift_type_name ?>
                                                </td>

                                                <td class="font-weight-semibold">
                                                    <?php
                                                $loadss = DB::table('policy_attendance_shift_type_items')
                                                    ->where('attendance_shift_id', $item->id)
                                                    ->first();
                                                $ShiftHour = (int) ($loadss->shift_hr ?? 0);
                                                $ShiftMin = (int) ($loadss->shift_min ?? 0);
                                                //   print_r($ShiftMin);

                                                //   dd($ShiftMin);
                                                if ($power->AttedanceShiftCheckItems($item->id) == 1) {
                                                    echo 'Fixed Shift: ' . $power->Convert24To12($loadss->shift_start) . '-' . $power->Convert24To12($loadss->shift_end);
                                                }
                                                if ($power->AttedanceShiftCheckItems($item->id) == 2) {
                                                    echo 'Rotational Shift: ';
                                                    foreach (DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $item->id)->where('business_id', Session::get('business_id'))->get() as $value) { ?>
                                                    <?= '' . $power->Convert24To12($value->shift_start) . '-' .
                                                    $power->Convert24To12($value->shift_end) ?> @if (!$loop->last)
                                                        ||
                                                    @endif
                                                    <?php }
                                                }
                                                if ($power->AttedanceShiftCheckItems($item->id) == 3) {
                                                    echo 'Open Shift Total Work: ' . str_pad($ShiftHour, 2, '0', STR_PAD_LEFT) . ' Hour ' . str_pad($ShiftMin, 2, '0', STR_PAD_LEFT)  . ' Min';
                                                }
                                                ?>
                                                </td>

                                                <td>
                                                    @if (in_array('Shift Settings.All', $permissions) || in_array('Shift Settings.Update', $permissions))
                                                        @if ($item->shift_type == 1)
                                                            {{-- @dd($item->shift_weekly_repeat); --}}
                                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                                href="javascript:void(0);"
                                                                onclick="openEditFixedShiftModel(this)"
                                                                data-id='<?= $item->id ?>'
                                                                data-shift_name='<?= $item->shift_type_name ?>'
                                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                                data-shift_start='<?= $loadss->shift_start ?>'
                                                                data-shift_end='<?= $loadss->shift_end ?>'
                                                                data-break_min='<?= $loadss->break_min ?>'
                                                                data-is_paid='<?= (int) $loadss->is_paid ?? 0 ?>'
                                                                data-work_hr='<?= $loadss->work_hr ?>'
                                                                data-work_min='<?= $loadss->work_min ?>' data-bs-toggle="modal"
                                                                data-bs-target="#fixiedshift">
                                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                                    data-original-title="View/Edit"></i>
                                                            </a>
                                                        @endif

                                                        @if ($item->shift_type == 2)
                                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                                href="javascript:void(0);"
                                                                onclick="openEditRotationalModel(this)"
                                                                data-id='<?= $item->id ?>'
                                                                data-shift_name='<?= $item->shift_type_name ?>'
                                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                                data-shift_start='<?= $loadss->shift_start ?? 0 ?>'
                                                                data-shift_end='<?= $loadss->shift_end ?? 0 ?>'
                                                                data-break_min='<?= $loadss->break_min ?? 0 ?>'
                                                                data-is_paid='<?= $loadss->is_paid ?? 0 ?>'
                                                                data-work_hr='<?= $loadss->work_hr ?? 0 ?>'
                                                                data-work_min='<?= $loadss->work_min ?? 0 ?>'
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#openEditRotationalModel">
                                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                                    data-original-title="View/Edit"></i>
                                                            </a>
                                                        @endif

                                                        @if ($item->shift_type == 3)
                                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                                href="javascript:void(0);"
                                                                onclick="openEditOpenShiftModel(this)"
                                                                data-id='<?= $item->id ?>'
                                                                data-shift_name='<?= $item->shift_type_name ?? 0 ?>'
                                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                                data-shift_hour='<?= $ShiftHour ?>'
                                                                data-shift_min='<?= $ShiftMin ?>'
                                                                data-break_min='<?= $loadss->break_min ?? 0 ?>'
                                                                data-is_paid='<?= $loadss->is_paid ?? 0 ?>'
                                                                data-work_hr='<?= $loadss->work_hr ?? 0 ?>'
                                                                data-work_min='<?= $loadss->work_min ?? 0 ?>'
                                                                data-bs-toggle="modal" data-bs-target="#openshiftModel">
                                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                                    data-original-title="View/Edit"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (in_array('Shift Settings.All', $permissions) || in_array('Shift Settings.Delete', $permissions))
                                                        <a class="btn action-btns  btn-danger btn-icon btn-sm"
                                                            href="javascript:void(0);"
                                                            data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                            onclick="DeleteModel(this)" data-bs-toggle="modal"
                                                            data-id='<?= $item->id ?>'
                                                            data-shift_type_name='<?= $item->shift_type_name ?>'
                                                            data-bs-target="#deleteModal">
                                                            <i class="feather feather-trash" data-bs-toggle="tooltip"
                                                                data-original-title="View/Edit"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endempty
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="modal fade" id="fixiedshift" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header p-5">
                                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Fixed
                                    Shift Policy
                                </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('admin/settings/attendance/update_attendace_shift') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Update Shift</h3>
                                        </div>

                                        <div class="card-body">
                                            <input type="text" id="fixedId" name="fixedshiftId" hidden>
                                            <input type="text" id="fu_WorkHour" name="fu_WorkHour" hidden>
                                            <input type="text" id="fu_WorkMin" name="fu_WorkMin" hidden>

                                            <div class="form-group">
                                                <label class="form-label">Shift Type</label>
                                                {{-- onchange="load(this.value)" --}}
                                                <select onchange="load(this.value)" name="fixiedshifttype"
                                                    class="form-control custom-select select2"
                                                    data-placeholder="Select Country" id="shift_ftype"
                                                    aria-readonly="true" required>
                                                    <option value="1" selected required>Fixed Shift</option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">Shift Name</label>
                                                        <input id="shift_fname" class="form-control mb-4"
                                                            placeholder="Enter Shift Name" type="text"
                                                            name="editfixedshiftname" required>

                                                    </div>
                                                    <div class="col-xl-3 mb-4">
                                                        <label class="form-label">Start Time</label>
                                                        <input class="form-control" id="updated_start_time"
                                                            value="" onchange="timeCalculate()"
                                                            placeholder="Set time" type="time"
                                                            name="UpdatedFixShiftStart" required>
                                                    </div>
                                                    <div class="col-xl-3 mb-4">
                                                        <label class="form-label">End Time</label>
                                                        <input class="form-control" id="updated_end_time" value=""
                                                            onchange="timeCalculate()" placeholder="Set time"
                                                            type="time" name="UpdatedFixShiftEnd" required>
                                                    </div>
                                                    <div class="col-xl-3 mb-4">
                                                        <label class="form-label">Break(Min)</label>
                                                        <input class="form-control" id="updated_break_time"
                                                            value="" onchange="timeCalculate()"
                                                            placeholder="Set time" type="number"
                                                            name="UpdatedFixShiftBreak" required>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Break is</label>
                                                        <div class="row">
                                                            <div class="col-6">

                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" id="updated_paid"
                                                                        class="custom-control-input"
                                                                        onchange="timeCalculate()" name="UpdatedFixpaid"
                                                                        value="1" {{-- {{ $check }} --}}>
                                                                    <span class="custom-control-label">Paid</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" id="updated_unpaid"
                                                                        class="custom-control-input"
                                                                        onchange="timeCalculate()" name="UpdatedFixpaid"
                                                                        value="0" {{-- {{ $uncheck }}
                                                                --}}>
                                                                    <span class="custom-control-label">Unpaid</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <span id="UpdateFixedWorkHour"
                                                            class="mb-5 fs-12 text-muted"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table-responsive -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" name="EditShiftFixedShiftSubmit" value="FixedSubmit"
                                        type="submit" id="savechanges">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="modal fade" id="openEditRotationalModel" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header p-5">
                                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit
                                    Rotational Shift Policy</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('admin/settings/attendance/update_attendace_shift') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <input type="text" id="setId" name="setId" value=""
                                                    hidden>
                                                <label class="form-label">Shift Type</label>
                                                <select onchange="" name="shiftType"
                                                    class="form-control custom-select select2"
                                                    data-placeholder="Select Country" id="shifttype"
                                                    aria-readonly="true">
                                                    <option value="2">Rotational Shift</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="UpdateRotationalShift">
                                                <div class="row">
                                                    {{-- <div class="col-11 my-1 mb-3">
                                                <label class="form-label">Repeat Shift in Every <input
                                                        id="updateWeekRepeat" class="mx-2 text-center" type="number"
                                                        name="update_repeat_week" min="1" max="6"
                                                        value="0" style="width: 3rem">Weeks</label>
                                            </div> --}}
                                                    <div class="col-xl-11">
                                                        <label class="form-label"> Rotational Shift Name</label>
                                                        <input class="form-control mb-4" id="updatedRotationalName"
                                                            value="" placeholder="Enter Shift Name" type="text"
                                                            name="rotationName" required>
                                                    </div>
                                                    <div class="col-xl-1 text-end mt-5">
                                                        <button type="button"
                                                            class="btn btn-sm btn-primary  add_item_btn_edit"><i
                                                                class="fe fe-plus bold"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <span id="show_item_edit">

                                                </span>

                                            </div>
                                            <div>
                                                <span class="text-danger d-none" id="editRotationalAlertMess">You can't
                                                    delete last row!</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit" id="updateButton">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="modal fade" id="openshiftModel">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header p-5">
                                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Open
                                    Shift Policy
                                </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('admin/settings/attendance/update_attendace_shift') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Update Open Shift</h3>
                                        </div>

                                        <div class="card-body">
                                            <input type="text" id="editopenshiftId" name="openshiftId" hidden>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="form-label">Shift Type</label>
                                                    {{-- onchange="load(this.value)" --}}
                                                    <select name="editshifttype"
                                                        class="form-control custom-select select2"
                                                        data-placeholder="Select Shift Type" id="shift_ttype"
                                                        aria-readonly="true">
                                                        <option value="3" selected>Open Shift</option>
                                                    </select>

                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" id="editshift_tname"
                                                        placeholder="Enter Shift Name" type="text"
                                                        name="editopenShiftName" required>

                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Hour</label>
                                                    <input class="form-control m-0" id="editshift_hour" placeholder="Set"
                                                        onchange="openUpdateMyFunction()" type="number"
                                                        name="editopenHour" required>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Minutes</label>
                                                    <input class="form-control" id="editshift_min" placeholder="Set"
                                                        onchange="openUpdateMyFunction()" type="number"
                                                        name="editopenMin" required>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" id="editshift_breack" placeholder="Set"
                                                        onchange="openUpdateMyFunction()" type="number"
                                                        name="editopenBreak" required>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio"onchange="openUpdateMyFunction()"
                                                                    onchange="openPaid()" id="editopenPaid"
                                                                    class="custom-control-input" name="editopenPaid"
                                                                    value="1" checked>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" onchange="openUpdateMyFunction()"
                                                                    onchange="openUnpaid()" id="editopenUnpaid"
                                                                    class="custom-control-input" name="editopenPaid"
                                                                    value="0" checked>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function openPaid() {
                                                            document.getElementById('openUnpaid').checked = false;
                                                            document.getElementById('openPaid').checked = true;

                                                        }

                                                        function openUnpaid() {
                                                            document.getElementById('openUnpaid').checked = true;
                                                            document.getElementById('openPaid').checked = false;
                                                        }
                                                    </script>
                                                    <span id="UpdateOpenHour" class="mb-5 fs-12 text-muted"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            function openUpdateMyFunction() {
                                                console.log("hii");
                                                let open_shift_hr = parseInt(document.getElementById("editshift_hour").value) || 0;
                                                let open_shift_minute = parseInt(document.getElementById("editshift_min").value) || 0;
                                                let open_shift_break_minute = parseInt(document.getElementById("editshift_breack").value) || 0;
                                                let updated_differenceMinutes = open_shift_hr * 60 + open_shift_minute;
                                                // // Get the element where you want to display the total work hour
                                                let timeshow = document.getElementById("UpdateOpenHour");
                                                // // Ensure the differenceMinutes is positive
                                                if (updated_differenceMinutes < 0) {
                                                    updated_differenceMinutes += 1440; // 24 hours in minutes
                                                }
                                                // Subtract break time if openUnpaid is checked
                                                if ($('#editopenUnpaid').is(':checked')) {
                                                    // console.log('hiii');
                                                    updated_differenceMinutes -= open_shift_break_minute;
                                                } else if ($('#editopenPaid').is(':checked')) {
                                                    let updated_differenceMinutes = open_shift_hr * 60 + open_shift_minute;
                                                    if (updated_differenceMinutes < 0) {
                                                        updated_differenceMinutes += 1440; // 24 hours in minutes
                                                    }
                                                }
                                                // Ensure the final result is not negative
                                                updated_differenceMinutes = Math.max(updated_differenceMinutes, 0);
                                                // Calculate hours and minutes
                                                const updated_resultHours = Math.floor(updated_differenceMinutes / 60);
                                                const updated_resultMinutes = updated_differenceMinutes % 60;
                                                // Format the result with leading zeros
                                                const updated_formattedResult =
                                                    `${String(updated_resultHours).padStart(2, '0')} Hr ${String(updated_resultMinutes).padStart(2, '0')} Min`;
                                                // Clear previous content
                                                timeshow.innerHTML = '';
                                                // Set innerHTML to display the total work hour
                                                timeshow.innerHTML = `Total Work Hour: ${updated_formattedResult}`;
                                                console.log(`Result: ${updated_formattedResult}`);
                                            }
                                        </script>
                                        <!-- table-responsive -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" name="EditShiftOpenShiftSubmit" value="OpenSubmit"
                                        type="submit" id="savechanges">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
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

                                <h4>Are you sure you want to delete <span id="load_name"></span> ?</h4><b>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                            </div>
                        </form>
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
                    let weekly_repeat = $(context).data('weekly_repeat');
                    // Set values for the input fields
                    $('#setId').val(id);
                    $('#updatedRotationalName').val(shift_name);
                    $('#shifttype').val(shift_ftype);
                    $('#updateWeekRepeat').val(weekly_repeat);

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
                let rowCounter = 0;

                function appendEditFormItem(item, index) {
                    rowCounter++;
                    let radioGroupId = `radioGroup_${index}`;
                    let rowId = `row_${index}`;
                    let newItemHtml = `
                <div class="row" id="${rowId}">
                <div class="col-xl-9">
                    <input type="number" value="${item.id}" name="updateItmeIdName[${item.id}]" hidden>

                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label">Shift Name</label>
                            <input class="form-control" id="updateRotateName${item.id}" placeholder="Enter Shift Name" value="${item.shift_name}" type="text" name="editshiftname[${item.id}]" required>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label">Start Time</label>
                            <input class="form-control" id="updateRotateStart${item.id}" onchange="updateRotateFunction(${item.id})" placeholder="Set time" value="${item.shift_start}" type="time" name="editstartshift[${item.id}]" required>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label">End Time</label>
                            <input class="form-control" id="updateRotateEnd${item.id}" onchange="updateRotateFunction(${item.id})" placeholder="Set time" value="${item.shift_end}" type="time" name="editshiftTimeend[${item.id}]" required>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label">Break(Min)</label>
                            <input class="form-control" id="updateRotateBreak${item.id}"  onkeyup="updateRotateFunction(${item.id})" placeholder="Set time" value="${item.break_min}" type="number" value="${item.break_min}" name="updatedRotationalShiftBreak[${item.id}]" required>
                        </div>
                        <input class="form-control"  type="text" id="ru_WorkHour${item.id}" name="ru_WorkHour[${item.id}]" value="${item.work_hr}" hidden>
                        <input class="form-control"  type="text" id="ru_WorkMin${item.id}" name="ru_WorkMin[${item.id}]" value="${item.work_min}" hidden>
                    </div>
                </div>
                <div class="col-xl-3">
                    <label class="form-label">Break is</label>
                    <div class="row">
                        <div class="col-4">
                            <label class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="updateRotatePaid${item.id}"  onclick="updateRotateFunction(${item.id})" name="isPaid[${item.id}]" value="1" ${(item.is_paid == 1) ? 'checked' : ''}>
                                <span class="custom-control-label">Paid</span>
                            </label>
                        </div>
                        <div class="col-5">
                            <label class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="updateRotateUnpaid${item.id}"  onclick="updateRotateFunction(${item.id})" name="isPaid[${item.id}]" value="0" ${(item.is_paid == 0) ? 'checked' : ''}>
                                <span class="custom-control-label">Unpaid</span>
                            </label>
                        </div>
                        <div class="col-3 text-end">
                            <button type="button" class="btn btn-sm btn-danger remove_item_btn_edit" data-row-id="${rowId}"><i class="feather feather-trash"></i></button>
                        </div>
                    </div>
                    <span class="mb-5 fs-12 text-muted" id="updateRot_fixedWorkHour${item.id}" name="totalworkhour[${item.id}]" value="${item.total_working_hour}">Total Work Hour: Min</span>
                </div>
            </div>`;

                    $('#show_item_edit').append(newItemHtml);

                }


                $('#updateButton').click(function() {
                    console.log('update btn call');
                    // Gather the updated data from the edited items
                    var updatedItems = [];
                    // var isValid = true; // Flag to track if all fields are valid
                    var isValid = true; // Initialize the validation flag as true

                    $('#show_item_edit .row').each(function(index) {
                        var row = $(this);
                        var shiftName = row.find('input[name="editshiftname[]"]').val();
                        var startTimeShift = row.find('input[name="editstartshift[]"]').val();
                        var endTimeShift = row.find('input[name="editshiftTimeend[]"]').val();
                        var breakMin = row.find('input[name="updatedRotationalShiftBreak[]"]').val();
                        var isPaid = row.find('input[name^="radioGroup_"][name$="_isPaid[]"]:checked').val();
                        var workHour = row.find('input[name="ru_WorkHour[]"]').val();
                        var workMin = row.find('input[name="ru_WorkMin[]"]').val();
                        var totalworkhour = row.find('input[name="totalworkhour[]"]').val();


                        if (!shiftName || !endTimeShift || !startTimeShift || shiftName === '' || startTimeShift ===
                            '' || endTimeShift === '' || breakMin === '' || isPaid === '' || workHour === '') {
                            // isValid = false; // Set the flag to false if any field is empty
                            // return false; // Exit the loop

                            return; // Skip this row if any field is empty or isPaid is undefined
                        }


                        var loaditem = {
                            shift_name: shiftName,
                            start_time: startTimeShift,
                            end_time: endTimeShift,
                            break_min: breakMin,
                            is_paid: isPaid,
                            work_hr: workHour,
                            work_min: workMin
                        };
                        // Assuming updatedItems is your array
                        updatedItems = updatedItems.filter(function(item) {
                            // Set the flag to false if any field is empty
                            isValid = false; // Set the flag to false if any field is empty

                            // Check if the item has all the required properties and none of them are undefined or empty
                            return (
                                item.shift_name !== undefined &&
                                item.start_time !== undefined &&
                                item.end_time !== undefined &&
                                item.break_min !== undefined &&
                                item.is_paid !== undefined &&
                                item.work_hr !== undefined &&
                                item.work_min !== undefined
                            );
                        });
                        // updatedItems = updatedItems.filter(function(item) {
                        //     // Check if is_paid is defined and at least one other property is defined
                        //     var definedProperties = Object.keys(item).filter(function(key) {
                        //         return item[key] !== undefined;
                        //     });

                        //     return definedProperties.includes('is_paid') && definedProperties.length > 1;
                        // });
                        // updatedItems = updatedItems.filter(function(item) {
                        //     // Check if the item has at least one property other than is_paid
                        //     return Object.keys(item).some(function(key) {
                        //         return key !== 'is_paid';
                        //     });
                        // });

                        // Now, updatedItems contains only items with properties other than is_paid
                        updatedItems.push(loaditem);
                        console.log(updatedItems);

                        // console.log(updatedItems);
                    });

                    // if (!isValid) {
                    //     console.log(isValid);
                    //     // Show an alert if any field is empty
                    //     Swal.fire({
                    //         title: 'Empty Fields',
                    //         text: 'Please fill in all fields for each item before updating.',
                    //         icon: 'error',
                    //     });
                    //     return false; // Prevent form submission
                    // }

                    $.ajax({
                        url: "{{ url('admin/settings/attendance/update_attendace_shift') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: $('#setId').val(),
                            shift_type: $('#shifttype').val(),
                            shift_rotation_name: $('#updatedRotationalName').val(),
                            updated_items: updatedItems // Send the array of updated items to the server
                        },
                        dataType: 'json',
                        success: function(result) {
                            console.log(result);
                            if (result.root != false) {
                                Swal.fire({
                                    timer: 2000,
                                    timerProgressBar: true,
                                    title: 'Update Successful',
                                    // text: 'Rotational Shift is Updated Successfully.',
                                    icon: 'success',
                                }).then(() => {
                                    // Reload the page after the alert is closed
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Update Failed',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    text: 'Rotational Shift is Not Updated',
                                    icon: 'error',
                                });
                            }
                            // Handle the AJAX success response as needed
                        }
                    });
                });

                $(document).ready(function() {
                    $(".add_item_btn_edit").click(function(e) {
                        rowCounter++; // Increment rowCounter
                        var radioGroupId = `radioGroup_${rowCounter}`;
                        var rowId = `row_${rowCounter}`; // rowCounter-1;

                        var shiftNameInput = $('#updateRotateName');
                        var startTimeInput = $('#updateRotateStart');
                        var endTimeInput = $('#updateRotateEnd');
                        var breakMinInput = $('#updateRotateBreak');
                        var alertElement = document.getElementById('editRotationalAlertMess');

                        alertElement.classList.add('d-none');


                        // var breakMinInput = $('#updateRotateBreak');
                        // var breakMinInput = $('#updateRotateBreak');

                        if (
                            shiftNameInput.val() === '' ||
                            startTimeInput.val() === '' ||
                            endTimeInput.val() === '' ||
                            breakMinInput.val() === ''
                        ) {
                            alert('Please fill in all fields for the new item before adding.');
                            return;
                        }

                        // Add the new row only if all fields are filled

                        // var radioGroupId = `radioGroup_${rowCounter}`;
                        // var rowId = `row_${rowCounter}`;
                        // updateRotateFunction(rowCounter);

                        $("#show_item_edit").append(`
                <div class="row" id="${rowId}">
                    <input type="number" value="${-rowCounter}" name="updateItmeIdName[-${rowCounter}]" hidden>
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-xl-3 mb-4">
                                <label class="form-label">Shift Name</label>
                                <input class="form-control" id="updateRotateName${rowCounter}" placeholder="Enter Shift Name" type="text" name="editshiftname[-${rowCounter}]" required>
                            </div>
                            <div class="col-xl-3 mb-4">
                                <label class="form-label">Start Time</label>
                                <input class="form-control" id="updateRotateStart${rowCounter}" onchange="updateRotateFunction(${rowCounter})" placeholder="Set time" type="time" name="editstartshift[-${rowCounter}]" required>
                            </div>
                            <div class="col-xl-3 mb-4">
                                <label class="form-label">End Time</label>
                                <input class="form-control" id="updateRotateEnd${rowCounter}" onchange="updateRotateFunction(${rowCounter})" placeholder="Set time" type="time" name="editshiftTimeend[-${rowCounter}]" required>
                            </div>
                            <div class="col-xl-3 mb-4">
                                <label class="form-label">Break(Min)</label>
                                <input class="form-control" id="updateRotateBreak${rowCounter}" onkeyup="updateRotateFunction(${rowCounter})" placeholder="Set time" type="number" name="updatedRotationalShiftBreak[-${rowCounter}]" required>
                            </div>
                            <input class="form-control"  type="text" id="ru_WorkHour${rowCounter}" name="ru_WorkHour[-${rowCounter}]" hidden >
                            <input class="form-control"  type="text" id="ru_WorkMin${rowCounter}" name="ru_WorkMin[-${rowCounter}]"  hidden>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label class="form-label">Break is</label>
                        <div class="row">
                            <div class="col-4">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input"  id="updateRotatePaid${rowCounter}" onclick="updateRotateFunction(${rowCounter})"  name="isPaid[-${rowCounter}]" value="1"  checked>
                                    <span class="custom-control-label">Paid</span>
                                </label>
                            </div>
                            <div class="col-5">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input"  id="updateRotateUnpaid${rowCounter}"   onclick="updateRotateFunction(${rowCounter})" name="isPaid[-${rowCounter}]" value="0">
                                    <span class="custom-control-label">Unpaid</span>
                                </label>
                            </div>
                            <div class="col-3 text-end">
                                <button type="button" class="btn btn-sm btn-danger remove_item_btn_edit" data-row-id="${rowId}"><i class="feather feather-trash"></i></button>
                            </div>
                        </div>
                        <span class="mb-5 fs-12 text-muted"  id="updateRot_fixedWorkHour${rowCounter}" name="totalworkhour[-${rowCounter}]">Total Work Hour: Min</span>
                    </div>
                </div>`);
                    });

                    $(document).on('click', '.remove_item_btn_edit', function(e) {
                        var alertElement = document.getElementById('editRotationalAlertMess');
                        // function removeItem(rowId) {
                        // Check if there's only one item left before removing
                        if ($('.remove_item_btn_edit').length > 1) {
                            let rowIdToRemove = $(this).data('row-id');
                            $('#' + rowIdToRemove).remove();
                            // check.disabled = false;
                            alertElement.classList.add('d-none');
                        } else {
                            alertElement.classList.remove('d-none');

                            // check.disabled = true;
                            // alert("You can't delete last row.");
                            return false;
                        }
                        // }


                        let rowIdToRemove = $(this).data('row-id');
                        $('#' + rowIdToRemove).remove();
                    });
                });
            </script>

            <script>
                function openEditFixedShiftModel(context) {
                    var id = $(context).data('id');
                    var shift_name = $(context).data('shift_name');
                    var shift_ftype = $(context).data('shift_type');
                    var shift_fstart = $(context).data('shift_start');
                    var shift_fend = $(context).data('shift_end');
                    var work_hr = $(context).data('work_hr');
                    var work_min = $(context).data('work_min');
                    var shift_fbreak = $(context).data('break_min');
                    var shift_fisPaid = $(context).data('is_paid');
                    $('#fixedId').val(id);
                    $('#shift_fname').val(shift_name);
                    $('#shift_ftype').val(shift_ftype);
                    $('#updated_start_time').val(shift_fstart);
                    $('#updated_end_time').val(shift_fend);
                    $('#updated_break_time').val(shift_fbreak);
                    $('#fu_WorkHour').val(work_hr);
                    $('#fu_WorkMin').val(work_min);

                    if (shift_fisPaid == 1) {
                        $('#updated_paid').prop('checked', true);
                    } else {
                        $('#updated_unpaid').prop('checked', true);
                    }

                    timeCalculate();


                    console.log(shift_fisPaid);
                }

                function openEditOpenShiftModel(context) {

                    var id = $(context).data('id');
                    var shift_ttype = $(context).data('shift_type');
                    var shift_name = $(context).data('shift_name');
                    var shift_hour = $(context).data('shift_hour');
                    var shift_min = $(context).data('shift_min');
                    var shift_break_min = $(context).data('break_min');
                    var shift_tisPaid = $(context).data('is_paid');
                    $('#editopenshiftId').val(id);
                    $('#shift_ttype').val(shift_ttype);
                    $('#editshift_tname').val(shift_name);
                    $('#editshift_hour').val(shift_hour);
                    $('#editshift_min').val(shift_min);
                    $('#editshift_breack').val(shift_break_min);

                    if (shift_tisPaid == 1) {
                        $('#editopenPaid').prop('checked', true);
                    } else {
                        $('#editopenUnpaid').prop('checked', true);
                    }

                    openUpdateMyFunction();
                }


                function timeCalculate() {
                    // alert(id);
                    let updated_start_time = document.getElementById("updated_start_time").value;
                    let updated_end_time = document.getElementById("updated_end_time").value;
                    let updated_break_time = document.getElementById("updated_break_time").value;

                    // Example time inputs
                    const updated_startTime = updated_start_time;
                    const updated_endTime = updated_end_time;
                    const updated_breakTime = updated_break_time; // in minutes

                    // Parse the time inputs
                    const [updated_startHours, updated_startMinutes] = updated_startTime.split(":").map(Number);
                    const [updated_endHours, updated_endMinutes] = updated_endTime.split(":").map(Number);

                    // Calculate the time difference in minutes

                    let updated_differenceMinutes = (updated_endHours * 60 + updated_endMinutes) - (updated_startHours * 60 +
                        updated_startMinutes);

                    // Ensure the differenceMinutes is positive
                    if (updated_differenceMinutes < 0) {
                        updated_differenceMinutes += 1440; // 24 hours in minutes
                    }


                    if ($('#updated_unpaid').is(':checked')) {
                        // Subtract break time
                        updated_differenceMinutes -= updated_breakTime;
                    }

                    // Ensure the result is positive
                    if (updated_differenceMinutes < 0) {
                        updated_differenceMinutes = 0;
                    }

                    // Calculate the hours and minutes for the result
                    const updated_resultHours = Math.floor(updated_differenceMinutes / 60);
                    const updated_resultMinutes = updated_differenceMinutes % 60;

                    // Format the result as "HH:MM"
                    const updated_formattedResult =
                        `${String(updated_resultHours).padStart(2, '0')}:${String(updated_resultMinutes).padStart(2, '0')}`;
                    // console.log(updated_formattedResult);
                    var updated_fixedHour = document.getElementById('UpdateFixedWorkHour');
                    document.getElementById('fu_WorkHour').value = `${String(updated_resultHours).padStart(2, '0')}`;
                    document.getElementById('fu_WorkMin').value = `${String(updated_resultMinutes).padStart(2, '0')}`;
                    updated_fixedHour.innerHTML = '';
                    updated_fixedHour.innerHTML =
                        `Total Work Hour: ${String(updated_resultHours).padStart(2, '0')} Hr ${String(updated_resultMinutes).padStart(2, '0')} Min`;
                    console.log(`Result: ${updated_formattedResult}`);
                }
            </script>
            <script>
                // function updateRotationalField() {

                // console.log(Id);
                // let updatedRotationalShift = '<div class="row" id="updateRotationalField' + Id + '">' +
                //     '<div class="col-xl-9">' +
                //     '<div class="row">' +
                //     '<div class="col-xl-3 mb-4">' +
                //     '<label class="form-label">Shift Name</label>' +
                //     '<input type="text" id="ru_WorkHour' + Id + '" name="ru_WorkHour[]" value="" hidden>' +
                //     '<input type="text" id="ru_WorkMin' + Id + '" name="ru_WorkMin[]" value="" hidden>' +
                //     '<input class="form-control" placeholder="Enter Shift Name" type="text" name="editshiftname[]">' +
                //     '</div>' +
                //     '<div class="col-xl-3 mb-4">' +
                //     '<label class="form-label">Start Time</label>' +
                //     '<input class="form-control" id="updateRotateStart' + Id + '" onchange="updateRotateFunction(' + Id +
                //     ')"  placeholder="Set time" type="time" name="editstartshift[]">' +
                //     '</div>' +
                //     '<div class="col-xl-3 mb-4">' +
                //     '<label class="form-label">End Time</label>' +
                //     '<input class="form-control" id="updateRotateEnd' + Id + '" onchange="updateRotateFunction(' + Id +
                //     ')"  placeholder="Set time" type="time" name="updatedRotationalShiftEnd[]">' +
                //     '</div>' +
                //     '<div class="col-xl-3 mb-4">' +
                //     '<label class="form-label">Break(Min)</label>' +
                //     '<input class="form-control" id="updateRotateBreak' + Id + '" onchange="updateRotateFunction(' + Id +
                //     ')"  placeholder="Set time" type="number" name="updatedRotationalShiftBreak[]">' +
                //     '</div>' +
                //     '</div>' +
                //     '</div>' +
                //     '<div class="col-xl-3">' +
                //     '<label class="form-label">Break is</label>' +
                //     '<div class="row">' +
                //     '<div class="col-4">' +
                //     '<label class="custom-control custom-radio">' +
                //     '<input type="radio" id="updateRotatePaid' + Id + '" onchange="updateRotateFunction(' + Id +
                //     ')" class="custom-control-input"  name="updatedRotationalpaid[]' + Id + '" value="1" checked>' +
                //     '<span class="custom-control-label">Paid</span>' +
                //     '</label>' +
                //     '</div>' +
                //     '<div class="col-5">' +
                //     '<label class="custom-control custom-radio">' +
                //     '<input type="radio" id="updateRotateUnpaid' + Id + '" onchange="updateRotateFunction(' + Id +
                //     ')" class="custom-control-input"  name="updatedRotationalpaid[]' + Id + '" value="0">' +
                //     '<span class="custom-control-label">Unpaid</span>' +
                //     '</label>' +
                //     '</div>' +
                //     '<div class="col-3">' +
                //     '<a class="btn btn-sm btn-danger" id="deleteElem' + Id + '" onclick="removalUpdaedElement(' + Id +
                //     ')"><i class="fa fa-trash"></i></a>' +
                //     '</div>' +
                //     '</div>' +
                //     '<span id="updateRot_fixedWorkHour' + Id + '" class="mb-5 fs-12 text-muted"></span>' +
                //     '</div>' +
                //     '</div>';

                // let parent = document.getElementById('updateAppendField' + setId);
                // parent.insertAdjacentHTML('beforeend', updatedRotationalShift);
                // }

                function updateRotateFunction(rotId) {
                    // rotId = 1;
                    // console.log(rotId);
                    let updateRot_start_time = document.getElementById("updateRotateStart" + rotId).value;
                    let updateRot_end_time = document.getElementById("updateRotateEnd" + rotId).value;
                    let updateRot_break_time = document.getElementById("updateRotateBreak" + rotId).value;
                    // alert('abvc')
                    // Example time inputs
                    const updateRot_startTime = updateRot_start_time;
                    const updateRot_endTime = updateRot_end_time;
                    const updateRot_breakTime = updateRot_break_time; // in minutes

                    // Parse the time inputs
                    const [updateRot_startHours, updateRot_startMinutes] = updateRot_startTime.split(":").map(Number);
                    const [updateRot_endHours, updateRot_endMinutes] = updateRot_endTime.split(":").map(Number);

                    // Calculate the time difference in minutes
                    let updateRot_differenceMinutes = (updateRot_endHours * 60 + updateRot_endMinutes) - (updateRot_startHours *
                        60 + updateRot_startMinutes);

                    // Ensure the differenceMinutes is positive
                    if (updateRot_differenceMinutes < 0) {
                        updateRot_differenceMinutes += 1440; // 24 hours in minutes
                    }


                    if ($('#updateRotateUnpaid' + rotId).is(':checked')) {
                        // Subtract break time
                        updateRot_differenceMinutes -= updateRot_breakTime;
                    }

                    // Ensure the result is positive
                    if (updateRot_differenceMinutes < 0) {
                        updateRot_differenceMinutes = 0;
                    }

                    // Calculate the hours and minutes for the result
                    const updateRot_resultHours = Math.floor(updateRot_differenceMinutes / 60);
                    const updateRot_resultMinutes = updateRot_differenceMinutes % 60;

                    // Format the result as "HH:MM"
                    const updateRot_formattedResult =
                        `${String(updateRot_resultHours).padStart(2, '0')}:${String(updateRot_resultMinutes).padStart(2, '0')}`;
                    var updateRot_fixedHour = document.getElementById('updateRot_fixedWorkHour' + rotId);
                    document.getElementById('ru_WorkHour' + rotId).value = `${String(updateRot_resultHours).padStart(2, '0')}`;
                    document.getElementById('ru_WorkMin' + rotId).value = `${String(updateRot_resultMinutes).padStart(2, '0')}`;
                    updateRot_fixedHour.innerHTML =
                        `Total Work Hour: ${String(updateRot_resultHours).padStart(2, '0')} Hr ${String(updateRot_resultMinutes).padStart(2, '0')} Min`;
                    console.log(`Result: ${updateRot_formattedResult}`);
                }

                function removalUpdaedElement(id) {
                    // alert(id);
                    // Get the element you want to remove by its ID
                    var updatedElementToRemove = document.getElementById('updateRotationalField' + id);

                    // Check if the element exists before attempting to remove it
                    if (updatedElementToRemove) {
                        console.log(id);
                        // Remove the element
                        updatedElementToRemove.remove();
                    } else {
                        console.log("Element with ID 'field' does not exist.");
                    }
                }

                // function rotationaPaid(index) {
                //     document.getElementById('unpaid'+index).checked = false;
                //     document.getElementById('paid'+index).checked = true;

                // }
                // function rotationaUnpaid(index) {
                //     document.getElementById('unpaid'+index).checked = true;
                //     document.getElementById('paid'+index).checked = false;
                // }

                function load(value) {
                    // alert(value);
                    if (value == 'fixed') {
                        $('#shiftname').removeClass('d-none');
                        $('#shiftname2').addClass('d-none');
                        $('#shifttime').removeClass('d-none');
                        $('#unpaidbreaklabel').removeClass('d-none');
                        $('#unpaidbreak').removeClass('d-none');
                        $('#workhour').addClass('d-none');
                        $('#additionaltbl').addClass('d-none');
                    } else if (value == 'rotational') {
                        $('#shiftname').addClass('d-none');
                        $('#shiftname2').removeClass('d-none');
                        $('#shifttime').addClass('d-none');
                        $('#unpaidbreaklabel').addClass('d-none');
                        $('#unpaidbreak').addClass('d-none');
                        $('#workhour').addClass('d-none');
                        $('#additionaltbl').removeClass('d-none');
                    } else {
                        $('#shiftname2').addClass('d-none');
                        $('#shiftname').removeClass('d-none');
                        $('#shifttime').addClass('d-none');
                        $('#unpaidbreaklabel').addClass('d-none');
                        $('#unpaidbreak').addClass('d-none');
                        $('#workhour').removeClass('d-none');
                        $('#additionaltbl').addClass('d-none');
                    }
                }
            </script>

            {{-- <div class=""> --}}

            {{-- <div class="container">
            <div class="modal fade" id="fixShiftEdit{{ $fix->fixed_id }}">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">

                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Shift
                                Policy
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('update.shift') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <input type="text" name="fixedId" value="{{ $fix->fixed_id }}" hidden>
                                        <h3 class="card-title">Update Shift</h3>
                                    </div>

                                    <div class="card-body">
                                        <input type="text" id="fu_WorkHour{{ $fix->fixed_id }}" name="fu_WorkHour"
                                            value="{{ $fix->work_hr }}" hidden>
                                        <input type="text" id="fu_WorkMin{{ $fix->fixed_id }}" name="fu_WorkMin"
                                            value="{{ $fix->work_min }}" hidden>



                                        <div class="form-group">
                                            <label class="form-label">Shift Type</label>
                                            <select onchange="load(this.value)" name="shiftType"
                                                class="form-control custom-select select2"
                                                data-placeholder="Select Country" id="shifttype" disabled required>
                                                <option value="1">Fixed Shift</option>
                                                <option value="2">Rotational Shift</option>
                                                <option value="3">Open Shift</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" placeholder="Enter Shift Name"
                                                        value="{{ $fix->shift_name }}" type="text"
                                                        name="UpdatedFixedshiftName">

                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Start Time</label>
                                                    <input class="form-control"
                                                        id="updated_start_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->shift_start }}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="time" name="UpdatedFixShiftStart">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">End Time</label>
                                                    <input class="form-control"
                                                        id="updated_end_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->shift_end }}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="time" name="UpdatedFixShiftEnd">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control"
                                                        id="updated_break_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->break_min }}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="number"
                                                        name="UpdatedFixShiftBreak">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            @if ($fix->is_paid == 1)
                                                            @php
                                                            $check = 'checked';
                                                            $uncheck = '';
                                                            @endphp
                                                            @else
                                                            @php
                                                            $check = '';
                                                            $uncheck = 'checked';
                                                            @endphp
                                                            @endif
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="updated_paid{{ $fix->fixed_id }}"
                                                                    class="custom-control-input"
                                                                    onchange="timeCalculate({{ $fix->fixed_id }})"
                                                                    name="UpdatedFixpaid" value="1" {{ $check }}>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="updated_unpaid{{ $fix->fixed_id }}"
                                                                    class="custom-control-input"
                                                                    onchange="timeCalculate({{ $fix->fixed_id }})"
                                                                    name="UpdatedFixpaid" value="0" {{ $uncheck }}>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="UpdateFixedWorkHour{{ $fix->fixed_id }}"
                                                        class="mb-5 fs-12 text-muted">Total Work Hour:
                                                        {{ $fix->work_hr }} Hr {{ $fix->work_min }} Min</span>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function timeCalculate(id) {
                                                        // alert(id);
                                                        let updated_start_time = document.getElementById("updated_start_time" + id).value;
                                                        let updated_end_time = document.getElementById("updated_end_time" + id).value;
                                                        let updated_break_time = document.getElementById("updated_break_time" + id).value;

                                                        // Example time inputs
                                                        const updated_startTime = updated_start_time;
                                                        const updated_endTime = updated_end_time;
                                                        const updated_breakTime = updated_break_time; // in minutes

                                                        // Parse the time inputs
                                                        const [updated_startHours, updated_startMinutes] = updated_startTime.split(":").map(Number);
                                                        const [updated_endHours, updated_endMinutes] = updated_endTime.split(":").map(Number);

                                                        // Calculate the time difference in minutes

                                                        let updated_differenceMinutes = (updated_endHours * 60 + updated_endMinutes) - (updated_startHours * 60 +
                                                            updated_startMinutes);

                                                        // Ensure the differenceMinutes is positive
                                                        if (updated_differenceMinutes < 0) {
                                                            updated_differenceMinutes += 1440; // 24 hours in minutes
                                                        }


                                                        if ($('#updated_unpaid').is(':checked')) {
                                                            // Subtract break time
                                                            updated_differenceMinutes -= updated_breakTime;
                                                        }

                                                        // Ensure the result is positive
                                                        if (updated_differenceMinutes < 0) {
                                                            updated_differenceMinutes = 0;
                                                        }

                                                        // Calculate the hours and minutes for the result
                                                        const updated_resultHours = Math.floor(updated_differenceMinutes / 60);
                                                        const updated_resultMinutes = updated_differenceMinutes % 60;

                                                        // Format the result as "HH:MM"
                                                        const updated_formattedResult =
                                                            `${String(updated_resultHours).padStart(2, '0')}:${String(updated_resultMinutes).padStart(2, '0')}`;
                                                        // console.log(updated_formattedResult);
                                                        var updated_fixedHour = document.getElementById('UpdateFixedWorkHour' + id);
                                                        document.getElementById('fu_WorkHour' + id).value = `${String(updated_resultHours).padStart(2, '0')}`;
                                                        document.getElementById('fu_WorkMin' + id).value = `${String(updated_resultMinutes).padStart(2, '0')}`;
                                                        updated_fixedHour.innerHTML = '';
                                                        updated_fixedHour.innerHTML =
                                                            `Total Work Hour: ${String(updated_resultHours).padStart(2, '0')} Hr ${String(updated_resultMinutes).padStart(2, '0')} Min`;
                                                        console.log(`Result: ${updated_formattedResult}`);
                                                    }
                                        </script>


                                    </div>
                                    <!-- table-responsive -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        </div>
        </div>

        {{-- add new shift --}}
        <div class="container">
            {{-- create modal --}}
            <div class="modal fade" id="additionalModal" data-bs-backdrop="static">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Create Shift
                                Policy
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('add.shift') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add New Shift</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Shift Type</label>
                                            {{-- <select name="" id="" required></select> --}}
                                            <select onchange="load(this.value)" name="shiftType"
                                                class="form-control custom-select" name=""
                                                data-placeholder="Select Shift" id="shifttype" required>
                                                <option label="Select Shift"></option>
                                                <option value="1">Fixed Shift</option>
                                                <option value="2">Rotational Shift</option>
                                                <option value="3">Open Shift</option>
                                            </select>

                                            <input type="text" id="f_WorkHour" name="f_WorkHour" value=""
                                                hidden>
                                            <input type="text" id="f_WorkMin" name="f_WorkMin" value="" hidden>

                                            <input type="text" id="r_WorkHour0" name="r_WorkHour[]" value=""
                                                hidden>
                                            <input type="text" id="r_WorkMin0" name="r_WorkMin[]" value=""
                                                hidden>
                                        </div>
                                        {{-- fixed shift --}}
                                        <div class="form-group d-none" id="shifttime">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" placeholder="Enter Shift Name"
                                                        type="text" name="fixedshiftName" id="shiftNameId1">

                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Start Time</label>
                                                    <input class="form-control" id="start_time" onchange="myFunction()"
                                                        placeholder="Set time" type="time" name="fixShiftStart">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">End Time</label>
                                                    <input class="form-control" id="end_time" onchange="myFunction()"
                                                        placeholder="Set time" type="time" name="fixShiftEnd">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" id="break_time" onchange="myFunction()"
                                                        placeholder="Set time" type="number" name="fixShiftBreak"
                                                        id="breakMinId1">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="paid"
                                                                    class="custom-control-input" onchange="myFunction()"
                                                                    name="fixpaid" value="1" checked>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="unpaid"
                                                                    class="custom-control-input" onchange="myFunction()"
                                                                    name="fixpaid" value="0" checked>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="fixedWorkHour" class="mb-5 fs-12 text-muted"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function myFunction() {
                                                let start_time = document.getElementById("start_time").value;
                                                let end_time = document.getElementById("end_time").value;
                                                let break_time = document.getElementById("break_time").value;
                                                // alert('abvc')
                                                // Example time inputs
                                                const startTime = start_time;
                                                const endTime = end_time;
                                                const breakTime = break_time; // in minutes

                                                // Parse the time inputs
                                                const [startHours, startMinutes] = startTime.split(":").map(Number);
                                                const [endHours, endMinutes] = endTime.split(":").map(Number);

                                                // Calculate the time difference in minutes
                                                let differenceMinutes = (endHours * 60 + endMinutes) - (startHours * 60 + startMinutes);

                                                // Ensure the differenceMinutes is positive
                                                if (differenceMinutes < 0) {
                                                    differenceMinutes += 1440; // 24 hours in minutes
                                                }


                                                if ($('#unpaid').is(':checked')) {
                                                    // Subtract break time
                                                    differenceMinutes -= breakTime;
                                                }

                                                // Ensure the result is positive
                                                if (differenceMinutes < 0) {
                                                    differenceMinutes = 0;
                                                }

                                                // Calculate the hours and minutes for the result
                                                const resultHours = Math.floor(differenceMinutes / 60);
                                                const resultMinutes = differenceMinutes % 60;

                                                // Format the result as "HH:MM"
                                                const formattedResult = `${String(resultHours).padStart(2, '0')}:${String(resultMinutes).padStart(2, '0')}`;
                                                var fixedHour = document.getElementById('fixedWorkHour');
                                                document.getElementById('f_WorkHour').value = `${String(resultHours).padStart(2, '0')}`;
                                                document.getElementById('f_WorkMin').value = `${String(resultMinutes).padStart(2, '0')}`;
                                                fixedHour.innerHTML =
                                                    `Total Work Hour: ${String(resultHours).padStart(2, '0')} Hr ${String(resultMinutes).padStart(2, '0')} Min`;
                                                console.log(`Result: ${formattedResult}`);
                                            }
                                        </script>

                                        {{-- open shift --}}
                                        <div class="form-group d-none" id="workhour">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" placeholder="Enter Shift Name"
                                                        id="shiftNameId3" type="text" name="openShiftName">

                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Hour</label>
                                                    <input class="form-control m-0" placeholder="Set" type="number"
                                                        onchange="openMyFunction()" id="hourId" name="openHour">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Minutes</label>
                                                    <input class="form-control" placeholder="Set" type="number"
                                                        onchange="openMyFunction()" id="minuteId" name="openMin">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" placeholder="Set" type="number"
                                                        onchange="openMyFunction()" id="breakMinuteOpenId"
                                                        name="openBreak">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" onchange="openMyFunction()"
                                                                    onchange="openPaid()" id="openPaid"
                                                                    class="custom-control-input" name="openPaid"
                                                                    value="1" checked>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" onchange="openMyFunction()"
                                                                    onchange="openUnpaid()" id="openUnpaid"
                                                                    class="custom-control-input" name="openPaid"
                                                                    value="0" checked>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function openPaid() {
                                                            document.getElementById('openUnpaid').checked = false;
                                                            document.getElementById('openPaid').checked = true;

                                                        }

                                                        function openUnpaid() {
                                                            document.getElementById('openUnpaid').checked = true;
                                                            document.getElementById('openPaid').checked = false;
                                                        }
                                                    </script>
                                                    <span id="CreateOpenHour" class="mb-5 fs-12 text-muted"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function openMyFunction() {
                                                let open_shift_hr = parseInt(document.getElementById("hourId").value) || 0;
                                                let open_shift_minute = parseInt(document.getElementById("minuteId").value) || 0;
                                                let open_shift_break_minute = parseInt(document.getElementById("breakMinuteOpenId").value) || 0;
                                                let updated_differenceMinutes = open_shift_hr * 60 + open_shift_minute;
                                                // Get the element where you want to display the total work hour
                                                let timeshow = document.getElementById("CreateOpenHour");
                                                // Ensure the differenceMinutes is positive
                                                if (updated_differenceMinutes < 0) {
                                                    updated_differenceMinutes += 1440; // 24 hours in minutes
                                                }
                                                // Subtract break time if openUnpaid is checked
                                                if ($('#openUnpaid').is(':checked')) {
                                                    updated_differenceMinutes -= open_shift_break_minute;
                                                } else if ($('#openPaid').is(':checked')) {
                                                    let updated_differenceMinutes = open_shift_hr * 60 + open_shift_minute;
                                                    if (updated_differenceMinutes < 0) {
                                                        updated_differenceMinutes += 1440; // 24 hours in minutes
                                                    }
                                                }
                                                // Ensure the final result is not negative
                                                updated_differenceMinutes = Math.max(updated_differenceMinutes, 0);
                                                // Calculate hours and minutes
                                                const updated_resultHours = Math.floor(updated_differenceMinutes / 60);
                                                const updated_resultMinutes = updated_differenceMinutes % 60;
                                                // Format the result with leading zeros
                                                const updated_formattedResult =
                                                    `${String(updated_resultHours).padStart(2, '0')} Hr ${String(updated_resultMinutes).padStart(2, '0')} Min`;
                                                // Clear previous content
                                                timeshow.innerHTML = '';
                                                // Set innerHTML to display the total work hour
                                                timeshow.innerHTML = `Total Work Hour: ${updated_formattedResult}`;
                                                console.log(`Result: ${updated_formattedResult}`);
                                            }
                                        </script>
                                        {{-- roatational shift --}}
                                        <div class="form-group d-none" id="shiftname2">
                                            <div class="row">
                                                {{-- <div class="col-11 my-1 mb-3">
                                                <label class="form-label">Repeat Shift in Every <input
                                                        class="mx-2 text-center" type="number" name="repeat_week"
                                                        min="1" max="6" style="width: 3rem">Weeks</label>
                                            </div> --}}
                                                <div class="col-10 col-xl-11">
                                                    <label class="form-label">Rotational Shift Name</label>
                                                    <input class="form-control mb-4" placeholder="Enter Shift Name"
                                                        id="rotationalNameId" type="text" name="rotationalName">
                                                </div>
                                                <div class="col-1 mt-4 text-end">
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary mt-3 ms-xl-5 ms-auto"
                                                        onclick="addRotationalField()"><i class="fe fe-plus bold"></i>
                                                    </button>
                                                    {{-- <a class="btn btn-outline-primary mt-2"
                                                onclick="addRotationalField()">Add
                                                New</a> --}}
                                                </div>
                                            </div>

                                            <div class="row" id="newRotationalField0">
                                                <div class="col-xl-9">
                                                    <div class="row">
                                                        <div class="col-xl-3 mb-4">
                                                            <label class="form-label">Shift Name</label>
                                                            <input class="form-control rotationalShiftNameClass"
                                                                placeholder="Enter Shift Name" type="text"
                                                                name="rotationalShiftName[]">

                                                        </div>
                                                        <div class="col-xl-3 mb-4">
                                                            <label class="form-label">Start Time</label>
                                                            <input class="form-control rotationalStartTimeClass"
                                                                onchange="rotateFunction(0)" id="start_time0"
                                                                placeholder="Set time" type="time"
                                                                name="rotationalShiftStart[]">
                                                        </div>
                                                        <div class="col-xl-3 mb-4">
                                                            <label class="form-label">End Time</label>
                                                            <input class="form-control rotationalEndTimeClass"
                                                                onchange="rotateFunction(0)" id="end_time0"
                                                                placeholder="Set time" type="time"
                                                                name="rotationalShiftEnd[]">
                                                        </div>
                                                        <div class="col-xl-3 mb-4">
                                                            <label class="form-label">Break(Min)</label>
                                                            <input class="form-control rotationalBreakMinClass"
                                                                onchange="rotateFunction(0)" id="break_time0"
                                                                placeholder="Set time" type="number"
                                                                name="rotationalShiftBreak[]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="rotatePaid0"
                                                                    class="custom-control-input"
                                                                    onchange="rotateFunction(0)" name="rotationalpaid[]"
                                                                    value="1" checked>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-5">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="rotateUnpaid0"
                                                                    class="custom-control-input"
                                                                    onchange="rotateFunction(0)" name="rotationalpaid[]"
                                                                    value="0">
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-3 text-end">
                                                            {{-- <a class="btn btn-sm btn-danger" id="deleteElem0"
                                                        onclick="removalElement(0)"><i class="fa fa-trash"></i></a> --}}

                                                            <button type="button" id="deleteElem0"
                                                                class="btn btn-sm btn-danger text-end"
                                                                onclick="removalElement(0)"><i
                                                                    class="feather feather-trash"></i></button>
                                                        </div>
                                                    </div>
                                                    <span id="rot_fixedWorkHour0" class="mb-5 fs-12 text-muted"></span>
                                                </div>
                                            </div>

                                            <script>
                                                let i = 0;

                                                function addRotationalField() {
                                                    var alertMessageRotational = document.getElementById('alertMessageRotational');
                                                    alertMessageRotational.classList.add('d-none');

                                                    i++;
                                                    let rotationalShift = '<div class="row show_item_insert" id="newRotationalField' + i + '">' +
                                                        '<div class="col-xl-9">' +
                                                        '<div class="row">' +
                                                        '<div class="col-xl-3 mb-4">' +
                                                        '<label class="form-label">Shift Name</label>' +
                                                        '<input type="text" id="r_WorkHour' + i + '" name="r_WorkHour[]" value="" hidden>' +
                                                        '<input type="text" id="r_WorkMin' + i + '" name="r_WorkMin[]" value="" hidden>' +
                                                        '<input class="form-control" placeholder="Enter Shift Name" type="text" name="rotationalShiftName[]" required>' +
                                                        '</div>' +
                                                        '<div class="col-xl-3 mb-4">' +
                                                        '<label class="form-label">Start Time</label>' +
                                                        '<input class="form-control" onchange="rotateFunction(' + i + ')" id="start_time' + i +
                                                        '"  placeholder="Set time" type="time" name="rotationalShiftStart[]" required>' +
                                                        '</div>' +
                                                        '<div class="col-xl-3 mb-4">' +
                                                        '<label class="form-label">End Time</label>' +
                                                        '<input class="form-control" onchange="rotateFunction(' + i + ')" id="end_time' + i +
                                                        '"  placeholder="Set time" type="time" name="rotationalShiftEnd[]" required>' +
                                                        '</div>' +
                                                        '<div class="col-xl-3 mb-4">' +
                                                        '<label class="form-label">Break(Min)</label>' +
                                                        '<input class="form-control" onchange="rotateFunction(' + i + ')" id="break_time' + i +
                                                        '"  placeholder="Set time" type="number" name="rotationalShiftBreak[]" required>' +
                                                        '</div>' +
                                                        '</div>' +
                                                        '</div>' +
                                                        '<div class="col-xl-3">' +
                                                        '<label class="form-label">Break is</label>' +
                                                        '<div class="row">' +
                                                        '<div class="col-4">' +
                                                        '<label class="custom-control custom-radio">' +
                                                        '<input type="radio" id="rotatePaid' + i + '" onchange="rotateFunction(' + i +
                                                        ')" class="custom-control-input" onchange="rotationaPaid(' + i + ')" name="rotationalpaid[]' + i +
                                                        '" value="1" checked>' +
                                                        '<span class="custom-control-label">Paid</span>' +
                                                        '</label>' +
                                                        '</div>' +
                                                        '<div class="col-5">' +
                                                        '<label class="custom-control custom-radio">' +
                                                        '<input type="radio" id="rotateUnpaid' + i + '" onchange="rotateFunction(' + i +
                                                        ')" class="custom-control-input" onchange="rotationaUnpaid(' + i + ')" name="rotationalpaid[]' + i +
                                                        '" value="0">' +
                                                        '<span class="custom-control-label">Unpaid</span>' +
                                                        '</label>' +
                                                        '</div>' +
                                                        '<div class="col-3 text-end">' +
                                                        '<a class="btn btn-sm btn-danger" id="deleteElem' + i + '" onclick="removalElement(' + i +
                                                        ')"><i class="feather feather-trash"></i></a>' +
                                                        '</div>' +
                                                        '</div>' +
                                                        '<span id="rot_fixedWorkHour' + i + '" class="mb-5 fs-12 text-muted"></span>' +
                                                        '</div>' +
                                                        '</div>';

                                                    let parent = document.getElementById('shiftname2');
                                                    parent.insertAdjacentHTML('beforeend', rotationalShift);
                                                }


                                                function rotateFunction(rotId) {
                                                    let rot_start_time = document.getElementById("start_time" + rotId).value;
                                                    let rot_end_time = document.getElementById("end_time" + rotId).value;
                                                    let rot_break_time = document.getElementById("break_time" + rotId).value;
                                                    // alert('abvc')
                                                    // Example time inputs
                                                    const rot_startTime = rot_start_time;
                                                    const rot_endTime = rot_end_time;
                                                    const rot_breakTime = rot_break_time; // in minutes

                                                    // Parse the time inputs
                                                    const [rot_startHours, rot_startMinutes] = rot_startTime.split(":").map(Number);
                                                    const [rot_endHours, rot_endMinutes] = rot_endTime.split(":").map(Number);

                                                    // Calculate the time difference in minutes
                                                    let rot_differenceMinutes = (rot_endHours * 60 + rot_endMinutes) - (rot_startHours * 60 + rot_startMinutes);

                                                    // Ensure the differenceMinutes is positive
                                                    if (rot_differenceMinutes < 0) {
                                                        rot_differenceMinutes += 1440; // 24 hours in minutes
                                                    }


                                                    if ($('#rotateUnpaid' + rotId).is(':checked')) {
                                                        // Subtract break time
                                                        rot_differenceMinutes -= rot_breakTime;
                                                    }

                                                    // Ensure the result is positive
                                                    if (rot_differenceMinutes < 0) {
                                                        rot_differenceMinutes = 0;
                                                    }

                                                    // Calculate the hours and minutes for the result
                                                    const rot_resultHours = Math.floor(rot_differenceMinutes / 60);
                                                    const rot_resultMinutes = rot_differenceMinutes % 60;

                                                    // Format the result as "HH:MM"
                                                    const rot_formattedResult =
                                                        `${String(rot_resultHours).padStart(2, '0')}:${String(rot_resultMinutes).padStart(2, '0')}`;
                                                    var rot_fixedHour = document.getElementById('rot_fixedWorkHour' + rotId);
                                                    document.getElementById('r_WorkHour' + rotId).value = `${String(rot_resultHours).padStart(2, '0')}`;
                                                    document.getElementById('r_WorkMin' + rotId).value = `${String(rot_resultMinutes).padStart(2, '0')}`;
                                                    rot_fixedHour.innerHTML =
                                                        `Total Work Hour: ${String(rot_resultHours).padStart(2, '0')} Hr ${String(rot_resultMinutes).padStart(2, '0')} Min`;
                                                    console.log(`Result: ${rot_formattedResult}`);
                                                }


                                                function removalElement(id) {
                                                    // alert(id);
                                                    // Get the element you want to remove by its ID
                                                    var elementToRemove = document.getElementById('newRotationalField' + id);
                                                    var alertMessageRotational = document.getElementById('alertMessageRotational');
                                                    // Check if the element exists before attempting to remove it
                                                    if (elementToRemove) {
                                                        if ($('.show_item_insert').length > 0) {
                                                            elementToRemove.remove();
                                                            // check.disabled = false;
                                                            alertMessageRotational.classList.add('d-none');
                                                        } else {
                                                            alertMessageRotational.classList.remove('d-none');

                                                            // check.disabled = true;
                                                            // alert("At least one item must remain.");
                                                            return false;
                                                        }
                                                        // Remove the element
                                                        // elementToRemove.remove();
                                                    } else {
                                                        console.log("Element with ID 'field' does not exist.");
                                                    }
                                                }

                                                // function rotationaPaid(index) {
                                                //     document.getElementById('unpaid'+index).checked = false;
                                                //     document.getElementById('paid'+index).checked = true;

                                                // }
                                                // function rotationaUnpaid(index) {
                                                //     document.getElementById('unpaid'+index).checked = true;
                                                //     document.getElementById('paid'+index).checked = false;
                                                // }
                                            </script>
                                        </div>
                                        <div>
                                            <span class="text-danger d-none" id="alertMessageRotational">You can't delete
                                                last row!</span>
                                        </div>

                                    </div>
                                    <!-- table-responsive -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Save</button>
                            </div>
                        </form>
                        <script>
                            function load(value) {
                                // alert(value);
                                if (value == '1') {
                                    //fixed
                                    // fixed
                                    var shiftNameId1 = document.getElementById('shiftNameId1');
                                    var start_time = document.getElementById('start_time');
                                    var end_time = document.getElementById('end_time');
                                    var break_time = document.getElementById('break_time');
                                    var shiftNameId2 = document.getElementById('shiftNameId2');
                                    shiftNameId1.setAttribute('required', true);
                                    start_time.setAttribute('required', true);
                                    end_time.setAttribute('required', true);
                                    break_time.setAttribute('required', true);

                                    $('#shiftname').removeClass('d-none');
                                    $('#shiftname2').addClass('d-none');
                                    $('#shifttime').removeClass('d-none');
                                    $('#unpaidbreaklabel').removeClass('d-none');
                                    $('#unpaidbreak').removeClass('d-none');
                                    $('#workhour').addClass('d-none');
                                    $('#additionaltbl').addClass('d-none');


                                } else if (value == '2') {
                                    // rotational
                                    var rotationalNameId = document.getElementById('rotationalNameId');
                                    var rotationalShiftNameClass = document.getElementsByClassName('rotationalShiftNameClass');
                                    var rotationalStartTimeClass = document.getElementsByClassName('rotationalStartTimeClass');
                                    var rotationalEndTimeClass = document.getElementsByClassName('rotationalEndTimeClass');
                                    var rotationalBreakMinClass = document.getElementsByClassName('rotationalBreakMinClass');
                                    rotationalNameId.setAttribute('required', true);
                                    for (var i = 0; i < rotationalShiftNameClass.length; i++) {
                                        rotationalShiftNameClass[i].setAttribute('required', 'true');
                                        rotationalStartTimeClass[i].setAttribute('required', 'true');
                                        rotationalEndTimeClass[i].setAttribute('required', 'true');
                                        rotationalBreakMinClass[i].setAttribute('required', 'true');
                                    }
                                    $('#shiftname').addClass('d-none');
                                    $('#shiftname2').removeClass('d-none');
                                    $('#shifttime').addClass('d-none');
                                    $('#unpaidbreaklabel').addClass('d-none');
                                    $('#unpaidbreak').addClass('d-none');
                                    $('#workhour').addClass('d-none');
                                    $('#additionaltbl').removeClass('d-none');
                                } else {
                                    // open
                                    var shiftNameId3 = document.getElementById('shiftNameId3');
                                    var hourId = document.getElementById('hourId');
                                    var minuteId = document.getElementById('minuteId');
                                    var breakMinuteOpenId = document.getElementById('breakMinuteOpenId');
                                    shiftNameId3.setAttribute('required', true);
                                    hourId.setAttribute('required', true);
                                    minuteId.setAttribute('required', true);
                                    breakMinuteOpenId.setAttribute('required', true);
                                    $('#shiftname2').addClass('d-none');
                                    $('#shiftname').removeClass('d-none');
                                    $('#shifttime').addClass('d-none');
                                    $('#unpaidbreaklabel').addClass('d-none');
                                    $('#unpaidbreak').addClass('d-none');
                                    $('#workhour').removeClass('d-none');
                                    $('#additionaltbl').addClass('d-none');
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <script>
             $("#btnOpen").on('click', function() {
                $('#shifttime').addClass('d-none');
                $('#workhour').addClass('d-none');
                $('#shiftname2').addClass('d-none');
                $('#additionalModal').modal('show');
            });
        </script>
    @endsection
@endif
