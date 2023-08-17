@extends('admin.layout.master')
@section('title')
Bulk Allowance/Deduction/Bonus
@endsection

@section('contents')
<div class="row">
    <div class="col-12">
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
                    <div class="col-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Entry Type</label>
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
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Description</label>
                                    <input type="text" class="form-control" placeholder="Description">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Paid to Salary cycle</label>
                                    <select name="projects" class="form-control custom-select select2"
                                        data-placeholder="Select">
                                        <option label="Select"></option>
                                        <option value="1">Paid</option>
                                        <option value="2">Add to salary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="">
                                    <label class="form-label mb-0 mt-2">Date</label>
                                    <input type="date" class="form-control" placeholder="#ID">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-pay">
                    <ul class="tabs-menu nav">
                        <li><a href="#tab21" data-bs-toggle="tab" class="active">Pay Same Amount to All</a></li>
                        <li><a href="#tab22" data-bs-toggle="tab" class="">Pay Differenet Amount</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab21" style="height:25rem; overflow:scroll;">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <div>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label">All Employee</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"><b>Information Technology
                                                    Employee(15)</b></span>
                                                    <span class="fs-11">By continuing you agree to <b><a href="#"
                                                        class="text-primary">Tearm & Conditions</a></b></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label">Aman Sahu</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label">Karan Verma</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab22" style="height:25rem; overflow:scroll;">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <div>
                                        <span class=""><b>Information Technology Employee(15)</b></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                        <label class="custom-control custom-checkbox">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </div>
                                                    <div class="col-xl-3 col-sm-11">
                                                        <label class="form-label mb-0 mt-2">Aman Sahu</label>
                                                    </div>
                                                    <div class="col-xl-4 col-sm-11">
                                                        <input type="text" class="form-control"
                                                            placeholder="Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

