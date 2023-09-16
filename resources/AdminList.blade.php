@extends('admin.setting.setting')
@section('subtitle')
    Admin List
@endsection
@section('settings')
    <div class="row">
        @php
            $Branch = App\Helpers\Central_unit::BranchList();
            $Department = App\Helpers\Central_unit::DepartmentList();
            $Employee = App\Helpers\Central_unit::EmployeeDetails();
            $Roles = App\Helpers\Central_unit::GetRoles();
            // $Permission = App\Helpers\Central_unit::GetModelPermission();
            // $Permission->where('permission_name','Employee.View')->all()!= null
        @endphp
        <div class="page-header d-md-flex d-block">
            <div class="page-leftheader">
                <div class="page-title">Admin List</div>
                <p class="text-muted">2 Admins Including You</p>
            </div>
            <div class="page-rightheader ms-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="d-lg-flex d-block">
                        <div class="btn-list">
                                <a class="modal-effect btn btn-primary border-0 my-auto" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#addNewAdmin">Add New Admin</a>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Owner</b></span></h4>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-3 my-auto">
                        <h5 class="my-auto">Dilip Sahu</h5>
                    </div>
                    <div class="col-6 col-xl-3 my-auto">
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><i class="fe fe-mail me-2"></i>dilipsahu@xyz.com
                        </p>
                    </div>
                    <div class="col-6 col-xl-3 my-auto">
                        <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>+91 8558652478</p>
                    </div>
                    <div class="col-xl-3">
                        <p class="my-auto text-muted text-end">
                            <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a>
                            <a class="btn text-primary" id="" href="#"><i class="fe fe-trash"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Admins</b></span></h4>
            </div>
            @foreach ($pendings as $pending)
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-xl-3 my-auto">
                            <h5 class="my-auto">{{ $pending->emp_name }}</h5>
                        </div>
                        <div class="col-6 col-xl-3 my-auto">
                            <p class="my-auto" style="color:rgb(34, 33, 29)"><i
                                    class="fe fe-mail me-2"></i>{{ $pending->emp_email }}</p>
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
            @endforeach

            @foreach ($admins as $admin)
                @php
                    $Emp = $Employee->where('emp_email', $admin->email)->first();
                    // dd($Emp_Id->emp_id);
                @endphp
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-xl-3 my-auto">
                            <h5 class="my-auto">{{ $admin->name }}</h5>
                        </div>
                        <div class="col-6 col-xl-3 my-auto">
                            <p class="my-auto" style="color:rgb(34, 33, 29)"><i
                                    class="fe fe-mail me-2"></i>{{ $admin->email }}</p>
                        </div>
                        <div class="col-6 col-xl-3 my-auto">
                            @if (isset($Emp->role_id))
                                @php
                                    $Role_id = $Roles->where('id', $Emp->role_id)->first();
                                @endphp
                                <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-user mx-2"></i>
                                    {{-- <a href="{{route('rolePermission',['data'=>$Emp->emp_id])}}"> --}}
                                    {{ $Role_id->name }}
                                    {{-- </a> --}}
                                </p>
                            @else
                                <a class="modal-effect btn btn-primary btn-sm border-0 my-auto" data-effect="effect-scale"
                                    data-bs-toggle="modal" href="#asignAdmin{{ $admin->id }}">Assign</a>
                            @endif

                        </div>
                        <div class="col-xl-3">
                            <p class="my-auto text-muted text-end">
                                <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a>
                                <a class="btn text-primary" id="" href="#"><i class="fe fe-trash"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
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
        <div class="modal fade" id="asignAdmin{{ $admin->id }}" data-bs-backdrop="static">
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
                                        <select name="role" class="form-control custom-select select2"
                                            data-placeholder="Roles" required>
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
                                            <input class="form-control" placeholder="Enter Name" type="text"
                                                name="model" value="{{ $Emp_Id->emp_id }}">
                                        @else
                                            <input class="form-control" placeholder="Enter Employee Id" type="text"
                                                name="model" value="">
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer  border-0">
                            <div class="d-flex">
                                <button type="reset" class="btn btn-danger btn-sm mx-3"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save & Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
