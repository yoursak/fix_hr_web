@extends('admin.layout.master')
@section('title')
    Leave Requests
@endsection

@section('contents')
    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Leaves Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Department:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
                                    <option value="1">Faith Harris</option>
                                    <option value="2">Austin Bell</option>
                                    <option value="3">Maria Bower</option>
                                    <option value="4">Peter Hill</option>
                                    <option value="5">Victoria Lyman</option>
                                    <option value="6">Adam Quinn</option>
                                    <option value="7">Melanie Coleman</option>
                                    <option value="8">Max Wilson</option>
                                    <option value="9">Amelia Russell</option>
                                    <option value="10">Justin Metcalfe</option>
                                    <option value="11">Ryan Young</option>
                                    <option value="12">Jennifer Hardacre</option>
                                    <option value="13">Justin Parr</option>
                                    <option value="14">Julia Hodges</option>
                                    <option value="15">Michael Sutherland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Designation:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Employee">
                                    <option label="Select Employee"></option>
                                    <option value="1">Faith Harris</option>
                                    <option value="2">Austin Bell</option>
                                    <option value="3">Maria Bower</option>
                                    <option value="4">Peter Hill</option>
                                    <option value="5">Victoria Lyman</option>
                                    <option value="6">Adam Quinn</option>
                                    <option value="7">Melanie Coleman</option>
                                    <option value="8">Max Wilson</option>
                                    <option value="9">Amelia Russell</option>
                                    <option value="10">Justin Metcalfe</option>
                                    <option value="11">Ryan Young</option>
                                    <option value="12">Jennifer Hardacre</option>
                                    <option value="13">Justin Parr</option>
                                    <option value="14">Julia Hodges</option>
                                    <option value="15">Michael Sutherland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Employee:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Priority">
                                    <option label="Select Priority"></option>
                                    <option value="1">High</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-leaves">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">Emp ID</th>
                                    <th class="border-bottom-0 w-5">Emp Name</th>
                                    <th class="border-bottom-0">Leave Type</th>
                                    <th class="border-bottom-0">From</th>
                                    <th class="border-bottom-0">To</th>
                                    <th class="border-bottom-0">Days</th>
                                    <th class="border-bottom-0">Reason</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>FD2987</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar brround me-3"
                                                style="background-image: url(assets/images/users/1.jpg)"></span>
                                            <div class="me-3 mt-0 mt-sm-2 d-block">
                                                <h6 class="mb-1 fs-14">Faith Harris</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Casual Leave</td>
                                    <td>16-01-2021</td>
                                    <td>16-01-2021</td>
                                    <td class="font-weight-semibold">1 Day</td>
                                    <td>Personal</td>
                                    <td>
                                        <span class="badge badge-success">Approved</span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                            data-bs-target="#editmodal">
                                            <i class="feather feather-edit primary text-primary" data-bs-toggle="tooltip"
                                                data-original-title="View"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-btns1" data-bs-toggle="modal"
                                            data-bs-target="#deletemodal">
                                            <i class="feather feather-trash primary text-primary" data-bs-toggle="tooltip"
                                                data-original-title="View"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row-->

    {{-- delete confirmation --}}
    <div class="modal fade" id="deletemodal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <h3>Are you sure want to delete ?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button> <button class="btn btn-danger"
                        data-bs-toggle="modal" data-bs-target="#">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- delete confirmation --}}


    {{-- delete confirmation --}}
    <div class="modal fade" id="editmodal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <h3>Are you sure want to Update It ?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                    <button class="btn btn-success"
                        data-bs-toggle="modal" data-bs-target="#">Approve</button>
                </div>
            </div>
        </div>
    </div>
    {{-- delete confirmation --}}
    @endsection
