@extends('admin.setting.setting')
@section('subtitle')
Account
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon las la-cog"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Name</h5>
                        </a>
                        <p>Fix HR</p>
                        <a href="#" data-bs-target="#nameModal" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span
                                class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i class="nav-icon las la-envelope"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Phone Number</h5>
                        </a>
                        <p>+91 1234567890</p>
                        <a class="text-muted" href="#" data-bs-target="#bAddress" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-danger-transparent text-danger border-danger"><i class="nav-icon lar la-credit-card"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Email Address</h5>
                        </a>
                        <p>Fixingdots@gmail.com</p>
                        <a href="#" data-bs-target="#emailModal" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i class="nav-icon las la-lock"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Business Type</h5>
                        </a>
                        <p>Software Development</p>
                        <a href="#" data-bs-target="#btypeModal" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-warning-transparent text-warning border-warning"><i class="nav-icon las la-share-alt"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Add/Delete Business</h5>
                        </a>
                        <p>1 Active Business</p>
                        <a href="#" data-bs-target="#baddDelete" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span
                                class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i class="nav-icon las la-envelope"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Subscriptions</h5>
                        </a>
                        <p>Desktop App</p>
                        <a href="#" data-bs-target="#bAddress" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-2 col-md-12">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-danger-transparent text-danger border-danger"><i class="nav-icon lar la-credit-card"></i></span>
                        </div>
                    </div>
                    <div class="col-xl-10 col-sm-10 col-md-12">
                        <a href="#">
                            <h5 class="mb-1 text-dark">KYB</h5>
                        </a>
                        <p>To awail online payment services</p>
                        <a href="#" data-bs-target="#kybModal" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 {{--  Name --}}
 <div class="modal fade" id="nameModal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Name</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
                    <input class="form-control" placeholder="Enter Name" type="text">

                </div>
            </div>
            <div class="modal-footer  border-0">
                <a href="#" class="btn btn-primary btn-sm">Continue</a>
            </div>
        </div>
    </div>
</div>
 {{--  Email --}}
 <div class="modal fade" id="emailModal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Email</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Email</p>
                    <input class="form-control" placeholder="Enter Email" type="email">

                </div>
            </div>
            <div class="modal-footer  border-0">
                <a href="#" class="btn btn-primary btn-sm">Continue</a>
            </div>
        </div>
    </div>
</div>
 {{--  Type --}}
 <div class="modal fade" id="btypeModal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Business Type</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <div class="form-group co-lg">
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Choose Industrial Sector</p>
                        <select class="form-control custom-select select2" data-placeholder="Select Department">
                            <option label="Select Employee"></option>
                            <option value="1">Faith Harris</option>
                            <option value="2">Austin Bell</option>
                        </select>
                    </div>
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
                    <input class="form-control" placeholder="Software Industry" type="email">
                </div>
            </div>
            <div class="modal-footer  border-0">
                <a href="#" class="btn btn-primary btn-sm">Continue</a>
            </div>
        </div>
    </div>
</div>
{{--  Manage Business --}}
<div class="modal fade" id="baddDelete">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Manage Business</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg d-none" id="anbc">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                    <input class="form-control" placeholder="Enter business Name" type="text">
                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                        class="text-primary">Terms & Conditions</a></p>
                </div>
                <div class="col-lg" id="anbc1">
                    <p class="mb-0 pb-0 text-dark fs-16 mt-1"><b>Fixing Dots</b></p>
                    <p class="mb-0 pb-0 text-muted fs-12 ">14 Employees</p>
                </div>
            </div>
            <div class="modal-footer  border-0" id="anbbtns">
                <a href="#" class="btn btn-outline-dark btn-sm" id="anbbtn1">Cancel</a>
                <a href="#" class="btn btn-primary btn-sm" id="anbbtn2">Add New Business</a>
            </div>
            <div class="modal-footer border-0 d-none" id="anbbtns1">
                <a href="#" class="btn btn-outline-light btn-sm" id="anbbtn3">Cancel</a>
                <a href="#" class="btn btn-success btn-sm" id="anbbtn4">Continue</a>
            </div>
        </div>
    </div>
</div>
{{--  KYB --}}
<div class="modal fade" id="kybModal">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">KYB Registration</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Registered Phone Number</p>
                    <input class="form-control" placeholder="eg. +91 1234567890" type="text">
                </div>
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Type</p>
                    <select class="form-control select2" data-placeholder="Department">
                        <option label="Fixed Amount"></option>
                        <option selected>Fixing Dots</option>
                        <option>KES</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer  border-0">
                <a href="#" class="btn btn-primary btn-sm">Continue</a>
            </div>
        </div>
    </div>
</div>




@endsection
