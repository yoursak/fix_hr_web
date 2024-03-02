@extends('admin.pagelayout.master')
@section('title', 'Notice')
@section('css')

@endsection
@if (in_array('Notice Board.View', $permissions))
@section('content')
<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
        <li class="active"><span><b>Notice Board</b></span></li>
    </ol>
</div>
<!-- PAGE HEADER -->
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Notice Board</div>
        <p>Create Your Business Notice Board to Share Updates</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block ms-auto">
                <div class="btn-list">
                    @if (in_array('Notice Board.Create', $permissions))
                    {{-- <a href="javascript:void(0);" class="btn btn-primary me-3 float-right"
                                    data-bs-toggle="modal" data-bs-target="#addnoticemodal">Create New Notice</a> --}}
                    <a href="javascript:void(0);" class="btn btn-primary me-3 float-right" id="create_new_notices_btn">Create New Notice</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
<!--END PAGE HEADER -->

<!-- ROW -->

<livewire:settings.notice-livewire>
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
                            </div><input class="form-control fc-datepicker" name="date" placeholder="dd/mm/yy" type="date" id="datepicker" required>
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
