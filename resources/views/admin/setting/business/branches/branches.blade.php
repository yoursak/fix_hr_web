@extends('admin.setting.setting')
@section('subtitle')
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
@section('settings')

    <div class="page-header d-md-flex d-block">
        @php
            $root =new App\Helpers\Central_unit;
            $branch=$root->BranchList();
            $i = 0;
            foreach ($branch as $item) {
                $i++;
            }
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Branch Setting</div>
            <p class="text-muted">{{ $i }} Active Branch</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" id="addNewBranch" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#branchName">Create Branch</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($branch as $item)
           <div class="card" id="repoerCard4">
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-12 my-auto">
                            <div class="row">
                                <div class="col-xl-10 my-auto">
                                    <h5 class="my-auto">{{ $item->branch_name }}</h5>
                                </div>
                                <div class="col-xl-2">
                                    <p class="my-auto text-muted text-end">
                                        <a  class="action-btns btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editBranchName{{ $item->id }}" id="BranchEditbtn"
                                            title="Edit">
                                            <i class="feather feather-edit"></i>
                                        </a>
                                        <a  class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#branchDeletebtn{{ $item->id }}" id="BranchEditbtn"
                                            title="Edit">
                                            <i class="feather feather-trash "></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-1 my-auto text-end">
                            <i class="fe fe-chevron-right fs-30 btn " id="reportBtn4"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div> --}}

    @foreach ($branch as $item)
        {{-- Edit Branch Name --}}
        <form method="POST" action="{{ route('admin.branchupdate') }}">
            <div class="modal fade" id="editBranchName{{ $item->id }}">
                {{-- @dd($item->branch_name) --}}
                @csrf
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header border-0">
                            <h4 class="modal-title ms-2">Manage Branch Name</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
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
                            <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary savebtn">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                        <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->branch_name }}</span> ?</h3>
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
