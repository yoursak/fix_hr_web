<div>
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom ">
                <thead>
                    <tr>
                        <th class="border-bottom-0 ">S.No.</th>
                        <th class="text-center border-bottom-0 ">Mode</th>
                        <th class="text-center border-bottom-0 ">Type</th>
                        <th class="text-center border-bottom-0 ">Branch Email</th>
                        <th class="text-center border-bottom-0 ">IMEI Number</th>
                        <th class="text-center border-bottom-0 "></th>
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
                        <td class="text-center"><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($camera->updated_at))}}</span></td>
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
        <div class="d-flex justify-content-between">
            <div>
                <label for="perPage">Per Page:</label>

                <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model.debounce.350ms="perPage" class="form-control"
                            x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i x-show="isOpen" class="fa fa-caret-up"></i>
                                <i x-show="!isOpen" class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>

                {!! $cameraAccess->links() !!}
            </div>
        </div>
    </div>
</div>
