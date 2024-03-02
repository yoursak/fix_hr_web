{{-- <?php dd($grade_list); ?> --}}
@extends('admin.pagelayout.master2')
@section('title')
    Business | Leave Policy
@endsection
@section('css')
@endsection
@section('content')
    {{-- @php
        $Central = new App\Helpers\Central_unit();
        $Employee = $Central::EmployeeDetails();
        $Department = $Central->DepartmentList();
        $Designation = $Central::DesignationList();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
    @endphp --}}
    {{-- breadcrumbs set start --}}
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/settings/tada') }}">TADA</a></li>
            <li class="active"><span><b>Toll Expense</b></span></li>
        </ol>
    </div>
    {{-- breadcrumbs set end --}}
    {{-- page header start --}}
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Toll Expense</div>
            <p class="text-muted m-0">Create a Template for Toll Expense </p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="button" class="btn btn btn-primary " id="create_template_btn">
                            Create Toll Expense
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- page header end --}}
    {{-- pagebody start --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Toll Expense List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Grade</th>
                            <th class="border-bottom-0">Travel Type</th>
                            <th class="border-bottom-0">Vehicle Type</th>
                            <th class="border-bottom-0">Toll Charges</th>
                            <th class="un" hidden>toll_add_charg</th>
                            <th class="border-bottom-0">Parking Charges</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataview as $key => $items)
                        <tr>

                            <td class="font-weight-semibold" id="key">{{ ++$key }}</td>
                            {{-- @dd($items->grade_name); --}}
                            <td class="font-weight-semibold" dataedit="{{ $items->toll_id }}"
                                data="{{ $items->grade_id }}" id="grade_id">
                                {{ $items->grade_list->grade_name ?? '' }}
                            </td>
                           <td class="font-weight-semibold"  id="items->travel_type">{{$items->travel_type}}</td>
                           {{-- @dd($items->ta_da_travel_mode->travel_type); --}}
                           <td class="font-weight-semibold" id="items->Vehicle_type">{{ $items->ta_da_travel_mode->travel_type ?? ''}}</td>
                           <td class="font-weight-semibold" style="display:none">{{$items->toll_charge}}</td>
                        <td class="font-weight-semibold" id="toll_add_charge">{{ $items->toll_add_charge }}</td>
                           <td class="font-weight-semibold" id="parking_charge">{{$items->parking_charge}}</td>
                            <td>
                                <div class="d-flex">
                                    <div id="actionBtn" class="">
                                        <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#showmodal"
                                            {{-- onclick="openTollEditBtn(this)" data-id='<?= $items->id ?>' --}}
                                            data-grade_name='<?= $items->grade_name ?>' data-bs-toggle="modal"
                                            href="#"
                                            onclick="openTollEditBtn(this)"
                                            data-id='{{ $items->toll_id ?? '' }}'
                                            data-grade_name='{{  $items->grade_list->grade_name  ?? ''}}',
                                            data-Vehicle_type='{{ $items->Vehicle_type ?? ''}}',
                                            data-travel_type='{{ $items->travel_type ?? ''}}',
                                            data-toll_add_charge='{{ $items->toll_add_charge ?? ''}}',
                                            data-parking_charge='{{ $items->parking_charge ?? ''}}',
                                            data-bs-toggle="modal" data
                                           >
                                            <i class='feather feather-edit'></i></a>

                                        <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-grade_name='{{ $items->grade_list->grade_name ?? '' }}'
                                            onclick="openDeleteBtn(this)"
                                            data-id='{{ $items->toll_id ?? '' }}'
                                            data-vehicle_type='{{ $items->Vehicle_type ?? '' }}'
                                            data-travel_type='{{ $items->travel_type ?? ''}}'
                                            data-toll_add_charge='{{ $items->toll_add_charge ?? '' }}'
                                            data-parking_charge='{{ $items->parking_charge ?? '' }}'
                                            data-bs-target="#deleteModal"
                                            id="deleteBtn{{ $items->toll_id ?? ''}}">
                                            <i class="feather feather-trash"></i>
                                        </a>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- leave policy create modal start --}}
    <div class="container">
        <div class="modal fade" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Toll Expenses</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('admin/settings/tada/tollcharge') }}" method="POST" id="form_leave">
                        <div class="modal-body" style="height: auto; overflow:scroll">
                            @csrf
                                <div class="pt-5 row  d-flex">
                                    <div class="col">
                                        <h4 class="card-title"><span>Toll Expenses </span></h4>
                                    </div>
                                    <div>
                                        <span id="show_item" ></span>
                                        <span class="add_item_btn" ><span>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row mx-2">
                            {{-- <span class="text-danger fs-12">Note: You must activate
                                your Comp Off and LWP policies from the business settings;
                                otherwise, Comp Off and LWP will not be allocated along with the leave policy.</span> --}}
                        </div>
                        <div>
                            &nbsp;
                        </div>

                        <div class="modal-footer d-flex justify-content-end">
                            <div class="text-center">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary" name="" id="submit" type="submit"
                                    data-bs-target="">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- leave policy create modal end --}}
    {{--   Edit --}}
    <div class="container">
        <div class="modal fade" id="showmodal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Toll Tax Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/admin/settings/tada/update_tollvalues') }}" method="POST"
                        id="form_leave_edit">
                        @csrf
                        <input type="text" name="tolvalue" id="rolesId" hidden>

                        <div class="modal-body" style="height: auto; overflow: scroll">
                            <div class="container-fluid">
                                <!-- Your dynamic content here -->
                                <span id="showedit"></span>
                            </div>
                        </div>
                            {{-- <div class="row">
                                <label for="inputPassword" class="col-sm-2 col-xl-2 col-form-label">Policy Name</label>
                                <div class="col-xl-10">
                                    <input type="text" class="form-control " name="edit_policys" id="edit_policy"
                                        placeholder="Enter Leave Policy Template Name" required>
                                </div>
                            </div> --}}
                            {{-- <div class="pt-2 row">
                                <label for="editFrom" class="col-xl-2 col-form-label">Leave Period</label>
                                <div class="col-xl-2">
                                    <input type="month" class="form-control " id="leave_periodfrom2"
                                        aria-disabled="true" disabled>
                                </div>
                                <label class="col-xl-1 col-form-label text-xl-center" for="">To</label>
                                <div class="col-xl-2">
                                    <input type="month" class="form-control " id="leave_periodto2"
                                        aria-disabled="true" disabled>
                                </div>

                            </div> --}}
                            {{-- <div class="pt-2 row">
                                <label for="inputPassword" class="col-xl-2 col-form-label">Sandwich Leaves <small
                                        class="badge badge-info-light" data-bs-trigger="hover"
                                        style="background-color:transparent;" data-bs-container="body"
                                        data-bs-content="When a holiday falls between two availed leaves, they are merged together and considered as sandwich leaves."
                                        data-bs-placement="right" data-bs-popover-color="primary"
                                        data-bs-toggle="popover" data-bs-html=true title="Sandwich Leaves"><i
                                            class="fa fa-info-circle"></i></small>
                                </label> --}}
                                {{-- <div class="col-sm-5">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" value="1" name="btnradioedit"
                                            id="btnradiomonthsedit" disabled>
                                        <label class="btn btn-outline-primary px-4" for="btnradiomonthsedit">Count</label>
                                        <input type="radio" class="btn-check" value="2" name="btnradioedit"
                                            id="btnradioyearsedit" disabled>
                                        <label class="btn btn-outline-primary px-4" for="btnradioyearsedit"
                                            style="width: 5.8rem">Ignore&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                </div> --}}
                            {{--  wire: --}}
                            {{-- <div class="row">
                                <input type="text" name="role" id="rolesId" hidden>
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Setting</span></h4>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                    <div class="col">
                                        <input type="text" class="form-control bg-muted form-label"
                                            name="edit_policys" id="edit_policy"
                                            placeholder="Enter Leave Policy Template Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                    <div class="form-row col-xl-5">
                                        <input type="month" class="form-control col-xl-4" id="leave_periodfrom2"
                                            aria-disabled="true" disabled>
                                        <label class="col-xl-1 col-form-label" for="">To</label>
                                        <input type="month" class="form-control col-xl-4 " id="leave_periodto2"
                                            aria-disabled="true" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Sandwich Leaves <small
                                            class="badge badge-info-light" data-bs-trigger="hover"
                                            style="background-color:transparent;" data-bs-container="body"
                                            data-bs-content="When a holiday falls between two availed leaves, they are merged together and considered as sandwich leaves."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Sandwich Leaves"><i
                                                class="fa fa-info-circle"></i></small></label>
                                    <div class="col-sm-5">
                                        <div class="btn-group" role="group"
                                            aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" value="1" name="btnradioedit"
                                                id="btnradiomonthsedit">
                                            <label class="btn btn-outline-primary" for="btnradiomonthsedit">Count</label>
                                            <input type="radio" class="btn-check" value="2" name="btnradioedit"
                                                id="btnradioyearsedit">
                                            <label class="btn btn-outline-primary" for="btnradioyearsedit">Ignore</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-5 row d-flex ">
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Category </span></h4>
                                </div>
                                <div class="col text-end">
                                    <button type="button" class="btn btn-sm btn-primary add_item_btn_edit"><i
                                            class="fe fe-plus bold"></i>
                                    </button>
                                </div>
                            </div>
                            <span id="show_item_edit">
                            </span> --}}
                        {{-- </div> --}}
                        <div id="editmodalfooter" class="modal-footer d-flex justify-content-end d-none">
                            <div class="text-center">
                                <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary" name="" id="updateButton"
                                    data-bs-target="">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Edit --}}

    <div class="container">
        <div class="modal fade" id="viewshowmodal">
            <div class="modal-dialog modal-dialog-centered modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">View Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    {{-- <form action="{{ url('/admin/settings/business/update_leave_policy') }}" method="POST"
                        id="form_leave_edit"> --}}
                    @csrf
                    <input type="text" name="role" id="rolesIdview" hidden>

                    <div class="modal-body" style="height: auto; overflow:scroll">
                        <div class="row">
                            <h4>Leave Settings</h4>
                        </div>

                        <span id="show_item_edit_view">
                        </span>
                    </div>
                    <div id="editmodalfooter" class="modal-footer d-flex justify-content-end d-none">
                        <div class="text-center">
                            <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- leave policy edit modal end --}}

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ url('admin/settings/tada/delete/tollamount') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    </div>
                    <input type="hidden" name="deleteId" id="deleteId" value="">
                    <div class="modal-body text-center">
                        <h4 class="mt-5">Are you sure you want to delete <span id="assign_emp"></span> ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $('#form_leave').on('submit', function(event) {
            // console.log(event);
            $('#myModal').modal('hide');
            $('#submit').prop('disabled', true);
            // event.preventDefault();

        });
        // delete modal function
        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var assign = $(context).data('policy_name');
            $('#poli_id').val(id);
            $('#assign_emp').text(assign);
        }
    </script>
    {{-- new create Section start --}}
    <script>
        // create tmplate btn click modal show
        $("#create_template_btn").on('click', function() {
            $('#form_leave').trigger('reset');
            $('#show_item').empty();
            $('#myModal').modal('show');
            $(".add_item_btn").click();
        });


        function updateSubmitButton() {
            var myButton = document.getElementById('submit');
            myButton.disabled = Object.values(validationStatus).some(status => !status);
        }

        function addOption(select, value, text) {
            var option = document.createElement('option');
            option.value = value;
            option.text = text;
            select.add(option);
        }
        var dd = [];


        var leave_id = 1;


// mahato

    </script>
    {{-- new create Section end --}}

    {{-- Edit Section start --}}
    <script>
        // Call the function on document ready to set initial values


        $('#updateButton').click(function() {
            // Gather the updated data from the edited items
            var updatedItems = [];
            var isValid = true; // Flag to track if all fields are valid
            var isCheck = true;
            $('#show_item_edit .row').each(function(index) {
                var categoryName = $(this).find('select[name="category_name_edit[]"]').val();
                var leavCycleMy = $(this).find('select[name="leave_cycle_my_edit[]"]').val();
                var days = $(this).find('input[name="days_edit[]"]').val();
                var unusedLeaveRule = $(this).find('select[name="unused_leave_rule_edit[]"]').val();

                // Ensure a consistent type for carryForwardLimit
                var carryForwardLimit = (unusedLeaveRule == 1) ? '0' : $(this).find(
                    'input[name="carry_forward_limit_edit[]"]').val();
                var applicableTo = $(this).find('select[name="applicable_to_edit[]"]').val();

                if (!$('#edit_policy').val() || !leavCycleMy || !categoryName || !days || !
                    unusedLeaveRule || !carryForwardLimit || !applicableTo) {
                    isValid = true; // Set the flag to false if any field is empty
                    isCheck = true;
                    return false; // Exit the loop
                } else {
                    isCheck = false;
                }

                // Create an object to represent the updated item
                var updatedItem = {
                    category_name: categoryName,
                    leav_Cycle_My: leavCycleMy,
                    days: days,
                    unused_leave_rule: unusedLeaveRule,
                    carry_forward_limit: carryForwardLimit,
                    applicable_to: applicableTo,
                };
                updatedItems.push(updatedItem);
            });

            var selectedCategories = [];

            // Check for duplicate categories
            $('#show_item_edit select[name="category_name_edit[]"]').each(function() {
                var categoryName = $(this).val()
                    .toLowerCase(); // Convert to lowercase for case-insensitive check

                if (selectedCategories.includes(categoryName)) {
                    isValid = false;
                    //    return false;
                    // Display an error message for duplicate category
                    $('#category_name_err_edit' + $(this).data('id')).removeClass('d-none');
                } else {
                    // Hide the duplicate category error
                    $('#category_name_err_edit' + $(this).data('id')).addClass('d-none');
                }

                // Add the category to the array
                selectedCategories.push(categoryName);
            });

            // if(!isValidto){
            //     isValid = false;
            // }


            if (!isValid) {
                // Show an alert if any field is empty or there are duplicate categories
                // Swal.fire({
                //     title: 'Invalid Fields',
                //     text: 'Please fill in all fields and select unique categories for each item before updating.',
                //     icon: 'error',
                // });
                return false; // Prevent form submission
            } else {
                // return true;

                if (isCheck == true) {
                    return true;
                } else {

                    $('#showmodal').modal('hide');
                    // Prevent the default form submission
                    return true;
                }


            }

            // Send the updated data to the server via AJAX
            $.ajax({
                url: "{{ url('/admin/settings/business/update_leave_policy') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    leave_policy_id: $('#rolesId').val(),
                    leave_name: $('#edit_policy').val(),
                    updated_items: updatedItems // Send the array of updated items to the server
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            timer: 2000,
                            timerProgressBar: true,
                            title: 'Update Successful',
                            text: 'Your data has been updated successfully.',
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
        });

        $(document).ready(function() {
            $(".add_item_btn_edit").click(function(e) {
                if (!validatePreviousRowEdit()) {
                    console.log("chal be");
                    // Show an alert or take any other action for empty values
                    // Swal.fire({
                    //     title: 'Previous row values are empty',
                    //     text: 'Please fill in the previous row values before adding a new row.',
                    //     icon: 'error',
                    // });
                    // return;
                }
                let categoryname_edit = $('#categoryname_edit').val();
                let days_edit = $('#days_edit').val();
                let leaverule_edit = $('#leaverule_edit').val();
                let cfl_edit = $('#cfl_edit').val();
                let applicable_edit = $('#applicable_edit').val();
                var myButton = document.getElementById('updateButton');
                myButton.disabled = false;
                $("#show_item_edit").append(
                    `<div class="row rowrowedit">
                        <div class="card-body col-xl-2 pt-3 pb-0" name="leave_id" id="" >
                            <label for="leave_category_edit" class="form-label">Category Name <small style="background-color:transparent;"  id="descirpitonEdit${leave_id}" class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                            data-bs-container="body"
                                            data-bs-content=""
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title=""><i style="background-color:none;"
                                                class="fa fa-info-circle" ></i></small></label>
                            <select  name="category_name_edit[]" id="leave_category_edit${leave_id}" onchange="LeaveCategoryCheckEdit1(this)" data-id="${leave_id}" value="" class="form-control" id="inputCity" placeholder="Category Name" required><option value="" disabled selected>Select Leave Cycle</option>
                             {{--   @foreach ($leaveType as $item)
                                    <option data-name="{{ $item->name }}" data-description="{{ $item->description }}" value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach--}}
                            </select>
                            <span id="category_name_err_edit${leave_id}" data-id="${leave_id}" class="text-danger d-none fs-10">Category Name can't be same</span>
                        </div>
                        <div class="col-xl-2 pt-3">
                            <label for="inputCity" class="form-label ">Leave Cycle <small style="background-color:transparent;" class="badge badge-info-light" data-bs-trigger="hover"
                                            data-bs-container="body"
                                            data-bs-content="Monthly limit should not exeeds more than 31 & Yearly limit should not exceed more than 366."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Leave Cycle "><i
                                                class="fa fa-info-circle"></i></small></label>
                            <select name="leave_cycle_my_edit[]" id="leave_cycle_edit${leave_id}" onchange="leaveCycleCheckEdit(this)" data-id="${leave_id}" class="form-control" required><option value="" disabled selected>Select Leave Cycle</option> <option value="1">Monthly</option>
                                <option value="2">Yearly</option></select>
                        </div>
                        <div class="col-xl-1 pt-3">
                            <label for="inputCity" class="form-label ">Days</label>
                            <input type="number" step="0.5" id="leave_day_edit${leave_id}" oninput="checkMaxValueEdit(this)" data-id="${leave_id}" name="days_edit[]" id="leave_days_edit${leave_id}" min="1" value="" class="form-control bg-muted leaveDays" placeholder="Count" disabled required >
                            <span class="text-danger d-none fs-10" id="days_err_edit${leave_id}">Limit can't be greater than day count</span>
                        <span class="text-danger d-none fs-10" id="days_err_edit1${leave_id}">Invalid count</span>

                        </div>
                        <div class="col-xl-2 pt-3 bg-muted">
                            <label for="inputState" class="form-label">Unused Leave Rule</label>
                            <select class="form-control select2" id="leaverules_edit${leave_id}" name="unused_leave_rule_edit[]"  onchange="unusedLeaveRuleEdit(this)" data-id="${leave_id}" required>
                                <option  value="0"  selected readonlye>Select Leave Rule</option>
                                <option value="1">Lapse</option> <option value="2">Carry Forward</option>
                            </select>
                        </div>
                        <div class="col-xl-2 pt-3">
                            <label for="inputCity" class="form-label">Carry Forward Limit</label>
                            <input name="carry_forward_limit_edit[]" type="number" step="0.5" oninput="checkLimitMaxValueEdit(this)" data-id="${leave_id}" min="1"  value="" class="form-control carry-forward-input-edit" id="carryForwardLimitEdit${leave_id}" placeholder="Days" disabled required>
                            <span class="text-danger d-none fs-10" id="cflimit_err_edit${leave_id}">Limit can't be greater than day count</span>
                            <span class="text-danger d-none fs-10" id="cflimit_err_edit1${leave_id}">Invalid Count Value</span>

                        </div>

                        <div class="col-xl-2 pt-3">
                            <label for="inputState" class="form-label">Applicable To</label>
                            <select data-id="${leave_id}" class="form-control select2" id="applicable_to_edit1${leave_id}" name="applicable_to_edit[]" required>
                                <option label="" value="" disabled selected>Select Applicable To</option>
                                  {{--  @foreach ($applicableTo as $item)
                                        <option  value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach  --}}
                            </select>
                        </div>

                        <div class="col-xl-1 pt-3 text-end">
                            <label for="inputCity" class="form-label ">&nbsp;</label>
                            <button type="button" class="btn btn-sm btn-danger remove_item_btn_edit"><i class="feather feather-trash"></i></button>
                        </div>
                    </div> `
                );

                leave_id++;

            });
            $(document).on('click', '.remove_item_btn_edit', function(e) {
                // e.preventDefault();
                let totalRows = $('.rowrowedit').length;
                // Check if there's only one row left
                if (totalRows == 1) {
                    // Show an error message or perform the desired action
                    alert("Cannot remove the last row!");
                    return;
                } else {
                    // alert("sahi hai");
                }
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            })
        });
    </script>
<script>
    function change_amount(val) {
        var change_id = val.id;
        var value1 = val.value;
        console.log('change_id', change_id);
        var extra = document.getElementById('extra');
        const amountManual=document.getElementById('amountManual')
        // console.log('value1',value1);
        if (value1 == 1) {
            // Show the extra input field when value1 is 1
            extra.style.display = 'block';
            amountManual.disabled = false;
        }
        if (value1 == 0) {
            // Hide the extra input field when value1 is 0
            extra.style.display = 'none';
            amountManual.disabled = true;
        }
    }
    function change_amount_edit(val) {
        var change_id = val.id;
        var value1 = val.value;
        console.log('change_id', change_id);
        var extra = document.getElementById('extra_edit');
        const amountManual=document.getElementById('amountManual')
        // console.log('value1',value1);
        if (value1 == 1) {
            // Show the extra input field when value1 is 1
            extra.style.display = 'block';
            amountManual.disabled = faalse;
        }
        if (value1 == 0) {
            // Hide the extra input field when value1 is 0
            extra.style.display = 'none';
            amountManual.disabled = true;
        }
    }
    $(document).ready(function() {
            var postURL = "<?php echo url('policy_sumbit'); ?>";
            $(".add_item_btn").click(function(e) {

                $('#newRowError').addClass('d-none');
                let categoryname = $('#categoryname').val();
                let days = $('#days').val();
                let leaverule = $('#leaverule').val();
                let cfl = $('#cfl').val();
                let applicable = $('#applicable').val();
                $("#show_item").append(`
                    <div class="container-fluid">
                        <div class="row col-12 pt-3" name="leave_id" id="${leave_id}">
                            <label  for="grade_name" class="form-label">Grade</label>
                            <select  name="grade_name" class="form-select">
                                @foreach($grade_list as $item)
                                    <option value="{{ $item->id }}">{{ $item->grade_name }}</option>
                                @endforeach
                            </select>
                        </div>


                            <div class="row col-12 pt-3" name="leave_id" id="${leave_id}">
                                <label for="travel_type" class="form-label">Travel Type</label>
                                <input  name="travel_type"   value="By Road" class="form-control carry-forward-input"  selected  placeholder="By Road" required>
                            </div>

                            <div class="row col-12 pt-3" name="leave_id">
                                <label for="Vehicle_type" class="form-label">Vehicle Type</label>
                                <select name="Vehicle_type" class="form-select" id="city">
                                    @foreach($road_data as $item)
                                        <option value="{{ $item->travel_id}}">{{ $item->travel_type }}</option>
                                    @endforeach
                                </select>
                            </div>


                        <div class="row col-12 pt-3">
                            <label for="toll_charge" class="form-label">Toll Charges</label>
                            <select class="form-control select2" name="toll_charge" data-id="${leave_id}" id="amount_switch" data-placeholder="Applicable To" required onchange="change_amount(this)">
                                <option value="">Select Amount</option>
                                <option value="1">Add Amount</option>
                                <option value="0">Actual</option>
                            </select>
                        </div>


                        <div class="row col-12 pt-3" name="leave_id " style="display:none" id="extra">
                            <label for="toll_add_charge" class="form-label">Amount</label>
                            <input name="toll_add_charge" type="number "   value="" class="form-control carry-forward-input"  id="amountManual" placeholder="Amount" required>
                            </div>

                        <div class="row col-12 pt-3" id="log_amount">
                            <label for="parking_charge" class="form-label">Parking charges</label>
                            <input name="parking_charge"  data-id="" value="" class="form-control carry-forward-input" placeholder="Amount" required>
                        </div>
                    </div>
                `);
            });
            // Use event delegation for popovers




                // Check if any of the required fields is empty








                // Define the URL for the AJAX request


        });

    function openTollEditBtn(context) {
        console.log('context',context);
        var id = $(context).data('id');
                    var grade_name = $(context).data('grade_name')
                    var travel_type = $(context).data('travel_type');
                    var Vehicle_type = $(context).data('vehicle_type');
                    var toll_add_charge = $(context).data('toll_add_charge');
                    var parking_charge = $(context).data('parking_charge')
                    var findid=$(context).closest('tr').find('td[dataedit]').attr('dataedit');

                // console.log("toll_add_charge",toll_add_charge,'Vehicle_type',Vehicle_type,'parking_charge',parking_charge,'findid',findid,'grade_name',grade_name);

        var dynamicData = `
                        <div class="container-fluid">
                            <div class="row col-12 pt-3" name="leave_id" id="${leave_id}">
                                <label for="grade_name" class="form-label">Grade</label>
                                <select name="grade_name" class="form-select">
                                    @foreach($grade_list as $item)
                                        <option value="{{ $item->id }}">{{ $item->grade_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="edit" value="${findid}">
                            <div class="row col-12 pt-3" name="leave_id" id="${leave_id}">
                                <label for="travel_type" class="form-label">Travel Type</label>
                                <input name="travel_type" value="By Road" class="form-control carry-forward-input" selected placeholder="By Road" required>
                            </div>

                            <div class="row col-12 pt-3" name="leave_id">
                                <label for="Vehicle_type" class="form-label">Vehicle Type</label>
                                <select name="Vehicle_type" class="form-select" id="city">
                                    @foreach($road_data as $item)
                                        <option value="{{ $item->travel_id }}">{{ $item->travel_type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row col-12 pt-3">
                                <label for="toll_charge" class="form-label">Toll Charges</label>
                                <select class="form-control select2" name="toll_charge" data-id="${leave_id}" id="amount_switch" data-placeholder="Applicable To" required onchange="change_amount_edit(this)">
                                    ${toll_add_charge ?
                                    `<option value="1">Add Amount</option>
                                    <option value="0">Actual</option>
                                    <option value="">Select Amount</option>` :
                                    `<option value="">Select Amount</option>
                                    <option value="1">Add Amount</option>
                                    <option value="0">Actual</option>`}
                                </select>
                            </div>

                            <div class="row col-12 pt-3" name="leave_id " id="extra_edit">
                                <label for="toll_add_charge" class="form-label">Amount</label>
                                ${toll_add_charge ?
                                `<input name="toll_add_charge" value="${toll_add_charge}" class="form-control carry-forward-input" id="amountManual" placeholder="Amount" required>`:
                                `<input name="toll_add_charge" value=" " class="form-control carry-forward-input" id="amountManual" placeholder="Toll Amount" required>`}
                            </div>

                            <div class="row col-12 pt-3" id="log_amount">
                                <label for="parking_charge" class="form-label">Parking charges</label>
                                <input name="parking_charge" type="number"  value="${parking_charge}"   data-id="${leave_id}" class="form-control " placeholder="Parking Amount" required>
                            </div>
                        </div>
                        `;

        document.getElementById('showedit').innerHTML = dynamicData;
    }

    //   for delete function
    function openDeleteBtn(context)
    {
        console.log('context',context);
        var id = $(context).data('id');
                    var grade_name = $(context).data('grade_name')
                    var travel_type = $(context).data('travel_type');
                    var Vehicle_type = $(context).data('vehicle_type');
                    var toll_add_charge = $(context).data('toll_add_charge');
                    var parking_charge = $(context).data('parking_charge')
                    var findid=$(context).closest('tr').find('td[dataedit]').attr('dataedit');

                    console.log("toll_add_charge",toll_add_charge,'Vehicle_type',Vehicle_type,'parking_charge',parking_charge,'findid',findid,'grade_name',grade_name);


                    // Populate the modal with the data
                    $('#deleteId').val(id);
                    // $('#gradeDeleteText').html(gradeName);

                    // Show the delete confirmation modal
                    $("#deleteModal").modal('show');
    }

</script>


@endsection
