@extends('admin.pagelayout.master')
@section('title', 'Dashboard')
@section('css')

@endsection
@section('content')


<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        {{-- <li><a href="{{ url('admin/settings/business')}}">Settings</a></li> --}}
        <li><a href="{{ url('admin/settings/business')}}">Business Setting</a></li>
        <li class="active"><span><b>Notice Board</b></span></li>
    </ol>
</div>
    <!-- PAGE HEADER -->   
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Notice Board</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="btn-list">
                    <a href="javascript:void(0);" class="btn btn-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#addnoticemodal">Create New Notice</a>
                    <button class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="E-mail"> <i
                            class="feather feather-mail"></i> </button>
                    <button class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip" title="Contact"> <i
                            class="feather feather-phone-call"></i> </button>
                    <button class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip" title="Info"> <i
                            class="feather feather-info"></i> </button>
                </div>
            </div>
        </div>
    </div>
    <!--END PAGE HEADER -->

    <!-- ROW -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Notice Summary</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap border border-bottom-3  " id="hr-notice">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">No</th>
                                    <th class="border-bottom-0">Title</th>
                                    <th class="border-bottom-0">Description</th>
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0 text-center">Uploaded Files</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($Notice ?? false)
                                @foreach ($Notice as $key => $notice)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$notice->title}}</td>
                                    <td>{{$notice->description}}</td>
                                    <td>{{$notice->date}}</td>
                                    <td class="text-center"><a href="{{url('notice_uploads/'.$notice->file)}}"><span class="text-primary">View file</span></a></td>
                                    <td>
                                        <div class="d-flex">
                                            <a type="" class="action-btns1" data-bs-toggle="modal"
                                                data-bs-target="#deletenoticemodal" title="Delete"><i
                                                    class="feather feather-trash-2 text-danger"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deletenoticemodal">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmation</h5>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{route('delete.notice',[$notice->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <h4>Are You Sure Want to Delete {{$notice->title}}</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" type="reset" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</a>
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <tr>
                                    <td class="text-center">No Data Found</td>
                                    
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
    <div class="modal fade" id="addnoticemodal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Notice</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('create.notice')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input class="form-control" name="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Select Date:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="feather feather-calendar"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="date" placeholder="DD-MM-YYYY" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description:</label>
                            <textarea  name="description" cols="100"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attachment:</label>
                            <div class="form-group">
                                <label class="form-label"></label>  
                                <input class="form-control" type="file" name="image" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="reset" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD LEAVE MODAL -->
    
@endsection

@section('js')
    <!-- INTERNAL  DATEPICKER JS -->
    <script src="{{ asset('assets/plugins/modal-datepicker/datepicker.js') }}"></script>
    <!-- INTERNAL SUMMERNOTE JS  -->
    <script src="{{ asset('assets/plugins/summer-note/summernote1.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.js') }}"></script>

    <!-- INTERNAL INDEX JS -->
    <script src="{{ asset('assets/js/hr/hr-notice.js') }}"></script>
@endsection
