@extends('admin.setting.setting')
<script src="{{ asset('assets/js/cities.js') }}"></script>
@section('subtitle')
    Account
@endsection
@section('settings')
    <div class=" p-0 my-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/account') }}">Settings</a></li> --}}
            <li class="active"><span><b>Account Settings</b></span></li>
        </ol>
    </div>
    <div class="">
        <p class="text-muted">Change your profile and account settings</p>
    </div>

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
                                <p class="my-auto">{{ $accDetail->business_logo ? 'Added' : 'Not Added' }}</p>
                            </div>
                            <div class="my-auto"><a href="#" data-bs-target="#bLogo" data-bs-toggle="modal"><i
                                        class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @php
            $central = new App\Helpers\Central_unit();
            $categoryName = $central::GetBusinessCategoryName($accDetail->business_categories);
            $businesstypeNames = $central::GetBusinessTypeName($accDetail->business_type);
            
        @endphp

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
                                <p class="my-auto">{{ $categoryName->name }}</p>
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

            <div class="modal fade" id="bLogo">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header border-0">
                            <h4 class="modal-title">Business Logo</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" enctype="multipart/form-data"
                            action="{{ route('upload.logo', $accDetail->id) }}">
                            @csrf
                            {{-- <div class="form-row border-bottom"> --}}
                            <p class=" fs-13 px-4 mt-3 pb-3 border-bottom " style="color: rgb(110, 104, 88)">Please upload the logo of your business in png, jpg or jpeg formate, this logo will be visible in payment slip.</p>
                            {{-- </div> --}}
                            <div class="modal-body">
                                {{-- <div class="card-header border-bottom-0"> --}}
                                <h3 class="card-title">File Upload</h3>
                                {{-- </div> --}}
                                <input type="text" name="editlogoId" value="{{ $accDetail->id }}" hidden>
                                {{-- src="{{ asset('business_logo/' . Session::get('login_business_image')) }}" --}}
                                <input type="file" name="image" class="dropify"
                                    data-default-file="{{ asset('business_logo/' . $accDetail->business_logo) }}"
                                     />
                                {{--                               
                                <img type="file" src="{{asset('business_logo/'.$accDetail->business_logo )}}" class="dropify" name="image" 
                                    data-default-file=""
                                    data-height="180" /> --}}

                            </div>
                            <div class="modal-footer py-1">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary savebtn me-0">Update & Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Business Name --}}
            <div class="modal fade" id="modaldemo4">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header">
                            <h4 class="modal-title">Business Category</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{ route('sbussinessname.update', $accDetail->id) }}">
                            @csrf
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
                                    name="business_name" value="{{ $accDetail->business_name }}" required>
                            </div>
                            <div class="modal-footer py-1">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary     savebtn me-0">Update & Continue</button>
                            </div>
                        </form>
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

            <div class="modal fade" id="nameUpdateModal">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header">
                            <h4 class="modal-title ">Name</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <form method="post" action="{{ route('name.update') }}">
                            @csrf
                            <div class="modal-body">
                                <p>Please add your name to continue</p>

                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Name</p>
                                <input class="form-control" placeholder="Enter Name" type="text" name="name"
                                    value="{{ $accDetail->client_name }}" required>
                            </div>
                            <div class="modal-footer py-1" style="background:#f9f8f8;">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary savebtn">Update & Continue</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 my-auto">
                            <span class="settings-icon  text-primary border-primary"><i
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
            <div class="modal fade" id="bphone">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header " >
                            <h4 class="modal-title">Phone Number</h4>

                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{ route('sphone.update', $accDetail->id) }}">
                            @csrf
                            <div class="modal-body">
                                <p>Please add your phone number to continue</p>
                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Phone Number</p>
                                <input class="form-control" placeholder="Enter Name" type="text" name="phone"
                                    value="{{ $accDetail->mobile_no }}" maxlength="10" required>
                            </div>
                            <div class="modal-footer py-1" style="background:#f9f8f8;">
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button class="btn btn-primary savebtn me-0" type="sumbit"> Save Changes </button>
                                {{-- <a href="{{ route('name.update') }}" method="post" type="sumbit" class="btn btn-primary btn-sm">Continue</a> --}}
                            </div>
                        </form>
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
                                <p class="my-auto">{{ $accDetail->business_email }}</p>
                            </div>
                            {{-- <div class="my-auto"> <a href="#" data-bs-target="#emailupdateModal"
                                    data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div> --}}

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
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
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
                                <p class="my-auto">{{ $businesstypeNames->name }}</p>
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
            <div class="modal fade" id="btypeModal">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header">
                            <h4 class="modal-title">Business Type</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{ route('sbussinesstype.update', $accDetail->id) }}">
                            @csrf

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
                                <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary savebtn me-0">Update & Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                            <div class="my-auto"> <a href="#" onclick="openEditModel(this)"
                                    data-id='<?= $accDetail->id ?>' data-bs-target="#updateempmodal"
                                    data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    <form method="post" action="{{ route('saddress.update', $accDetail->id) }}">
                        @csrf
                        <div class="modal-body">
                            <p>Please add your phone number to continue</p>

                            <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>

                            <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Address Line</p>
                            <textarea class="form-control " id="" placeholder="Address Line 1" rows="3" name="address" maxlength="100"></textarea>


                            <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Country</p>
                            <input class="form-control" placeholder="Confirm Bank Account Number" name="country"
                                type="text" value="India" readonly>

                            <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">State</p>
                            {{-- <input class="form-control" placeholder="Confirm Bank Account Number" name="state"
                                type="text" value="{{ $accDetail->state }}" required readonly> --}}
                            <select onchange="print_city('state1', this.selectedIndex);" id="" name="state"
                                class=" sts1 form-control w-100 border rounded" required>
                                {{-- <option value="{{ $accDetail->city }}" {{$accDetail->city == ? 'selected':''}}>{{ $accDetail->city }}</option> --}}
                            </select>

                            <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">City</p>
                            <input class="form-control" placeholder="City Name" name="city" type="text"
                                value="{{ $accDetail->city }}" required>
                                {{-- <select id="" name="city" class="state1 form-control w-100 border rounded"
                                    required readonly></select>
                                <script language="javascript">
                                    print_state("sts1");
                                </script> --}}

                            <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Pin Code</p>
                            <input class="form-control" placeholder="Pin Code" id="" name="pincode" type="text"
                                value="" required>

                        </div>
                        <div class="modal-footer d-flex py-1">
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue</button>
                        </div>
                    </form>
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
                        <input class="form-control" placeholder="eg. 22XXXXXXXXA1Z5" type="text" required>
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
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
                        <input class="form-control" placeholder="Holder Name" type="text" required>

                        <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">Account Number</p>
                        <input class="form-control" placeholder="Bank Account Number" type="password" required>

                        <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">Confirm Account Number</p>
                        <input class="form-control" placeholder="Confirm Bank Account Number" type="text" required>

                        <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">IFSC Code</p>
                        <input class="form-control" placeholder="IFSC Code" type="text" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- LARGE MODAL -->
    <div class="modal fade " id="updateempmodal">
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
                <form method="post" action="{{ route('saddress.update', $accDetail->id) }}">
                    @csrf
                    <div class="modal-body">
                        <p>Please add your address to continue</p>
{{-- <input type="text" id="emialllllll"> --}}
                        <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Address Line</p>
                        <textarea class="form-control" id="upateAddressLine" placeholder="Address Line 1" rows="3" name="address" maxlength="100"></textarea>


                        <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Country</p>
                        <input class="form-control" placeholder="Confirm Bank Account Number" name="country"
                            type="text" value="India" readonly>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">State</p>
                        {{-- <input class="form-control" placeholder="Confirm Bank Account Number" name="state"
                            type="text" value="{{ $accDetail->state }}" required readonly> --}}
                        <label class="form-label mb-0 mt-2">State</label>
                        <select id="sts2" onchange="print_city('state2', selectedIndex);" name="state"
                            class="sts2 form-control w-100 border rounded" required></select>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">City</p>
                        {{-- <input class="form-control" placeholder="City Name" name="city" type="text"
                            value="{{ $accDetail->city }}" required> --}}
                        <select id="state24" name="city" class="state2 updatecity form-control w-100 border rounded"
                            required></select>
                        <script language="javascript">
                            print_state("sts2");
                        </script>

                        <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Pin Code</p>
                        <input class="form-control" placeholder="Pin Code" id="updatePinCode" name="pincode" id="" type="text"
                            value="" required>

                    </div>
                    <div class="modal-footer d-flex py-1">
                        <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                        <button class="btn btn-primary savebtn me-0" type="sumbit">Update & Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END LARGE MODAL -->

    {{-- Business Address detail --}}
    <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>

    <script>
        function openEditModel(context) {
            // $('.dropify').dropify();
            $("#updateempmodal").modal("show");

            // var id = $(context).data('id');
            // $('#setId').val(id);
            // console
            // let shift_name = $(context).data('shift_name');
            // let shift_ftype = $(context).data('shift_type');

            // console.log(id);
            $.ajax({
                url: "{{ url('admin/settings/account/businessdetail') }}",
                type: "GET",
                async: true,
                data: {
                    _token: '{{ csrf_token() }}',
                    // employee_id: id
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    $('#emialllllll').val(result.get.business_email);
                    $('#upateAddressLine').val(result.get.business_address);
                    console.log(result.get.business_address);
                    $('#updatePinCode').val(result.get.pin_code);
                    console.log("hiadisjf", result)
                    // console.log("dfasf",result.get.business_email);
                    // console.log("Edit modal" + result.get[0].profile_photo);
                    // console.log("businessemail"+result.get[0].business_email);

                    // $("input[name='update_gender']").filter("[value='" + result.get[0]
                    //     .emp_gender + "']").prop(
                    //     'checked', true);
                    // console.log("city: " + result.get[0].emp_city);
                    // Set the "State" dropdown value
                    $('#sts2').val(result.get.state);

                    // Set the "City" dropdown value
                    var dataat = $('#sts2').trigger('change');
                    // console.log("Dad: " + dataat.state2);
                    $('#state24').val(result.get.city);



                },
            });
        }

        // function openEditModel(context) {
        //     // $('.dropify').dropify();
        //     $("#updateempmodal").modal("show");

        //     // var id = $(context).data('id');
        //     // $('#setId').val(id);
        //     // console
        //     // let shift_name = $(context).data('shift_name');
        //     // let shift_ftype = $(context).data('shift_type');

        //     // console.log(id);
        //     $.ajax({
        //                         url: "{{ url('admin/settings/account/businessdetail') }}",

        //         type: "GET",
        //         async: true,
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             // employee_id: id
        //         },
        //         dataType: 'json',
        //         cache: true,
        //         success: function(result) {

        //             console.log("Edit modal" + result.get[0].profile_photo);
        //             // if (result.get[0].id) {
        //                 $("input[name='update_gender']").filter("[value='" + result.get[0]
        //                     .emp_gender + "']").prop(
        //                     'checked', true);
        //                 // console.log("city: " + result.get[0].emp_city);
        //                 // Set the "State" dropdown value
        //                 consol.log(result.get[0].state);
        //                 $('#sts2').val(result.get[0].state);

        //                 // Set the "City" dropdown value
        //                 var dataat = $('#sts2').trigger('change');
        //                 // console.log("Dad: " + dataat.state2);
        //                 $('#state24').val(result.get[0].emp_city);
        //                 // console.log("city" + result.get[0].emp_city);
        //                 // // sts2
        //                 // // var hii = print_city_update('state2', result.get[0].emp_state);
        //                 // // console.log("hii: "+hii);;
        //                 // $('#sts2').val(result.get[0].emp_state);
        //                 // // $('.state2').val(result.get[0].emp_city);
        //                 // // $('.updatecity').val(result.get[0].emp_city);
        //                 // // updatecity
        //                 // $('#state24').val(result.get[0].emp_city);
        //                 // setTimeout(function() {
        //                 //     $('#state24').val(result.get[0].emp_city);
        //                 // }, 500);
        //                 // $('#sts2,#state24').trigger('change');

        //                 // $('#edit_state').val(depart_id);
        //                 // $('#editName').val(desig_name);
        //                 // setTimeout(function() {
        //                 //     $('#edit_state').val(depart_id);
        //                 // }, 500);
        //                 // $('#editbranch-dd,#edit_state').trigger('change');



        //                 $('.update_name_sd').val(result.get[0].emp_name);
        //                 $('.update_mname_sddd').val(result.get[0].emp_mname);
        //                 $('.update_lname_sddd').val(result.get[0].emp_lname);
        //                 $('.update_cnumber_sddd').val(result.get[0].emp_mobile_number);
        //                 $('.update_email_sddd').val(result.get[0].emp_email);
        //                 $('.update_dob_sddd').val(result.get[0].emp_date_of_birth);
        //                 $('.update_country_sddd').val(result.get[0].emp_country);

        //                 $('.update_city_sddd').val(result.get[0].emp_city);
        //                 $('.update_pcode_sddd').val(result.get[0].emp_pin_code);
        //                 // $('.sts1').val(result.get[0].emp_state);
        //                 $('.update_address_sddd').val(result.get[0].emp_address);
        //                 $('.update_shifttype_sddd').val(result.get[0].emp_shift_type).change();
        //                 $('.update_attendance_method').val(result.get[0].emp_attendance_method).change();
        //                 $('.update_empid_sddd').val(result.get[0].id);
        //                 $('.update_branchname_sddd').val(result.get[0].branch_id);
        //                 $('.update_department_sddd').val(result.get[0].department_id);
        //                 $('.update_designationname_sddd').val(result.get[0].desig_name);
        //                 $('.update_doj_dd').val(result.get[0].emp_date_of_joining);
        //                 const imageUrl = `{{ asset('employee_profile/${result.get[0].profile_photo}') }}`;
        //                 $('.image_sdd').attr("data-default-file", imageUrl);
        //                 $('.image_sdd').dropify('destroy');
        //                 $('.image_sdd').dropify();
        //                 change(result.get[0].branch_id, result.get[0].department_id, result.get[0]
        //                     .designation_id);

        //             // } else {

        //             //     // console.log("Nhi ja raha hai");
        //             // }
        //         },
        //     });
        // }
    </script>
@endsection
