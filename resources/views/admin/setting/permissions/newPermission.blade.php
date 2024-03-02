@extends('admin.pagelayout.master')
@section('title', 'Roles And Permissions')


@section('css')

@endsection
@if (in_array('Roles & Permissions.All', $permission) || in_array('Roles & Permissions.View', $permission))
    @section('content')

        <div class=" p-0 pt-4 ">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
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
                        <div
                            class="d-flex align-items-end flex-wrap my-auto justify-content-end end-content breadcrumb-end">
                            <div class="d-lg-flex d-block">
                                <div class="btn-list">
                                    @if (in_array('Roles & Permissions.Create', $permission) || in_array('Roles & Permissions.All', $permission))
                                        <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                            id="assignPermission" data-bs-toggle="modal" href="#empAssign">Assign
                                            Permission</a>
                                    @endif
                                    @if (in_array('Roles & Permissions.All', $permission) || in_array('Roles & Permissions.Create', $permission))
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
                    <livewire:role-permission.role-and-permission-livewire>
                    {{-- <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
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
                    </div> --}}
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
                    <input type="text" id="assocated_Users" name="assocated_Users" hidden>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">
                        <p>Role Name
                            <b>
                                <span id="rolesname"></span>
                            </b>
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

                <form action="{{ route('submitAssignPermission') }}" method="post" id="assignPermissionModal">
                    @csrf
                    <div class="modal-body">

                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <p class="form-label">Role Name*</p>
                                <select name='roleID' id="" class="form-control" required>
                                    <option value="" disabled selected>Select Role Name</option>
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
                                    <p class="form-label">Branch*</p>
                                    <select name='branch_id' id="country-dd" class="form-control" required>
                                        <option value="" disabled selected>Select Branch Name</option>
                                        @foreach ($Branch as $data)
                                            <option value="{{ $data->branch_id }}">
                                                {{ $data->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Department*</p>
                                    <div class="form-group mb-3">
                                        <select id="state-dd" name="department_id" class="form-control" required>
                                            <option value="" disabled selected>Select Department Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Employee*</p>
                                    <select id="employee-dd" name="emp_id" class="form-control" required>
                                        <option value="">Select Employee Name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <p class="form-label">Permission Type*</p>
                                    <select id="permissiontype-dd" name="permissiontype_id" class="form-control"
                                        required>
                                        <option value="" disabled selected>Select Permission Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12" id="branchNameDiv">
                                <div class="form-group">
                                    <p class="form-label">Branch Name*</p>
                                    <select class="form-control" id="branchname_id" name="branchname_id"
                                        data-placeholder="Choose Shift Policy" required>
                                        <option value="" disabled selected>Select Branch Name</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer  border-0">
                        <div class="d-flex">
                            <a type="reset" class="btn btn-danger btn-md mx-3" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-md">Save </button>
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
                        <h4 class="modal-title ms-2">Add New Role</h4>
                        <button type="button" id="closeBtn" class="btn-close btn" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>

                        {{-- <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button> --}}
                    </div>
                    <div class="modal-body">
                        <input type="text" name="business_id" value="{{ Session::get('business_id') }}" hidden>
                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <label class="form-label">Role Name*</label>
                                <input class="form-control" placeholder="Role Name" type="text" name="role_name"
                                    required>
                            </div>
                            <div class="col-12 my-2">
                                <label class="form-label">Description*</label>
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
                                <div class="col-lg-9 col-sm-12">
                                    <div class="d-flex flex-wrap" id="permit">
                                        @foreach ($permissions->where('module_id', $module->menu_id) as $permission)
                                            <label class="custom-control custom-checkbox mx-3 fw-20">
                                                <input id="{{ $permission->id }}" type="checkbox"
                                                    class="custom-control-input allow check_all_input"
                                                    name="permissio[]"
                                                    value="{{ $module->menu_name . '.' . $permission->name }}"
                                                    onclick="checkCreate(this)"
                                                    data-checkall='<?= $permission->name ?>'
                                                    data-check='<?= $permission->module_id ?>'
                                                    onchange="givePermit(this)">
                                                <span
                                                    class="custom-control-label  check_all">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="savechanges">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="showmodal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">

                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Update Assign Permission</h4><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ url('Role-permission/role_permission_updated') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="role" id="rolesId" hidden>

                        <input type="text" name="business_id_edit" value="{{ Session::get('business_id') }}"
                            hidden>
                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <label class="form-label">Role Name*</label>
                                <input class="form-control" placeholder="Role Name" type="text"
                                    name="role_name_edit" id="role_name_edit_id" required>
                            </div>
                            <div class="col-12 my-2">
                                <label class="form-label">Description*</label>
                                <input class="form-control" placeholder="Description" type="text"
                                    id="description_edit_id" name="description_edit" required>
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
                                    <div class="d-flex flex-wrap" id="permit">
                                        @foreach ($permissions->where('module_id', $module->menu_id) as $permission)
                                            <label class="custom-control custom-checkbox mx-3 fw-20">
                                                <input id="{{ $permission->id }}" type="checkbox"
                                                    class="custom-control-input allow check_all_input_edit"
                                                    name="permissions[]"
                                                    value="{{ $module->menu_name . '.' . $permission->name }}"
                                                    onclick="checkEdit(this)"
                                                    data-checkalledit='<?= $permission->name ?>'
                                                    data-checkedit='<?= $permission->module_id ?>'>
                                                <span
                                                    class="custom-control-label check_all_edit">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var roleName = $(context).data('rolename');
            var assocatedUsers = $(context).data('associated_users');
            $('#role_id').val(id);
            $('#assocated_Users').val(assocatedUsers);
            $('#rolesname').text(roleName);
        }

        function openEditModel(context) {
            var id = $(context).data('id');
            var roles_name = $(context).data('roles_name');
            var description = $(context).data('description');
            $('#role_name_edit_id').val(roles_name);
            $('#description_edit_id').val(description);
            $('#rolesId').val(id);
            $.ajax({
                url: "{{ url('Role-permission/get_assign') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    role_id: id
                },
                dataType: 'json',
                success: function(result) {
                    $('input[type="checkbox"][name^="permissions"]').prop('checked', false);

                    result.checking.forEach(function(element) {
                        // Get the menu_name from the element
                        var menuName = element.model_name;
                        $('input[type="checkbox"][name^="permissions"][value="' + menuName + '"]').prop(
                            'checked', true);

                        // $('input[type="checkbox"][name^="permissions"][value="' + menuName + '"]').prop(
                        // 'checked', false);

                        // Find the corresponding checkbox based on menu_name and set it as checked
                        // $('input[type="checkbox"][value="' + menuName + '"]').prop('checked', true);
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
                        var elem = document.getElementById(element.permission_id).checked = true;
                    });
                }
            });
        }

        function checkCreate(e) {
            var moduleID = $(e).data('check');
            var moduleIDCheck = $(e).data('checkall');
            var checkAllValue = 'All';
            if (moduleIDCheck == 'All') {
                if (e.checked) {
                    $('.check_all_input[data-check="' + moduleID + '"]').prop('checked', true).prop('required', false)
                        .trigger('change');
                } else {
                    $('.check_all_input[data-check="' + moduleID + '"]').prop('checked', false).prop('required', false)
                        .trigger('change');
                }
            } else {
                var allIndividualCheckboxesChecked = $('.check_all_input[data-check="' + moduleID +
                    '"][data-checkall!="All"]:checked').length === $('.check_all_input[data-check="' + moduleID +
                    '"][data-checkall!="All"]').length;

                // If all individual checkboxes are checked, check the "Check All" checkbox
                if (allIndividualCheckboxesChecked) {
                    $('.check_all_input[data-check="' + moduleID + '"][data-checkall="' + checkAllValue + '"]').prop(
                        'checked', true).trigger('change');
                } else {
                    $('.check_all_input[data-check="' + moduleID + '"][data-checkall="' + checkAllValue + '"]').prop(
                        'checked', false).trigger('change');
                }
            }
        }

        function checkEdit(e) {
            var moduleID = $(e).data('checkedit');
            var moduleIDCheck = $(e).data('checkalledit');
            var checkAllValue = 'All';
            if (moduleIDCheck == 'All') {
                if (e.checked) {
                    $('.check_all_input_edit[data-checkedit="' + moduleID + '"]').prop('checked', true).prop('required',
                        false).trigger('change');
                } else {
                    $('.check_all_input_edit[data-checkedit="' + moduleID + '"]').prop('checked', false).prop('required',
                        false).trigger('change');
                }
            } else {

                var allIndividualCheckboxesChecked = $('.check_all_input_edit[data-checkedit="' + moduleID +
                    '"][data-checkalledit!="All"]:checked').length === $('.check_all_input_edit[data-checkedit="' +
                    moduleID + '"][data-checkalledit!="All"]').length;

                // If all individual checkboxes are checked, check the "Check All" checkbox
                if (allIndividualCheckboxesChecked) {
                    $('.check_all_input_edit[data-checkedit="' + moduleID + '"][data-checkalledit="' + checkAllValue + '"]')
                        .prop('checked', true).trigger('change');
                } else {
                    $('.check_all_input_edit[data-checkedit="' + moduleID + '"][data-checkalledit="' + checkAllValue + '"]')
                        .prop(
                            'checked', false).trigger('change');
                }
            }
        }

        function givePermit(e) {
            var elem = document.getElementById('selectAdmin').value;
            var permission = e.value;
            var permission_id = e.id;
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
                    success: function(result) {}
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
                    success: function(result) {}
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
                        <h4 class="modal-title ms-2">Add New Permission</h4><button aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
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
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <label class="form-label">Description</label>
                                <input class="form-control" placeholder="Description" type="text"
                                    name="Description" required>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Create Method
        $("#assignPermission").on('click', function() {
            $('#assignPermissionModal').trigger('reset');
            $('#empAssign').modal('show');
            $('#branchNameDiv').hide();
        });

        $(document).ready(function() {
            $('#country-dd').on('change', function() {
                var branch_id = this.value;
                $('#branchNameDiv').hide();
                $("#permissiontype-dd").html('');
                $('#branchname_id').prop('required', false);
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
                        $('#state-dd').html(
                            '<option value="" name="department" selected disabled>Select Department Name</option>'
                        );
                        $.each(result.department, function(key, value) {
                            $("#state-dd").append('<option name="department" value="' +
                                value
                                .depart_id + '">' + value.depart_name +
                                '</option>');
                        });

                        $('#desig-dd').html(
                            '<option value="" selected disabled>Select Designation Name</option>'
                        );
                        $('#permissiontype-dd').html(
                            '<option value="" disabled selected>Select Permission Type</option>'
                        );
                    }
                });
            });
            // designation
            // $('#state-dd').on('change', function() {
            //     var depart_id = this.value;
            //     $("#desig-dd").html('');
            //     $.ajax({
            //         url: "{{ url('admin/settings/business/alldesignation') }}",
            //         type: "POST",
            //         data: {
            //             depart_id: depart_id,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             $('#desig-dd').html(
            //                 '<option value="">Select Designation Name</option>');
            //             $.each(res.designation, function(key, value) {
            //                 $("#desig-dd").append('<option value="' + value
            //                     .desig_id + '">' + value.desig_name + '</option>');
            //             });
            //             // $('#employee-dd').html(
            //             //     '<option value="">Select Employee Name</option>');

            //         }
            //     });
            // });
            // employee
            $('#state-dd').on('change', function() {
                $('#country-dd').val();
                $('#branchNameDiv').hide();
                $('#branchname_id').prop('required', false);
                $("#permissiontype-dd").html('');
                var branch_id = $('#country-dd').val();
                var depart_id = this.value;
                $("#employee-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allemployeefilter') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        branch_id: branch_id,
                        depart_id: depart_id,
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#employee-dd').html(
                            '<option value="" disabled selected>Select Employee Name</option>'
                        );
                        $('#permissiontype-dd').html(
                            '<option value="" disabled selected>Select Permission Type</option>'
                        );
                        $.each(res.employee, function(key, value) {
                            $("#employee-dd").append('<option value="' + value.emp_id +
                                '">' + ((value.emp_name ? value.emp_name : '') +
                                    ' ' + (value.emp_mname ? value.emp_mname : '') +
                                    ' ' + (value.emp_lname ? value.emp_lname : '')
                                ) + '</option>');
                        });
                    }
                });
            });
            // permission
            $('#employee-dd').on('change', function() {
                var depart_id = this.value;
                $('#branchNameDiv').hide();

                $("#permissiontype-dd").html('');
                $.ajax({
                    url: "{{ url('admin/settings/business/allpermissiontype') }}",
                    type: "GET",
                    dataType: 'json',

                    success: function(res) {
                        $('#permissiontype-dd').html(
                            '<option value="" disabled selected>Select Permission Type</option>'
                        );
                        $.each(res.permission, function(key, value) {
                            $("#permissiontype-dd").append('<option value="' + value
                                .id +
                                '">' + (value.permission_type_name ? value
                                    .permission_type_name : '') + '</option>');
                        });
                    }
                });
            });
            // branch name
            $('#permissiontype-dd').change(function() {
                var selectedPermissionType = $(this).val();
                var branch_id = $('#country-dd').val()
                var emp_id = $('#employee-dd').val()

                $("#branchname_id").html('');
                // Assuming you want to hide the branchname_id select box when permission type is 1
                if (selectedPermissionType == '1') {
                    $('#branchNameDiv').hide();
                    $('#branchname_id').prop('required', false);
                } else {
                    $('#branchNameDiv').show();
                    // For other permission types, show the select box and fetch branch options
                    $.ajax({
                        url: "{{ url('admin/settings/business/selectbranch') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            branchId: branch_id,
                            empId: emp_id,
                        },

                        success: function(res) {
                            // Clear existing options and add a default disabled option
                            $('#branchname_id').html(
                                '<option value="" disabled selected>Select Branch Name</option>'
                            );
                            console.log("RESTY ", res);
                            // Append new branch options
                            $("#branchname_id").append('<option value="' + res.branch
                                .branch_id + '" selected>' + (res.branch.branch_name ? res
                                    .branch
                                    .branch_name : '') + '</option>');
                            // $.each(res.branch, function(key, value) {

                            // });
                            // Show the branchname_id select box
                            $('#branchname_id').show();
                        },
                        error: function(err) {
                            console.error("Error fetching branches:", err);
                        }
                    });
                }
            });

        });
    </script>
@endsection
@endif
