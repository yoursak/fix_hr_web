@extends('admin.setting.setting')
@section('subtitle')
    Salary / Manage Salary Template
@endsection

@section('css')
@endsection
@section('settings')
    <div class="row d-none">
        <div class="card">
            <div class="card-header">
                <div class="page-leftheader ">
                    <p class="mb-0 fs-18 text-dark"><b>Department</b></p>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#adddepartmentmodal">Create Template</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body border-bottum-0">
                <table class="table mb-0 text-nowrap">
                    <tbody>
                        <tr class="border-bottom-0">
                            <td>
                                <div class="d-flex">
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <span class="avatar avatar-md bradius fs-20 bg-primary-transparent">2</span>
                                    </div>
                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                        <p class="mb-0 fs-16 text-dark">Default-Copy</p>
                                        <div class="clearfix"></div>
                                        <small class="text-muted">UI designer</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start fs-12"><span class="bg-success p-1 rounded">Default</span></td>
                            <td class="text-end">
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body border-bottum-0">
                <div class="d-flex justify-content-between my-auto">
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Template Name</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="default"
                                    checked>
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
            <div class="card-body border-bottom-0">
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Employee Type</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete">
                                {{-- <i class="feather feather-trash-2 text-danger"></i> --}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Salary Calculation By</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    <div class="my-auto">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete">
                                {{-- <i class="feather feather-trash-2 text-danger"></i> --}}
                            </a>
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
                    <div class="col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Basic + DA</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
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
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">HRA</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
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
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Medical Allowance</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
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
                    <div class="col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-primary btn"><b>Add more</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Deduction</h4>
            </div>
            <div class="card-body border-bottom-0">
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class="col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Employee State Insurance(ESI)</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
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
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-primary btn"><b>Add more</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-0">
                <h4 class="mb-0 fs-18 text-dark">Employer's Contribution</h4>
            </div>
            <div class="card-body border-bottom-0">
                <div class="d-flex justify-content-between my-auto py-2">
                    <div class="col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-dark">Employee State Insurance(ESI)</p>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control" id="inputName" placeholder="Name">
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
                    <div class=" col-xl-3 my-auto">
                        <p class="mb-0 fs-16 text-primary btn"><b>Add more</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
