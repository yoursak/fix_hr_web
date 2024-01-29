@extends('admin.setupLayout.master')
@section('title', 'Notice')
@section('css')
@endsection
@if (in_array('Notice Board.View', $permissions))
    @section('content')
        <!-- ROW -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h3 class="card-title">Notice Summary</h3>
                        </div>
                        <div class="d-flex btn-list">
                            @if (in_array('Notice Board.Create', $permissions))
                                <a href="javascript:void(0);" class="btn btn-primary me-3" data-bs-toggle="modal" id="create_new_notices_btn"
                                   ">Create New Notice</a>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="card-header  border-0">
                        <h4 class="card-title">Notice Summary</h4>
                    </div> --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap border-bottom-1" id="hr-notice">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0 w-5">S.No.</th>
                                        <th class="border-bottom-0">Title</th>
                                        <th class="border-bottom-0">Description</th>
                                        <th class="border-bottom-0">Date</th>
                                        <th class="border-bottom-0 text-center">Uploaded Files</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$Notice->isEmpty())
                                        @foreach ($Notice as $key => $notice)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $notice->title }}</td>
                                                <td>{{ $notice->description }}</td>
                                                <td>{{ \Carbon\Carbon::parse($notice->date)->format('d-m-Y') }}</td>
                                                <td class="text-center"><a
                                                        href="{{ url('notice_uploads/' . $notice->file) }}"><span
                                                            class="text-primary">View file</span></a></td>
                                                <td>
                                                    @if (in_array('Notice Board.Delete', $permissions))
                                                        <div class="d-flex">
                                                            <a type="" class="btn btn-sm btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deletenoticemodal{{ $notice->id }}"
                                                                title="Delete"><i
                                                                    class="feather feather-trash-2 text-kight"></i></a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="deletenoticemodal{{ $notice->id }}"
                                                data-bs-backdrop="static">
                                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmation</h5>
                                                            <button class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('delete.notice', [$notice->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body text-center">
                                                                <h4 class="mt-5">Are You Sure Want to Delete
                                                                    {{ $notice->title }}</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#" type="reset" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</a>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Data Found</td>

                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->

        <!-- ADD LEAVE MODAL -->
        <div class="modal fade" id="addnoticemodal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Notice</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('create.notice') }}" method="post" enctype="multipart/form-data" id="addNoticeFormId">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label">Title<span>*</span></label>
                                <input class="form-control" name="title" placeholder="Title" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Select Date<span>*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" name="date" placeholder="dd/mm/yy"
                                        type="date" id="datepicker" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Attachment<span>*</span></label>
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <input class="form-control" type="file" name="image" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" cols="100" style="width: 100%"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END ADD LEAVE MODAL -->

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
            $("#create_new_notices_btn").on('click', function() {
                $('#addNoticeFormId').trigger('reset');
                $('#addnoticemodal').modal('show');
            });
        </script>
        <!-- INTERNAL  DATEPICKER JS -->
        <script src="{{ asset('assets/plugins/modal-datepicker/datepicker.js') }}"></script>
        <!-- INTERNAL SUMMERNOTE JS  -->
        <script src="{{ asset('assets/plugins/summer-note/summernote1.js') }}"></script>
        <script src="{{ asset('assets/js/summernote.js') }}"></script>

        <!-- INTERNAL INDEX JS -->
        <script src="{{ asset('assets/js/hr/hr-notice.js') }}"></script>
    @endsection
@endif
