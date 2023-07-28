@extends('admin.setting.setting')
@section('subtitle')
    Salary / Manage Salary Template
@endsection

@section('css')
@endsection
@section('settings')
    <div class="row" id="editform">
        <div class="card">
            <div class="card-body border-bottum-0">
                <div class="d-flex justify-content-between my-auto">
                    <div class=" col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-dark">Template Name</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="default"
                                >
                                <span class="custom-control-label">Set as default</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Employee Detail</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="mb-0 fs-16 text-dark">Employee Type</p>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                            <select class="form-control select2" data-placeholder="Employee Type">
                                <option label="Fixed Amount"></option>
                                <option>Monthly Regular</option>
                                <option>Hourly Regular</option>
                                <option>Daily Regular</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="mb-0 fs-16 text-dark">Salary Calculation By</p>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                            <select class="form-control select2" data-placeholder="Salary Calculation By"
                                style="width:12rem">
                                <option label="Fixed Amount"></option>
                                <option>Fixed Amount</option>
                                <option>Percentage</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Earnings</h4>
            </div>
            <div class="card-body border-bottom-0">
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class="col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-dark">Basic + DA</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control bg-muted" id="inputName" placeholder="Enter Amount"
                            disabled>
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class=" col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-dark">HRA</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control bg-muted" id="inputName" placeholder="Enter Amount"
                            disabled>
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class=" col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-dark">Medical Allowance</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control bg-muted" id="inputName" placeholder="Enter Amount"
                            disabled>
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete"><i
                                    class="feather feather-trash-2 text-danger"></i></a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class="col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-primary btn" data-bs-target="#earning" data-bs-toggle="modal"><b>Add more</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Deduction</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="mb-0 fs-16 text-dark">Employee State Insurance(ESI)</p>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                            <select multiple="multiple" class="multi-select" data-placeholder="Deduction">
                                <option value="1">Basic + DA</option>
                                <option value="2">HRA</option>
                                <option value="3">Medical Allowance</option>
                                <option value="4">Medical Allowance</option>
                                <option value="5">Special Allowance</option>
                                <option value="6">OT Wages</option>
                                <option value="7">Bonas Wages</option>
                                <option value="8">Allowance Wages</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 text-end">
                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Delete"><i
                                class="feather feather-trash-2 text-danger"></i></a>
                    </div>
                </div>
                <div class="my-auto">
                    <p class="mb-0 fs-16 text-primary btn" data-bs-target="#deduction" data-bs-toggle="modal"><b>Add more</b></p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Employer's Contribution</h4>
            </div>
            <div class="card-body border-bottom-0">
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class="col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-dark">Employee State Insurance(ESI)</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class=" col-xl-4 my-auto">
                        <p class="mb-0 fs-16 text-primary btn" data-bs-target="#contribution" data-bs-toggle="modal"><b>Add more</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" text-end">
            <a href="{{url('settings/salary/salaryTemp')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Save</a>
        </div>
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
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
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
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
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
                    <button class="btn btn-outline-primary cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>
@endsection
