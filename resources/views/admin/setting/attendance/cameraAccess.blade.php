@extends('admin.pagelayout.master')
@section('title')
    Camera Access
@endsection

@section('content')
    <div class=" p-0 my-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin/settings/attendance') }}">Attendance Settings</a></li>
            <li class="active"><span><b>Camera Access</b></span></li>
        </ol>
    </div>
    {{-- <div class="">
        <p class="text-muted">Create and activate camera access to track attendance</p>
    </div> --}}
    <div class="page-header d-md-flex d-block">

        <div class="page-leftheader">
            <div class="page-title">Camera Access</div>
            <p class="text-muted m-0">Create and activate camera access to track attendance</p>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createTemplate">Create Camera Access</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                {{-- <div class="card-header border-bottom-0">
                    <h4 class="card-title">Camera Access</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('accessCamera') }}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group mb-0">
                                    <label class="col-md-3 form-label">Select Mode</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="mode" data-placeholder="Choose One"
                                            required>
                                            <option label="Choose one"></option>
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->method_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 form-label">Business Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control text-muted"
                                            value="{{ $bName->business_name }}" placeholder="" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 form-label">Mobile IP</label>
                                    <div class="col-md-9">
                                        <input type="text" name="ip" class="form-control" value=""
                                            placeholder="eg. 192.0.0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 form-label">IMEI Number</label>
                                    <div class="col-md-9">
                                        <input type="text" name="imei" class="form-control" value=""
                                            placeholder="eg. 125489351545628" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 my-auto">
                                <div class="form-group">
                                    <div class="form-label">Camera Access</div>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="cameraAccess" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Allow Camera Access</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success me-auto" type="submit">Submit</button>
                        </div>
                    </form>
                </div> --}}
                <div class="card-header">
                    <h3 class="card-title">Camera Access List</h3>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 ">Sr.No.</th>
                                    <th class="text-center border-bottom-0 ">Mode</th>
                                    <th class="text-center border-bottom-0 ">IP Address</th>
                                    <th class="text-center border-bottom-0 ">IEMI Number</th>
                                    <th class="text-center border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody class="my_body">
                                @foreach ($cameraAccess as $key => $camera)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td class="text-center">{{ $camera->method_name }}</td>
                                        <td class="text-center">{{ $camera->mobile_ip }}</td>
                                        <td class="text-center">{{ $camera->imei_number }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                id="edit_btn_modal" onclick="openEditModel(this)"
                                                data-id='<?= $camera->id ?>' data-modecheck='<?= $camera->mode_check ?>'
                                                data-businessname='<?= $bName->business_name ?>'
                                                data-mobileip='<?= $camera->mobile_ip ?>'
                                                data-imeino='<?= $camera->imei_number ?>'
                                                data-checkcamera='<?= $camera->check_camera ?>' data-bs-toggle="modal" data
                                                data-bs-target="#updateCameraAccess">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>

                                            <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm"
                                                data-bs-toggle="modal" onclick="ItemDeleteModel(this)"
                                                data-bs-target="#deleteModal">
                                                <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>

                                        </td>
                                    </tr>

                                    <div class="modal fade" id="deleteModal" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete Confirmation</h6><button
                                                        aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class='mt-5'>Are you sure want to delete {{ $camera->mobile_ip }}
                                                        ?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('removeCamera', [$camera->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-primary btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="modal fade" id="editModal" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Update Camera Access</h6><button
                                                        aria-label="Close" class="btn-close"
                                                        data-bs-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form action="{{ route('updateCamera') }}" method="post">
                                                    @csrf
                                                    <input type="text" id="editid" name="id" class="form-control"
                                                        value="" hidden>
                                                    <div class="modal-body">
                                                        <div class="row mx-2">
                                                            <div class="my-3">
                                                                <div class="form-group mb-0">
                                                                    <label class="form-label">Select Mode</label>
                                                                    <div class="">
                                                                        <select class="form-control select2"
                                                                            name="updatemode"
                                                                            data-placeholder="Choose One" required>
                                                                            <option label="Choose one"></option>

                                                                            @foreach ($modes as $mode)
                                                                                <option value="<?= $mode->id ?>"
                                                                                    {{ $camera->mode_check == $mode->id ? 'selected' : '' }}>
                                                                                    {{ $mode->method_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label class="form-label">Business Name</label>
                                                                    <div class="">
                                                                        <input type="text"
                                                                            class="form-control text-muted"
                                                                            value="{{ $bName->business_name }}"
                                                                            placeholder="" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label class="form-label">Mobile IP</label>
                                                                    <div class="">
                                                                        <input type="text" name="updateip"
                                                                            class="form-control"
                                                                            value="{{ $camera->mobile_ip }}"
                                                                            placeholder="eg. 192.0.0.01">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label class="form-label">IMEI Number</label>
                                                                    <div class="">
                                                                        <input type="text" name="updateimei"
                                                                            class="form-control"
                                                                            value="{{ $camera->imei_number }}"
                                                                            placeholder="eg. 125489351545628" required>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class=" my-auto">
                                                                <div class="form-group">
                                                                    <div class="form-label">Camera Access</div>
                                                                    <label class="custom-switch">
                                                                        <input type="checkbox" name="updatecameraAccess"
                                                                            class="custom-switch-input"
                                                                            {{ $camera->check_camera == 1 ? 'checked' : '' }}>
                                                                        <span class="custom-switch-indicator"></span>
                                                                        <span class="custom-switch-description">Allow
                                                                            Camera Access</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-danger "
                                                            data-bs-dismiss="modal">Cancel</button>

                                                        <button type="submit"
                                                            class="btn btn-primary btn-success">Update</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <div class="rescalendar" id="my_calendar_en"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Camera Access Modal --}}
    <div class="modal fade" id="createTemplate" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Create Camera Access</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('accessCamera') }}" method="post">
                    @csrf
                    {{-- <input type="text" id="editid" name="id" class="form-control"
                        value="" hidden> --}}
                    <div class="modal-body">
                        <div class="row mx-2">
                            <div class="my-3">
                                <div class="form-group mb-0">
                                    <label class="form-label">Select Mode</label>
                                    <div class="">
                                        <select class="form-control select2" name="mode" data-placeholder="Choose One"
                                            required>
                                            <option label="Choose one"></option>
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->method_name }}</option>
                                            @endforeach
                                            {{-- @foreach ($modes as $mode)
                                                <option value="<?= $mode->id ?>"
                                                    {{ $camera->mode_check == $mode->id ? 'selected' : '' }}>
                                                    {{ $mode->method_name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">Business Name</label>
                                    <div class="">
                                        <input type="text" class="form-control text-muted"
                                            value="{{ $bName->business_name }}" placeholder="" disabled>

                                        {{-- <input type="text"
                                            class="form-control text-muted"
                                            value="{{ $bName->business_name }}"
                                            placeholder="" disabled> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">Mobile IP</label>
                                    <div class="">
                                        <input type="text" name="ip" class="form-control" value=""
                                            placeholder="eg. 192.0.0.01">
                                    </div>
                                    {{-- <div class="">
                                        <input type="text" name="updateip"
                                            class="form-control"
                                            value="{{ $camera->mobile_ip }}"
                                            placeholder="eg. 192.0.0.01">
                                    </div> --}}
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">IMEI Number</label>
                                    <div class="">
                                        <input type="text" name="imei" class="form-control" value=""
                                            placeholder="eg. 125489351545628" required>

                                        {{-- <input type="text" name="updateimei"
                                            class="form-control"
                                            value="{{ $camera->imei_number }}"
                                            placeholder="eg. 125489351545628" required> --}}

                                    </div>
                                </div>
                            </div>

                            <div class=" my-auto">
                                <div class="form-group">
                                    <div class="form-label">Camera Access</div>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="cameraAccess" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Allow Camera Access</span>
                                    </label>
                                    {{-- <label class="custom-switch">
                                        <input type="checkbox" name="updatecameraAccess"
                                            class="custom-switch-input"
                                            {{ $camera->check_camera == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Allow
                                            Camera Access</span>
                                    </label> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>

                        {{-- <button type="submit"
                            class="btn btn-primary btn-success">Update</button> --}}

                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Camera Access Modal --}}
    <div class="modal fade" id="updateCameraAccessPermission" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Update Camera Access</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('updateCamera') }}" method="post">
                    @csrf
                    <input type="text" id="upCaAcId" name="id" class="form-control" value="" hidden>
                    <div class="modal-body">
                        <div class="row mx-2">
                            <div class="my-3">
                                <div class="form-group mb-0">
                                    <label class="form-label">Select Mode</label>
                                    <div class="">
                                        <select class="form-control select2" name="updatemode" id="update_mode_Id"
                                            data-placeholder="Choose One" required>
                                            <option label="Choose one"></option>
                                            @foreach ($modes as $mode)
                                                <option value="{{ $mode->id }}">{{ $mode->method_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">Business Name</label>
                                    <div class="">
                                        <input type="text" id="update_business_name_id"
                                            class="form-control text-muted" value="" placeholder="" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">Mobile IP</label>
                                    <div class="">
                                        <input type="text" id="update_mobile_ip_id" name="updateip"
                                            class="form-control" value="" placeholder="eg. 192.0.0.01">

                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label class="form-label">IMEI Number</label>
                                    <div class="">
                                        <input type="text" id="update_imei_no_id" name="updateimei"
                                            class="form-control" value="" placeholder="eg. 125489351545628"
                                            required>

                                    </div>
                                </div>
                            </div>

                            <div class=" my-auto">
                                <div class="form-group">
                                    <div class="form-label">Camera Access</div>
                                    <label class="custom-switch">
                                        <input type="checkbox" id="update_checkbox_id" name="updatecameraAccess"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Allow
                                            Camera Access</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-primary btn-success">Update</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModel(context) {
            $("#updateCameraAccessPermission").modal("show");
            var id = $(context).data('id');
            var mode_check = $(context).data('modecheck')
            var business_name = $(context).data('businessname')
            var mobile_ip = $(context).data('mobileip')
            var imei_no = $(context).data('imeino')
            var check_camera = $(context).data('checkcamera');
            console.log("id ", id);
            console.log("mode_check ", mode_check);
            console.log("mode_check ", mode_check);
            console.log("business_name ", business_name);
            console.log("mobile_ip ", mobile_ip);
            console.log("imei_no ", imei_no);
            console.log(check_camera);
            $('#upCaAcId').val(id);
            $('#update_mode_Id').val(mode_check).trigger('change');
            $('#update_business_name_id').val(business_name);
            $('#update_mobile_ip_id').val(mobile_ip);
            $('#update_mobile_ip_id').val(mobile_ip);
            $('#update_imei_no_id').val(imei_no);
            console.log("check_camera ", typeof(check_camera));
            if (check_camera == 1) {
                $('#update_checkbox_id').prop('checked', true);
            } else {
                $('#update_checkbox_id').prop('checked', false);
            }
        }
    </script>

 
@endsection
