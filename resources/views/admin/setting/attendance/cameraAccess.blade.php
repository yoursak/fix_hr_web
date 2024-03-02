@extends('admin.pagelayout.master')
@section('title')
Camera Access
@endsection
@if (in_array('Camera Permission.View', $permissions))

@section('content')
<div class=" p-0 my-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin/settings/attendance') }}">Attendance Settings</a></li>
        <li class="active"><span><b>Camera Access</b></span></li>
    </ol>
</div>

<div class="page-header d-md-flex d-block">

    <div class="page-leftheader">
        <div class="page-title">Camera Access</div>
        <p class="text-muted m-0">Create and Activate Camera Access to Track Attendance.</p>
    </div>
    <div class="page-rightheader ms-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block ms-auto">
                <div class="btn-list">
                    @if (in_array('Camera Permission.Create', $permissions))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplate">Create Camera Access</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Camera Access List</h3>
            </div>
            <livewire:settings.camera-acess-livewire>
            {{-- <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 ">S.No.</th>
                                <th class="text-center border-bottom-0 ">Mode</th>
                                <th class="text-center border-bottom-0 ">Type</th>
                                <th class="text-center border-bottom-0 ">Branch Email</th>
                                <th class="text-center border-bottom-0 ">IMEI Number</th>
                                <th class="text-center border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody class="my_body">
                            @foreach ($cameraAccess as $key => $camera)
                            @php
                            $type = $Type->where('id', $camera->type_check)->first();
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-center">{{ $camera->method_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $type->mode_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $camera->branch_email ?? 'N/A' }}</td>
                                <td class="text-center">{{ $camera->imei_number ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if (in_array('Camera Permission.Update', $permissions))
                                    <a class="btn btn-primary btn-icon btn-sm" id="edit_btn_modal" onclick="openEditModel(this)" data-id='{{ $camera->id }}' data-branch_id='{{ $camera->branch_id }}' , data-modecheck='{{ $camera->mode_check }}' , data-branchmail='{{ $camera->branch_email }}' , data-typecheck='{{ $camera->type_check }}' , data-imeino='{{ $camera->imei_number }}' data-checkcamera='{{ $camera->check_camera }}' data-bs-toggle="modal" data data-bs-target="#updateCameraAccess">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View"></i>
                                    </a>
                                    @endif
                                    @if (in_array('Camera Permission.Delete', $permissions))
                                    <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm" data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-bs-target="#deleteModal">
                                        <i class="feather feather-trash-2" data-bs-toggle="tooltip" data-original-title="View"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>

                            <div class="modal fade" id="deleteModal" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Delete Confirmation</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4 class='mt-5'>Are you sure want to delete ?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('removeCamera', [$camera->id]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="rescalendar" id="my_calendar_en"></div>
            </div> --}}
        </div>
    </div>
</div>

{{-- Create Camera Access Modal --}}
<div class="modal fade" id="createTemplate" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Create Camera Access</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('accessCamera') }}" method="post">
                @csrf
                {{-- <input type="text" id="editid" name="id" class="form-control" value="" hidden> --}}
                <div class="modal-body">
                    <div class="row mx-2">
                        <div class="my-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Attendance Mode</label>
                                <div class="">
                                    <select class="form-control " name="mode" data-placeholder="Choose One" required>
                                        @foreach ($modes as $mode)
                                        @if ($mode->id == 1)
                                        <option value="{{ $mode->id }}" selected>
                                            {{ $mode->method_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        @php
                        $root = new App\Helpers\Central_unit();
                        // $Type = $root->AttendanceMode();
                        // dd($Type);
                        @endphp

                        <div class="my-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Attendance Login Type</label>
                                <div class="">
                                    <select class="form-control" name="type" required>
                                        <option value="" >Select Login Type</option>
                                        @foreach ($Type as $type)
                                        <option label="{{ $type->mode_name }}" value="{{ $type->id }}">
                                            {{ $type->mode_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @php
                        $Branch = $root->BranchList();
                        @endphp
                        <div class="my-4">
                            <div class="form-group mb-0">
                                <label class="form-label">Select Branch</label>
                                <div class="">
                                    <select class="form-control" onchange="setBranchEmail(this) " id="branchSelect" name="branch" data-placeholder="Choose One" required>
                                        <option value="" >Select Branch Name</option>
                                        @foreach ($Branch as $branch)
                                        <option data-email='{{ $branch->branch_email }}' value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="form-group">
                                <label class="form-label">Branch Email</label>
                                <div class="">
                                    <input type="text" name="branch_email" id="branchEmail" class="form-control text-muted" value="" placeholder="" disabled>
                                </div>
                            </div>
                        </div>

                        <script>
                            function setBranchEmail(e) {
                                var selectedOption = e.options[e.selectedIndex];
                                console.log(selectedOption);
                                // Get the value and data-email attribute of the selected option
                                var selectedValue = selectedOption.value;
                                var selectedEmail = selectedOption.getAttribute('data-email');

                                document.getElementById('branchEmail').value = selectedEmail;

                                // Log the values for testing
                                console.log('Selected Value:', selectedValue);
                                console.log('Selected Email:', selectedEmail);
                            }
                        </script>

                        <div class="">
                            <div class="form-group">
                                <label class="form-label">IMEI Number</label>
                                <div class="">
                                    <input type="text" name="imei" class="form-control" value="" placeholder="eg. 12548935154562" maxlength="15" required>

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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Submit</button>

                    {{-- <button type="submit" class="btn btn-primary btn-success">Update</button> --}}

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
                <h6 class="modal-title">Update Camera Access</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('updateCamera') }}" method="post">
                @csrf
                <input type="text" id="upCaAcId" name="id" class="form-control" value="" hidden>
                <div class="modal-body">
                    <div class="row mx-2">
                        <div class="my-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Attendance Mode</label>
                                <div class="">
                                    <select class="form-control " name="updatemode" id="update_mode_Id" data-placeholder="Choose One" required>
                                        @foreach ($modes as $mode)
                                        @if ($mode->id == 1)
                                        <option value="{{ $mode->id }}">{{ $mode->method_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @php
                        $root = new App\Helpers\Central_unit();
                        // $Type = $root->AttendanceMode();
                        // dd($Type);
                        @endphp
                        <div class="my-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Attendance Login Type</label>
                                <div class="">
                                    <select class="form-control " name="type" data-placeholder="Choose One" id="attendanceTypeUpdate" required>
                                        <option value="" >Select Login Type</option>
                                        @foreach ($Type as $type)
                                        <option label="{{ $type->mode_name }}" value="{{ $type->id }}">
                                            {{ $type->mode_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @php
                        $Branch = $root->BranchList();
                        @endphp
                        <div class="my-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Select Branch</label>
                                <div class="">
                                    <select class="form-control" onchange="updateBranchEmail(this) " id="branchSelectUpdate" name="branch" data-placeholder="Choose One" required>
                                        <option value="" >Select Branch Name</option>
                                        @foreach ($Branch as $branch)
                                        <option data-uemail='{{ $branch->branch_email }}' value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="form-group">
                                <label class="form-label">Branch Email</label>
                                <div class="">
                                    <input type="text" name="update_branch_email" id="ubranchEmail" class="form-control text-muted" placeholder="" readonly>
                                </div>
                            </div>
                        </div>

                        <script>
                            function updateBranchEmail(e) {
                                var uselectedOption = e.options[e.selectedIndex];
                                console.log(uselectedOption);

                                var uselectedValue = uselectedOption.value;
                                var uselectedEmail = uselectedOption.getAttribute('data-uemail');

                                document.getElementById('ubranchEmail').value = uselectedEmail;


                                console.log('Selected Value:', uselectedValue);
                                console.log('Selected Email:', uselectedEmail);
                            }
                        </script>

                        <div class="">
                            <div class="form-group">
                                <label class="form-label">IMEI Number</label>
                                <div class="">
                                    <input type="text" id="update_imei_no_id" name="updateimei" class="form-control" value="" placeholder="eg. 125489351545628" required>

                                </div>
                            </div>
                        </div>

                        <div class=" my-auto">
                            <div class="form-group">
                                <div class="form-label">Camera Access</div>
                                <label class="custom-switch">
                                    <input type="checkbox" id="update_checkbox_id" name="updatecameraAccess" class="custom-switch-input">
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

                    <button type="submit" class="btn btn-primary">Update</button>

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
        var branch_id = $(context).data('branch_id');
        var branch_mail = $(context).data('branchmail');
        var type_check = $(context).data('typecheck');
        var imei_no = $(context).data('imeino')
        var check_camera = $(context).data('checkcamera');

        console.log("id ", id);
        console.log("mode_check ", mode_check);
        console.log("type_check ", type_check);
        console.log("branch_mail ", branch_mail);
        console.log("branch_id ", branch_id);
        console.log("imei_no ", imei_no);
        console.log(check_camera);

        $('#upCaAcId').val(id);
        $('#update_mode_Id').val(mode_check).trigger('change');
        $('#branchSelectUpdate').val(branch_id).trigger('change');
        $('#attendanceTypeUpdate').val(type_check).trigger('change');
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
@endif
