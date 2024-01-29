@extends('admin.setupLayout.master')
@section('title')
    Holiday Policy Setting
@endsection
@section('css')
    <style>
        .required-input {
            border: 1px solid red;
        }

        .table-row-with-border {
            border-bottom: 1px solid #e9ebfa;
            /* Adjust the border style as needed */
        }
    </style>
@endsection
@if (in_array('Holiday Settings.View', $permissions))
    @php
        $centralUnit = new App\Helpers\Central_unit();
        $HolidayTemplate = $centralUnit->Template();
        $Holiday = $centralUnit->Holiday();
        $j = 0;
    @endphp
    @section('content')
        {{-- breadcrumbs --}}

        {{-- breadcrumbs --}}

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h3 class="card-title">Holiday Policy List</h3>
                </div>
                <div class="d-flex btn-list">
                    @if (in_array('Holiday Settings.Create', $permissions))
                        <button type="button" class="btn btn-primary" id="add_holiday">Create Holiday</button>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  tabel-border-bottom " id="">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Holiday Policy Name</th>
                                <th class="border-bottom-0">Numbers of Holiday</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $j = 1;
                            @endphp
                            @if (!$HolidayTemplate->isEmpty())
                                @foreach ($HolidayTemplate as $item)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                                        <td class="font-weight-semibold">{{ $item->temp_name }}</td>
                                        <td class="font-weight-semibold"><?php
                                        $load = $centralUnit->GetPolicysCount($item->temp_id);
                                        $ll = $load[0];
                                        echo $ll;
                                        ?>
                                            <span>Days</span>
                                        </td>
                                        <td>
                                            @php
                                                $masterendgame = 0;
                                            @endphp
                                            @foreach ($masterEndAssignCheck as $checkmaster)
                                                @if ($checkmaster->holiday_policy_ids_list == $item->temp_id)
                                                    @php
                                                        $masterendgame = 1;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (in_array('Holiday Settings.Update', $permissions))
                                                <button class="btn action-btns  btn-primary btn-icon btn-sm"
                                                    href="javascript:void(0);" {{ $masterendgame == 1 ? 'disabled' : '' }}
                                                    onclick="openEditModel(this)" data-temp_id='<?= $item->temp_id ?>'
                                                    data-temp_name='<?= $item->temp_name ?>'
                                                    data-temp_from='<?= $item->temp_from ?>'
                                                    data-temp_to='<?= $item->temp_to ?>'
                                                    data-business_id='<?= $item->business_id ?>'>
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </button>
                                            @endif
                                            @if (in_array('Holiday Settings.View', $permissions))
                                                <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                    href="javascript:void(0);" onclick="openViewModel(this)"
                                                    data-temp_id='<?= $item->temp_id ?>'
                                                    data-temp_name='<?= $item->temp_name ?>'
                                                    data-temp_from='<?= $item->temp_from ?>'
                                                    data-temp_to='<?= $item->temp_to ?>'
                                                    data-business_id='<?= $item->business_id ?>'>
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Holiday Settings.Delete', $permissions))
                                                <a class="btn action-btns  btn-danger btn-icon btn-sm"
                                                    href="javascript:void(0);" onclick="ItemDeleteModel(this)"
                                                    data-id='<?= $item->temp_id ?>' data-temp_name='<?= $item->temp_name ?>'
                                                    data-bs-toggle="modal" data-bs-target="#editDeleteModel"><i
                                                        class="feather feather-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="modal fade" id="createTemplate" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-size:18px;">Holiday Policy</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>

                        <div class="card-header p-3 border-0">
                            <h4 class="card-title">Holiday Settings</h4>
                        </div>
                        <form action="{{ route('add.holiday') }}" method="post">
                            @csrf
                            <input type="hidden" name="hiddenHolidayCreate" id="hiddenHolidayCreate">

                            <div class="modal-body" style="height: 60vh; overflow:scroll" id="frmProduct">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label">Holiday Policy Name*</p>
                                            <input type="text" class="form-control header-text" id="policyNameInsert"
                                                placeholder="Enter Policy Name" aria-label="text" tabindex="1"
                                                name="temp_name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">From*</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control" placeholder="YYYY-MM" type="month"
                                                    id="temp_from" onchange="createHoliday(this)" name="temp_from"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">To*</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control " placeholder="YYYY-MM" type="month"
                                                    id="temp_to" name="temp_to" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('temp_from').addEventListener('input', function() {
                                            // Get the selected month and year from the "From" input
                                            var fromValue = this.value;
                                            var fromYear = parseInt(fromValue.split('-')[0]);
                                            var fromMonth = parseInt(fromValue.split('-')[1]);

                                            // Calculate the month and year after one year
                                            var toYear = fromMonth === 1 ? fromYear : fromYear + 1;
                                            var toMonth = fromMonth === 1 ? 12 : fromMonth - 1;

                                            // Format the "To" input value and set it
                                            var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;
                                            document.getElementById('temp_to').value = toValue;
                                        });
                                    </script>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label">Holiday Name*</p>
                                            <input type="text" class="form-control" id="holidayNames"
                                                placeholder="Enter Holiday Name" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">Date*</p>
                                        <input type="date" class="form-control" id="holidayDates" />

                                    </div>
                                    <div class="col-xl-4 py-5 pt-xl-5 col-md-12 append-buttons">

                                        <button type="button" id="" onclick="addSetData()" style="float:right"
                                            class="btn btn-sm btn-primary add_item_btn "><i class="fe fe-plus bold"></i>
                                        </button>

                                    </div>
                                    <small id="root_add_message" style="color: red;font-size:10px;"></small>

                                </div>

                                <div class="row">
                                    <div class="row p-0 m-0">
                                        <div class="col-md-12 table-responsive-sm">
                                            <table width="100%" id="displayTable"
                                                class="table text-center border-bottom ">
                                                <thead>
                                                    <tr>
                                                        <th>Holiday Name</th>
                                                        <th>Date</th>
                                                        <th>Day</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="show_item_insert">
                                                </tbody>
                                            </table>
                                            <span id="requiredCheckId" class="text-danger d-none">Note:- This field can't
                                                be
                                                empty.</span>
                                            <div hidden class="moreManpower row">

                                            </div>
                                        </div>
                                        <script>
                                            function deleteHolidayOnly(id, temp) {
                                                $.ajax({
                                                    url: "{{ url('/delete/holiday') }}",
                                                    type: "POST",
                                                    data: {
                                                        state: id,
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    dataType: 'json',
                                                    success: function(result) {
                                                        location.reload();
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-end">
                                <a class="btn btn-danger cancel" type="reset" id="close-btn"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary " data-bs-toggle="tooltip"
                                    data-bs-placement="top" id="submitButtonHoliday" title="Save">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit modal start --}}
        <div class="container">
            <!-- Button to Open the Modal -->
            <!-- The Modal -->
            <div class="modal fade" id="showmodal" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Holiday
                                Policy
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <div class="card-header p-3 border-0">
                            <h4 class="card-title">Holiday Settings</h4>
                        </div>
                        <form action="{{ route('update.holiday') }}" method="post">

                            @csrf
                            <div class="modal-body " style="height: 60vh; overflow:scroll">
                                <input type="text" name="update_temp_id" id="updateId" hidden>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label">Holiday Policy Name* </p>
                                            <input type="text" class="form-control header-text"
                                                placeholder="Enter Template Name" value="" aria-label="text"
                                                tabindex="1" name="update_temp_name" id="updateName" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">From*</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="month" class="form-control" placeholder="YYYY-MM"
                                                    value="" onchange="updateHoliday(this)" name="update_temp_from"
                                                    id="updateFrom" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">To*</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="month" class="form-control " name="update_temp_to"
                                                    id="updateTo" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label hidden-md">Holiday
                                                Name*</p>
                                            <input type="text" class="form-control" id="update_holiday_name" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="hiddenHolidayData" id="hiddenHolidayData">

                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label hidden-md">Date*</p>
                                            <input type="date" class="form-control" id="update_holiday_date" />

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-12 mt-5  append-buttons">
                                        <button type="button" id="" onclick="updateAppend(this.id)"
                                            style="float:right" class="btn btn-sm btn-primary add_item_btn "><i
                                                class="fe fe-plus bold"></i>
                                        </button>
                                    </div>
                                    <small id="root_edit_message" style="color: red;font-size:10px;"></small>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="mt-3 border-0">
                                            <div class="row" style="align-items: center;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-md-12 p-0 table-responsive-sm">
                                        <table width="100%" id="displayTableUpdate"
                                            class="table text-center border-bottom ">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th>Holiday Name</th>
                                                    <th>Date</th>
                                                    <th>Day</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="show_item_edit">
                                            </tbody>
                                        </table>
                                        <span id="requiredUpdateCheckId" class="d-none text-danger">Note:- This field
                                            can't be
                                            empty.</span>
                                        <div hidden class="UpdatemoreManpower row">
                                        </div>
                                    </div>
                                    <script>
                                        function deleteHolidayOnly(id, temp) {
                                            $.ajax({
                                                url: "{{ url('/delete/holiday') }}",
                                                type: "POST",
                                                data: {
                                                    state: id,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                dataType: 'json',
                                                success: function(result) {
                                                    location.reload();
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-end">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary" type="sumbit" data-bs-toggle="tooltip"
                                    id="updateButton" title="Save">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit modal end --}}

        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="d-flex">
                {{-- <a href="{{ url('setup/attendance-settings') }}" id="saveButton"  class="btn btn-primary">Save & Continue</a> --}}
            </div>
        </div>
        <script>
            // Function to gather table data and update the form before submission
            function prepareFormDataBeforeSubmit() {
                // Create an array to store holiday data
                var holidaysData = [];

                // Get the table body
                var tableBody = document.getElementById("show_item_edit");

                // Loop through rows in the table
                for (var i = 0; i < tableBody.rows.length; i++) {
                    var row = tableBody.rows[i];
                    var holidayName = row.cells[0].innerText;
                    var date = row.cells[1].innerText;
                    var day = row.cells[2].innerText;

                    // Add holiday data to the array
                    holidaysData.push({
                        name: holidayName,
                        date: date,
                        day: day
                    });
                }
                // Update the hidden input field with the JSON string of holiday data
                document.getElementById("hiddenHolidayData").value = JSON.stringify(holidaysData);
            }
            // Your existing function to delete a holiday
            function deleteHolidayOnly(id, temp) {
                // Your existing AJAX code to delete a holiday
            }
            // Add an event listener to the "Update" button to call the preparation function before form submission
            document.getElementById("updateButton").addEventListener("click", function() {
                prepareFormDataBeforeSubmit();
            });
        </script>

        {{-- view modal start --}}
        <div class="container">
            <!-- Button to Open the Modal -->
            <!-- The Modal -->
            <div class="modal fade" id="viewshowmodal" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">View Holiday
                                Policy
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <div class="card-header p-3 border-0">
                            <h4 class="card-title">Holiday Settings</h4>
                        </div>
                        <div class="modal-body " style="height: 60vh; overflow:scroll">
                            <input type="text" name="update_temp_id" id="updateIdView" hidden>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <p class="form-label">Holiday Policy Name*</p>
                                        <input type="text" class="form-control header-text"
                                            placeholder="Enter Template Name" value="" aria-label="text"
                                            tabindex="1" name="update_temp_name" id="updateNameView" required readonly>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <p class="form-label">From*</p>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="month" class="form-control text-muted" placeholder="YYYY-MM"
                                                value="" onchange="updateHoliday(this)" name="update_temp_from"
                                                id="updateFromView" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <p class="form-label">To*</p>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="month" class="form-control text-muted" name="update_temp_to"
                                                id="updateToView" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="mt-3 border-0">
                                        <div class="row" style="align-items: center;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-0 m-0">
                                <div class="col-md-12 p-0 table-responsive-sm">
                                    <table width="100%" id="displayTableUpdate"
                                        class="table text-center border-bottom ">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th>Holiday Name</th>
                                                <th>Date</th>
                                                <th>Day</th>

                                            </tr>
                                        </thead>
                                        <tbody id="show_item_edit_view">
                                        </tbody>
                                    </table>
                                    <span id="requiredUpdateCheckId" class="d-none text-danger">Note:- This field can't be
                                        empty.</span>
                                    <div hidden class="UpdatemoreManpower row">
                                    </div>
                                </div>
                                <script>
                                    function deleteHolidayOnly(id, temp) {
                                        $.ajax({
                                            url: "{{ url('/delete/holiday') }}",
                                            type: "POST",
                                            data: {
                                                state: id,
                                                _token: '{{ csrf_token() }}'
                                            },
                                            dataType: 'json',
                                            success: function(result) {
                                                location.reload();
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- view modal end --}}
        {{-- delete modale start --}}
        <div class="modal fade" id="editDeleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('delete.holidayTemp') }}" method="POST">
                        @csrf
                        <input type="text" id="holiday_policy_id" name="holiday_policy_id" hidden>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <h4 class="mt-5">Are you sure you want to delete <span id="assign_emp"></span>?</h4>
                        </div>
                        <div class="modal-footer">

                            <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-danger" id="">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- delete modale end --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            function prepareFormDataBeforeSubmitHoliday() {
                // Create an array to store holiday data
                var holidaysData = [];

                // Get the table body
                var tableBody = document.getElementById("show_item_insert");

                // Loop through rows in the table
                for (var i = 0; i < tableBody.rows.length; i++) {
                    var row = tableBody.rows[i];
                    var holidayName = row.cells[0].innerText;
                    var date = row.cells[1].innerText;
                    var day = row.cells[2].innerText;

                    // Add holiday data to the array
                    holidaysData.push({
                        name: holidayName,
                        date: date,
                        day: day
                    });
                }
                // Update the hidden input field with the JSON string of holiday data
                document.getElementById("hiddenHolidayCreate").value = JSON.stringify(holidaysData);
            }
            document.getElementById("submitButtonHoliday").addEventListener("click", function() {
                prepareFormDataBeforeSubmitHoliday();
            });
        </script>

        <script>
            $("#add_holiday").on('click', function() {
                $('#form_holiday').trigger('reset');
                $('#show_item_insert').empty();
                $('#createTemplate').modal('show');
            });
            document.getElementById("close-btn").addEventListener("click", function() {
                document.getElementById("frmProduct").reset();
            });
            var loader = '';

            function createHoliday(context) {
                var id = context.value;
                $.ajax({
                    url: "{{ url('/setup/business-settings/get_holiday_api') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        selectDate: id

                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#show_item_insert').empty(); // Clear existing items
                        $.each(result, function(index, item) {
                            appendEditFormItemInsert(item);
                        });
                    }
                });
            }

            function appendEditFormItemInsert(item) {
                var holiday_name = item.name;
                var holiday_date = item.dateIso;
                var dateObject = new Date(holiday_date);
                var formattedDate = dateObject.toLocaleDateString('en-GB');
                var day = item.day;
                var sno = item.sno;

                var newItemHtml = `<tr class="border-bottom">
                <td>${holiday_name}</td>
                <td>${formattedDate}</td>
                <td>${day}</td>
                <td>
                    <button type="button"  onclick="deleteHoliday(this)" class="btn btn-sm btn-danger " ><i class="feather feather-trash"></i></button>
                </tr>`
                $('#show_item_insert').append(newItemHtml);
            }

            function ItemDeleteModel(context) {

                var id = $(context).data('id');
                var name = $(context).data('temp_name')
                $('#holiday_policy_id').val(id);
                $('#assign_emp').text(name);
            }

            function updateHoliday(context) {
                var fromValue = $(context).val();
                var fromYear = parseInt(fromValue.split('-')[0]);
                var fromMonth = parseInt(fromValue.split('-')[1]);

                // Calculate the month and year after one year
                var toYear = fromMonth === 1 ? fromYear : fromYear + 1;
                var toMonth = fromMonth === 1 ? 12 : fromMonth - 1;

                // Format the "To" input value and set it
                var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;
                document.getElementById('updateTo').value = toValue;

            }

            var holidayData = [];

            function openEditModel(context) {
                var id = $(context).data('temp_id');
                var temp_name = $(context).data('temp_name');
                var temp_from = $(context).data('temp_from');
                var temp_to = $(context).data('temp_to');
                var business_id = $(context).data('business_id');
                $('#showmodal').modal('show');
                $('#updateId').val(id);
                var fromYear = parseInt(temp_from.split('-')[0]);
                var fromMonth = parseInt(temp_from.split('-')[1]);
                var fromValue = fromYear + '-' + (fromMonth < 10 ? '0' : '') + fromMonth;

                var toYear = parseInt(temp_to.split('-')[0]);
                var toMonth = parseInt(temp_to.split('-')[1]);
                // // Calculate the month and year after one year
                var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;


                // // Format the "To" input value and set it
                $('#updateName').val(temp_name);
                $('#updateFrom').val(fromValue);
                $('#updateTo').val(toValue);
                $.ajax({
                    url: "{{ url('/admin/settings/business/all_holiday_policy') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        leave_policy_id: {
                            id
                        }
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#show_item_edit').empty(); // Clear existing items
                        $.each(result.get, function(index, item) {
                            appendEditFormItem(item);
                        });
                    }
                });
            }

            function openViewModel(context) {
                var id = $(context).data('temp_id');
                var temp_name = $(context).data('temp_name');
                var temp_from = $(context).data('temp_from');
                var temp_to = $(context).data('temp_to');
                var business_id = $(context).data('business_id');
                $('#viewshowmodal').modal('show');
                $('#updateIdView').val(id);
                var fromYear = parseInt(temp_from.split('-')[0]);
                var fromMonth = parseInt(temp_from.split('-')[1]);
                var fromValue = fromYear + '-' + (fromMonth < 10 ? '0' : '') + fromMonth;

                var toYear = parseInt(temp_to.split('-')[0]);
                var toMonth = parseInt(temp_to.split('-')[1]);
                // // Calculate the month and year after one year
                var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;


                // // Format the "To" input value and set it
                $('#updateNameView').val(temp_name);
                $('#updateFromView').val(fromValue);
                $('#updateToView').val(toValue);
                $.ajax({
                    url: "{{ url('/admin/settings/business/all_holiday_policy') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        leave_policy_id: {
                            id
                        }
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#show_item_edit_view').empty(); // Clear existing items
                        $.each(result.get, function(index, item) {
                            appendViewFormItem(item);
                        });
                    }
                });
            }

            function appendViewFormItem(item) {
                var holiday_name = item.holiday_name;
                var holiday_date = item.holiday_date;
                var dateObject = new Date(holiday_date);
                var formattedDate =
                    ('0' + dateObject.getDate()).slice(-2) + '/' +
                    ('0' + (dateObject.getMonth() + 1)).slice(-2) + '/' +
                    dateObject.getFullYear();
                var day = item.day;
                var holidayId = item.holiday_id;

                var newItemHtml = `<tr class="border-bottom">
                <td>${holiday_name}</td>
                <td>${formattedDate}</td>
                <td>${day}</td>
                </tr>`
                $('#show_item_edit_view').append(newItemHtml);
            }

            function appendEditFormItem(item) {
                var holiday_name = item.holiday_name;
                var holiday_date = item.holiday_date;
                var dateObject = new Date(holiday_date);
                var formattedDate = dateObject.toLocaleDateString('en-GB');
                var day = item.day;
                var holidayId = item.holiday_id;

                var newItemHtml = `<tr class="border-bottom">
                <td>${holiday_name}</td>
                <td>${formattedDate}</td>
                <td>${day}</td>
                 <td><button type="button" class="btn btn-sm btn-danger remove_item_btn_edit" value="${holidayId}"><i class="feather feather-trash"></i></button>
                </tr>`
                $('#show_item_edit').append(newItemHtml);
            }

            // Function to convert date format from DD/MM/YYYY to YYYY-MM-DD
            function convertDateFormat(originalDate) {
                var parts = originalDate.split('/');
                if (parts.length === 3) {
                    return parts[2] + '-' + parts[1] + '-' + parts[0];
                } else {
                    return originalDate; // Return the original date if the format is not as expected
                }
            }

            $(document).on('click', '.remove_item_btn_edit', function(e) {
                // e.preventDefault();
                var data = []; // Declare an empty array
                var inputField = document.getElementById('show_item_edit');
                var rowCount = inputField.getElementsByTagName('tr').length;
                if (rowCount == 1) {
                    $('#requiredUpdateCheckId').removeClass('d-none');
                    return false;
                }
                // Assuming this.value contains the data you want to store
                data.push(this.value);
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            })

            function addSetData() {
                $('#requiredCheckId').addClass('d-none');
                var holidayName = document.getElementById('holidayNames').value;
                var holidayDate = document.getElementById('holidayDates').value;
                if (holidayName && holidayDate) {
                    // Format the date to "YYYY-MM-DD"
                    var dateObject = new Date(holidayDate);
                    var formattedDate =
                    ('0' + dateObject.getDate()).slice(-2) + '/' +
                    ('0' + (dateObject.getMonth() + 1)).slice(-2) + '/' +
                    dateObject.getFullYear();
                    var day = getDayName(holidayDate);
                    document.getElementById('root_add_message').innerHTML = '';
                    addHoliday(holidayName, formattedDate, day);
                    clearForm();
                } else {
                    document.getElementById('root_add_message').innerHTML =
                        '**Please fill the previous row value before adding a new row.';
                }
            }


            function clearForm() {
                document.getElementById('holidayNames').value = '';
                document.getElementById('holidayDates').value = '';
            }

            function getDayName(dateString) {
                // Create a Date object from the input string
                var date = new Date(dateString);

                // Get the day name
                var options = {
                    weekday: 'long'
                };
                var dayName = date.toLocaleDateString(undefined, options);
                return dayName;
            }

            function addHoliday(name, date, day) {
                var holiday_name = name;
                var holiday_date = date;
                var day = day;
                var newItemHtml = `<tr class="border-bottom">
                <td>${holiday_name}</td>
                <td>${date}</td>
                <td>${day}</td>
                <td>
                    <button type="button"  onclick="deleteHoliday(this)" class="btn btn-sm btn-danger " ><i class="feather feather-trash"></i></button>
                </tr>`
                $('#show_item_insert').append(newItemHtml);
            }

            function deleteHoliday(button) {
                var inputField = document.getElementById('show_item_insert');
                var rowCount = inputField.getElementsByTagName('tr').length;
                if (rowCount == 1) {
                    $('#requiredCheckId').removeClass('d-none');

                    return false;
                }
                var row = button.parentNode.parentNode;
                var rowIndex = row.rowIndex;
                row.parentNode.removeChild(row);
                holidayData.splice(rowIndex - 1, 1);
            }

            function updateDayField() {
                var selectedDate = document.getElementById('holidayDate').value;
                if (selectedDate) {
                    var dateObject = new Date(selectedDate);
                    var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    var dayOfWeek = daysOfWeek[dateObject.getDay()];
                    document.getElementById('autoDay').value = dayOfWeek;
                }
            }

            // Add event listener to update the "Day" field when the date is changed
            document.getElementById('holidayDate').addEventListener('change', updateDayField);

            function updateAppend(id) {
                var holidayNameUpdate = document.getElementById('update_holiday_name' + id).value;
                var holidayDateUpdate = document.getElementById('update_holiday_date' + id).value;
                var dateObject = new Date(holidayDateUpdate);
                var formattedDate =
                    ('0' + dateObject.getDate()).slice(-2) + '/' +
                    ('0' + (dateObject.getMonth() + 1)).slice(-2) + '/' +
                    dateObject.getFullYear();
                // var formattedDate = dateObject.toLocaleDateString('en-GB');
                if (holidayNameUpdate && holidayDateUpdate) {
                    var dayUpdate = getDayName(holidayDateUpdate);
                    clearUpdateForm(id);
                    addHolidayUpdate(holidayNameUpdate, formattedDate, dayUpdate, id);
                    document.getElementById('root_edit_message').innerHTML = '';
                } else {
                    document.getElementById('root_edit_message').innerHTML =
                        '**Please fill the previous row value before adding a new row.';
                }
            }

            function clearUpdateForm(id) {
                document.getElementById('update_holiday_name').value = '';
                document.getElementById('update_holiday_date').value = '';
            }

            var holidayUpdateData = [];

            function addHolidayUpdate(name, date, day, id) {
                var table = document.getElementById("displayTableUpdate" + id).getElementsByTagName('tbody')[0];
                var row = table.insertRow(table.rows.length);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = name;
                cell2.innerHTML = date;
                cell3.innerHTML = day;
                cell4.innerHTML =
                    '<button type="button"  onclick="deleteHoliday(this)" class="btn btn-danger " ><i class="feather feather-trash"></i></button>';
                row.classList.add('table-row-with-border');
            }
        </script>
    @endsection
@endif
