{{-- <?php dd($data); ?> --}}
@extends('admin.pagelayout.master')
@section('title')
    TADA | Lodging Policy
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
            <li><a href="{{ url('/admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Toll page</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Lodging Policy</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="reset" class="btn btn-primary mb-2 mb-md-0 me-md-2" data-bs-toggle="modal" id="createGradeBtn" data-bs-target="#createGradeModal">Create Lodging Policy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lodging Policy</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Grade </th>
                            <th class="border-bottom-0">Travel Type</th>
                            <th class="border-bottom-0">Travel Category</th>
                            <th class="border-bottom-0">Lodging Type</th>
                            {{-- <td class="font-weight-semibold">Set Amount</td> --}}
                            <th class="border-bottom-0">Lodging Amount</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $items)
                            <tr>

                                <td class="font-weight-semibold" id="key">{{ ++$key }}</td>
                                <td class="font-weight-semibold"  dataedit="{{ $items->lo_id }}">{{$items->grade_list->grade_name ?? ''}}</td>
                                {{-- <td class="font-weight-semibold" style="display:none" mewant="{{ $items->misc_id }}"
                                    id="mewant_id">{{ $items->lo_id }}</td> --}}
                                <td class="font-weight-semibold">{{$items->travel_type->travel_class ?? ''}}</td>
                                <td class="font-weight-semibold">{{$items->travel_category->travel_type ?? ''}}</td>
                                <td class="font-weight-semibold">{{$items->lodging_type}}</td>
                                {{-- <td class="font-weight-semibold">{{$items->set_amount}}</td> --}}
                                {{-- <td class="font-weight-semibold">{{ if($items->lodge_amount == null ){ $items->set_amount->actual_amount }else{ $items->lodge_amount} }}</td> --}}
                                <td class="font-weight-semibold">
                                    @if($items->lodge_amount == null)
                                        {{ $items->set_amount_one->actual_amount ?? '' }}
                                    @else
                                        {{ $items->lodge_amount ?? ''}}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn" class="">
                                            {{-- <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                onclick="openLodgeEditBtn(this)"
                                                data-bs-toggle="modal"
                                                data-id='{{ $items->lo_id}}'
                                                data-grade_name='{{$items->grade_list->id  ?? ''}}',
                                                data-travel_type='{{$items->travel_type->travel_m_id  ?? ''}}',
                                                data-travel_category='{{$items->travel_category->travel_id  ?? ''}}',
                                                data-lodging_type='{{$items->lodging_type_id}}',
                                                data-lodging_amount=' @if($items->lodge_amount == null)
                                                {{ $items->set_amount_one->actual_amount ?? '' }}
                                            @else
                                                {{ $items->lodge_amount ?? ''}}
                                            @endif',
                                                href="#">
                                                <i class='feather feather-edit'></i></a> --}}

                                                    <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                        onclick="openLodgeEditBtn(this)"
                                                        data-bs-toggle="modal"
                                                        data-id="{{ $items->lo_id }}"
                                                        data-grade_name="{{ $items->grade_list->id ?? '' }}"
                                                        data-travel_type="{{ $items->travel_type->travel_m_id ?? '' }}"
                                                        data-travel_category="{{ $items->travel_category->travel_id ?? '' }}"
                                                        data-lodging_type='{{$items->lodging_type ?? ''}}',
                                                        data-lodging_amount="{{ $items->lodge_amount ?? ($items->set_amount_one->actual_amount ?? '') }}"
                                                        href="#">
                                                        <i class="feather feather-edit"></i>
                                                    </a>



                                            <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-grade_name='<?= $items->grade_list->grade_name ?? '' ?>'
                                                onclick="openDeleteBtn(this)"
                                                data-id='<?= $items->misc_id ?>' data-bs-target="#gradeDeleteBtn"
                                                data-misc_account='{{ $items->misc_amount }}'
                                                data-set_amount='{{ $items->set_amount }}'
                                                data-bs-target="#gradeDeleteBtn"
                                                id="BranchEditbtn">
                                                <i class="feather feather-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <?php ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- sir model start --}}
    <div class="modal fade" id="createGradeModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Create Lodging Amount </h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ url('admin/settings/tada/lodging/person') }}" id="addGradeFormId">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Grade Name</label>
                                    <select name="grade_id" id="leave_category5" data-id="5" class="form-control" required>
                                        <option value=""> Select Grade</option>
                                        @foreach ($grade_list as $list)
                                            <option value="{{$list->id}}">{{$list->grade_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {{-- <div class="form-group">
                                            <label for="travel_type" class="form-label">Travel Type</label>
                                            <input type="text" class="form-control" id="travel_type" name="travel_type" placeholder="Enter travel type">
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="travel_type" class="form-label">Travel Type</label>
                                            <select class="form-control" id="travel_type" name="travel_type" onchange="change_modes(this)" required>
                                                <option value="">Select Travel Type</option>
                                                @foreach ($travel_modes as $mode)
                                                    <option value="{{ $mode->travel_m_id}}">{{ $mode->travel_class }}</option>
                                                @endforeach
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Travel Category</label>
                                            <select name="travel_category"  data-id="" class="form-control"  id="travel_all" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="lodging_type" class="form-label">Lodging Type</label>
                                            <select class="form-control" id="lodging_type" name="lodging_type">
                                                <option value="single_occupancy">Single Occupancy</option>
                                                <option value="double_occupancy">Double Occupancy</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- me create a button wire: --}}
                                <div class="form-group"> <!-- Added form-group here -->
                                    <p class="form-label" >Set Amount</p>
                                    {{-- <label for="set_amount">Other Miscellaneous Amount</label> <!-- Added label --> --}}
                                    <select name="set_amount" class="form-control" id="gradeSelect_add" aria-label="Grade" tabindex="1" required onchange="show_hide_add()">
                                        <option value="">Select Amount</option>
                                        @foreach ($amount as $paisa)
                                        {
                                            <option value="{{$paisa->set_id}}">{{$paisa->category_amount}}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div id="manualInput_add" class="mt-2" style="display: none;">
                                    <label for="amount_manual" id="amount_manual_label" class="form-label">Amount</label>
                                    <input name="misc_amount" type="text" class="form-control" id="amount_manual_add" disabled  placeholder="Enter Amount" aria-label="added_amount Grade" tabindex="2">
                                </div>
                                <div class="row">
                                    {{-- <div class="col-12">
                                        <div class="form-group">
                                            <label for="lodging_amount" class="form-label">Lodging Amount</label>
                                            <input type="text" class="form-control" id="lodging_amount" name="lodging_amount" placeholder="Enter lodging amount">
                                        </div>
                                    </div> --}}
                                </div>
                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end">
                        <a type="reset" class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary savebtn">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- EDIT MODAL START --}}
    {-- FOR MODAL  Edit  --}}
    <div class="modal fade" id="modaldemo1" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Lodging amount</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ url('admin/settings/tada/lodgingedit') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div id="edit_lodging"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger cancel" type="reset" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary savebtn">Update</button>
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
            console.log(event);
            $('#myModal').modal('hide');
            $('#submit').prop('disabled', true);
            event.preventDefault();

        });
        //     // delete modal function
        //     function ItemDeleteModel(context) {
        //         var id = $(context).data('id');
        //         var assign = $(context).data('policy_name');
        //         $('#poli_id').val(id);
        //         $('#assign_emp').text(assign);
        //     }
    </script>
     {{-- new create Section start --}}
    <script>
    //  create tmplate btn click modal show
        $("#create_template_btn").on('click', function() {
            $('#form_leave').trigger('reset');
            $('#show_item').empty();
            $('#myModal').modal('show');
            $(".add_item_btn").click();
        });


        // // insert unused leave rule
        // function UnusedLeaveRule(context) {
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


    </script>
    <script>
        function change_modes(val) {
            let different_modes = val.value;
            // console.log(different_modes);

            console.log('different_modes', different_modes);
            $.ajax({
                url: "{{ url('admin/settings/tada/differentmodes') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data_modes": different_modes
                },
                success: function(response) {
                    console.log('response',response.data_modes);
                    console.log('Response:', response.data_modes); // Log the entire response object
                    var selOpts1 = "<option value=''>Selet </option>";
                    if (Array.isArray(response.data_modes)) {
                        response.data_modes.forEach(function(data) {
                            console.log('data:', data); // Log each individual data object to inspect its structure
                            selOpts1 += "<option value='" + data.travel_id + "'>" + data.travel_type + "</option>";
                        });
                    } else {
                        // Handle non-array response here, if needed
                    }
                    console.log('selOpts1', selOpts1);
                    document.getElementById('travel_all').innerHTML = selOpts1;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // for adding amount function
        function show_hide_add(){
                var gradeSelect = document.getElementById("gradeSelect_add");
                var manualInput = document.getElementById("manualInput_add");
                var amountManual = document.getElementById("amount_manual_add");

                console.log('gradeSelect',gradeSelect.value ,'manualInput',manualInput,'amountManual',amountManual);
                if (gradeSelect.value == '1') {
                    manualInput.style.display = 'block';
                    amountManual.disabled = false;
                } else {
                    manualInput.style.display = 'none';
                    amountManual.disabled = true;
                };
            }




//        function openLodgeEditBtn(context) {
//     console.log('context', context);
//     var id = $(context).data('id');

//     var gradeName = $(context).data('grade_name');

//     var travel_type  = $(context).data('travel_type');

//     var travelCategory = $(context).data('travel_category');
//     var lodgingType = $(context).data('lodging_type');
//     var lodgingAmount = $(context).data('lodging_amount');




//     var gradeName = $('#grade_name').val();
// var travel_type = $('#travel_type').val();
// var travelCategory = $('#travel_category').val();
// var lodgingType = $('#lodging_type').val();
// var lodgingAmount = $('#lodging_amount').val();
//     // console.log('id:', id);
//     // console.log('gradeName:', gradeName);

// //     console.log('travelCategory:', travelCategory);
// //    console.log('lodgingType:', lodgingType);
// //     console.log('lodgingAmount:', lodgingAmount);


//     //     var amount = $(context).closest('tr').find('#misc_amount').text().trim();
//     //     var set_amount = $(context).closest('tr').find('#set_amount').val();

//     var newItemHtml = `
//     <div class="col-12">
//     <div class="form-group">
//         <label class="form-label">Grade Name</label>
//         <select name="grade_id" id="leave_category5" class="form-control" placeholder="Category Name" required>
//             @foreach ($grade_list as $list)
//                 <option value="{{ $list->id }}" ${mewantValue == {{ $list->id }} ? 'selected' : ''}>{{ $list->grade_name }}</option>
//             @endforeach
//         </select>
//     </div>
//     <input type="hidden" name="edit" value="${findid}">
//     <div class="form-group">
//         <label class="form-label">Travel Category</label>
//         <input type="text" name="travel_category" id="travel_category" class="form-control" placeholder="Enter Travel Category" required>
//     </div>
//     <div class="form-group">
//         <label class="form-label">Travel Type</label>
//         <input type="text" name="travel_type" id="travel_type" class="form-control" placeholder="Enter Travel Type" required>
//     </div>
//     <div class="form-group">
//         <label class="form-label">Lodging Type</label>
//         <input type="text" name="lodging_type" id="lodging_type" class="form-control" placeholder="Enter Lodging Type" required>
//     </div>
//     <div class="form-group">
//         <label class="form-label">Lodging Amount</label>
//         <input type="number" name="lodging_amount" id="lodging_amount" class="form-control" placeholder="Enter Lodging Amount" required>
//     </div>
//     <div class="form-group">
//         <label class="form-label">Miscellaneous Allowance Limit</label>
//         <select name="set_amount" class="form-control" id="gradeSelect" required onchange="show_hide_edit()">
//             ${amount ? `
//                 <option value="1">Add Amount</option>
//                 <option value="0">Actual</option>
//                 <option value="">Select Amount</option>` :
//                 `<option value="">Select Amount</option>
//                 <option value="1">Add Amount</option>
//                 <option value="0">Actual</option>`}
//         </select>
//     </div>
//     ${amount ? `
//         <div id="manualInput" class="mt-2">
//             <label class="form-label" id="amount_manual_label">Amount</label>
//             <input name="misc_amount" type="text" class="form-control" id="amount_manual" placeholder="Enter Amount" value="${amount}">
//         </div>` : `
//         <div id="manualInput" class="mt-2" style="display: none;">
//             <label class="form-label" id="amount_manual_label">Amount</label>
//             <input name="misc_amount" type="text" class="form-control" id="amount_manual" placeholder="Enter Amount">
//         </div>`}
//     <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
// </div>

//             <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
//         </div>`;

//     $('#edit_lodging').empty().append(newItemHtml)
//        }
function openLodgeEditBtn(context) {
    console.log('context', context);
    var id = $(context).data('id');
    var gradeName = $(context).data('grade_name');
    var travelType = $(context).data('travel_type');
    var travelCategory = $(context).data('travel_category');
    var lodgingType = $(context).data('lodging_type');
    var lodgingAmount = $(context).data('lodging_amount');

    console.log("ID:", id);
    console.log("Grade Name:", gradeName);
    console.log("Travel Type:", travelType);
    console.log("Travel Category:", travelCategory);
    console.log("Lodging Type:", lodgingType);
    console.log("Lodging Amount:", lodgingAmount);

    var newItemHtml = `
    <div class="col-12">
        <div class="form-group">
            <label class="form-label">Grade Name</label>
            <select name="grade_id" id="leave_category5" class="form-control" placeholder="Category Name" required>
                @foreach ($grade_list as $list)
                    <option value="{{ $list->id }}" {{ $list->id == '${gradeName}'  ? 'selected' : '' }} >{{ $list->grade_name }}</option>
                @endforeach
            </select>

        </div>
        <input type="hidden" name="edit" value="">
        <div class="form-group">
            <label for="travel_type" class="form-label">Travel Type</label>
            <select class="form-control" id="travel_type" name="travel_type" onchange="change_modes(this)" required>
                @foreach ($travel_modes as $mode)
                    <option value="{{ $mode->travel_m_id }}" {{ $mode->travel_m_id == '${travelType}' ? 'selected' : '' }}>{{ $mode->travel_class }}</option>
                @endforeach
                <!-- Add more options as needed -->
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Travel Category</label>
            <input type="text" name="travel_category" id="travel_all" class="form-control" placeholder="Enter Travel Category" value="${travelCategory}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Lodging Type</label>
            <input type="text" name="lodging_type" id="lodging_type" class="form-control" placeholder="Enter Lodging Type" value="${lodgingType}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Lodging Amount</label>
            <input type="number" name="lodging_amount" id="lodging_amount" class="form-control" placeholder="Enter Lodging Amount" value="${lodgingAmount}" required>
        </div>

        <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
    </div>`;

    $('#edit_lodging').empty().append(newItemHtml);
}

    </script>

@endsection
