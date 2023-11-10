@extends('admin.pagelayout.master')
@section('title')
    Business | Leave Policy
@endsection

@section('css')
@endsection
@section('content')
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
            background: #1877f2;
            color: white;
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

    @php

        // $Employee = App\Helpers\Central_unit::EmployeeDetails();
        $Central = new App\Helpers\Central_unit();

        $Employee = $Central::EmployeeDetails();
        $Department = $Central->DepartmentList();
        $Designation = $Central::DesignationList();
        // dd($Designation);
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        // dd($Employee);
        // $i = 0;
        // $male = 0;
        // $female = 0;
        // foreach ($Employee as $key => $value) {
        // // dd($value);
        // $i++;
        // if ($value->emp_gender == 1) {
        // $male++;
        // } elseif ($value->emp_gender == 2) {
        // $female++;
        // }
        // }
    @endphp

    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/business')}}">Settings</a></li> --}}
            <li><a href="{{ url('admin/settings/business') }}">Business Setting</a></li>
            <li class="active"><span><b>Leave Policy</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Leave Policy</div>
            <p class="text-muted m-0">Create Template to give leaves to staff on month if they want</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Create Templates
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                            style="color:white">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.leavepolicySubmit') }}" method="POST">
                        <div class="modal-body  m-5">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Settddding</span></h4>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                    <div class="col">
                                        <input type="text" class="form-control bg-muted form-label" id="inputName"
                                            placeholder="Enter Template Name" name="policyname" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Leave Policy
                                        Cycle</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check btnradiomonthyear" onclick="checkGet()"
                                                name="btnradio" id="btnradiomonth" value="1" checked>
                                            <label class="btn btn-outline-primary" for="btnradiomonth">Monthly</label>
                                            <input type="radio" class="btn-check btnradiomonthyear" onclick="checkGet()"
                                                name="btnradio" id="btnradioyear" value="2">
                                            <label class="btn btn-outline-primary" for="btnradioyear">Yearly</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                    <div class="form-row col-xl-5">
                                        <input type="date" class="form-control col-xl-4" name="leave_periodfrom"
                                            id="editFrom" required>
                                        <label class="col-xl-1" for="">To</label>
                                        <input type="date" class="form-control col-xl-4 " name="leave_periodto"
                                            id="editTo" required>
                                    </div>
                                </div>
                            </div>

                            <hr style="background: black" />
                            <div class="row ">
                                <div class="d-flex col-sm-10">
                                    <h4 class="card-title"><span>Leave Category</span></h4>

                                </div>
                                <div class="col-sm-2 text-end">
                                    <button type="button" class="btn btn-outline-primary add_item_btn"><i
                                            class="fe fe-plus bold"></i>
                                    </button>
                                </div>


                                <span id="show_item">

                                </span>

                            </div>

                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <div class="text-center">
                                <button class="btn btn-success" type="submit" name="" id="submit"
                                    data-bs-target="">Apply</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    {{-- <div class="col-lg-12"> --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Leave Policy List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
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
                                    {{ $item->leave_policy_cycle_monthly == 1 ? 'Monthly' : 'Yearly' }}
                                </td>
                                <td class="font-weight-semibold">
                                    @foreach ($Central->LeavePolicyCategory($item->id) as $check)
                                        <div class="row">
                                            <div class="tags p-0">
                                                <span class="tag tag-rounded"> {{ $check->category_name }} &nbsp;
                                                </span>
                                                <span class="tag tag-rounded">
                                                    {{ $check->applicable_to }}
                                                </span>

                                            </div>
                                        </div>
                                    @endforeach
                                </td>

                                <td>
                                    <a class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="openEditModel(this)" data-id='<?= $item->id ?>'
                                        data-policy_name='<?= $item->policy_name ?>'
                                        data-leave_policy_cycle_monthly='<?= $item->leave_policy_cycle_monthly ?>'
                                        data-leave_policy_cycle_yearly='<?= $item->leave_policy_cycle_yearly ?>'
                                        data-leave_period_from='<?= $item->leave_period_from ?>'
                                        data-leave_period_to='<?= $item->leave_period_to ?>' data-bs-toggle="modal"
                                        data-bs-target="#showmodal">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>

                                    <button id="deleteButton" class="btn action-btns  btn-danger btn-icon btn-sm"
                                        data-toggle="modal" onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>'
                                        data-policy_name='<?= $item->policy_name ?>' data-target="#deleteModal"
                                        data-id="1"><i class="feather feather-trash"></i></button>


                                    {{-- <a class="btn btn-sm btn-danger" onclick="ItemDeleteModel(this)"
                                    data-bs-toggle="modal" data-bs-target="#leavePolicyDeletebtn" id="PolicyDeletebtn"
                                    title="Edit">
                                    <i class="feather feather-trash"></i>
                                </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- </div> --}}

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="showmodal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Edit Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body  m-5">
                        <div class="row">
                            <input type="text" name="role" id="rolesId" hidden>
                            <div class="col">
                                <h4 class="card-title"><span>Leave Setting</span></h4>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                <div class="col">
                                    <input type="text" class="form-control bg-muted form-label" name="edit_policys"
                                        id="edit_policy" placeholder="Enter Leave Policy Template Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave Policy
                                    Cycle</label>
                                <div class="col-sm-5">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" value="1" name="btnradiomonths"
                                            aria-disabled="true" disabled>
                                        <label class="btn btn-outline-primary" for="btnradiomonths">Monthly</label>
                                        <input type="radio" class="btn-check" value="2" name="btnradioyears"
                                            aria-disabled="true" disabled>
                                        <label class="btn btn-outline-primary" for="btnradioyears">Yearly</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                <div class="form-row col-xl-5">
                                    <input type="date" class="form-control col-xl-4" id="leave_periodfrom2"
                                        aria-disabled="true" disabled>
                                    <label class="col-xl-1" for="">To</label>
                                    <input type="date" class="form-control col-xl-4 " id="leave_periodto2"
                                        aria-disabled="true" disabled>
                                </div>
                            </div>
                        </div>
                        <hr style="background: black" />
                        <div class="row ">
                            <div class="d-flex col-sm-10">
                                <h4 class="card-title"><span>Leave Category</span></h4>
                            </div>
                            <div class="col-sm-2 text-end">
                                <button type="button" class="btn btn-outline-primary add_item_btn_edit"><i
                                        class="fe fe-plus bold"></i>
                                </button>
                            </div>
                            <span id="show_item_edit">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="text-center">
                            <button class="btn btn-success" type="submit" name="" id="updateButton"
                                data-bs-target="">Apply</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{ route('delete.leavePolicy') }}" method="post">
                    @csrf
                    <input type="text" id="poli_id" name="poli_id" hidden>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Policy Name <b>
                            </b></p>
                        <h4 id="assign_emp"></h4><b>
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

    <script>
        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var assign = $(context).data('policy_name');
            // console.log(assign);
            $('#poli_id').val(id);
            $('#assign_emp').text(assign);
        }
    </script>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- new create Section --}}
    <script>
        var leave_id = 1;
        $(document).ready(function() {
            var postURL = "<?php echo url('policy_sumbit'); ?>";
            $(".add_item_btn").click(function(e) {

                // e.preventDefault();
                let categoryname = $('#categoryname').val();
                let days = $('#days').val();
                // console.log("days ",days);   
                let leaverule = $('#leaverule').val();
                let cfl = $('#cfl').val();
                let applicable = $('#applicable').val();
                // leave_id = document.getElementById('cfl').value;<option>Encash</option>
                // console.log(categoryname, days, leaverule, cfl, applicable);
                $("#show_item").append(
                    `<div class="row">
                        <div class="card-body col-xl-3 pt-3" name="leave_id" id="' + leave_id +'" > 
                            <label for="inputCity" class="form-label">Category Name</label> 
                            <input type="text" name="category_name[]" value="" class="form-control" id="inputCity" placeholder="Category Name" required> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label ">Days</label> 
                        <input type="number" name="days[]" value="" class="form-control bg-muted days-input" placeholder="Count" data-id=" ${leave_id} " onclick="checkGet()" id="leave_days${leave_id}" required> 
                    </div> 
                        <div class="col-xl-2 pt-3 bg-muted"> 
                            <label for="inputState" class="form-label">Unused Leave Rule</label> 
                            <select class="form-control select2" name="unused_leave_rule[]" id="leaverules"  required> 
                                <option  value="" disabled selected>Select Leave Rule</option> 
                                <option>Lapse</option> <option>Carry Forward</option>  
                            </select> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label">Carry Forward Limit</label> 
                        <input name="carry_forward_limit[]" type="number" value="" class="form-control carry-forward-input" min="0" id="carryForwardLimit" placeholder="Days" required> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputState" class="form-label">Applicable To</label> 
                        <select class="form-control select2" name="applicable_to[]" data-placeholder="Applicable To" required> 
                            <option value="" disabled selected>Select Applicable To</option> <option>All</option> 
                            <option>Male</option> <option>Female</option>
                        </select> 
                        </div> <div class="col-xl-1 pt-3 text-end"> 
                            <label for="inputCity" class="form-label ">&nbsp;</label> 
                            <button type="button" class="btn btn-outline-danger remove_item_btn"><i class="feather feather-trash"></i></button>  
                        </div> 
                    </div> `
                );
                leave_id++;
                // leave_id = document.getElementById('categoryname').value;    

            });

            $(document).on('click', '.remove_item_btn', function(e) {
                // e.preventDefault();
                let row_item = $(this).parent().parent();
                // console.log(row_item);
                $(row_item).remove();
            })


            // document.getElementById('leave_days').addEventListener('keyup', checkCFD);


            // $(document).on('change keyup paste click', '#leave_days', '#btnradiomonth', '#btnradioyear', function(e) {
            //     e.preventDefault();
            //     // var btnradioyear =
            //     console.log($('#btnradioyear').val());
            //     var value = $('#leave_days').val();
            //     console.log(value);
            //     // $('#carryForwardLimit').
            //     var carryForwardLimitInput = $('#carryForwardLimit');

            //     // Set the min and max attributes
            //     carryForwardLimitInput.attr('min', 0); // Set the minimum value to 0
            //     carryForwardLimitInput.attr('max', value); // Set the maximum value to 100

            //     // let row_item = $(this).parent().parent();
            //     // console.log(row_item);
            //     // $(row_item).remove();
            // })


            $('#submit').click(function() {
                var isValid = true; // Flag to track if all fields are valid
                // Loop through each added item
                $('#show_item').each(function(index, element) {
                    var categoryName = $(this).find('input[name="category_name[]"]').val();
                    var days = $(this).find('input[name="days[]"]').val();
                    var unusedLeaveRule = $(this).find('select[name="unused_leave_rule[]"]').val();
                    var carryForwardLimit = $(this).find('input[name="carry_forward_limit[]"]')
                        .val();
                    var applicableTo = $(this).find('select[name="applicable_to[]"]').val();

                    // Validate each field
                    if (!categoryName || !days || !unusedLeaveRule || !carryForwardLimit || !
                        applicableTo) {
                        isValid = false; // Set the flag to false if any field is empty
                        return false; // Exit the loop
                    }
                });
                if (!isValid) {
                    // Show an alert if any field is empty
                    Swal.fire({
                        title: 'Empty Fields',
                        text: 'Please fill in all fields for each item before submitting.',
                        icon: 'error',
                    });
                    return false; // Prevent form submission
                }

                $.ajax({
                    url: postURL,
                    method: "POST",
                    data: $('#add_item_btn').serialize(),
                    type: 'json',
                    // dd(data);
                    success: function(data) {

                        if (data.error) {
                            // Handle error if needed
                            return Hello;
                        } else {
                            // Handle success if needed
                            i = 1;
                            $('.dynamic-added').remove();
                            $('#remove_item_btn')[0].reset();
                        }

                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', 'input[name="btnradio"]', function() {

            $('.carry-forward-input').val('0');
            // var carryForwardInput = ('.carry-forward-input');
            carryForwardInput.val('0');
        })

        // var carryForwardInput = document.getElementByClass('carry-forward-input');

        // // Add event listener to enforce min and max value constraints
        // carryForwardInput.addEventListener('input', function(event) {
        //   const inputValue = parseInt(carryForwardInput.value);

        //   if (isNaN(inputValue)) {
        //     carryForwardInput.value = 0; // Reset to minimum if it's not a number
        //   } else if (inputValue < parseInt(carryForwardInput.min)) {
        //     carryForwardInput.value = carryForwardInput.min; // Enforce minimum value
        //   } else if (inputValue > parseInt(carryForwardInput.max)) {
        //     carryForwardInput.value = carryForwardInput.max; // Enforce maximum value
        //   }
        // });

        $(document).on('change click keyup', '.days-input, .carry-forward-input, input[name="btnradio"]', function() {
            // Find the closest row to the input field
            var row = $(this).closest('.row');
            var btnradio = $('input[name="btnradio"]:checked').val();
            console.log('btnradio ', btnradio);
            // Get the value of the 'days' input in the same row
            var daysValue = row.find('.days-input').val();
            var daysValue = parseFloat(daysValue);
            var days = (btnradio == 1) ? daysValue * 12 : daysValue;
            console.log("days " + days);
            console.log(daysValue);
            // Get the 'carry forward' input in the same row
            // carryForwardInput.preventDefault();
            var carryForwardInput = row.find('.carry-forward-input');

            if (daysValue) {
                // Set the max attribute of the 'carry forward' input to the value of 'days'
                carryForwardInput.attr('max', days);
                // var inputValue = parseInt(carryForwardInput.value);
                // if (isNaN(inputValue)) {
                //     carryForwardInput.value = 0; // Reset to minimum if it's not a number
                // } else if (inputValue < parseInt(carryForwardInput.min)) {
                //     carryForwardInput.value = carryForwardInput.min; // Enforce minimum value
                // } else if (inputValue > parseInt(carryForwardInput.max)) {
                //     carryForwardInput.value = carryForwardInput.max; // Enforce maximum value
                // }
            }
        });

        function checkGet() {

            // console.log('ddd');

            // var inputId = $(this).data('id');
            // console.log("inputId "+inputId);
            // $(document).on('change click keyup', '#leave_days'+inputId+', input[name="btnradio"]', function(e) {
            //     // Get the value of the selected radio button
            //     var btnradio = $('input[name="btnradio"]:checked').val();

            //     console.log('btnradio ', btnradio);
            //     if (btnradio == 1) {
            //         var value = $('#leave_days').val() * 12;
            //         console.log("Value: " + value);
            //     } else {
            //         // var value
            //         var value = $('#leave_days').val();

            //         // console.log('2 aaya');
            //     }
            //     // Get the value of the leave_days input
            //     //     var value = $('#leave_days').val();
            //     // console.log("Value: " + value);

            //     // Set the min and max attributes for the carryForwardLimit input
            //     var carryForwardLimitInput = $('#carryForwardLimit');
            //     carryForwardLimitInput.attr('min', 0); // Set the minimum value to 0
            //     carryForwardLimitInput.attr('max', value); // Set the maximum value to the value of leave_days

            //     let row_item = $(this).parent().parent();
            //     // console.log(row_item);
            //     // $(row_item).remove();
            //     console.log(row_item);
            // });

            // return context.value;
        }
    </script>
    {{-- end create Method --}}
    {{-- Create updated Method --}}

    <script>
        let LoadName = ''; //document.getElementById('edit_policy').value;

        // Reloaded Confirm Method All Set by JAYANT
        function openEditModel(context) {
            var id = $(context).data('id');
            var editpolicy = $(context).data('policy_name');
            var leave_policy_cycle_monthly = $(context).data('leave_policy_cycle_monthly');
            var leave_policy_cycle_yearly = $(context).data('leave_policy_cycle_yearly');
            var leave_period_from = $(context).data('leave_period_from');
            var leave_period_to = $(context).data('leave_period_to');
            // console.log('m' + leave_policy_cycle_monthly);
            // console.log('y' + leave_policy_cycle_yearly);
            LoadName = editpolicy;
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
            $('#leave_periodfrom2').val(leave_period_from);
            $('#leave_periodto2').val(leave_period_to);

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
                    console.log(result);
                    $('#show_item_edit').empty(); // Clear existing items
                    $.each(result.get, function(index, item) {
                        appendEditFormItem(item);
                    });
                }
            });

        }

        function appendEditFormItem(item) {
            // Extract values from the 'item' object
            var categoryName = item.category_name;
            var days = item.days;
            var unusedLeaveRule = item.unused_leave_rule;
            var carryForwardLimit = item.carry_forward_limit;
            var applicableTo = item.applicable_to;

            var newItemHtml = `<div class="row">
                    <div class="card-body col-xl-3 pt-3">
                        <label for="inputCity" class="form-label">Category Name</label> 
                        <input type="text" name="category_name_edit[]" value="${categoryName}" class="form-control" id="inputCity" placeholder="Category Name" required> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label">Days</label> 
                        <input type="number" name="days_edit[]" value="${days}" class="form-control bg-muted" placeholder="Count" required> 
                    </div> 
                    <div class="col-xl-2 pt-3 bg-muted"> 
                        <label for="inputState" class="form-label">Unused Leave Rule</label> 
                        <select class="form-control select2" name="unused_leave_rule_edit[]" id="leaverules" data-placeholder="Leave Rule" required> 
                            <option label="">Select Leave Rule</option> 
                            <option ${unusedLeaveRule === 'Lapse' ? 'selected' : ''}>Lapse</option> 
                            <option ${unusedLeaveRule === 'Carry Forward' ? 'selected' : ''}>Carry Forward</option>  
                        </select> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label">Carry Forward Limit</label> 
                        <input name="carry_forward_limit_edit[]" type="number" value="${carryForwardLimit}" class="form-control" id="inputCity" placeholder="Days" required> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputState" class="form-label">Applicable To</label> 
                        <select class="form-control select2" name="applicable_to_edit[]" data-placeholder="Applicable To" required> 
                            <option label="">Select Applicable To</option> 
                            <option ${applicableTo === 'All' ? 'selected' : ''}>All</option> 
                            <option ${applicableTo === 'Male' ? 'selected' : ''}>Male</option> 
                            <option ${applicableTo === 'Female' ? 'selected' : ''}>Female</option>
                        </select> 
                    </div> 
                    <div class="col-xl-1 pt-3 text-end"> 
                        <label for="inputCity" class="form-label ">&nbsp;</label> 
                        <button type="button" class="btn btn-outline-danger remove_item_btn_edit"><i class="feather feather-trash"></i></button>  
                    </div> 
                </div>`;

            $('#show_item_edit').append(newItemHtml);
        }


        $('#updateButton').click(function() {

            // Gather the updated data from the edited items
            var updatedItems = [];
            var isValid = true; // Flag to track if all fields are valid

            $('#show_item_edit .row').each(function(index) {
                var categoryName = $(this).find('input[name="category_name_edit[]"]').val();
                var days = $(this).find('input[name="days_edit[]"]').val();
                var unusedLeaveRule = $(this).find('select[name="unused_leave_rule_edit[]"]').val();
                var carryForwardLimit = $(this).find('input[name="carry_forward_limit_edit[]"]').val();
                var applicableTo = $(this).find('select[name="applicable_to_edit[]"]').val();
                if (!$('#edit_policy').val() || !categoryName || !days || !unusedLeaveRule || !
                    carryForwardLimit || !applicableTo) {
                    isValid = false; // Set the flag to false if any field is empty
                    return false; // Exit the loop
                }
                // Create an object to represent the updated item
                var updatedItem = {
                    category_name: categoryName,
                    days: days,
                    unused_leave_rule: unusedLeaveRule,
                    carry_forward_limit: carryForwardLimit,
                    applicable_to: applicableTo
                };

                updatedItems.push(updatedItem);
                console.log(updatedItems);
            });

            if (!isValid) {
                // Show an alert if any field is empty
                Swal.fire({
                    title: 'Empty Fields',
                    text: 'Please fill in all fields for each item before updating.',
                    icon: 'error',
                });
                return false; // Prevent form submission
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
                    console.log(result);
                    if (result.message != false) {
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

        // temporary clone data set
        $(document).ready(function() {

            $(".add_item_btn_edit").click(function(e) {
                let categoryname_edit = $('#categoryname_edit').val();
                let days_edit = $('#days_edit').val();
                let leaverule_edit = $('#leaverule_edit').val();
                let cfl_edit = $('#cfl_edit').val();
                let applicable_edit = $('#applicable_edit').val();
                $("#show_item_edit").append(
                    `<div class="row">
                        <div class="card-body col-xl-3 pt-3" name="leave_id" id="" > 
                            <label for="inputCity" class="form-label">Category Name</label> 
                            <input type="text" name="category_name_edit[]" value="" class="form-control" id="inputCity" placeholder="Category Name" required> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label ">Days</label> 
                        <input type="number" id="leaveDays" name="days_edit[]" value="" class="form-control bg-muted leaveDays" placeholder="Count" required> 
                    </div> 
                        <div class="col-xl-2 pt-3 bg-muted"> 
                            <label for="inputState" class="form-label">Unused Leave Rule</label> 
                            <select class="form-control select2" name="unused_leave_rule_edit[]" id="leaverules"  required> 
                                <option  value="" disabled selected>Select Leave Rule</option> 
                                <option>Lapse</option> <option>Carry Forward</option>  
                            </select> 
                        </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputCity" class="form-label">Carry Forward Limit</label> 
                        <input name="carry_forward_limit_edit[]" type="number" value="" class="form-control" id="inputCity" placeholder="Days" required> 
                    </div> 
                    <div class="col-xl-2 pt-3"> 
                        <label for="inputState" class="form-label">Applicable To</label> 
                        <select class="form-control select2" name="applicable_to_edit[]" required> 
                            <option>Select Applicable To</option> <option>All</option> 
                            <option>Male</option> <option>Female</option>
                        </select> 
                        </div> <div class="col-xl-1 pt-3 text-end"> 
                            <label for="inputCity" class="form-label ">&nbsp;</label> 
                            <button type="button" class="btn btn-outline-danger remove_item_btn_edit"><i class="feather feather-trash"></i></button>  
                        </div> 
                    </div> `
                );
            });

            // $("#leaveDays").click(function(e) {
            //     console.log("helloBrother");
            // }


            $(document).on('click', '.remove_item_btn_edit', function(e) {
                // e.preventDefault();
                let row_item = $(this).parent().parent();
                console.log(row_item);
                $(row_item).remove();
            })




        });
    </script>
    {{-- end updated Section --}}

    <script>
        function LeavePeriodCheck(context) {
            alert(context);

        }
    </script>
    <script></script>

    <script>
        document.getElementById('editFrom').addEventListener('change', calculateDateDifference);
        document.getElementById('editTo').addEventListener('change', calculateDateDifference);

        function calculateDateDifference() {
            var fromDate = document.getElementById('editFrom').value;
            var toDate = document.getElementById('editTo').value;

            if (fromDate && toDate) {
                var from = new Date(fromDate);
                var to = new Date(toDate);
                // Calculate the difference in milliseconds
                var differenceInTime = to - from;

                // Calculate the difference in years
                var differenceInYears = differenceInTime / (1000 * 3600 * 24 * 365.25); // Consider leap years

                // Check if the difference is not exactly 1 year
                if (Math.abs(differenceInYears - 1) > 0.001) { // We use a small tolerance to account for leap years
                    alert("Financial year not match, 1 Year.");
                    // toDate.style.color = 'red !important'; // Set the text color to red
                } else {
                    // toDate.style.color = ''; // Reset the text color using !important
                }

                $('#editDays').val(Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1);
                console.log(Math.floor(differenceInTime / (1000 * 3600 * 24)) + 1);
            }
        }
    </script>
@endsection

{{-- <div class=" text-end">
    <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
data-bs-placement="top" title="Save">Apply Changes</a>
</div> --}}

{{-- Set Multilavel Approval Modal --}}
{{-- <div class="modal fade" id="SetMultilavelApprovalModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body border-0 ">
                <div class="card">
                    <div class="card-header  border-0">
                        <h6 class="card-title">Set Multilavel Approval</h6>
                    </div>
                    <div class="card-body border-0">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="form-label">Choose Type of Approval:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Type of Approval" id='lavelofapproval'>
                                        <option label="Select Employee"></option>
                                        <option value="1">Lavel One</option>
                                        <option value="2">Lavel Two</option>
                                        <option value="3">Lavel Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12">
                                <div class="row">
                                    <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                        <div class="form-group d-none" id="firstlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-none" id="secondlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-none" id="thirdlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}
{{-- Edit Multilavel Approval Modal --}}
{{-- <div class="modal fade" id="EditMultilavelApprovalModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body border-0">
                <div class="card">
                    <div class="card-header  border-0">
                        <h6 class="card-title">Edit Multilavel Approval</h6>
                    </div>
                    <div class="card-body border-0">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="form-label">Choose Type of Approval:</label>
                                    <select name="attendance" class="form-control custom-select select2"
                                        data-placeholder="Type of Approval" id='Editlavelofapproval'>
                                        <option label="Select Employee"></option>
                                        <option value="1">Lavel One</option>
                                        <option value="2">Lavel Two</option>
                                        <option value="3">Lavel Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12">
                                <div class="row">
                                    <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                        <div class="form-group d-none" id="Editfirstlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-none" id="Editsecondlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-none" id="Editthirdlavel">
                                            <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                Approved By:</label>
                                            <select name="attendance" class="form-control custom-select select2 d-none"
                                                data-placeholder="Select Employee">
                                                <option label="Select Employee"></option>
                                                <option value="1">Employer</option>
                                                <option value="2">Manager</option>
                                                <option value="3">HR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}


{{-- <div class="row">
    <div class="card">
        <div class="card-body ">
            <div class="row">
                <div class="col-6 col-xl-3 my-auto">
                    <h5 class="my-auto">FD Leave Template</h5>
                </div>
                <div class="col-6 col-xl-2 my-auto">
                    <p class="my-auto text-muted">2 Leaves Per Month</p>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto text-muted">Applied to 14 Employees</p>
                </div>
                <div class="col-8 col-xl-2">
                    <p class="my-auto text-muted">
                        <a class="btn text-primary" id="manageemp1" href="#"><b>Manage Employee List</b></a>
                        <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                    </p>
                </div>
                <div class="col-4 col-xl-2">
                    <p class="my-auto text-muted text-end">
                        <a class="btn text-primary" id="editTempBtn" href="#"><b>Edit Template</b></a>
                        <a class="btn btn-outline-success d-none" id="applyTempBtn" href="#"><b>Apply</b></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body border-bottum-0 d-none" style="height: 20rem; overflow:scroll" id="emplist1">
            <table class="table mb-0 text-nowrap">

                <tbody>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mail"><i
                                    class="feather feather-edit  text-primary"></i></a>
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}
