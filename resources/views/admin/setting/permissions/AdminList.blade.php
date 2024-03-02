@extends('admin.pagelayout.master')
@section('title', 'Admin List')

@if (in_array('Admin List.All', $permission) || in_array('Admin List.View', $permission))
@section('content')
<div class="p-0">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('/Role-permission/role_permission') }}">Role & Permission</a></li>
        <li class="active"><span><b>Admin List</b></span></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="page-header d-md-flex p-0 d-block">
            <div class="page-leftheader">
                <div class="page-title">Admin List</div>
                <p class="text-muted m-0"><b><?= $AdminCount[3] ?></b> Admins Including You</p>
            </div>
            <div class="page-rightheader  ms-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($Owner as $admin)
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
                        <p class="my-auto" style="color:rgb(34, 33, 29)"><i class="fe fe-mail me-2"></i>{{ $admin->business_email }}
                        </p>
                    </div>
                    <div class="col-6 col-xl-3 my-auto">
                        <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>{{ $admin->mobile_no }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            @empty(!$Employee)
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Assigned Roles</b></span></h4>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0" hidden>S.No.</th>
                                <th class="border-bottom-0">Employee Name</th>
                                <th class="border-bottom-0">Branch</th>
                                <th class="border-bottom-0">Permission Type</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Role</th>
                                <th class="border-bottom-0">Created at</th>
                                {{-- <th class="border-bottom-0">Updated at</th> --}}
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>

                                    @foreach ($Employee as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-md brround me-3"
                                                        style="background-image: url('/storage/livewire_employee_profile/{{ $item->profile_photo }}')"></span>
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-1 fs-14">
                                                            <a href="{{ route('employeeProfile', [$item->emp_id]) }}">
                                                                {{ $item->emp_name }}&nbsp;{{ $item->emp_mname }}&nbsp;{{ $item->emp_lname }}
                                                            </a>
                                                        </h6>
                                                        <p class="text-muted mb-0 fs-12">
                                                            {{ $item->desig_name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->branch_name }}
                                            </td>
                                            <td>
                                                {{ $item->permission_type_name }}

                                            </td>
                                            <td>
                                                {{ $item->emp_email }}
                                            </td>
                                            <td>
                                                {{ $item->roles_name }}
                                            </td>
                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                            <td>
                                                @if (in_array('Admin List.Update', $permission) || in_array('Admin List.All', $permission))
                                                    {{-- <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a> --}}
                                                @endif

                                                @if (in_array('Admin List.Delete', $permission) || in_array('Admin List.All', $permission))
                                                    <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                                        onclick="ItemDeleteModel(this)" data-id='<?= $item->emp_id ?>'
                                                        data-role_id='<?= $item->role_id ?>'
                                                        data-emp_name='<?= $item->emp_name ?>' data-bs-toggle="modal"
                                                        data-bs-target="#deleteConfirmationModal">
                                                        <i class="feather feather-trash-2" data-bs-toggle="tooltip"
                                                            data-original-title="View/Edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <form action="{{ route('deleteAssign') }}" method="post">
                        @csrf
                        <input type="text" id="emp_id" name="emp_id" hidden>
                        <input type="text" id="role_id_set" name="role_id" hidden>

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Assign Name <b>
                                    <span id="assign_emp"></span>
                                </b> </p>

                            Are you sure you want to delete this role ?
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
                console.log(context);
                var id = $(context).data('id');
                var role_id = $(context).data('role_id');
                var assign = $(context).data('emp_name');
                console.log(assign);
                $('#emp_id').val(id);
                $('#role_id_set').val(role_id);
                $('#assign_emp').text(assign);
            }
        </script>
    @endsection
@endif
