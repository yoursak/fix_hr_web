@extends('admin.setupLayout.master')

@section('title')
    Designation Setting
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

@if (in_array('Designation Settings.View', $permissions))
    @section('content')
            {{-- <div class=" p-0 my-3">
                <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                    <li><a class="text-white">Dashboard</a></li>
                    <li><a class="text-white">Business Setting</a></li>
                    <li class="active"><span><b>Designation Setting</b></span></li>
                </ol>
            </div> --}}

        @php
            $root = new App\Helpers\Central_unit();
            $Designation = $root->DesignationList();
            $Branch = $root->BranchList();

            $Department = $root->DepartmentList();
            $j = 1;

            $designationCount = $root->CountersValue();

        @endphp

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h3 class="card-title">Designation List</h3>
                </div>
                <div class="d-flex btn-list">
                    @if (in_array('Designation Settings.Create', $permissions))
                        <button type="reset" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createDesignationModal">Create Designation</button>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="">
                        <thead>
                            <tr class="text-align-left">
                                <th style="text-align: left;" class="border-bottom-0 ">S.No.</th>
                                <th style="text-align: left;" class="border-bottom-0">Designation Name</th>
                                <th style="text-align: left;" class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $j = 1;
                            @endphp
                            @if (!$Designation->isEmpty())
                                @foreach ($Designation as $item)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                                        <td class="font-weight-semibold">{{ $item->desig_name }}</td>
                                        <td>



                                            <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                onclick="openEditDesignation(this)" data-branch_id='<?= $item->branch_id ?>'
                                                data-id='<?= $item->desig_id ?>'
                                                data-depart_id='<?= $item->department_id ?>'
                                                data-desig_name='<?= $item->desig_name ?>' data-bs-toggle="modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a>
                                            <a class="btn action-btns  btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#departDeletebtn{{ $item->desig_id }}" id="BranchEditbtn"
                                                title="Edit">
                                                <i class="feather feather-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No data available</td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createDesignationModal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Create Designation</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST" action="{{ route('add.designation') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row ">
                                <div class="col-12">
                                    <div class="form-group">
                                        <p class="form-label">Designation Name</p>
                                        <input name='designation' type="text" class="form-control" value=""
                                            placeholder="Enter Designation Name" aria-label="Search" tabindex="1"
                                            required>
                                    </div>
                                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                            class="text-primary">Terms & Conditions</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end ">
                            @csrf
                            <button type="reset" class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary savebtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modaldemo1" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit Designation</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{ route('admin.designationupdate') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class=" custom-selectform-control " id="editId" name="editid"
                                hidden>
                            <div class="form-group">
                                <p class="form-label">Designation's Name</p>
                                <input name='editdesignation' id="editName" type="text" class="form-control"
                                    value="" placeholder="Enter Designation Name" aria-label="Search"
                                    tabindex="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @foreach ($Designation as $item)
            <div class="modal fade" id="departDeletebtn{{ $item->desig_id }}" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="mt-5">Are you sure want to Delete, <span
                                    class="text-primary">{{ $item->desig_name }}</span> ?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form method="POST" action="{{ route('delete.designation', $item->desig_id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Back</a>
            </div>

            <div class="d-flex">
                {{-- <a href="{{ url('setup/attendance-settings') }}" id="saveButton"  class="btn btn-primary">Save & Continue</a> --}}
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            function btnFunc(e) {
                document.getElementById("actionBtn" + e.id).classList.toggle("d-none");
                document.getElementById("actionBtn" + e.id).classList.toggle("animatedBtn");
            }
        </script>
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
                        }
                    });
                });

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
                                '<option  value="" name="department">Select Department Name</option>'
                            );
                            $.each(result.department, function(key, value) {

                                $("#edit_state").append(
                                    '<option name="department" value="' +
                                    value
                                    .depart_id + '">' + value.depart_name +
                                    '</option>');
                            });


                        }
                    });
                });

            });

            function openEditDesignation(context) {
                var id = $(context).data('id');
                var branch_id = $(context).data('branch_id');
                var depart_id = $(context).data('depart_id');
                var desig_name = $(context).data('desig_name');
                console.log(depart_id);
                $('#editId').val(id);
                $('#editbranch-dd').val(branch_id);
                $('#edit_state').val(depart_id);
                $('#editName').val(desig_name);
                setTimeout(function() {
                    $('#edit_state').val(depart_id);
                }, 500);
                $('#editbranch-dd,#edit_state').trigger('change');

            }
        </script>
    @endsection
@endif
