@extends('admin.setting.setting')
@section('subtitle')
    Salary / Employee Bank Account Details
@endsection

@section('css')
@endsection
@section('settings')

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Add Staff Account Number</div>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#clockinmodal"><i class="fa fa-file-excel-o mx-2"></i>Excel Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-xl-4">
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
                    <div class="col-md-12 col-xl-4">
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
                    <div class="col-md-12 col-xl-4">
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
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap" id="hr-table">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Emp Detail</th>
                            <th class="border-bottom-0">A/c Holder Name</th>
                            <th class="border-bottom-0">A/c Number</th>
                            <th class="border-bottom-0">Confirm A/c Number</th>
                            <th class="border-bottom-0">IFSC NO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <h6 class="mb-1 fs-14">Faith Harris</h6>
                                        <p class="text-muted mb-0 fs-12">+91 254685452485</p>
                                    </div>
                                </div>
                            </td>
                            <td><input type="text" class="form-control"placeholder="Enter A/c Holder Name"></td>
                            <td><input type="password" class="form-control"placeholder="Enter A/c Number"></td>
                            <td><input type="text" class="form-control"placeholder="Confirm A/c Number"></td>
                            <td><input type="text" class="form-control"placeholder="Enter IFSC Code"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class=" text-end">
    <a href="{{url('settings/salarysetting')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Save</a>
</div>

    {{-- Earnings --}}
    <div class="modal fade" id="earning">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Earning default list</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Selecting at least one is must.</p>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Suggetion</p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Basic + DA</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">HRA</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Medical Allowance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Travel Allowance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Special Allowance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Meal Allowance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Leave Travel Allowance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Bonus</span>
                        </label>
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Custom List</p>
                        <div class="col-12 text-center my-3">
                            <a href="#" class="text-primary"><b>Add Custum</b></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Deductions --}}
    <div class="modal fade" id="deduction">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Deduction default list</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Selecting at least one is must.</p>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Suggetion</p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Provided Found (PF)</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Employee State Insurance (ESI)</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Professional Tax (PT)</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Labour Welfare Found (LWF)</span>
                        </label>
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Custom List</p>
                        <div class="col-12 text-center my-3">
                            <a href="#" class="text-primary"><b>Add Custum</b></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Contribution --}}
    <div class="modal fade" id="contribution">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <div>
                        <h4 class="modal-title ms-2">Employer's Contribution default list</h4>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-2">Selecting at least one is must.</p>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Suggetion</p>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Provided Found (PF)</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Employee State Insurance (ESI)</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
                            <span class="custom-control-label">Health Insurance</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                            <span class="custom-control-label">Labour Welfare Found (LWF)</span>
                        </label>
                        <p class="mb-0 pb-0 text-muted fs-14 mt-1 ">Custom List</p>
                        <div class="col-12 text-center my-3">
                            <a href="#" class="text-primary"><b>Add Custum</b></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>
@endsection
