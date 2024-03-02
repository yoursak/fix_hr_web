@extends('admin.pagelayout.master')
@section('title')
Business | Leave Policy
@endsection
@section('css')
@endsection
@section('content')
@php
$Central = new App\Helpers\Central_unit();
$Employee = $Central::EmployeeDetails();
$Department = $Central->DepartmentList();
$Designation = $Central::DesignationList();
$nss = new App\Helpers\Central_unit();
$EmpID = $nss->EmpPlaceHolder();
@endphp
{{-- breadcrumbs set start --}}
<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/settings/business') }}">Business Settings</a></li>
        <li class="active"><span><b>Leave Policy</b></span></li>
    </ol>
</div>
{{-- breadcrumbs set end --}}
{{-- page header start --}}
<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Leave Policy</div>
        <p class="text-muted m-0">Create a Template for Granting Leaves to Staff on a Monthly Basis, If They Wish.</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block ms-auto">
                <div class="btn-list">
                    <button type="button" class="btn btn btn-primary " id="create_template_btn">
                        Create Leave Policy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- page header end --}}
{{-- page-body start --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Leave Policy List</h3>
    </div>
    <livewire:settings.leave-list-livewire>
    {{-- <div class="card-body">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Policy Name</th>
                        <th class="border-bottom-0">Policy Cycle</th>
                        <th class="border-bottom-0">Leave | Applied To</th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $j = 1;
                    @endphp
                    @foreach ($leavePolicy as $item)
                    <tr>
                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                        <td class="font-weight-semibold">{{ $item->policy_name }}</td>
                        <td class="font-weight-semibold">
                            @foreach ($Central->LeavePolicyCategory($item->id) as $check)
                            <div class="row">
                                <div class="tags">
                                    <span class="tag tag-rounded">
                                        {{ $check->leave_cycle_monthly_yearly == 1 ? 'Monthly' : 'Yearly' }}
                                        &nbsp;
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td class="font-weight-semibold">
                            @foreach ($Central->LeavePolicyCategory($item->id) as $check)
                            <div class="row">
                                <div class="tags">
                                    <span class="tag tag-rounded"> {{ $check->static_category_name }} &nbsp;
                                    </span>
                                    <span class="tag tag-rounded">
                                        {{ $check->static_leave_category_applicable_name }}
                                    </span>

                                </div>
                            </div>
                            @endforeach
                        </td>
                        @php
                        $masterendgame = 0;
                        @endphp
                        <td>

                            @foreach ($getleavepolicy as $dataaa)
                            @if ($item->id == $dataaa->leave_policy_ids_list)
                            @php
                            $masterendgame = 1;
                            break; // Break out of the loop once a match is found
                            @endphp
                            @endif
                            @endforeach

                            <button class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);" {{ $masterendgame == 1 ? 'disabled' : '' }} onclick="openEditModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-sandwich_leaves_count='<?= $item->sandwich_leaves_count ?>' data-sandwich_leaves_ignore='<?= $item->sandwich_leaves_ignore ?>' data-leave_policy_cycle_monthly='<?= $item->leave_policy_cycle_monthly ?>' data-leave_policy_cycle_yearly='<?= $item->leave_policy_cycle_yearly ?>' data-leave_period_from='<?= $item->leave_period_from ?>' data-leave_period_to='<?= $item->leave_period_to ?>' data-bs-toggle="modal" data-bs-target="#showmodal">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                            </button>
                            <a class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);" onclick="openViewModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-sandwich_leaves_count='<?= $item->sandwich_leaves_count ?>' data-sandwich_leaves_ignore='<?= $item->sandwich_leaves_ignore ?>' data-leave_policy_cycle_monthly='<?= $item->leave_policy_cycle_monthly ?>' data-leave_policy_cycle_yearly='<?= $item->leave_policy_cycle_yearly ?>' data-leave_period_from='<?= $item->leave_period_from ?>' data-leave_period_to='<?= $item->leave_period_to ?>' data-bs-toggle="modal" data-bs-target="#viewshowmodal">
                                <i class="feather feather-eye" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                            </a>
                            <button id="deleteButton" class="btn action-btns  btn-danger btn-icon btn-sm" data-toggle="modal" onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-target="#deleteModal" data-id="1"><i class="feather feather-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
</div>
{{-- page body end --}}
{{-- leave policy create modal start --}}
<div class="container">
    <div class="modal fade" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.leavepolicySubmit') }}" method="POST" id="form_leave">
                    <div class="modal-body" style="height: 60vh; overflow:scroll">
                        @csrf
                        <div class="row">
                            <h4>Leave Settings</h4>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="col-sm-2 col-xl-2 col-form-label">Policy Name</label>
                            <div class="col-xl-10">
                                <input type="text" class=" form-control " id="policy_Names" placeholder="Enter Template Name" name="policyname" required>
                            </div>
                        </div>

                        <div class="pt-2 row">
                            <label for="editFrom" class="col-xl-2 col-form-label">Leave Period</label>
                            <div class="col-xl-2">
                                <input type="month" class="form-control " name="leave_periodfrom" id="editFrom" data required>
                            </div>
                            <label class="col-xl-1 text-xl-center col-form-label" for="form-label">To</label>
                            <div class="col-xl-2">
                                <input type="month" class="form-control" name="leave_periodto" id="editTo" required readonly>
                            </div>
                        </div>

                        <div class="pt-2 row" id="sandwichLeavesCreateId">
                            <label for="inputPassword" class="col-xl-2 col-form-label">Sandwich Leaves
                                <small class="badge badge-info-light" data-bs-trigger="hover" style="background-color:transparent;" data-bs-container="body" data-bs-content="When a holiday falls between two taken leaves, they are merged together and considered as sandwich leaves." data-bs-placement="right" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Sandwich Leaves"><i class="fa fa-info-circle"></i>
                                </small>
                            </label>
                            <div class="col-sm-5">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth" value="1" checked>
                                    <label class="btn btn-outline-primary" for="btnradiomonth">&nbsp;Count&nbsp;&nbsp;&nbsp;</label>
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioyear" value="2">
                                    <label class="btn btn-outline-primary" for="btnradioyear">&nbsp;Ignore&nbsp;&nbsp;&nbsp;</label>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 row d-flex">
                            <div class="col">
                                <h4 class="card-title"><span>Leave Category</span></h4>
                            </div>
                            <div class="col-sm-2 col-xl-2 text-end">
                                <button type="button" class="btn btn-sm btn-primary add_item_btn"><i class="fe fe-plus bold"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <span id="show_item">
                            </span>
                            <span class="text-danger d-none fs-10" id="newRowError">**Please fill the previous row
                                value before adding a new row.</span>
                        </div>
                        <script>
                            document.getElementById('editFrom').addEventListener('input', function() {
                                // Get the selected month and year from the "From" input
                                var fromValue = this.value;
                                var fromYear = parseInt(fromValue.split('-')[0]);
                                var fromMonth = parseInt(fromValue.split('-')[1]);
                                // Calculate the month and year after one year
                                var toYear = fromMonth == 1 ? fromYear : fromYear + 1;
                                var toMonth = fromMonth == 1 ? 12 : fromMonth - 1;
                                // Format the "To" input value and set it
                                var toValue = toYear + '-' + (toMonth < 10 ? '0' : '') + toMonth;
                                document.getElementById('editTo').value = toValue;
                            });
                        </script>
                    </div>
                    <div class="row">
                        {{-- <span id="emptySingleCehck d-none">This Field can't be empty.</span> --}}
                    </div>
                    <div class="row mx-2">
                        <span class="text-danger fs-12">Note: You must activate
                            your Comp Off and LWP policies from the business settings;
                            otherwise, Comp Off and LWP will not be allocated along with the leave policy.</span>
                    </div>
                    <div>
                        &nbsp;
                    </div>

                    <div class="modal-footer d-flex justify-content-end">
                        <div class="text-center">
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            <button class="btn btn-primary" name="" id="submit" type="submit" data-bs-target="">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
{{-- leave policy create modal end --}}
{{-- leave policy edit modal  start yaahi aana h --}}
<div class="container">
    <div class="modal fade" id="showmodal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Leave Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/admin/settings/business/update_leave_policy') }}" method="POST" id="form_leave_edit">
                    @csrf
                    <input type="text" name="role" id="rolesId" hidden>

                    <div class="modal-body" style="height: 60vh; overflow:scroll">
                        <div class="row">
                            <h4>Leave Settings</h4>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="col-sm-2 col-xl-2 col-form-label">Policy Name</label>
                            <div class="col-xl-10">
                                <input type="text" class="form-control " name="edit_policys" id="edit_policy" placeholder="Enter Leave Policy Template Name" required>
                            </div>
                        </div>

                        <div class="pt-2 row">
                            <label for="editFrom" class="col-xl-2 col-form-label">Leave Period</label>
                            <div class="col-xl-2">
                                <input type="month" class="form-control " id="leave_periodfrom2" aria-disabled="true" disabled>
                            </div>
                            <label class="col-xl-1 col-form-label text-xl-center" for="">To</label>
                            <div class="col-xl-2">
                                <input type="month" class="form-control " id="leave_periodto2" aria-disabled="true" disabled>
                            </div>

                        </div>
                        <div class="pt-2 row" id="sandwichLeavesEditId">
                            <label for="inputPassword" class="col-xl-2 col-form-label">Sandwich Leaves <small class="badge badge-info-light" data-bs-trigger="hover" style="background-color:transparent;" data-bs-container="body" data-bs-content="When a holiday falls between two availed leaves, they are merged together and considered as sandwich leaves." data-bs-placement="right" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Sandwich Leaves"><i class="fa fa-info-circle"></i></small>
                            </label>
                            <div class="col-sm-5">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" value="1" name="btnradioedit" id="btnradiomonthsedit" disabled>
                                    <label class="btn btn-outline-primary px-4" for="btnradiomonthsedit">Count</label>
                                    <input type="radio" class="btn-check" value="2" name="btnradioedit" id="btnradioyearsedit" disabled>
                                    <label class="btn btn-outline-primary px-4" for="btnradioyearsedit" style="width: 5.8rem">Ignore&nbsp;&nbsp;&nbsp;</label>
                                </div>
                            </div>
                        </div>
                        <div class="pt-5 row d-flex ">
                            <div class="col">
                                <h4 class="card-title"><span>Leave Category </span></h4>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn btn-sm btn-primary add_item_btn_edit"><i class="fe fe-plus bold"></i>
                                </button>
                            </div>
                        </div>
                        <span id="show_item_edit">
                        </span>
                    </div>
                    <div id="editmodalfooter" class="modal-footer d-flex justify-content-end d-none">
                        <div class="text-center">
                            <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                            <button class="btn btn-primary" name="" id="updateButton" data-bs-target="">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="modal fade" id="viewshowmodal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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

                <div class="modal-body" style="height: 60vh; overflow:scroll">
                    <div class="row">
                        <h4>Leave Settings</h4>
                    </div>
                    <div class="row">
                        <label for="inputPassword" class="col-sm-2 col-xl-2 col-form-label">Policy Name</label>
                        <div class="col-xl-10">
                            <input type="text" class="form-control " name="edit_policys" id="edit_policyview" placeholder="Enter Leave Policy Template Name" required readonly>
                        </div>
                    </div>

                    <div class="pt-2 row">
                        <label for="editFrom" class="col-xl-2 col-form-label">Leave Period</label>
                        <div class="col-xl-2">
                            <input type="month" class="form-control " id="leave_periodfrom2view" aria-disabled="true" disabled>
                        </div>
                        <label class="col-xl-1 col-form-label text-xl-center" for="">To</label>
                        <div class="col-xl-2">
                            <input type="month" class="form-control " id="leave_periodto2view" aria-disabled="true" disabled>
                        </div>

                    </div>
                    <div class="pt-2 row" id="sandwichLeavesViewId">
                        <label for="inputPassword" class="col-xl-2 col-form-label">Sandwich Leaves <small class="badge badge-info-light" data-bs-trigger="hover" style="background-color:transparent;" data-bs-container="body" data-bs-content="When a holiday falls between two availed leaves, they are merged together and considered as sandwich leaves." data-bs-placement="right" data-bs-popover-color="primary" data-bs-toggle="popover" data-bs-html=true title="Sandwich Leaves"><i class="fa fa-info-circle"></i></small>
                        </label>
                        <div class="col-sm-5">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" value="1" name="btnradioedit" id="btnradiomonthseditview" disabled>
                                <label class="btn btn-outline-primary px-4" for="btnradiomonthseditview">Count</label>
                                <input type="radio" class="btn-check" value="2" name="btnradioedit" id="btnradioyearseditview" disabled>
                                <label class="btn btn-outline-primary px-4" for="btnradioyearseditview" style="width: 5.8rem">Ignore&nbsp;&nbsp;&nbsp;</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 row d-flex ">
                        <div class="col">
                            <h4 class="card-title"><span>Leave Category </span></h4>
                        </div>
                        <div class="col text-end">
                        </div>
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
{{-- leave policy delete modal start --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('delete.leavePolicy') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                </div>
                <input type="text" id="poli_id" name="poli_id" hidden>
                <div class="modal-body text-center">
                    <h4 class="mt-5">Are you sure you want to delete <span id="assign_emp"></span> ?</h4>
                </div>
                <div class="modal-footer">
                    <a type="close" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- leave policy delete modal end --}}

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $('#form_leave').on('submit', function(event) {
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
        $('#sandwichLeavesCreateId').hide();
        $('#myModal').modal('show');
        $(".add_item_btn").click();
    });

    // insert select box select run
    function LeaveCategoryCheck(context) {
        var value = context.value;
        var id = $(context).data('id');
        var leaveCycleDropdown = document.getElementById('leave_cycle' + id);
        var unusedLeaveRuleDropdown = document.getElementById('leaverules' + id);
        unusedLeaveRuleDropdown.innerHTML = '';
        leaveCycleDropdown.innerHTML = '';
        var leaveDay = document.getElementById('leave_days' + id);
        leaveDay.value = '';
        var applicableTo = document.getElementById('applicable_to' + id);
        applicableTo.innerHTML = '';
        if ((value == 6) || (value == 7)) {
            // If value is 4, add both "Monthly" and "Yearly" options
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            addOption(applicableTo, "", "Select Applicable To", true);
            addOption(applicableTo, "1", "All");
            addOption(applicableTo, "2", "Male");
            addOption(applicableTo, "3", "Female");
            addOption(applicableTo, "4", "Male & Other");

            // addOption(applicableTo, "3", "Female");
        } else if (value == 4) {
            // maternity
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            var applicableTo = document.getElementById('applicable_to' + id);
            addOption(applicableTo, "3", "Female");
        } else if (value == 5) {
            // paternity
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            addOption(applicableTo, "4", "Male & Other");
            // addOption(applicableTo, "3", "Female");
        } else {
            leaveDay.disabled = true;
            addOption(leaveCycleDropdown, "", "Select Leave Cycle", true);
            addOption(leaveCycleDropdown, "1", "Monthly");
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "", "Select Leave Rule", true);
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            addOption(unusedLeaveRuleDropdown, "2", "Carry Forward");
            addOption(applicableTo, "", "Select Applicable To", true);
            addOption(applicableTo, "1", "All");
            addOption(applicableTo, "2", "Male");
            addOption(applicableTo, "3", "Female");
            addOption(applicableTo, "4", "Male & Other");
        }
        $('#newRowError').addClass('d-none');
        var selectedOption = $(context).find(':selected');
        var description = selectedOption.data('description');
        var name = selectedOption.data('name');
        var id = $(context).data('id');
        var popoverSelector = $('#description' + id);
        var myButton = document.getElementById('submit');
        var dayErr = document.getElementById('days_err' + id);
        var dayErr1 = document.getElementById('days_err1' + id);
        // myButton.disabled = false;
        dayErr.classList.add('d-none');
        dayErr1.classList.add('d-none');
        // Update popover content
        popoverSelector.attr('data-bs-content', '<div style="text-align: justify;">' + description + '</div>');
        // popoverSelector.attr('data-bs-content', description);
        popoverSelector.attr('title', name);
        // Destroy and recreate the popover to reflect the updated content
        popoverSelector.popover('dispose').popover({
            trigger: 'hover',
            delay: {
                show: 100, // Set the delay for showing the popover (in milliseconds)
                hide: 100 // Set the delay for hiding the popover (in milliseconds)
            }
        });
        // Show popover
        // popoverSelector.popover('show'); // hidded by Aman as per the instruction of Dilip Sir.

        // Automatically hide the popover after 2 seconds
        setTimeout(function() {
            popoverSelector.popover('hide');
        }, 1000);
    }

    // insrt modal leave category select
    function LeaveCycleCheck(context) {
        $('#newRowError').addClass('d-none');
        var value = context.value;
        var id = $(context).data('id');
        var unusedLeaveRuleDropdown = document.getElementById('leaverules' + id);
        var leaveDay = document.getElementById('leave_days' + id);
        var leaveCFL = document.getElementById('carryForwardLimit' + id);
        var myButton = document.getElementById('submit');
        var dayErr = document.getElementById('days_err' + id);
        var dayErr1 = document.getElementById('days_err1' + id);
        unusedLeaveRuleDropdown.value = '';
        leaveDay.value = '';
        leaveCFL.value = '';
        leaveDay.disabled = false;
        leaveCFL.disabled = true;
        // myButton.disabled = false;
        dayErr.classList.add('d-none');
        dayErr1.classList.add('d-none');
    }

    // leave insert modal days input field
    function checkMaxValue(context) {
        var id = $(context).data('id');
        var value = context.value;
        var leaveCycle = document.getElementById('leave_cycle' + id).value;
        var myButton = document.getElementById('submit');
        var leaveDays = Number(leaveCycle) == 1 ? '30' : '366';
        var leaveDaysNumber = Number(leaveDays);
        var valueNumber = Number(value);
        var dayErr = document.getElementById('days_err' + id);
        var dayErr1 = document.getElementById('days_err1' + id);
        var decimalPart = value - Math.floor(value);
        if (leaveCycle == 1) {
            maxAllowedValue = 31;
        } else if (leaveCycle == 2) {
            maxAllowedValue = 366;
        } else {
            // Handle other cases or provide a default value
            console.error("Invalid leaveCycle value");
            return;
        }
        // var roundedValue;
        // if (decimalPart < 0.5) {
        //     // If less than 0.5, round down to the nearest whole number
        //     context.value = Math.floor(valueNumber);
        // } else {
        //     // If greater than or equal to 0.5, round up to the nearest whole number
        //     context.value = Math.ceil(valueNumber);
        // }

        var enteredNumber = Number(context.value);

        // Check if the entered value exceeds the maxAllowedValue
        if (!isNaN(enteredNumber) && enteredNumber > maxAllowedValue) {
            // If it exceeds, set the input value to the maximum allowed value
            event.target.value = maxAllowedValue;
        }

        if (!isNaN(leaveDaysNumber) && !isNaN(valueNumber)) {
            if (leaveDaysNumber < valueNumber) { // value gerter
                console.log("1");
                // myButton.disabled = true;
                dayErr.classList.remove('d-none');
                dayErr1.classList.add('d-none');
            } else if ((decimalPart == 0.5) || (decimalPart == 0)) {
                console.log("2");

                myButton.disabled = false;
                dayErr.classList.add('d-none');
                dayErr1.classList.add('d-none');

            } else if (decimalPart != 0.5) {
                console.log("3");

                myButton.disabled = true;
                dayErr1.classList.remove('d-none');

            } else if (leaveDaysNumber >= valueNumber) {
                console.log("4");

                myButton.disabled = false;
                dayErr.classList.add('d-none');
            }
        } else {
            // Handle the case where either leaveDays or value is not a valid number
            console.error("leaveDays and value must be convertible to numbers");
        }

    }

    // insert unused leave rule
    function UnusedLeaveRule(context) {
        $('#newRowError').addClass('d-none');
        var value = context.value;
        var id = $(context).data('id');
        var myButton = document.getElementById('submit');
        var dayErr = document.getElementById('days_err' + id);
        var dayErr1 = document.getElementById('days_err1' + id);
        if (value == 2) {
            $('#carryForwardLimit' + id).prop('disabled', false);
        } else {
            $('#carryForwardLimit' + id).val('');
            $('#carryForwardLimit' + id).prop('disabled', true);
        }
        myButton.disabled = false;
        dayErr.classList.add('d-none');
        dayErr1.classList.add('d-none');
    }
    // insert max value check
    function checkLimitMaxValue(input) {
        $('#newRowError').addClass('d-none');
        var value = input.value;
        console.log(value);
        var id = $(input).data('id');
        var leaveDays = document.getElementById('leave_days' + id).value;
        var numericValue = parseFloat(input.value);
        var myButton = document.getElementById('submit');
        var cflimitErr = document.getElementById('cflimit_err' + id);
        var cflimitErr1 = document.getElementById('cflimit_err1' + id);
        var leaveDaysNumber = Number(leaveDays);
        var valueNumber = Number(value);
        // myButton.disabled = false;
        cflimitErr.classList.add('d-none');
        cflimitErr1.classList.add('d-none');
        // Check if the conversion was successful (both leaveDays and value are valid numbers)
        var decimalPart = numericValue - Math.floor(numericValue);
        if (!isNaN(leaveDaysNumber) && !isNaN(valueNumber)) {
            if (leaveDaysNumber < valueNumber) { // value gerter
                console.log("1");
                // myButton.disabled = true;
                cflimitErr.classList.remove('d-none');
                cflimitErr1.classList.add('d-none');
                input.value = leaveDaysNumber;
            } else if ((decimalPart == 0.5) || (decimalPart == 0)) {
                console.log("2");

                myButton.disabled = false;
                cflimitErr.classList.add('d-none');
                cflimitErr1.classList.add('d-none');

            } else if (decimalPart != 0.5) {
                console.log("3");

                myButton.disabled = true;
                cflimitErr1.classList.remove('d-none');

            } else if (leaveDaysNumber >= valueNumber) {
                console.log("4");

                myButton.disabled = false;
                cflimitErr.classList.add('d-none');
            }
        } else {
            // Handle the case where either leaveDays or value is not a valid number
            console.error("leaveDays and value must be convertible to numbers");
        }
        // validationStatus[id] = !(myButton.disabled || cflimitErr1.classList.contains('d-none'));

        // // Check overall validation status and enable/disable submit button accordingly
        // updateSubmitButton();
    }



    // Function to handle leave category, leave cycle, and applicable to changes
    function handleLeaveChanges(context) {
        var value = context.value;
        var id = $(context).data('id');
        var leaveCycleDropdown = document.getElementById('leave_cycle' + id);
        var unusedLeaveRuleDropdown = document.getElementById('leaverules' + id);
        unusedLeaveRuleDropdown.innerHTML = '';
        leaveCycleDropdown.innerHTML = '';
        var leaveDay = document.getElementById('leave_days' + id);
        leaveDay.value = '';
        var applicableTo = document.getElementById('applicable_to' + id);
        applicableTo.innerHTML = '';

        if ((value == 6) || (value == 7)) {
            // Add options for yearly leaves
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            addApplicableToOptions(applicableTo);
        } else if (value == 4) {
            // Add options for maternity leaves
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            addOption(applicableTo, "3", "Female");
        } else if (value == 5) {
            // Add options for paternity leaves
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            leaveDay.disabled = false;
            leaveDay.setAttribute('max', '366');
            leaveDay.setAttribute('maxlength', '3');
            addOption(applicableTo, "4", "Male & Other");
        } else {
            // Default options for other leaves
            leaveDay.disabled = true;
            addDefaultOptions(leaveCycleDropdown, unusedLeaveRuleDropdown, applicableTo);
        }

        // Additional logic for updating popover, hiding after 2 seconds, etc.
        updatePopover(context);
    }

    // Function to add applicable to options
    function addApplicableToOptions(applicableTo) {
        addOption(applicableTo, "", "Select");
        addOption(applicableTo, "1", "All");
        addOption(applicableTo, "2", "Male");
        addOption(applicableTo, "3", "Female");
        addOption(applicableTo, "4", "Male & Other");
    }

    // Function to add default options
    function addDefaultOptions(leaveCycleDropdown, unusedLeaveRuleDropdown, applicableTo) {
        leaveCycleDropdown.innerHTML = '';
        addOption(leaveCycleDropdown, "", "Select Leave Cycle", true);
        addOption(leaveCycleDropdown, "1", "Monthly");
        addOption(leaveCycleDropdown, "2", "Yearly");
        unusedLeaveRuleDropdown.innerHTML = '';
        addOption(unusedLeaveRuleDropdown, "", "Select Leave Rule", true);
        addOption(unusedLeaveRuleDropdown, "1", "Lapse");
        addOption(unusedLeaveRuleDropdown, "2", "Carry Forward");
        applicableTo.innerHTML = '';
        addOption(applicableTo, "", "Select");
        addOption(applicableTo, "1", "All");
        addOption(applicableTo, "2", "Male");
        addOption(applicableTo, "3", "Female");
        addOption(applicableTo, "4", "Male & Other");
    }

    // Function to update popover and hide after 2 seconds
    function updatePopover(context) {
        // Your existing popover update logic
        // ...
        setTimeout(function() {
            // Your existing popover hide logic
            // ...
        }, 2000);
    }

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



    $(document).ready(function() {
        var postURL = "<?php echo url('policy_sumbit'); ?>";
        $(".add_item_btn").click(function(e) {
            // e.preventDefault();
            if (!validatePreviousRow()) {
                // Show an alert or take any other action for empty values
                // Swal.fire({
                //     title: 'Previous row values are empty',
                //     text: 'Please fill in the previous row values before adding a new row.',
                //     icon: 'error',
                // });

                $('#newRowError').removeClass('d-none');
                return;
            }
            $('#newRowError').addClass('d-none');
            let categoryname = $('#categoryname').val();
            let days = $('#days').val();
            let leaverule = $('#leaverule').val();
            let cfl = $('#cfl').val();
            let applicable = $('#applicable').val();
            // leave_id = document.getElementById('cfl').value;<option>Encash</option>
            $("#show_item").append(
                `<div class="row rowrow">
                        <div class="col-xl-2 pt-3" name="leave_id" id="' + leave_id +'" >
                            <label for="inputCity" class="form-label">Category Name <small style="background-color:transparent;"  id="description${leave_id}" class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                            data-bs-container="body"
                                            data-bs-content=""
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title=""><i style="background-color:none;"
                                                class="fa fa-info-circle" ></i></small></label>
                            <select type="text" name="category_name[]" id="leave_category${leave_id}" onchange="LeaveCategoryCheck(this)" data-id="${leave_id}" value="" class="form-control" id="inputCity" placeholder="Category Name" required><option value="" disabled selected>Select Category</option>
                            @foreach ($leaveType as $item)
                                <option data-name="{{ $item->name }}" data-description="{{ $item->description }}" value={{ $item->id }}>{{ $item->name }}</option>
                            @endforeach </select>
                            <span id="category_name_err${leave_id}" class="text-danger d-none fs-10">Category Name can't be same</span>
                        </div>

                        <div class="col-xl-2 pt-3">
                            <label for="inputCity" class="form-label">Leave Cycle <small style="background-color:transparent;" class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                data-bs-container="body"
                                data-bs-content="Monthly or yearly limits should not exceed more than 31 or 366 days."
                                data-bs-placement="right" data-bs-popover-color="primary"
                                data-bs-toggle="popover" data-bs-html=true title="Leave Cycle"><i
                                    class="fa fa-info-circle"></i></small></label>
                                    <select name="leave_cycle_my[]" id="leave_cycle${leave_id}" onchange="LeaveCycleCheck(this)" data-id="${leave_id}" class="form-control" required><option value="" disabled selected>Select Leave Cycle</option> <option value="1">Monthly</option>
                                <option value="2">Yearly</option></select>
                        </div>

                        <div class="col-xl-1 pt-3">
                            <label for="inputCity" class="form-label ">Days <small class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                            style="background-color:transparent;" data-bs-container="body"
                                            data-bs-content="Day count should be in a valid format. For example, it should be either 1 or 1.5 only."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Days"><i
                                                class="fa fa-info-circle"></i></small></label>
                            <input  type="number" oninput="checkMaxValue(this)" step="0.5" name="days[]" value="" min="1" class="form-control bg-muted"  placeholder="Count" data-id="${leave_id}"  id="leave_days${leave_id}" required disabled>
                            <span class="text-danger d-none fs-10" id="days_err${leave_id}">Limit can't be greater than Leave Cycel day</span>
                        <span class="text-danger d-none fs-10" id="days_err1${leave_id}">Invalid count</span>

                            </div>

                        <div class="col-xl-2 pt-3 bg-muted">
                            <label for="inputState" class="form-label">Unused Leave Rule</label>
                            <select class="form-control select2 UnuserLevaRuleClass" name="unused_leave_rule[]" id="leaverules${leave_id}"  onchange="UnusedLeaveRule(this)" data-id="${leave_id}"   required>
                                <option  value="" disabled selected>Select Leave Rule</option>
                                <option value="1">Lapse</option> <option value="2">Carry Forward</option>
                            </select>
                        </div>
                        <div class="col-xl-2 pt-3">
                            <label for="inputCity" class="form-label">Carry Forward Limit</label>
                            <input name="carry_forward_limit[]" type="number" step="0.5" oninput="checkLimitMaxValue(this)" data-id=${leave_id} value="" class="form-control carry-forward-input" min="1" id="carryForwardLimit${leave_id}"  placeholder="Days" required disabled>
                            <span class="text-danger d-none fs-10" id="cflimit_err${leave_id}">Limit can't be greater than day count</span>
                            <span class="text-danger d-none fs-10" id="cflimit_err1${leave_id}">Invalid Count Value</span>
                        </div>

                        <div class="col-xl-2 pt-3">
                            <label for="inputState" class="form-label">Applicable To</label>
                            <select class="form-control select2" name="applicable_to[]"  data-id="${leave_id}" id="applicable_to${leave_id}"  data-placeholder="Applicable To" required >
                                <option value="" disabled selected>Select Applicable To</option>
                                @foreach ($applicableTo as $item)
                                    <option  value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-1 pt-3 text-end">
                            <label for="inputCity" class="form-label ">&nbsp;</label>
                            <button type="button" class="btn btn-sm btn-danger remove_item_btn"><i class="feather feather-trash"></i></button>
                        </div>
                    </div> `
            );
            leave_id++;

            $('[data-bs-toggle="popover"]').popover({
                trigger: 'hover'
            });

            function validatePreviousRow() {
                var lastRow = $("#show_item .row:last");
                var categorySelect = lastRow.find('select[name="category_name[]"]');
                var leaveCycleSelect = lastRow.find('select[name="leave_cycle_my[]"]');
                var daysInput = lastRow.find('input[name="days[]"]');
                var leaveRuleSelect = lastRow.find('select[name="unused_leave_rule[]"]');
                var carryForwardLimitInput = lastRow.find('input[name="carry_forward_limit[]"]');
                var applicableToSelect = lastRow.find('select[name="applicable_to[]"]');

                // Check if any of the fields in the last row is empty
                return (
                    categorySelect.val() !== "" &&
                    leaveCycleSelect.val() !== "" &&
                    daysInput.val() !== "" &&
                    (
                        (leaveRuleSelect.val() !== "" &&
                            carryForwardLimitInput.val() !== "") || (leaveRuleSelect.val() ==
                            "1") ||
                        (leaveRuleSelect.val() == "2" && carryForwardLimitInput.val() !== "")
                    ) &&
                    applicableToSelect.val() !== ""
                );
            }
        });
        // Use event delegation for popovers
        $(document).on('mouseenter', '[data-bs-toggle="popover"]', function() {
            $(this).popover('show');
        }).on('mouseleave', '[data-bs-toggle="popover"]', function() {
            $(this).popover('hide');
        });

        $(document).on('click', '.remove_item_btn', function(e) {

            let totalRows = $('.rowrow').length;
            // Check if there's only one row left
            if (totalRows == 1) {
                // Show an error message or perform the desired action
                alert("Cannot remove the last row!");
                return;
            } else {
                // alert("sahi hai");
            }
            // e.preventDefault();
            let row_item = $(this).parent().parent();
            $(row_item).remove();
        })

        var initialCategoryValues = []; // Array to store initial category values

        // Function to set initial category values
        function setInitialCategoryValues() {
            initialCategoryValues = [];
            $('#show_item select[name="category_name[]"]').each(function() {
                initialCategoryValues.push($(this).val());
            });
        }

        // Call the function on document ready to set initial values
        setInitialCategoryValues();

        // Event listener for category name changes
        $('#show_item').on('change', 'select[name="category_name[]"]', function() {
            var currentCategory = $(this).val();
            var index = $(this).data('id');

            // Check if the new category is different from the initial value
            if (initialCategoryValues[index] !== currentCategory) {
                // Hide the duplicate category error
                $('#category_name_err' + index).addClass('d-none');
            }
        });

        $('#submit').click(function() {
            var myButton = document.getElementById('submit');
            // myButton.disabled = true;
            var isValid = true; // Flag to track if all fields are valid
            var selectedCategories = [];



            // Extract form values
            var policy_name = $('#policy_Names').val();
            var policy_editFrom = $('#editFrom').val();
            var policy_editTo = $('#editTo').val();

            // Check if any of the required fields is empty
            if (policy_name.trim() == '' || policy_editFrom.trim() == '' || policy_editTo.trim() ==
                '') {
                myButton.disabled = false;
                isValid = false;
                return true;
            }

            // Loop through each added item
            $('#show_item select[name="category_name[]"]').each(function() {
                var categoryName = $(this).val();

                // Check if the category is already selected
                if (selectedCategories.includes(categoryName)) {
                    isValid = false;
                    // Display an error message for duplicate category
                    // $('#submit').button
                    // document.getElementById("submit").type = '';
                    document.getElementById("submit").disabled = true;
                    $('#category_name_err' + $(this).data('id')).removeClass('d-none');
                } else {
                    // Hide the duplicate category error
                    document.getElementById("submit").type = 'submit';
                    $('#category_name_err' + $(this).data('id')).addClass('d-none');
                }

                // Add the category to the array
                selectedCategories.push(categoryName);
            });

            $('#show_item .row').each(function(index) {
                var categoryName = $(this).find('select[name="category_name[]"]').val();
                var leavCycleMy = $(this).find('select[name="leave_cycle_my[]"]').val();
                var days = $(this).find('input[name="days[]"]').val();
                var unusedLeaveRule = $(this).find('select[name="unused_leave_rule[]"]')
                    .val();

                // Ensure a consistent type for carryForwardLimit
                var carryForwardLimit = (unusedLeaveRule == 1) ? '0' : $(this).find(
                    'input[name="carry_forward_limit_edit[]"]').val();
                var applicableTo = $(this).find('select[name="applicable_to_edit[]"]').val();

                if (!$('#edit_policy').val() || !leavCycleMy || !categoryName || !days || !
                    unusedLeaveRule || !carryForwardLimit || !applicableTo) {
                    isValid = false; // Set the flag to false if any field is empty
                    isCheck = true;
                    return true; // Exit the loop
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

            if (!isValid) {
                // Show an alert or handle error if any field is empty or there are duplicate categories
                return true; // Prevent form submission
            }





            // Define the URL for the AJAX request
            var postURL = "{{ route('admin.leavepolicySubmit') }}";

            // Send the data to the server via AJAX
            // $.ajax({
            //     url: postURL,
            //     method: "POST",
            //     data: $('#form_leave').serialize(), // Serialize the entire form data
            //     type: 'json',
            //     success: function(data) {
            //         if (data.error) {
            //             // Handle error if needed
            //         } else {
            //             // Handle success if needed
            //             // Reset form or perform additional actions
            //             $('#form_leave')[0].reset();
            //         }
            //     }
            // });
            // myButton.disabled = true;

        });

        // $('#submit').click(function() {
        //     var isValid = true; // Flag to track if all fields are valid
        //     var selectedCategories = [];
        //     // Loop through each added item
        //     var policy_name = $('#policy_Names').val();
        //     var policy_editFrom = $('#editFrom').val();
        //     var policy_editTo = $('#editTo').val();

        //     if (policy_name.trim() == '' || policy_editFrom.trim() == '' || policy_editTo.trim() ==
        //         '') {
        //         // $('#policyNameInsert').addClass('required-input');
        //         isValid = false;
        //         return true;
        //     }
        //     var i = 1;
        //     $('#show_item select[name="category_name[]"]').each(function() {
        //         var categoryName = $(this).val();
        //         // Check if the category is already selected
        //         if (selectedCategories.includes(categoryName)) {
        //             isValid = false;
        //             // Swal.fire({
        //             //     title: 'Duplicate Category',
        //             //     text: 'Please select unique categories for each item.',
        //             //     icon: 'error',
        //             // });
        //             // return false; // Exit the loop
        //             $('#category_name_err' + $(this).data('id')).removeClass('d-none');
        //         } else {
        //             // Hide the duplicate category error
        //             $('#category_name_err' + $(this).data('id')).addClass('d-none');
        //         }

        //         // Add the category to the array
        //         selectedCategories.push(categoryName);
        //     });

        //     if (!isValid) {
        //         // Show an alert if any field is empty
        //         // Swal.fire({
        //         //     title: 'Empty Fields',
        //         //     text: 'Please fill in all fields for each item before submitting.',
        //         //     icon: 'error',
        //         // });
        //         return false; // Prevent form submission
        //     }

        //     // if (true) {
        //     //     Swal.fire({
        //     //         title: 'Empty Fields',
        //     //         text: 'Soon .',
        //     //         icon: 'error',
        //     //     });
        //     //     return false; // Prevent form submission

        //     // }
        //     $.ajax({
        //         url: postURL,
        //         method: "POST",
        //         data: $('#add_item_btn').serialize(),
        //         type: 'json',
        //         // dd(data);
        //         success: function(data) {
        //             if (data.error) {
        //                 // Handle error if needed
        //                 return Hello;
        //             } else {
        //                 // Handle success if needed
        //                 i = 1;
        //                 $('.dynamic-added').remove();
        //                 $('#remove_item_btn')[0].reset();
        //             }

        //         }
        //     });
        // });
    });
</script>
{{-- new create Section end --}}

{{-- Edit Section start --}}
<script>
    let LoadName = '';
    // Reloaded Confirm Method All Set by JAYANT
    function openEditModel(context) {
        $('#sandwichLeavesEditId').hide();
        var id = $(context).data('id');
        var editpolicy = $(context).data('policy_name');
        var leave_policy_cycle_monthly = $(context).data('sandwich_leaves_count');

        var leave_policy_cycle_yearly = $(context).data('sandwich_leaves_ignore');

        var leave_period_from = $(context).data('leave_period_from');
        var leave_period_to = $(context).data('leave_period_to');
        // var myButton = document.getElementById('updateButton');
        // myButton.disabled = true;
        if (leave_policy_cycle_yearly == 2) {
            $('#btnradioyearsedit').prop('checked', true);
            $('#btnradiomonthsedit').prop('checked', false);
        }
        if (leave_policy_cycle_monthly == 1) {
            $('#btnradiomonthsedit').prop('checked', true);
            $('#btnradioyearsedit').prop('checked', false);
        }
        $('#showmodal').modal('show');
        $('#rolesId').val(id);
        $('#edit_policy').val(editpolicy);
        $('input[name="btnradio"]').prop('checked', false); // Uncheck all radio buttons
        if (leave_policy_cycle_monthly == 1) {
            $('input[name="btnradiomonths"]').prop('checked', true); // Check Monthly radio button
            $('input[name="btnradioyears"]').prop('checked', false); // Check Monthly radio button
        }
        if (leave_policy_cycle_yearly == 2) {
            $('input[name="btnradioyears"]').prop('checked', true); // Check Yearly radio button
            $('input[name="btnradiomonths"]').prop('checked', false); // Check Monthly radio button
        }
        $('#leave_periodfrom2').val(leave_period_from.substr(0, 7));
        // $('#leave_periodfrom2').val(leave_period_from);
        // $('#leave_periodto2').val(leave_period_to);
        $('#leave_periodto2').val(leave_period_to.substr(0, 7));

        // Open the modal
        $.ajax({
            url: "{{ url('/admin/settings/business/all_leave_policy') }}",
            type: "get",
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
        $('#sandwichLeavesViewId').hide();
        var id = $(context).data('id');
        var editpolicy = $(context).data('policy_name');
        var leave_policy_cycle_monthly = $(context).data('sandwich_leaves_count');

        var leave_policy_cycle_yearly = $(context).data('sandwich_leaves_ignore');

        var leave_period_from = $(context).data('leave_period_from');
        var leave_period_to = $(context).data('leave_period_to');

        if (leave_policy_cycle_yearly == 2) {
            $('#btnradioyearseditview').prop('checked', true);
            $('#btnradiomonthseditview').prop('checked', false);
        }
        if (leave_policy_cycle_monthly == 1) {
            $('#btnradiomonthseditview').prop('checked', true);
            $('#btnradioyearseditview').prop('checked', false);
        }
        $('#viewshowmodal').modal('show');

        $('#rolesIdview').val(id);
        $('#edit_policyview').val(editpolicy);
        $('input[name="btnradio"]').prop('checked', false); // Uncheck all radio buttons
        if (leave_policy_cycle_monthly == 1) {
            $('input[name="btnradiomonths"]').prop('checked', true); // Check Monthly radio button
            $('input[name="btnradioyears"]').prop('checked', false); // Check Monthly radio button
        }
        if (leave_policy_cycle_yearly == 2) {
            $('input[name="btnradioyears"]').prop('checked', true); // Check Yearly radio button
            $('input[name="btnradiomonths"]').prop('checked', false); // Check Monthly radio button
        }
        $('#leave_periodfrom2view').val(leave_period_from.substr(0, 7));
        // $('#leave_periodfrom2').val(leave_period_from);
        // $('#leave_periodto2').val(leave_period_to);
        $('#leave_periodto2view').val(leave_period_to.substr(0, 7));

        // Open the modal
        $.ajax({
            url: "{{ url('/admin/settings/business/all_leave_policy') }}",
            type: "get",
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

    // this fucntion directly run openeditmodel button click pe popover set karne ke liye
    function leaveCategoryCheckEdit(name, itemId, description) {
        var popoverSelector = $('#descirpitonEdit' + itemId);
        popoverSelector.attr('data-bs-content', '<div style="text-align: justify;">' + description + '</div>');
        // popoverSelector.attr('data-bs-content', description);
        popoverSelector.attr('title', name);
        // Destroy and recreate the popover to reflect the updated content
        popoverSelector.popover('dispose').popover({
            trigger: 'hover',
            delay: {
                show: 100, // Set the delay for showing the popover (in milliseconds)
                hide: 100 // Set the delay for hiding the popover (in milliseconds)
            }
        });
    }

    // leave category edit check this function
    function LeaveCategoryCheckEdit1(context) {
        var value = context.value;
        var id = $(context).data('id');
        var selectedOption = $(context).find(':selected');
        var description = selectedOption.data('description');
        var name = selectedOption.data('name');
        var popoverSelector = $('#descirpitonEdit' + id);
        popoverSelector.attr('data-bs-content', '<div style="text-align: justify;">' + description + '</div>');
        popoverSelector.attr('title', name);
        popoverSelector.popover('dispose').popover({
            html: true, // Set to true if your content has HTML

        });
        setTimeout(function() {
            popoverSelector.popover('hide');
        }, 2000);
        var leaveCycleDropdown = document.getElementById('leave_cycle_edit' + id);
        var unusedLeaveRuleDropdown = document.getElementById('leaverules_edit' + id);
        var leaveDay = document.getElementById('leave_day_edit' + id);
        var leaveCFL = document.getElementById('carryForwardLimitEdit' + id);
        var leaveApplicabel = document.getElementById('applicable_to_edit' + id);
        var applicableTo = document.getElementById('applicable_to_edit' + id);
        console.log("applicableTo ", applicableTo, context.value, id);
        applicableTo.innerHTML = '';
        unusedLeaveRuleDropdown.innerHTML = '';
        leaveCycleDropdown.innerHTML = '';
        (leaveDay != null) ? leaveDay.value = '': '';
        leaveCFL.value = '';
        (leaveApplicabel != null) ? leaveApplicabel.value = '': '';
        if ((value == 6) || (value == 7)) {
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            if (leaveDay != null) {
                leaveDay.value = '';
                leaveCFL.disabled = true;
                // leaveDay.setAttribute('max', '366');
                // leaveDay.setAttribute('maxlength', '3');
                addOption(applicableTo, "", "Select Applicable To", true);
                addOption(applicableTo, "1", "All");
                addOption(applicableTo, "2", "Male");
                addOption(applicableTo, "3", "Female");
                addOption(applicableTo, "4", "Male & Other");
            }
            leaveDay.disabled = false;
        } else if (value == 4) {
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            if (leaveDay != null) {
                leaveDay.value = '';
                leaveCFL.disabled = true;
            }
            addOption(applicableTo, "3", "Female");
            leaveDay.disabled = false;
        } else if (value == 5) {
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            addOption(applicableTo, "4", "Male & Other");

            if (leaveDay != null) {
                leaveDay.value = '';
                leaveCFL.disabled = true;
                leaveDay.setAttribute('max', '366');
                leaveDay.setAttribute('maxlength', '3');
            }
        } else {
            addOption(leaveCycleDropdown, "", "Select Leave Cycle", true);
            addOption(leaveCycleDropdown, "1", "Monthly");
            addOption(leaveCycleDropdown, "2", "Yearly");
            addOption(unusedLeaveRuleDropdown, "", "Select Leave Rule", true);
            addOption(unusedLeaveRuleDropdown, "1", "Lapse");
            addOption(unusedLeaveRuleDropdown, "2", "Carry Forward");
            addOption(applicableTo, "", "Select Applicable To", true);
            addOption(applicableTo, "1", "All");
            addOption(applicableTo, "2", "Male");
            addOption(applicableTo, "3", "Female");
            addOption(applicableTo, "4", "Male & Other");
        }
    }

    function checkMaxValueEdit(context) {
        var id = $(context).data('id');
        var value = context.value;
        var leaveCycle = document.getElementById('leave_cycle_edit' + id).value;
        var myButton = document.getElementById('updateButton');
        var leaveDays = Number(leaveCycle) == 1 ? '31' : '366';
        var leaveDaysNumber = Number(leaveDays);
        var valueNumber = Number(value);
        var dayErr = document.getElementById('days_err_edit' + id);
        var dayErr1 = document.getElementById('days_err_edit1' + id);
        var decimalPart = value - Math.floor(value);
        if (!isNaN(leaveDaysNumber) && !isNaN(valueNumber)) {
            if (leaveDaysNumber < valueNumber) { // value gerter
                // myButton.disabled = true;
                dayErr.classList.remove('d-none');
                dayErr1.classList.add('d-none');
                context.value = leaveDaysNumber;
            } else if ((decimalPart == 0.5) || (decimalPart == 0)) {
                myButton.disabled = false;
                dayErr.classList.add('d-none');
                dayErr1.classList.add('d-none');

            } else if (decimalPart != 0.5) {
                myButton.disabled = true;
                dayErr1.classList.remove('d-none');

            } else if (leaveDaysNumber >= valueNumber) {
                myButton.disabled = false;
                dayErr.classList.add('d-none');
            }
        } else {
            // Handle the case where either leaveDays or value is not a valid number
            console.error("leaveDays and value must be convertible to numbers");
        }

    }

    // edit carryforwardlimit valid value check
    function checkLimitMaxValueEdit(input) {
        var value = input.value;
        var id = $(input).data('id');
        var leaveDays = document.getElementById('leave_day_edit' + id).value;
        var myButton = document.getElementById('updateButton');
        var cflimitErr = document.getElementById('cflimit_err_edit' + id);
        var cflimitErr1 = document.getElementById('cflimit_err_edit1' + id);
        var leaveDaysNumber = Number(leaveDays);
        var valueNumber = Number(value);
        var decimalPart = value - Math.floor(value);
        if (!isNaN(leaveDaysNumber) && !isNaN(valueNumber)) {
            if (leaveDaysNumber < valueNumber) { // value gerter
                // myButton.disabled = true;
                cflimitErr.classList.remove('d-none');
                cflimitErr1.classList.add('d-none');
                input.value = leaveDaysNumber;
            } else if ((decimalPart == 0.5) || (decimalPart == 0)) {
                myButton.disabled = false;
                cflimitErr.classList.add('d-none');
                cflimitErr1.classList.add('d-none');

            } else if (decimalPart != 0.5) {
                myButton.disabled = true;
                cflimitErr1.classList.remove('d-none');

            } else if (leaveDaysNumber >= valueNumber) {
                myButton.disabled = false;
                cflimitErr.classList.add('d-none');
            }
        } else {
            // Handle the case where either leaveDays or value is not a valid number
            console.error("leaveDays and value must be convertible to numbers");
        }
    }

    function unusedLeaveRuleEdit(context) {
        var value = context.value;
        var id = $(context).data('id');
        if (value == 2) {
            $('#carryForwardLimitEdit' + id).prop('disabled', false);
        } else {
            $('#carryForwardLimitEdit' + id).val('');
            $('#carryForwardLimitEdit' + id).prop('disabled', true);
        }
    }

    function leaveCycleCheckEdit(context) {
        var value = context.value;
        var id = $(context).data('id');
        var unusedLeaveRuleDropdown = document.getElementById('leaverules_edit' + id);
        var leaveDay = document.getElementById('leave_day_edit' + id);
        var leaveCFL = document.getElementById('carryForwardLimitEdit' + id);
        unusedLeaveRuleDropdown.value = '';
        // leaveCycleDropdown.innerHTML = '';
        leaveDay.value = '';
        leaveCFL.value = '';
        leaveDay.disabled = false;
        leaveCFL.disabled = true;
    }

    function appendViewFormItem(item) {
        // Extract values from the 'item' object
        var id = item.id;
        var description = item.description;
        var static_category_name = item.static_category_name;
        var categoryName = item.category_name;
        var leaveCycleMY = item.leave_cycle_monthly_yearly;
        var days = item.days;
        var unusedLeaveRule = item.unused_leave_rule;
        var carryForwardLimit = item.carry_forward_limit;
        var applicableTo = item.applicable_to;
        var newItemHtml = `<div class="row rowrowedit" disabled>
                    <div class="col-xl-2 pt-3">
                        <label for="inputCity" class="form-label">Category Name
                            <small style="background-color:transparent;" id="descirpitonEdit${id}" class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                data-bs-container="body"
                                data-bs-content=""
                                data-bs-placement="right" data-bs-popover-color="primary"
                                data-bs-toggle="popover" data-bs-html=true title="">
                                <i style="background-color:none;" class="fa fa-info-circle"></i>
                            </small>
                        </label>
                        <select onchange="LeaveCategoryCheckEdit1(this)" data-id=${id} name="category_name_edit[]" class="form-control" id="category_name_edit${id}" placeholder="Category Name" required disabled>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($leaveType as $leaveItem)
                                <option data-name="{{ $leaveItem->name }}" data-description="{{ $leaveItem->description }}" value="{{ $leaveItem->id }}" ${categoryName == {{ $leaveItem->id }} ? 'selected': ''} >{{ $leaveItem->name }}</option>
                            @endforeach
                            </select>
                            <span id="category_name_err_edit${id}" data-id="${id}" class="text-danger d-none fs-10">Category Name can't be same</span>
                    </div>
                    <div class="col-xl-2 pt-3" disabled>
                            <label for="inputCity" class="form-label ">Leave Cycle  <small style="background-color:transparent;" class="badge badge-info-light" data-bs-trigger="hover"
                                            data-bs-container="body"
                                            data-bs-content="Monthly limit should not exeeds more than 31 & Yearly limit should not exceed more than 366."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Leave Cycle"><i
                                                class="fa fa-info-circle"></i></small></label>
                            <select onchange="leaveCycleCheckEdit(this)" name="leave_cycle_my_edit[]"  id="leave_cycle_edit${id}" class="form-control" data-id="${id}" required disabled>
                                <option value="" disabled selected>Select Leave Cycle</option>
                                <option value="1" ${leaveCycleMY == '1' ? 'selected': ''} >Monthly</option>
                                <option value="2" ${leaveCycleMY == '2' ? 'selected': ''} >Yearly</option>
                            </select>
                    </div>
                    <div class="col-xl-2 pt-3">
                        <label for="inputCity" class="form-label">Days <small class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                            style="background-color:transparent;" data-bs-container="body"
                                            data-bs-content="Day count should be in a valid format. For example, it should be either 1 or 1.5 only."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Days"><i
                                                class="fa fa-info-circle"></i></small></label>
                        <input type="number" step="0.5" name="days_edit[]" id="leave_day_edit${id}" oninput="checkMaxValueEdit(this)" data-id="${id}" value="${days}" id="leave_day_edit${id}" min="1" class="form-control bg-muted" placeholder="Count" required disabled>
                        <span class="text-danger d-none fs-10" id="days_err_edit${id}">Limit can't be greater than day count</span>
                        <span class="text-danger d-none fs-10" id="days_err_edit1${id}">Invalid count</span>
                    </div>
                    <div class="col-xl-2 pt-3 bg-muted">
                        <label for="inputState" class="form-label">Unused Leave Rule</label>
                        <select id="leaverules_edit${id}" class="form-control select2" name="unused_leave_rule_edit[]" onchange="unusedLeaveRuleEdit(this)" data-id="${id}" data-placeholder="Leave Rule"  required disabled>
                            <option value="" selected disabled>Select Leave Rule</option>
                            <option value="1" ${unusedLeaveRule == '1' ? 'selected' : ''}>Lapse</option>
                            <option  value="2" ${unusedLeaveRule == '2' ? 'selected' : ''}>Carry Forward</option>
                        </select>
                    </div>
                    <div class="col-xl-2 pt-3">
                        <label for="inputCity" class="form-label">Carry Forward Limit</label>
                        <input name="carry_forward_limit_edit[]" id="carryForwardLimitEdit${id}" min="0" type="number" step="0.5" oninput="checkLimitMaxValueEdit(this)" data-id="${id}" min="1"  value="${carryForwardLimit != '0' ? carryForwardLimit:''}" ${unusedLeaveRule == '1' ? 'disabled' : ''} class="form-control" placeholder="Days" required disabled>
                        <span class="text-danger d-none fs-10" id="cflimit_err_edit${id}">Limit can't be greater than day count</span>
                            <span class="text-danger d-none fs-10" id="cflimit_err_edit1${id}">Invalid Count Value</span>
                    </div>
                    <div class="col-xl-2 pt-3">
                        <label for="inputState" class="form-label">Applicable To</label>
                        <select class="form-control select2" data-id="${id}" id="applicable_to_edit1${id}" name="applicable_to_edit[]" data-placeholder="Applicable To" required disabled>
                            <option label="" value="" disabled selected>Select Applicable To</option>
                                @foreach ($applicableTo as $item)
                                    <option  value={{ $item->id }}  ${applicableTo == {{ $item->id }} ? 'selected' : ''}>{{ $item->name }}</option>
                                @endforeach
                        </select>
                    </div>


                </div>`;

        $('#show_item_edit_view').append(newItemHtml);
        leaveCategoryCheckEdit(static_category_name, id, description);
        // $('[data-bs-toggle="popover"]').popover({
        //     trigger: 'hover'
        // });
        if (leaveCycleMY == 1) {
            // $('#leave_days_edit' + id).val('reset');
            // $('#leave_days_edit' + id).prop('disabled', false);
            $('#leave_days_edit' + id).prop('max', 30); // Set max attribute to 30 for monthly leave cycle
            $('#leave_days_edit' + id).attr('maxlength', 2);
        } else if (leaveCycleMY == 2) {
            // $('#leave_days_edit' + id).val('reset');
            // $('#leave_days_edit' + id).prop('disabled', false);
            $('#leave_days_edit' + id).prop('max', 365); // Set max attribute to 365 for yearly leave cycle
            $('#leave_days_edit' + id).attr('maxlength', 3);
        }
    }


    function appendEditFormItem(item) {
        // Extract values from the 'item' object
        var id = item.id;
        var description = item.description;
        var static_category_name = item.static_category_name;
        var categoryName = item.category_name;
        var leaveCycleMY = item.leave_cycle_monthly_yearly;
        var days = item.days;
        var unusedLeaveRule = item.unused_leave_rule;
        var carryForwardLimit = item.carry_forward_limit;
        var applicableTo = item.applicable_to;
        var newItemHtml = `<div class="row rowrowedit" disabled>
                    <div class="col-xl-2 pt-3">
                        <label for="inputCity" class="form-label">Category Name
                            <small style="background-color:transparent;" id="descirpitonEdit${id}" class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                data-bs-container="body"
                                data-bs-content=""
                                data-bs-placement="right" data-bs-popover-color="primary"
                                data-bs-toggle="popover" data-bs-html=true title="">
                                <i style="background-color:none;" class="fa fa-info-circle"></i>
                            </small>
                        </label>
                        <select onchange="LeaveCategoryCheckEdit1(this)" data-id=${id} name="category_name_edit[]" class="form-control" id="category_name_edit${id}" placeholder="Category Name" required >
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($leaveType as $leaveItem)
                                <option data-name="{{ $leaveItem->name }}" data-description="{{ $leaveItem->description }}" value="{{ $leaveItem->id }}" ${categoryName == {{ $leaveItem->id }} ? 'selected': ''} >{{ $leaveItem->name }}</option>
                            @endforeach
                            </select>
                            <span id="category_name_err_edit${id}" data-id="${id}" class="text-danger d-none fs-10">Category Name can't be same</span>
                    </div>
                    <div class="col-xl-2 pt-3" disabled>
                            <label for="inputCity" class="form-label ">Leave Cycle  <small style="background-color:transparent;" class="badge badge-info-light" data-bs-trigger="hover"
                                            data-bs-container="body"
                                            data-bs-content="Monthly limit should not exeeds more than 31 & Yearly limit should not exceed more than 366."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Leave Cycle"><i
                                                class="fa fa-info-circle"></i></small></label>
                            <select onchange="leaveCycleCheckEdit(this)" name="leave_cycle_my_edit[]"  id="leave_cycle_edit${id}" class="form-control" data-id="${id}" required >
                                <option value="" disabled selected>Select Leave Cycle</option>
                                <option value="1" ${leaveCycleMY == '1' ? 'selected': ''} >Monthly</option>
                                <option value="2" ${leaveCycleMY == '2' ? 'selected': ''} >Yearly</option>
                            </select>
                    </div>
                    <div class="col-xl-1 pt-3">
                        <label for="inputCity" class="form-label">Days <small class="m-0 badge badge-info-light" data-bs-trigger="hover"
                                            style="background-color:transparent;" data-bs-container="body"
                                            data-bs-content="Day count should be in a valid format. For example, it should be either 1 or 1.5 only."
                                            data-bs-placement="right" data-bs-popover-color="primary"
                                            data-bs-toggle="popover" data-bs-html=true title="Days"><i
                                                class="fa fa-info-circle"></i></small></label>
                        <input type="number" step="0.5" name="days_edit[]" id="leave_day_edit${id}" oninput="checkMaxValueEdit(this)" data-id="${id}" value="${days}" id="leave_day_edit${id}" min="1" class="form-control bg-muted" placeholder="Count" required >
                        <span class="text-danger d-none fs-10" id="days_err_edit${id}">Limit can't be greater than day count</span>
                        <span class="text-danger d-none fs-10" id="days_err_edit1${id}">Invalid count</span>
                    </div>
                    <div class="col-xl-2 pt-3 bg-muted">
                        <label for="inputState" class="form-label">Unused Leave Rule</label>
                        <select id="leaverules_edit${id}" class="form-control select2" name="unused_leave_rule_edit[]" onchange="unusedLeaveRuleEdit(this)" data-id="${id}" data-placeholder="Leave Rule"  required >
                            <option value="" selected disabled>Select Leave Rule</option>
                            <option value="1" ${unusedLeaveRule == '1' ? 'selected' : ''}>Lapse</option>
                            <option  value="2" ${unusedLeaveRule == '2' ? 'selected' : ''}>Carry Forward</option>
                        </select>
                    </div>
                    <div class="col-xl-2 pt-3">
                        <label for="inputCity" class="form-label">Carry Forward Limit</label>
                        <input name="carry_forward_limit_edit[]" id="carryForwardLimitEdit${id}" min="0" type="number" step="0.5" oninput="checkLimitMaxValueEdit(this)" data-id="${id}" min="1"  value="${carryForwardLimit != '0' ? carryForwardLimit:''}" ${unusedLeaveRule == '1' ? 'disabled' : ''} class="form-control" placeholder="Days" required >
                        <span class="text-danger d-none fs-10" id="cflimit_err_edit${id}">Limit can't be greater than day count</span>
                            <span class="text-danger d-none fs-10" id="cflimit_err_edit1${id}">Invalid Count Value</span>
                    </div>
                    <div class="col-xl-2 pt-3">
                        <label for="inputState" class="form-label">Applicable To</label>
                        <select class="form-control select2" data-id="${id}" id="applicable_to_edit${id}" name="applicable_to_edit[]" data-placeholder="Applicable To" required >
                            <option label="" value="" disabled selected>Select Applicable To</option>
                                @foreach ($applicableTo as $item)
                                    <option  value={{ $item->id }}  ${applicableTo == {{ $item->id }} ? 'selected' : ''}>{{ $item->name }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="col-xl-1 pt-3 text-end">
                        <label for="inputCity" class="form-label ">&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-danger remove_item_btn_edit"><i class="feather feather-trash"></i></button>
                    </div>
                </div>`;

        $('#show_item_edit').append(newItemHtml);
        leaveCategoryCheckEdit(static_category_name, id, description);
        // $('[data-bs-toggle="popover"]').popover({
        //     trigger: 'hover'
        // });
        if (leaveCycleMY == 1) {
            // $('#leave_days_edit' + id).val('reset');
            // $('#leave_days_edit' + id).prop('disabled', false);
            $('#leave_days_edit' + id).prop('max', 30); // Set max attribute to 30 for monthly leave cycle
            $('#leave_days_edit' + id).attr('maxlength', 2);
        } else if (leaveCycleMY == 2) {
            // $('#leave_days_edit' + id).val('reset');
            // $('#leave_days_edit' + id).prop('disabled', false);
            $('#leave_days_edit' + id).prop('max', 365); // Set max attribute to 365 for yearly leave cycle
            $('#leave_days_edit' + id).attr('maxlength', 3);
        }
    }

    var initialCategoryValues = []; // Array to store initial category values

    // Function to set initial category values
    function setInitialCategoryValues() {
        initialCategoryValues = [];
        $('#show_item_edit select[name="category_name_edit[]"]').each(function() {
            initialCategoryValues.push($(this).val());
        });
    }

    // Call the function on document ready to set initial values
    setInitialCategoryValues();

    // Event listener for category name changes
    $('#show_item_edit').on('change', 'select[name="category_name_edit[]"]', function() {
        var currentCategory = $(this).val();
        var index = $(this).data('id');

        // Check if the new category is different from the initial value
        if (initialCategoryValues[index] !== currentCategory) {
            // Hide the duplicate category error
            $('#category_name_err_edit' + index).addClass('d-none');
        }
    });

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

                // Swal.fire({
                //     // text: 'Are you sure want to Update?',
                //     title: '<b class="fs-18">Are you sure want to Update? <b><br><br><p class="fs-18">Changing the leave policy will remove or change the currently assigned leave. Balance will reset to zero and new balance will start to appear from the new leave update. Do you wish to proceed?</p>',
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonColor: '#1877F2',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Update',
                //     reverseButtons: true,

                // }).then((result) => {
                //     if (result.isConfirmed) {
                //         $('#form_leave_edit').submit();
                //     } else {
                //         $('#showmodal').modal('show');

                //     }
                // });

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

    // $('#updateButton').click(function() {
    //     // Gather the updated data from the edited items
    //     var updatedItems = [];
    //     var isValid = true; // Flag to track if all fields are valid

    //     $('#show_item_edit .row').each(function(index) {
    //         var categoryName = $(this).find('select[name="category_name_edit[]"]').val();
    //         var leavCycleMy = $(this).find('select[name="leave_cycle_my_edit[]"]').val();
    //         var days = $(this).find('input[name="days_edit[]"]').val();
    //         var unusedLeaveRule = $(this).find('select[name="unused_leave_rule_edit[]"]').val();
    //         var carryForwardLimit = ((unusedLeaveRule == 1) ? '0' : ($(this).find(
    //             'input[name="carry_forward_limit_edit[]"]').val()));
    //         var applicableTo = $(this).find('select[name="applicable_to_edit[]"]').val();
    //         if (!$('#edit_policy').val() || !leavCycleMy || !categoryName || !days || !
    //             unusedLeaveRule || !
    //             carryForwardLimit || !applicableTo) {
    //             isValid = false; // Set the flag to false if any field is empty
    //             return false; // Exit the loop
    //         }
    //         // Create an object to represent the updated item
    //         var updatedItem = {
    //             category_name: categoryName,
    //             leav_Cycle_My: leavCycleMy,
    //             days: days,
    //             unused_leave_rule: unusedLeaveRule,
    //             carry_forward_limit: carryForwardLimit,
    //             applicable_to: applicableTo,
    //         };
    //         updatedItems.push(updatedItem);
    //     });
    //     var selectedCategories = [];
    //     $('#show_item_edit select[name="category_name_edit[]"]').each(function() {
    //         var categoryName = $(this).val();

    //         if (selectedCategories.includes(categoryName)) {
    //             isValid1 = false;
    //             // Display an error message for duplicate category
    //             $('#category_name_err_edit' + $(this).data('id')).removeClass('d-none');
    //         } else {
    //             // Hide the duplicate category error
    //             $('#category_name_err_edit' + $(this).data('id')).addClass('d-none');
    //         }

    //         // Add the category to the array
    //         selectedCategories.push(categoryName);
    //     });



    //     if (!isValid) {
    //         // Show an alert if any field is empty
    //         // Swal.fire({
    //         //     title: 'Empty Fields',
    //         //     text: 'Please fill in all fields for each item before updating.',
    //         //     icon: 'error',
    //         // });
    //         return true;

    //         // return false; // Prevent form submission
    //     } else {
    //         // Send the updated data to the server via AJAX
    //         $.ajax({
    //             url: "{{ url('/admin/settings/business/update_leave_policy') }}",
    //             type: "POST",
    //             data: {
    //                 _token: '{{ csrf_token() }}',
    //                 leave_policy_id: $('#rolesId').val(),
    //                 leave_name: $('#edit_policy').val(),
    //                 updated_items: updatedItems // Send the array of updated items to the server
    //             },
    //             dataType: 'json',
    //             success: function(result) {
    //                 if (result.message != false) {
    //                     Swal.fire({
    //                         timer: 2000,
    //                         timerProgressBar: true,
    //                         title: 'Update Successful',
    //                         text: 'Your data has been updated successfully.',
    //                         icon: 'success',
    //                     }).then(() => {
    //                         // Reload the page after the alert is closed
    //                         location.reload();
    //                     });
    //                 } else {
    //                     Swal.fire({
    //                         title: 'Update Failed',
    //                         timer: 3000,
    //                         timerProgressBar: true,
    //                         text: 'There was an error updating your data.',
    //                         icon: 'error',
    //                     });
    //                 }
    //             }
    //         });
    //     }
    // });
    // temporary clone data set
    $(document).ready(function() {
        $(".add_item_btn_edit").click(function(e) {
            if (!validatePreviousRowEdit()) {
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
                            @foreach ($leaveType as $item)
                                <option data-name="{{ $item->name }}" data-description="{{ $item->description }}" value={{ $item->id }}>{{ $item->name }}</option>
                            @endforeach </select>
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
                            <label for="inputState" class="form-label">Applicable To test</label>
                            <select data-id="${leave_id}" class="form-control select2" id="applicable_to_edit${leave_id}" name="applicable_to_edit[]" required>
                                <option label="" value="" disabled selected>Select Applicable To</option>
                                @foreach ($applicableTo as $item)
                                    <option  value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-1 pt-3 text-end">
                            <label for="inputCity" class="form-label ">&nbsp;</label>
                            <button type="button" class="btn btn-sm btn-danger remove_item_btn_edit"><i class="feather feather-trash"></i></button>
                        </div>
                    </div> `
            );

            leave_id++;

            function validatePreviousRowEdit() {
                var lastRow = $("#show_item_edit .row:last");
                var categorySelect = lastRow.find('select[name="category_name_edit[]"]');
                var leaveCycleSelect = lastRow.find('select[name="leave_cycle_my_edit[]"]');
                var daysInput = lastRow.find('input[name="days_edit[]"]');
                var leaveRuleSelect = lastRow.find('select[name="unused_leave_rule_edit[]"]');
                var carryForwardLimitInput = lastRow.find('input[name="carry_forward_limit_edit[]"]');
                var applicableToSelect = lastRow.find('select[name="applicable_to_edit[]"]');
                // Check if any of the fields in the last row is empty
                return (
                    categorySelect.val() !== "" &&
                    leaveCycleSelect.val() !== "" &&
                    daysInput.val() !== "" &&
                    (
                        (leaveRuleSelect.val() !== "" &&
                            carryForwardLimitInput.val() !== "") || (leaveRuleSelect.val() ==
                            "1") ||
                        (leaveRuleSelect.val() == "2" && carryForwardLimitInput.val() !== "")
                    ) &&
                    applicableToSelect.val() !== ""
                );
            }
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
{{-- end updated Section --}}
@endsection
