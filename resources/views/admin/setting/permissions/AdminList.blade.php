@extends('admin.setting.setting')
@section('title')
    Admin List
@endsection
@section('settings')

<div class=" p-0  ">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/Role-permission/role_permission') }}">Role & Permission</a></li>
        {{-- <li><a href="{{ url('/requests/misspunch') }}">Request</a></li> --}}

        <li class="active"><span><b>Admin List</b></span></li>
    </ol>
</div>
    <div class="row">
    
        @php
            use App\Models\PolicySettingRoleAssignPermission;
            use App\Models\PolicySettingRoleCreate;
            $rooted = new App\Helpers\Central_unit();
            $Branch = $rooted->BranchList();
            $Department = $rooted->DepartmentList();
            $Employee = $rooted->EmployeeDetails();
            $AdminCount = $rooted->CountersValue();
            $Roles = $rooted->GetRoles();
            $Onwer = DB::table('business_details_list')
                ->where('business_id', Session::get('business_id'))
                ->get();

            //

            //  dd($Employee);
            // $Permission = App\Helpers\Central_unit::GetModelPermission();
            // $Permission->where('permission_name','Employee.View')->all()!= null
        @endphp
        <div class="col-lg-12">

            <div class="page-header d-md-flex p-0 d-block">
                <div class="page-leftheader">
                    <div class="page-title">Admin List</div>
                    <p class="text-muted m-0"><b><?= $AdminCount[3] ?></b> Admins Including You</p>
                </div>
                <div class="page-rightheader  ms-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">

                        {{-- <div class="d-lg-flex d-block">
                    @if (in_array('Admin List.Create', $permission))
                    <div class="btn-list">
                        <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                            data-bs-toggle="modal" href="#addNewAdmin">Assign Mail Send Admin</a>
                    </div>
                    @endif
                </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($Onwer as $admin)
        <div class="row row-sm">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Owner</b></span></h4>
                    </div>
                    <div class="card-body border-bottum-0">
                        <div class="row">
                            <div class="col-xl-3 my-auto">
                                <h5 class="my-auto">{{ $admin->client_name }}</h5>
                            </div>
                            <div class="col-6 col-xl-3 my-auto">
                                <p class="my-auto" style="color:rgb(34, 33, 29)"><i
                                        class="fe fe-mail me-2"></i>{{ $admin->business_email }}
                                </p>
                            </div>
                            <div class="col-6 col-xl-3 my-auto">
                                <p class="my-auto " style="color:rgb(34, 33, 29)"><i
                                        class="fe fe-phone mx-2"></i>{{ $admin->mobile_no }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- @foreach ($pendings as $pending)
<div class="card-body border-bottum-0">
    <div class="row">
        <div class="col-xl-3 my-auto">
            <p>Panding Statement Send </p>
            <h5 class="my-auto">{{ $pending->emp_name }}</h5>
        </div>
        <div class="col-6 col-xl-3 my-auto">
            <p class="my-auto" style="color:rgb(34, 33, 29)"><i class="fe fe-mail me-2"></i>{{ $pending->emp_email }}
            </p>
        </div>
        <div class="col-6 col-xl-3 my-auto">
            <span>Not Accepted Yet</span>
        </div>
        <div class="col-xl-3">
            <p class="my-auto text-muted text-end">
                <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a>
                <a class="btn text-primary" id="" href="#"><i class="fe fe-trash"></i></a>
            </p>
        </div>
    </div>
</div>
@endforeach --}}


    <div class="row row-sm">
        <div class="col-lg-12">

        <div class="card">
            @empty(!$Employee)
                <div class="card-header  border-0">
                    <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Assigned Roles</b></span></h4>
                </div>

                @foreach ($Employee->where('role_id', '!=', null)->where('role_id', '!=', 0) as $admin)
                    <div class="card-body border-bottum-0">
                        <div class="row">
                            <div class="col-xl-3 my-auto">
                                <h5 class="my-auto">{{ $admin->emp_name }}</h5>
                            </div>
                            <div class="col-6 col-xl-3 my-auto">
                                <p class="my-auto" style="color:rgb(34, 33, 29)"><i
                                        class="fe fe-mail me-2"></i>{{ $admin->emp_email }}
                                </p>
                            </div>
                            <div class="col-6 col-xl-3 my-auto">
                              

                            <?php
                    if ($admin->emp_id !== null) {
                        $Role_id = PolicySettingRoleAssignPermission::where('emp_id', $admin->emp_id)
                            ->where('business_id', Session::get('business_id'))
                            ->select('*')
                            ->first();
                            
                            if ($Role_id !== null) { // Check if $Role_id is not null
                                $Rolee = PolicySettingRoleCreate::where('business_id', Session::get('business_id'))
                                ->where('id', '=', $Role_id->role_id)
                                ->first(); 
                                // dd($Role_id->created_at);
                                ?>
                                <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-user mx-2"></i>
                                    <?= $Rolee != '' ? $Rolee->roles_name : 'Role Name : null' ?>
                                    <?= 'Date: '.date('d-m-y',strtotime($Role_id->created_at)) ?>
                                
                                </p>

                                
                                <?php
                            // Continue with your code using $Role_id and $Rolee if necessary
                        } else {
                            // Handle the case where $Role_id is null
                            // You can set a default value or display an error message
                        }
                    } else {
                        // Handle the case where $admin->emp_id is null
                        // You can set a default value or display an error message
                    }
                    ?>
                            </div>
                            
                            {{-- @else --}}
                            {{-- <a class="modal-effect btn btn-primary btn-sm border-0 my-auto" data-effect="effect-scale"
                    data-bs-toggle="modal" href="#asignAdmin{{ $admin->id }}">Assign</a> --}}
                            {{-- @endif --}}

                            <div class="col-xl-3">
                                <p class="my-auto text-muted text-end">
                                    @if (in_array('Admin List.Update', $permission))
                                        {{-- <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a> --}}
                                    @endif

                                    @if (in_array('Admin List.Delete', $permission))
                                        <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                            onclick="ItemDeleteModel(this)" data-id='<?= $admin->emp_id ?>'
                                            data-emp_name='<?= $admin->emp_name ?>' data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal">
                                            <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                data-original-title="View/Edit"></i>
                                        </a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endempty

        </div>
        </div>
    </div>

    <div class="modal fade" id="addNewAdmin" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">

            <div class="modal-content modal-content-demo">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Add New Admin</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('add.admin') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row p-3">
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
                                <div class="form-group">
                                    <label class="form-label">Department</label>
                                    <select name="department" class="form-control custom-select select2"
                                        data-placeholder="Department Name" required>
                                        @foreach ($Department as $department)
                                            <option value="{{ $department->depart_id }}">{{ $department->depart_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <div class="form-group">
                                    <label class="form-label">Employee</label>
                                    <select name="employee" class="form-control custom-select select2"
                                        data-placeholder="Employee Name" required>
                                        @foreach ($Employee as $employee)
                                            <option value="{{ $employee->emp_id }}"><b>{{ $employee->emp_name }}</b>
                                                ({{ $employee->emp_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  border-0">
                        <div class="d-flex">
                            <button type="reset" class="btn btn-danger btn-sm mx-3"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($admins as $admin)
        @php
            $Emp_Id = $Employee->where('emp_email', $admin->email)->first();
            // dd($Emp_Id->emp_id);
        @endphp
        {{-- <div class="modal fade" id="asignAdmin{{ $admin->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Assign Role</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('assign.role') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row p-3">
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
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control custom-select select2" data-placeholder="Roles"
                                    required>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"><b>{{ $role->name }}</b></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="form-group">
                                <label class="form-label">Admin</label>
                                @if (isset($Emp_Id))
                                <input class="form-control" placeholder="Enter Name" type="text" name="model"
                                    value="{{ $Emp_Id->emp_id }}">
                                @else
                                <input class="form-control" placeholder="Enter Employee Id" type="text" name="model"
                                    value="">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer  border-0">
                    <div class="d-flex">
                        <button type="reset" class="btn btn-danger btn-sm mx-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save & Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}
    @endforeach

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form action="{{ route('deleteAssign') }}" method="post">
                    @csrf
                    <input type="text" id="emp_id" name="emp_id" hidden>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Assing Name <b>
                                <h4 id="assign_emp"></h4>
                            </b> </p>

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


    <script>
        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var assign = $(context).data('emp_name');
            console.log(assign);
            $('#emp_id').val(id);
            $('#assign_emp').text(assign);
        }
    </script>
@endsection
