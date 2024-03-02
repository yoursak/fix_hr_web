{{-- <?php dd($data_view); ?> --}}
@extends('admin.pagelayout.master')
@section('title')
    Grade Settings
@endsection
@section('css')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/tada') }}">TADA</a></li>
            <li class="active"><span><b>Other_miscllaneous</b></span></li>
        </ol>
    </div>
   {{-- <div class="row">
    <p>Other Miscllaneous Amount</p>
    <div class="page-header d-md-flex d-block">
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="reset" class="btn btn-primary" data-bs-toggle="modal" id="createGradeBtn"
                            data-bs-target="#createGradeModal">Create Grade</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div> --}}
<div class="mb-md-0 me-md-2">
    <div class="row align-items-center">
        <div class="col">
            <p class="mb-0">Other Miscellaneous Amount</p>
        </div>
        <div class="col-auto b-2 ">
            <button type="reset" class="btn btn-primary mb-2 mb-md-0 me-md-2" data-bs-toggle="modal" id="createGradeBtn"
                data-bs-target="#createGradeModal">Create Expense</button>
        </div>
    </div>

</div>


    {{-- </form> --}}
    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title ">Miscellaneous Expense List</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">

                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Grade Name</th>
                            <th class="border-bottom-0">Amount</th>
                            <th class="un" hidden>set amount</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_view as $key => $items)
                            <tr>

                                <td class="font-weight-semibold" id="key">{{ ++$key }}</td>
                                <td class="font-weight-semibold" dataedit="{{ $items->misc_id }}"
                                    data="{{ $items->grade_id }}" id="grade_id">
                                    {{ $items->grade_list->grade_name ?? '' }}
                                </td>
                                <td class="font-weight-semibold" style="display:none" mewant="{{ $items->misc_id }}"
                                    id="mewant_id">{{ $items->grade_id }}</td>
                                <td class="font-weight-semibold" id="misc_amount">{{ $items->misc_amount }}</td>

                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn" class="">
                                            {{-- <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                onclick="openGradeEditBtn(this)" data-id='<?= $items->id ?>'
                                                data-grade_name='<?= $items->grade_name ?>' data-bs-toggle="modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a> --}}
                                                <a class="btn action-btns btn-sm btn-primary"
                                                    href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modaldemo1"
                                                    onclick="openGradeEditBtn(this)"
                                                    data-id="<?= $items->id ?>"
                                                    data-grade_name="<?= $items->grade_name ?>">
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
 {{-- FOR MODAL  Edit  --}}
    <div class="modal fade" id="modaldemo1" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Grade</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ url('admin/settings/tada/edit/other_amount') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div id="edit_grade"></div>
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
    {{-- Grade Name Creation Modal  Add --}}
    <div class="modal fade" id="createGradeModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Create Grade and Other Miscellaneous </h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ url('admin/settings/tada/other_amount') }}" id="addGradeFormId">
                    @csrf
                    {{-- <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Grade Name</p>
                                    <select type="text" name="grade_id" id="leave_category5" data-id="5" value="" class="form-control" placeholder="Category Name" required="">
                                        @foreach ($grade_list as $list)
                                            <option value="{{$list->id}}">{{$list->grade_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="form-label">Set Amount</p>
                                <select name="set_amount" class="form-control" id="gradeSelect_add" aria-label="Grade" tabindex="1" required onchange="show_hide_add()">
                                    <option value="">Select Amount</option>
                                    <option value="1">Add Amount </option>
                                    <option value="0">Actual</option>
                                </select>
                                <div id="manualInput_add" class="mt-2" style="display: none;">
                                    <label for="amount_manual" id="amount_manual_label">Amount</label>
                                    <input name="misc_amount" type="text" class="form-control" id="amount_manual_add" disabled  placeholder="Enter Amount" aria-label="added_amount Grade" tabindex="2">
                                </div>
                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Grade Name</p>
                                    <select type="text" name="grade_id" id="leave_category5" data-id="5" value="" class="form-control" placeholder="Category Name" required="">
                                        @foreach ($grade_list as $list)
                                            <option value="{{$list->id}}">{{$list->grade_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> <!-- Added form-group here -->
                                    <p class="form-label" >Miscllaneous Allowance Limit</p>
                                    {{-- <label for="set_amount">Other Miscellaneous Amount</label> <!-- Added label --> --}}
                                    <select name="set_amount" class="form-control" id="gradeSelect_add" aria-label="Grade" tabindex="1" required onchange="show_hide_add()">
                                        <option value="">Select Amount</option>
                                        <option value="1">Add Amount </option>
                                        <option value="0">Actual</option>
                                    </select>
                                </div>
                                <div id="manualInput_add" class="mt-2" style="display: none;">
                                    <label for="amount_manual" id="amount_manual_label" class="form-label">Amount</label>
                                    <input name="misc_amount" type="text" class="form-control" id="amount_manual_add" disabled  placeholder="Enter Amount" aria-label="added_amount Grade" tabindex="2">
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
    {{--  for deleteing the amount  --}}
    <div class="modal fade" id="gradeDeleteBtn" data-bs-backdrop="static" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="mt-5">Are you sure want to delete the other miscellaneous allowances</h4>
                            {{-- <p>Are you sure you want to delete the following item?</p>
                                 <span class="text-primary"
                            id="gradeDeleteText"></span> ?
                            <p><strong>Grade Name:</strong> <span id="gradeName"></span></p>
                            <p><strong>Misc Amount:</strong> <span id="miscAccount"></span></p>
                            <p><strong>Set Amount:</strong> <span id="setAmount"></span></p> --}}
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="POST" action="{{url('admin/settings/tada/delete/other_amount') }}">
                        @csrf
                        <input type="hidden" name="deleteId" id="deleteId" value="">
                        <button type="submit" data-confirm-delete="true" class="btn btn-danger" data-bs-toggle="modal"data-bs-target="#">Delete</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <script>
          function openGradeEditBtn(context) {
    console.log('context', context);

    var id = $(context).data('id');
    var gradeName = $(context).data('grade_name');

    var findid = $(context).closest('tr').find('td[dataedit]').attr('dataedit');
    var mewantValue = $(context).closest('tr').find('td[mewant]').attr('mewant');
    console.log('mewantValue', mewantValue);

        var amount = $(context).closest('tr').find('#misc_amount').text().trim();
        var set_amount = $(context).closest('tr').find('#set_amount').val();

    var newItemHtml = `
        <div class="col-12">
            <div class="form-group">
                <label class="form-label">Grade Name</label>
                <select name="grade_id" id="leave_category5" class="form-control" placeholder="Category Name" required>
                    @foreach ($grade_list as $list)
                        <option value="{{ $list->id }}" ${mewantValue == {{ $list->id }} ? 'selected' : ''}>{{ $list->grade_name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="edit" value="${findid}">
            <div class="form-group">
                <label class="form-label">Miscellaneous Allowance Limit</label>
                <select name="set_amount" class="form-control" id="gradeSelect" required onchange="show_hide_edit()">
                    ${amount ? `
                        <option value="1">Add Amount</option>
                        <option value="0">Actual</option>
                        <option value="">Select Amount</option>` :
                        `<option value="">Select Amount</option>
                        <option value="1">Add Amount</option>
                        <option value="0">Actual</option>`}
                </select>
            </div>
            ${amount ? `
                <div id="manualInput" class="mt-2">
                    <label class="form-label" id="amount_manual_label">Amount</label>
                    <input name="misc_amount" type="text" class="form-control" id="amount_manual" placeholder="Enter Amount" value="${amount}">
                </div>` : `
                <div id="manualInput" class="mt-2" style="display: none;">
                    <label class="form-label" id="amount_manual_label">Amount</label>
                    <input name="misc_amount" type="text" class="form-control" id="amount_manual" placeholder="Enter Amount">
                </div>`}
            <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
        </div>`;

    $('#edit_grade').empty().append(newItemHtml);
}




             function openDeleteBtn(context) {
                var id = $(context).data('id');
                var gradeName = $(context).data('grade_name');
                var miscId = $(context).data('id');
                var gradeName = $(context).data('grade_name');
                var miscAccount = $(context).data('misc_account');
                var setAmount = $(context).data('set_amount');

                // Populate the modal with the data
                $('#miscId').text(miscId);
                $('#gradeName').text(gradeName);
                $('#miscAccount').text(miscAccount);
                $('#setAmount').text(setAmount);


                // Populate the modal with the data
                $('#deleteId').val(id);
                $('#gradeDeleteText').html(gradeName);

                // Show the delete confirmation modal
                $('#gradeDeleteBtn').modal('show');
             }

            function show_hide_edit(){
                var gradeSelect = document.getElementById("gradeSelect");
                var manualInput = document.getElementById("manualInput");
                var amountManual = document.getElementById("amount_manual");
                console.log('gradeSelect',gradeSelect.value ,'manualInput',manualInput,'amountManual',amountManual);
                if (gradeSelect.value == '1') {
                    manualInput.style.display = 'block';
                    amountManual.disabled = false;
                } else {
                    manualInput.style.display = 'none';
                    amountManual.disabled = true;
                };
            }
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
    </script>
@endsection
{{-- @endif --}}

