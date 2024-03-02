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
@endsection

@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Grade Settings</b></span></li>
        </ol>
    </div>

    @csrf
    <div class="page-header d-md-flex d-block">
        @php
            $centralUnit = new App\Helpers\Central_unit(); // Create an instance of the Central_unit class

            $Department = $centralUnit->DepartmentList();
            $Branch = $centralUnit->BranchList();
            $i = 0;
            $root = new App\Helpers\Central_unit();
            $gradeCount = $root->CountersValue();

        @endphp
        <div class="page-leftheader">
            <div class="page-title">Grade Settings</div>
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
                            data-bs-target="#createGradeModal">Create Grade</button>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Grade List</h3>
        </div>
        <livewire:settings.grade-lst-livewre>
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
                                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                            class="text-primary">Terms & Conditions</a></p>
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
