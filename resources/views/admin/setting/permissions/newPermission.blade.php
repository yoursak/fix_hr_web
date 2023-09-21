@extends('admin.setting.setting')
@section('subtitle')
    Roles And Permissions
@endsection
@section('settings')
    <!-- ROW -->
    <div class="row">
        @php
            $rooted = new App\Helpers\Central_unit();
            $rooted1 = new App\Helpers\Layout();
            
            $Branch = $rooted->BranchList();
            $Roles = $rooted->GetRoles();
            $Modules = $rooted1->SidebarMenu();
            $Department = $rooted->DepartmentList();
            $Employee = $rooted->EmployeeDetails();
            
        @endphp
        <div class="page-header d-md-flex d-block">
            <div class="page-leftheader">
                <div class="page-title">Roles & Permissions</div>
            </div>
            <div class="page-rightheader ms-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="d-lg-flex d-block">
                        <div class="btn-list">
                            <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#empAssign">Assign Permission</a>

                            <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#empRole">Create Role</a>
                            {{-- <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#empPermission">Add New Permissions</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="empAssign" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <form action="{{ route('role.add') }}" method="post">
                @csrf
                <div class="modal-content modal-content-demo">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Assing Permission</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row p-3">
                            <div class="col-12 my-2">
                                <label class="form-label">Select Role </label>
                                <input class="form-control" placeholder="Role Name" type="text" name="role_name"
                                    required>
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


    <div class="modal fade" id="empRole" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <form action="{{ route('SubmitRole') }}" method="post">
                @csrf
                <div class="modal-content modal-content-demo">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Add New Role</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="business_id" value="{{Session::get("business_id")}}" hidden>
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
                        <div class="row">
                            <div class="col-xl-2">
                                <div>
                                    {{ $module->menu_name }}
                                    {{-- <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label> --}}
                                </div>
                            </div>
                            <div class="col-xl-9">
                                <div class="d-flex" id="permit">
                                    {{-- <label class="custom-control custom-checkbox mx-3">
                                        <input type="checkbox" class="custom-control-input">
                                        <span class="custom-control-label">All</span>
                                    </label> --}}
                                    @foreach ($permissions->where('module_id', $module->menu_id) as $permission)
                                        <label class="custom-control custom-checkbox mx-3 fw-20">
                                            <input id="{{ $permission->id }}" type="checkbox"
                                                class="custom-control-input allow" name="permissions[]"
                                                value="{{ $module->menu_name . '.' . $permission->name }}"
                                                onchange="givePermit(this)">
                                            <span class="custom-control-label" >{{ $permission->name }}</span>
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
@endsection
