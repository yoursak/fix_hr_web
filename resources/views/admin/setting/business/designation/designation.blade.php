@extends('admin.setting.setting')
@section('subtitle')
Salary / Designation Setting
@endsection

@section('css')
<style>
    .dataTables_wrapper .dt-buttons {
        float: none;
        text-align: center;

    }

    .top {
        padding: 10px;
    }

    th {
        text-align: center;
    }

    /* Aman Sir */
    .animatedBtn {
        position: relative;
        animation-name: example;
        animation-duration: 200ms;
    }

    @keyframes example {
        0% {
            left: 30px;

        }

        100% {
            left: 0px;

        }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection

@section('settings')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

<form method="POST" action="{{ route('add.designation') }}">
    @csrf
    <div class="page-header d-md-flex d-block">
        @php
        $Designation = App\Helpers\Central_unit::DesignationList();
        $Branch = App\Helpers\Central_unit::BranchList();
        $Department = App\Helpers\Central_unit::DepartmentList();
        // dd($Department);
        $i = 0;
        $j = 1;
        foreach ($Designation as $item) {
        $i++;
        }

        @endphp
        <div class="page-leftheader">
            <div class="page-title">Designation Setting</div>
            <p class="text-muted">{{ $i }} Active Designation</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="reset" id="addNewDepartment" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Create Designation</button>
                        <button type="submit" id="SaveNewDepartment" class="btn btn-outline-success d-none"
                            data-bs-toggle="modal" data-bs-target="#clockinmodal">Save Designation</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Designations</b></span></h4>
            </div>
            <div class="card-body d-none" id="addDepartment">
                <div class="row">
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Designation
                                            Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Branch</p>
                                        <select name='branch' id="country-dd" class="form-control select2">
                                            <option value="">Select Branch Name</option>
                                            @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department</p>
                                        <div class="form-group mb-3">
                                            <select id="state-dd" name="department" class="form-control">
                                                <option value="">Select Deparment Name</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Designation's Name</p>
                                        <input name='designation' type="text" class="form-control" value=""
                                            placeholder="Enter Designation Name" aria-label="Search" tabindex="1"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body ant-table" style="padding:0px">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Branch Name</th>
                                <th class="border-bottom-0">Department Name</th>
                                <th class="border-bottom-0">Designation Name</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Designation as $item)
                            <tr>
                                <td class="font-weight-semibold">{{ $j++ }}.</td>
                                <td class="font-weight-semibold">{{ $item->branch_name }}</td>
                                <td class="font-weight-semibold">{{ $item->depart_name }}</td>
                                <td class="font-weight-semibold">{{ $item->desig_name }}</td>
                                <td>
                                    {{-- <div class="d-flex"> --}}
                                       
                                        <a href="javascript:void(0);" class="" data-bs-toggle="modal"
                                            data-bs-target="#departDeletebtn{{ $item->desig_id }}" id="BranchEditbtn"
                                            title="Edit">
                                            <i class="feather feather-trash  text-dark"  style='font-size:24px;padding:0px;'></i>
                                        </a>

                                        <a class="btn" data-bs-target="#modaldemo1"
                                            data-value1="{{ $item->branch_name}}" data-value2="SecondValue"
                                            data-id="{{ $item->desig_id }}" data-name="{{ $item->desig_name }}"
                                            data-bs-toggle="modal" href="#">
                                            <i class='feather feather-edit  text-dark' style='font-size:24px'></i></a>

                                    {{-- </div> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</form>


<div class="modal fade" id="modaldemo1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <form method="POST" action="{{ route('admin.designationupdate', $item->id) }}">
                @csrf

                <div class="modal-header">
                    <h6 class="modal-title">Edit Designation Preview</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="editId" name="editid" value="">

                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <p class="form-label">Branch</p>
                            <input type="text" class="form-control" id="value1" readonly>
                            <select name='editbranch' id="editbranch-dd" class="form-control " required>
                                <option value="">Select Branch Name </option>
                                @foreach ($Branch as $data)
                                <option value="{{ $data->branch_id }}">
                                    {{ $data->branch_name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <p class="form-label">Department</p>
                            <input type="text" class="form-control" id="value2" readonly>
                            <div class="form-group mb-3">
                                <select id="edit_state" name="editdepartment" class="form-control" required>
                                    <option value="">Select Deparment Name</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <p class="form-label">Designation's Name</p>
                            <input name='editdesignation' id="editName" type="text" class="form-control" value=""
                                placeholder="Enter Designation Name" aria-label="Search" tabindex="1" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary savebtn">Update Continue</button>

                </div>
            </form>
        </div>
    </div>

</div>

{{-- @endforeach --}}
@foreach ($Designation as $item)
{{-- @dd($item); --}}
<div class="modal fade" id="departDeletebtn{{ $item->desig_id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->desig_name }}</span> ?</h3>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                <form method="POST" action="{{ route('delete.designation', $item->desig_id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script>
    new DataTable('#example10', {
            dom: '<"top"lfB>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        });
</script>
<script>
    function btnFunc(e) {
            document.getElementById("actionBtn" + e.id).classList.toggle("d-none");
            document.getElementById("actionBtn" + e.id).classList.toggle("animatedBtn");
        }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Create Method
        $(document).ready(function() {
            $('#country-dd').on('change', function() {
                var branch_id = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log(result);
                        $('#state-dd').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#state-dd").append('<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });




                        // $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            // $('#state-dd').on('change', function() {
            //     var idState = this.value;
            //     $("#city-dd").html('');
            //     $.ajax({
            //         url: "{{ url('api/fetch-cities') }}",
            //         type: "POST",
            //         data: {
            //             state_id: idState,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             $('#city-dd').html('<option value="">Select City</option>');
            //             $.each(res.cities, function(key, value) {
            //                 $("#city-dd").append('<option value="' + value
            //                     .id + '">' + value.name + '</option>');
            //             });
            //         }
            //     });
            // });
        });

        // EDIT Method
        $(document).ready(function() {
            $('#editbranch-dd').on('change', function() {
                var branch_id = this.value;

                $("#edit_state").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log(result);
                        $('#edit_state').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#edit_state").append(
                                '<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });


                        // $('#edit_state').html(
                        //     '<option value="" name="department">Select Department Name</option>'
                        // );
                        // $.each(result.department, function(key, value) {
                        //     $("#edit_state").append('<option name="department" value="' +
                        //         value
                        //         .depart_id + '">' + value.depart_name +
                        //         '</option>');
                        // });
                        // $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            // $('#state-dd').on('change', function() {
            //     var idState = this.value;
            //     $("#city-dd").html('');
            //     $.ajax({
            //         url: "{{ url('api/fetch-cities') }}",
            //         type: "POST",
            //         data: {
            //             state_id: idState,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             $('#city-dd').html('<option value="">Select City</option>');
            //             $.each(res.cities, function(key, value) {
            //                 $("#city-dd").append('<option value="' + value
            //                     .id + '">' + value.name + '</option>');
            //             });
            //         }
            //     });
            // });
        });
    
        
        $(document).ready(function() {
    // Bind to the modal's show event
    $('#modaldemo1').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var value1 = button.data('value1');
        var value2 = button.data('value2');
        console.log(value1);
        $('#value1').val(value1);
        $('#value2').val(value2);
        
        $('#editId').val(id);
        $('#editName').val(name);
   
        // var id = $(event.relatedTarget).data('id');
        // $('#editroot').val(id);
        // $.ajax({
        //     type: 'get',
        //     url: '{{ route("admin.designation", ["id" => 'id']) }}', // Replace 'id' with the actual id value,
        //     data: {
        //         id: id // Pass the id as a data parameter
        //     },
        //     success: function(data) {
        //         // document.getElementById("editbranch-dd").value=999;
        //         console.log(data.editDesignationResult);
               
        //         // console.log(data.editDesignationResult.depart_id);
        //         // document.getElementById('editbranchload').value='2';
        //         // $('#editbranchload').attr('name', 'new_name_value');
        //         // console.log(data.editDesignationResult.desig_name);

        //         // Handle the response data here and set the value in the input field
        //     },
        //     error: function(xhr, status, error) {
        //         console.error(error);
        //     }
        // });
        });
    });

</script>
@endsection