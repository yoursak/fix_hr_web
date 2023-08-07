@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
@endsection
@section('settings')

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Admin Setting</div>
        <p class="text-muted">2 Admins Including You</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-header  border-0">
            <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Owner</b></span></h4>
        </div>
        <div class="card-body border-bottum-0">
            <div class="row">
                <div class="col-xl-3 my-auto">
                    <h5 class="my-auto">Dilip Sahu</h5>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto" style="color:rgb(34, 33, 29)"><i class="fe fe-mail mx-2"></i>dilipsahu@xyz.com</p>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto " style="color:rgb(34, 33, 29)"><i class="fe fe-phone mx-2"></i>+91 8548652478</p>
                </div>
                <div class="col-xl-3">
                    <p class="my-auto text-muted text-end">
                        <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a>
                        <a class="btn text-primary" id="" href="#"><i class="fe fe-trash"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-header  border-0">
            <div class="page-leftheader">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Admins</b></span></h4>
                <p class="text-muted mt-1">Admins have complete access to all the assigned businesses</p>
            </div>
        </div>
        <div class="card-body border-bottum-0">
            <div class="row">
                <div class="col-xl-3 my-auto">
                    <h5 class="my-auto">Nisha Sahu</h5>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto" style="color::rgb(34, 33, 29)"><i class="fe fe-mail mx-2"></i>hr@xyz.com</p>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto " style="color:rgb(63, 61, 55)"><i class="fe fe-phone mx-2"></i>+91 8548652478</p>
                </div>
                <div class="col-xl-3">
                    <p class="my-auto text-muted text-end">
                        <a class="btn text-primary" id="" href="#"><i class="fe fe-edit"></i></a>
                        <a class="btn text-primary" id="" href="#"><i class="fe fe-trash"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class=" text-end">
    <a href="{{url('settings/salarysetting')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Save</a>
</div>
@endsection
