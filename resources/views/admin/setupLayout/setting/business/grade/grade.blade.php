@extends('admin.setupLayout.master')
@section('title')
    Grade Settings
@endsection

@section('css')
    <style>
        .rotate {
            transition: 500ms;
            transform: rotate(90deg);
            /* Adjust the desired rotation value */
        }

        .bg-inf {
            /* background-color: #a3d5dd; */
            /* Change to your desired color */
        }
    </style>
@endsection
@section('content')
    <style>
        /* Set the map's size */
        #map {
            height: 400px;
            width: 100%;
        }

        /* Adjust the search input style */
        #searchInput {
            width: 100%;
            margin-bottom: 10px;
        }

        #editaddressNameId {
            width: 100%;
            margin-bottom: 10px;

        }

        #mapeditload {
            height: 400px;
            width: 100%;

        }

        .pac-container {
            z-index: 10000 !important;
            /* Set a high z-index for the autocomplete dropdown */
        }
    </style>
    @php
        // dd($permissions);
        $root = new App\Helpers\Central_unit();
        $branch = $root->BranchList();
        $branchCount = $root->CountersValue();

        $i = 0;
        foreach ($branch as $item) {
            $i++;
        }
    @endphp
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
            <div>
                <h3 class="card-title">Grade List</h3>
            </div>
            <div class="d-flex btn-list">
                <button type="reset" class="btn btn-primary" data-bs-toggle="modal" id="createGradeBtn"
                    data-bs-target="#createGradeModal">Create Grade</button>

            </div>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Grade Name</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $items)
                            <tr>
                                <td class="font-weight-semibold">{{ ++$key }}</td>
                                <td class="font-weight-semibold">{{ $items->grade_name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn" class="">
                                            {{-- @if (in_array('Grade Settings.Update', $permissions)) --}}
                                            <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                                onclick="openGradeEditBtn(this)" data-id='<?= $items->id ?>'
                                                data-grade_name='<?= $items->grade_name ?>' data-bs-toggle="modal"
                                                href="#">
                                                <i class='feather feather-edit'></i></a>
                                            {{-- @endif --}}
                                            {{-- @if (in_array('Grade Settings.Delete', $permissions)) --}}
                                            <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-grade_name='<?= $items->grade_name ?>' onclick="openDeleteBtn(this)"
                                                data-id='<?= $items->id ?>' data-bs-target="#gradeDeleteBtn"
                                                id="BranchEditbtn"><i class="feather feather-trash"></i>
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
                                    <p class="form-label">Grade Name</p>
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
                    <h4 class="modal-title ms-2">Create Grade</h4><button aria-label="Close" class="btn-close"
                        id="createdGrade" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.grade') }}" id="addGradeFormId">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Grade Name</p>
                                    <input name='Grade' type="text" class="form-control" value=""
                                        placeholder="Enter Grade Name" aria-label="Search" tabindex="1" required>
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
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Back</a>
        </div>

        <div class="d-flex">
            {{-- <a href="{{ url('setup/attendance-settings') }}" id="saveButton"  class="btn btn-primary">Save & Continue</a> --}}
        </div>
    </div>

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
