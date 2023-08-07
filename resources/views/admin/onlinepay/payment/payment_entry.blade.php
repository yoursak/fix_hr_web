@extends('admin.layout.master')
@section('title')
Bulk Payment- Save payment Entry
@endsection

@section('contents')
<div class="row">
    <div class="card">
        <div class="card-header  border-0">
            <div class="page-rightheader ms-auto">
                <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                    <div class="btn-list d-flex">
                        <a class="modal-effect btn btn-outline-primary mb-3"
                            data-effect="effect-scale" data-bs-toggle="modal" href="#BulkpayAdd"><i
                                class="fa fa-file-excel-o"></i> Bulk Excel Upload</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Employee Type</label>
                                    <select name="projects" class="form-control custom-select select2"
                                        data-placeholder="Select">
                                        <option label="Select"></option>
                                        <option value="1">Allowance</option>
                                        <option value="2">Bonus</option>
                                        <option value="3">Deduction</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Payment Record Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Amount Type</label>
                                    <select name="projects" class="form-control custom-select select2"
                                        data-placeholder="Select">
                                        <option label="Select"></option>
                                        <option value="1">Paid</option>
                                        <option value="2">Add to salary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Cycle</label>
                                    <input type="date" class="form-control" placeholder="#ID">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-header border-bottom-0">
            <div>
                <h5 class=""><b>Information Technology Employee(15)</b></h5>
            </div>
        </div>
        <div class="card-body" style="height: 30rem; overflow:scroll">
            <div class="col">
                <label class="custom-control custom-checkbox">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xl-3 col-sm-11 my-auto">
                                <label class="form-label my-auto fs-16">Aman Sahu</label>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input type="text" class="form-control my-auto"
                                    placeholder="Amount">
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <input type="text" class="form-control my-auto"
                                    placeholder="Note">
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection

