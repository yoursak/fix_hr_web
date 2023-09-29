{{-- @extends('admin.setting.setting') --}}
@extends('admin.pagelayout.master')
@section('title')
    Salary / Branch Setting
@endsection

@section('css')
    <style>
        .rotate {
            transition: 500ms;
            transform: rotate(90deg);
            /* Adjust the desired rotation value */
        }

        .bg-inf {
            /* background-color: #a3d5dd; */
            /* Change to your desired color */
        }
    </style>
@endsection
@section('content')
    <div class="page-header d-md-flex d-block">
        @php
            $root = new App\Helpers\Central_unit();
            $branch = $root->BranchList();
            $branchCount = $root->CountersValue();
            
            $i = 0;
            foreach ($branch as $item) {
                $i++;
            }
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Branch Setting</div>
            <p class="text-muted"><?= $branchCount[0] ?> Active Branch</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" id="addNewBranch" class="btn btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#branchName">Create Branch</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="row row-sm"> --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Branch List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">S. No.</th>
                                <th class="border-bottom-0">Branch Name</th>

                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                
                                $count = 1;
                            @endphp
                            @foreach ($branch as $item)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $item->branch_name }}</td>

                                    <td>
                                        <div class="d-flex">
                                            @if (in_array('Employee.Update', $permissions))
                                                <a class="action-btns btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editBranchName{{ $item->id }}" id="BranchEditbtn"
                                                    title="Edit">
                                                    <i class="feather feather-edit"></i>
                                                </a>
                                            @endif
                                            @if (in_array('Employee.Delete', $permissions))
                                                <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#branchDeletebtn{{ $item->id }}" id="BranchEditbtn"
                                                    title="Edit">
                                                    <i class="feather feather-trash "></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($branch as $item)
        {{-- Edit Branch Name --}}
        <div class="modal fade" id="editBranchName{{ $item->id }}">
            {{-- @dd($item->branch_name) --}}
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header border-0">
                        <h4 class="modal-title ms-2">Manage Branch Name</h4><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST" action="{{ route('admin.branchupdate') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="col-lg">
                                <input type="text" name="editBranchId" value="{{ $item->id }}" hidden>
                                <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                                <input class="form-control" placeholder="Branch Name" type="text"
                                    value="{{ $item->branch_name }}" name="editbranch">
                                <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                        class="text-primary">Terms & Conditions</a></p>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <a class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary savebtn">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Branch Name --}}
    <div class="modal fade" id="branchName">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Branch Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('add.branch') }}">
                    <div class="modal-body">
                        <div class="col-lg">
                            <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                            <input class="form-control" name="branch" placeholder="Branch Name" type="text" required>
                            <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                    class="text-primary">Terms & Conditions</a></p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        @csrf
                        <button type="reset" class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary savebtn">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal for delete confirmation  --}}
    @foreach ($branch as $item)
        <div class="modal fade" id="branchDeletebtn{{ $item->id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->branch_name }}</span> ?
                        </h3>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                        <form method="POST" action="{{ route('delete.branch', $item->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
