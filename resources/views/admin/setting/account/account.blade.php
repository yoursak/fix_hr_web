@extends('admin.setting.setting')
@section('subtitle')
Account
@endsection
@section('settings')
<div class="row row-sm">
    @php
    $BType = app\Helpers\Central_unit::GetBusinessType();
    // dd($BType);
    @endphp
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon ion ion-images"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Business Logo</h5>
                            </a>
                            <p class="my-auto">Not Added</p>
                        </div>
                        <div class="my-auto"><a href="#" data-bs-target="#bLogo" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-id-card-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Business Name</h5>
                            </a>
                            <p class="my-auto">Fixing Dots</p>
                        </div>
                        <div class="my-auto"><a href="#" data-bs-target="#modaldemo4" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon mdi mdi-account-edit"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto">
                            <a href="#">
                                <h5 class="my-auto text-dark">Name</h5>
                            </a>
                            <p class="my-auto" class="my-auto">{{$accDetail->name}}</p>
                        </div>
                        <div class="my-auto">
                            <a href="#" data-bs-target="#nameModal" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-phone"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Phone Number</h5>
                            </a>
                            <p class="my-auto">{{$accDetail->country_code}} {{$accDetail->phone}}</p>
                        </div>
                        <div class="my-auto"> <a class="text-muted" href="#" data-bs-target="#bAddress"
                                data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-envelope-o"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Email Address</h5>
                            </a>
                            <p class="my-auto">{{$accDetail->email}}</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#emailModal" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-suitcase"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Business Type</h5>
                            </a>
                            <p class="my-auto">Software Development</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#btypeModal" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-edit"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Add/Delete Business</h5>
                            </a>
                            <p class="my-auto">1 Active Business</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#baddDelete" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon si si-diamond"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Subscriptions</h5>
                            </a>
                            <p class="my-auto">Desktop App</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#bAddress" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="nav-icon fa fa-copy"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">KYB</h5>
                                </a>
                                <p class="my-auto">To awail online payment services</p>
                            </div>
                            <div class="my-auto"> <a href="#" data-bs-target="#kybModal" data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="nav-icon fa fa-bank"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Business Bank Account</h5>
                                </a>
                                <p class="my-auto">XXXX XXXX XX12</p>
                            </div>
                            <div class="my-auto"><a href="#" data-bs-target="#bAccName" data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon fa fa-map-signs"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Business Address</h5>
                            </a>
                            <p class="my-auto">Fixingdots,Keshar Earth Solution Building, Ring Road No-2, Raipur</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#bAddress" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon zmdi zmdi-receipt mx-1"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">GSTN</h5>
                            </a>
                            <p class="my-auto">22AAAAA0000A1Z5</p>
                        </div>
                        <div class="my-auto"> <a href="#" data-bs-target="#gstNumber" data-bs-toggle="modal"><i
                                    class="fa fa-percentage fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Name --}}
<div class="modal fade" id="nameModal">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Name</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
                    <input class="form-control" placeholder="Enter Name" type="text" name="name"
                        value="{{$accDetail->name}}">
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
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Email</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Email</p>
                    <input class="form-control" placeholder="Enter Email" type="email" name="email"
                        value="{{$accDetail->email}}" disabled>

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
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Business Type</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <div class="form-group co-lg">
                        <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Choose Industrial Sector</p>
                        <select class="form-control custom-select select2" data-placeholder="Select Department">
                            <option label="Select Employee"></option>
                            @foreach ($BType as $btype)
                            <option value="{{$btype->id}}">{{$btype->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
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
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Manage Business</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg d-none" id="anbc">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                    <input class="form-control" placeholder="Enter business Name" type="text">
                    <p class="my-auto" class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                            class="text-primary">Terms & Conditions</a></p>
                </div>
                <div class="col-lg" id="anbc1">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-16 mt-1"><b>Fixing Dots</b></p>
                    <p class="my-auto" class="mb-0 pb-0 text-muted fs-12 ">14 Employees</p>
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
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">KYB Registration</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Registered Phone Number</p>
                    <input class="form-control" placeholder="eg. +91 1234567890" type="text">
                </div>
                <div class="col-lg">
                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Type</p>
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

{{-- Business Name --}}
<div class="modal fade" id="modaldemo4">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Business Name</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                    <input class="form-control" placeholder="Business Name" type="text">
                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                            class="text-primary">Terms & Conditions</a></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary savebtn">Continue</button>
            </div>
        </div>
    </div>
</div>
{{-- GST Number --}}
<div class="modal fade" id="gstNumber">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">GST Number</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">GST Number</p>
                    <input class="form-control" placeholder="eg. 22XXXXXXXXA1Z5" type="text">
                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                            class="text-primary">Terms & Conditions</a></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary savebtn">Continue</button>
            </div>
        </div>
    </div>
</div>
{{-- Business Account detail --}}
<div class="modal fade" id="bAccName">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <div>
                    <h4 class="modal-title ms-2">Business Account Details</h4><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal"></button><br />
                    <p class="mb-0 pb-0 fs-13 ms-2 " style="color: rgb(110, 104, 88)">Provide Business Acount Detail
                        to
                        get Instant Refound in the
                        case of payout or transaction failures</p>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">Account Holder Name</p>
                    <input class="form-control" placeholder="Holder Name" type="text">

                    <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">Account Number</p>
                    <input class="form-control" placeholder="Bank Account Number" type="password">

                    <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">Confirm Account Number</p>
                    <input class="form-control" placeholder="Confirm Bank Account Number" type="text">

                    <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">IFSC Code</p>
                    <input class="form-control" placeholder="IFSC Code" type="text">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary savebtn">Continue</button>
            </div>
        </div>
    </div>
</div>
{{-- Logo Upload --}}
<div class="modal fade" id="bLogo">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <div>
                    <h4 class="modal-title ms-2">Add Logo</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button><br />
                    <p class="mb-0 pb-0 fs-13 ms-2 " style="color: rgb(110, 104, 88)">Please upload the logo ogf
                        business in png, jpg or jpeg formate, this logo will be visible in payment slip.</p>
                </div>
            </div>
            <div class="modal-body">
                <form method="post" class="card">
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <input type="file" class="dropify"
                                    data-default-file="{{ asset('imgs/uploadgificon.gif') }}" data-width="200"
                                    data-height="200" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary savebtn">Continue</button>
            </div>
        </div>
    </div>
</div>

{{-- Business Address detail --}}
<div class="modal fade" id="bAddress">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <div>
                    <h4 class="modal-title ms-2">Address</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button><br />
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Address Line 1</p>
                    <textarea class="form-control mb-4" placeholder="Address Line 1" rows="3"
                        maxlength="100"></textarea>

                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Address Line 1</p>
                    <textarea class="form-control mb-4" placeholder="Address Line 2" rows="3"
                        maxlength="100"></textarea>

                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">State</p>
                    <input class="form-control" placeholder="Confirm Bank Account Number" type="text">

                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">City</p>
                    <input class="form-control" placeholder="City Name" type="text">

                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Pin Code</p>
                    <input class="form-control" placeholder="Pin Code" type="text">
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