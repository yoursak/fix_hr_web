@extends('admin.pagelayout.master')
@section('title', 'Roles And Permissions')


@section('css')

@endsection

@section('content')

    <style>
        .nav-link.icon {
            line-height: 0;
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f8ff;
            /* color: #fff; */
        }

        .modal-open {
            overflow: hidden
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: .5rem;
            pointer-events: none
        }

        .modal.fade .modal-dialog {
            transition: -webkit-transform .3s ease-out;
            transition: transform .3s ease-out;
            transition: transform .3s ease-out, -webkit-transform .3s ease-out;
            -webkit-transform: translate(0, -50px);
            transform: translate(0, -50px)
        }

        @media (prefers-reduced-motion:reduce) {
            .modal.fade .modal-dialog {
                transition: none
            }
        }

        .modal.show .modal-dialog {
            -webkit-transform: none;
            transform: none
        }

        .modal.modal-static .modal-dialog {
            -webkit-transform: scale(1.02);
            transform: scale(1.02)
        }

        .modal-dialog-scrollable {
            display: -ms-flexbox;
            display: flex;
            max-height: calc(100% - 1rem)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 1rem);
            overflow: hidden
        }

        .modal-dialog-scrollable .modal-footer,
        .modal-dialog-scrollable .modal-header {
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto
        }

        .modal-dialog-centered {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            min-height: calc(100% - 1rem)
        }

        .modal-dialog-centered::before {
            display: block;
            height: calc(100vh - 1rem);
            height: -webkit-min-content;
            height: -moz-min-content;
            height: min-content;
            content: ""
        }

        .modal-dialog-centered.modal-dialog-scrollable {
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            height: 100%
        }

        .modal-dialog-centered.modal-dialog-scrollable .modal-content {
            max-height: none
        }

        .modal-dialog-centered.modal-dialog-scrollable::before {
            content: none
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: #000
        }

        .modal-backdrop.fade {
            opacity: 0
        }

        .modal-backdrop.show {
            opacity: .5
        }

        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: calc(.3rem - 1px);
            border-top-right-radius: calc(.3rem - 1px)
        }

        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem -1rem -1rem auto
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1rem
        }

        .modal-footer {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding: .75rem;
            border-top: 1px solid #dee2e6;
            border-bottom-right-radius: calc(.3rem - 1px);
            border-bottom-left-radius: calc(.3rem - 1px)
        }

        .modal-footer>* {
            margin: .25rem
        }

        .modal-scrollbar-measure {
            position: absolute;
            top: -9999px;
            width: 50px;
            height: 50px;
            overflow: scroll
        }

        @media (min-width:576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto
            }

            .modal-dialog-scrollable {
                max-height: calc(100% - 3.5rem)
            }

            .modal-dialog-scrollable .modal-content {
                max-height: calc(100vh - 3.5rem)
            }

            .modal-dialog-centered {
                min-height: calc(100% - 3.5rem)
            }

            .modal-dialog-centered::before {
                height: calc(100vh - 3.5rem);
                height: -webkit-min-content;
                height: -moz-min-content;
                height: min-content
            }

            .modal-sm {
                max-width: 300px
            }
        }

        @media (min-width:992px) {

            .modal-lg,
            .modal-xl {
                max-width: 800px
            }
        }

        @media (min-width:1200px) {
            .modal-xl {
                max-width: 1140px
            }
        }
    </style>

    <div class=" p-0 pt-4 ">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('/admin/requests/misspunch') }}">Request</a></li> --}}

            <li class="active"><span><b>Role Management</b></span></li>
        </ol>
    </div>

    <!-- ROW -->
    <div class="row row-sm">
        @php
            $rooted = new App\Helpers\Central_unit();
            $rooted1 = new App\Helpers\Layout();
            
            $Branch = $rooted->BranchList();
            $Roles = $rooted->GetRoles();
            $Modules = $rooted1->SidebarMenu();
            $Department = $rooted->DepartmentList();
            $Employee = $rooted->EmployeeDetails();
            
        @endphp
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
                                    {{-- <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                            data-bs-toggle="modal" href="#empPermission">Add New Permissions</a> --}}
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
                            {{-- <div class="table-responsive">
                    <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
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

                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Designation</p>
                                    <div class="form-group mb-3">
                                        <select id="desig-dd" name="designation_id" class="form-control" required>
                                            <option value="">Select Designation Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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


    {{-- Create Role Model --}}
    <div class="modal fade" id="empRole">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('SubmitRole') }}" method="post">
                @csrf
                <div class="modal-content modal-content-demo">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Add New Role</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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
                                <input class="form-control" placeholder="Description" type="text" name="description"
                                    required>
                            </div>
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
                    <div class="modal-footer  border-0">
                        <div class="d-flex">
                            <button type="reset" class="btn btn-danger btn-sm mx-3"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="showmodal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">

                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Preview Assign Users</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ url('Role-permission/role_permission_updated') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="role" id="rolesId" hidden>
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
                                                    value="{{ $module->menu_name . '.' . $permission->name }}">
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
                            <a class="btn btn-danger btn-sm " data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var roleName = $(context).data('rolename');
            $('#role_id').val(id);
            $('#rolesname').text(roleName);
        }

        function openEditModel(context) {
            var id = $(context).data('id');
            $('#rolesId').val(id);
            // console.log(id);
            $.ajax({
                url: "{{ url('Role-permission/get_assign') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    role_id: id
                },
                dataType: 'json',
                success: function(result) {

                    result.checking.forEach(function(element) {
                        console.log(element);

                        // Get the menu_name from the element
                        var menuName = element.model_name;

                        // Find the corresponding checkbox based on menu_name and set it as checked
                        $('input[type="checkbox"][value="' + menuName + '"]').prop('checked', true);
                    });
                }
            });

        }
    </script>
    <script>
        // function for give allot permission and disallot permission 
        function check(e) {
            var valueq = e.value;

            $.ajax({
                url: "{{ url('Role-permission/get-permissions') }}",
                type: "post",
                data: {
                    valueq: valueq,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    result.forEach(element => {
                        console.log(element);
                        var elem = document.getElementById(element.permission_id).checked = true;
                    });

                }
            });
        }

        function givePermit(e) {
            var elem = document.getElementById('selectAdmin').value;
            var permission = e.value;
            var permission_id = e.id;

            console.log(e.value);
            console.log(e.id);
            console.log(elem);

            if (e.checked == true) {
                $.ajax({
                    url: "{{ url('Role-permission/assign-permission-to-role') }}",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin: elem,
                        permission,
                        permission_id
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ url('Role-permission/remove-permission') }}",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin: elem,
                        permission,
                        permission_id
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                    }
                });
            }
        }
    </script>
    <!-- END ROW -->

    <div class="modal fade" id="empPermission" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <form action="{{ route('permission.add') }}" method="post">
                @csrf
                <div class="modal-content modal-content-demo">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Add New Permission</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <div class="form-group">
                                    <label class="form-label">Permission</label>
                                    <select name="Permission" class="form-control custom-select select2"
                                        data-placeholder="Module" required>
                                        <option value="All">All</option>
                                        <option value="View">View</option>
                                        <option value="Create">Create</option>
                                        <option value="Update">Update</option>
                                        <option value="Delete">Delete</option>
                                        <option value="Import">Import</option>
                                        <option value="Export">Export</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <div class="form-group">
                                    <label class="form-label">Module Name</label>
                                    <select name="module" class="form-control custom-select select2"
                                        data-placeholder="Module" required>
                                        @foreach ($Modules as $module)
                                            <option value="{{ $module->menu_id }}">{{ $module->menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <div class="form-group">
                                    <label class="form-label">Branch</label>
                                    <select name="branch" class="form-control custom-select select2"
                                        data-placeholder="Select Branch" required>
                                        @foreach ($Branch as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <label class="form-label">Description</label>
                                <input class="form-control" placeholder="Description" type="text" name="Description"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  border-0">
                        <div class="d-flex">
                            <button type="reset" class="btn btn-danger btn-sm mx-3"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function btnFunc(e) {
            document.getElementById("actionBtn" + e.id).classList.toggle("d-none");
            document.getElementById("actionBtn" + e.id).classList.toggle("animatedBtn");
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Create Method
        $(document).ready(function() {
            $('#country-dd').on('change', function() {
                var branch_id = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldepartment') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        brand_id: branch_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log(result);
                        $('#state-dd').html(
                            '<option value="" name="department">Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#state-dd").append('<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });




                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                    }
                });
            });
            $('#state-dd').on('change', function() {
                var depart_id = this.value;
                $("#desig-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/alldesignation') }}",
                    type: "POST",
                    data: {
                        depart_id: depart_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $('#desig-dd').html(
                            '<option value="">Select Designation Name</option>');
                        $.each(res.designation, function(key, value) {
                            $("#desig-dd").append('<option value="' + value
                                .desig_id + '">' + value.desig_name + '</option>');
                        });
                        // $('#employee-dd').html(
                        //     '<option value="">Select Employee Name</option>');

                    }
                });
            });
            // employee
            $('#state-dd').on('change', function() {
                var depart_id = this.value;
                $("#employee-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allemployeefilter') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        depart_id: depart_id,
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $('#employee-dd').html('<option value="">Select Employee</option>');
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + value.emp_name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
