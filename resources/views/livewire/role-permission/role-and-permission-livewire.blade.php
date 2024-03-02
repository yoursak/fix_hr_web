<div>
    @php
        $rooted = new App\Helpers\Central_unit();
        $rooted1 = new App\Helpers\Layout();
        $Branch = $rooted->BranchList();
        $Roles = $rooted->GetRoles();
        $Modules = $rooted1->SidebarMenu();
        $Department = $rooted->DepartmentList();
        $Employee = $rooted->EmployeeDetails();
    @endphp
    <div class="card-body p-2">
        <div class="row justify-content-end">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="form-group mb-3">
                        <input type="text" wire:model="searchFilter" placeholder="Search"
                            class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom ">
                <thead>
                    <tr>
                        <th class="border-bottom-0">S.No.</th>
                        <th class="border-bottom-0">Role Name</th>
                        <th class="border-bottom-0">Description</th>
                        <th class="border-bottom-0">Associated Users</th>
                        <th class="border-bottom-0">View Permission</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                        // dd($RolesData);
                    @endphp

                    @foreach ($RolesData as $item)
                        <tr>
                            <td>
                                <?= $count++ ?>
                            </td>
                            <td>
                                <?= $item->roles_name ?>
                            </td>
                            <td>
                                <?= $item->description ?>
                            </td>
                            <td>
                                <?= $rooted->RoleIdToCountAssignUsers($item->id) ?>
                            </td>
                            <td>
                                <div class="tags p-0">
                                    @php $tagCount = 0; @endphp
                                    @foreach ($rooted->RoleIdToModelName($item->id) as $model)
                                        @if ($tagCount < 4)
                                            <span class="tag tag-rounded"> {{ $model->model_name }}</span>
                                            @php $tagCount++; @endphp
                                            @if ($tagCount % 2 == 0 && $tagCount < 4)
                                                <br>
                                                <!-- Line break after every 2 items -->
                                            @endif
                                        @else
                                        @break
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                            <td>
                                @if (in_array('Roles & Permissions.All', $permission) || in_array('Roles & Permissions.Update', $permission))
                                    <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="openEditModel(this)" data-id='<?= $item->id ?>'
                                        data-roles_name='<?= $item->roles_name ?>'
                                        data-description='<?= $item->description ?>' data-bs-toggle="modal"
                                        data-bs-target="#showmodal">
                                        <i class="feather feather-eye" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>
                                @endif
                                @if (in_array('Roles & Permissions.All', $permission) || in_array('Roles & Permissions.Delete', $permission))
                                    <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>'
                                        data-associated_users='<?= $rooted->RoleIdToCountAssignUsers($item->id) ?>'
                                        data-rolename='<?= $item->roles_name ?>' data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal">
                                        <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
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

                {!! $RolesData->links() !!}
            </div>
        </div>
    </div>
</div>
