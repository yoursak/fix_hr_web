@extends('admin.setting.setting')
@section('subtitle')
    Salary / Employee Data Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Employee Detail</div>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" id="addNewManager" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Add Field</button>
                        <button type="button" id="SaveNewManager" class="btn btn-outline-success d-none" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Save Field</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-body d-none" id="addManager">
                <div class="row" >
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add New Field</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-xl-5">
                                    <div class="form-group">
                                        <p class="form-label">Field Name</p>
                                        <input type="text" class="form-control" value="" placeholder="Enter Name" aria-label="Search" tabindex="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <h4 class="my-auto"><b>Employee Personal Detail</b></h4>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Gender, Date of Birth, Address</p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <h4 class="my-auto"><b>Employement Information</b></h4>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">Employee Id, Joining Date, Department, Designation</p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0">
                <div class="row">
                    <div class="col-xl-12 my-auto">
                        <h4 class="my-auto"><b>Goverment IDs</b></h4>
                        <p class="my-auto fs-12 text-muted" style="color:rgb(34, 33, 29)">PAN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Save</a>
    </div>
@endsection
