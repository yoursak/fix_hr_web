@extends('auth/admin/authlayout.master_simple')
@section('title', 'Business Create')
@section('css')

@endsection
@section('js')


@endsection
@section('content')


<div class="row d-flex justify-content-center">
    <div class="col-sm-12 col-md-8 col-sm-6">
        <div class="card">
            <form action="{{ route('businessVerify') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="display-6 card-title"><b>Business Details</b></div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div style="text-align: center;">
                                <img src="{{ asset('imgs/business.gif') }}" alt=""
                                    style="margin: 0 auto;height: 150px;width:150px;border-radius:50px;">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Business Category</label>
                                <select style="padding: 0px;" class="form-control  select2" name="businessCategory"
                                    data-placeholder="Select Business Category" required>
                                    <option label="Select Business Category"></option>
                                    @foreach ($businessCat as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Business Type</label>
                                <select class="form-control  select2" name="businessType"
                                    data-placeholder="Select Business Type" required>
                                    <option label="Select Business Type"></option>
                                    @foreach ($businessType as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input autocapitalize="true" type="text" name="name" class="form-control"
                                    placeholder="Enter Your Name" required>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Business Name</label>
                                <input type="text" autocapitalize name="bname" class="form-control"
                                    placeholder="Business Name" required>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <input type="email" name="bemail" class="form-control" placeholder="Email"
                                    value="{{Session()->get('firstEmail')}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="eg. XXXXXXXXX5"
                                    maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <select class="form-control select2" aria-label="Type" name="country" required>
                                    <option label="Select Country Type">Select Country Type</option>
                                    <option value="1">India</option>
                                    <option value="2">USA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select onchange="print_city('state1', this.selectedIndex);" id="sts1" name="state"
                                    name="stt" class="form-control  " required></select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">City/Distict</label>
                                <select id="state1" name="city" class="form-control " required></select>
                                <script language="javascript">
                                    print_state("sts1");
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                               
                                <div class="col-sm-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" name="pin" class="form-control" placeholder="Pin Code">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">GST Number</label>
                                        <input type="text" name="gst" class="form-control"
                                            placeholder="eg. 29GGGGG1314R9Z6" required>
                                    </div>
                                    <button class="btn btn-sm btn-success">Validate GST</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="row">
                                
                                {{-- <div class="col-sm-6 col-md-6"> --}}
                                    {{-- data-default-file="{{ asset('imgs/business.gif') }}" --}}
                                    {{-- <input type="file" name="image" class="dropify" data-height="100" data-width="400" />
                                </div> --}}
                                {{-- <div class="col-sm-6 col-md-6"> --}}
                                    <div class="form-group">
                                        <label class="form-label">Address</label>
                                        <textarea rows="6" name="address" class="form-control"
                                            placeholder="Enter Business Address"></textarea>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button href="#" type="submit" class="btn btn-primary">Save & Continue</button>
                    {{-- <a href="{{ url('/admin') }}" class="btn btn-outline-primary">Skip</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection