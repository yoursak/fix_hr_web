@extends('admin.pagelayout.master')

@section('subtitle')
    Salary / Department Setting
@endsection

@section('css')
@endsection
@section('content')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Weekly Holiday Setting</div>
            <p class="text-muted">Assign weekly off days of your business to automatically mark attendance for those days.
            </p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        {{-- <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-bs-target="#modaldemo3"   data-target="#modaldemo3">
                        Create Templates
                    </button> --}}
                        <a class="btn btn-primary" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">Create
                            Template</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="text-center py-4 bg-light border">
    <a class="btn btn-primary" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">View Live Demo</a>
</div><!-- pd-y-30 --> --}}
    <!-- LARGE MODAL -->
    <div class="modal fade" id="modaldemo3">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Weekoff/Weekly Holiday</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('holiday.policy') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row  ">
                            <label for="weekname" class="col-sm-3 col-form-label fs-14">Weekly off template name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="templatename" id="weekname"
                                    placeholder="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group m-0">
                                    <div class="fs-14 mb-4">Weekly Holiday Days</div>
                                    <div class="custom-controls-stacked">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Monday">
                                            <span class="custom-control-label">Monday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Tuesday">
                                            <span class="custom-control-label">Tuesday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Wednesday">
                                            <span class="custom-control-label">Wednesday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Thursday">
                                            <span class="custom-control-label">Thursday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Friday">
                                            <span class="custom-control-label">Friday</span>
                                        </label>

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Saturday">
                                            <span class="custom-control-label">Saturday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="days[]"
                                                value="Sunday">
                                            <span class="custom-control-label">Sunday</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Close</button> <button class="btn btn-primary me-0"
                            type="submit">Save & Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($data as $item)
            {{-- @foreach ($branch as $item) --}}
            <div class="card" id="repoerCard4">
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-12 my-auto">
                            <div class="row">
                                <div class="col-xl-5 my-auto">
                                    {{-- <h5 class="my-auto"></h5> --}}
                                    <h5 class="my-auto">{{ $item->name }}</h5>
                                </div>
                                <div class="col-xl-5 my-auto">
                                    {{-- <h5 class="my-auto"></h5> --}}
                                    <h5 class="my-auto">
                                        {{-- {{$item->days}} --}}

                                            @php
                                                $holidays = json_decode($item->days);
                                            @endphp
                                            @if(is_array($holidays) || is_object($holidays))
                                                
                                            @foreach ($holidays as $holiday)
                                            {{ $holiday }}
                                            @endforeach
                                            @endif
                                    </h5>
                                </div>
                                <div class="col-xl-2">
                                    <p class="my-auto text-muted text-end">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal"
                                            data-bs-target="#editBranchName{{ $item->id }}" id="BranchEditbtn"
                                            {{-- data-bs-target="#editBranchName" id="BranchEditbtn" --}} title="Edit">
                                            <i class="feather feather-edit  text-dark"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal" data-bs-target="#holidaypolicyDeletebtn{{ $item->id }}" id="BranchEditbtn" 
                                            title="Edit">
                                            <i class="feather feather-trash  text-dark"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-1 my-auto text-end">
                            <i class="fe fe-chevron-right fs-30 btn " id="reportBtn4"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach

        <!-- LARGE MODAL -->
        @foreach ($data as $item)
            <div class="modal fade" id="editBranchName{{ $item->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">Weekoff/Weekly Holiday</h6><button aria-label="Close"
                                class="btn-close" data-bs-dismiss="modal"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" action="{{ route('update.holidaypolicy') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row  ">
                                    <input type="text" name="id" value="{{ $item->id }}" hidden>
                                    <label for="weekname" class="col-sm-3 col-form-label fs-14">Weekly off template
                                        name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="templatename" id="weekname"
                                            placeholder="name" value={{ $item->name}}>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group m-0">
                                            <div class="fs-14 mb-4">Weekly Holiday Days</div>
                                            <div class="custom-controls-stacked">
                                                @php
                                                $holidays = json_decode($item->days);
                                            @endphp
                                            {{-- @if(is_array($holidays) || is_object($holidays))
                                                
                                            @foreach ($holidays as $holiday)
                                            {{ $holiday }}
                                            @endforeach
                                            @endif --}}

                                           <label>
           
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Tuesday" {{ in_array('Tuesday', $days   ) ? 'checked' : 'null' }}>
                                                Tuesday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Wednesday" {{ in_array('Wednesday', $days) ? 'checked' : '' }}>
                                                Wednesday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Thursday" {{ in_array('Thursday', $days) ? 'checked' : '' }}>
                                                Thursday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Friday" {{ in_array('Friday', $days) ? 'checked' : '' }}>
                                                Friday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Saturday" {{ in_array('Saturday', $days) ? 'checked' : '' }}>
                                                Saturday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" name="holidays[]" value="Sunday" {{ in_array('Sunday', $days) ? 'checked' : '' }}>
                                                Sunday
                                            </label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" data-bs-dismiss="modal">Close</button> <button
                                    class="btn btn-primary me-0" type="submit">Save & Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($data as $item)
        <div class="modal fade" id="holidaypolicyDeletebtn{{ $item->id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->templatename }}</span> ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                        <form method="POST" action="{{ route('delete.holidaypolicy', $item->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    <!-- END LARGE MODAL -->
    {{-- <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Weekly Holiday Setting</div>
            <p class="text-muted">Assign weekly off days of your business to automatically mark attendance for those days.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Weekly Off</b></span></h4>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-4 my-auto">
                        <h5 class="my-auto"> Weekly Off Preferences</h5>
                    </div>
                    <div class="col-xl-5 my-auto">
                        <p class="my-auto fs-13 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                    </div>
                    <div class="col-xl-3">
                        <div class="btn-list radiobtns">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioCount2"=""
                                    data-bs-toggle="modal" data-bs-target="#businessLavel" checked>
                                <label class="btn btn-outline-dark" for="btnradioCount2">Business</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioIgnore2"
                                    data-bs-toggle="modal" data-bs-target="#employeeLavel">
                                <label class="btn btn-outline-dark" for="btnradioIgnore2">Employee</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <p class="card-title"><span style="color:rgb(104, 96, 151)"><b>Holiday Days</b></span></p>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"
                                checked>
                            <span class="custom-control-label fs-18">Sunday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Monday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Tuesday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Wednesday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Thrusday</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label fs-18">Satureday</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div>

    <!-- Business Lavel MODAL -->
    <div class="modal fade" id="businessLavel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-5">
                        <h4 class="mb-1 fs-20 font-weight-semibold">Switch To Busines Lavel</h4>
                        <p class="my-auto fs-12 mt-5 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                            <div class="d-lg-flex d-block mt-5">
                                <div class="btn-list ms-auto">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Cancel</button>
                                    <button type="button"  class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Switch</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Business Lavel MODAL  -->
    <!-- Business Lavel MODAL -->
    <div class="modal fade" id="employeeLavel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-5">
                        <h4 class="mb-1 fs-20 font-weight-semibold">Switch To Employee Lavel</h4>
                        <p class="my-auto fs-12 mt-5 text-muted" style="color:rgb(34, 33, 29)">Choose if you wish to keep same
                            holidays fopr all your emplyees or different</p>
                            <div class="d-lg-flex d-block mt-5">
                                <div class="btn-list ms-auto">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Cancel</button>
                                    <button type="button"  class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#clockinmodal">Switch</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <script src="assets/plugins/jquery/jquery.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
           
        });
    </script>
    <!-- END Business Lavel MODAL  -->
@endsection
