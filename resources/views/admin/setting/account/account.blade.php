@extends('admin.pagelayout.master')
{{-- @extends('admin.setting.setting')
--}}
<script src="{{ asset('assets/js/cities.js') }}"></script>
@section('title')
    Account
@endsection
@section('content')
    @php
        $root = new app\Helpers\Central_unit();
        $BType = $root->GetBusinessType();
        $Bcategory = $root->GetBusinessCategory();
        $categoryName = $root->GetBusinessCategoryName($accDetail->business_categories);
        $businesstypeNames = $root->GetBusinessTypeName($accDetail->business_type);
        $Bname = $root->GetBusinessCategoryName($accDetail->business_categories);
        $countryArray = $root->getCountry();
        $stateArray = $root->getState();
        $cityArray = $root->getCity();
        use Illuminate\Support\Str;
        $checkPermissionOrNot = 0;
    
    @endphp
    @if (in_array('Account Settings.View', $permissions) || in_array('Account Settings.All', $permissions))
        @if (in_array('Account Settings.update', $permissions) || in_array('Account Settings.All', $permissions))
            @php
                $checkPermissionOrNot = 1;
            @endphp
        @endif

        <div class=" p-0 my-3">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Account Settings</b></span></li>
            </ol>
        </div>
        <div class="">
            <p class="text-muted">Change Your Profile and Account Settings</p>
        </div>
        <div class="row row-sm">
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="nav-icon ion ion-images mx-1"></i></span>
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
                                <div class="my-auto"><a href="#" data-bs-target="#modaldemo4"
                                        data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Logo Upload --}}
                <div class="modal fade" id="bLogo" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header border-0">
                                <h4 class="modal-title">Business Logo</h4><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post" enctype="multipart/form-data"
                                action="{{ route('upload.logo', $accDetail->id) }}">
                                @csrf
                                <p class=" fs-13 px-4 mt-3 pb-3 border-bottom " style="color: rgb(110, 104, 88)">Please
                                    upload
                                    the logo of your business in png, jpg or jpeg formate, this logo will be visible in
                                    payment
                                    slip.</p>
                                <div class="modal-body">
                                    <h3 class="card-title">File Upload</h3>
                                    <input type="text" name="editlogoId" value="{{ $accDetail->id }}" hidden>
                                    <input type="file" name="image" class="dropify"
                                        data-default-file="{{ asset('business_logo/' . $accDetail->business_logo) }}"
                                        data-height="180" style="display: block; margin: 0 auto;"
                                        {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }} />
                                </div>
                                <div class="modal-footer py-1">
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    @if (in_array('Account Settings.Update', $permissions))
                                        <button type="submit" class="btn btn-primary savebtn me-0">Update</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Business Name --}}
                <div class="modal fade" id="modaldemo4" data-bs-backdrop="static">
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

                                        <label class="form-label mb-0 mt-2">Business Category*</label>
                                        <select class="form-control custom-select select2"
                                            data-placeholder="Select Department" name="select"
                                            {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>

                                            <option label="Select Employee" value="{{ $Bname->id }}">
                                                {{ $Bname->name }}
                                            </option>
                                            @foreach ($Bcategory as $bcategory)
                                                <option value="{{ $bcategory->id }}">{{ $bcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="form-label mb-0 mt-2">Business Name*</label>
                                    <input class="form-control" placeholder="Software Industry" type="text"
                                        name="business_name" value="{{ $accDetail->business_name }}" required
                                        {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                </div>
                                <div class="modal-footer py-1">
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    @if (in_array('Account Settings.Update', $permissions))
                                        <button type="submit" class="btn btn-primary savebtn me-0">Update</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{--  Manage Business --}}
                <div class="modal fade" id="baddDelete" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header border-0">
                                <h4 class="modal-title ms-2">Manage Business</h4><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg d-none" id="anbc">
                                    <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Business Name</p>
                                    <input class="form-control" placeholder="Enter business Name" type="text">
                                    <p class="my-auto" class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to
                                        <a href="#" class="text-primary">Terms & Conditions</a>
                                    </p>
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
                                @if (in_array('Account Settings.Update', $permissions))
                                    <a href="#" class="btn btn-outline-light btn-sm" id="anbbtn3">Cancel</a>
                                    <a href="#" class="btn btn-success btn-sm" id="anbbtn4">Continue</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6" data-bs-backdrop="static" data-bs-backdrop="static">
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
                                            class="fa fa-angle-double-right fs-20 my-auto mx-1 "></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  Name --}}
                {{-- @foreach ($branch as $item) --}}

                <div class="modal fade" id="nameUpdateModal" data-bs-backdrop="static">
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
                                    <p>Please Add Your Name To Continue</p>

                                    <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                    <label class="form-label mb-0 mt-2">Name*</label>
                                    <input class="form-control" placeholder="Enter Name" type="text" name="name"
                                        value="{{ $accDetail->client_name }}" required
                                        {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                </div>
                                <div class="modal-footer py-1" style="background:#f9f8f8;">
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    @if (in_array('Account Settings.Update', $permissions))
                                        <button type="submit" class="btn btn-primary savebtn">Update</button>
                                    @endif
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-6" >
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent  text-primary border-primary"><i
                                        class="nav-icon fa fa-phone mx-1"></i></span>
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
                <div class="modal fade" id="bphone" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header ">
                                <h4 class="modal-title">Phone Number</h4>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post" action="{{ route('sphone.update', $accDetail->id) }}">
                                @csrf
                                <div class="modal-body">
                                    <p>Please Add Your Phone Number To Continue</p>
                                    <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                    <label class="form-label mb-0 mt-2">Phone Number*</label>
                                    <input class="form-control" id="phoneInput" placeholder="Enter Phone Number" type="text"
                                        name="phone" value="{{ $accDetail->mobile_no }}" maxlength="10" required
                                        {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                    <span id="error-message" style="color: red;"></span>
                                </div>
                                <div class="modal-footer py-1" style="background:#f9f8f8;">
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    @if (in_array('Account Settings.Update', $permissions))
                                        <button class="btn btn-primary savebtn me-0" id="phoneNumberSubmitBtn"
                                            type="sumbit">
                                            Update</button>
                                    @endif
                                    {{-- <a href="{{ route('name.update') }}" method="post" type="sumbit" class="btn btn-primary btn-sm">Continue</a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <script>
                // Get the input element by its id
                var phoneInput = document.getElementById('phoneInput');
                var phoneNumSubmitBtn = document.getElementById('phoneNumberSubmitBtn');

                // Get the error message span element by its id
                var errorMessage = document.getElementById('error-message');

                // Add an event listener for input changes
                phoneInput.addEventListener('input', function() {
                    // Check if the input length is less than 10
                    if (phoneInput.value.length < 10) {
                        // Display an error message
                        errorMessage.textContent = 'Error: Phone number must be 10 digits**';
                        phoneNumSubmitBtn.disabled = true;
                    } else {
                        // Clear the error message if the input is valid
                        errorMessage.textContent = '';
                        phoneNumSubmitBtn.disabled = false;
                    }
                });
            </script>
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
                                <p>Please Add Your Email To Continue</p>
                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>
                                <p class="my-auto" class="mb-0 pb-0 text-dark fs-13 mt-1 ">Email</p>
                                <input class="form-control" placeholder="Enter Email" type="email" name="email"
                                    value="{{ $accDetail->business_email }}" readonly>
                            </div>
                            <div class="modal-footer py-1">
                                @if (in_array('Account Settings.Update', $permissions))
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    <button class="btn btn-primary savebtn me-0" type="sumbit">Update </button>
                                @endif
                                {{-- <a href="#" class="btn btn-primary btn-sm">Continue</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
            <div class="col-xl-6" data-bs-backdrop="static">
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
                <div class="modal fade" id="btypeModal" data-bs-backdrop="static">
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
                                        <label class="form-label mb-0 mt-2">Business Type*</label>
                                        <select class="form-control custom-select select2"
                                            data-placeholder="Select Department" name="select"
                                            {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
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
                                    @if (in_array('Account Settings.Update', $permissions))
                                        <button type="submit" class="btn btn-primary savebtn me-0">Update</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{--  Manage Business --}}

            </div>

            <div class="col-xl-6" data-bs-backdrop="static">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="nav-icon fa fa-map-signs"></i></span>
                            </div>
                            <div class="col-10 d-flex justify-content-between">
                                <div class="my-auto"><a href="#">
                                    </a>
                                    <h5 class="my-auto text-dark">Business Address&nbsp; <i style="color:1877f2;"
                                            class="fa fa-flag"></i></h5>
                                    <p class="my-auto">
                                        {{ Str::limit($accDetail->business_address, $limit = 70, $end = '...') }} </p>
                                </div>
                                <div class="my-auto"> <a href="#" onclick="openEditModel(this)"
                                        id="create_template_btn" data-id='<?= $accDetail->id ?>'
                                        data-country='<?= $accDetail->country ?>' data-state='<?= $accDetail->state ?>'
                                        data-city='<?= $accDetail->city ?>'
                                        data-business_email='<?= $accDetail->business_email ?>'
                                        data-pin_code='<?= $accDetail->pin_code ?>'
                                        data-business_address='<?= $accDetail->business_address ?>'
                                        data-bs-target="#updateempmodal" data-bs-toggle="modal"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bAddress">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content tx-size-sm">

                        <div class="modal-header">
                            <h4 class="modal-title">Business Address</h4><button aria-label="Close" class="btn-close"
                                data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{ route('saddress.update', $accDetail->id) }}">
                            @csrf
                            <div class="modal-body">
                                <p>Please Add Your Business Address Details</p>

                                <input type="text" name="editBranchId" value="{{ $accDetail->id }}" hidden>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Address Line </p>
                                <textarea class="form-control " id="" placeholder="Address Line 1" rows="3" name="address"
                                    maxlength="10000"></textarea>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Country</p>
                                <input class="form-control" placeholder="Confirm Bank Account Number" name="country"
                                    type="text" value="India" readonly>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">State</p>
                                <select onchange="print_city('state1', this.selectedIndex);" id=""
                                    name="state" class=" sts1 form-control w-100 border rounded" required>
                                </select>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">City</p>
                                <input class="form-control" placeholder="City Name" name="city" type="text"
                                    value="{{ $accDetail->city }}" required>

                                <p class="mb-0 pb-0 text-dark fs-13 mt-2 ">Zip Code</p>
                                <input class="form-control" placeholder="Zip Code" id="areaPinCodeInput" name="pincode"  oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);"
                                    type="text" value="" maxlength="6" required>
                                <span id="pinCodeErrorMessage" style="color: red;"></span>

                            </div>
                            <div class="modal-footer d-flex py-1">
                                @if (in_array('Account Settings.Update', $permissions))
                                    <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                                    <button class="btn btn-primary savebtn me-0" id="settingAddressSubmitBtn"
                                        type="sumbit">Update</button>
                                @endif
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
                                        <h5 class="my-auto text-dark">GSTIN</h5>
                                    </a>
                                    <p class="my-auto">{{ $accDetail->gstnumber }}</p>
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
                        @if (in_array('Account Settings.Update', $permissions))
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            <button class="btn btn-primary savebtn">Continue</button>
                        @endif
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
                            <p class="mb-0 pb-0 fs-13 ms-2 " style="color: rgb(110, 104, 88)">Provide Business Acount
                                Detail
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
                            <input class="form-control" placeholder="Confirm Bank Account Number" type="text"
                                required>

                            <p class="mb-0 pb-0 text-dark fs-12 mt-5 ">IFSC Code</p>
                            <input class="form-control" placeholder="IFSC Code" type="text" required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        @if (in_array('Account Settings.Update', $permissions))
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            <button class="btn btn-primary savebtn">Continue</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- LARGE MODAL -->
        <div class="modal fade " id="updateempmodal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-header">
                        <h4 class="modal-title">Business Address</h4><button aria-label="Close" type="reset"
                            class="btn-close" onclick="businessaddress()" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="{{ route('saddress.update') }}">
                        @csrf
                        <div class="modal-body" id="kjdfsjkdfklsd">
                            <p>Please Add Your Address To Continue</p>
                            <input type="text" id="loadupdateid" name="editBranchId" hidden>
                            <label class="form-label mb-0 mt-2">Country*</label>

                            <select name="country" id="getCountryId" onchange="getState(this.value)"class=" form-control custom-select  w-100 border rounded" required{{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                {{-- <option label="Select Employee" value="{{ $accDetail->country }}">
                                {{ $countryArray->where('id', $accDetail->country)->first()->name }}</option> --}}
                                <option value="">Select Country Name</option>

                                @foreach ($countryArray as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $country->id == $accDetail->country ? 'selected' : '' }}> {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label mb-0 mt-2">State*</label>
                            <select name="state" id="getStateId" onchange="getCity(this.value)"
                                class="custom-select  form-control w-100 border rounded" required
                                {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                <option value="">Select State</option>
                                {{-- @foreach ($statefind as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == $accDetail->state ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach --}}
                                @foreach ($statefind as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $accDetail->state ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach
                                {{-- <option label="Select Employee" value="{{ $accDetail->state }}">
                                {{ $stateArray->where('id', $accDetail->state)->first()->name }} </option> --}}
                            </select>
                            <label class="form-label mb-0 mt-2">City*</label>
                            <select id="getCityId" name="city"
                                class="custom-select  form-control w-100 border rounded" required
                                {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>
                                <option value="">Select City</option>
                                @foreach ($citiesfind as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $accDetail->city ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label mb-0 mt-2">Zip Code*</label>
                            <input class="form-control" placeholder="Zip Code" id="updatePinCode" name="pincode"
                                maxlength="6" type="text" value="" required  oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);"
                                {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}>

                            <label class="form-label mb-0 mt-2">Address Line* &nbsp; <i style="color:1877f2;"
                                    class="fa fa-flag"></i></label>
                            <textarea class="form-control" id="upateAddressLine" placeholder="Address Line 1" rows="3" name="address"
                                maxlength="200" {{ $checkPermissionOrNot == 1 ? '' : 'disabled' }}></textarea>
                        </div>
                        <div class="modal-footer d-flex py-1">
                            <a class="btn btn-danger cancel" data-bs-dismiss="modal">Cancel</a>
                            @if (in_array('Account Settings.Update', $permissions))
                                <button class="btn btn-primary savebtn me-0" type="sumbit">Update</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END LARGE MODAL -->

        {{-- Business Address detail --}}
        <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
        <script src="{{ asset('assets/js/filupload.js') }}"></script>
        <script>
            var CityID;
            var StateID;

            function openEditModel(context) {
                $.ajax({
                    url: "{{ url('admin/settings/account/businessdetail') }}",
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(result) {
                        CityID = result.get.city;
                        StateID = result.get.state;
                        $('#loadupdateid').val(result.get.id);
                        // $('#emialllllll').val(result.get.business_email);
                        $('#upateAddressLine').val(result.get.business_address);
                        $('#updatePinCode').val(result.get.pin_code);
                        $('#getCountryId').val(result.get.country);
                        // getState(result.get.country);
                        // getCity(result.get.state);
                        // $('#getStateId').val(result.get.state);
                        // $('#getCityId').val(result.get.city);
                    },
                });
            }

            function getState(countryValue) {
                $stateId = $('#getStateId');
                $.ajax({
                    url: "{{ route('getCityStateCountry') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        state: null,
                        country: countryValue
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        var state = result.states;

                        $stateId.html('');

                        var defaultOption = $('<option>').val('').text('Select State').attr('selected', true);
                        $stateId.append(defaultOption);
                        // $stateId.append(
                        //     '<option label="Select Employee" value="{{ $accDetail->state }}">{{ $stateArray->where('id', $accDetail->state)->first()->name }}</option>'
                        // );

                        state.forEach(function(element) {
                            var option = $('<option>').val(element.id).text(element.name);
                            $stateId.append(option);
                        });
                        // Set the selected state after populating options
                        // $stateId.val(stateValue);
                    }
                });
            }

            function getCity(stateValue) {
                // console.log('Hello');
                $cityId = $('#getCityId');
                $.ajax({
                    url: "{{ route('getCityStateCountry') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        state: stateValue
                    },
                    dataType: 'json',
                    cache: true,
                    success: function(result) {
                        var city = result.city;
                        var defaultOptioncity = $('<option>').val('').text('Select City').attr('selected', true);
                        $cityId.html('');
                        $cityId.append(defaultOptioncity);

                        city.forEach(function(element) {
                            var option = $('<option>').val(element.id).text(element.name);
                            $cityId.append(option);
                        });

                        // console.log('city:'.city);
                        // $('#getStateId').val(stateValue);
                        // $('#getCityId').val(CityID);
                    }
                });
            }
        </script>
    @endif
@endsection
