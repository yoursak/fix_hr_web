@extends('admin.setting.setting')
@section('subtitle')
    Account
@endsection
@section('settings')
    <div class="row row-sm">
        @php
            $BType = app\Helpers\Central_unit::GetBusinessType();
            $Bcategory = app\Helpers\Central_unit::GetBusinessCategory();
            
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
                                    class="nav-icon fa fa-id-card-o"></i></span>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div class="my-auto"><a href="#">
                                    <h5 class="my-auto text-dark">Business Category</h5>
                                </a>
                                <p class="my-auto">{{ $accDetail->business_name }}</p>
                                {{-- <p class="my-auto">{{ $accDetail->business_name }}</p> --}}
                            </div>
                            <div class="my-auto"><a href="#" data-bs-target="#modaldemo4" data-bs-toggle="modal"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $Bname = app\Helpers\Central_unit::GetBusinessCategoryName($accDetail->business_categories);
                
            @endphp
            {{-- Logo Upload --}}
            <form method="post" enctype="multipart/form-data" action="{{ route('upload.logo', $accDetail->id) }}">
                @csrf

                <div class="modal fade" id="bLogo">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header border-0">
                                <h4 class="modal-title">Logo</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            </div>
                            {{-- <div class="form-row border-bottom"> --}}
                            <p class=" fs-13 px-4 border-bottom " style="color: rgb(110, 104, 88)">Please upload the logo
                                ogf
                                business in png, jpg or jpeg formate, this logo will be visible in payment slip.</p>
                            {{-- </div> --}}
                            <div class="modal-body">
                                {{-- <div class="card-header border-bottom-0"> --}}
                                <h3 class="card-title">File Upload</h3>
                                {{-- </div> --}}
                                <input type="text" name="editlogoId" value="{{ $accDetail->id }}" hidden>
                                {{-- src="{{ asset('business_logo/' . Session::get('login_business_image')) }}" --}}
                                <input type="file" name="image"  class="dropify" data-default-file="{{asset('business_logo/'.$accDetail->business_logo )}}" />
{{--                               
                                <img type="file" src="{{asset('business_logo/'.$accDetail->business_logo )}}" class="dropify" name="image" 
                                    data-default-file=""
                                    data-height="180" /> --}}
                             
                            </div>
                            <div class="modal-footer py-1">
                                <button type="" class="btn btn-danger savebtn">Cancel</button>
                                <button type="submit" class="btn btn-primary savebtn me-0">Update & Continue</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            {{-- Business Name --}}
            <form method="post" action="{{ route('sbussinessname.update', $accDetail->id) }}">
                @csrf
                <div class="modal fade" id="modaldemo4">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header">
                                <h4 class="modal-title">Business Category</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group co-lg">
                                    <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>

                                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Category</p>
                                    <select class="form-control custom-select select2" data-placeholder="Select Department"
                                        name="select">

                                        <option label="Select Employee" value="{{ $Bname->id }}">{{ $Bname->name }}
                                        </option>
                                        {{-- @foreach ($BType as $btype)
                                                <option value="{{ $btype->id }}">{{ $btype->name }}</option>
                                            @endforeach --}}
                                        @foreach ($Bcategory as $bcategory)
                                            <option value="{{ $bcategory->id }}">{{ $bcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                                <input class="form-control" placeholder="Software Industry" type="text"
                                    name="business_name" value="{{ $accDetail->business_name }}">
                            </div>
                            <div class="modal-footer py-1">
                                <button type="" class="btn btn-danger savebtn">Cancel</button>
                                <button type="submit" class="btn btn-primary     savebtn me-0">Update & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
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
                                <p class="my-auto" class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a
                                        href="#" class="text-primary">Terms & Conditions</a></p>
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
                                <p class="my-auto" class="my-auto">{{ $accDetail->client_name }}</p>
                            </div>
                            <div class="my-auto">
                                <a href="#" data-bs-target="#nameUpdateModal" data-bs-toggle="modal"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  Name --}}
            {{-- @foreach ($branch as $item) --}}
            <form method="post" action="{{ route('name.update', $accDetail->id) }}">
                <div class="modal fade" id="nameUpdateModal">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header">
                                <h4 class="modal-title ">Name</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            @csrf
                            <div class="modal-body">
                                <p>Please add your name to continue</p>

                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
                                <input class="form-control" placeholder="Enter Name" type="text" name="name"
                                    value="{{ $accDetail->client_name }}">
                            </div>
                            <div class="modal-footer py-1" style="background:#f9f8f8;">
                                <button class="btn btn-danger savebtn" type="sumbit">Cancel</button>
                                <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue</button>
                                {{-- <a href="{{ route('name.update') }}" method="post" type="sumbit" class="btn btn-primary btn-sm">Continue</a> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </form>
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
                                <p class="my-auto"> {{ $accDetail->mobile_no }}</p>
                            </div>
                            <div class="my-auto"> <a class="text-muted" href="#" data-bs-target="#bphone"
                                    data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{--  KYB --}}
            <form method="post" action="{{ route('sphone.update', $accDetail->id) }}">
                @csrf
                <div class="modal fade" id="bphone">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header " style="background:#f9f8f8;">
                                <h4 class="modal-title">Phone Number</h4>

                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>

                            @csrf
                            <div class="modal-body">
                                <p>Please add your phone number to continue</p>
                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Phone Number</p>
                                <input class="form-control" placeholder="Enter Name" type="text" name="phone"
                                    value="{{ $accDetail->mobile_no }}" maxlength="10">
                            </div>
                            <div class="modal-footer py-1" style="background:#f9f8f8;">
                                <button class="btn btn-danger savebtn" type="cancel">Cancel</button>
                                <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue </button>
                                {{-- <a href="{{ route('name.update') }}" method="post" type="sumbit" class="btn btn-primary btn-sm">Continue</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>

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
                                <p class="my-auto">{{ $accDetail->business_email }}</p>
                            </div>
                            <div class="my-auto"> <a href="#" data-bs-target="#emailupdateModal"
                                    data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- <form method="post" action="{{ route('name.update', $accDetail->id) }}"> --}}
            {{-- @csrf --}}
            <div class="modal fade" id="emailupdateModal">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header border">
                            <h4 class="modal-title ">Email</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Please add your email to continue</p>
                            <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                            <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Email</p>
                            <input class="form-control" placeholder="Enter Email" type="email" name="email"
                                value="{{ $accDetail->business_email }}" readonly>
                        </div>
                        <div class="modal-footer py-1">
                            <button class="btn btn-danger savebtn" type="">Cancel</button>
                            <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue </button>
                            {{-- <a href="#" class="btn btn-primary btn-sm">Continue</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
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
                                <p class="my-auto"></p>
                            </div>
                            <div class="my-auto"> <a href="#" data-bs-target="#btypeModal"
                                    data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- Business Name --}}
            @php
                $Btypename = app\Helpers\Central_unit::GetBusinessTypeName($accDetail->business_type);
                
            @endphp
            <form method="post" action="{{ route('sbussinesstype.update', $accDetail->id) }}">
                @csrf
                <div class="modal fade" id="btypeModal">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header">
                                <h4 class="modal-title">Business Type</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="editBtypeId" value="{{ $accDetail->id }}" hidden>

                                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Type</p>
                                    <select class="form-control custom-select select2"
                                        data-placeholder="Select Department" name="select">
                                        <option label="Select Employee" value="{{ $Btypename->id }}">
                                            {{ $Btypename->name }}</option>
                                        @foreach ($BType as $btype)
                                            <option value="{{ $btype->id }}">{{ $btype->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer py-1">
                                <button type="" class="btn btn-danger savebtn">Cancel</button>
                                <button type="submit" class="btn btn-primary savebtn me-0">Update & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            {{--  Manage Business --}}

        </div>

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
                                <p class="my-auto">{{ $accDetail->business_address }}</p>
                                {{-- <p class="my-auto">Fixingdots,Keshar Earth Solution Building, Ring Road No-2, Raipur</p> --}}
                            </div>
                            <div class="my-auto"> <a href="#" data-bs-target="#bAddress" data-bs-toggle="modal"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('saddress.update', $accDetail->id) }}">
                @csrf
                <div class="modal fade" id="bAddress">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content tx-size-sm">
                            {{-- <div>
                                    <h4 class="modal-title ms-2">Business Address</h4><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"><span
                                            aria-hidden="true">&times;</span></button>
                                </div> --}}
                            <div class="modal-header">
                                <h4 class="modal-title">Business Address</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Please add your phone number to continue</p>

                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Address Line</p>
                                <textarea class="form-control " placeholder="Address Line 1" rows="3" name="address" maxlength="100">{{ $accDetail->business_address }}</textarea>


                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Country</p>
                                <input class="form-control" placeholder="Confirm Bank Account Number" name="country"
                                    type="text" value="India" readonly>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">State</p>
                                <input class="form-control" placeholder="Confirm Bank Account Number" name="state"
                                    type="text" value="{{ $accDetail->state }}">

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">City</p>
                                <input class="form-control" placeholder="City Name" name="city" type="text"
                                    value="{{ $accDetail->city }}">

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Pin Code</p>
                                <input class="form-control" placeholder="Pin Code" name="pincode" type="text"
                                    value="{{ $accDetail->pin_code }}">
                            </div>
                            <div class="modal-footer d-flex py-1">
                                <button class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                            <div class="my-auto"> <a href="#" data-bs-target="#gstNumber"
                                    data-bs-toggle="modal"><i class="fa fa-percentage fs-20 my-auto"></i></a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--  Email --}}

    {{--  Type --}}





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


    {{-- Business Address detail --}}
@endsection
