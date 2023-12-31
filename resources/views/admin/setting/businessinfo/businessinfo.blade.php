@extends('admin.setting.setting')
@section('subtitle')
    Business Info
@endsection
@section('settings')
    <div class="row row-sm">
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
                            <div class="my-auto"><a href="#" data-bs-target="#modaldemo4" data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

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
        </div>
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
                            <div class="my-auto"><a href="#" data-bs-target="#bLogo" data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

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
                                    class="nav-icon fa fa-map-signs mx-2"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Business Address</h5>
                                </a>
                                <p class="my-auto">Fixingdots,Keshar Earth Solution Building, Ring Road No-2, Raipur</p>
                            </div>
                            <div class="my-auto"> <a href="#" data-bs-target="#bAddress" data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                        </div>
                    </div>
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
                        <textarea class="form-control mb-4" placeholder="Address Line 1" rows="3" maxlength="100"></textarea>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Address Line 1</p>
                        <textarea class="form-control mb-4" placeholder="Address Line 2" rows="3" maxlength="100"></textarea>

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
