@extends('admin.pagelayout.master')
@section('title')
    Holiday Policy Settings
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
@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Holiday Policy</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        @php
            $centralUnit = new App\Helpers\Central_unit();
            $HolidayTemplate = $centralUnit->Template();
            $Holiday = $centralUnit->Holiday();
            $j = 0;
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Holiday Policy</div>
            <p class="text-muted m-0">Create template to give automatic paid leaves to staff on public holidays</p>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="button" class="btn btn-primary" id="add_holiday">Create Holiday</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Holiday Policy List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  tabel-border-bottom " id="file-datatable">
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
                        @foreach ($HolidayTemplate as $item)
                            <tr>
                                <td class="font-weight-semibold">{{ $j++ }}.</td>
                                <td class="font-weight-semibold">{{ $item->temp_name }}</td>
                                <td class="font-weight-semibold"><?php
                                $load = $centralUnit->GetPolicysCount($item->temp_id);
                                $ll = $load[0];
                                echo $ll;
                                ?>
                                </td>
                                <td>
                                    <a class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="openEditModel(this)" data-temp_id='<?= $item->temp_id ?>'
                                        data-temp_name='<?= $item->temp_name ?>' data-temp_from='<?= $item->temp_from ?>'
                                        data-temp_to='<?= $item->temp_to ?>' data-business_id='<?= $item->business_id ?>'
                                        data-bs-toggle="modal" data-bs-target="#showmodal">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>
                                    <a class="btn action-btns  btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="ItemDeleteModel(this)" data-id='<?= $item->temp_id ?>'
                                        data-temp_name='<?= $item->temp_name ?>' data-bs-toggle="modal"
                                        data-bs-target="#editDeleteModel"><i class="feather feather-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="modal fade" id="createTemplate">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size:18px;">New Holiday Policy
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>

                    <div class="card-header p-3 border-0">
                        <h4 class="card-title">Create New Holiday</h4>
                    </div>
                    {{-- <form action="{{ route('add.holiday') }}" method="post"> --}}
                    {{-- <form action="" method="post" id="form_holiday"> --}}
                    {{-- @csrf --}}
                    <div class="modal-body" style="height: 60vh; overflow:scroll" id="frmProduct">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <p class="form-label">Policy Name</p>
                                    <input type="text" class="form-control header-text" id="policyNameInsert"
                                        placeholder="Enter Policy Name" aria-label="text" tabindex="1" name="temp_name"
                                        required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <p class="form-label">From</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div>
                                        <input class="form-control" placeholder="YYYY-MM" type="month" id="temp_from"
                                            onchange="createHoliday(this)" name="temp_from" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <p class="form-label">To</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div>
                                        <input class="form-control " placeholder="YYYY-MM" type="month" id="temp_to"
                                            name="temp_to" readonly>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.getElementById('temp_from').addEventListener('input', function() {
                                    // Get the selected month and year from the "From" input
                                    var fromValue = this.value;
                                    console.log(typeof(this.value));
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
                                <p class="form-label">Date</p>
                                <input type="date" class="form-control" id="holidayDates" />

                            </div>
                            <div class="col-xl-4 mt-5  col-md-1 append-buttons">

                                <button type="button" id="" onclick="addSetData()" style="float:right"
                                    class="btn btn-outline-primary add_item_btn"><i class="fe fe-plus bold"></i>
                                </button>

                            </div>

                        </div>

                        <div class="row">
                            <div class="row p-0 m-0">
                                <div class="col-md-12 table-responsive-sm">
                                    <table width="100%" id="displayTable" class="table text-center border-bottom ">
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
                                    <span id="requiredCheckId" class="text-danger d-none">Note:- This field can't be
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
                                                console.log(result);

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
                        <button type="submit" class="btn btn-primary " data-bs-toggle="tooltip" data-bs-placement="top"
                            id="submitButtonHoliday" title="Save">Save</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="showmodal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Update Holiday
                            Policy
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <div class="card-header p-3 border-0">
                        <h4 class="card-title">Update Holiday</h4>
                    </div>
                    {{-- <form action="{{ route('update.holiday') }}" method="post"> --}}
                    @csrf
                    <input type="text" name="update_temp_id" id="updateId">
                    <div class="modal-body " style="height: 60vh; overflow:scroll">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <p class="form-label">Template Name</p>
                                    <input type="text" class="form-control header-text"
                                        placeholder="Enter Template Name" value="" aria-label="text"
                                        tabindex="1" name="update_temp_name" id="updateName" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <p class="form-label">From</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="month" class="form-control" placeholder="YYYY-MM" value=""
                                            onchange="updateHoliday(this)" name="update_temp_from" id="updateFrom">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <p class="form-label">To</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="month" class="form-control" name="update_temp_to" id="updateTo"
                                            readonly>
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
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <p class="form-label hidden-md">Date</p>
                                    <input type="date" class="form-control" id="update_holiday_date" />

                                </div>
                            </div>
                            <div class="col-xl-4 col-md-2 mt-5 col-md-1 append-buttons">
                                <button type="button" id="" onclick="updateAppend(this.id)"
                                    style="float:right" class="btn btn-outline-primary add_item_btn "><i
                                        class="fe fe-plus bold"></i>
                                </button>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="mt-3 border-0">
                                    <div class="row" style="align-items: center;">
                                        {{-- <div class="col-md-10 dynamic-field">
                                            <div class="row">
                                                <h4 class="card-title">Holiday</h4>
                                            </div>
                                            <div class="row" id="row">
                                                <div class="col-xl-4 pt-3">
                                                    <div class="form-group">
                                                        <label for="field" class="hidden-md">Holiday
                                                            Name*</label>
                                                        <input type="text" class="form-control"
                                                            id="update_holiday_name" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 pt-3">
                                                    <div class="form-group">
                                                        <label for="field" class="hidden-md">Date</label>
                                                        <input type="date" class="form-control"
                                                            id="update_holiday_date" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 pt-4 col-md-1 append-buttons">
                                            <button type="button" id="" onclick="updateAppend(this.id)"
                                                class="btn btn-outline-primary add_item_btn"><i
                                                    class="fe fe-plus bold"></i>
                                            </button>

                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-md-12 p-0 table-responsive-sm">
                                <table width="100%" id="displayTableUpdate" class="table text-center border-bottom ">
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
                                            console.log(result);

                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                        <button class="btn btn-primary" type="submit" name="" id="updateButton"
                            data-bs-target="">Update & Contionue</button>
                    </div>
                    {{-- </form> --}}

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editDeleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('delete.holidayTemp') }}" method="POST">
                    @csrf
                    <input type="text" id="holiday_policy_id" name="holiday_policy_id" hidden>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class="mt-5">Are you sure you want to delete <span id="assign_emp"></span>?</h4>
                    </div>
                    <div class="modal-footer">

                        <a class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger" id="">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $("#add_holiday").on('click', function() {
            // $('#form_holiday').trigger('reset');
            $('#show_item_insert').empty();
            $('#createTemplate').modal('show');
        });
        document.getElementById("close-btn").addEventListener("click", function() {
            document.getElementById("frmProduct").reset();
        });
        var loader = '';
        console.log(loader);

        function createHoliday(context) {
            console.log(context.value);
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
                    console.log(result);
                    // var loader = '';

                    $('#show_item_insert').empty(); // Clear existing items
                    $.each(result, function(index, item) {
                        appendEditFormItemInsert(item);
                    });

                    result.forEach(function(data) {

                        loader += `
                    <input type="text" name="holiday_name[]" value="${data.name}" required>
                    <input type="date" name="holiday_date[]" value="${data.dateIso}" required>
                    <input type="text" name="holiday_day[]" value="${data.day}" required>`;
                    });

                    $('.moreManpower').eq(0).html(loader);
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
            // var holidayId = item.holiday_id;

            var newItemHtml = `<tr class="border-bottom">
                <td>${holiday_name}</td>
                <td>${formattedDate}</td>
                <td>${day}</td>
                <td>

                    <button type="button"  onclick="deleteHoliday(this)" class="btn btn-sm btn-outline-danger " ><i class="feather feather-trash"></i></button>
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
            console.log(context.value);
            var fromValue = $(context).val();
            console.log(fromValue);
            var fromYear = parseInt(fromValue.split('-')[0]);
            var fromMonth = parseInt(fromValue.split('-')[1]);

            // Calculate the month and year after one year
            var toYear = fromMonth === 1 ? fromYear : fromYear + 1;
            var toMonth = fromMonth === 1 ? 12 : fromMonth - 1;

            // Format the "To" input value and set it
            var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;
            console.log(toValue);
            document.getElementById('updateTo').value = toValue;

        }

        var holidayData = [];

        function openEditModel(context) {
            console.log(context);
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
                        console.log("item", item);
                        appendEditFormItem(item);
                    });
                }
            });
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
                <td><button type="button" class="btn btn-sm btn-outline-danger remove_item_btn_edit" value="${holidayId}"><i class="feather feather-trash"></i></button>  
                </tr>`
            $('#show_item_edit').append(newItemHtml);
        }

        $('#submitButtonHoliday').click(function() {

            var updatedItems = [];
            var isValid = true; // Flag to track if all fields are valid
            $('#show_item_insert tr').each(function(index, row) {
                console.log("ja raha hai");
                var cells = $(row).find('td');
                console.log("cells ", cells[0]);
                var updatedItem = {
                    // Assuming you want to get values of the first three td elements
                    name: $(cells[0]).text(),
                    date: convertDateFormat($(cells[1]).text()),
                    day: $(cells[2]).text(),
                };
                updatedItems.push(updatedItem);
                console.log(updatedItems);
            });
            console.log("updateItems ", updatedItems);
            var temp_name = $('#policyNameInsert').val().trim();
            var temp_from = $('#temp_from').val().trim();
            var temp_to = $('#temp_to').val().trim();
            if (temp_name == null || temp_name == '' || temp_from == '' || temp_to == '') {
                if (temp_name.trim() === '') {
                    $('#policyNameInsert').addClass('required-input');
                    isValid = false;
                } else {
                    $('#policyNameInsert').removeClass('required-input');
                }
                if (temp_from.trim() === '') {
                    $('#temp_from').addClass('required-input');
                    isValid = false;
                } else {
                    $('#temp_from').removeClass('required-input');
                }

                if (temp_to.trim() === '') {
                    $('#temp_to').addClass('required-input');
                    isValid = false;
                } else {
                    $('#temp_to').removeClass('required-input');
                }

            } else if ((updatedItems.length == 0 && isValid == true)) {
                // Show an alert if any field is empty
                $('#requiredCheckId').removeClass('d-none');
                // Swal.fire({
                //     title: 'Empty Fields',
                //     text: 'Please fill in all fields for each item before submitting.',
                //     icon: 'error',
                // });
                return false; // Prevent form submission
            } else {
                console.log("submit me gaya");
                $.ajax({
                    url: "{{ url('/add/holiday') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        temp_name: $('#policyNameInsert').val(),
                        temp_from: $('#temp_from').val(),
                        temp_to: $('#temp_to').val(),
                        updated_items: updatedItems // Send the array of updated items to the server
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log("data", data);
                        if (data != false) {
                            Swal.fire({
                                timer: 2000,
                                timerProgressBar: true,
                                // title: 'Update Successful',
                                text: 'Your Policy has been Created Successfully.',
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
                                text: 'There was an error crate your data.',
                                icon: 'error',
                            });
                        }
                    }
                });
            }

        });

        function convertDateFormat(inputDate) {
            // Split the date into day, month, and year
            var parts = inputDate.split("/");

            // Create a new Date object using the parts and construct the new format
            var formattedDate = new Date(parts[2], parts[1] - 1, parts[0]).toISOString().split('T')[0];

            return formattedDate;
        }

        $('#updateButton').click(function() {
            console.log($('#updateFrom').val());
            // Gather the updated data from the edited items
            var updatedItems = [];
            var isValid = true; // Flag to track if all fields are valid
            $('#show_item_edit tr').each(function(index, row) {

                var cells = $(row).find('td');
                console.log("cells ", cells[0]);
                var updatedItem = {
                    // Assuming you want to get values of the first three td elements
                    name: $(cells[0]).text(),
                    date: convertDateFormat($(cells[1]).text()),
                    day: $(cells[2]).text(),
                };
                updatedItems.push(updatedItem);
                console.log(updatedItems);
            });

            var temp_name = $('#updateName').val();
            var temp_from = $('#updateFrom').val();
            var temp_to = $('#updateTo').val();
            if (temp_name == null || temp_name == '' || temp_from == '' || temp_to == '') {
                // document.getElementById("policyNameInsert").style.color = red;
                // document.getElementById("policyNameInsert").style.color = "#FF8040";
                console.log('ja rahaa hai');
                if (temp_name == '') {
                    var inputField = document.getElementById('updateName');
                    inputField.classList.add('required-input');
                }
                if (temp_from == '') {
                    var inputField = document.getElementById('updateFrom');
                    inputField.classList.add('required-input');
                }
                if (temp_to == '') {
                    var inputField = document.getElementById('updateTo');
                    inputField.classList.add('required-input');
                }

                // Check if the input field is empty and required
                // if (inputField.value.trim() === '' && inputField.hasAttribute('required')) {
                //     // If it's empty and required, add the class to change the border color
                // alert('Input field is required!');
                // } else {
                //     // If it's not empty or not required, remove the class
                //     inputField.classList.remove('required-input');
                //     // Proceed with form submission or other actions
                //     alert('Form submitted successfully!');
                //     // You can uncomment the line below to submit the form
                //     // document.getElementById('myForm').submit();
                // }
                // $('#policyNameInsert').addClass('fffff');
            } else if ((updatedItems.length == 0 && isValid == true)) {
                // console.log("updatedItems ", updatedItems);

                $('#requiredUpdateCheckId').removeClass('d-none');

                // if (!isValid) {
                //     // Show an alert if any field is empty
                //     Swal.fire({
                //         title: 'Empty Fields',
                //         text: 'Please fill in all fields for each item before updating.',
                //         icon: 'error',
                //     });
                //     return false; // Prevent form submission
                // }

                // if (updatedItems.length === 0) {
                //     console.log("updatedItems is empty");
                //     Swal.fire({
                //         title: 'Update Failed',
                //         timer: 3000,
                //         timerProgressBar: true,
                //         text: 'Holiday list is mandetory.',
                //         icon: 'error',
                //     })

            } else {
                console.log("updatedItems is not empty");
                $.ajax({
                    url: "{{ url('/update/holiday') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        updateId: $('#updateId').val(),
                        updateName: $('#updateName').val(),
                        updateFrom: $('#updateFrom').val(),
                        updateTo: $('#updateTo').val(),
                        updated_items: updatedItems // Send the array of updated items to the server
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        if (result.message != false) {
                            Swal.fire({
                                timer: 2000,
                                timerProgressBar: true,
                                // title: 'Update Successful',
                                text: 'Your Policy has been Updated Successfully.',
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
                                text: 'There was an error updating your data.',
                                icon: 'error',
                            });
                        }


                    }
                });
            }

        });


        $(document).on('click', '.remove_item_btn_edit', function(e) {
            console.log(e);
            // e.preventDefault();
            var data = []; // Declare an empty array
            var inputField = document.getElementById('show_item_edit');
            console.log("inputField ", inputField);
            var rowCount = inputField.getElementsByTagName('tr').length;
            console.log('Number of <tr> elements: ' + rowCount);
            if (rowCount == 1) {
                $('#requiredUpdateCheckId').removeClass('d-none');
                return false;
            }
            // Assuming this.value contains the data you want to store
            data.push(this.value);
            // var data= this.value;
            console.log(data);
            let row_item = $(this).parent().parent();
            console.log(row_item);
            $(row_item).remove();
        })



        function addSetData() {
            $('#requiredCheckId').addClass('d-none');

            var holidayName = document.getElementById('holidayNames').value;
            var holidayDate = document.getElementById('holidayDates').value;
            var dateObject = new Date(holidayDate);
            var formattedDate = dateObject.toLocaleDateString('en-GB');
            console.log(holidayName);
            // var holidaynotemptycheck = document.getElementById('rowEmpty');
            // holidaynotemptycheck.removeAttribute('required');
            if (holidayName && holidayDate) {
                var day = getDayName(holidayDate);
                addHoliday(holidayName, formattedDate, day);
                clearForm();
            } else {
                alert("All fields are required!");
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
            var table = document.getElementById("displayTable").getElementsByTagName('tbody')[0];
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = name;
            cell2.innerHTML = date;
            cell3.innerHTML = day;
            cell4.innerHTML =
                '<button type="button" onclick="deleteHoliday(this)" class="btn btn-sm btn-outline-danger " ><i class="feather feather-trash"></i></button>';

            row.classList.add('table-row-with-border');
            // Add the holiday data to the array
            holidayData.push({
                name: name,
                date: date,
                day: day
            });


            updateLoaderArray();
        }

        function deleteHoliday(button) {
            var inputField = document.getElementById('show_item_insert');
            console.log("inputField ", inputField);
            var rowCount = inputField.getElementsByTagName('tr').length;
            console.log('Number of <tr> elements: ' + rowCount);
            if (rowCount == 1) {
                $('#requiredCheckId').removeClass('d-none');

                return false;
            }
            var row = button.parentNode.parentNode;
            var rowIndex = row.rowIndex;
            row.parentNode.removeChild(row);
            holidayData.splice(rowIndex - 1, 1);
            updateLoaderArray();
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
        // document.getElementById('holidayDate').addEventListener('change', updateDayField);

        function updateLoaderArray() {
            // var loader = '';

            holidayData.forEach(function(data) {
                loader += `
                    <input type="text" name="holiday_name[]" value="${data.name}" required>
                    <input type="date" name="holiday_date[]" value="${data.date}" required>
                    <input type="text" name="holiday_day[]" value="${data.day}" required>
                `;
            });
            // console.log(loader);
            $('.moreManpower').eq(0).html(loader);
        }

        var holidayUpdateData = [];

        function updateAppend(id) {
            console.log("id ", id);
            var holidayNameUpdate = document.getElementById('update_holiday_name' + id).value;
            var holidayDateUpdate = document.getElementById('update_holiday_date' + id).value;

            var dateObject = new Date(holidayDateUpdate);
            var formattedDate = dateObject.toLocaleDateString('en-GB');
            // console.log(holidayDateUpdate);

            // alert(holidayNameUpdate);
            if (holidayNameUpdate && holidayDateUpdate) {
                var dayUpdate = getDayName(holidayDateUpdate);
                console.log('Zinda hai');
                clearUpdateForm(id);
                addHolidayUpdate(holidayNameUpdate, formattedDate, dayUpdate, id);
                console.log(id);

            } else {
                alert("All fields are required!");
            }
        }

        function clearUpdateForm(id) {
            document.getElementById('update_holiday_name').value = '';
            document.getElementById('update_holiday_date').value = '';
        }

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
                '<button type="button"  onclick="deleteHoliday(this)" class="btn btn-outline-danger " ><i class="feather feather-trash"></i></button>';

            row.classList.add('table-row-with-border');
            // Add the holiday data to the array
            holidayUpdateData.push({
                name: name,
                date: date,
                day: day
            });

            LoaderArray(id);
        }


        function LoaderArray(id) {
            var loaderUpdate = '';

            holidayUpdateData.forEach(function(data) {
                loaderUpdate += `
                    <input type="text" name="update_name[]" value="${data.name}">
                    <input type="date" name="update_date[]" value="${data.date}">
                    <input type="text" name="update_day[]" value="${data.day}">
                `;
            });

            $('.UpdatemoreManpower' + id).eq(0).html(loaderUpdate);
        }
    </script>
@endsection
