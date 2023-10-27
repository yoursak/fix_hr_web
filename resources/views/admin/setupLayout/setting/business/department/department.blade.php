@extends('admin.setupLayout.master')
@section('title')
    Salary / Department Setting
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
            <li><a href="{{ url('/setup') }}">Dashboard</a></li>
            <li><a href="{{ url('/setup/business-settings') }}">Settings</a></li>
            <li><a href="{{ url('/setup/business-settings') }}">Business Setting</a></li>
            <li class="active"><span><b>Department Setting</b></span></li>
        </ol>
    </div>
    <form method="POST" action="{{ route('add.department') }}">
        @csrf
        <div class="page-header d-md-flex d-block">
            @php
                $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class
                
                $Department = $centralUnit->DepartmentList();
                $Branch = $centralUnit->BranchList();
                // dd($Department);
                $i = 0;
                $j = 1;
                $root = new App\Helpers\Central_unit();
                // $branchCount=$root->CountersValue();
                $deparmtnetCount = $root->CountersValue();
                
            @endphp
            <div class="page-leftheader">
                <div class="page-title">Department Setting</div>
                <p class="text-muted m-0">
                    <?= $deparmtnetCount[1] ?> Active Department
                </p>
            </div>
            <div class="page-rightheader ms-md-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="d-lg-flex d-block">
                        <div class="btn-list">
                            <button type="reset" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createDepartmentModal">Add Department</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </form>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Department List</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">

                <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            {{-- <th class="border-bottom-0">Branch Name</th> --}}
                            <th class="border-bottom-0">Deparment Name</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        $Departments = $centralUnit->DepartmentList(); ?>

                        {{-- {{$branchList}} --}}
                        @foreach ($Departments as $items)
                            <tr>
                                <td class="font-weight-semibold">{{ $count++ }}</td>
                                {{-- <td class="font-weight-semibold">{{ $items->branch_name }}</td> --}}
                                <td class="font-weight-semibold">{{ $items->depart_name }}</td>
                                <td>
                                    <div class="d-flex">
                                        {{-- {{ $count }} --}}
                                        <div id="actionBtn" class="">
                                            {{-- <a class="btn btn-sm btn-primary" data-bs-target="#modaldemo2"
                                                    data-value1="{{ $items->branch_name }}"
                                                    data-value2="{{ $items->depart_name }}"
                                                    data-id="{{ $items->depart_id }}" data-name="{{ $items->depart_name }}"
                                                    data-bs-toggle="modal" href="#"><i
                                                        class='feather feather-edit'></i>
                                                </a> --}}

                                            {{-- btn btn-sm btn-primary --}}
                                            <a class="btn btn-primary btn-icon action-btns btn-sm"
                                                href="javascript:void(0);" onclick="openEditMasterPolicy(this)"
                                                data-id='<?= $items->depart_id ?>'
                                                data-depart_name='<?= $items->depart_name ?>'
                                                data-branch_id='<?= $items->branch_id ?>' data-bs-toggle="modal"
                                                data-bs-target="#modaldemo2">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>

                                            <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#departDeletebtn{{ $items->depart_id }}"
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

    {{-- <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Departments</b></span></h4>
            </div>
            <div class="card-body ant-table" style="padding:0px">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Branch Name</th>
                                <th class="border-bottom-0">Deparment Name</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            $Departments = $centralUnit->DepartmentList(); ?>

                            @foreach ($Departments as $items)
                                <tr>
                                    <td class="font-weight-semibold">{{ $count++ }}</td>
                                    <td class="font-weight-semibold">{{ $items->branch_name }}</td>
                                    <td class="font-weight-semibold">{{ $items->depart_name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div id="actionBtn{{ $count }}" class="">
                                                <a class="btn btn-sm btn-primary" data-bs-target="#modaldemo2"
                                                    data-value1="{{ $items->branch_name }}"
                                                    data-value2="{{ $items->depart_name }}"
                                                    data-id="{{ $items->depart_id }}"
                                                    data-name="{{ $items->depart_name }}" data-bs-toggle="modal"
                                                    href="#"><i class='feather feather-edit'></i>
                                                </a>

                                                <a class="action-btn btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#departDeletebtn{{ $items->depart_id }}"
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
    </div> --}}

    <div class="modal fade" id="modaldemo2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                {{-- $item->depart_id --}}


                <div class="modal-header">
                    <h6 class="modal-title">Edit Department Preview</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ route('admin.updatedepartment') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="text" class="form-control" id="editId" name="editid" hidden>

                        {{-- <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select id="editbranchs" name='editbranch' class="form-control select2"
                                    data-placeholder="Branch" required>
                                    @foreach ($Branch as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <p class="form-label">Department's Name</p>
                                    <input name='editdepartment' id="editdepart" type="text" class="form-control"
                                        placeholder="Enter Department Name" aria-label="Search" tabindex="1" required>
                                </div>

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

    {{-- Department Name Creation Modal --}}
    <div class="modal fade" id="createDepartmentModal">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Create Department</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.department') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mx-3">
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch' class="form-control select2" data-placeholder="Branch"
                                        required>
                                        @foreach ($Branch as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Department's Name</p>
                                    <input name='department' type="text" class="form-control" value=""
                                        placeholder="Enter Department Name" aria-label="Search" tabindex="1" required>
                                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a
                                            href="#" class="text-primary">Terms & Conditions</a></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        @csrf
                        <button type="reset" class="btn btn-outline-dark cancel"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary savebtn">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($Department as $item)
        {{-- @dd($Department); --}}
        <div class="modal fade" id="departDeletebtn{{ $item->depart_id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->depart_name }}</span> ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                        <form method="POST" action="{{ route('delete.department', $item->depart_id) }}">
                            @csrf
                            <button type="submit" data-confirm-delete="true" class="btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function openEditMasterPolicy(context) {
            var id = $(context).data('id');
            var depart_name = $(context).data('depart_name');
            var branch_id = $(context).data('branch_id');

            $('#editId').val(id);
            $('#editbranchs').val(branch_id);
            $('#editdepart').val(depart_name);
            $('#editbranchs').trigger('change');

        }
    </script>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        new DataTable('#example10', {
            dom: '<"top"lfB>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        });
    </script>
    <script>
        function btnFunc(e) {
            // document.getElementByClassName('animatedBtn').classList.replace(animatedBtn,d-none);
            document.getElementById("actionBtn" + e.id).classList.toggle("d-none");
            document.getElementById("actionBtn" + e.id).classList.toggle("animatedBtn");
        }
    </script>
@endsection
@endsection
