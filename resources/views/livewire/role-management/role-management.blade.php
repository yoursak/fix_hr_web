    <!-- ROW -->
    <div class="row row-sm">

        <div class="col-lg-12">
            <div class="page-header  d-md-flex d-block">
                <div class="page-leftheader">
                    <div class="page-title">Role Management</div>
                </div>
                <div class="page-rightheader ms-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="d-lg-flex d-block">
                            <div class="btn-list">
                                @if (in_array('Roles & Permissions.Create', $permission))
                                    <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#empAssign">Assign Permission</a>
                                @endif
                                @if (in_array('Roles & Permissions.Create', $permission))
                                    <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#empRole">Create Role</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles List</h3>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                            {{-- <div class="table-responsive"    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No.</th>
                                    <th class="border-bottom-0">Role Name</th>
                                    <th class="border-bottom-0">Description</th>
                                    <th class="border-bottom-0">Associated Users</th>
                                    <th class="border-bottom-0">View Permission</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
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
                                                @foreach ($rooted->RoleIdToModelName($item->id) as $model)
                                                    <span class="tag tag-rounded"> {{ $model->model_name }}
                                                    </span>
                                                @endforeach

                                            </div>

                                        </td>
                                        <td>
                                            @if (in_array('Roles & Permissions.Update', $permission))
                                                <a class="btn btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                                    onclick="openEditModel(this)" data-id='<?= $item->id ?>'
                                                    data-bs-toggle="modal" data-bs-target="#showmodal">
                                                    <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                        data-original-title="View/Edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Roles & Permissions.Delete', $permission))
                                                <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                    onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>'
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form action="{{ route('deletePermissionAssign') }}" method="post">
                    @csrf
                    <input type="text" id="role_id" name="role_set" hidden>
                    <div class="modal-header">
                        {{-- <input type="text" id="rolesname" disabled> --}}
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Role Name
                        <h4 id="rolesname"></h4>
                        </p>

                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- Assign Permission model --}}
    <div class="modal fade" id="empAssign" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Assign Permission</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('submitAssignPermission') }}" method="post">
                        @csrf

                        <div class="row p-3">
                            <div class="col-12 my-2">
                                {{-- <label class="form-label">Select Role </label>

                            <input class="form-control" placeholder="Role Name" type="text" name="role_name" required>
                            --}}
                                <p class="form-label">Role Name</p>
                                <select name='roleID' id="" class="form-control" required>
                                    <option value="">Select Role Name</option>
                                    @if (!empty($RolesData))
                                        @foreach ($RolesData as $dataa)
                                            <option value="<?= $dataa->id ?>">
                                                <?= $dataa->roles_name ?>
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No roles available</option>
                                    @endif
                                </select>

                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Branch</p>
                                    <select name='branch_id' id="country-dd" class="form-control" required>
                                        <option value="">Select Branch Name</option>
                                        @foreach ($BranchList as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Department</p>
                                    <div class="form-group mb-3">
                                        <select id="state-dd" name="department_id" class="form-control" required>
                                            <option value="">Select Deparment Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Designation</p>
                                    <div class="form-group mb-3">
                                        <select id="desig-dd" name="designation_id" class="form-control" required>
                                            <option value="">Select Designation Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Employee</p>
                                    <select id="employee-dd" name="emp_id" class="form-control" required>
                                        <option value="">Select Employee Name</option>
                                    </select>

                                    {{-- <select name='employee' id="" class="form-control">
                                    <option value="">Select Employee Name</option>
                                    @foreach ($EmployeeList as $data)
                                    <option value="{{ $data->emp_id }}">
                                    {{ $data->emp_id }} | {{ $data->emp_name }}
                                    </option>
                                    @endforeach
                                    </select> --}}
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer  border-0">
                    <div class="d-flex">
                        <a type="reset" class="btn btn-danger btn-md mx-3" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-md">Save & Apply</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="empRole">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('SubmitRole') }}" method="post">
                @csrf
                <div class="modal-content modal-content-demo">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Add New Role</h4>
                        <button type="button" id="closeBtn" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>

                        {{-- <button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button> --}}
                    </div>
                    <div class="modal-body">
                        <input type="text" name="business_id" value="{{ Session::get('business_id') }}" hidden>
                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <label class="form-label">Role Name</label>
                                <input class="form-control" placeholder="Role Name" type="text" name="role_name"
                                    required>
                            </div>
                            <div class="col-12 my-2">
                                <label class="form-label">Description</label>
                                <input class="form-control" placeholder="Description" type="text"
                                    name="description" required>
                            </div>
                        </div>

                        @foreach ($Modules as $module)
                            <div class="row p-4">
                                <div class="col-lg-2">
                                    <div>
                                        {{ $module->menu_name }}

                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="d-flex" id="permit">

                                        @foreach ($permissions->where('module_id', $module->menu_id) as $permission)
                                            <label class="custom-control custom-checkbox mx-3 fw-20">
                                                <input id="{{ $permission->id }}" type="checkbox"
                                                    class="custom-control-input allow" name="permissions[]"
                                                    value="{{ $module->menu_name . '.' . $permission->name }}"
                                                    onchange="givePermit(this)">
                                                <span class="custom-control-label">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-footer  border-0">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-danger btn-sm mx-3" data-bs-dismiss="modal"
                                id="disposeButton">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
