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
                            data-bs-target="#createEarnModal">Create Earning Component</button>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Earning Components</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Name Component</th>
                            <th class="border-bottom-0">Earning Name</th>
                            <th class="border-bottom-0"> Calculation Types </th>
                            <th class="border-bottom-0">  Amount </th>
                            <th class="border-bottom-0">Action</th>
                            {{-- <th class="border-bottom-0">other</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newData as $key => $items)
                        {{-- @dd($items); --}}
                            <tr>
                                <td class="font-weight-semibold">{{ ++$key }}</td>
                                <td class="font-weight-semibold">{{ $items->custom_earning_compo ?? '' }}</td>
                                <td class="font-weight-semibold" dataedit="{{ $items->id }}">{{ $items->policy_salary_static_earning_component->name == 'others' ? $items->others : ($items->policy_salary_static_earning_component->name ?? '') }}</td>
                                     {{-- <td class="font-weight-semibold">{{ $items->static_salary_earning_type->name ?? '' }}</td> --}}
                                     {{-- <td class="font-weight-semibold">{{$items->earning_type_id == 1 && $items->static_salary_earning_type->name == 'Percentage(%)' ? $items->static_salary_earning_type->name. 'of Ctc' :  $items->static_salary_earning_type->name. 'of Basic' }}</td> --}}
                                     <td class="font-weight-semibold">
                                        {{ $items->static_salary_earning_type->name == 'Percentage(%)' ? ($items->earning_type_id == 1 ? 'Percentage(%) of Ctc' : 'Percentage(%) of Basic') : $items->static_salary_earning_type->name }}
                                    </td>


                                <td class="font-weight-semibold">{{ $items->earning_amount_percent ?? '' }} </td>
                                {{-- <td class="font-weight-semibold">
                                    {{ $items->earning_amount_percent == 'Fixed' ? $items->earning_amount_percent.'YES' : $items->earning_amount_percent.'sdfgdfgfds' }}
                                </td> --}}
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn" class="">
                                            {{-- @if (in_array('Grade Settings.Update', $permissions)) --}}
                                            <a class="btn action-btns  btn-sm btn-primary"
                                                data-bs-target="#editearnmodal"
                                                onclick="openEarnEditBtn(this)"
                                                data-id='<?= $items->id ?>'
                                                data-salary_name = '<?= $items->salary_id ?>'
                                                data-earn-type = <?=$items->earning_type_id ?>
                                                data-earn-other = '{{ $items->others ?? '' }}'
                                                data-earn-id = '{{$items}}'
                                                data-custom-earn = '{{ $items->earning_amount_percent ?? '' }}'
                                                data-custom-name = '{{ $items->custom_earning_compo ?? '' }}'
                                                data-bs-toggle = "modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a>
                                            {{-- @endif --}}
                                            {{-- @if (in_array('Grade Settings.Delete', $permissions)) --}}
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
                                                {{-- id="BranchEditbtn" --}}
                                                >
                                                <i class="feather feather-trash"></i>
                                            </a>
                                            {{-- @endif --}}
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
                    <h4 class="modal-title ms-2">Create Earning Component</h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.earning') }}" id="addearnFormId">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Earning Components</p>
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
                                        <label for="payslip_name" class="form-label">Enter Your Payslip Name</label>
                                        <input name='payslip_name' type="text" class="form-control"
                                            id="payslip_id" value="" placeholder="Enter Earning Component"
                                            aria-label="Search" tabindex="1" required>
                                    </div>

                                   <div class="col mt-4">
                                    <label for="pay_types" class="form-label">Calculation Types</label>
                                    <select class="form-control" tabindex="1" name="salary_id" id="selectpaytype" onchange="selectpaytypes(this);custom_set_function(this)"  required>
                                        <option value="">Select Calculation Types</option>
                                        @foreach ($earn_type as $item)
                                            <option value="{{ $item->type_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                {{-- for create div on selectpaytypes --}}
                                <div class="col mt-4">
                                    <input name='custompay_amount' type="text" class="form-control" style="display:none"
                                    id="custompay_amount" value="" placeholder="Enter Custom values"
                                        aria-label="Search" tabindex="1" disabled>
                                </div>
                                {{-- for create input on % section  --}}
                                {{-- <div class="display-flex justify-content-between"> --}}
                                   <div class="row d-flex justify-content-between">
                                        <div class="col-8 mt-4">
                                            <input name='custom_amount_percent' type="text" class="form-control" style="display:none"
                                            id="selectpay_amount_percent" value="" onchange="percentage_choose(this)" placeholder="Enter Percentage Component"
                                                aria-label="Search" tabindex="1" disabled>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <input name='custom_appendName' type="text" class="form-control"
                                            id="custom_apppendId" value="" placeholder="Enter Percentage Component"
                                            style="display:none" disabled >
                                        </div>
                                   </div>
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
            <div class="modal-content modal-content-demo">
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
    var earnName = $(context).data('salary_name');
    var earnType = $(context).data('earn-type');
    var earnOther = $(context).data('earn-other');
    var custom_earn = $(context).data('custom-earn');
    var custom_name = $(context).data('custom-name');
    var findid=$(context).closest('tr').find('td[dataedit]').attr('dataedit');

    // console.log('Earning Component', earnName);
    // console.log('earnType', earnType);
    // console.log('earnOther',earnOther);
    console.log('custom_name',custom_name);

    var newItemHtml = `
        <div class="col-12">
            <div class="form-group">
                <label class="form-label">Earning Component</label>
                <select name="earnName" id="earn_name" class="form-control" placeholder="enter earning components"  onchange="switch_earn_edit(this)" required>
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}" ${earnType == {{$item->id}} ? 'selected' : ''}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="edit" value="${findid}">

            <div class="form-group" id="custom_name_id" >
                    <label class="form-label">Name Component</label>
                    <input type="text"   class="form-control" name="custom_name" value="${custom_name}" placeholder="Enter Earning Component" aria-label="Search"  tabindex="1"  required>
            </div>

            ${earnOther == '' ? `<div class="col mt-4" id="earning_data"  style="display:none">
                <input name='earnOther' id="earning_input" type="text" class="form-control" value="" placeholder="Enter Earning Component" aria-label="Search" tabindex="1" disabled>
            </div>` :
                `<div class="form-group" id="earning_data" >
                    <label class="form-label">Earning Component</label>
                    <input type="text"  id="earning_input" class="form-control" name="earnOther" value="${earnOther}" placeholder="Enter Earning Component" aria-label="Search" id="earnother_input" tabindex="1"  required>
                </div>`
            }

            <div class="col mt-4" id="earnother">
                <input name='others_' type="text" class="form-control" style="display:none"
                {{ $items->others ?? '' }} placeholder="Enter Earning Component"
                    aria-label="Search" tabindex="1" disabled>
            </div>
            <div class="form-group">
                <label for="pay_types" class="form-label">Paytypes</label>
                <select class="form-control" id="earnType_id" name="earnType" required>
                    @foreach ($earn_type as $item)
                        <option value="{{ $item->type_id }}" ${earnName == {{$item->type_id}} ? 'selected' : ''}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="custom_earn_id" >
                    <label class="form-label">Amount</label>
                    <input type="text"   class="form-control" name="custom_earn" value="${custom_earn}" placeholder="Enter Earning Component" aria-label="Search"  tabindex="1"  required>
            </div>

            <p class="mb-0 pb-0 text-muted fs-12 mt-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p>
        </div>`;

    $('#edit_earning').empty().append(newItemHtml);


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
            if(selectedValue == 1 )
            {
                document.getElementById('custom_apppendId').value  = 'of CTC';
                document.getElementById('custom_apppendId').disabled  = true; ;
            }else if(selectedValue != 1)
            {
                document.getElementById('custom_apppendId').value  = 'of Basic';
                document.getElementById('custom_apppendId').disabled  = true;
            }
        }

        function switch_earn_edit(section)
            {
                var earning_data = document.getElementById('earning_data');
                var earning_input = document.getElementById('earning_input');
                // console.log('earning_data',earning_data,'earning_input',earning_input,'section',section.value);
                console.log(section.value.name);
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

        function selectpaytypes(section) {
                var custompay_amount = document.getElementById("custompay_amount");
                var selectpay_amount_percent = document.getElementById("selectpay_amount_percent");
                var custom_apppendId = document.getElementById("custom_apppendId");


                // if(earningComponentValue == 1 && selectpaytype == 2)
                // {
                //     console.log("hii");
                // }
                // console.log(section.value);
                if (section.value == 1) {
                    custompay_amount.style.display = "block";
                    custompay_amount.disabled = false;
                    selectpay_amount_percent.style.display = "none";
                    custom_apppendId.style.display = "none";
                    // select_earn_compo.style.display = "none"
                    selectpay_amount_percent.disabled = true;
                }
                if (section.value == 2)
                {
                    custompay_amount.style.display = "none";
                    custompay_amount.disabled = true;
                    selectpay_amount_percent.style.display = "block";
                    selectpay_amount_percent.disabled = false;
                    custom_apppendId.style.display = "block";
                    // select_earn_compo.style.display = "block"
                }




        }

        function custom_set_function(value) {
              console.log('aaya data  new',value.value);
               var earningComponentValue = document.getElementById('optionearn').value;
              if(value.value == 2 && earningComponentValue == 1 ){

                document.getElementById("custom_apppendId").value = 'of CTC';
                // custom_appendName.value = ;
              }
              else if(value.value == 2 && earningComponentValue == 2)
              {
                document.getElementById("custom_apppendId").value = 'of basic';
              }else{
                document.getElementById("custom_apppendId").value = " ";
              }

        }





    </script>
@endsection
