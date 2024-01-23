@extends('admin.pagelayout.master')
@section('title', 'Roles And Permissions')


@section('css')

@endsection

@section('content')
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
                        {{-- <div class="table-responsive" <table id="file-datatable"
                            class="table table-bordered text-nowrap key-buttons border-bottom"> --}}
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
                                            @php $tagCount = 0; @endphp
                                            @foreach ($rooted->RoleIdToModelName($item->id) as $model)
                                            @if ($tagCount < 4) <span class="tag tag-rounded"> {{ $model->model_name
                                                }}</span>
                                                @php $tagCount++; @endphp

                                                @if ($tagCount % 2 == 0 && $tagCount < 4) <br>
                                                    <!-- Line break after every 2 items -->
                                                    @endif

                                                    @else
                                                    @break
                                                    @endif
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
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') )
<script>
    Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            text: "{{ session('success') }}",
            footer: '<a href="javascript:;">Responderemos assim que possível.</a>',
            timer: 3000,
            timerProgressBar: true
        });
</script>
@endif --}}
{{-- Create Role Model --}}
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

                    {{-- <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button> --}}
                </div>
                <div class="modal-body">
                    <input type="text" name="business_id" value="{{ Session::get('business_id') }}" hidden>
                    <div class="row p-3">
                        <div class="col-12 my-2">
                            <label class="form-label">Role Name</label>
                            <input class="form-control" placeholder="Role Name" type="text" name="role_name" required>
                        </div>
                        <div class="col-12 my-2">
                            <label class="form-label">Description</label>
                            <input class="form-control" placeholder="Description" type="text" name="description"
                                required>
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
                                    <input id="{{ $permission->id }}" type="checkbox" class="custom-control-input allow"
                                        name="permissio[]" value="{{ $module->menu_name . '.' . $permission->name }}"
                                        onchange="givePermit(this)">
                                    <span class="custom-control-label">{{ $permission->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="savechanges">Create Role</button>
                </div>
                {{-- <div class="modal-footer  border-0">
                    <div class="d-flex">
                        <button type="reset" class="btn btn-danger btn-sm mx-3" data-bs-dismiss="modal"
                            id="disposeButton">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                    </div>
                </div> --}}
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

                                    <input id="{{ $permission->id }}" type="checkbox" class="custom-control-input allow"
                                        name="permissions[]" value="{{ $module->menu_name . '.' . $permission->name }}">
                                    <span class="custom-control-label">{{ $permission->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- <div class="modal-footer  border-0">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-danger btn-sm mx-3" data-bs-dismiss="modal"
                            id="disposeButton">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                    </div>
                </div> --}}
                <div class="modal-footer">
                    <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" >Update Role</button>
                </div>
    
                {{-- <div class="modal-footer  border-0">
                    <div class="d-flex">
                        <a class="btn btn-danger btn-sm " data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Continue</button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
</div>
{{-- <a class="btn ripple btn-secondary" data-bs-target="#scrollmodal" data-bs-toggle="modal" href="javascript:;">View
    Demo</a>
<div class="modal fade" id="scrollmodal">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Scrolling With Content Modal</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                    magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was
                    born and I will give you a complete account of the system, and expound the actual teachings of the
                    great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or
                    avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue
                    pleasure rationally encounter consequences that are extremely painful. </p>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                    deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                    provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum
                    fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
                <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and
                    demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee
                    the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their
                    duty through weakness of will, which is the same as saying through shrinking from toil and pain.</p>
                <p>These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is
                    untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to
                    be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or
                    the obligations of business it will frequently occur that pleasures have to be repudiated and
                    annoyances accepted. The wise man therefore always holds in these matters to this principle of
                    selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid
                    worse pains.</p>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                    magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was
                    born and I will give you a complete account of the system, and expound the actual teachings of the
                    great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or
                    avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue
                    pleasure rationally encounter consequences that are extremely painful. </p>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                    deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                    provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum
                    fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-success" type="button">Save changes</button>
                <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div> --}}
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
                    $('input[type="checkbox"][name^="permissions"]').prop('checked', false);

                    result.checking.forEach(function(element) {
                        console.log(element);

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
                        <button type="reset" class="btn btn-danger btn-sm mx-3" data-bs-dismiss="modal">Cancel</button>
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