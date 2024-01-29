@extends('admin.pagelayout.master')

@section('title')
    Designation Settings
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


@section('content')
    @if (in_array('Designation Settings.View', $permissions))
        <div class=" p-0 mt-3">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
                <li class="active"><span><b>Designation Settings</b></span></li>
            </ol>
        </div>
        <form method="POST" action="{{ route('add.designation') }}">
            @csrf
            <div class="page-header d-md-flex d-block">
                @php
                    $root = new App\Helpers\Central_unit();
                    $Designation = $root->DesignationList();
                    $Branch = $root->BranchList();

                    $Department = $root->DepartmentList();
                    $j = 1;

                    $designationCount = $root->CountersValue();

                @endphp
                <div class="page-leftheader">
                    <div class="page-title">Designation Settings</div>
                    <p class="text-muted m-0">{{ $designationCount[2] }} Active Designation</p>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="d-lg-flex d-block ms-auto">
                            <div class="btn-list">
                                @if (in_array('Designation Settings.Create', $permissions))
                                    <button type="reset" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createDesignationModal">Create Designation</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Designation List</h3>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">

                    <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                {{-- <th class="border-bottom-0">Branch Name</th>
                            <th class="border-bottom-0">Department Name</th> --}}
                                <th class="border-bottom-0">Designation Name</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $j = 1;
                            @endphp
                            @foreach ($Designation as $item)
                                <tr>
                                    <td class="font-weight-semibold">{{ $j++ }}.</td>
                                    <td class="font-weight-semibold">{{ $item->desig_name }}</td>
                                    <td>
                                        @if (in_array('Designation Settings.Update', $permissions))
                                            <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                onclick="openEditDesignation(this)" data-branch_id='<?= $item->branch_id ?>'
                                                data-id='<?= $item->desig_id ?>'
                                                data-depart_id='<?= $item->department_id ?>'
                                                data-desig_name='<?= $item->desig_name ?>' data-bs-toggle="modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a>
                                        @endif
                                        @if (in_array('Designation Settings.Delete', $permissions))
                                            <a class="btn action-btns  btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#departDeletebtn{{ $item->desig_id }}" id="BranchEditbtn"
                                                title="Edit">
                                                <i class="feather feather-trash"></i>
                                        @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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
                                <p class="form-label">Designation Name</p>
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

                            console.log("result" + result);
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
                    console.log("branch_id " + branch_id);
                    $.ajax({
                        url: "{{ url('admin/settings/business/alldepartment') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            brand_id: branch_id
                        },
                        dataType: 'json',
                        success: function(result) {

                            console.log("result" + result);
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
    @endif
@endsection
