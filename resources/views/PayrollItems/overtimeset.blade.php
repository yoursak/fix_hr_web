{{-- @extends('admin.pagelayout.master')

@section('title')
    Setup Activation | Create Shift
@endsection

@section('content')

<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/admin/settings/payroll') }}">Payroll Setup</a></li>
        <li class="active"><span><b>Indirect Allowances</b></span></li>
    </ol>
</div>
<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Indirect Allowance</div>
    </div>
</div>


@endsection --}}
{{-- <?php dd($newData); ?> --}}
@extends('admin.pagelayout.master')
@section('title')
    Earnings
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
            <li class="active"><span><b>Earnings</b></span></li>
        </ol>
    </div>
    {{-- <form method="POST" action="{{ route('add.department') }}"> --}}
    {{-- @csrf --}}
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Earnings</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        {{-- @if (in_array('Grade Settings.Create', $permissions)) --}}
                        <button type="reset" class="btn btn-primary" data-bs-toggle="modal" id="createEarnBtn"
                            data-bs-target="#create_indirect_allowanceModal">Create Indirect Allowances</button>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> Indirect Allowances</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Indirect Allowances</th>
                            <th class="border-bottom-0"> Amount</th>
                            <th class="border-bottom-0">Action</th>
                            {{-- <th class="border-bottom-0">other</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($newData as $key => $items)
                            <tr>
                                <td class="font-weight-semibold">{{ ++$key }}</td>
                                <td class="font-weight-semibold" dataedit="{{ $items->id }}">{{ $items->static_component_salary_earning->name == 'others' ? $items->others : ($items->static_component_salary_earning->name ?? '') }}</td>
                                <td class="font-weight-semibold">{{ $items->static_salary_earning_type->name ?? '' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn" class="">
                                            <a class="btn action-btns  btn-sm btn-primary"
                                                data-bs-target="#editearnmodal"
                                                onclick="openEarnEditBtn(this)"
                                                data-id='<?= $items->id ?>'
                                                data-salary_name='<?= $items->salary_id ?>'
                                                data-earn-type=<?=$items->earning_type_id ?>
                                                data-earn-other='{{ $items->others ?? '' }}'
                                                data-earn-id='{{$items}}'
                                                data-bs-toggle="modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a>
                                            <a class="action-btns btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-grade_name='<?= $items->grade_name ?>'
                                                onclick="openDeleteBtn(this)"
                                                data-id='<?= $items->id ?>'
                                                data-salary_name='<?= $items->salary_id ?>'
                                                data-earn-type=<?=$items->earning_type_id ?>
                                                data-earn-other='{{ $items->others ?? '' }}'
                                                data-earn-id='{{$items}}'
                                                data-bs-target="#earnDeleteBtn"
                                                >
                                                <i class="feather feather-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                       --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    {{-- Earning Name Creation Modal --}}
    <div class="modal fade" id="create_indirect_allowanceModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Create Indirect Allowance Component</h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.indirect_allowance') }}" id="addearnFormId">
                    @csrf
                    {{-- <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Create earning component components</p>
                                    <div class="col">
                                        <select name="earning_component" class="form-control" tabindex="1" required
                                            id="optionearn" onchange="showandhide(this)">
                                            @foreach ($data as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col mt-4">
                                        <input name='others' type="text" class="form-control" style="display:none"
                                            id="selectearn" value="" placeholder="Enter Earning Component"
                                            aria-label="Search" tabindex="1" disabled>
                                    </div>
                                   <div class="col mt-4">
                                    <label for="pay_types" class="form-label">Paytypes</label>
                                    <select class="form-control" tabindex="1" name="salary_id" required>
                                        @foreach ($earn_type as $item)
                                            <option value="{{ $item->type_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a
                                            href="#" class="text-primary">Terms & Conditions</a></p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="modal-footer d-flex justify-content-end">
                        @csrf
                        <a type="reset" class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary savebtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- earning name edit modaL --}}
    <div class="modal fade" id="editearnmodal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Edit Earning Component</h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('update.earning') }}" id="addGradeFormId">
                    @csrf
                    {{-- <input type="hidden" name="editearning" value="{{id}}" id="editearningid"> --}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    {{-- <p class="form-label">create earning component components</p> --}}

                                    <span id="edit_earning"></span>

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

    {{-- delte earning modal --}}
    <div class="modal fade" id="earnDeleteBtn" data-bs-backdrop="static" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            {{-- <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="mt-5">Are you sure want to Delete, <span class="text-primary"
                            id="gradeDeleteText"></span> ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="POST" action="{{ url('admin/settings/payroll/delete/earning') }}">
                        @csrf
                        <input type="text" name="deleteId" id="deleteId" hidden>
                        <button type="submit" data-confirm-delete="true" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#">Delete</button>
                    </form>
                </div>
            </div> --}}
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
    var earnName = $(context).data('salary_name');
    var earnType = $(context).data('earn-type');
    var earnOther= $(context).data('earn-other')
    var findid=$(context).closest('tr').find('td[dataedit]').attr('dataedit');

    // console.log('Earning Component', earnName);
    // console.log('earnType', earnType);
    // console.log('earnOther',earnOther);



}

        function showandhide(selectElement) {
            var selectedValue = selectElement.value; // Get the selected value from the <select> element
            var inputField = document.getElementById('selectearn'); // Get the input field
            var optionField = document.getElementById('optionearn');
            if (selectedValue == 9) {
                inputField.style.display = 'block';
                inputField.disabled = false;
            } else {
                optionField.style.display = 'block';
                inputField.style.display = 'none';
                inputField.disabled = true;
            }
        }

        function switch_earn_edit(section)
            {
                var earning_data = document.getElementById('earning_data');
                var earning_input = document.getElementById('earning_input');
                console.log('earning_data',earning_data,'earning_input',earning_input,'section',section.value);
                // var earnother_input = document.getElementById('earnother_input');
                if(section.value == 9)
                {
                    console.log();
                    earning_data.style.display = 'block';
                    earning_input.disabled = false;
                } else {
                    earning_data.style.display = 'none';
                    earning_input.disabled = true;
                }
            }

// for delete the data
            function openDeleteBtn(context) {
            console.log(context);
            var id = $(context).data('id');
    var earnName = $(context).data('salary_name');
    var earnType = $(context).data('earn-type');
    var earnOther= $(context).data('earn-other')
    var findid=$(context).closest('tr').find('td[dataedit]').attr('dataedit');

    console.log('Earning Component', earnName);
    console.log('earnType', earnType);
    console.log('earnOther',earnOther);
         $('#deleteId').val(id);

        }

        // function openDeleteBtn(context) {
        //     var id = $(context).data('id');
        //     var gradeName = $(context).data('grade_name');

        //     $('#gradeDeleteText').html(gradeName);
        // }



    </script>
@endsection

