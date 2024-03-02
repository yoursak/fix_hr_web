@extends('admin.pagelayout.master')

@section('title')
    Deduction
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
        <li><a href="{{ url('admin/settings/payroll') }}">Payroll Setup</a></li>
        <li class="active"><span><b>Deduction</b></span></li>
    </ol>
</div>
{{-- <form method="POST" action="{{ route('add.department') }}"> --}}
@csrf
<div class="page-header d-md-flex d-block">
    {{-- @php
        $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class

        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        // dd($Department);
        $i = 0;
        $j = 1;
        $root = new App\Helpers\Central_unit();
        // $branchCount=$root->CountersValue();
        $gradeCount = $root->CountersValue();

    @endphp --}}
    <div class="page-leftheader">
        <div class="page-title">Deductions</div>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block ms-auto">
                <div class="btn-list">
                    {{-- @if (in_array('Grade Settings.Create', $permissions)) --}}
                    <button type="reset" class="btn btn-primary" data-bs-toggle="modal" id="createEarnBtn"
                        data-bs-target="#createEarnModal">Create Deduction Component</button>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>

</div>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Deductions Components</h3>
    </div>
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0 w-10">Name Component</th>
                        <th class="border-bottom-0">Deduction Name</th>
                        <th class="border-bottom-0">Calculation Types</th>
                        <th class="border-bottom-0">Amount</th>

                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newData as $key => $items)
                        <tr>
                            <td class="font-weight-semibold">{{ ++$key }}</td>
                            <td class="font-weight-semibold">{{ $items->deduct_name }}</td>
                            <td>
                                <div class="d-flex">
                                    <div id="actionBtn" class="">
                                        <a class="btn action-btns  btn-sm btn-primary"
                                        data-bs-target="#modaldemo1"
                                         onclick="openEarnEditBtn(this)"
                                         data-id='<?= $items->id ?>'
                                         data-salary_name='<?= $items->salary_id ?>'
                                         data-bs-toggle="modal"
                                         href="#">
                                            <i class='feather feather-edit'></i></a>
                                        <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-grade_name='<?= $items->grade_name ?>' onclick="openDeleteBtn(this)"
                                            data-id='<?= $items->id ?>' data-bs-target="#gradeDeleteBtn"
                                            id="BranchEditbtn"><i class="feather feather-trash"></i>
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





  {{-- Earning Name Creation Modal --}}
  <div class="modal fade" id="createEarnModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Create Deduction Component</h4><button aria-label="Close" class="btn-close"
                    id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            {{-- <form method="POST" action="{{ route('add.deduction') }}" id="addGradeFormId"> --}}
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-12">
                            <div class="form-group">
                                <p class="form-label">create earning component components</p>
                                <div class="col" >
                                    <select name="earning_component" class="form-control" tabindex="1" required id="optionearn" onchange="showandhide(this)">
                                        @foreach ($data as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                             <div class="col mt-4">
                                <input name='Earning' type="text" class="form-control" style="display:none" id="selectdeduct" value=""
                                    placeholder="Enter Earning Component" aria-label="Search" tabindex="1" required>
                            </div>

                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a
                                        href="#" class="text-primary">Terms & Conditions</a></p>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="form-group">
                                <p class="form-label">Create Deduction  components</p>

                                    <div class="col" >
                                        <select name="deduction_component" class="form-control" tabindex="1" required id="optionearn" onchange="showandhide(this)">
                                            @foreach ($data as $item)
                                                <option value="{{ $item->id}}">{{ $item->name_ded }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col mt-4">
                                        <input name='deduction' type="text" class="form-control" style="display:none" id="selectdeduct" value=""
                                            placeholder="Enter Earning Component" aria-label="Search" tabindex="1" required>
                                    </div>

                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a
                                        href="#" class="text-primary">Terms & Conditions</a></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    @csrf
                    <a type="reset" class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary savebtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#createEarnBtn").on('click', function() {
            // $('#addGradeFormId').trigger('reset');
            $('#createGradeModal').modal('show');
        });

        function openEarnEditBtn(context) {
            console.log(context);
            var id = $(context).data('id');
            var gradeName = $(context).data('salary_name');
            // $('#editId').val(id);
            // $('#editGrade').val(gradeName);
        }

        function openDeleteBtn(context) {
            console.log(this);
            var id = $(context).data('id');
            var gradeName = $(context).data('grade_name');
            $('#editId').val(id);
            $('#editGrade').val(gradeName);
        }

        function openDeleteBtn(context) {
            var id = $(context).data('id');
            var gradeName = $(context).data('grade_name');
            $('#deleteId').val(id);
            $('#gradeDeleteText').html(gradeName);
        }




function showandhide(selectElement) {
    var selectedValue = selectElement.value; // Get the selected value from the <select> element
    var inputField = document.getElementById('selectdeduct'); // Get the input field
    var optionField = document.getElementById('optionearn');

    if (selectedValue === 'OtherTaxes') {
        // If 'Others' is selected, show the input field
        inputField.style.display = 'block';

    } else {
        // Otherwise, hide the input field
        optionField.style.display = 'block';
        inputField.style.display = 'none';
    }
}



    </script>
@endsection
