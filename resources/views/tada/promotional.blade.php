@extends('admin.pagelayout.master')
@section('title')
    Promotional Category
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
{{-- @if (in_array('Grade Settings.View', $permissions)) --}}
@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Promotional Settings</b></span></li>
        </ol>
    </div>
    {{-- <form method="POST" action="{{ route('add.department') }}"> --}}
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
            $gradeCount = $root->CountersValue();

        @endphp
        <div class="page-leftheader">
            <div class="page-title">Promotional Category Settings</div>
            <p class="text-muted m-0">
                <?= $gradeCount[7] ?> Active Grade
            </p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        {{-- @if (in_array('Grade Settings.Create', $permissions)) --}}
                        <button type="reset" class="btn btn-primary" data-bs-toggle="modal" id="createGradeBtn"
                            data-bs-target="#createGradeModal">Promotional Category</button>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- </form> --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Promotional Category</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Promotional Category</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data as $key => $items)
                    <tr>
                        <td class="font-weight-semibold">{{ ++$key }}</td>
                        <td class="font-weight-semibold">{{ $items->grade_name }}</td>
                        <td>
                            <div class="d-flex">
                                <div id="actionBtn" class="">
                                    <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1" onclick="openGradeEditBtn(this)" data-id='<?= $items->id ?>' data-grade_name='<?= $items->grade_name ?>' data-bs-toggle="modal" href="#">
                                        <i class='feather feather-edit'></i></a>
                                    <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal" data-grade_name='<?= $items->grade_name ?>' onclick="openDeleteBtn(this)" data-id='<?= $items->id ?>' data-bs-target="#gradeDeleteBtn" id="BranchEditbtn"><i class="feather feather-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach --}}
                        <?php ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modaldemo1" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Grade</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ route('admin.updateGrade') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="text" class="form-control" id="editId" name="editid" hidden>
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <p class="form-label">Promotional Category</p>
                                    <input name='editGrade' id="editGrade" type="text" class="form-control"
                                        placeholder="Enter Grade Name" aria-label="Search" tabindex="1" required>
                                </div>

                            </div>
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

    {{-- Grade Name Creation Modal --}}
    <div class="modal fade" id="createGradeModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Promotional Category</h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.promotional') }}" id="addGradeFormId">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Promotional Category</p>
                                    <input name='Grade' type="text" class="form-control" value=""
                                        placeholder="Enter Grade Name" aria-label="Search" tabindex="1" required>
                                </div>
                                <div class="form-group">
                                    <p class="form-label">Amount Limit</p>
                                    <input name="amountlist" type="text" class="form-control" value=""
                                        placeholder="Enter Grade Name" aria-label="Search" tabindex="1" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="form-group  select2-lg ">
                                    <label for="inputPassword4">
                                        Grade
                                    </label>

                                    <select multiple="multiple" id="countryId1" class="SlectBox-grp-src" name="grade[]">
                                        @foreach ($gradeData as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->grade_name }}
                                            </option>
                                        @endforeach
                                    </select>
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

    {{-- @foreach ($Grade as $item) --}}
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
                    <h4 class="mt-5">Are you sure want to Delete, <span class="text-primary"
                            id="gradeDeleteText"></span> ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="POST" action="{{ route('delete.grade') }}">
                        @csrf
                        <input type="text" name="deleteId" id="deleteId" hidden>
                        <button type="submit" data-confirm-delete="true" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#createGradeBtn").on('click', function() {
            $('#addGradeFormId').trigger('reset');
            $('#createGradeModal').modal('show');
        });

        function openGradeEditBtn(context) {
            console.log(this);
            var id = $(context).data('id');
            var gradeName = $(context).data('grade_name');
            $('#editId').val(id);
            $('#editGrade').val(gradeName);
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
    </script>
@endsection
{{-- @endif --}}
